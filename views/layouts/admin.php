<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AdminAsset;
use yii\bootstrap\Modal;
use yii\bootstrap\Alert;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;

AdminAsset::register($this);

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language; ?>">
<head>
	<meta charset="<?echo Yii::$app->charset; ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php echo Html::csrfMetaTags(); ?>
	<title><?php echo Html::encode($this->title); ?></title>
	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody(); ?>

<?php

Modal::begin([
	'id' => 'modal'
]);

?>

<div class="loading" style="display: none;">Loading...</div>

<div class="ajax-content" style="display: none;"></div>

<div class="error" style="display: none;">

	<div class="pseudo_head">
		<h4 class="modal-title">Error Loading</h4>
	</div>

	<?php

	echo Alert::widget([
		'options' => [
			'class' => 'alert-danger'
		],
		'body' => '',
		'closeButton' => false,
	]);

	?>

</div>

<div class="confirm" style="display: none;">

	<div class="pseudo_head">
		<h4 class="modal-title">Confirm</h4>
	</div>

	<div class="confirm-message">Are you sure?</div>

	<?php ActiveForm::begin(['options' => ['class' => 'confirm-form']]); ?>

	<div class="form-group">
		<?php echo Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
		<?php echo Html::Button('Cancel', ['class' => 'btn btn-default btn-cancel']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>

<?php

Modal::end();

?>

<div class="main_wrapper">
	<div class="left_panel">
		<a href="#" class="logo"></a>
		<span>Admin Area</span>
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
			<li class="item_11"><a href="#">Venues</a></li>
			<li class="item_12"><a href="#">Vendors</a></li>
			<li class="item_13"><a href="#">Locations</a></li>
			<li class="item_14"><a href="#">Pricing</a></li>
			<li class="item_15 <?php echo (Yii::$app->controller->id == 'admin-knowledgebases') ? 'active' : ''; ?>"><a href="<?php echo Url::to(['admin-knowledgebases/index']); ?>" id="it_15">Knowledge Base</a></li>
			<li class="item_16"><a href="#">Reports</a></li>
			<li class="item_17"><a href="#">Webs</a></li>
			<li class="item_18"><a href="#">Settings</a></li>
			<li class="item_19"><a href="#">User Manager</a></li>
			<li class="item_20"><a href="#">Companies</a></li>
			<li class="item_21" <?php echo (Yii::$app->controller->id == 'admin-kmastertable') ? 'active' : ''; ?>><a href="<?php echo Url::to(['admin-mastertable	/index']); ?>">Mastertable</a></li>
		</ul>
	</div>
	<header>
		<div class="header">
			<div class="container">
				<div class="row">
					<div class="col-md-12 clearfix">
						<div class="col-md-6 col-sm-6 col-xs-12 clearfix">
							<div class="admin_info">
								<span>WOMI</span>
								<span>Admin</span>
								<span id="pos_name">Patti Metzger</span>
							</div>
							<nav class="navbar clearfix">
								<ul class="nav">
									<li><a href="#">Support</a></li>
									<li><a href="#">My account</a></li>
									<li><a href="#">Log Out</a></li>
								</ul>
								<a class="mob_btn clicked"></a>
							</nav>
						</div>
						<div class="main_title col-md-3 col-sm-3 col-xs-6">
							<p id="section_title"><?php echo Html::encode(@$this->params['section_title']); ?></p>
							<p id="title"><?php echo Html::encode($this->title); ?></p>
						</div>
						<div class="col-md-1"></div>
						<div class="col-md-2 col-sm-3 col-xs-6">
							<span>Admin Area</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<section id="base">
		<div class="main_base">
			<div class="container">
				<div class="row">
					<!--div id="main"-->
					<?php Pjax::begin(['id' => 'main']) ?>

						<?php echo $content; ?>

<?php

if (Yii::$app->request->isAjax) {

	$js = 'jQuery("#title").html("' . Html::encode($this->title) . '");';

	$this->registerJS($js);

}

if (isset($this->params['js'])) {

	$this->registerJS($this->params['js']);

}

?>

					<?php Pjax::end() ?>
					<!--/div-->
				</div>
			</div>
		</div>
	</section>
</div>

<footer>
	<div class="footer">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="col-md-4 col-sm-6">
						<span>Copyright &copy 2016 Idoweddings.com</span>
					</div>
					<div class="col-md-4 col-sm-6">
						<span>Destination Wedding Specials</span>
					</div>
					<div class="col-md-4 col-sm-12">
						<span>Powered by <a href="#" class="foo_logo"></a></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
