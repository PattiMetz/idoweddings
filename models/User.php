<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\db\Query;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $display_name
 * @property string $email
 * @property integer $organization_id
 * @property integer $role_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface {

    public $password;

    public $privilegesNames;

    public $privilegesTreeInfo;

    public $privilege_ids;

    public $roleItems;

    public $geoTreeInfo;

    public $region_ids;

    public $all_destinations;

    public $destination_ids;

    public $all_locations;

    public $location_ids;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
	    TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
		['display_name', 'required'],
		['email', 'required'],
		['email', 'unique'],
		['username', 'required'],
		['username', 'string', 'min' => 6, 'max' => 128],
		['username', 'unique'],
		['password', 'required'],
		['password', 'string', 'min' => 6, 'max' => 128],
		['role_id', 'required'],
		['role_id', 'inRoleItems'],
		['all_regions', 'required'],
		['all_regions', 'integer'],
		/*TODO: What's the workaround using Yii coding style? */
		[['privilege_ids', 'region_ids', 'all_destinations', 'destination_ids', 'all_locations', 'location_ids'], 'filter', 'filter' => [$this, 'handleEmptySelection']],
		[['privilege_ids', 'region_ids', 'all_destinations', 'destination_ids', 'all_locations', 'location_ids'], 'each', 'rule' => ['integer']],
		[['privilege_ids', 'region_ids', 'all_destinations', 'destination_ids', 'all_locations', 'location_ids'], 'filter', 'filter' => 'array_unique'],
		/*TODO: Maybe to show an error instead of removing invalid privileges? */
		['privilege_ids', 'filter', 'filter' => [$this, 'checkPrivileges']],
		['region_ids', 'filter', 'filter' => [$this, 'checkRegions']],
		['all_destinations', 'filter', 'filter' => [$this, 'checkAllDestinations']],
		['destination_ids', 'filter', 'filter' => [$this, 'checkDestinations']],
		['all_locations', 'filter', 'filter' => [$this, 'checkAllLocations']],
		['location_ids', 'filter', 'filter' => [$this, 'checkLocations']]
        ];
    }

    public function scenarios()
    {
	return [
		'create' => ['display_name', 'email', 'username', 'password', 'role_id', 'privilege_ids', 'all_regions', 'region_ids', 'all_destinations', 'destination_ids', 'all_locations', 'location_ids'],
		'update' => ['display_name', 'email', 'role_id', 'privilege_ids', 'all_regions', 'region_ids', 'all_destinations', 'destination_ids', 'all_locations', 'location_ids']
	];
    }

//    public function formName() {
//	return '';
  //  }

    public function attributeLabels() {
	return [
		'display_name' => 'Name',
		'email' => 'E-mail',
		'role_id' => 'Role',
		'all_regions' => 'All regions'
	];
    }

    public function inRoleItems() {
	if (!isset($this->roleItems[$this->role_id])) {
		$this->addError('role_id', 'Wrong role');
	}
    }

    public function handleEmptySelection($value) {
	if ($value === '') {
		$value = [];
	}
	return $value;
    }

    public function checkPrivileges($value) {
	foreach (array_keys($value) as $key) {
		if (!isset($this->privilegesTreeInfo['flat_tree'][$value[$key]])) {
			unset($value[$key]);
		}
	}
	return $value;
    }

    public function checkRegions($value) {
	if ($this->all_regions) {
		$value = [];
	} else {
		foreach (array_keys($value) as $key) {
			if (!isset($this->geoTreeInfo['regions'][$value[$key]])) {
				unset($value[$key]);
			}
		}
	}
	return $value;
    }

    public function checkAllDestinations($value) {
	if (empty($this->region_ids)) {
		$value = [];
	} else {
		foreach (array_keys($value) as $key) {
			if (!in_array($value[$key], $this->region_ids)) {
				unset($value[$key]);
			}
		}
	}
	return $value;
    }

    public function checkDestinations($value) {
	if (empty($this->region_ids)) {
		$value = [];
	} else {
		foreach (array_keys($value) as $key) {
			if (!isset($this->geoTreeInfo['destinations'][$value[$key]])) {
				unset($value[$key]);
			} else {
				$region_id = $this->geoTreeInfo['destinations'][$value[$key]]['region_id'];
				if (!in_array($region_id, $this->region_ids) || in_array($region_id, $this->all_destinations)) {
					unset($value[$key]);
				}
			}
		}
	}
	return $value;
    }

    public function checkAllLocations($value) {
	if (empty($this->destination_ids)) {
		$value = [];
	} else {
		foreach (array_keys($value) as $key) {
			if (!in_array($value[$key], $this->destination_ids)) {
				unset($value[$key]);
			}
		}
	}
	return $value;
    }

    public function checkLocations($value) {
	if (empty($this->destination_ids)) {
		$value = [];
	} else {
		foreach (array_keys($value) as $key) {
			if (!isset($this->geoTreeInfo['locations'][$value[$key]])) {
				unset($value[$key]);
			} else {
				$destination_id = $this->geoTreeInfo['locations'][$value[$key]]['destination_id'];
				if (!in_array($destination_id, $this->destination_ids) || in_array($destination_id, $this->all_locations)) {
					unset($value[$key]);
				}
			}
		}
	}
	return $value;
    }

    public function beforeSave($insert) {
	if ($this->scenario == 'create') {
		$this->setPassword($this->password);
		$this->updated_at = date('Y-m-d h:i:s');
	}
	return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getPrivileges()
    {
	return $this->hasMany(Privilege::className(), ['id' => 'privilege_id'])
		->viaTable('{{%user_privilege}}', ['user_id' => 'id']);
    }

    public function getPrivilegesNames()
    {
	if (isset($this->privilegesNames)) {
		return $this->privilegesNames;
	}
	$res = [];
	foreach ($this->privileges as $privilege) {
		$res[] = $privilege->name;
	}
	$this->privilegesNames = $res;
	return $res;
    }

    public function hasPrivilegeByName($name)
    {
	return in_array($name, $this->getPrivilegesNames());
    }

    public function getOrganization()
    {
	return $this->hasOne(Organization::className(), ['id' => 'organization_id']);
    }

    public function prepareGeoSettings()
    {
	$this->prepareRegionSettings();
	$this->prepareDestinationSettings();
	$this->prepareLocationSettings();
    }

    public function prepareRegionSettings()
    {
	if (isset($this->region_ids) && isset($this->all_destinations)) {
		return;
	}

	$this->region_ids = [];
	$this->all_destinations = [];

	if (!$this->id) {
		return;
	}

	$rows = (new Query)
		->from('user_region')
		->where(['user_id' => $this->id])
		->all();

	foreach ($rows as $row) {
		$this->region_ids[] = $row['region_id'];
		if ($row['all_destinations']) {
			$this->all_destinations[] = $row['region_id'];
		}
	}
    }

    public function prepareDestinationSettings()
    {
	if (isset($this->destination_ids) && isset($this->all_locations)) {
		return;
	}

	$this->destination_ids = [];
	$this->all_locations = [];

	if (!$this->id) {
		return;
	}

	$rows = (new Query)
		->from('user_destination')
		->where(['user_id' => $this->id])
		->all();

	foreach ($rows as $row) {
		$this->destination_ids[] = $row['destination_id'];
		if ($row['all_locations']) {
			$this->all_locations[] = $row['destination_id'];
		}
	}
    }

    public function prepareLocationSettings()
    {
	if (isset($this->location_ids)) {
		return;
	}

	$this->location_ids = [];

	if (!$this->id) {
		return;
	}

	$rows = (new Query)
		->from('user_location')
		->where(['user_id' => $this->id])
		->all();

	foreach ($rows as $row) {
		$this->location_ids[] = $row['location_id'];
	}
    }

    public function saveGeoSettings()
    {
	$this->saveRegionSettings();
	$this->saveDestinationSettings();
	$this->saveLocationSettings();
    }

    public function saveRegionSettings()
    {
	if (!isset($this->region_ids) || !isset($this->all_destinations)) {
		return;
	}

	Yii::$app->db->createCommand()->delete('user_region', ['user_id' => $this->id])->execute();

	foreach ($this->region_ids as $region_id) {
		Yii::$app->db->createCommand()->insert('user_region', [
			'user_id' => $this->id,
			'region_id' => $region_id,
			'all_destinations' => in_array($region_id, $this->all_destinations) ? 1 : 0
		])->execute();
	}
    }

    public function saveDestinationSettings()
    {
	if (!isset($this->destination_ids) || !isset($this->all_locations)) {
		return;
	}

	Yii::$app->db->createCommand()->delete('user_destination', ['user_id' => $this->id])->execute();

	foreach ($this->destination_ids as $destination_id) {
		Yii::$app->db->createCommand()->insert('user_destination', [
			'user_id' => $this->id,
			'destination_id' => $destination_id,
			'all_locations' => in_array($destination_id, $this->all_locations) ? 1 : 0
		])->execute();
	}
    }

    public function saveLocationSettings()
    {
	if (!isset($this->location_ids)) {
		return;
	}

	Yii::$app->db->createCommand()->delete('user_location', ['user_id' => $this->id])->execute();

	foreach ($this->location_ids as $location_id) {
		Yii::$app->db->createCommand()->insert('user_location', [
			'user_id' => $this->id,
			'location_id' => $location_id
		])->execute();
	}
    }

}
