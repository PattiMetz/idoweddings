<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\search\UserSearch;
use app\models\Role;
use app\models\Privilege;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use app\components\AccessRule;

class AdminUserManagerController extends Controller {

	public $layout = 'admin';

	public function beforeAction($action) {

		$this->view->params['section_title'] = 'User Manager';

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
						'allow' => true,
//						'roles' => ['usermanager'],
					],
				],
			],
		];

	}

	public function actionIndex() {

		$this->view->title = 'Users';

		$searchModel = new UserSearch();

		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider
		]);

	}

	public function actionRoles() {

#var_dump(Yii::$app->user->identity->privilegesNames);

#var_dump(Yii::$app->user->identity->hasPrivilegeByName('usermanager'));

#var_dump(Yii::$app->user->identity->getPrivilegesNames());

		$this->view->title = 'Roles';

		$companyTypes = ArrayHelper::map((new Query)->from('company_type')->all(), 'id', 'name');

		$dataProviders = [];

		foreach (array_keys($companyTypes) as $companyTypeId) {

			$dataProviders[$companyTypeId] = new ArrayDataProvider([
				'allModels' => []
			]);

		}

		$templateRoles = Role::find()->where([
			'company_id' => 0,
			'company_type_id' => array_keys($companyTypes)
		])->all();

		foreach ($templateRoles as $role) {

			$dataProviders[$role->company_type_id]->allModels[] = $role;

		}

		return $this->render('roles', compact(
			'companyTypes',
			'dataProviders'
		));

	}

	function actionUpdateRole($id) {

		$this->view->title = 'Update Role';

		if ($id) {

			$model = Role::findOne($id);

			if (!$model) {           

				throw new \yii\web\NotFoundHttpException('Role not found');

			}

			$model->privilege_ids = $model->getPrivileges()->select('id')->column();

		} else {

			$model = new Role;

			$model->privilege_ids = [];

		}

		$model->privilegesTreeInfo = (new Privilege)->getTreeInfo();

		if (Yii::$app->request->isPost) {
		
			$post = Yii::$app->request->post();
			
			if (empty($post['privilege_ids'])) {

				$post['privilege_ids'] = [];

			}

			$model->load($post);

			if ($model->save()) {

				// Unlink all privileges
				$model->unlinkAll('privileges', true);

				foreach ($model->privilege_ids as $privilege_id) {

					if (isset($model->privilegesTreeInfo['flat_tree'][$privilege_id])) {

						$privilege = $model->privilegesTreeInfo['flat_tree'][$privilege_id];

						// Link privilege
						$model->link('privileges', $privilege);

					}

				}

			} else {

				$errors = $model->getErrors();

			}

			$pjax_reload = '#main';

			Yii::$app->response->format = Response::FORMAT_JSON;

			return compact(
				'errors',
				'pjax_reload'
			);

		}

		return $this->renderAjax('update-role', compact(
			'model'
		));

	}

}
