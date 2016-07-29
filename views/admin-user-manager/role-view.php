<?php
use yii\helpers\Html;
use yii\grid\GridView;
?>

<p>Privileges for <span><?php echo (($model->organization_type_id && $model->organization_type_id != Yii::$app->user->identity->organization->type_id) ? Html::encode($organizationTypes[$model->organization_type_id]) . ':' : '') . Html::encode($model->display_name); ?></span></p>

<div class="table-responsive">

<?php
	echo GridView::widget([
		'dataProvider' => $dataProvider,
		'layout' => "{items}",
		'tableOptions' => [
			'class' => 'table table-bordered table-condensed'
		],
		'rowOptions' => function($model) {
			if ($model->parent_id) {
				return ['class' => 'child_line'];
			}
		},
		'columns' => [
			[
				'label' => 'Name',
				'attribute' => 'display_name'
			],
			[
				'label' => 'Enabled',
				'format' => 'raw',
				'value' => function ($data) use ($model) {
					if (in_array($data->id, $model->privilege_ids)) {
						$checked =  'checked';
						$class_on = 'on';
					} else {
						$checked =  '';
						$class_on = '';
					}
					return "<input type=\"checkbox\" class=\"custom_checkbox {$class_on}\" {$checked} disabled>";
				}
			],
		],
	]);
?>

</div>
