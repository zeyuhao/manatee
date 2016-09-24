<?php include 'template/side.php'; ?>
<?php include 'template/navigation.php'; ?><!--Navigation here -->
<div class="container">
	<div class="panel panel-default">
		 <div class="panel-body">
			<?php include 'template/page_header.php'; ?>
			<?php if (isset($page['body_formatted'])) { echo $page['body_formatted']; } ?>
		</div><!-- End panel-body -->
	</div><!-- End panel -->
</div><!-- end container -->
