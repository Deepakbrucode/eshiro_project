<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
	<title><?php echo $title.' | '.$site_title;?></title>
	
	<link rel="shortcut icon" href="<?php echo IMG_PATH;?>favicon1.ico"/>

	<?php if(isset($headerfiles)){
		echo include_files($headerfiles, 'header');
	}
	?>
	<!--Fonts-->
	<link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;subset=latin,cyrillic'
		  rel='stylesheet' type='text/css'/>




</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
