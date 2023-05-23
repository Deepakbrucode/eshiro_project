 <!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-users"></i>
                    <a href="#"><?php echo $title_txt; ?></a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span><?php echo $formname." ".$title_txt; ?></span>
                </li>
            </ul>
        </div>
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light portlet-fit  calendar">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-equalizer font-red-sunglo"></i>
                                        <span class="caption-subject font-red-sunglo bold uppercase"><?php echo $formname." ".$title_txt; ?> </span>
                                        <span class="caption-helper"><?php echo $formname." ".$title_txt; ?> details</span>
                                    </div>

                                </div>
                                <?php  
                                    if($InvClientDetail)
                                    {
                                        foreach ($InvClientDetail as $value) {
                                            $client_id = $value->id;
                                            $firm_name = $value->name;
                                            $emailid = $value->email;
                                            $mobile = $value->phone;
                                            $address1 = $value->address1;
                                            $address2 = $value->address2;
                                            $zip_code = $value->zip_code;
                                            $trading_name = $value->trading_name;
                                            $vat_no = $value->vat_no;
                                            $status = $value->status;
                                            $suser_id = $value->user_id;
                                            // $start_month = $value->financial_month_start;
                                            // $end_month = $value->financial_month_end;
                                        }
                                    }
                                    else
                                    {
                                        $client_id = '';
                                        $firm_name = '';
                                        $emailid='';
                                        $mobile='';
                                        $directors = '';
                                        $address1 = '';
                                        $address2 = '';
                                        $zip_code = '';
                                        $trading_name = '';
                                        $vat_no = '';
                                        $status = '1';
                                        $suser_id = $user_id;
                                        // $start_month = '3';
                                        // $end_month = '2';
                                    }
                                ?>
                                <div class="portlet-body form">
                                    <?php echo $this->session->flashdata('invoicing'); ?>
                                    <!-- BEGIN FORM-->
                                    <form action="<?php echo BASE_URL;?>invoicing/<?php echo $form_action; ?>" method="post" class="form-horizontal">
                                        <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
                                        <input type="hidden" name="usertype_new" value="<?php echo $usertype_new; ?>">
                                        <input type="hidden" name="redirect_url" value="<?php echo $redirect_url; ?>">
                                        <div class="form-body">

                                        <?php if($usertype == '5') { ?>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Client name</label>
                                                <div class="col-md-4">
                                                    <select name="user_id" class="form-control">
                                                    <?php if($ClientDetails){
                                                        foreach($ClientDetails as $ClientDetail) { 
                                                            $selected = ($suser_id == $ClientDetail->id)?'selected':'';
                                                        echo "<option value='".$ClientDetail->id."' ".$selected.">".$ClientDetail->name."</option>";

                                                     } } else {echo "<option value=''>No clients Available</option>";} ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <input type="hidden" name="user_id" value="<?php echo $suser_id; ?>">
                                        <?php } ?>


                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Name</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="firm_name" class="form-control" placeholder="Name" value="<?php echo $firm_name; ?>" required>
                                                    <!--  <span class="help-block"> A block of help text. </span> -->
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Email</label>
                                                <div class="col-md-4">
                                                    <input type="email" name="emailid" class="form-control" placeholder="Email" value="<?php echo $emailid; ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Phone</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="phone" class="form-control" placeholder="Phone No" value="<?php echo $mobile; ?>" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Address Line1</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="address1" class="form-control" placeholder="Address Line1" value="<?php echo $address1; ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Address Line2</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="address2" class="form-control" placeholder="Address  Line2" value="<?php echo $address2; ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Zip Code</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="zip_code" class="form-control" placeholder="Zip Code" value="<?php echo $zip_code; ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Trading_name or Other name</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="trading_name" placeholder="Trading_name or Other name" value="<?php echo $trading_name; ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">VAT No</label>
                                                <div class="col-md-4">
                                                    <input type="text" pattern="\d*" maxlength="10" minlength="10" class="form-control" name="vat_no" placeholder="VAT No" value="<?php echo $vat_no; ?>" >
                                                </div>
                                            </div>
                                                      
						                    <?php if(($_SESSION['usertype'])== 5) { ?>
							                <div class="form-group">
							                    <label class="col-md-3 control-label">Admin Approval</label>
							                   <div class="col-md-4">
			                                         <label><input type="radio" name="status"  value="1" <?php echo ($status == '1')?'checked':''; ?> >Active</label>
			                                        <label><input type="radio" name="status"  value="0" <?php echo ($status == '0')?'checked':''; ?> >In-Active</label>
							                    </div>
							                </div> 
							                <?php } else {?>
									        <input type="hidden" name="status" value="<?php echo $status; ?>">
								            <?php } ?>
                                        </div>
                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="submit" class="btn green"><?php echo $formname." ".$title_txt; ?></button>
                                                    <?php if(($_SESSION['usertype'])== 5){ ?>
                                                    <button type="button" class="btn default"><a href="<?php echo BASE_URL; ?>invoicing/<?php echo $cancel_url; ?>">Cancel</a></button>
                                                    <?php } else { ?>
													<button type="button" class="btn default"><a href="<?php echo BASE_URL; ?>invoicing/index">Cancel</a></button>
													<?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END FORM-->
                                 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->

            
    
