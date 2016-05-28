<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
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

			$pjax_reload = '#knowledgebases';

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

	function actionEntries() {

		$this->view->title = 'Entries';

		$dataProvider = new ActiveDataProvider([
			'query' => KnowledgebaseEntry::find(),
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

		return $this->render('entries', [
			'dataProvider' => $dataProvider
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

}
