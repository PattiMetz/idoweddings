<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

?>
<ul class="list">
	<li><?= Html::a("Regions", ['region-list']) ?></li>
	<li><?= Html::a("Destinations", ['destination-list']) ?></li>
	<li><?= Html::a("Locations", ['location-list']) ?></li>
	<li><?= Html::a("Countries", ['country-list']) ?></li>
	<li><?= Html::a("Currencies", ['currency-list']) ?></li>
	<li><?= Html::a("Languages", ['language-list']) ?></li>
	<li><?= Html::a("Venue types", ['venuetype-list']) ?></li>
	<li><?= Html::a("Wedding Vibe", ['vibe-list']) ?></li>
	<li><?= Html::a("Venue Provides", ['venueservice-list']) ?></li>
</ul>
