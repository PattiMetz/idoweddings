<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\Alert;
?>

<?php echo $this->render('_tabs'); ?>

<?php

echo Alert::widget([
	'options' => [
		'class' => 'alert-danger',
		'style' => 'display: none'
	],
	'body' => '',
	'closeButton' => false
]);

?>

<div class="top_panel clearfix">
	<div class="col-md-2 col-sm-2">
		<?php echo Html::button('Add Role', ['value' => Url::to(['admin-user-manager/role-update']), 'class' => 'btn btn-danger modal-ajax']); ?>
	</div>
</div>

<div class="roles_block col-md-6 col-sm-12">

<?php foreach ($dataProviders as $organizationTypeId => $dataProvider): ?>

	<p>Roles for <span><?php echo ($organizationTypeId == Yii::$app->user->identity->organization->type_id) ? Html::encode(Yii::$app->user->identity->organization->name) : Html::encode($organizationTypes[$organizationTypeId]); ?></span></p>

	<div class="table-responsive">
	<?php
		echo GridView::widget([
			'dataProvider' => $dataProvider,
			'layout' => "{items}",
			'tableOptions' => [
				'class' => 'table table-bordered table-condensed'
			],
			'columns' => [
				'display_name',
				[  
					'class' => 'yii\grid\ActionColumn',
					'header' => 'Actions',
					'template' => '{update} {delete}',
					'urlCreator' => function ($action, $model, $key, $index) {
						switch ($action) {
							case 'update':
								$url = Url::to(['admin-user-manager/role-update', 'id' => $model->id]);
								break;
							case 'delete':
								$url = Url::to(['admin-user-manager/role-delete', 'id' => $model->id]);
								break;
						}
						return $url;
					},
					'buttons' => [
						'update' => function($url, $model) {
							return Html::button('<i class="glyphicon glyphicon-pencil"></i> Edit', [
								'value' => $url,
								'class' => 'btn btn-primary modal-ajax',
							]);
						},
						'delete' => function($url, $model) {
							return Html::button('<i class="glyphicon glyphicon-close"></i> Delete', [
								'value' => $url,
								'class' => 'btn btn-primary modal-ajax',
							]);
						}
					],
					'visibleButtons' => [
						'update' => function($model) {
							return $model->organization_id && $model->organization_id == Yii::$app->user->identity->organization_id;
						},
						'delete' => 1
					]
				]
			],
		]);
	?>
	</div>

<?php endforeach; ?>

</div>

<div class="privileges_block col-md-6 col-sm-12">

</div>
