<!doctype html>
<html lang="en">

	<head>
		<meta charset="utf-8"/>
		<title>Dashboard Admin Panel</title>

		<link rel="stylesheet" href="<?= site_url('css/layout.css') ?>" type="text/css" media="screen" />
		<!--[if lt IE 9]>
		<link rel="stylesheet" href="<?= site_url('css/ie.css') ?>" type="text/css" media="screen" />
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<script src="<?= site_url('js/jquery-1.5.2.min.js') ?>"></script>
		<script src="<?= site_url('js/hideshow.js') ?>"></script>
		<script src="<?= site_url('js/jquery.tablesorter.min.js') ?>"></script>
		<script src="<?= site_url('js/jquery.dataTables.min.js') ?>"></script>
		<script src="<?= site_url('js/jquery.equalHeight.js') ?>"></script>
		<script>
			$(document).ready(function() { 
				$(".tablesorter").tablesorter();
				$('.datatable').dataTable({
					'sDom': '<"table-header"lf>tipr'
				});

				$('.column').equalHeight();

				$(".tab_content").hide(); //Hide all content
				$("ul.tabs li:first").addClass("active").show(); //Activate first tab
				$(".tab_content:first").show(); //Show first tab content

				//On Click Event
				$("ul.tabs li").click(function() {

					$("ul.tabs li").removeClass("active"); //Remove any "active" class
					$(this).addClass("active"); //Add "active" class to selected tab
					$(".tab_content").hide(); //Hide all tab content

					var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
					$(activeTab).fadeIn(); //Fade in the active ID content
					return false;
				});
			});
		</script>

	</head>

	<body>

		<header id="header">
			<hgroup>
				<h1 class="site_title"><a href="index.html">Lumix Admin</a></h1>
				<h2 class="section_title"><?= $page['name'] ?></h2>
			</hgroup>
		</header> <!-- end of header bar -->

		<section id="secondary_bar">
			<div class="user">
				<p>John Doe (<a href="#">3 Messages</a>)</p>
				<a class="logout_user" href="<?= site_url('admin/auth/logout') ?>" title="Logout">Logout</a> 
			</div>
			<div class="breadcrumbs_container"></div>
		</section><!-- end of secondary bar -->

		<aside id="sidebar" class="column">
			<form class="quick_search">
				<input type="text" value="Quick Search" onfocus="if(!this._haschanged){this.value=''};this._haschanged=true;">
			</form>
			<hr/>

			<?php foreach ($menu_items as $menu_item): ?>
				<h3><a href="<?= site_url('admin/' . $menu_item['slug'] . '/view') ?>"><?= $menu_item['heading'] ?></a></h3>
				<ul class="toggle">
					<?php foreach ($menu_item['items'] as $item): ?>
						<li class="icn_new_article"><a href="<?= site_url('admin/' . $menu_item['slug'] . '/' . $item->key) ?>"><?= $item->title ?></a></li>
					<?php endforeach; ?>
				</ul>
			<?php endforeach; ?>

			<h3><a href="<?= site_url('admin/auth/view') ?>">Users</a></h3>
			<ul class="toggle">
				<li class="icn_new_article"><a href="<?= site_url('admin/auth/view_users') ?>">View Users</a></li>
				<li class="icn_new_article"><a href="<?= site_url('admin/auth/add_user') ?>">Add User</a></li>
				<li class="icn_new_article"><a href="<?= site_url('admin/auth/import_users') ?>">Import Users</a></li>
				<li class="icn_new_article"><a href="<?= site_url('admin/auth/export_users') ?>">Export Users</a></li>
				<li class="icn_new_article"><a href="<?= site_url('admin/auth/print_users') ?>">Print Users</a></li>
				<li class="icn_new_article"><a href="<?= site_url('admin/auth/view_roles') ?>">View Roles</a></li>
				<li class="icn_new_article"><a href="<?= site_url('admin/auth/add_role') ?>">Add Role</a></li>
			</ul>

			<footer>
				<hr />
				<p><strong>Copyright &copy; <?= date('Y') ?> Wasabi Digital</strong></p>
			</footer>
		</aside><!-- end of sidebar -->

		<section id="main" class="column">

			<article class="module width_full">
				<?= $table ?>
			</article><!-- end of stats article -->

			<div class="spacer"></div>
		</section>


	</body>

</html>