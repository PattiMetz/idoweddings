<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Venue</title>
		<link rel="stylesheet" href="/css/bootstrap.css">
		<link rel="stylesheet" href="/css/frontend.css">
		<meta http-equiv="Content-Type" content="text/html" />
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<script type="text/javascript" src="/js/jquery-1.12.3.min.js"></script>
		<script src="/js/chosen.jquery.min.js"></script>
		<script src="/js/superfish.min.js"></script>
		<script src="/js/bootstrap.min.js"></script>
		<script src="/js/settings.js"></script>
		<meta http-equiv="Content-Type" content="text/html" />
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		
		<style>
			#venue_name {
				color:<?php echo $model->venue->website->settings['name']['color']?>;
				font-size: <?php echo $model->venue->website->settings['name']['size']?>;
				font-family: <?php echo $model->venue->website->settings['name']['font']?>;
			}
			#slogan {
				color:<?php echo $model->venue->website->settings['name']['color']?>;
			}
			#h1 {
				color:<?php echo $model->venue->website->settings['title']['color']?>;
				font-size: <?php echo $model->venue->website->settings['title']['size']?>;
				font-family: <?php echo $model->venue->website->settings['title']['font']?>;
			}
			#h2 {
				color:<?php echo $model->venue->website->settings['subtitle']['color']?>;
				font-size: <?php echo $model->venue->website->settings['subtitle']['size']?>;
				font-family: <?php echo $model->venue->website->settings['subtitle']['font']?>;
			}
			#text1, #text2 {
				color:<?php echo $model->venue->website->settings['content']['color']?>;
				font-size: <?php echo $model->venue->website->settings['content']['size']?>;
				font-family: <?php echo $model->venue->website->settings['content']['font']?>;
			}
			.navbar_sm li a {
				color:<?php echo $model->venue->website->settings['menu']['color']?>;
				font-size: <?php echo $model->venue->website->settings['menu']['size']?>;
				font-family: <?php echo $model->venue->website->settings['menu']['font']?>;
			}
			.sub_menu li a{
				color:<?php echo $model->venue->website->settings['submenu']['color']?>;
				font-size: <?php echo $model->venue->website->settings['submenu']['size']?>;
				font-family: <?php echo $model->venue->website->settings['submenu']['font']?>;
			}
			.animate_btn {
				color:<?php echo $model->venue->website->settings['button']['background']?>;
				border:3px solid <?php echo $model->venue->website->settings['button']['background']?>;
			}
			.animate_btn i:before{
				color:<?php echo $model->venue->website->settings['button']['background']?>;
			}
			.animate_btn:hover{
				background-color:<?php echo $model->venue->website->settings['button']['background']?>;
				color: <?php echo $model->venue->website->settings['button']['color']?>;
				font-size: <?php echo $model->venue->website->settings['button']['size']?>;
				font-family: <?php echo $model->venue->website->settings['button']['font']?>;
			}
		</style>
		<?php if($model->venuepagesetting->top_type == 'video') {?>
			<style>
				body {
				  background: url(<?php echo $model->venuepagesetting->video?>);
				  background-size: cover;
				}

				.bgvideo {
				  position: fixed;
				  right: 0;
				  bottom: 0;
				  min-width: 100%;
				  min-height: 100%;
				  width: auto;
				  height: auto;
				  z-index: -9999;
				}
			</style>
		<?php }?>
	</head>
	<body class="venue_page<?php if($model->venuepagesetting->top_type == 'none') {echo " type_3";}?>">
		<div class="main_wrapper">
			<header>
				<div class="header_sm">
					<nav class="navbar_sm">
						<div class="mob_btn"></div>
						<ul class="gen_menu">
							<li class="sublist">
								<a href="#">Locations</a>
								<ul class="sub_menu">
									<li class="secsublist">
										<a href="#">Wedding Locations</a>
										<ul class="secsub_menu">
											<li><a href="venue_location.html">Beach</a></li>
											<li><a href="venue_location.html">Gazebo</a></li>
											<li><a href="venue_location.html">Garden</a></li>
										</ul>
									</li>
									<li><a href="#">Reception Locations</a></li>
								</ul>
							</li>
							<li><a href="#">Availability</a></li>
							<li><a href="#">Wedding packages</a></li>
							<li><a href="#">Wedding items</a></li>
							<li><a href="#">Food & Beverages</a></li>
							<li class="sublist">
								<a href="#">Gallery</a>
								<ul class="sub_menu">
									<li><a href="#">Wedding Themes</a></li>
									<li><a href="#">Cake Gallery</a></li>
									<li><a href="#">Flower Gallery</a></li>
								</ul>
							</li>
							<li><a href="#">FAQ's</a></li>
						</ul>
					</nav>
				</div>
			</header>
			<section class="topimg_block">
				<?php if($model->venuepagesetting->top_type != 'none') {?>
					<div class="jumbotron">
						<div class="text_editor">
							<a class="edit_btn"></a>
							<h1 contenteditable id="slogan"><?php echo $model->venuepagesetting->slogan?></h1>
						</div>
					</div>
				<?php }?>
				<div class="filter_white pos_absolute">
					<div class="container">
						<div class="row">
							<div class="top_block">
								<div class="text_editor">
									<a class="edit_btn"></a>
									<span contenteditable id="venue_name"><?php echo $model->venuepagesetting->venue_name?></span>
								</div>
									<a href="#" class="animate_btn">
										<i class="glyphicon glyphicon-heart"></i>
										<div class="text_editor">
											<span contenteditable id="button">Let's Say "I Do" Here</span>
										</div>
									</a>
							</div>
						</div>
					</div>
				</div>
				<?php if($model->venuepagesetting->top_type == 'image'){?>
					<?php if(isset($model->images) && count($model->images)>0) {?> 
							<?php foreach ($model->images as $simage) {?>
								<div class="media">
									<?php echo Html::img("/uploads/venue/".$model->venue->id."/website/".$model->type."/".$simage->id.'.'.end(explode('.', $simage->image)))?>
								</div>
								<?php break;?>
							<?php }?>
						<?php }?>
				<?php }?>
				<?php if($model->venuepagesetting->top_type == 'slideshow'){?>
					<?php $active = false;?>
					<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="5000">
						<div class="carousel-inner" role="listbox">
							<?php if(isset($model->images) && count($model->images)>0) {?> 
									<?php foreach ($model->images as $simage) {?>
										<div class="item<?php if($active == false){ echo ' active';$active = true;}?>">
											<?php echo Html::img("/uploads/venue/".$model->venue->id."/website/".$model->type."/".$simage->id.'.'.end(explode('.', $simage->image)))?>
										</div>
									<?php }?>
								
							<?php }?>
							<?php $c = explode(',', $model->venuepagesetting->default_slideshow);?>
							<?php if(count($c) > 0) {?>
								<?php foreach($c as $i) {?>
									<div class="item<?php if($active == false){ echo ' active';$active = true;}?>">
										<?php echo Html::img("/images/venue/default/venue_top".$i.".jpg")?>
									</div>
								<?php }?>
							<?php }?>
						</div>
						<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
						<div class="glyphicon glyphicon-chevron-left" aria-hidden="true"></div>
						<span class="sr-only">Previous</span>
					</a>
					<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
						<div class="glyphicon glyphicon-chevron-right" aria-hidden="true"></div>
						<span class="sr-only">Next</span>
					</a>
					</div>
					
				<?php } ?>				
				<?php if($model->venuepagesetting->top_type == 'video') {?>
					<video autoplay loop muted class="bgvideo" id="bgvideo">
					   <source src="<?php echo $model->venuepagesetting->video?>" type="video/mp4"></source>
					</video>
				<?php }?>		
			</section>
			<section class="content_block">
				<div class="container">
					<div class="row">
						<div class="clearfix">
							<div class="col-md-12">
								<div class="text_editor">
									<a class="edit_btn"></a>
									<h1 contenteditable id="h1"><?php echo $model->venuepagesetting->h1?></h1>
								</div>
								<div class="block_margin10"></div>
								<div class="text_editor">
									<a class="edit_btn"></a>
									<h2 contenteditable id="h2"><?php echo $model->venuepagesetting->h2?></h2>
								</div>
								<div class="block_margin10"></div>
							</div>
						</div>
						<div class="content_left clearfix">
							<div class="col-md-6">
								<div class="text_editor">
									<a class="edit_btn"></a>
									<p contenteditable id="text1"><?php echo $model->venuepagesetting->text1?>
									</p>
								</div>
							</div>
							<div class="col-md-6">
								<div class="text_editor">
									<a class="edit_btn"></a>
									<p contenteditable id="text2"><?php echo $model->venuepagesetting->text2?>
									</p>
								</div>
							</div>
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
								<a href="#">Privacy Policy</a>
								<a href="contact_us.html">Contact Us</a>
							</div>
							<div class="col-md-4 col-sm-12">
								<span>Powered by <a href="homepage.html" class="foo_logo"></a></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>
	</body>
</html>