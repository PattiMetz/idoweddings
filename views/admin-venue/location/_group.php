<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\BaseHtml;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
use app\models\venue\VenueLocation;
use app\models\venue\VenueLocationGroup;
?>
<div class="location_group">
	<div class="top">
		<?=$model->name?>
		<?php
			echo Html::button('Edit', [
				'value' => Url::to(['/admin/venue-location/group', 'id' => $model->id]),
				'class' => 'btn btn-primary modal-ajax'
			]);
		?>
		<?php
			echo Html::button('Delete', [
				'value' => Url::to(['/admin/venue-location/group-delete', 'id' => $model->id]),
				'class' => 'btn btn-primary  modal-ajax'
			]);
		?>
		<?php
			echo Html::a('Add location', [
				Url::to(['/admin/venue-location/create', 'group_id' => $model->id])],
				['class' => 'btn btn-primary']
			);
		?>
	</div>
	<div class="content">
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
