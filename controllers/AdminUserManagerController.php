<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use yii\db\Query;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use app\components\AccessRule;
use app\models\search\UserSearch;
use app\models\Role;
use app\models\Privilege;

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
				'ruleConfig' => [
					'class' => AccessRule::className(),
				],
				'rules' => [
					[
						'actions' => ['role-list', 'role-view', 'role-update', 'role-delete'],
						'allow' => false,
						'roles' => ['!usermanager:roles'],
					],
					[
						'allow' => true,
						'roles' => ['usermanager']
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

	public function actionRoleList() {

		$this->view->title = 'Roles';

		$organizationTypes = ArrayHelper::map((new Query)->from('organization_type')->all(), 'id', 'name');

		if (Yii::$app->user->identity->organization->type_id != 1) {

			$organizationTypes = array_intersect_key($organizationTypes, array_flip([Yii::$app->user->identity->organization->type_id]));

		}

		$dataProviders = [];

		foreach (array_keys($organizationTypes) as $organizationTypeId) {

			$dataProviders[$organizationTypeId] = new ArrayDataProvider([
				'allModels' => [],
				'key' => 'id'
			]);

		}

		$roles = Role::find()
			->where([
				'organization_id' => 0,
				'organization_type_id' => array_keys($organizationTypes)
			])
			->orWhere(['organization_id' => Yii::$app->user->identity->organization_id])
			->orderBy([new \yii\db\Expression('! organization_id DESC, id')])
			->all();

		foreach ($roles as $role) {

			$organization_type_id = ($role->organization_type_id) ? $role->organization_type_id : Yii::$app->user->identity->organization->type_id;

			$dataProviders[$organization_type_id]->allModels[] = $role;

		}

		$this->view->params['js'] = $this->_roles_js();

		return $this->render('role-list', compact(
			'organizationTypes',
			'dataProviders'
		));

	}

	function actionRoleUpdate($id = 0) {

		$this->view->title = ($id) ? 'Edit Role' : 'Add Role';

		if ($id) {

			$model = Role::findOne($id);

			if (!$model) {           

				throw new \yii\web\NotFoundHttpException('Role not found');

			}

			if (!$model->organization_id) {

				throw new \yii\web\ForbiddenHttpException('This role is protected');

			}

			if ($model->organization_id != Yii::$app->user->identity->organization_id) {

				throw new \yii\web\ForbiddenHttpException('You are not allowed to edit this role');

			}

			$model->privilege_ids = $model->getPrivileges()->select('id')->column();

		} else {

			$model = new Role;

			$model->organization_type_id = 0;

			$model->organization_id = Yii::$app->user->identity->organization_id;

			$model->privilege_ids = [];

		}

		$model->privilegesTreeInfo = (new Privilege)->getTreeInfo();

		if (Yii::$app->request->isPost) {
		
			$post = Yii::$app->request->post();
			
			if (empty($post['privilege_ids'])) {

				$post['privilege_ids'] = [];

			}

			$model->load($post);

			do {

				$errors = ActiveForm::validate($model);

				if (count($errors)) {

					break;

				}

				$transaction = Yii::$app->db->beginTransaction();

				$alert = '';

				if (!$model->save()) {

					$alert = 'Role not saved';

					$transaction = rollback();

					break;

				}


				// Unlink all privileges

				try {

					$model->unlinkAll('privileges', true);

				} catch (yii\db\Exception $ex) {

					$alert = 'Failed to unlink privileges';

					$transaction = rollback();

					break;

				}


				// Link privileges

				try {

					foreach ($model->privilege_ids as $privilege_id) {

						if (isset($model->privilegesTreeInfo['flat_tree'][$privilege_id])) {

							$privilege = $model->privilegesTreeInfo['flat_tree'][$privilege_id];

							$model->link('privileges', $privilege);

						}

					}

				} catch (yii\db\Exception $ex) {

					$alert = 'Failed to link privileges';

					$transaction = rollback();

					break;

				}


				$transaction->commit();

				break;

			} while(0);

			$pjax_reload = '#main';

			Yii::$app->response->format = Response::FORMAT_JSON;

			return compact(
				'alert',
				'errors',
				'pjax_reload'
			);

		}

		$dataProvider = new ArrayDataProvider([
			'allModels' => $model->privilegesTreeInfo['flat_tree']
		]);

		return $this->renderAjax('role-update', compact(
			'model',
			'dataProvider'
		));

	}

	public function actionRoleView($id) {

		$organizationTypes = ArrayHelper::map((new Query)->from('organization_type')->all(), 'id', 'name');

		if (Yii::$app->user->identity->organization->type_id != 1) {

			$organizationTypes = array_intersect_key($organizationTypes, array_flip([Yii::$app->user->identity->organization->type_id]));

		}

		$model = Role::findOne($id);

		if (!$model) {

			throw new \yii\web\NotFoundHttpException('Role not found');

		}

		if ($model->organization_id) {

			if ($model->organization_id != Yii::$app->user->identity->organization_id) {

				throw new \yii\web\ForbiddenHttpException('You are not allowed to view this role');

			}

		} elseif (!isset($organizationTypes[$model->organization_type_id])) {

			throw new \yii\web\ForbiddenHttpException('You are not allowed to view this role');

		}

		$model->privilege_ids = $model->getPrivileges()->select('id')->column();

		$model->privilegesTreeInfo = (new Privilege)->getTreeInfo();

		$dataProvider = new ArrayDataProvider([
			'allModels' => $model->privilegesTreeInfo['flat_tree']
		]);

		return $this->renderAjax('role-view', compact(
			'model',
			'dataProvider',
			'organizationTypes'
		));

	}

	public function actionRoleDelete($id) {

		$this->view->title = 'Delete Role';

		$model = Role::findOne($id);

		if (!$model) {

			throw new \yii\web\NotFoundHttpException('Role not found');

		}

		if (!$model->organization_id) {

			throw new \yii\web\ForbiddenHttpException('This role is protected');

		}

		if ($model->organization_id != Yii::$app->user->identity->organization_id) {

			throw new \yii\web\ForbiddenHttpException('You are not allowed to edit this role');

		}

		if (Yii::$app->request->isPost) {

			do {

				$transaction = Yii::$app->db->beginTransaction();

				$alert = '';

				if (!$model->delete()) {

					$alert = 'Role not deleted';

					$transaction->rollback();

					break;

				}


				// Unlink privileges

				try {

					$model->unlinkAll('privileges', true);

				} catch (yii\db\Exception $ex) {

					$alert = 'Failed to unlink privileges';

					$transaction->rollback();

					break;

				}


				$transaction->commit();

				break;

			} while(0);

			$pjax_reload = '#main';

			Yii::$app->response->format = Response::FORMAT_JSON;

			return compact(
				'alert',
				'pjax_reload'
			);
			
		}

		return $this->renderAjax('role-delete', compact(
			'model'
		));

	}

	private function _roles_js() {

		$role_view_url = Url::to(['admin-user-manager/role-view']);

		$js = <<<JS

			var el = $('.roles_block table:first tbody tr:first-child');

			el.addClass('active');

			getRole(el.attr('data-key'));

			$('.roles_block tbody tr').on('click', function() {

				$('.roles_block tbody tr').removeClass('active');

				$(this).addClass('active');

				getRole($(this).attr('data-key'));

			});

			function getRole(id) {

				$('#main .alert-danger').hide();

				$('#main .alert-success').hide();

				$('#preloader').show();

				$.ajax({
					url: '{$role_view_url}',
					type: 'GET',
					data: {
						id: id
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

						$('.privileges_block').html('');

					},
					success: function(data) {

						$('.privileges_block').html(data);

					}
				});

			}
JS;

		return $js;

	}

}
