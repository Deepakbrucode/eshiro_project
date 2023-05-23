        <!-- BEGIN HEADER -->
        <?php if(!isset($_SESSION['id']) || $_SESSION['id'] == '') {redirect(BASE_URL.'login');}  ?>
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner ">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="index.html">
                        <img src="<?php echo BASE_URL;?>images/eshirologo.png" alt="logo" class="logo-default" style="width:120px;    margin-top: 7px; "/> </a>
                    <div class="menu-toggler sidebar-toggler">
                        <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
                    </div>
                </div>
                <!-- END LOGO -->
                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
                <!-- END RESPONSIVE MENU TOGGLER -->

                <!-- BEGIN PAGE TOP -->
                <div class="page-top">
<?php if($_SESSION['usertype']==5) {?>

<?php if(isset($_SESSION['filtered_client_id']) && $_SESSION['filtered_client_id'] != '') { ?>
<p style="display: inline-block;padding-top:5px;padding-left: 17px;">Client Name: <b><?php echo $_SESSION['filtered_client_name']; ?></b>  <a href="<?php echo BASE_URL; ?>client/edit?client_id=<?php echo $_SESSION['filtered_client_id']; ?>">Edit Client Details</a></p>
<?php } ?>
<?php } 
if(isset($showtopsave))
{
   ?>
   <button type="button" name="" class="btn btn-warning btn_saveinvcostop" style="width: 300px;margin: 14px;">Save Analysed Data</button>
   <?php
}?>



                    <!-- BEGIN HEADER SEARCH BOX -->
                    <!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
                    <!-- <form class="search-form search-form-expanded" action="" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search..." name="query">
                            <span class="input-group-btn">
                                <a href="javascript:;" class="btn submit">
                                    <i class="icon-magnifier"></i>
                                </a>
                            </span>
                        </div>
                    </form> -->
                    <!-- END HEADER SEARCH BOX -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        
                        <ul class="nav navbar-nav pull-right">
                           
                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                            <li class="dropdown dropdown-user">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
<!--
                                    <img alt="" class="img-circle" src="<?php echo BASE_URL;?>images/avatar.png" />
-->
                                    <span class="username username-hide-on-mobile"> <b><?php //print_r ($_SESSION);
                                    echo $_SESSION['filtered_client_name1']; ?></b>  </span>
                                    <i class="fa fa-angle-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    <li>
										<?php if($_SESSION['usertype']==5) {?>
                                         <a href="<?php echo BASE_URL; ?>dashboard/profile">
                                         <?php } else { ?>
                                         <a href="<?php echo BASE_URL; ?>client/edit?id=<?php echo $_SESSION['id']; ?>">
                                         <?php }?>
                                            <i class="icon-user"></i> My Profile </a>
                                    </li>
                                    
                                    <li>
                                        <a href="<?php echo BASE_URL; ?>login/logout">
                                            <i class="icon-key"></i> Log Out </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
                <!-- END PAGE TOP -->
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
