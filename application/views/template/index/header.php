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
	<div id="wrapper" class="home-page">
<div class="topbar">
  <div class="container">
    <div class="row">
      <div class="col-md-12">     
        <p class="pull-left hidden-xs"><i class="fa fa-clock-o"></i><span>Mon - Sat 8.00 - 18.00. Sunday CLOSED</span></p>
        <p class="pull-right"><i class="fa fa-phone"></i>Tel No. (+001) 123-456-789</p>
      </div>
    </div>
  </div>
</div>   
</div>
	<!--Fonts-->
	<link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&amp;subset=latin,cyrillic'
		  rel='stylesheet' type='text/css'/>

</head>
<body>

