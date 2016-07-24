<?php

namespace app\components;

use Yii;

class AccessRule extends \yii\filters\AccessRule {

	/** @inheritdoc */
	protected function matchRole($user) {

		if (empty($this->roles)) {
			return true;
		}

		foreach ($this->roles as $role) {
			if ($role === '?') {
				if (Yii::$app->user->isGuest) {
					return true;
				}
			} elseif ($role === '@') {
				if (!Yii::$app->user->isGuest) {
					return true;
				}
			} elseif (strpos($role, '!') === 0 && strlen($role) > 1) {
				if (Yii::$app->user->isGuest || !Yii::$app->user->identity->hasPrivilegeByName(substr($role, 1))) {
					return true;
				}
			} elseif (!Yii::$app->user->isGuest && Yii::$app->user->identity->hasPrivilegeByName($role)) {
				return true;
			}
		}

		return false;
	}

}
