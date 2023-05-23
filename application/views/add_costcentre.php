 <!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-users"></i>
                    <a href="#">Cost Centre</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span><?php echo $formname; ?> Cost Centre</span>
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
                                        <span class="caption-subject font-red-sunglo bold uppercase"><?php echo $formname; ?> Cost Centre</span>
                                        <span class="caption-helper"><?php echo $formname; ?> Cost Centre details</span>
                                    </div>
                                </div>
                                <?php 
                                if($CostDetail)
                                {
                                    foreach ($CostDetail as $value) {
    									$cost_id = $value->cost_id;
                                        $account_no = $value->account_no;
                                        $links = $value->links;
                                        $set_id = $value->set_id;
                                        $user_id = $value->user_id;
                                        $cost_name = $value->cost_name;
                                        $status = $value->status;
                                        $category_id = $value->category_id;
                                        $subcategory_id = $value->subcategory_id;
                                    }
                                }
                                else
                                {
									$cost_id = '';
                                    $cost_name = '';
                                    $status='1';
                                    $category_id = '';
                                    $subcategory_id = '';
                                    $account_no = '';
                                    $links = '';
                                    $set_id = '';
                                }
                                ?>
                                <div class="portlet-body form">
                                    <?php echo $this->session->flashdata('costcentre'); ?>
                                    <!-- BEGIN FORM-->
                                    <form action="<?php echo BASE_URL;?>costcentre/<?php echo $form_action; ?>" method="post" class="form-horizontal costform">
                                        <input type="hidden" name="cost_id" value="<?php echo $cost_id; ?>">
                                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                        <div class="form-body">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Account</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="account_no" class="form-control " placeholder="Account No" value="<?php echo $account_no; ?>" minlength="4" maxlength="4" size="4" required>
                                                    <!--  <span class="help-block"> A block of help text. </span> -->
                                                </div>
                                            </div> 

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Cost Name</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="cost_name" class="form-control " placeholder="Cost Name" value="<?php echo $cost_name; ?>" required>
                                                    <!--  <span class="help-block"> A block of help text. </span> -->
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Links</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="links" class="form-control links" placeholder="Links" value="<?php echo $links; ?>" maxlength="14" required>
                                                    <div class="error_message"></div>
                                                    <!--  <span class="help-block"> A block of help text. </span> -->
                                                </div>
                                            </div>     
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Category</label>
                                                <div class="col-md-4">
                                                    <select class="form-control category_id" name="category_id" <?php echo ($usertype != '5')?'required':''; ?> >
                                                        <option value="">Select Category</option>
                                                        <?php
                                                            if($Categories)
                                                            {
                                                                foreach($Categories as $CostDet)
                                                                {
                                                                        $selected = ($category_id == $CostDet->cost_id)?'selected':'';
                                                                        echo "<option value='".$CostDet->cost_id."' ".$selected.">".$CostDet->cost_name."</option>";
                                                                         
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                                    
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">SubCategory</label>
                                                <div class="col-md-4">
                                                    <select class="form-control subcategory_id" name="subcategory_id" <?php echo ($usertype != '5')?'required':''; ?>>
                                                        <option value="">Select SubCategory</option>
                                                        <?php
                                                        if($category_id !='')
                                                        {
                                                            $subcategories1 = $subcategories[$category_id];
                                                            foreach($subcategories1 as $CostDet){
                                                                if($cost_id != $CostDet->cost_id)
                                                                {
                                                                    $selected = ($subcategory_id == $CostDet->cost_id)?'selected':'';
                                                                    echo "<option value='".$CostDet->cost_id."' ".$selected.">".$CostDet->cost_name."</option>";
                                                                }
                                                                            
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php if($usertype == '5') { ?>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Set</label>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="set_id">
                                                        <option value="">Select Costset</option>
                                                    <?php 
                                                    if($Sets)
                                                    {
                                                        foreach($Sets as $Set)
                                                        {
                                                            $selected = ($set_id == $Set->set_id)?'selected':'';
                                                            echo "<option value='".$Set->set_id."' ".$selected.">".$Set->set_name."</option>";
                                                                         
                                                        }
                                                    }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>  
                                            <?php } else {?>
                                                <input type="hidden" name="set_id" value="">
                                            <?php } ?>
                                                    
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Status</label>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="status">
                                                        <option value="1" <?php echo ($status == '1')?'selected':''; ?>>Active</option>
                                                        <option value="0" <?php echo ($status == '0')?'selected':''; ?>>In-Active</option>
                                                    </select>
                                                </div>
                                            </div>
										</div>
                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="submit" class="btn green"><?php echo $formname; ?> Cost</button>
                                                    <button type="button" class="btn default"><a href="<?php echo BASE_URL; ?>reports/index">Cancel</a></button>
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
    
