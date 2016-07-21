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

?>
<div class="venue-index">

    <!--h1><!--?= Html::encode($this->title) ?></h1-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php 
        $region           = new Region();
        $location         = new Location;
        $location_list    = isset($searchModel->destination_id)?$location->getList($searchModel->destination_id):array();
        $destination      = new Destination();
        $destination_list = isset($searchModel->region_id)?$destination->getList($searchModel->region_id):array();
        $region_id        = $searchModel->region_id;
        $destination_id   = $searchModel->destination_id;
        $type             = new VenueType();
        $vibe             = new Vibe();
        $service          = new VenueService();?>
    <div class="top_panel clearfix">
		<div class="col-md-2 col-sm-2">
			 <?= Html::a('Create Venue', ['update'], ['class' => 'btn btn-danger']) ?>        
		</div>
		
		<div class="col-md-10 filter">
				<?php echo Html::beginForm(['?'], 'get', ['data-pjax' => '', 'class' => 'clearfix venue_filter']); ?>
				<div class="col-md-9">      
					<label class="control-label"><i class="glyphicon glyphicon-filter"></i> Filter by:</label>
					
					<div>
						<div class="select_wrapper">
							<?php echo Html::dropDownList('VenueSearch[active]',$searchModel->active,['Not active', 'Active'],['prompt'=>'Status', 'class' => 'chosen-style filter_field'])?> 
							<?php echo Html::dropDownList('VenueSearch[featured]', $searchModel->featured, ['Not featured', 'Featured'],['prompt' => 'Is featured', 'class'  => 'chosen-style filter_field'])?> 
						</div>
						<div class="select_wrapper">
							<?= Html::dropDownList('VenueSearch[region_id]', $searchModel->region_id, $region->getList(),
								[
									'class'    => 'chosen-style',
									'prompt'   => 'Region', 
									'onchange' => '
											$("#destination_id").chosen("destroy");
											$("#destination_id").empty().html("<option value=\'\'>Destination</option>");
											$("#destination_id").chosen();
											$("#location_block").html("");
											$(".venue_filter").submit();
											
									'
								]);
							?>
							<?= Html::dropDownList('VenueSearch[destination_id]', $searchModel->destination_id, $destination_list,
								[
									'id'       => 'destination_id',
									'class'    => 'chosen-style',
									'prompt'   => 'Destination', 
									'onchange' => '
										$("#location_block").html("");
										$(".venue_filter").submit();
									'
								]);
							?>
							<!--?php echo Html::dropDownList('VenueSearch[location_id][]', $searchModel->location_id, $location_list,
								[
									'id'          => 'location_id',
									'class'       => 'multiple filter_field',
									'placeholder' => 'Location', 
									'multiple'    => 'multiple',
									[
								        'horizontalCssClasses' => [
								            'offset' => 'col-sm-offset-4',
								        ]
								    ]
								   
								]);
							?-->
							<div class="multiselect_box">
								<span>Location</span>
								<ul class="drop_bottom" id="location_block">
									
									<?php echo Html::checkboxList('VenueSearch[location_id][]', $searchModel->location_id, $location_list,[
									'tag'=>'li',
									'separator'=>'</li><li>',
									'item' =>
						                function ($index, $label, $name, $checked, $value) {
						                    return Html::checkbox($name, $checked, [
									                        'value' => $value,
									                        'label' => $label,
									                        'class' => 'filter2_field',
									                        'labelOptions' => [
									                            'class' => 'checkbox-inline',
									                        ],
									                        //'id' => $label,
									                    ]);
						                }]) ?>
								</ul>
							</div>
						</div>
						<div class="select_wrapper">
							<!--?php echo Html::dropDownList('VenueSearch[type_id][]',$searchModel->type_id,$type->getList(), ['placeholder' => 'Venue type', 'class'  => 'multiple filter_field','multiple' => 'multiple'])?-->
							<div class="multiselect_box">
								<span>Venue type</span>
								<ul class="drop_bottom" id="type_block">
									<?php echo Html::checkboxList('VenueSearch[type_id][]', $searchModel->type_id, $type->getList(),[
									'tag'=>'li',
									'separator'=>'</li><li>',
									'item' =>
						                function ($index, $label, $name, $checked, $value) {
						                    return Html::checkbox($name, $checked, [
									                        'value' => $value,
									                        'label' => $label,
									                        'class' => 'filter2_field',
									                        'labelOptions' => [
									                            'class' => 'checkbox-inline',
									                        ],
									                        'id' => $label,
									                    ]);
						                }]) ?>
									
								</ul>
							</div>
							<!--?php echo Html::dropDownList('VenueSearch[vibe_id][]',$searchModel->vibe_id,$vibe->getList(),['placeholder' => 'Wedding Vibe',  'class' => 'multiple drop_lg filter_field','multiple'=>'multiple'])?-->
							<div class="multiselect_box">
								<span>Wedding Vibe</span>
								<ul class="drop_bottom" id="vibe_block">
									<?php echo Html::checkboxList('VenueSearch[vibe_id][]', $searchModel->vibe_id, $vibe->getList(),[
									'tag'=>'li',
									'separator'=>'</li><li>',
									'item' =>
						                function ($index, $label, $name, $checked, $value) {
						                    return Html::checkbox($name, $checked, [
									                        'value' => $value,
									                        'label' => $label,
									                        'class' => 'filter2_field',
									                        'labelOptions' => [
									                            'class' => 'checkbox-inline',
									                        ],
									                        //'id' => $label,
									                    ]);
						                }]) ?>
								</ul>
							</div>
							<!--?php echo Html::dropDownList('VenueSearch[service_id][]',$searchModel->service_id,$type->getList(),['placeholder' => 'Venue provides', 'class'  => 'multiple filter_field','multiple' => 'multiple'])?-->
							<div class="multiselect_box">
								<span>Venue provides</span>
								<ul class="drop_bottom" id="service_block">
									<?php echo Html::checkboxList('VenueSearch[service_id][]', $searchModel->service_id, $service->getList(),[
									'tag'=>'li',
									'separator'=>'</li><li>',
									'item' =>
						                function ($index, $label, $name, $checked, $value) {
						                    return Html::checkbox($name, $checked, [
									                        'value' => $value,
									                        'label' => $label,
									                        'class' => 'filter2_field',
									                        'labelOptions' => [
									                            'class' => 'checkbox-inline',
									                        ],
									                        //'id' => $label,
									                    ]);
						                }]) ?>
								</ul>
							</div>
						</div>										
					</div>
			  
				</div>
	 
				<div class="col-md-3 col-sm-4 input-group">
					<input type="text" name="VenueSearch[name]" value="<?php echo (isset($searchModel->name)?$searchModel->name:(isset($searchModel->name)?$searchModel->name:''));?>" class="form-control" placeholder="Search" autocomplete="off">
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
					</span>
				</div>
		  <?php echo Html::endForm() ?>
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
				/*[
					'label' => 'Destination',
					'value' => 'location.destination.name'
				],
				[
					'label' => 'Location',
					'value' => 'location.name'
				],*/
				'destinationName',
				'locationName',
				[
					'attribute'   => 'fullName',
					'format'      => 'html',
					'encodeLabel' => false,
					'label'       => 'Venue Name<br/>Featured Name'
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
<?php
$this->registerJs("

		$(document).on('ready pjax:end', function(e) {
			get_menu($('.grid-view table tbody tr:first-child').attr('data-key'));
			$('.grid-view table tbody tr:first-child').addClass('active');
			$('.grid-view table tr').on('click',function(){
				$('.grid-view table tr').removeClass('active');
				$(this).addClass('active');
				get_menu($(this).attr('data-key'));
			})
			var open_select = false;
			/* Top panel pseudo select */
			$('.multiselect_box').click(function() {
				$('.multiselect_box').find('.drop_bottom').hide();
				$(this).find('.drop_bottom').show();
				open_select = true;
			});
			$('.drop_bottom').each(function(){
				setMultipleValue($(this).attr('id'));
			})
			$('.filter_field').on('change',function(){
				$('.venue_filter').submit();
			})
			

			$('.filter2_field').on('change',function(){
				setMultipleValue($(this).parent().parent().parent().attr('id'));
			})
			
			$(document).click(function (event) {

		        if ($(event.target).closest('.drop_bottom').length == 0 && $(event.target).closest('.multiselect_box').length == 0 && open_select) {
		        	
		            $('.drop_bottom').hide();
		            open_select = false;
		            $('.venue_filter').submit();
		        }
		    });
		});

		function setMultipleValue(id) {
			var vals = [];
			$('#' + id).find('input:checkbox:checked').each(function(){
				vals.push($(this).parent().text());

			})
			if(vals.length > 3) {
				$('#' + id).prev().html(vals.length + ' selected');
			} else {
				if(vals.length > 0)
					$('#' + id).prev().html(vals.join(', '));
			}
		}
		function get_menu(id) {
			if(id) {
				$.ajax({
					url:'".Url::to(["admin-venue/menu"])."',
					method:'POST',
					data:{'id':id},
					success:function(data){
						$('.venue_list').html(data);
					}

				})
			}
		}
		

");