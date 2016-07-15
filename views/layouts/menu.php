<?php
	use yii\helpers\Url;
?>
<ul class="item_list">
	<li class="item_1"><a href="#">Dashboard</a></li>
	<li class="item_2"><a href="#">Availability Calendar</a></li>
	<li class="item_3"><a href="#">Schedule</a></li>
	<li class="item_4"><a href="#">Customers</a></li>
	<li class="item_5"><a href="#">Inquiries</a></li>
	<li class="item_6"><a href="#">To do</a></li>
	<li class="item_7"><a href="#">Pending Answers</a></li>
	<li class="item_8"><a href="#">Messages</a></li>
	<li class="item_9"><a href="#">Quotes</a></li>
	<li class="item_10"><a href="#">Invoices</a></li>
	<li class="item_11<?php echo (Yii::$app->controller->id == 'admin-venue') ? ' active' : ''; ?>"><a href="<?php echo Url::to(['admin-venue/index']); ?>">Venues</a></li>
	<li class="item_12"><a href="#">Vendors</a></li>
	<li class="item_13"><a href="#">Locations</a></li>
	<li class="item_14"><a href="#">Pricing</a></li>
	<li class="item_15 <?php echo (Yii::$app->controller->id == 'admin-knowledgebases') ? 'active' : ''; ?>"><a href="<?php echo Url::to(['admin-knowledgebases/index']); ?>" id="it_15">Knowledge Base</a></li>
	<li class="item_16"><a href="#">Reports</a></li>
	<li class="item_17"><a href="#">Webs</a></li>
	<li class="item_18"><a href="#">Settings</a></li>
	<li class="item_19"><a href="#">User Manager</a></li>
	<li class="item_20"><a href="#">Companies</a></li>
	<li class="item_21 <?php echo (Yii::$app->controller->id == 'admin-mastertable') ? 'active' : ''; ?>"><a href="<?php echo Url::to(['admin-mastertable/index']); ?>">Mastertable</a></li>
</ul>