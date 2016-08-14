<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "organization".
 *
 * @property integer $id
 * @property integer $type_id
 * @property integer $country_id
 * @property string $state
 * @property string $zip
 * @property string $city
 * @property string $address
 * @property integer $timezone
 * @property string $email
 * @property string $site
 * @property integer $status
 *
 * @property Contact[] $contacts
 */
class Organization extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'organization';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['type_id'], 'required'],
			[['type_id', 'country_id', 'timezone', 'status'], 'integer'],
			[['state'], 'string', 'max' => 100],
			[['zip'], 'string', 'max' => 20],
			[['city'], 'string', 'max' => 200],
			[['address', 'email', 'site'], 'string', 'max' => 255],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'type_id' => 'Type ID',
			'country_id' => 'Country ID',
			'state' => 'State',
			'zip' => 'Zip',
			'city' => 'City',
			'address' => 'Address',
			'timezone' => 'Timezone',
			'email' => 'Email',
			'site' => 'Site',
			'status' => 'Status',
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getContacts()
	{
		return $this->hasMany(Contact::className(), ['organization_id' => 'id']);
	}

	public function getAvailableRoles() {
		return Role::find()
			->where([
				'organization_id' => 0,
				'organization_type_id' => $this->type_id
			])
			->orWhere(['organization_id' => $this->id])
			->orderBy([new \yii\db\Expression('! organization_id DESC, id')]);
	}
}