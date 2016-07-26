<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<ul class="nav nav-tabs">
	<li><?php echo Html::a('Users', Url::to(['admin-user-manager/index']), ['class' => ((Yii::$app->controller->action->id == 'index') ? 'active':'')]); ?></li>
	<?php if (Yii::$app->user->identity->hasPrivilegeByName('usermanager:roles')): ?>
		<li><?php echo Html::a('Roles', Url::to(['admin-user-manager/role-list']), ['class' => ((Yii::$app->controller->action->id == 'role-list') ? 'active':'')]); ?></li>
	<?php endif; ?>
</ul>
