<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

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
		/*TODO: What's the workaround using Yii coding style? */
		['privilege_ids', 'filter', 'filter' => [$this, 'handleEmptySelection']],
		['privilege_ids', 'each', 'rule' => ['integer']],
		['privilege_ids', 'filter', 'filter' => 'array_unique'],
		/*TODO: Maybe to show an error instead of removing invalid privileges? */
		['privilege_ids', 'filter', 'filter' => [$this, 'checkPrivileges']]
        ];
    }

    public function scenarios()
    {
	return [
		'create' => ['display_name', 'email', 'username', 'password', 'role_id', 'privilege_ids'],
		'update' => ['display_name', 'email', 'role_id', 'privilege_ids']
	];
    }

    public function formName() {
	return '';
    }

    public function attributeLabels() {
	return [
		'display_name' => 'Name',
		'email' => 'E-mail',
		'role_id' => 'Role',
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

}
