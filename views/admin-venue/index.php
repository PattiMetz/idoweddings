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
											$("#location_id").chosen("destroy");
											$("#location_id").html("");
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
										$("#location_id").chosen("destroy");
										$("#location_id").html("<option>Location</option>");
										//$("#location_id").chosen();
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
								<ul class="drop_bottom">
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Select All
										</label>
									</li>
								</ul>
							</div>
						</div>
						<div class="select_wrapper">
							<!--?php echo Html::dropDownList('VenueSearch[type_id][]',$searchModel->type_id,$type->getList(), ['placeholder' => 'Venue type', 'class'  => 'multiple filter_field','multiple' => 'multiple'])?-->
							<div class="multiselect_box">
								<span>Venue type</span>
								<ul class="drop_bottom">
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Select All
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />All-inclusive Resort
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Resort
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Boutique
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Castle
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Cathedral
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Chateau
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Church
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Estate
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Hotel
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Outdoor Venue
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Park
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Restaurant
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Temple
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Villa
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Beach
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Formal Garden
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Golf Club
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Hall
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Vineyard
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Other
										</label>
									</li>
								</ul>
							</div>
							<!--?php echo Html::dropDownList('VenueSearch[vibe_id][]',$searchModel->vibe_id,$vibe->getList(),['placeholder' => 'Wedding Vibe',  'class' => 'multiple drop_lg filter_field','multiple'=>'multiple'])?-->
							<div class="multiselect_box">
								<span>Wedding Vibe</span>
								<ul class="drop_bottom">
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Select All
										</label>
										<label class="checkbox-inline">
											<input type="checkbox" />One Event Per Day
										</label>
										<label class="checkbox-inline">
											<input type="checkbox" />Multiple Weddings Per Day
										</label>
										<label class="checkbox-inline">
											<input type="checkbox" />Chapel
										</label>
										<label class="checkbox-inline">
											<input type="checkbox" />Gazebo
										</label>
										<label class="checkbox-inline">
											<input type="checkbox" />Beach Wedding Location – Private
										</label>
										<label class="checkbox-inline">
											<input type="checkbox" />Beach Wedding Location – Public
										</label>
										<label class="checkbox-inline">
											<input type="checkbox" />Cliff Wedding Location
										</label>
										<label class="checkbox-inline">
											<input type="checkbox" />Garden Wedding Location
										</label>
										<label class="checkbox-inline">
											<input type="checkbox" />Oceanview Wedding Location
										</label>
										<label class="checkbox-inline">
											<input type="checkbox" />Outdoor Reception Location
										</label>
										<label class="checkbox-inline">
											<input type="checkbox" />Ruin Wedding Location
										</label>
										<label class="checkbox-inline">
											<input type="checkbox" />Terrace Wedding Location
										</label>
										<label class="checkbox-inline">
											<input type="checkbox" />Ballroom
										</label>
										<label class="checkbox-inline">
											<input type="checkbox" />Adults Only
										</label>
										<label class="checkbox-inline">
											<input type="checkbox" />Gay Friendly
										</label>
										<label class="checkbox-inline">
											<input type="checkbox" />Family Friendly
										</label>
										<label class="checkbox-inline">
											<input type="checkbox" />Non-guests may attend with Daypass
										</label>
										<label class="checkbox-inline">
											<input type="checkbox" />Non-guests may not attend
										</label>
										<label class="checkbox-inline">
											<input type="checkbox" />Venue will host non-guest events
										</label>
									</li>
								</ul>
							</div>
							<!--?php echo Html::dropDownList('VenueSearch[service_id][]',$searchModel->service_id,$type->getList(),['placeholder' => 'Venue provides', 'class'  => 'multiple filter_field','multiple' => 'multiple'])?-->
							<div class="multiselect_box">
								<span>Venue provides</span>
								<ul class="drop_bottom">
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Select All
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />All-inclusive Resort
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Resort
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Boutique
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Castle
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Cathedral
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Chateau
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Church
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Estate
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Hotel
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Outdoor Venue
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Park
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Restaurant
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Temple
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Villa
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Beach
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Formal Garden
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Golf Club
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Hall
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Vineyard
										</label>
									</li>
									<li>
										<label class="checkbox-inline">
											<input type="checkbox" />Other
										</label>
									</li>
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
			$('.multiple').multipleSelect({});
			$('.grid-view table tr').on('click',function(){
				$('.grid-view table tr').removeClass('active');
				$(this).addClass('active');
				get_menu($(this).attr('data-key'));
			})
			$('.filter_field').on('change',function(){
				$('.venue_filter').submit();
			})
		});
		$('body').on('submit', 'form.event-filter', function(e) {

			e.preventDefault();

		});
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