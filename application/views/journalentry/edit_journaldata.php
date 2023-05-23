 <!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-users"></i>
                    <a href="#">Journal datas</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Journal data</span>
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
                                        <span class="caption-subject font-red-sunglo bold uppercase">Journal data</span>
                                        <span class="caption-helper">Journal details</span>
                                     </div>

                                </div>
                                <?php 

                                if($ReportDetail)
                                {
                                    foreach ($ReportDetail as $value) {
										$report_id = $value->report_id;
                                        $user_id = $value->user_id;
                                        $report_date = $value->report_date;
                                        $report_date = date('d/m/Y',strtotime($report_date));
                                        // $inv_no = $value->inv_no;
                                        // $ref_no = $value->ref_no;
                                        $description = $value->description;
                                        $amount_type = $value->amount_type;
                                        $amount = $value->amount;
                                        $tax_type = $value->tax_type;
                                        $data_costid = $value->cost_id;
                                        $status = $value->status;
                                        $category_id = $value->category_id;
                                        $ledger_type = $value->ledger_type;
                                        //$cost_name = $value->cost_name;
                                        $subcategory_id = $value->subcategory_id;
                                        $opt_sval = $category_id.'-'.$subcategory_id.'-'.$data_costid;
                                        $CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $user_id));

                                    }
                                }
                                else
                                {
									$report_id = '';
                                    // $user_id = '';
                                    $report_date = '';
                                    // $inv_no='';
                                    // $ref_no='';
                                    $description = '';
                                    $amount_type = '';
                                    $amount = '';
                                    $tax_type = '';
                                    $cost_id = '';
                                    $status = 1;
                                    $category_id = '';
                                    //$cost_name = '';
                                    $subcategory_id = '';
                                    $opt_sval = '';
                                    // $user_id= $this->session->id;
                                    $CostDetails = $this->costcentre_model->getDetails(array('category_id !=' => '', 'subcategory_id !=' => '','user_id' => $user_id));

                                }

                                // echo "<pre>";print_r($CostDetails);echo "</pre>"; 

                                ?>
                                <div class="portlet-body form">
                                    <?php echo $this->session->flashdata('report'); ?>
                                    <!-- BEGIN FORM-->
                                    <form action="<?php echo BASE_URL;?>journalentry/save_journaldata" method="post" class="form-horizontal">
                                        <input type="hidden" name="report_id" value="<?php echo $report_id; ?>">
                                                    
                                        <div class="form-body">
                                            <?php if($usertype == '5') { ?>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Client Name</label>
                                                <div class="col-md-4">
                                                    <select name="user_id" class="form-control">
                                                    <?php
                                                        if($ClientDetails)
                                                        {
                                                            foreach($ClientDetails as $ClientDetail)
                                                            {
                                                                $selected = ($user_id == $ClientDetail->id)?'selected':'';
                                                                echo "<option value='".$ClientDetail->id."' ".$selected.">".$ClientDetail->name."</option>";
                                                            }
                                                        }
                                                        else
                                                        {
                                                            echo "<option value=''>No clients avaiable</option>";
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php } else { ?>
                                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                            <?php } ?>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Date</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="report_date" class="form-control report_date" placeholder="Date" value="<?php echo $report_date; ?>" required>
                                                </div>
                                            </div>
                                            <!-- <div class="form-group">
                                                <label class="col-md-3 control-label">Inv No</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="inv_no" class="form-control" placeholder="Inv No" value="<?php echo $inv_no; ?>" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Ref No</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="ref_no" class="form-control" placeholder="Ref No" value="<?php echo $ref_no; ?>" required>
                                                </div>
                                            </div> -->
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Description</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="description" class="form-control" placeholder="Description" value="<?php echo $description; ?>" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Transaction type</label>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="amount_type">
														<option value="sales" <?php echo ($amount_type == 'sales')?'selected':''; ?> >DR (Sales)</option>
														<option value="expense" <?php echo ($amount_type == 'expense')?'selected':''; ?>>CR (Expense)</option>
													</select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Ledger type</label>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="ledger_type">
                                                         <option value="" <?php echo ($ledger_type == '' || $ledger_type == ' ')?'selected':''; ?>>Select Ledger</option>
                                                        <option value="1" <?php echo ($ledger_type == '1')?'selected':''; ?> >Invoice Ledger</option>
                                                        <option value="2" <?php echo ($ledger_type == '2')?'selected':''; ?>>Banktransaction Ledger</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Amount</label>
                                                <div class="col-md-4">
                                                    <input type="text" name="amount" class="form-control" placeholder="Amount" value="<?php echo $amount; ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Cost Centre</label>
                                                <div class="col-md-4">
                                                    <select name="data_costid" class="table_frminput form-control ">
                                                        <option value="">Select Cost Centre</option>
                                                        <?php
                                                            if($CostDetails)
                                                            {
                                                                foreach($CostDetails as $CostDetail)
                                                                {

                                                                    $cost_id1 = $CostDetail->cost_id;
                                                                    $links = $CostDetail->links;
                                                                    $category_id1 = $CostDetail->category_id;
                                                                    $subcategory_id1 = $CostDetail->subcategory_id;
                                                                    $opt_val = $category_id1.'-'.$subcategory_id1.'-'.$cost_id1; 
                                                                    $selected = ($opt_sval == $opt_val)?'selected':'';
                                                                    echo "<option value='".$opt_val."' ".$selected.">".$CostDetail->cost_name." (".$links.")</option>";

                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <input type="hidden" name="status" value="1">
										</div>
                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="submit" class="btn green"><?php echo $formname; ?> Transaction</button>
                                                    <button type="button" class="btn default"><a href="<?php echo BASE_URL; ?>journalentry/index">Cancel</a></button>
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
            format: 'dd/mm/yyyy',
    		orientation: "bottom"
    	});

        jQuery(document).on('change','.parent_cost',function(){
            var this_val = jQuery(this)
            var parent_cost = jQuery(this).val();
            var child_cost = jQuery(".child_cost").val();
            var src = '<?php echo BASE_URL; ?>'+'costcentre/get_childcost';
            jQuery(".child_cost").html('');
            $.ajax({
                url: src,
                type:'POST',
                dataType: "json",
                data: {'parent_cost':parent_cost},
                success: function(data) {
                    console.log(data);
                    var ChildCostDetails = data.ChildCostDetails;
                    var child_val = '';
                    jQuery.each(ChildCostDetails,function(key,value){
                        child_val += "<option value='"+value['cost_id']+"'>"+value['cost_name']+"</option>";
                    });
                    jQuery(".child_cost").html(child_val);
                }
            });

        });


    });
</script>    
    
