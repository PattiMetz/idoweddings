<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
?>

<?php echo $this->render('_tabs'); ?>

<div class="top_panel clearfix">
	<div class="col-md-2 col-sm-2">
		<?php echo Html::button('Add User', ['value' => Url::to(['admin-user-manager/user-update']), 'class' => 'btn btn-danger modal-ajax']); ?>
	</div>
</div>

<div class="table-responsive">
<?php
	echo GridView::widget([
		'dataProvider' => $dataProvider,
		'layout' => "{items}\n{summary}\n{pager}",
		'tableOptions' => [
			'class' => 'table table-bordered'
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
							$url = Url::to(['admin-user-manager/user-update', 'id' => $model->id]);
							break;
						case 'delete':
							$url = Url::to(['admin-user-manager/user-delete', 'id' => $model->id]);
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
				]
			]
		],
	]);
?>
</div>
