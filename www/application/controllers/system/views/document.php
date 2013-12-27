<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title><?=$page_title?></title>
	<?=$page_icon?>
	<?=$page_meta?>
	<?=$page_css?>
</head>
<body>

<?=$page_content?>

<?=$page_js?>
<script type="text/javascript">
$(function( ) {
	var module, cname = '<?=$page_module?>';

	if ( window.hasOwnProperty( 'app' ) == false ) window.app = { };

	if ( app[ cname ] ) {
		module = new app[ cname ]( );
	}
	else {
		module = new app.SystemModule( );
	}

	module.hookUp( );
	module.bindEventListeners( );
});
</script>

</body>
</html>
