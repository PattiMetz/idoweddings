<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\BaseHtml;
use yii\data\ArrayDataProvider;

$days = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
?>

<?php echo $model->name?>
		<?php
			echo Html::a('Edit', 
				 Url::to(['/admin/venue-location/location', 'id' => $model->id]),
				['class' => 'btn btn-danger'
			]);
		?>
		<?php
			echo Html::button('Delete', [
				'value' => Url::to(['/admin/venue-location/location-delete', 'id' => $model->id]),
				'class' => 'btn btn-danger  modal-ajax'
			]);
		?>

<div class="panel panel-default">
				<div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse1">
					<h4 class="panel-title">
						<a class="text-success"><?php echo $model->name?></a>
					</h4>
				</div>
				<div id="collapse1" class="panel-collapse collapse">
					<div class="panel-body">
						<div class="inner_collapse_sett_panel clearfix">
							<p>Guest capacity <span><?php echo $model->guest_capacity?></span></p>
						
							<?php
								echo Html::a('<i class="glyphicon glyphicon-pencil"></i> Edit', 
									 Url::to(['/admin/venue-location/location', 'id' => $model->id]),
									['class' => 'btn btn-primary'
								]);
							?>
							<?php
								echo Html::button('<i class="glyphicon glyphicon-close"></i>Delete', [
									'value' => Url::to(['/admin/venue-location/location-delete', 'id' => $model->id]),
									'class' => 'btn btn-primary  modal-ajax'
								]);
							?>
						</div>
						<div class="col-md-6">
							<p>Description</p>
							<div class="bordered_box">
								<?php echo $model->description?>
							</div>
							
							<?php if(is_array($model->images)) {?>
								<ul class="image_list list-inline">
								<?php foreach($model->images as $image) {?>
									<li><?=Html::img("/uploads/venue/".$model->group->venue_id."/location/thumb/".$image->image)?>
									</li>
								<?php }?>
							</ul>

							<?php }?>
						</div>
						<div class="col-md-6">
							<p>Available Time slots</p>
							<div class="bordered_box">
								<?php if(is_array($model->times)) {
									foreach($model->times as $stime) {?>
										<span class="time_slot"><?php echo $stime->time_from?> - <?php echo $stime->time_to?></span>
										<div class="text-center">
											<ul class="timeslot_list list-inline">
												<?php echo Html::checkboxList('days_array',$stime->days_array, $days,[
													'disabled' => 'disabled',
													 'items' =>
										                function ($index, $label, $name, $checked, $value) {
										                    return Html::checkbox($name, $checked, [
										                        'value' => $value,
										                        
										                        'labelOptions' => [
										                            'class' => 'heckbox-inline',
										                        ],
										                    ]);
										                },
                 
													'template'=>'<li>{input}{label}</li>']) ?>
												</ul>
										</div>	
									<?php }
								}?>

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






<div class="location" style="">
	<div class="top">
		<?php echo $model->name?>
		<?php
			echo Html::a('Edit', 
				 Url::to(['/admin/venue-location/location', 'id' => $model->id]),
				['class' => 'btn btn-danger'
			]);
		?>
		<?php
			echo Html::button('Delete', [
				'value' => Url::to(['/admin/venue-location/location-delete', 'id' => $model->id]),
				'class' => 'btn btn-danger  modal-ajax'
			]);
		?>
		
	</div>
	<div>
		<?php echo $model->description?>
	</div>
	<div>
		<label>Guest Capacity</label><?php echo $model->guest_capacity?>
	</div>
	<div class="timeslots">
		<?php if(is_array($model->times)) {
			foreach($model->times as $stime) {?>
				<div class="col-sm-12 time">
					<div class="col-sm-3">
						<?php echo $stime->time_from?> - <?php echo $stime->time_to?>
					</div>
					<div class="col-sm-4">
						<?php echo Html::checkboxList('days_array',$stime->days_array, $days,['disabled'=>'disabled']) ?>
					</div>
					
				</div>
			<?php }
		}?>
	</div>
	<div class="images">
		<?php if(is_array($model->images)) {?>
			<ul style="width:100%;float:left">
			<?php foreach($model->images as $image) {?>
				<li style="float:left"><?=Html::img("/uploads/venue/".$model->group->venue_id."/location/thumb/".$image->image)?>
				</li>
			<?php }?>
		</ul>

		<?php }?>
	</div>
</div>
