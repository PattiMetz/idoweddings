<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
?>
<?php
	$exampleName = isset($exampleName)?$exampleName:'';
?>
<ul class="tabs">
	<li><?= Html::a("Regions", ['region-list'], ['class' => (($exampleName == 'region')?'active':'')]) ?></li>
	<li><?= Html::a("Destinations", ['destination-list'], ['class' => (($exampleName == 'destination')?'active':'')]) ?></li>
	<li><?= Html::a("Locations", ['location-list'], ['class' => (($exampleName == 'location')?'active':'')]) ?></li>
	<li><?= Html::a("Countries", ['country-list'], ['class' => (($exampleName == 'country')?'active':'')]) ?></li>
	<li><?= Html::a("Currencies", ['currency-list'], ['class' => (($exampleName == 'currency')?'active':'')]) ?></li>
	<li><?= Html::a("Languages", ['language-list'], ['class' => (($exampleName == 'language')?'active':'')]) ?></li>
	<li><?= Html::a("Venue types", ['venuetype-list'], ['class' => (($exampleName == 'venuetype')?'active':'')]) ?></li>
	<li><?= Html::a("Wedding Vibe", ['vibe-list'], ['class' => (($exampleName == 'vibe')?'active':'')]) ?></li>
	<li><?= Html::a("Venue Provides", ['venueservice-list'], ['class' => (($exampleName == 'venueservice')?'active':'')]) ?></li>
</ul>
<div class="top_panel clearfix">
	<div class="col-md-9 col-sm-8 col-xs-7">
		<?php echo Html::button('Add '.ucfirst($exampleName), ['value' => Url::to([Yii::$app->controller->id.'/'.$exampleName.'-update']), 'class' => 'btn btn-danger modal-ajax']); ?>

		
	</div>
	<div class="col-md-3 col-sm-4 col-xs-5">
		<form name="search" class="input-group" method="get" action="">
			<input type="text" name="search" value="<?php echo (isset($filterModel->mixedSearch)?$filterModel->mixedSearch:(isset($filterModel->name)?$filterModel->name:''));?>" class="form-control" placeholder="Search" autocomplete="off" />
			<span class="input-group-btn">
				<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-search"></span></button>
			</span>
		</form>
	</div>
</div>