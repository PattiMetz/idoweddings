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
use app\models\Knowledgebase;
use app\models\KnowledgebaseEntry;

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
						'actions' => ['index', 'update', 'delete', 'entries', 'categories-update', 'categories-delete', 'articles-update', 'articles-delete'],
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
				'defaultPageSize' => 2,
				'pageSize' => 2
			]
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider
		]);

	}

	public function actionUpdate($id = 0) {

		$alert = '';

		if ($id) {

			$model = Knowledgebase::find()->where(['id' => $id])->one();

			if (!$model) {

				$alert = 'Knowledge base not found.';

			}

		} else {

			$model = new Knowledgebase;

		}

		if ($model->load(Yii::$app->request->post())) {

			$errors = ActiveForm::validate($model);

			if (!count($errors)) {

				if (!$model->save()) {

					$alert = 'Knowledge base not saved.';

				}

			}

			$pjax_reload = '#main';

			Yii::$app->response->format = Response::FORMAT_JSON;

			return compact(
				'errors',
				'alert',
				'pjax_reload'
			);

		}

		return $this->renderAjax('update', [
			'model' => $model,
			'alert' => $alert
		]);

	}

	public function actionTest($id = 0) {

		$alert = '';

		$message = '';

		if ($id) {

			$model = Knowledgebase::find()->where(['id' => $id])->one();

			if (!$model) {

				$alert = 'Knowledge base not found.';

			}

		} else {

			$model = new Knowledgebase;

		}

		if ($model->load(Yii::$app->request->post())) {

			$errors = ActiveForm::validate($model);

			if (!count($errors)) {

				if (!$model->save()) {

					$alert = 'Knowledge base not saved.';

				} else {

					$message = 'Knowledge base saved.';

				}

			}

			Yii::$app->response->format = Response::FORMAT_JSON;

			return compact(
				'errors',
				'alert',
				'message'
			);

		}

		return $this->render('test', [
			'model' => $model,
			'alert' => $alert
		]);

	}

	function actionDelete($id) {

		$alert = '';

		$model = Knowledgebase::findOne($id);

		if (!$model) {

			$alert = 'Knowledge base not found.';

		}

		if (Yii::$app->request->isPost) {

			$errors = [];

			if (!$model->delete()) {

				$alert = 'Knowledge base not deleted.';

			}

			$pjax_reload = '#main';

			Yii::$app->response->format = Response::FORMAT_JSON;

			return compact(
				'errors',
				'alert',
				'pjax_reload'
			);

		}

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

		// Categories cache
		$categories = array();

		// Get all knowledgebases for SELECT options
		$knowledgebases = ArrayHelper::map(Knowledgebase::find()->all(), 'id', 'name');

		do {

			// Sanitize knowledgebase ID
			$knowledgebase_id = intval($knowledgebase_id);


			// Knowledgebase not found

			if (!isset($knowledgebases[$knowledgebase_id])) {

				$knowledgebase_id = 0;

				$alert = 'Knowledge base not found.';

				break;

			}


			// Set page title
			$this->view->title = $knowledgebases[$knowledgebase_id] . Yii::$app->request->get('page');

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

					$alert = 'Category not found.';

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
				'query' => KnowledgebaseEntry::find()->where($filter), // entries
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

//		$this->view->params['js'] = '
//			$("#knowledgebase_id").change(function() {
//				$.pjax({url: "' . Url::to(['admin-knowledgebases/entries']) . '?knowledgebase_id=" + $(this).val(), container: "#main"});
//			});
//		';

		$this->view->params['js'] = '
			$(document).on("change", "#_knowledgebase_id", function() {
				$.pjax({url: "' . Url::to(['admin-knowledgebases/entries']) . '?knowledgebase_id=" + $(this).val(), container: "#main"});
			});
		';

		return $this->render('entries', [
			'alert' => $alert,
			'dataProvider' => $dataProvider,
			'current_knowledgebase_id' => $knowledgebase_id,
			'current_category_id' => $category_id,
			'knowledgebases' => $knowledgebases, // SELECT options
			'current_path' => $current_path,
			'categories' => $categories // cache
		]);

	}

	public function actionCategoriesUpdate($id = 0) {

		$alert = '';

		if ($id) {

			$model = KnowledgebaseEntry::find()->where(['id' => $id])->one();

			if (!$model) {

				$alert = 'Category not found.';

			}

		} else {

			$model = new KnowledgebaseEntry;

			$knowledgebase_id = Yii::$app->request->get('knowledgebase_id');

			if (isset($knowledgebase_id)) {

				$model->knowledgebase_id = $knowledgebase_id;

			}

			$category_id = Yii::$app->request->get('category_id');

			if (isset($category_id)) {

				$model->category_id = intval($category_id);

			} else {

				$model->category_id = 0;

			}

			$model->is_category = 1;

			$model->status = 'published';

		}

		if ($model->load(Yii::$app->request->post())) {

			$errors = ActiveForm::validate($model);

			if (!count($errors)) {

				if (!$model->save()) {

					$alert = 'Category not saved.';

				}

			}

			$pjax_reload = '#main';

			Yii::$app->response->format = Response::FORMAT_JSON;

			return compact(
				'errors',
				'alert',
				'pjax_reload'
			);

		}

		return $this->renderAjax('categories-update', [
			'model' => $model,
			'alert' => $alert
		]);

	}

	function actionCategoriesDelete($id) {

		$alert = '';

		$model = KnowledgebaseEntry::findOne($id);

		if (!$model) {

			$alert = 'Category not found.';

		}

		if (Yii::$app->request->isPost) {

			$errors = [];

			if (!$model->delete()) {

				$alert = 'Category not deleted.';

			}

			$pjax_reload = '#main';

			Yii::$app->response->format = Response::FORMAT_JSON;

			return compact(
				'errors',
				'alert',
				'pjax_reload'
			);

		}

		return $this->renderAjax('categories-delete', [
			'model' => $model,
			'alert' => $alert
		]);

	}

	public function actionArticlesUpdate($id = 0) {

		$this->view->title = ($id) ? 'Edit Article' : 'Add Article';

		$alert = '';

		if ($id) {

			$model = KnowledgebaseEntry::find()->where(['id' => $id])->one();

			if (!$model) {

				$alert = 'Article not found.';

			}

		} else {

			$model = new KnowledgebaseEntry;

			$knowledgebase_id = Yii::$app->request->get('knowledgebase_id');

			if (isset($knowledgebase_id)) {

				$model->knowledgebase_id = $knowledgebase_id;

			}

			$category_id = Yii::$app->request->get('category_id');

			if (isset($category_id)) {

				$model->category_id = intval($category_id);

			} else {

				$model->category_id = 0;

			}

			$model->status = 'draft';

		}

		$model->statuses = [
			'published' => 'Published',
			'draft' => 'Draft'
		];

		if ($model->load(Yii::$app->request->post())) {

			$model->save();

			$errors = $model->getErrors();

			$pjax_reload = '#main';

			Yii::$app->response->format = Response::FORMAT_JSON;

			return compact(
				'errors',
				'alert',
				'pjax_reload'
			);

		}

		return $this->renderAjax('articles-update', [
			'model' => $model,
			'alert' => $alert
		]);

	}

	function actionArticlesDelete($id) {

		$alert = '';

		$model = KnowledgebaseEntry::findOne($id);

		if (!$model) {

			$alert = 'Article not found.';

		}

		if (Yii::$app->request->isPost) {

			$errors = [];

			if (!$model->delete()) {

				$alert = 'Article not deleted.';

			}

			$pjax_reload = '#main';

			Yii::$app->response->format = Response::FORMAT_JSON;

			return compact(
				'errors',
				'alert',
				'pjax_reload'
			);

		}

		return $this->renderAjax('articles-delete', [
			'model' => $model,
			'alert' => $alert
		]);

	}

}
