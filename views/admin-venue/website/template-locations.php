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
			.animate_btn .glyphicon:before{
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
				<?php echo $this->render('menu', ['pages' => $venue->pages]);?>
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
											<i class="edit_btn"></i><span contenteditable="" id="button">Let's Say "I Do" Here</span>
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
				<div class="menu_panel bg_col">
					<?php $groups = $model->getGroups();?>
					<ul class="list-inline default_list">
						<?php foreach($groups as $group) {?>
							
							<?php $active_group = isset($active_group)?$active_group:$group;?>
							<li><a class="ellipse <?php if($group->id == $active_group->id){?> active<?php }?>" data-id="<?php echo $group->id;?>"><?php echo $group->name?></a></li>
						<?php }?>
					</ul>
				</div>
				<div class="submenu_panel">
					<?php foreach($groups as $group) {?>
						<ul class="list-inline default_list group_<?php echo $group->id;?> group_location" <?php if($group->id != $active_group->id){?>style="display:none"<?php }?>>
							<?php foreach($group->locations as $k => $location) {?>
								<li><a href="#block_<?php echo $location->id?>" id="link_to1" class="ellipse <?php if($k==0){?>active<?php }?> aa"><?php echo $location->name?></a></li>
								<?php $active_location = isset($active_location)?$active_location:$location;?>
							<?php }?>
						</ul>
					<?php }?>
				</div>
				<div class="container">
					<div class="row">
						<?php foreach($groups as $group) {?>
							<?php foreach($group->locations as $location){?>
								<div id="block_<?php echo $location->id?>" class="loc_box <?php if($location->id == $active_location->id) {?>active<?php }?>">
									<div class="col-md-12 inner_wrap clearfix">
										<?php if($location->images) {?>
											<div class="col-md-6">
												<div class="carousel_wrapper">
													<div id="carousel-example-generic2" class="carousel slide content-carousel" data-ride="carousel" data-interval="5000">
														<div class="carousel-inner" role="listbox">
															<?php $upload_dir = "/uploads/venue/".$active_group->venue_id."/location";?>
															<?php foreach($location->images as $k=>$image) {?>
																<div class="item <?php if($k==0){?>active<?php }?>">
																	<img src="<?php echo $upload_dir.'/'.$image->id.'.'.end(explode('.', $image->image))?>" alt="img1">
																	<div class="carousel-caption"></div>
																</div>
															<?php }?>
														</div>
														<a class="left carousel-control" href="#carousel-example-generic2" role="button" data-slide="prev">
															<div class="glyphicon glyphicon-chevron-left" aria-hidden="true"></div>
															<span class="sr-only">Previous</span>
														</a>
														<a class="right carousel-control" href="#carousel-example-generic2" role="button" data-slide="next">
															<div class="glyphicon glyphicon-chevron-right" aria-hidden="true"></div>
															<span class="sr-only">Next</span>
														</a>
													</div>
												</div>
											</div>
											<div class="col-md-6">
										<?php } else {?>
											<div class="col-md-8 col-md-offset-2 inner_wrap clearfix">
										<?php }?>
										
											<h2><?php echo $location->name?></h2>
											<h3>Guest capacity - <?php echo $active_location->guest_capacity?></h3>
											<div class="block_margin35"></div>
											<?php echo $location->description?>
										</div>
									</div>
								</div>
								
								
							<?php }?>
						<?php }?>
						<div class="col-md-12">
							<p><a href="#">View availability calendar for this location</a></p>
							<div class="block_margin10"></div>
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