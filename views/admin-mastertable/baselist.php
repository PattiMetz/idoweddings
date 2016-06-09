<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
?>

<?php echo $this->render('tabs', ['exampleName' => $exampleName, 'filterModel' => $filterModel]);?>

<div class="clearfix">
	<?php
		global $update_url;
		$update_url = Yii::$app->controller->id."/".$exampleName."-update";
		global $delete_url;
		$delete_url = Yii::$app->controller->id."/".$exampleName."-delete";

		echo GridView::widget([
			'dataProvider' => $dataProvider,
			'layout' => "{items}\n{summary}\n{pager}",
			'tableOptions' => [
				'class' => 'table table-bordered table-condensed'
			],
			'columns' => [
		        [
		            'attribute'=>'name',
		            
		            'format' => 'raw',
		            'value' => function($data){
		            	global $update_url;
		                return Html::a($data->name,
		                	Url::to([$update_url, 'id'=>$data->id]),
		                	[ 'class' => 'modal-ajax']
		                );
		                
		            },
		        ],
		        
		        [
			        'class' => 'yii\grid\ActionColumn','template' => '{delete}',
			        'urlCreator' => function ($action, $model, $key, $index) {
						global $delete_url;
						$url = Url::to([$delete_url, 'id' => $model->id]);
						
						return $url;
					},
					'buttons' => [
						'delete' => function($url, $model) {
							return Html::button('<i class="glyphicon glyphicon-close"></i> Delete', [
								'value' => $url,
								'class' => 'btn btn-primary modal-ajax',
							]);
						}
					]
				],
		    ]
		]);
	?>
</div>
