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
use app\models\User;
use app\models\Role;
use app\models\Privilege;
use app\models\Region;
use app\models\Destination;
use app\models\Location;

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

	public function actionUserUpdate($id = 0) {

		$this->view->title = ($id) ? 'Edit User' : 'Add User';

		if ($id) {

			$model = User::findOne($id);

			if (!$model) {           

				throw new \yii\web\NotFoundHttpException('User not found');

			}

			$model->scenario = 'update';

			$roles = $model->organization->getAvailableRoles()->all();

			$model->privilege_ids = $model->getPrivileges()->select('id')->column();

		} else {

			$model = new User;

			$model->scenario = 'create';

			$organization = Yii::$app->user->identity->organization;

			$model->organization_id = $organization->id;

			$roles = $organization->getAvailableRoles()->all();

			if (count($roles)) {

				$role = $roles[0];

				$model->role_id = $role->id;

				$model->privilege_ids = $role->getPrivileges()->select('id')->column();

			} else {

				$model->role_id = 0;

				$model->privilege_ids = [];

			}

		}

		$model->prepareGeoSettings();

		$model->geoTreeInfo = $this->_getGeoTreeInfo();

		$model->privilegesTreeInfo = (new Privilege)->getTreeInfo();

		$model->roleItems = ArrayHelper::map($roles, 'id', 'display_name');

		if ($model->load(Yii::$app->request->post())) {

			do {

				$errors = ActiveForm::validate($model);

				if (count($errors)) {

					break;

				}

				$transaction = Yii::$app->db->beginTransaction();

				$alert = '';

				if (!$model->save(false)) {

					$alert = 'User not saved';

					$transaction->rollback();

					break;

				}


				// Save Geo Settings

				try {

					$model->saveGeoSettings();

				} catch (yii\db\Exception $ex) {

					$alert = 'Failed to save user settings';

					$transaction->rollback();

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

						$privilege = $model->privilegesTreeInfo['flat_tree'][$privilege_id];

						$model->link('privileges', $privilege);

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

		$privilegesDataProvider = new ArrayDataProvider([
			'allModels' => $model->privilegesTreeInfo['flat_tree']
		]);

		$_privilege_checkbox_change_handler_js = $this->_privilege_checkbox_change_handler_js();

		return $this->renderAjax('user-update', compact(
			'model',
			'privilegesDataProvider',
			'_privilege_checkbox_change_handler_js'
		));

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

		if ($model->load(Yii::$app->request->post())) {
		
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

						$privilege = $model->privilegesTreeInfo['flat_tree'][$privilege_id];

						$model->link('privileges', $privilege);

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

		$privilegesDataProvider = new ArrayDataProvider([
			'allModels' => $model->privilegesTreeInfo['flat_tree']
		]);

		$_privilege_checkbox_change_handler_js = $this->_privilege_checkbox_change_handler_js();

		return $this->renderAjax('role-update', compact(
			'model',
			'privilegesDataProvider',
			'_privilege_checkbox_change_handler_js'
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

		$privilegesDataProvider = new ArrayDataProvider([
			'allModels' => $model->privilegesTreeInfo['flat_tree']
		]);

		return $this->renderAjax('role-view', compact(
			'model',
			'privilegesDataProvider',
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

		if (count($model->users)) {

			throw new \yii\web\ForbiddenHttpException('You can\'t delete this role because of connected users');

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

	public function actionRolePrivilegeCheckboxList($role_id, $field_name) {

		/*TODO: validate field name */

		/*TODO: it is similar to roleView */

		$model = Role::findOne($role_id);

		if (!$model) {

			throw new \yii\web\NotFoundHttpException('Role not found');

		}

		if ($model->organization_id) {

			if ($model->organization_id != Yii::$app->user->identity->organization_id) {

				throw new \yii\web\ForbiddenHttpException('You are not allowed to view this role');

			}

		} elseif ($model->organization_type_id != Yii::$app->user->identity->organization->type_id) {

			throw new \yii\web\ForbiddenHttpException('You are not allowed to view this role');

		}

		$model->privilege_ids = $model->getPrivileges()->select('id')->column();

		$model->privilegesTreeInfo = (new Privilege)->getTreeInfo();

		$privilegesDataProvider = new ArrayDataProvider([
			'allModels' => $model->privilegesTreeInfo['flat_tree']
		]);

		$is_view = false;

		return $this->renderAjax('_privilege-checkbox-list', compact(
			'model',
			'privilegesDataProvider',
			'is_view',
			'field_name'
		));

	}

	private function _getGeoTreeInfo() {

		$regions = Region::find()->orderBy('name')->indexBy('id')->all();

		$destinations = Destination::find()->where(['active' => 1])->orderBy('name')->indexBy('id')->all();

		$locations = Location::find()->where(['active' => '1'])->orderBy('name')->indexBy('id')->all();

		$child_ids = [
			'by_region' => [],
			'by_destination' => []
		];

		foreach ($regions as $region) {

			$child_ids['by_region'][$region->id] = [];

		}

		foreach ($destinations as $destination) {

			$child_ids['by_region'][$destination->region_id][] = $destination->id;

			$child_ids['by_destination'][$destination->id] = [];

		}

		foreach ($locations as $location) {

			$child_ids['by_destination'][$location->destination_id][] = $location->id;

		}

		return compact('regions', 'destinations', 'locations', 'child_ids');

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

	private function _privilege_checkbox_change_handler_js() {

		$js = <<<EOT
			var handleCheckboxChange = function(e) {
				var fieldId = e.data.fieldId;
				var checked = this.checked;
				var childIds = $(this).data('child-ids');
				$.each(childIds, function(index, value) {
					var selector = '.field-' + fieldId + ' input[value="' + value + '"]';
					$(selector).prop('checked', checked);
					$(selector).prop('disabled', !checked);
					$(selector).trigger('refresh');
				});
			}
EOT;

		return $js;

	}

}
