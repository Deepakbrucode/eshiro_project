 <!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-users"></i>
                    <a href="#">Client</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span><?php echo $formname; ?> Client</span>
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
                                        <span class="caption-subject font-red-sunglo bold uppercase"><?php echo $formname; ?> Client</span>
                                        <span class="caption-helper"><?php echo $formname; ?> client details</span>
                                    </div>

                                </div>
                                <?php  
                                    if($ClientDetail)
                                    {
                                        foreach ($ClientDetail as $value) {
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
                                            $set_id = $value->set_id;
                                            $start_month = $value->financial_month_start;
                                            $end_month = $value->financial_month_end;
                                            $pdf_logo = $value->pdf_logo;
                                            $issue_capital = $value->issue_capital;
                                            $register_no = $value->register_no;
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
                                        $set_id = '';
                                        $start_month = '3';
                                        $end_month = '2';
                                        $pdf_logo = '';
                                        $issue_capital = '';
                                        $register_no = '';
                                    }
                                ?>
                                <div class="portlet-body form">
                                    <?php echo $this->session->flashdata('client'); ?>
                                    <!-- BEGIN FORM-->
                                    <form action="<?php echo BASE_URL;?>client/<?php echo $form_action; ?>" method="post" class="form-horizontal" enctype="multipart/form-data">
                                        <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
                                        <div class="form-body">
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
                                                <label class="col-md-3 control-label">Register Number</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="register_no" class="form-control" placeholder="Register Number" value="<?php echo $register_no; ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Issued capital</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="issue_capital" class="form-control" placeholder="Issued capital" value="<?php echo $issue_capital; ?>" required>
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

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Financial Month</label>
                                                            <div class="col-md-2">
                                                               
                                                               <select class="form-control" name="start_month">
                                                                   <option value="1" <?php echo ($start_month=='1')?'selected':''; ?> >January</option>
                                                                   <option value="2" <?php echo ($start_month=='2')?'selected':''; ?> >February</option>
                                                                   <option value="3" <?php echo ($start_month=='3')?'selected':''; ?> >March</option>
                                                                   <option value="4" <?php echo ($start_month=='4')?'selected':''; ?> >April</option>
                                                                   <option value="5" <?php echo ($start_month=='5')?'selected':''; ?> >May</option>
                                                                   <option value="6" <?php echo ($start_month=='6')?'selected':''; ?> >June</option>
                                                                   <option value="7" <?php echo ($start_month=='7')?'selected':''; ?> >July</option>
                                                                   <option value="8" <?php echo ($start_month=='8')?'selected':''; ?> >August</option>
                                                                   <option value="9" <?php echo ($start_month=='9')?'selected':''; ?> >September</option>
                                                                   <option value="10" <?php echo ($start_month=='10')?'selected':''; ?> >October</option>
                                                                   <option value="11" <?php echo ($start_month=='11')?'selected':''; ?> >November</option>
                                                                   <option value="12" <?php echo ($start_month=='12')?'selected':''; ?> >December</option>
                                                               </select>
                                                              <!--  <input type="text" class="form-control" name="start_month" placeholder="Start Month" value="<?php echo $bank_accounts; ?>"> -->
                                                            </div>
                                                            <div class="col-md-1" style="width: 10px;padding: 0px;">
                                                            <p>to</p>
                                                            </div>
                                                            <div class="col-md-2">
                                                               
                                                               <select class="form-control" name="end_month">
                                                                   <option value="1" <?php echo ($end_month=='1')?'selected':''; ?> >January</option>
                                                                   <option value="2" <?php echo ($end_month=='2')?'selected':''; ?> >February</option>
                                                                   <option value="3" <?php echo ($end_month=='3')?'selected':''; ?> >March</option>
                                                                   <option value="4" <?php echo ($end_month=='4')?'selected':''; ?> >April</option>
                                                                   <option value="5" <?php echo ($end_month=='5')?'selected':''; ?> >May</option>
                                                                   <option value="6" <?php echo ($end_month=='6')?'selected':''; ?> >June</option>
                                                                   <option value="7" <?php echo ($end_month=='7')?'selected':''; ?> >July</option>
                                                                   <option value="8" <?php echo ($end_month=='8')?'selected':''; ?> >August</option>
                                                                   <option value="9" <?php echo ($end_month=='9')?'selected':''; ?> >September</option>
                                                                   <option value="10" <?php echo ($end_month=='10')?'selected':''; ?> >October</option>
                                                                   <option value="11" <?php echo ($end_month=='11')?'selected':''; ?> >November</option>
                                                                   <option value="12" <?php echo ($end_month=='12')?'selected':''; ?> >December</option>
                                                               </select>
                                                            </div>
                                                        </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Logo</label>
                                                <div class="col-md-4">
                                                    <input type="file" class="form-control" id="imgInp" name="pdf_logo" accept="image/*">
                                                    <input type="hidden" name="pdf_logo_old" value="<?php echo $pdf_logo; ?>">
                                                    <?php if($pdf_logo !='') { ?>
                                                        <img id="blah" src="<?php echo BASE_URL."/images/pdflogo/".$pdf_logo; ?>" alt="your image" style="    width: 100px;" />
                                                    <?php } else { ?>
                                                        <img id="blah" src="#" alt="your image" style="    width: 100px;" />
                                                    <?php } ?>

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
                                                    <button type="submit" class="btn green"><?php echo $formname; ?> Client</button>
                                                    <?php if(($_SESSION['usertype'])== 5){ ?>
                                                    <button type="button" class="btn default"><a href="<?php echo BASE_URL; ?>client/add_client">Cancel</a></button>
                                                    <?php } else { ?>
													<button type="button" class="btn default"><a href="<?php echo BASE_URL; ?>reports/index">Cancel</a></button>
													<?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- END FORM-->
                                    <?php if(($_SESSION['usertype'])!= 5){ ?>   
                                        <div class="col-md-12">                
    						             <div class="col-md-3"></div>
    						              <!-- password form -->
    						              <form class="login-form" name="profile" action="<?php echo BASE_URL;?>dashboard/passwordsave" method="post">
    						                <div class="col-md-3">
    						                    <h3 class="form-title font-green">Password</h3>
                                                <?php echo $this->session->flashdata('client'); ?>
                                                <div class="alert alert-danger display-hide">
                                                    <button class="close" data-close="alert"></button>
                                                    <span> Enter Password </span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label visible-ie8 visible-ie9">Current Password</label>
                                                    <input class="form-control form-control-solid placeholder-no-fix" type="password" required autocomplete="off" placeholder="Password" name="password" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label visible-ie8 visible-ie9">New Password</label>
                                                    <input class="form-control form-control-solid placeholder-no-fix" type="password" required autocomplete="off" placeholder="New Password" name="newpassword" />
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label visible-ie8 visible-ie9">Re-type New Password</label>
                                                    <input class="form-control form-control-solid placeholder-no-fix" type="password"  required autocomplete="off" placeholder="Confirm Password" name="newrepassword" />
                                                </div>
                                                <div class="form-actions">
                                                    <button type="submit" class="btn green" id="passsubmit" name="submit" value="Save Changes">Change Password</button>
                                                </div>
                                            </form>
    						                <!-- /password form -->
                                        </div>
                                        <?php if($set_id == '' || $set_id <0){ ?>
                                        
                                        
						            <?php } } ?>
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
<script type="text/javascript">
    function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#blah').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

$("#imgInp").change(function() {
  readURL(this);
});
</script>
            
    
