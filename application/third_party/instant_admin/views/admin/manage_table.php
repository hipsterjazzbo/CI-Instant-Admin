<!DOCTYPE html>
<html>
<head>
	<title><?= $page_configs[$page]['name'] ?></title>
</head>
<body>
	<p>Elapsed Time: {elapsed_time}</p>
	<p>Memory Usage: {memory_usage}</p>
	
	<h1>Menu</h1>
	<ul>
	<?php foreach($page_configs as $page => $config): ?>
		<li><a href="<?= site_url('admin/' . $page) ?>"><?= $config['name'] ?></a></li>
	<?php endforeach; ?>
	</ul>
	
	<h1>Admin Config</h1>
	<pre>
		<?php var_dump($page_configs); ?>
	</pre>
	
	<h1>Page config:</h1>
	<pre>
		<?php var_dump($page_configs[$page]); ?>
	</pre>
	
	<h1>Data</h1>
	<pre>
		<?php var_dump($data); ?>
	</pre>
</body>
</html>