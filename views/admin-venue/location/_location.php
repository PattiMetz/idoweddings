<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\BaseHtml;
use yii\data\ArrayDataProvider;

$days = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
?>


<div class="panel panel-default">
	<div class="panel-heading collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $model->id;?>">
		<h4 class="panel-title">
			<a class="text-success"><?php echo $model->name?></a>
		</h4>
	</div>
	<div id="collapse<?php echo $model->id;?>" class="panel-collapse collapse">
		<div class="panel-body">
			<div class="inner_collapse_sett_panel clearfix">
				<p>Guest capacity <span><?php echo $model->guest_capacity?></span></p>
			
				<?php
					echo Html::a('<i class="glyphicon glyphicon-pencil"></i> Edit', 
						 Url::to(['/admin/venue-location/location', 'id' => $model->id]),
						['class' => 'btn btn-primary','data-pjax' => 0]);
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
				<?php } else {?>
					<img src="/img/noimage.png"/>
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
										'tag'=>'li',
										'separator'=>'</li><li>',
										'item' =>
							                function ($index, $label, $name, $checked, $value) {
							                    return Html::checkbox($name, $checked, [
										                        'value' => $value,
										                        'disabled'=>'disabled',
										                        'label' => '<label for="' . $label . '">' . $label . '</label>',
										                        'labelOptions' => [
										                            'class' => 'checkbox-inline',
										                        ],
										                        //'id' => $label,
										                    ]);
							                }]) ?>
									</ul>
							</div>	
						<?php }
					}?>
				</div>
				
			</div>
		</div>
	</div>
</div>
