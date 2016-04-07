<nav class="navbar navbar-default" role="navigation">

	<!--<div class="container">-->
		
		<ul class="nav navbar-nav">

<!--			<li><a href="#" class="navbar-brand"><img src="../images/ctree_logo_small.png"></a></li>-->
			<li><img src="../images/ctree_logo_small_2.png" class="navbar-brand"></li>
			<li><a href="?page=dashboard">Dashboard</a></li>
			<li><a href="?page=pages">Pages</a></li>
			<li><a href="?page=users">Users</a></li>
			<li><a href="?page=navigation">Navigation</a></li>
			<li><a href="?page=settings">Settings</a></li>
			
		</ul>
		
		<div class="pull-right">
		
			<ul class="nav navbar-nav">
				
				<li>
						<?php if($debug == 1) { ?>
							<button type="button" id="btn-debug" class="btn btn-default navbar-btn"><i class="fa fa-bug"></i></button>
						<?php } ?>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $user['fullname']; ?><span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="logout.php">Log Out</a></li>
					</ul>
				</li>
				
			</ul>
		
		</div>
<!--	</div>-->
</nav><!-- End nav -->