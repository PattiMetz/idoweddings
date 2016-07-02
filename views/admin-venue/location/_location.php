<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\BaseHtml;
use yii\data\ArrayDataProvider;

$days = array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
?>
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
