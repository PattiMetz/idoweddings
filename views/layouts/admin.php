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
	<title><?php echo Html::encode(isset($this->params['title'])?$this->params['title']:$this->title); ?></title>
	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody(); ?>

<div id="preloader" style="display: none;">
	<img src="../../web/images/preloader.gif" />
</div>

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
			<li class="item_2"><a href="#">Schedule</a></li>
			<li class="item_3"><a href="#">Customers</a></li>
			<li class="item_4"><a href="#">Inquiries</a></li>
			<li class="item_5"><a href="#">To do</a></li>
			<li class="item_6"><a href="#">Pending Answers</a></li>
			<li class="item_7"><a href="#">Messages</a></li>
			<li class="item_8"><a href="#">Quotes</a></li>
			<li class="item_9"><a href="#">Invoices</a></li>
			<li class="item_10<?php echo (Yii::$app->controller->id == 'admin-venue') ? ' active' : ''; ?>"><a href="<?php echo Url::to(['admin-venue/index']); ?>">Venues</a></li>
			<li class="item_11 <?php echo (Yii::$app->controller->id == 'admin-vendor') ? 'active' : ''; ?>">
				<a href="<?= Url::to(['admin-vendor/index']) ?>">Vendors</a>
			</li>
			<li class="item_12"><a href="#">Agencies</a></li>
			<li class="item_13 <?php echo (Yii::$app->controller->id == 'admin-knowledgebases') ? 'active' : ''; ?>"><a href="<?php echo Url::to(['admin-knowledgebases/index']); ?>">Knowledge Base</a></li>
			<li class="item_14"><a href="#">Reports</a></li>
			<li class="item_15 <?php echo (Yii::$app->controller->id == 'admin-maincompany') ? 'active' : ''; ?>">
				<a href="<?= Url::to(['admin-maincompany/update']) ?>">Our Profile</a>
			</li>
			<li class="item_16"><a href="#">Our Packages</a></li>
			<li class="item_17"><a href="#">Our Items</a></li>
			<?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->hasPrivilegeByName('usermanager')): ?>
				<li class="item_18 <?php echo (Yii::$app->controller->id == 'admin-user-manager') ? 'active' : ''; ?>"><a href="<?php echo Url::to(['admin-user-manager/index']); ?>">User Manager</a></li>
			<?php endif; ?>
			<li class="item_19 <?php echo (Yii::$app->controller->id == 'admin-mastertable') ? 'active' : ''; ?>"><a href="<?php echo Url::to(['admin-mastertable/index']); ?>">Mastertable</a></li>
		</ul>
	</div>
	<header>
		<div class="header">
			<div class="container">
				<div class="row">
					<div class="col-md-12 clearfix">
						<div class="col-md-6 col-sm-6 col-xs-12 clearfix">
							<div class="admin_info">
								<?php if (Yii::$app->user->isGuest): ?>
									<span>Guest</span>
								<?php else: ?>
									<span>&lt;COMPANY&gt;</span>
									<span>&lt;ROLE&gt;</span>
									<span id="pos_name"><?php echo Html::encode(Yii::$app->user->identity->display_name); ?></span>
								<?php endif; ?>
							</div>
							<nav class="navbar clearfix">
								<ul class="nav">
									<li><a href="#">Support</a></li>
									<?php if (Yii::$app->user->isGuest): ?>
										<li><a href="<?php echo Url::to(Yii::$app->user->loginUrl); ?>">Login</a></li>
									<?php else: ?>
										<li><a href="#">My account</a></li>
										<li><a href="<?php echo Url::to(['admin/logout']); ?>" data-method="post">Log Out</a></li>
									<?php endif; ?>
								</ul>
								<a class="mob_btn clicked"></a>
							</nav>
						</div>
						<div class="main_title col-md-3 col-sm-3 col-xs-6">
							<p id="section_title"><?php echo Html::encode(@$this->params['section_title']); ?></p>
							<p id="subtitle"><?php echo Html::encode($this->title); ?></p>
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

	$js = 'jQuery("#subtitle").html("' . Html::encode($this->title) . '");';

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
