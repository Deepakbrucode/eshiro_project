<div class=" login">
		<!-- BEGIN LOGO -->
		<div class="logo">
<!--
		 <a href="login">
		<img src="images/Logo.jpg" alt="" /> 
		</a>
	-->
		</div>
		<!-- END LOGO -->
		
		<!-- BEGIN Register -->
		<div class="content">
		<!-- BEGIN Register FORM -->
		<form class="login-form"  name="register" action="<?php echo BASE_URL;?>login/insert/" method="post">
		 
		<h3 class="form-title font-green">Registration Form</h3>
		<?php echo $this->session->flashdata('register'); ?>
		<div class="alert alert-danger display-hide">
		<button class="close" data-close="alert"></button>
		 <span>Check All Details </span>
		</div>
		
		<div class="form-group">
		<label class="control-label visible-ie8 visible-ie9">Name</label>
		<input class="form-control form-control-solid placeholder-no-fix" type="text" required autocomplete="off" placeholder="Name" name="name" />
		 </div>
		 
		 <div class="form-group">
		<label class="control-label visible-ie8 visible-ie9">Trading ot Other name</label>
		<input class="form-control form-control-solid placeholder-no-fix" type="text" required autocomplete="off" placeholder="Trading ot Other name" name="trading_name" />
		 </div>
	
		 <div class="form-group">
		<label class="control-label visible-ie8 visible-ie9">Emailid</label>
		<input class="form-control" type="email" required  placeholder="Emailid" name="emailid" />
		 </div>
		 <div class="form-group">
		<label class="control-label visible-ie8 visible-ie9">Mobile</label>
		<input class="form-control form-control-solid placeholder-no-fix" type="text" required  autocomplete="off" placeholder="MobileNo" name="mobile" />
		 </div>
		 
		 <div class="form-group">
		<label class="control-label visible-ie8 visible-ie9">VAT register number</label>
		<input class="form-control form-control-solid placeholder-no-fix" type="text" pattern="\d*" maxlength="10" minlength="10" autocomplete="off" placeholder="VAT register number" name="vat_no" />
		 </div>
		 
		  <div class="form-group">
		<label class="control-label visible-ie8 visible-ie9">Address Line1</label>
		<input class="form-control form-control-solid placeholder-no-fix" type="text" required autocomplete="off" placeholder="Address Line1" name="address1" />
		 </div>
		 
		 <div class="form-group">
		<label class="control-label visible-ie8 visible-ie9">Address Line2</label>
		<input class="form-control form-control-solid placeholder-no-fix" type="text" required autocomplete="off" placeholder="Address Line2" name="address2" />
		 </div>
		 
		 <div class="form-group">
		<label class="control-label visible-ie8 visible-ie9">Zip Code</label>
		<input class="form-control form-control-solid placeholder-no-fix" type="text" required autocomplete="off" placeholder="Zip Code" name="zip_code" />
		 </div>

		 <label class="col-md-12"><div class="row" style="color: white;">Financial Month:</div></label>
		 <div class="form-group">
                                                            
                                                            <div class="col-md-5" style="width: 45.5%;">
                                                               <div class="row">
                                                               <select class="form-control" name="start_month">
                                                                   <option value="1">January</option>
                                                                   <option value="2">February</option>
                                                                   <option value="3">March</option>
                                                                   <option value="4">April</option>
                                                                   <option value="5">May</option>
                                                                   <option value="6">June</option>
                                                                   <option value="7">July</option>
                                                                   <option value="8">August</option>
                                                                   <option value="9">September</option>
                                                                   <option value="10">October</option>
                                                                   <option value="11">November</option>
                                                                   <option value="12">December</option>
                                                               </select>
                                                              <!--  <input type="text" class="form-control" name="start_month" placeholder="Start Month" value="<?php echo $bank_accounts; ?>"> -->
                                                          </div>
                                                            </div>
                                                            <div class="col-md-1" style="color: white;margin-top: -12px;padding-left: 10px;">
                                                            <p>to</p>
                                                            </div>
                                                            <div class="col-md-5" style="width: 45.5%;">
                                                            	<div class="row">
                                                               
                                                               <select class="form-control" name="end_month">
                                                                   <option value="1">January</option>
                                                                   <option value="2">February</option>
                                                                   <option value="3">March</option>
                                                                   <option value="4">April</option>
                                                                   <option value="5">May</option>
                                                                   <option value="6">June</option>
                                                                   <option value="7">July</option>
                                                                   <option value="8">August</option>
                                                                   <option value="9">September</option>
                                                                   <option value="10">October</option>
                                                                   <option value="11">November</option>
                                                                   <option value="12">December</option>
                                                               </select>
                                                           </div>
                                                            </div>
                                                        </div>
		 
		<div class="form-actions">
		<button type="submit" class="btn green uppercase">Register</button>
		<button type="reset" class="btn green uppercase"  onClick="window.location='<?php echo BASE_URL;?>';">Cancel</button>
		
		 
		</div>

		</form>
		</div>
		</div>
