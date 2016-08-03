<?php
use yii\helpers\Html;
use yii\grid\GridView;
?>

<p>Privileges for <span><?php echo (($model->organization_type_id && $model->organization_type_id != Yii::$app->user->identity->organization->type_id) ? Html::encode($organizationTypes[$model->organization_type_id]) . ':' : '') . Html::encode($model->display_name); ?></span></p>

<div class="table-responsive">

<?php echo $this->render('_privilege-checkbox-list', [
		'model' => $model,
		'privilegesDataProvider' => $privilegesDataProvider,
		'is_view' => true,
		'field_name' => ''
]); ?>

</div>
