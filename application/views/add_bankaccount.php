 <!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-users"></i>
                    <a href="#">Bank Accounts</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Add Bank Account</span>
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
                                        <span class="caption-subject font-red-sunglo bold uppercase">Bank Accounts</span>
                                        <span class="caption-helper">Add Bank Account</span>
                                    </div>
                                </div>
                                <?php 
                                if($bankDetail)
                                {
                                    foreach ($bankDetail as $value) {
    									$bank_id = $value->bank_id;
                                        $client_id = $value->client_id;
                                        $bank_name = $value->bank_name;
                                        $bank_number = $value->bank_number;
                                        $account_type = $value->account_type;
                                        $currency_color = $value->currency_color;
                                        
                                    }
                                }
                                else
                                {
									$bank_id = '';
                                    $bank_name='';
                                    $bank_number = '';
                                    $account_type = '';
                                    $currency_color = '';
                                   
                                }
                                ?>
                                <div class="portlet-body form">
                                    <?php echo $this->session->flashdata('costcentre'); ?>
                                    <!-- BEGIN FORM-->
                                    <form action="<?php echo BASE_URL;?>client/saveBankAccount" method="post" class="form-horizontal costform">
                                        <input type="hidden" name="bank_id" value="<?php echo $bank_id; ?>">
                                        <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Bank Name</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="bank_name" class="form-control " placeholder="Bank Name" value="<?php echo $bank_name; ?>" required>
                                                    <!--  <span class="help-block"> A block of help text. </span> -->
                                                </div>
                                            </div> 

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Bank Number</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="bank_number" class="form-control " placeholder="Bank Number" value="<?php echo $bank_number; ?>" required>
                                                    <!--  <span class="help-block"> A block of help text. </span> -->
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">account_type</label>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="account_type">
                                                        <option value="check" <?php echo ($account_type == 'check')?'selected':''; ?> >Check</option>
                                                        <option value="credit_card" <?php echo ($account_type == 'credit_card')?'selected':''; ?>>Credit card</option>
                                                        <option value="investment" <?php echo ($account_type == 'investment')?'selected':''; ?>>Investment</option>
                                                    </select>

                                                    <!--  <span class="help-block"> A block of help text. </span> -->
                                                </div>
                                            </div>     
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Color</label>
                                                <div class="col-md-4">
                                                    <input type="color" class="form-control" name="currency_color" value="<?php echo $currency_color; ?>">
                                                </div>
                                            </div>
                                                    
                                            
                                           
                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="submit" class="btn green">Save Bank Account</button>
                                                    <!-- <button type="button" class="btn default"><a href="<?php echo BASE_URL; ?>reports/index">Cancel</a></button> -->
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
<script>
    jQuery(document).ready(function(){
	   $('.report_date').datepicker({
		  autoclose: true,
		  orientation: "bottom"
	   });

        jQuery(document).on('change','.category_id',function(){
            var this_val = jQuery(this)
            var category_id = jQuery(this).val();
            var child_cost = jQuery(".subcategory_id").val();
            var src = '<?php echo BASE_URL; ?>'+'costcentre/get_subcategory';
            jQuery(".subcategory_id").html('');
            $.ajax({
                url: src,
                type:'POST',
                dataType: "json",
                data: {'category_id':category_id},
                success: function(data) {
                    console.log(data);
                    var Subcategory_Details = data.Subcategory_Details;
                    var child_val = '';
                    jQuery.each(Subcategory_Details,function(key,value){
                        child_val += "<option value='"+value['cost_id']+"'>"+value['cost_name']+"</option>";
                    });
                    jQuery(".subcategory_id").html(child_val);
                }
            });

        });

        jQuery(".costform").submit(function(e){
            jQuery(".error_message").html();
            var links = jQuery(".links").val();
            // alert(links);
            // e.preventDefault();
                // return false;
            var error_message = 1;
            if(links.indexOf('.') !== -1)
            {
                // e.preventDefault();
                // return false;
                var result_links = links.split('.');
                if(result_links.length == 3)
                {
                    var fst_var = result_links[0];
                    var sed_var = result_links[1];
                    var trd_var = result_links[2];
                    console.log(fst_var.length);
                    if(fst_var.length <=4 && fst_var.length > 0 && /^[a-zA-Z]+$/.test(fst_var) && sed_var.length <=4 &&  sed_var.length > 0 && /^\d+$/.test(sed_var) && trd_var.length <=4 &&  trd_var.length > 0 && /^\d+$/.test(trd_var))
                    {
                        error_message = 0;
                    }
                }
            }
            if(error_message == 1)
            {
                jQuery(".error_message").html("<div class='alert alert-danger'>Please enter a valid Links (ex: erds.8521.4521)");
                e.preventDefault();
                return false;
            }
            // alert(error_message);
            // e.preventDefault();
            //     return false;
        })

    });
</script>    
    
