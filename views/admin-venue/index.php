<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\Region;
use app\models\Destination;
use app\models\Location;
use app\models\VenueType;
use app\models\VenueService;
use app\models\Vibe;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Venue */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title  = '';

$this->params['breadcrumbs'][] = $this->title;
$this->params['title'] = 'Venue list';
$this->registerJsFile("/js/multiple-select.js",['depends'=>'yii\web\JqueryAsset']);
$this->registerCssFile("/css/multiple-select.css");
$this->registerJs("
      
		$(document).on('ready pjax:end', function() {
			get_menu($('.grid-view table tbody tr:first-child').attr('data-key'));
			$('.grid-view table tbody tr:first-child').addClass('active');
			$('.multiple').multipleSelect({});
			$('.grid-view table tr').on('click',function(){
				$(this).addClass('active');
				get_menu($(this).attr('data-key'));
			})
		});
		function get_menu(id) {
			$('.grid-view table tr').removeClass('active');
			
			$.ajax({
				url:'".Url::to(["admin-venue/menu"])."',
				method:'POST',
				data:{'id':id},
				success:function(data){
					$('.venue_list').html(data);
				}

			})
		}
		

");
?>
<div class="venue-index">

    <!--h1><!--?= Html::encode($this->title) ?></h1-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php 
        $region           = new Region();
        $location_list    = isset($searchModel->location)?$searchModel->location->getList($searchModel->location->destination_id):array();
        $destination      = new Destination();
        $destination_list = isset($searchModel->location)?$destination->getList($searchModel->location->destination->region_id):array();
        $region_id        = isset($searchModel->location)?$searchModel->location->destination->region_id:'';
        $destination_id   = isset($searchModel->location)?$searchModel->location->destination_id:'';
        $type             = new VenueType();
        $vibe             = new Vibe();
        $service          = new VenueService();?>
    <div class="top_panel clearfix">
		<div class="col-md-2 col-sm-2">
			 <?= Html::a('Create Venue', ['create'], ['class' => 'btn btn-danger']) ?>        
		</div>
		
		<div class="col-md-10 filter">
			<form name="search" class="clearfix" method="get" action="">
				<div class="col-md-9">      
					<label class="control-label"><i class="glyphicon glyphicon-filter"></i> Filter by:</label>
					
					<div>
						<?php echo Html::dropDownList('VenueSearch[active]',$searchModel->active,['Not active', 'Active'],['prompt'=>'Status', 'class' => 'chosen-style'])?> 
							 <?= Html::dropDownList('VenueSearch[region_id]', $searchModel->region_id, $region->getList(),
										[
											'class'  => 'chosen-style',
											'prompt' => 'Region', 
											'onchange'=>'
												var id = $(this).val();
												$.ajax({
												url:"'.Yii::$app->urlManager->createUrl(["admin-mastertable/dynamicdestinations"]).'",
												method:"POST",
												data:{"region_id":id},
												success:function(data){
													$("#destination_id").chosen("destroy");
													$("#destination_id").empty().append( data );
													$("#destination_id").removeAttr("disabled");
								                    $("#destination_id").chosen({disable_search_threshold: 10});
													$("#location_id").html("");
												}
											})'
										]);
							?>
							<?php echo Html::dropDownList('VenueSearch[type_id][]',$searchModel->type_id,$type->getList(),['placeholder'=>'Venue type', 'class'  => 'multiple','multiple'=>'multiple'])?> 
							<?php echo Html::dropDownList('VenueSearch[featured]',$searchModel->featured,['Not featured', 'Featured'],['prompt'=>'Is featured', 'class'  => 'chosen-style'])?> 
							<?= Html::dropDownList('VenueSearch[destination_id]', $searchModel->destination_id, $destination_list,
								[
									'id'=>'destination_id',
									'class'  => 'chosen-style',
									'disabled'=>'disabled',
									'prompt' => 'Destination', 
									'onchange'=>'
										var id = $(this).val();
										$.ajax({
										url:"'.Yii::$app->urlManager->createUrl(["admin-mastertable/dynamiclocations"]).'",
										method:"POST",
										data:{"destination_id":id},
										success:function(data){
											$("#location_id").chosen("destroy");
											$("#location_id").empty().append( data ).multipleSelect("refresh");
											$("#location_id").chosen({disable_search_threshold: 10});
										}
									})'
								]);
							?>

							<?php echo Html::dropDownList('VenueSearch[vibe_id][]',$searchModel->vibe_id,$vibe->getList(),['placeholder'=>'Wedding Vibe',  'class'  => 'multiple drop_lg','multiple'=>'multiple'])?>
							<div style="width:190px;float:left"> &nbsp;</div>
							<?php echo Html::dropDownList('VenueSearch[location_id][]', $searchModel->location_id, $location_list,
								[
									'id'=>'location_id',
									'class'  => 'multiple',
									'placeholder' => 'Location', 
									'multiple'=>'multiple',
									[
								        'horizontalCssClasses' => [
								            'offset' => 'col-sm-offset-4',
								        ]
								    ]
								   
								]);
							?>
							
						
							
							
							<?php echo Html::dropDownList('VenueSearch[service_id][]',$searchModel->service_id,$type->getList(),['placeholder'=>'Venue provides', 'class'  => 'multiple','multiple'=>'multiple'])?>  
					
					</div>
			  
				</div>
	 
				<div class="col-md-3 col-sm-4 input-group">
					<input type="text" name="VenueSearch[name]" value="<?php echo (isset($searchModel->name)?$searchModel->name:(isset($searchModel->name)?$searchModel->name:''));?>" class="form-control" placeholder="Search" autocomplete="off">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
					</span>
				</div>
		  </form>
		</div>
	</div>
	<div class="col-md-3 venue_list">
		
	</div>
	<div class="col-md-9">
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'layout' => "{items}\n{summary}\n{pager}",
			'tableOptions' => [
				'class' => 'table table-bordered table-condensed'
			],
			'columns' => [
				[
					'label' => 'Destination',
					'value' => 'location.destination.name'
				],
				[
					'label' => 'Location',
					'value' => 'location.name'
				],
				[
					'label' => 'Airport Code',
					'value' => 'location.airport'
				],
				[
					'label'       => 'Venue Name<br/> Featured Name',
					'encodeLabel' => false,
					'format'      => 'raw',
					'value'       => function($data){
						return $data->name."<br/>".$data->featured_name;
					},
				],
				[
					'label' => 'Featured',
					'format' => 'raw',
					'value' => function($data){
						return Html::checkbox('featured',
							($data->featured==1)?true:false,['disabled'=>true]
							
						);
					},
				],
				// 'featured',
				// 'type_id',
				// 'vibe_id',
				// 'service_id',
				// 'comment:ntext',
				// 'guest_capacity',
				// 'updated_by',
				// 'updated_at',

				[
					'class' => 'yii\grid\ActionColumn','template' => '{delete}',
					
					'buttons' => [
						'urlCreator' => function ($action, $model, $key, $index) {
							global $delete_url;
							$url = Url::to([Yii::$app->controller->id."/delete", 'id' => $model->id]);
							
							return $url;
						},
						'delete' => function($url, $model) {
							return Html::button('<i class="glyphicon glyphicon-close"></i> Delete', [
								'value' =>  $url,
								'class' => 'btn btn-primary modal-ajax',
							]);
						}
					]
				],
			],
		]); ?>
	</div>
</div>
