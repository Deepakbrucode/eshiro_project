 <!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-users"></i>
                    <a href="#">Fixed Asset</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Save Asset Dep</span>
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
                                        <span class="caption-subject font-red-sunglo bold uppercase">Fixed Asset</span>
                                        <span class="caption-helper">Save Asset Dep</span>
                                    </div>
                                </div>
                                <?php 
                                if($costDetail)
                                {
                                    foreach ($costDetail as $value) {
    									$cost_id = $value->cost_id;
                                        $cost_name = $value->cost_name;
                                        $dep_per = $value->dep_per;
                                        $residual_value = $value->residual_value;
                                        
                                    }
                                }
                                else
                                {
									$cost_id = '';
                                    $cost_name='';
                                    $dep_per = '';
                                    $residual_value = '';
                                   
                                }
                                ?>
                                <div class="portlet-body form">
                                    <?php echo $this->session->flashdata('costcentre'); ?>
                                    <!-- BEGIN FORM-->
                                    <form action="<?php echo BASE_URL;?>financialreport/saveCostDep" method="post" class="form-horizontal costform">
                                        <input type="hidden" name="cost_id" value="<?php echo $cost_id; ?>">
                                        <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Cost Name</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="bank_name" class="form-control " placeholder="Bank Name" value="<?php echo $cost_name; ?>" readonly>
                                                    <!--  <span class="help-block"> A block of help text. </span> -->
                                                </div>
                                            </div> 

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Dep Percentage(Only insert value)</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="dep_per" class="form-control " placeholder="Dep value" value="<?php echo $dep_per; ?>" required>
                                                    <!--  <span class="help-block"> A block of help text. </span> -->
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Residual Value</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="residual_value" class="form-control " placeholder="Residual Value" value="<?php echo $residual_value; ?>" required>
                                                </div>
                                            </div>
                                            
                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="submit" class="btn green">Save</button>
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
    
