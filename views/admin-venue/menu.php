<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="list_wrap">
	<p>Venue <?php echo $model->name;?> Customization </p>
	<ul>
		<li><?php echo Html::a('Venues general information', [Url::to([Yii::$app->controller->id.'/update','id' => $model->id])], ['data-pjax' => 0])?></li>
		<li><?php echo Html::a('Website Customization', [Url::to([Yii::$app->controller->id.'/settings','id' => $model->id])], ['data-pjax' => 0])?></li>
		<li><?php echo Html::a('Event Locations', [Url::to(['admin-venue-location/index','venue_id' => $model->id])], ['data-pjax' => 0])?></li>
		<li><a>Availability calendar</a></li>
		<li><a>Wedding packages</a></li>
		<li><a>Wedding items</a></li>
		<li><a>Food & Beverages</a></li>
		<li><a>FAQ's</a></li>
		<li><a>Websites</a></li>
		<li><a>Agreement</a></li>
	</ul>
</div>