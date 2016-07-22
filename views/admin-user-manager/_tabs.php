<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<ul class="nav nav-tabs">
	<li><?php echo Html::a('Users', Url::to(['admin-user-manager/index']), ['class' => ((Yii::$app->controller->action->id == 'index') ? 'active':'')]); ?></li>
	<li><?php echo Html::a('Roles', Url::to(['admin-user-manager/roles']), ['class' => ((Yii::$app->controller->action->id == 'roles') ? 'active':'')]); ?></li>
</ul>
