      
           
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-users"></i>
                                <a href="#"><?php echo $cusotm_field; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <span><?php echo $form_name; ?> <?php echo $cusotm_field; ?></span>
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
                                                    <span class="caption-subject font-red-sunglo bold uppercase"><?php echo $form_name;?> <?php echo $cusotm_field; ?></span>
                                                    <span class="caption-helper">details</span>
                                                </div>

                                            </div>

                                            <?php  
                                            if($FileDetail)
                                            {
                                            foreach ($FileDetail as $value) 
                                            {
												//$filtered_client_id= $this->session->filtered_client_id;
                                                //$firm_name=$value->firm_name;
                                                $file_id=$value->file_id;
                                                $file_name = $value->file_name;
                                                $client_id = $value->client_id;
                                                $file_type = $value->file_type;
                                                $file_number = $value->file_number;
                                                $ledger_openbal = $value->ledger_openbal;
                                                $case_type = $value->case_type;
                                                 $physical_address = $value->physical_address;
                                                $postal_address = $value->postal_address;
                                                $telephone_no = $value->telephone_no;
                                                $cell_no = $value->cell_no;
                                                $email=$value->email;
                                                $financial_start=$value->financial_start;
                                                $financial_end=$value->financial_end;
                                                $opening_balance=$value->opening_balance;
                                               // $status = $value->status;
                                            }
                                            }
                                            else
                                            {
                                                $file_id = '';
                                                $file_name = '';
                                               // $firm_name = '';
                                                $client_id = '';
                                                $file_type = $file_type1;
                                                $file_number = '';
                                                $ledger_openbal = '';
                                                $case_type = '';
                                                 $physical_address = '';
                                                $postal_address = '';
                                                $telephone_no = '';
                                                $email = '';
                                                //$status = '';
                                                $cell_no = '';
                                                $financial_start='';
                                                $financial_end='';
                                                $opening_balance='';
                                            }
                                            //echo "<pre>";print_r($ClientDetails);echo "</pre>";
                                            ?>
                                            <div class="portlet-body form">
                                            <?php echo $this->session->flashdata('File'); ?>
                                            <?php echo $this->session->flashdata('client'); ?>
                                                <!-- BEGIN FORM-->
                                                <form action="<?php echo BASE_URL;?>file/<?php echo $form_action; ?>" method="post" class="form-horizontal">
                                                    <input type="hidden" name="file_type" value="<?php echo $file_type; ?>">
                                                    <input type="hidden" name="page_url" value="<?php echo $page_url; ?>">
                                                    <input type="hidden" name="file_id" value="<?php echo $file_id; ?>">
                                                    <input type="hidden" name="client_id" value="<?php echo $_SESSION['filtered_client_id']; ?>">
                                                    <div class="form-body">
                                                       
                                                        <!--<div class="form-group">
                                                            <label for="single" class="col-md-3 control-label">Client</label>
                                                            <div class="col-md-4">
                                                                <select id="select2_client" name="client_id" class="form-control select2" required>
                                                                    <option></option>
                                                                    <?php 
                                                                    if($ClientDetails){
                                                                        foreach ($ClientDetails as $client) {
                                                                            $ccid = $client->client_id;
                                                                            if($ccid == $client_id){$selected = 'selected';}else {$selected = '';}
                                                                           echo "<option value='".$client->client_id."' ".$selected.">".$client->firm_name."</option>";
                                                                        }
                                                                    }
                                                                    ?>
                                                                    
                                                                </select>
                                                                
                                                            </div>
                                                            <div class="col-md-4">
                                                                <a class="btn purple btn-outline sbold" data-toggle="modal" href="#modal_addclient"> Add Client </a>
                                                            </div>
                                                        </div>-->

                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">File Name</label>
                                                            <div class="col-md-4">
                                                                <input type="text" name="file_name" class="form-control" placeholder="File Name" value="<?php echo $file_name; ?>" required>
                                                            </div>
                                                        </div> 
                                                         <div class="form-group">
                                                            <label class="col-md-3 control-label">File Number</label>
                                                            <div class="col-md-4">
                                                                <input type="text" name="file_number" class="form-control" placeholder="File Number" value="<?php echo $file_number; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Financial Year</label>
                                                            <div class="col-md-4">
                                                                <div class="input-group input-large date-picker input-daterange"  >
																<input type="text" name="opening_bal_from" class="form-control" value="<?php echo $financial_start; ?>" required>
																<span class="input-group-addon"> to </span>
																<input type="text" name="opening_bal_to" class="form-control" value="<?php echo $financial_end; ?>" required> 
															</div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Opening Balance</label>
                                                            <div class="col-md-4">
                                                                <input type="text" name="ledger_openbal" class="form-control" placeholder="Opening Balance" value="<?php echo $opening_balance; ?>" required>
                                                            </div>
                                                        </div>  
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Case Type</label>
                                                            <div class="col-md-4">
                                                                <input type="text" name="case_type" class="form-control" placeholder="Case Type" value="<?php echo $case_type; ?>" >
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Cell Phone</label>
                                                            <div class="col-md-4">
                                                                <input type="text" name="cell_phone" class="form-control" placeholder="Cell Phone" value="<?php echo $cell_no; ?>" >
                                                            </div>
                                                        </div> 
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Telephone</label>
                                                            <div class="col-md-4">
                                                                <input type="text" name="telephone" class="form-control" placeholder="Telephone" value="<?php echo $telephone_no; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Email</label>
                                                            <div class="col-md-4">
                                                                <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $email;?>"> 
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Physical Address</label>
                                                            <div class="col-md-4">
                                                                <textarea name="physical_address" class="form-control" placeholder="Physical Address"><?php echo $physical_address; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Postal Address</label>
                                                            <div class="col-md-4">
                                                                <textarea name="postal_address" class="form-control" placeholder="Postal Address"><?php echo $postal_address; ?></textarea>
                                                            </div>
                                                        </div>
                                                       <!--  <div class="form-group">
                                                            <label class="col-md-3 control-label">Status</label>
                                                            <div class="col-md-4">
                                                                <label><input type="radio" name="status" value="1" <?php echo ($status == '1')?'checked':''; ?> required>Active</label>
                                                                <label><input type="radio" name="status" value="0" <?php echo ($status == '0')?'checked':''; ?> required>In-Active</label>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                    <div class="form-actions">
                                                        <div class="row">
                                                            <div class="col-md-offset-3 col-md-9">
                                                                <button type="submit" class="btn green"> <?php echo $form_name; ?></button>
                                                                <!-- <button type="button" class="btn default"><a href="<?php echo BASE_URL; ?>file/add_file">Cancel</button> -->
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

            <div class="modal fade" id="modal_addclient" tabindex="-1" role="modal_addclient" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <center><h4 class="modal-title">Add Client Details</h4></center>
                        </div>
                        <div class="modal-body"> 
                            <div class="error_msg"></div>
                            <form action="<?php echo BASE_URL;?>client/<?php echo $form_action; ?>" method="post" class="formadd_client form-horizontal">
                                <input type="hidden" name="client_id" value="">
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
	
	  $('.date-picker').datepicker({
                autoclose: true,
                  format: "mm-yyyy",
        viewMode: "months", 
        minViewMode: "months",
                orientation: "bottom"
            });
            
            
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
             /*   $(function(){
  $("#client").autocomplete({

    minLength:2, 
    source: "<?php echo BASE_URL; ?>client/get_clientname", // path to the get_birds method
    focus: function( event, ui ) {
                  $( "#client" ).val( ui.item.label );
                     return false;
               },
               select: function( event, ui ) {
                  $( "#client" ).val( ui.item.label );
                  $( "#client_id" ).val( ui.item.value );
                  return false;
               },
               change: function (event, ui) {
                     if (ui.item === null) {
                         $('#client_id').val('');
                     }
                   }
  });
});*/
            </script>
            
    
