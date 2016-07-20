<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
?>

<?php echo $this->render('_tabs'); ?>


<?php foreach ($dataProviders as $companyTypeId => $dataProvider): ?>

	<h4>Roles and privileges for <?php echo Html::encode($companyTypes[$companyTypeId]); ?></h4>
	<div class="table-responsive">
	<?php
		echo GridView::widget([
			'dataProvider' => $dataProvider,
			'layout' => "{items}",
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
								$url = Url::to(['admin-user-manager/update-role', 'id' => $model->id]);
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
					]
				]
			],
		]);
	?>
	</div>

<?php endforeach; ?>
