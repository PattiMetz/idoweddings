<div class="header_sm">
	<nav class="navbar_sm">
		<div class="mob_btn"></div>
		<ul class="gen_menu">
			<?php foreach($pages as $page){?>
				<li <?php if ($page->type=='locations'){?>class="sublist"<?php }?>>
					<a href="#"><?php echo $page->name?></a>
					<?php if ($page->type == 'locations'){?>
						<ul class="sub_menu">
							<?php foreach($page->groups as $group) {?>
								<li class="secsublist">
									<a href="#"><?php echo $group->name;?></a>
									<ul class="secsub_menu">
										<?php foreach($group->locations as $location){?>
											<li><a href="venue_location.html"><?php echo $location->name?></a></li>
										<?php }?>
									</ul>
								</li>
							<?php }?>
						</ul>
						<?php }?>
				</li>
			<?php }?>
			
			
		</ul>
	</nav>
</div>