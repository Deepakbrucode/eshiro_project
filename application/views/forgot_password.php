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
		<form class="login-form"  name="register" action="<?php echo BASE_URL;?>login/forgot_passwordmail/" method="post">
		 
		<h3 class="form-title font-green">Forgot Password</h3>
		<?php echo $this->session->flashdata('forgot_password'); ?>

	
		 <div class="form-group">
		<label class="control-label visible-ie8 visible-ie9">Email ID</label>
		<input class="form-control" type="email" required  placeholder="Emailid" name="emailid" />
		 </div>

		 
		<div class="form-actions">
		<button type="submit" class="btn green uppercase">Send</button>
		<button type="reset" class="btn green uppercase"  onClick="window.location='<?php echo BASE_URL;?>';">Cancel</button>
		
		 
		</div>

		</form>
		</div>
		</div>
