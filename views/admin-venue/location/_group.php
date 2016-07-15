<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\BaseHtml;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
use app\models\venue\VenueLocation;
use app\models\venue\VenueLocationGroup;
?>

<div class="sett_block_wrap">
	<span><?php echo ucfirst($model->name)?>
		<?php if($model->one_event){?>
			<div class="btn" style="float:right;background-color:#ece1df;color:#ae8082;border-radius:5px;border:solid 1px #e2d4d4;margin-top:-5px">Only one event per time slot</div>
		<?php }?>
	</span>
	<?php
		echo Html::a('Add location', [
			Url::to(['/admin/venue-location/location', 'group_id' => $model->id])],
			['class' => 'btn btn-danger', 'data-pjax'=>0]
		);
	?>
	<?php
		echo Html::button('<i class="glyphicon glyphicon-pencil"></i> Rename', [
			'value' => Url::to(['/admin/venue-location/group', 'id' => $model->id]),
			'class' => 'btn btn-primary modal-ajax'
		]);
	?>
	<?php
		echo Html::button('<i class="glyphicon glyphicon-close"></i> Delete', [
			'value' => Url::to(['/admin/venue-location/group-delete', 'id' => $model->id]),
			'class' => 'btn btn-primary  modal-ajax'
		]);
	?>
	
	<div class="panel-group" id="accordion">
		
		<?php $id = $model->id;?>
		<?php $dataProvider2 = new ActiveDataProvider([
            'query' => VenueLocation::find()->where(['group_id'=>$id]),
        ]);?>
	    <?php
	        echo ListView::widget([
	            'dataProvider' => $dataProvider2,
	            'layout' => "{items}",
	            'itemView' => '_location',
	        ]);
	    ?>
	
	</div>
</div>