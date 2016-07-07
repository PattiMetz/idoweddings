<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

?>
<ul class="list clearfix">
	<li>
		<div class="list_top"><?= Html::a("Regions", ['region-list']) ?></div>
		<div class="list_bottom item_1"></div>
	</li>
	<li>
		<div class="list_top"><?= Html::a("Destinations", ['destination-list']) ?></div>
		<div class="list_bottom item_2"></div>
	</li>
	<li>
		<div class="list_top"><?= Html::a("Locations", ['location-list']) ?></div>
		<div class="list_bottom item_3"></div>
	</li>
	<li>
		<div class="list_top"><?= Html::a("Countries", ['country-list']) ?></div>
		<div class="list_bottom item_4"></div>
	</li>
	<li>
		<div class="list_top"><?= Html::a("Currencies", ['currency-list']) ?></div>
		<div class="list_bottom item_5"></div>
	</li>
	<li>
		<div class="list_top"><?= Html::a("Languages", ['language-list']) ?></div>
		<div class="list_bottom item_6"></div>
	</li>
	<li>
		<div class="list_top"><?= Html::a("Venue types", ['venuetype-list']) ?></div>
		<div class="list_bottom item_7"></div>
	</li>
	<li>
		<div class="list_top"><?= Html::a("Wedding Vibe", ['vibe-list']) ?></div>
		<div class="list_bottom item_8"></div>
	</li>
	<li>
		<div class="list_top"><?= Html::a("Venue Provides", ['venueservice-list']) ?></div>
		<div class="list_bottom item_9"></div>
	</li>
	<li>
		<div class="list_top"><?= Html::a("Vendor Types", ['vendortype-list']) ?></div>
		<div class="list_bottom item_10"></div>
	</li>
	<li>
		<div class="list_top"><?= Html::a("Categories", ['']) ?></div>
		<div class="list_bottom item_11"></div>
	</li>
	<li>
		<div class="list_top"><?= Html::a("Package Types", ['packagetype-list']) ?></div>
		<div class="list_bottom item_12"></div>
	</li>
	<li>
		<div class="list_top"><?= Html::a("Agreements", ['agreement-list']) ?></div>
		<div class="list_bottom item_13"></div>
	</li>
</ul>
