            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <div class="page-top">

                    <?php if(isset($_SESSION['filtered_client_id']) && $_SESSION['filtered_client_id'] != '') { ?>
						<?php if($_SESSION['usertype']!=5) {?>
                        <p style="display: inline-block;padding-top:5px;padding-left: 17px;">Client Name: <b><?php echo $_SESSION['filtered_client_name']; ?></b>  <a href="<?php echo BASE_URL; ?>client/edit?client_id=<?php echo $_SESSION['filtered_client_id']; ?>">Edit Client Details</a></p>
                        <?php } ?>
                        <?php } ?>
                        </div>
                        
                    <div class="row">
					<div class="col-md-3">
</div>	
					<div class="col-md-3">

					<form class="login-form" name="profile" action="<?php echo BASE_URL;?>dashboard/passwordsave" method="post">

					<h3 class="form-title font-green">Profile</h3>
					<?php echo $this->session->flashdata('profile'); ?>
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

					</div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->


            <div class="modal fade" id="modal_addclient" tabindex="-1" role="modal_addclient" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <center><h4 class="modal-title">Add Client Details</h4></center>
                        </div>
                        <div class="modal-body"> 
                            <div class="error_msg"></div>
                            <form action="#" method="post" class="formadd_client form-horizontal">
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Firm Name</label>
                                        <div class="col-md-6">
                                            <input type="text" name="firm_name" class="form-control firm_name" placeholder="Firm Name" value="" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Directors</label>
                                        <div class="col-md-6">
                                            <input type="text" name="directors" class="form-control" placeholder="Directors" value="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Registered Address</label>
                                        <div class="col-md-6">
                                            <textarea name="registered_address" class="form-control" placeholder="Registered Address"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Physical Address</label>
                                        <div class="col-md-6">
                                            <textarea name="physical_address" class="form-control" placeholder="Physical Address"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Postal Address</label>
                                        <div class="col-md-6">
                                            <textarea name="postal_address" class="form-control" placeholder="Postal Address"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Bank Accounts</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="bank_accounts" placeholder="Bank Accounts" value="">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                            <button type="button" class="btn green btn_addclient">Add Client</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->


            <script type="text/javascript">
                $(document).ready(function(){
            $('#select2_client').select2({
            placeholder: "Client Name",
            allowClear: true
        });

        $(".btn_addclient").click(function(){
            $(".error_msg").html('');
            var firm_name = jQuery(".firm_name").val();
            var option_html = '';
            src = '<?php echo BASE_URL; ?>'+'client/addclient_ajax';
            if(firm_name != '')
            {
                $.ajax({
                    url: src,
                    type:'POST',
                    dataType: "json",
                    data: $(".formadd_client").serialize(),
                    success: function(data) {

                  if(data)
                  {

                    $("#select2_client").html("");
                     option_html += "<option></option>";
                    $.each(data,function(key, value){

                        option_html += "<option value='"+value['client_id']+"'>"+value['firm_name']+"</option>";
                    })
                  }

                    //console.log(data);
                     $("#select2_client").html(option_html);

                    }
                });
                $('#modal_addclient').modal('hide');
            }
            else
            {
                $(".error_msg").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Please enter the firm name</span></div>');
            }

        })

       /* function client_name(){
            alert("next function ");
            src = '<?php echo BASE_URL; ?>'+'client/get_clientnames';
            $.ajax({
                url: src,
                type:'POST',
                dataType: "json",
                success: function(data) {
                    console.log(data);

                    $("#select2_client").html();

                   // response(data);

                }
            });
        }*/



})
            </script>
            
