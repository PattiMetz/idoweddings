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
						'actions' => ['index', 'update', 'delete', 'entries', 'categories-update', 'categories-delete', 'articles-update', 'articles-delete', 'test'],
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

		$this->view->title = 'Entries';

		$alert = '';

		$dataProvider = false;

		$knowledgebases = ArrayHelper::map(Knowledgebase::find()->all(), 'id', 'name');

		do {

			if (!isset($knowledgebases[$knowledgebase_id])) {

				$knowledgebase_id = 0;

				$alert = 'Knowledge base not found.';

				break;

			}

			if ($category_id) {

				$model_category = KnowledgebaseEntry::find()->where([
					'knowledgebase_id' => $knowledgebase_id,
					'id' => $category_id,
					'is_category' => 1
				])->one();

				if (!$model_category) {

					$alert = 'Category not found.';

					break;

				}

			}

			$filter = ['knowledgebase_id' => $knowledgebase_id];

			if ($category_id) {

				$filter['parent_id'] = $category_id;

			}

			$dataProvider = new ActiveDataProvider([
				'query' => KnowledgebaseEntry::find()->where($filter),
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

		$this->view->params['js'] = '
			$("#knowledgebase_id").change(function() {
				$.pjax({url: "' . Url::to(['admin-knowledgebases/entries']) . '?knowledgebase_id=" + $(this).val(), container: "#main"});
			});
		';

		return $this->render('entries', [
			'alert' => $alert,
			'dataProvider' => $dataProvider,
			'knowledgebase_id' => $knowledgebase_id,
			'category_id' => $category_id,
			'knowledgebases' => $knowledgebases
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

			$model->status = 'draft';

		}

		$model->statuses = [
			'published' => 'Published',
			'draft' => 'Draft'
		];

		if ($model->load(Yii::$app->request->post())) {

			$errors = ActiveForm::validate($model);

			if (!count($errors)) {

				if (!$model->save()) {

					$alert = 'Article not saved.';

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

		return $this->renderAjax('articles-update', [
			'model' => $model,
			'alert' => $alert
		]);

	}

}
