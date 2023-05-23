            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-users"></i>
                                <a href="#">Receipt</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <span><?php echo $cusotm_field; ?></span>
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
                                                    <span class="caption-subject font-red-sunglo bold uppercase"><?php echo $cusotm_field; ?></span>
                                                    <span class="caption-helper">details</span>
                                                </div>

                                            </div>
                                            <?php  
                                            if($BalDetail)
                                            {
                                            foreach ($BalDetail as $value) {
                                                $openbal_id = $value->id;
                                                $openbal_date = $value->openbal_date;
                                                $openbal_date = date('m/d/Y',strtotime($openbal_date));
                                               // $bank = $value->bank;
                                                $amount = $value->amount;
                                                $file_id = $value->file_id;
                                                $client_id = $value->client_id;
                                                //$client_name = $value->firm_name;
                                                $file_number = $value->file_number;
                                               // $transaction_type1 = $value->transaction_type;
                                               // $status = $value->status;
                                            }
                                            }
                                            else
                                            {
                                                $openbal_id = '';
                                                $openbal_date = '';
                                               // $bank = '';
                                                $amount = '';
                                                $file_id = '';
                                                $client_id = '';
                                                //$client_name = '';
                                                $file_number = '';
                                                //$transaction_type1 = '';
                                                //$status = '';
                                            }

                                            ?>
                                            <div class="portlet-body form">
                                            <?php echo $this->session->flashdata('receipts'); ?>
                                                <!-- BEGIN FORM-->
                                                <form action="<?php echo BASE_URL;?>receipts/<?php echo $form_action; ?>/" method="post" class="form-horizontal">

                                                    <input type="hidden" name="bal_id" value="<?php echo $openbal_id; ?>">
                                                    <input type="hidden" name="client_id" value="<?php echo $_SESSION['filtered_client_id']; ?>">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Date</label>
                                                            <div class="col-md-4">
                                                            <?php if(isset($_GET['openbal_id']) && $openbal_id !='') { ?>
                                                                <input type="text" name="opening_bal_date" class="form-control date-picker" placeholder="Date" value="<?php echo $openbal_date; ?>" required>
                                                            <?php }  else { ?>

                                                                <div class="input-group input-large date-picker input-daterange"  >
                                                                    <input type="text" name="opening_bal_from" class="form-control">
                                                                    <span class="input-group-addon"> to </span>
                                                                    <input type="text" name="opening_bal_to" class="form-control"> 
                                                                </div>
                                                            <?php } ?>

                                                                <!-- <input type="text" name="receipt_date" class="form-control date-picker" placeholder="Date" value="<?php echo $receipt_date; ?>" required> -->
                                                               <!--  <span class="help-block"> A block of help text. </span> -->
                                                            </div>
                                                        </div>
                                                        <!--<div class="form-group">
                                                            <label class="col-md-3 control-label">Bank</label>
                                                            <div class="col-md-4">
                                                            <select id="select2_client" name="client_id" class="form-control select2" required>
                                                                    <option></option>
                                                                    <?php 
                                                                    if($ClientDetails){
                                                                        foreach ($ClientDetails as $client) {
                                                                            $ccid = $client->client_id;
                                                                            if($ccid == $client_id){$selected = 'selected';}else {$selected = '';}
                                                                            if($client->bank_accounts != '')
                                                                           echo "<option value='".$client->client_id."' ".$selected.">".$client->bank_accounts."</option>";
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
                                                            <label class="col-md-3 control-label">Amount</label>
                                                            <div class="col-md-4">
                                                                <input type="text" name="amount" class="form-control" placeholder="Amount" value="<?php echo $amount; ?>" required>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="form-group">
                                                            <label class="col-md-3 control-label">Client</label>
                                                            <div class="col-md-4">
                                                                <input type="text" name="client_name" id="client_name" class="form-control " placeholder="Client Name" value="<?php echo $client_name; ?>">
                                                                <input type="hidden" class="client_id" id="client_id" name="client_id" value="<?php echo $client_id; ?>">
                                                            </div>
                                                        </div> -->
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">File</label>
                                                            <div class="col-md-4">

                                                                <select id="select2_file" name="file_id" class="form-control select2" >
                                                                    <option></option>
                                                                    <?php 
                                                                    if($FileDetails){
                                                                        foreach ($FileDetails as $FileDetail) {
                                                                            $ccid = $FileDetail->file_id;
                                                                            if($ccid == $file_id){$selected = 'selected';}else {$selected = '';}
                                                                            if($FileDetail->file_number != '')
                                                                           echo "<option value='".$FileDetail->file_id."' ".$selected.">".$FileDetail->file_number."</option>";
                                                                        }
                                                                    }
                                                                    ?>
                                                                    
                                                                </select>

                                                               <!--  <input type="text" name="file_name" id="file_name" class="form-control " placeholder="File" value="<?php echo $file_number; ?>">
                                                                <input type="hidden" class="file_id" id="file_id" name="file_id" value="<?php echo $file_id; ?>"> -->
                                                            </div>
                                                            <div class="col-md-4">
                                                                <a class="btn purple btn-outline sbold" data-toggle="modal" href="#modal_addfile" tabindex="-1"> Add File </a>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Transaction Type </label>
                                                            <div class="col-md-4">
                                                                <input type="text" name="transaction_type" class="form-control" value="Opening Balance" readonly tabindex="-1">
                                                                 <!-- <select name="transaction_type" class="form-control" required>
                                                                    <option>Select Option</option>
                                                                    <option value="deposit" <?php echo ($txn_type == 'deposit' || $transaction_type1 == 'deposit')?'selected':'' ?> >Deposit</option>
                                                                    <option value="rtd" <?php echo ($txn_type == 'rtd' || $transaction_type1 == 'rtd')?'selected':'' ?> >RTD</option>
                                                                    <option value="credit_interest" <?php echo ($txn_type == 'credit_interest' || $transaction_type1 == 'credit_interest')?'selected':'' ?> >Credit Interest</option>
                                                                </select>  -->
                                                            </div>
                                                        </div>
                                                        <!-- <div class="form-group">
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
                                                                <button type="submit" class="btn green">Submit</button>
                                                                <button type="button" class="btn default">Cancel</button>
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

            <div class="modal fade" id="modal_addfile" tabindex="-1" role="modal_addclient" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <center><h4 class="modal-title">Add File Details</h4></center>
                        </div>
                        <div class="modal-body"> 
                            <div class="error_msg"></div>
                            <form action="<?php echo BASE_URL;?>file/addfile_submit" method="post" class="form-horizontal formadd_file">
                              <input type="hidden" name="file_type" value="all">
                              <input type="hidden" name="file_id" value="">
                              <input type="hidden" name="client_id1" value="<?php echo $_SESSION['filtered_client_id']; ?>">
                              <div class="form-body">             
                                <!--<div class="form-group">
                                  <label for="single" class="col-md-4 control-label">Client</label>
                                  <div class="col-md-6">
                                    <select id="select2_client1" name="client_id1" class="form-control select2" required>
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
                                </div>-->

                                <div class="form-group">
                                  <label class="col-md-4 control-label">File Name</label>
                                  <div class="col-md-6">
                                    <input type="text" name="file_name" class="form-control file_name" placeholder="File Name" value="" required>
                                  </div>
                                </div> 
                                <div class="form-group">
                                  <label class="col-md-4 control-label">File Number</label>
                                  <div class="col-md-6">
                                    <input type="text" name="file_number" class="form-control file_number" placeholder="File Number" value="" required>
                                  </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Opening Balance</label>
                                    <div class="col-md-6">
                                        <input type="text" name="ledger_openbal" class="form-control" placeholder="Opening Balance" value="" required>
                                    </div>
                                </div>  
                                <div class="form-group">
                                  <label class="col-md-4 control-label">Case Type</label>
                                  <div class="col-md-6">
                                    <input type="text" name="case_type" class="form-control" placeholder="Case Type" value="" >
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-4 control-label">Cell Phone</label>
                                  <div class="col-md-6">
                                    <input type="text" name="cell_phone" class="form-control" placeholder="Cell Phone" value="" >
                                  </div>
                                </div> 
                                <div class="form-group">
                                  <label class="col-md-4 control-label">Telephone</label>
                                  <div class="col-md-6">
                                    <input type="text" name="telephone" class="form-control" placeholder="Telephone" value="">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-4 control-label">Email</label>
                                  <div class="col-md-6">
                                    <input type="email" name="email" class="form-control" placeholder="Email" value=""> 
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

                              </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                            <button type="button" class="btn green btn_addfile">Add File</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

            <script type="text/javascript">
            jQuery(document).ready(function(){
                 $('.date-picker').datepicker({
                autoclose: true,
                orientation: "bottom"
            });


            $('#select2_client').select2({
            placeholder: "Bank Accounts",
            allowClear: true
        });
              $('#select2_client1').select2({
            placeholder: "Bank Accounts",
            allowClear: true
        });
            
            $('#select2_file').select2({
            placeholder: "File Number",
            allowClear: true
        });


            $(".btn_addclient").click(function(){
            $(".error_msg").html('');
            var firm_name = jQuery(".firm_name").val();
            var option_html = '';
            var option_html1 = '';
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
                    $("#select2_client1").html("");
                     option_html += "<option></option>";
                      option_html1 += "<option></option>";
                    $.each(data,function(key, value){
                       // console.log(value);
                        //console.log(key);
                        //console.log(value['firm_name']);
                        if(value['bank_accounts'] != ''){
                        option_html += "<option value='"+value['client_id']+"'>"+value['bank_accounts']+"</option>";
                      }
                       if(value['firm_name'] != ''){
                        option_html1 += "<option value='"+value['client_id']+"'>"+value['firm_name']+"</option>";
                      }
                    })
                  }

                    //console.log(data);
                     $("#select2_client").html(option_html);
                     $("#select2_client1").html(option_html1);

                    }
                });
                $('#modal_addclient').modal('hide');
            }
            else
            {
                $(".error_msg").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Please enter the firm name</span></div>');
            }

        });


            $(".btn_addfile").click(function(){
            $(".error_msg").html('');
            var select2_client1 = jQuery("#select2_client1").val();
            var file_number = jQuery(".file_number").val();
            var option_html = '';
            src = '<?php echo BASE_URL; ?>'+'file/addfile_ajax';
            if(select2_client1 != '')
            {
              if(file_number != '')
            {
                $.ajax({
                    url: src,
                    type:'POST',
                    dataType: "json",
                    data: $(".formadd_file").serialize(),
                    success: function(data) {

                  if(data)
                  {
                    $("#select2_file").html("");
                     option_html += "<option></option>";
                    $.each(data,function(key, value){
                       // console.log(value);
                        //console.log(key);
                        //console.log(value['firm_name']);
                        if(value['file_number'] != ''){
                        option_html += "<option value='"+value['file_id']+"'>"+value['file_number']+"</option>";
                      }
                    })
                  }

                    //console.log(data);
                     $("#select2_file").html(option_html);

                    }
                });
                $('#modal_addfile').modal('hide');
                 }
                else
                {
                    $(".error_msg").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Please enter a <b>File Number</b></span></div>');
                }
            }
            else
            {
                $(".error_msg").html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span> Please enter the <b>Client Name</b></span></div>');
            }

        });



$('#select2_client').on("select2:select", function(e) { 
              
var selected_id = jQuery('#select2_client :selected').val();
ajax_client(selected_id)

});
$('#select2_client').on("select2:unselect", function(e) { 
ajax_client('')

});

            function ajax_client(selected_id){
              var option_html = '';
               src = '<?php echo BASE_URL; ?>'+'file/get_FileDetails';
                 $.ajax({
                    url: src,
                    type:'POST',
                    dataType: "json",
                    data: {'client_id':selected_id},
                    success: function(data) {

                      console.log(data);

                  if(data)
                  {
                    $("#select2_file").html("");
                     option_html += "<option></option>";
                    $.each(data,function(key, value){
                       // console.log(value);
                        //console.log(key);
                        //console.log(value['firm_name']);
                        if(value['file_number'] != ''){
                        option_html += "<option value='"+value['file_id']+"'>"+value['file_number']+"</option>";
                      }
                    })
                  }

                    //console.log(data);
                     $("#select2_file").html(option_html);

                    }
                });
            }




            


                 });






/*
                            $(function(){
  $("#file_name").autocomplete({

    minLength:2, 
    source: "<?php echo BASE_URL; ?>payments/get_filenumber?client_id="+$( "#client_id" ).val(), // path to the get_birds method
    focus: function( event, ui ) {
                  $( "#file_name" ).val( ui.item.label );
                     return false;
               },
               select: function( event, ui ) {
                  $( "#file_name" ).val( ui.item.label );
                  $( "#file_id" ).val( ui.item.value );
                  return false;
               },
               change: function (event, ui) {
                     if (ui.item === null) {
                         $('#file_id').val('');
                     }
                   }
  });


    src = '<?php echo BASE_URL; ?>'+'payments/get_filenumber';

    // Load the cities straight from the server, passing the country as an extra param
    $("#file_name").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    term : request.term,
                    client_id : $("#client_id").val()
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        min_length: 2,
        select: function( event, ui ) {
                  $( "#file_name" ).val( ui.item.label );
                  $( "#file_id" ).val( ui.item.value );
                  return false;
               },
               change: function (event, ui) {
                     if (ui.item === null) {
                         $('#file_id').val('');
                     }
                   }
    });
  $("#client_name").autocomplete({

    minLength:2, 
    source: "<?php echo BASE_URL; ?>client/get_clientname", // path to the get_birds method
    focus: function( event, ui ) {
                  $( "#client_name" ).val( ui.item.label );
                     return false;
               },
               select: function( event, ui ) {
                  $( "#client_name" ).val( ui.item.label );
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
            
    