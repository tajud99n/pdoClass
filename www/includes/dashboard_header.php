<!DOCTYPE html>
<html>
<head>
    <title><?php echo $page_title ?></title>
	<link rel="stylesheet" type="text/css" href="styles/styles.css">
</head>

<body>
	<section>
		<div class="mast">
			<h1>T<span>SSB</span></h1>
			<nav>
				<ul class="clearfix">
					<li><a href="add_category.php" <?php curNave('add_category.php')?>>add category</a></li>
					<li><a href="view_category.php" <?php curNave('view_category.php')?>>view category</a></li>
					<li><a href="add_products.php"  <?php curNave('add_products.php')?>>add products</a></li>
					<li><a href="view_products.php" <?php curNave('view_products.php')?>>view products</a></li>
					<li><a href="logout.php">logout</a></li>
				</ul>
			</nav>
		</div>
	</section>
