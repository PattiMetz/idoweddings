<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use app\models\venue\VenueLocationGroup;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\VenueLocation */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Venue Locations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="venue-location-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Add Group of Locations',Url::to(['/admin/venue-location/group','venue_id'=>$venue_id]),  ['class' => 'btn btn-danger modal-ajax']) ?>
    </p>
 
    <?php
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{items}\n{summary}\n{pager}",
            'itemView' => '_group',
        ]);
    ?>
    <?php /*GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'group_id',
            'name',
            'description:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);*/ ?>
	
	<div class="sett_block_wrap">
		<span>Wedding Locations</span>
		<a href="#" class="btn btn-danger">Add Location</a>
		<button class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Rename</button>
		<button class="btn btn-primary"><i class="glyphicon glyphicon-close"></i> Delete</button>
		<div class="panel-group" id="accordion">
			<div class="panel panel-default">
				<div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse1">
					<h4 class="panel-title">
						<a class="text-success">Beach</a>
					</h4>
				</div>
				<div id="collapse1" class="panel-collapse collapse">
					<div class="panel-body">
						<div class="inner_collapse_sett_panel clearfix">
							<p>Guest capacity <span>200</span></p>
							<button class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Edit</button>
							<button class="btn btn-primary"><i class="glyphicon glyphicon-close"></i> Delete</button>
						</div>
						<div class="col-md-6">
							<p>Description</p>
							<div class="bordered_box">
								<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, 
									pellentesque eu, pretium quis, sem.
								</p>
								<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, 
									pellentesque eu, pretium quis, sem.
								</p>
							</div>
							<ul class="image_list list-inline">
								<li>
									<img src="../../../web/images/venue/img1.jpg" />
								</li>
								<li>
									<img src="../../../web/images/venue/img2.jpg" />
								</li>
								<li>
									<img src="../../../web/images/venue/img3.jpg" />
								</li>
							</ul>
						</div>
						<div class="col-md-6">
							<p>Available Time slots</p>
							<div class="bordered_box">
								<span class="time_slot">2:00 pm - 4:00 pm</span>
								<div class="text-center">
									<ul class="timeslot_list list-inline">
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Mon
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Tue
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Wed
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Thu
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Fri
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Sat
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" />Sun
											</label>
										</li>
									</ul>
								</div>
							</div>
							<div class="bordered_box">
								<span class="time_slot">4:00 pm - 8:00 pm</span>
								<div class="text-center">
									<ul class="timeslot_list list-inline">
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Mon
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Tue
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Wed
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Thu
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Fri
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Sat
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" />Sun
											</label>
										</li>
									</ul>
								</div>
							</div>
							<div class="bordered_box">
								<span class="time_slot">6:00 pm - 8:00 pm</span>
								<div class="text-center">
									<ul class="timeslot_list list-inline">
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Mon
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Tue
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Wed
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Thu
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Fri
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Sat
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" />Sun
											</label>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse2">
					<h4 class="panel-title">
						<a class="text-success">Gazebo</a>
					</h4>
				</div>
				<div id="collapse2" class="panel-collapse collapse">
					<div class="panel-body">
						<div class="inner_collapse_sett_panel clearfix">
							<p>Guest capacity <span>150</span></p>
							<button class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Edit</button>
							<button class="btn btn-primary"><i class="glyphicon glyphicon-close"></i> Delete</button>
						</div>
						<div class="col-md-6">
							<p>Description</p>
							<div class="bordered_box">
								<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, 
									pellentesque eu, pretium quis, sem.
								</p>
								<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, 
									pellentesque eu, pretium quis, sem.
								</p>
							</div>
							<ul class="image_list list-inline">
								<li>
									<img src="../../../web/images/venue/no_image.jpg" />
								</li>
							</ul>
						</div>
						<div class="col-md-6">
							<p>Available Time slots</p>
							<div class="bordered_box">
								<span class="time_slot">2:00 pm - 4:00 pm</span>
								<div class="text-center">
									<ul class="timeslot_list list-inline">
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Mon
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Tue
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Wed
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Thu
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Fri
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Sat
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" />Sun
											</label>
										</li>
									</ul>
								</div>
							</div>
							<div class="bordered_box">
								<span class="time_slot">4:00 pm - 8:00 pm</span>
								<div class="text-center">
									<ul class="timeslot_list list-inline">
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Mon
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Tue
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Wed
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Thu
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Fri
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Sat
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" />Sun
											</label>
										</li>
									</ul>
								</div>
							</div>
							<div class="bordered_box">
								<span class="time_slot">6:00 pm - 8:00 pm</span>
								<div class="text-center">
									<ul class="timeslot_list list-inline">
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Mon
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Tue
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Wed
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Thu
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Fri
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Sat
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" />Sun
											</label>
										</li>
									</ul>
								</div>
							</div>
							<div class="bordered_box">
								<span class="time_slot">8:00 pm - 10:00 pm</span>
								<div class="text-center">
									<ul class="timeslot_list list-inline">
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Mon
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Tue
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Wed
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Thu
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Fri
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Sat
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" />Sun
											</label>
										</li>
									</ul>
								</div>
							</div>
							<div class="bordered_box">
								<span class="time_slot">10:00 pm - 12:00 pm</span>
								<div class="text-center">
									<ul class="timeslot_list list-inline">
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Mon
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Tue
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Wed
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Thu
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Fri
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" checked />Sat
											</label>
										</li>
										<li>
											<label class="checkbox-inline">
												<input type="checkbox" />Sun
											</label>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse3">
					<h4 class="panel-title">
						<a class="text-success">Garden</a>
					</h4>
				</div>
				<div id="collapse3" class="panel-collapse collapse">
					<div class="panel-body">
					
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="sett_block_wrap">
		<span>Reception Locations</span>
		<a href="#" class="btn btn-danger">Add Location</a>
		<button class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Rename</button>
		<button class="btn btn-primary"><i class="glyphicon glyphicon-close"></i> Delete</button>
		<div class="panel-group" id="accordion_2">
			<div class="panel panel-default">
				<div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion_2" href="#collapse1_2">
					<h4 class="panel-title">
						<a class="text-success">Restaurant A</a>
					</h4>
				</div>
				<div id="collapse1_2" class="panel-collapse collapse">
					<div class="panel-body">
					
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion_2" href="#collapse2_2">
					<h4 class="panel-title">
						<a class="text-success">Restaurant B</a>
					</h4>
				</div>
				<div id="collapse2_2" class="panel-collapse collapse">
					<div class="panel-body">
					
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="sett_block_wrap">
		<span>After Dinner Reception Locations</span>
		<a href="#" class="btn btn-danger">Add Location</a>
		<button class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Rename</button>
		<button class="btn btn-primary"><i class="glyphicon glyphicon-close"></i> Delete</button>
		<div class="panel-group" id="accordion_3">
			<div class="panel panel-default">
				<div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion_3" href="#collapse1_3">
					<h4 class="panel-title">
						<a class="text-success">Deck A</a>
					</h4>
				</div>
				<div id="collapse1_3" class="panel-collapse collapse">
					<div class="panel-body">
					
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion_3" href="#collapse2_3">
					<h4 class="panel-title">
						<a class="text-success">Deck B</a>
					</h4>
				</div>
				<div id="collapse2_3" class="panel-collapse collapse">
					<div class="panel-body">
					
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>
