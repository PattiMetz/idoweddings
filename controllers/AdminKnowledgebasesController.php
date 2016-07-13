<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\validators\FileValidator;
use yii\helpers\Html;
use app\models\Knowledgebase;
use app\models\KnowledgebaseEntry;
use app\models\KnowledgebaseEntryReorderForm;
use app\models\KnowledgebaseEntryFile;

class AdminKnowledgebasesController extends Controller {

	public $layout = 'admin';

	public function beforeAction($action) {

		$this->view->params['section_title'] = 'Knowledge Bases';

		return parent::beforeAction($action);

	}

	public function behaviors() {

		return [
			'access' => [
				'class' => AccessControl::className(),
//				'ruleConfig' => [
//					'class' => AccessRule::className(),
//				],
				'rules' => [
					[
						'actions' => ['index', 'update', 'delete', 'entries', 'categories-update', 'categories-delete', 'categories-tree', 'articles-update', 'articles-delete', 'entries-reorder', 'entries-files-upload', 'entries-files-download'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];

	}

	public function actionIndex() {

		$this->view->title = 'Overview';

		$dataProvider = new ActiveDataProvider([
			'query' => Knowledgebase::find(),
			'sort' => [
				'defaultOrder' => ['name' => SORT_ASC],
				'attributes' => ['name']
			],
			'pagination' => [
				'defaultPageSize' => 6,
				'pageSize' => 6
			]
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider
		]);

	}

	public function actionUpdate($id = 0) {

		$alert = '';

		if ($id) {

			Yii::$app->db->createCommand('LOCK TABLES {{%knowledgebase}} WRITE')->execute();

			$model = Knowledgebase::findOne($id);

			if (!$model) {

				$alert = 'Knowledge base not found';

			}

		} else {

			$model = new Knowledgebase;

		}

		if ($model->load(Yii::$app->request->post())) {

			$errors = ActiveForm::validate($model);

			if (!count($errors)) {

				if (!$model->save(false)) {

					$alert = 'Knowledge base not saved';

				}

			}

			Yii::$app->db->createCommand('UNLOCK TABLES')->execute();

			$pjax_reload = '#main';

			Yii::$app->response->format = Response::FORMAT_JSON;

			return compact(
				'errors',
				'alert',
				'pjax_reload'
			);

		}

		Yii::$app->db->createCommand('UNLOCK TABLES')->execute();

		return $this->renderAjax('update', [
			'model' => $model,
			'alert' => $alert
		]);

	}

	function actionDelete($id) {

		$alert = '';

		Yii::$app->db->createCommand('LOCK TABLES {{%knowledgebase}} WRITE, {{%knowledgebase_entry}} WRITE, {{%knowledgebase_entry_file}} WRITE')
			->execute();

		$model = Knowledgebase::findOne($id);

		if (!$model) {

			$alert = 'Knowledge base not found.';

		}

		if (Yii::$app->request->isPost) {

			$errors = [];

			do {

				if (!$model) {

					break;

				}

				$transaction = Yii::$app->db->beginTransaction();

				if (!$model->delete()) {

					$alert = 'Knowledge base not deleted';

					$transaction = rollback();

					break;

				}


				// Get all entries IDs

				try {

					$entry_ids = KnowledgebaseEntry::find()
						->where(['knowledgebase_id' => $model->id])
						->select('id')
						->column();

				} catch (yii\db\Exception $ex) {

					$alert = 'Failed to get entries';

					$transaction->rollback();

					break;

				}


				if (count($entry_ids)) {

					$s_ids = join(', ', $entry_ids);


					// Unlink all files

					try {

						$result = Yii::$app->db->createCommand()->update(
							'knowledgebase_entry_file', ['knowledgebase_entry_id' => 0], "knowledgebase_entry_id IN ($s_ids)"
						)->execute();

					} catch (yii\db\Exception $ex) {

						$alert = 'Failed to unlink the files';

						$transaction->rollback();

						break;

					}


					// Delete all entries

					try {

						$result = Yii::$app->db->createCommand()->delete(
							'knowledgebase_entry', "id IN ($s_ids)"
						)->execute();

					} catch (yii\db\Exception $ex) {

						$alert = 'Failed to delete entries';

						$transaction->rollback();

						break;

					}

				}


				$transaction->commit();

				break;

			} while(0);

			Yii::$app->db->createCommand('UNLOCK TABLES')->execute();

			$pjax_reload = '#main';

			Yii::$app->response->format = Response::FORMAT_JSON;

			return compact(
				'errors',
				'alert',
				'pjax_reload'
			);

		}

		Yii::$app->db->createCommand('UNLOCK TABLES')->execute();

		return $this->renderAjax('delete', [
			'model' => $model,
			'alert' => $alert
		]);

	}

	function actionEntries($knowledgebase_id, $category_id = 0) {

		// Default page title
		$this->view->title = 'Entries';

		// Alert message
		$alert = '';

		// Data provider
		$dataProvider = false;

		// Current path
		$current_path = [];

		// Categories data
		$categories = array();

		// Get all knowledgebases for SELECT options
		$knowledgebases = ArrayHelper::map(Knowledgebase::find()->all(), 'id', 'name');

		do {

			// Sanitize knowledgebase ID
			$knowledgebase_id = intval($knowledgebase_id);


			// Knowledgebase not found

			if (!isset($knowledgebases[$knowledgebase_id])) {

				$knowledgebase_id = 0;

				$alert = 'Knowledge base not found';

				break;

			}


			// Set page title
			$this->view->title = $knowledgebases[$knowledgebase_id];

			// Sanitize category ID
			$category_id = intval($category_id);


			if ($category_id) {


				// Get current category

				$current_category = KnowledgebaseEntry::find()->where([
					'knowledgebase_id' => $knowledgebase_id,
					'id' => $category_id,
					'is_category' => 1
				])->asArray()->one();


				// Category not found

				if (!$current_category) {

					$alert = 'Category not found';

					break;

				}


				// Cache category data
				$categories[$category_id] = $current_category;


				// Get current path
				$current_path = array_filter(explode('|', $current_category['tree_path']));


				// Get parent categories

				$parent_categories = KnowledgebaseEntry::find()->where([
					'id' => $current_path,
					'is_category' => 1
				])->asArray()->all();


				// Cache categories data

				foreach ($parent_categories as $parent_category) {

					$categories[$parent_category['id']] = $parent_category;

				}


				// Append category_id itself to the current path
				$current_path[] = $category_id;

			}

			$filter = [
				'knowledgebase_id' => $knowledgebase_id,
				'category_id' => $category_id
			];

			$dataProvider = new ActiveDataProvider([
				'query' => KnowledgebaseEntry::find()->where($filter)->indexBy('id'), // entries
				'sort' => [
					'defaultOrder' => ['order' => SORT_ASC],
					'attributes' => [
						'order' => [
							'asc' => [
								'is_category' => SORT_DESC,
								'order' => SORT_ASC
							],
							'desc' => [
								'is_category' => SORT_DESC,
								'order' => SORT_DESC
							]
						],
						'title' => [
							'asc' => [
								'is_category' => SORT_DESC,
								'title' => SORT_ASC
							],
							'desc' => [
								'is_category' => SORT_DESC,
								'title' => SORT_DESC
							]
						]
					]
				],
				'pagination' => [
					'defaultPageSize' => 3,
					'pageSize' => 3
				]
			]);

			break;

		} while(0);

		$this->view->params['js'] = $this->_entries_js();

		return $this->render('entries', [
			'alert' => $alert,
			'dataProvider' => $dataProvider,
			'current_knowledgebase_id' => $knowledgebase_id,
			'current_category_id' => $category_id,
			'knowledgebases' => $knowledgebases, // SELECT options
			'current_path' => $current_path,
			'categories' => $categories // cached data
		]);

	}

	public function actionCategoriesUpdate($id = 0) {

		$this->view->title = ($id) ? 'Edit Category' : 'Add Category';

		$alert = '';

		Yii::$app->db->createCommand('LOCK TABLES {{%knowledgebase}} WRITE, {{%knowledgebase_entry}} WRITE')->execute();

		// Get all knowledgebases for SELECT options
		$knowledgebases = ArrayHelper::map(Knowledgebase::find()->all(), 'id', 'name');

		do {

			if ($id) {

				$model = KnowledgebaseEntry::find()->where([
					'id' => $id,
					'is_category' => 1
				])->one();

				if (!$model) {

					$alert = 'Category not found';

					break;

				}

				$model->_old_knowledgebase_id = $model->knowledgebase_id;

				$model->_old_category_id = $model->category_id;

				$model->_old_tree_path = $model->tree_path;

			} else {

				$model = new KnowledgebaseEntry;

				$knowledgebase_id = Yii::$app->request->get('knowledgebase_id');

				if (isset($knowledgebase_id)) {

					$model->knowledgebase_id = intval($knowledgebase_id);

				} else {

					$model->knowledgebase_id = 0;

				}

				$category_id = Yii::$app->request->get('category_id');

				if (isset($category_id)) {

					$model->category_id = intval($category_id);

				} else {

					$model->category_id = 0;

				}

				$model->is_category = 1;

				$model->status = '';

				$model->_old_knowledgebase_id = 0;

				$model->_old_category_id = 0;

				$model->_old_tree_path = '';

			}

			$model->knowledgebases = $knowledgebases;

			if (Yii::$app->request->isGet) {

				if ($model->knowledgebase_id && !isset($model->knowledgebases[$model->knowledgebase_id])) {

					$model->knowledgebase_id = 0;

				}

				if ($model->knowledgebase_id) {


					// Get categories tree

					$categories_tree_info = $this->_get_categories_tree($model->knowledgebase_id, $model->category_id, $model->id);

					extract($categories_tree_info, EXTR_PREFIX_ALL, 'categories');

					$model->categories_tree_json = json_encode($categories_tree);


					// Skip category_id if there is no such ID in the tree

					if ($model->category_id && !in_array($model->category_id, $categories_plain_ids)) {

						$model->category_id = 0;

					}


				}

			}

			break;

		} while(0);

		if (Yii::$app->request->isPost) {

			do {

				if (!$model) {

					break;

				}

				$post = Yii::$app->request->post();

				$model->load($post);

				$errors = ActiveForm::validate($model);

				if (count($errors)) {

					break;

				}

				$transaction = Yii::$app->db->beginTransaction();

				if (!$model->save(false)) {

					$alert = 'Category not saved';

					$transaction->rollback();

					break;

				}


				if ($id && ($model->knowledgebase_id != $model->_old_knowledgebase_id || $model->category_id != $model->_old_category_id)) {


					// Get all children IDs

					try {

						$tree_path = (strlen($model->_old_tree_path)) ? $model->_old_tree_path . '|' . $model->id : $model->id;

						$child_ids = KnowledgebaseEntry::find()
							->where(['tree_path' => $tree_path])
							->orWhere(['like', 'tree_path', $tree_path . '|%', false])
							->select('id')
							->column();

					} catch (yii\db\Exception $ex) {

						$alert = 'Failed to get entries';

						$transaction->rollback();

						break;

					}


					if (count($child_ids)) {

						$s_ids = join(', ', $child_ids);

						$columns = [];

						$values = [];

						if ($model->knowledgebase_id != $model->_old_knowledgebase_id) {

							$columns['knowledgebase_id'] = 'knowledgebase_id = :knowledgebase_id';

							$values[':knowledgebase_id'] = $model->knowledgebase_id;

						}

						if ($model->category_id != $model->_old_category_id) {

							$pos = (strlen($model->_old_tree_path)) ? strlen($model->_old_tree_path) + 2 : 1;

							$columns['tree_path'] = 'tree_path = CONCAT(:tree_path, SUBSTR(tree_path, ' . $pos . '))';

							$values[':tree_path'] = strlen($model->tree_path) ? $model->tree_path . '|' : '';

						}


						// Move all children

						try {

							$columns = join(', ', $columns);

							$command = Yii::$app->db->createCommand(
								'UPDATE {{%knowledgebase_entry}} SET ' . $columns . ' WHERE id IN (' . $s_ids . ')'
							);

							foreach ($values as $name => $value) {

								$command->bindValue($name, $value);

							}

							$command->execute();

						} catch (yii\db\Exception $ex) {

							$alert = 'Failed to move entries';

							$transaction->rollback();

							break;

						}


					}


				}


				// Cache categories counts

				$category_ids = [];

				if ($model->_old_category_id) {

					$category_ids[] = $model->_old_category_id;

				}

				if ($model->category_id && $model->category_id != $model->_old_category_id) {

					$category_ids[] = $model->category_id;

				}

				foreach ($category_ids as $category_id) {

					try {

						$this->_cacheCategoryCounts($category_id);

					} catch (yii\db\Exception $ex) {

						$alert = 'Failed to cache category counts';

						$transaction->rollback();

						break(2);

					}

				}


				// Cache knowledge base counts

				$knowledgebase_ids = [];

				if ($model->_old_knowledgebase_id) {

					$knowledgebase_ids[] = $model->_old_knowledgebase_id;

				}

				if ($model->knowledgebase_id != $model->_old_knowledgebase_id) {

					$knowledgebase_ids[] = $model->knowledgebase_id;

				}

				foreach ($knowledgebase_ids as $knowledgebase_id) {

					try {

						$this->_cacheKnowledgebaseCounts($knowledgebase_id);

					} catch (yii\db\Exception $ex) {

						$alert = 'Failed to cache knowledge base counts';

						$transaction->rollback();

						break(2);

					}

				}


				$transaction->commit();

				break;

			} while(0);

			Yii::$app->db->createCommand('UNLOCK TABLES')->execute();

			$pjax_reload = '#main';

			Yii::$app->response->format = Response::FORMAT_JSON;

			return compact(
				'errors',
				'alert',
				'pjax_reload'
			);

		}

		Yii::$app->db->createCommand('UNLOCK TABLES')->execute();

		return $this->renderAjax('categories-update', [
			'model' => $model,
			'alert' => $alert
		]);

	}

	function actionCategoriesDelete($id) {

		$alert = '';

		Yii::$app->db->createCommand('LOCK TABLES {{%knowledgebase}} WRITE, {{%knowledgebase_entry}} WRITE, {{%knowledgebase_entry_file}} WRITE')
			->execute();

		$model = KnowledgebaseEntry::find()->where([
			'id' => $id,
			'is_category' => 1
		])->one();

		if (!$model) {

			$alert = 'Category not found';

		}

		if (Yii::$app->request->isPost) {

			do {

				if (!$model) {

					break;

				}

				$errors = [];

				$transaction = Yii::$app->db->beginTransaction();

				if (!$model->delete()) {

					$alert = 'Category not deleted';

					$transaction->rollback();

					break;

				}


				// Get all children IDs

				try {

					$tree_path = (strlen($model->tree_path)) ? $model->tree_path . '|' . $model->id : $model->id;

					$child_ids = KnowledgebaseEntry::find()
						->where(['tree_path' => $tree_path])
						->orWhere(['like', 'tree_path', $tree_path . '|%', false])
						->select('id')
						->column();

				} catch (yii\db\Exception $ex) {

					$alert = 'Failed to get entries';

					$transaction->rollback();

					break;

				}


				if (count($child_ids)) {

					$s_ids = join(', ', $child_ids);


					// Unlink all files

					try {

						Yii::$app->db->createCommand()->update(
							'knowledgebase_entry_file', ['knowledgebase_entry_id' => 0], "knowledgebase_entry_id IN ($s_ids)"
						)->execute();

					} catch (yii\db\Exception $ex) {

						$alert = 'Failed to unlink the files';

						$transaction->rollback();

						break;

					}


					// Delete all children

					try {

						Yii::$app->db->createCommand()->delete(
							'knowledgebase_entry', "id IN ($s_ids)"
						)->execute();

					} catch (yii\db\Exception $ex) {

						$alert = 'Failed to delete entries';

						$transaction->rollback();

						break;

					}

				}


				// Cache category counts

				if ($model->category_id) {

					try {

						$this->_cacheCategoryCounts($model->category_id);

					} catch (yii\db\Exception $ex) {

						$alert = 'Failed to cache category counts';

						$transaction->rollback();

						break;

					}

				}


				// Cache knowledge base counts

				try {

					$this->_cacheKnowledgebaseCounts($model->knowledgebase_id);

				} catch (yii\db\Exception $ex) {

					$alert = 'Failed to cache knowledge base counts';

					$transaction->rollback();

					break;

				}


				$transaction->commit();

				break;

			} while(0);

			Yii::$app->db->createCommand('UNLOCK TABLES')->execute();

			$pjax_reload = '#main';

			Yii::$app->response->format = Response::FORMAT_JSON;

			return compact(
				'errors',
				'alert',
				'pjax_reload'
			);

		}

		Yii::$app->db->createCommand('UNLOCK TABLES')->execute();

		return $this->renderAjax('categories-delete', [
			'model' => $model,
			'alert' => $alert
		]);

	}

	function actionCategoriesTree($knowledgebase_id) {

		// Check if knowledgebase exists
		$exists = Knowledgebase::find()->where(['id' => $knowledgebase_id])->exists();

		if ($exists) {

			// Get categories tree

			$categories_tree_info = $this->_get_categories_tree($knowledgebase_id);

			extract($categories_tree_info, EXTR_PREFIX_ALL, 'categories');

		} else {

			$categories_tree = [];

		}

		Yii::$app->response->format = Response::FORMAT_JSON;

		return $categories_tree;

	}

	public function actionArticlesUpdate($id = 0) {

		$this->view->title = ($id) ? 'Edit Article' : 'Add Article';

		$alert = '';

		Yii::$app->db->createCommand('LOCK TABLES {{%knowledgebase}} WRITE, {{%knowledgebase_entry}} WRITE, {{%knowledgebase_entry_file}} WRITE')
			->execute();

		// Get all knowledgebases for SELECT options
		$knowledgebases = ArrayHelper::map(Knowledgebase::find()->all(), 'id', 'name');

		do {

			if ($id) {

				$model = KnowledgebaseEntry::find()->where([
					'id' => $id,
					'is_category' => 0
				])->one();

				if (!$model) {

					$alert = 'Article not found';

					break;

				}

				$files = KnowledgebaseEntryFile::find()->where([
					'knowledgebase_entry_id' => $model->id
				])->indexBy('id')->all();

				$model->files = $files;

				$model->file_ids = array_keys($model->files);

				$model->_old_knowledgebase_id = $model->knowledgebase_id;

				$model->_old_category_id = $model->category_id;

			} else {

				$model = new KnowledgebaseEntry;

				$knowledgebase_id = Yii::$app->request->get('knowledgebase_id');

				if (isset($knowledgebase_id)) {

					$model->knowledgebase_id = intval($knowledgebase_id);

				} else {

					$model->knowledgebase_id = 0;

				}

				$category_id = Yii::$app->request->get('category_id');

				if (isset($category_id)) {

					$model->category_id = intval($category_id);

				} else {

					$model->category_id = 0;

				}

				$model->is_category = 0;

				$model->status = 'draft';

				$model->files = [];

				$model->file_ids = [];

				$model->_old_knowledgebase_id = 0;

				$model->_old_category_id = 0;

			}

			$model->statuses = [
				'published' => 'Published',
				'draft' => 'Draft'
			];

			$model->knowledgebases = $knowledgebases;

			if (Yii::$app->request->isGet) {

				if ($model->knowledgebase_id && !isset($model->knowledgebases[$model->knowledgebase_id])) {

					$model->knowledgebase_id = 0;

				}

				if ($model->knowledgebase_id) {


					// Get categories tree

					$categories_tree_info = $this->_get_categories_tree($model->knowledgebase_id, $model->category_id);

					extract($categories_tree_info, EXTR_PREFIX_ALL, 'categories');

					$model->categories_tree_json = json_encode($categories_tree);


					// Skip category_id if there is no such ID in the tree

					if ($model->category_id && !in_array($model->category_id, $categories_plain_ids)) {

						$model->category_id = 0;

					}


				}

			}

			break;

		} while(0);

		if (Yii::$app->request->isPost) {

			do {

				if (!$model) {

					break;

				}

				$post = Yii::$app->request->post();

				$model->load($post);

				$file_ids = [];

				if (isset($post['file_ids']) && is_array($post['file_ids'])) {

					foreach ($post['file_ids'] as $file_id) {

						$file_ids[] = $file_id;

					}

				}

				$deleted_ids = array_diff($model->file_ids, $file_ids);

				$new_ids = array_diff($file_ids, $model->file_ids);

				$files = KnowledgebaseEntryFile::find()->where([
					'id' => $new_ids,
					'knowledgebase_entry_id' => 0
				])->indexBy('id')->all();

				$new_ids = array_intersect($new_ids, array_keys($files));

				$errors = ActiveForm::validate($model);

				if (count($errors)) {

					break;

				}

				$transaction = Yii::$app->db->beginTransaction();

				if (!$model->save(false)) {

					$alert = 'Article not saved';

					$transaction->rollBack();

					break;

				}


				// Unlink the files

				if (count($deleted_ids)) {

					$s_ids = join(', ', $deleted_ids);

					try {

						Yii::$app->db->createCommand()->update(
							'knowledgebase_entry_file', ['knowledgebase_entry_id' => 0], "id IN ($s_ids)"
						)->execute();

					} catch (yii\db\Exception $ex) {

						$alert = 'Failed to unlink the files';

						$transaction->rollback();

						break;

					}

				}


				// Link the files

				if (count($new_ids)) {

					$s_ids = join(', ', $new_ids);

					try {

						Yii::$app->db->createCommand()->update(
							'knowledgebase_entry_file', ['knowledgebase_entry_id' => $model->id], "id IN ($s_ids)"
						)->execute();

					} catch (yii\db\Exception $ex) {

						$alert = 'Failed to link the files';

						$transaction->rollback();

						break;

					}

				}


				// Cache files info

				try {

					$model->cacheFilesInfo();

				} catch (yii\db\Exception $ex) {

					$alert = 'Failed to cache files information';

					$transaction->rollback();

					break;

				}


				// Cache categories counts

				$category_ids = [];

				if ($model->_old_category_id) {

					$category_ids[] = $model->_old_category_id;

				}

				if ($model->category_id && $model->category_id != $model->_old_category_id) {

					$category_ids[] = $model->category_id;

				}

				foreach ($category_ids as $category_id) {

					try {

						$this->_cacheCategoryCounts($category_id);

					} catch (yii\db\Exception $ex) {

						$alert = 'Failed to cache category counts';

						$transaction->rollback();

						break(2);

					}

				}


				// Cache knowledge base counts

				$knowledgebase_ids = [];

				if ($model->_old_knowledgebase_id) {

					$knowledgebase_ids[] = $model->_old_knowledgebase_id;

				}

				if ($model->knowledgebase_id != $model->_old_knowledgebase_id) {

					$knowledgebase_ids[] = $model->knowledgebase_id;

				}

				foreach ($knowledgebase_ids as $knowledgebase_id) {

					try {

						$this->_cacheKnowledgebaseCounts($knowledgebase_id);

					} catch (yii\db\Exception $ex) {

						$alert = 'Failed to cache knowledge base counts';

						$transaction->rollback();

						break(2);

					}

				}


				$transaction->commit();

				break;

			} while(0);

			Yii::$app->db->createCommand('UNLOCK TABLES')->execute();

			$pjax_reload = '#main';

			Yii::$app->response->format = Response::FORMAT_JSON;

			return compact(
				'errors',
				'alert',
				'pjax_reload'
			);

		}

		Yii::$app->db->createCommand('UNLOCK TABLES')->execute();

		return $this->renderAjax('articles-update', [
			'model' => $model,
			'alert' => $alert
		]);

	}

	function actionArticlesDelete($id) {

		$this->view->title = 'Delete Article';

		$alert = '';

		Yii::$app->db->createCommand('LOCK TABLES {{%knowledgebase}} WRITE, {{%knowledgebase_entry}} WRITE, {{%knowledgebase_entry_file}} WRITE')
			->execute();

		$model = KnowledgebaseEntry::find()->where([
			'id' => $id,
			'is_category' => 0
		])->one();

		if (!$model) {

			$alert = 'Article not found';

		}

		if (Yii::$app->request->isPost) {

			do {

				if (!$model) {

					break;

				}

				$transaction = Yii::$app->db->beginTransaction();

				if (!$model->delete()) {

					$alert = 'Article not deleted';

					$transaction->rollBack();

					break;

				} else {


					// Unlink all files

					try {

						Yii::$app->db->createCommand()->update(
							'knowledgebase_entry_file', ['knowledgebase_entry_id' => 0], 'knowledgebase_entry_id = :id'
						)->bindValue(':id', $model->id)->execute();

					} catch (yii\db\Exception $ex) {

						$alert = 'Failed to unlink the files';

						$transaction->rollback();

						break;

					}


					// Cache category counts

					if ($model->category_id) {

						try {

							$this->_cacheCategoryCounts($model->category_id);

						} catch (yii\db\Exception $ex) {

							$alert = 'Failed to cache category counts';

							$transaction->rollback();

							break;

						}

					}


					// Cache knowledge base counts

					try {

						$this->_cacheKnowledgebaseCounts($model->knowledgebase_id);

					} catch (yii\db\Exception $ex) {

						$alert = 'Failed to cache knowledge base counts';

						$transaction->rollback();

						break;

					}


				}

				$transaction->commit();

				break;

			} while(0);

			Yii::$app->db->createCommand('UNLOCK TABLES')->execute();

			$pjax_reload = '#main';

			Yii::$app->response->format = Response::FORMAT_JSON;

			return compact(
				'errors',
				'alert',
				'pjax_reload'
			);

		}

		Yii::$app->db->createCommand('UNLOCK TABLES')->execute();

		return $this->renderAjax('articles-delete', [
			'model' => $model,
			'alert' => $alert
		]);

	}

	function actionEntriesReorder($id) {

		$this->view->title = 'Change Order';

		$alert = '';

		Yii::$app->db->createCommand('LOCK TABLES {{%knowledgebase_entry}} WRITE')->execute();

		do {

			$entry = KnowledgebaseEntry::findOne($id);

			if (!$entry) {

				$alert = 'Entry not found';

				break;

			}

			$model = new KnowledgebaseEntryReorderForm();

			$model->move_types = [
				'top'		=>	'Move to the top',
				'up'		=>	'Up',
				'position'	=>	'Move to the position',
				'down'		=>	'Down',
				'bottom'	=>	'Move to the end'
			];

			$model->move_types_visible = $model->move_types;

			unset(
				$model->move_types_visible['up'],
				$model->move_types_visible['down']
			);

			$model->move_type = 'top';

			$model->position = 0;

			break;

		} while(0);

		if (Yii::$app->request->isPost) {

			do {

				if (!$entry) {

					break;

				}

				$model->load(Yii::$app->request->post());

				$errors = ActiveForm::validate($model);

				if (count($errors)) {

					break;

				}

				$transaction = Yii::$app->db->beginTransaction();


				// Change entry order

				try {

					$entry->changeOrder($model->move_type, $model->position);

				} catch (yii\db\Exception $ex) {

					$alert = 'Failed to change entry order';

					$transaction->rollback();

					break;

				}


				// Renumber current category

				try {

					$entry->renumberOrder($entry->knowledgebase_id, $entry->category_id, $entry->is_category);

				} catch (yii\db\Exception $ex) {

					$alert = 'Failed to renumber current category';

					$transaction->rollback();

					break;

				}


				$transaction->commit();

				break;

			} while(0);

			Yii::$app->db->createCommand('UNLOCK TABLES')->execute();

			$pjax_reload = '#main';

			Yii::$app->response->format = Response::FORMAT_JSON;

			return compact(
				'alert',
				'errors',
				'pjax_reload'
			);

		}

		Yii::$app->db->createCommand('UNLOCK TABLES')->execute();

		return $this->renderAjax('entries-reorder', [
			'model' => $model,
			'alert' => $alert
		]);

	}

	function actionEntriesFilesUpload() {

		$alert = '';

		$errors = [];

		$list = [];

		if (Yii::$app->request->isPost) {

			$validator = new FileValidator(); // no rules for now

			$files = UploadedFile::getInstancesByName('files');

			if (!count($files)) {

				if ($_SERVER['CONTENT_LENGTH']) {

					$alert = 'Content-Length exceeds the limit';

				}

			} else {

				foreach ($files as $file) {
        
					$validator->validate($file, $error);
        
					if ($error) {
        
						$errors[Html::encode($file->name)] = $error;
        
					} else {
        
						$model = new KnowledgebaseEntryFile;
        
						$model->knowledgebase_entry_id = 0;
        
						$model->name = $file->name;
        
						$model->file = $file;
        
						$transaction = Yii::$app->db->beginTransaction();
        
						if ($model->save(false) && $model->fileSaved) {
        
							$list[$model->id] = Html::encode($file->name);
        
							$transaction->commit();
        
						} else {
        
							$errors[$file->name] = 'File not saved';
        
							$transaction->rollBack();
        
						}
        
					}
        
				}

			}

			Yii::$app->response->format = Response::FORMAT_JSON;

			return compact(
				'alert',
				'errors',
				'list'
			);

		}

	}

	function actionEntriesFilesDownload($id) {

		$model = KnowledgebaseEntryFile::findOne($id);

		if (!$model) {

			throw new \yii\web\NotFoundHttpException('File not found');

		} else {

			$path = Yii::getAlias('@webroot') . '/uploads/knowledgebase-entry/' . $model->getNumericPath($id) . '.data';

			if (file_exists($path)) {

				 return Yii::$app->response->sendFile($path, $model->name);

			} else {

				throw new \yii\web\NotFoundHttpException('File does not exist');

			}

		}

	}

	private function _get_categories_tree($knowledgebase_id, $selected_id = 0, $current_id = 0) {


		// Get all categories of the knowledgebase
		$categories = KnowledgebaseEntry::find()->where([
			'is_category' => 1,
			'knowledgebase_id' => $knowledgebase_id
		])->asArray()->indexBy('id')->all();


		// Get all categories IDs
		$plain_ids = array_keys($categories);


		// Skip selected_id if there is no such ID in categories

		if ($selected_id && !in_array($selected_id, $plain_ids)) {

			$selected_id = 0;

		}


		// All parents of the selected category will be open nodes

		if ($selected_id) {

			$open_ids = array_filter(explode('|', $categories[$selected_id]['tree_path']));

		} else {

			$open_ids = [];

		}


		// Collect child IDs including the first level

		$child_ids = [];

		foreach ($categories as $category) {

			$parent_id = $category['category_id'];

			if (!isset($child_ids[$parent_id])) {

				$child_ids[$parent_id] = [];

			}

			$child_ids[$parent_id][] = $category['id'];

		}


		// Prepare categories tree with HTML encoded texts

		function _get_categories_child_items(&$categories, &$child_ids, &$open_ids, &$stop_id, $parent_id = 0) {

			$rv = [];

			if (isset($child_ids[$parent_id])) {

				foreach ($child_ids[$parent_id] as $category_id) {

					if ($category_id != $stop_id) {

						$node = [
							'id' => $category_id,
							'text' => Html::encode($categories[$category_id]['title']),
							'children' => _get_categories_child_items($categories, $child_ids, $open_ids, $stop_id, $category_id)
						];

						if (!in_array($category_id, $open_ids) && count($node['children'])) {

							$node['state'] = 'closed';

						}

						$rv[] = $node;

					}

				}

			}

			return $rv;

		}

		$tree = _get_categories_child_items($categories, $child_ids, $open_ids, $current_id);


		// Prepend a blank option to combotree

		$blank_option = [
			'id' => 0,
			'text' => '(None)',
			'children' => []
		];

		array_unshift($tree, $blank_option);


		return compact(
			'tree',
			'plain_ids'
		);

	}

	private function _cacheCategoryCounts($category_id) {

		$count_categories = KnowledgebaseEntry::find()->where([
			'category_id' => $category_id,
			'is_category' => 1
		])->count();

		$count_articles_published = KnowledgebaseEntry::find()->where([
			'category_id' => $category_id,
			'is_category' => 0,
			'status' => 'published'
		])->count();

		$count_articles_draft = KnowledgebaseEntry::find()->where([
			'category_id' => $category_id,
			'is_category' => 0,
			'status' => 'draft'
		])->count();

		return Yii::$app->db->createCommand()->update('knowledgebase_entry', [
				'count_categories' => $count_categories,
				'count_articles_published' => $count_articles_published,
				'count_articles_draft' => $count_articles_draft
			], 'id = :category_id')
			->bindValue(':category_id', $category_id)
			->execute();

	}

	private function _cacheKnowledgebaseCounts($knowledgebase_id) {

		$count_articles_published = KnowledgebaseEntry::find()->where([
			'knowledgebase_id' => $knowledgebase_id,
			'is_category' => 0,
			'status' => 'published'
		])->count();

		$count_articles_draft = KnowledgebaseEntry::find()->where([
			'knowledgebase_id' => $knowledgebase_id,
			'is_category' => 0,
			'status' => 'draft'
		])->count();

		return Yii::$app->db->createCommand()->update('knowledgebase', [
				'count_articles_published' => $count_articles_published,
				'count_articles_draft' => $count_articles_draft
			], 'id = :knowledgebase_id')
			->bindValue(':knowledgebase_id', $knowledgebase_id)
			->execute();

	}

	private function _entries_js() {

		$entries_url = Url::to(['admin-knowledgebases/entries']);

		$js = <<<JS
			$('#_knowledgebase_id').on('change', function() {
				$.pjax({url: '{$entries_url}?knowledgebase_id=' + $(this).val(), container: '#main'});
			});

			$('.reorder-knowledgebase-entry').on('click', function(e) {

				e.preventDefault();

				$('#main .alert-danger').hide();

				$('#main .alert-success').hide();

				$('#preloader').show();

				$.ajax({
					url: $(this).attr('href'),
					type: 'POST',
					data: {
						move_type: $(this).attr('data-move-type')
					},
					timeout: ajaxTimeout,
					complete: function() {

						$('#preloader').hide();

					},
					error: function(jqXHR) {

						var message;

						if (jqXHR.status == 0) {

							message = ajaxTimeoutMessage;

						} else {

							message = jqXHR.responseText;

						}

						$('#main .alert-danger').html(message).show().delay(2000).fadeOut();

					},
					success: function(data) {

						var success = true;

						if (data.errors !== undefined && !$.isEmptyObject(data.errors)) {

							success = false;

							// Collect errors
							var html = '';
							$.each(data.errors, function(key, val) {
								html+= val + '<br>';
							});

							// Show alert
							$('#main .alert-danger').html(html).show().delay(2000).fadeOut();

						}

						if (data.alert !== undefined && data.alert != '') {

							success = false;

							$('#main .alert-danger').html(data.alert).show().delay(2000).fadeOut();

						}

						if (success) {

							$.pjax.reload({
								container: '#main'
							});

						}

					}
				});

			});
JS;

		return $js;

	}

}
