<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
?>

<?php echo $this->render('_tabs'); ?>

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
					'template' => '{update} {view} {delete}',
					'urlCreator' => function ($action, $model, $key, $index) {
/*						$type = ($model->is_category) ? 'categories' : 'articles';
						switch ($action) {
							case 'update':
								$url = Url::to(["admin-knowledgebases/{$type}-update", 'id' => $model->id]);
								break;
							case 'view':
								$url = Url::to(["admin-knowledgebases/{$type}-view", 'id' => $model->id]);
								break;
							case 'delete':
								$url = Url::to(["admin-knowledgebases/{$type}-delete", 'id' => $model->id]);
								break;
						}*/
						$url = '';
						return $url;
					},
					'buttons' => [
						'update' => function($url, $model) {
							return Html::button('<i class="glyphicon glyphicon-pencil"></i> Edit', [
								'value' => $url,
								'class' => 'btn btn-primary modal-ajax',
							]);
						},
						'view' => function($url, $model) {
							return Html::button('<i class="glyphicon glyphicon-mykey"></i>', [
								'value' => $url,
								'class' => 'btn btn-danger modal-ajax',
								'title' => 'Permissins',
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
