 <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-file-text-o"></i>
                                <a href="#">Report</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <span><?php echo $formname; ?> Report</span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light portlet-fit  calendar">
                                <div class="portlet-body">
                                    <div class="row">
										<form action="<?php echo BASE_URL;?>reports/<?php echo $form_action; ?>" method="post" class="form-inline1" role="form">
                                        <div class="portlet light bordered">
                                            <div class="portlet-title">
                              
                              
                                                <div class="caption">
                                                    <i class="icon-equalizer font-red-sunglo"></i>
                                                    <span class="caption-subject font-red-sunglo bold uppercase"><?php echo $formname; ?> Report</span>
                                                    <span class="caption-helper"><?php echo $formname; ?> report details</span>
                                                </div>
                                                <div class="actions">
													
													<button type="submit" class="btn green-meadow">Save</button>
												</div>
                                            </div>
                                          
                                            <div class="portlet-body form">
                                            <?php echo $this->session->flashdata('report'); ?>
                                                <!-- BEGIN FORM-->
                                               
													<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
													<input type="hidden" name="report_id" value="">
                                                
													<input type="hidden" class="item_count" value="1">
													<div class="col-md-12">
														<div class="row">
														<div class="col-md-2">
															<input type="text" class="form-control" name="report_name" placeholder="Rport Name" value="" required>
														</div>
														<div class="col-md-8"></div>
														 <div class="col-md-2" style="text-align:right;margin-bottom:15px;">
															<button type="button" class="btn btn-warning btn_additem">Add Item</button>
														</div>
														</div>
													</div>
													<div class="report_items">
														<div class="report_item">
															<div class="col-md-2 form-group">
																<input type="text" name="report_data[0][report_date]" class="form-control report_date" placeholder="Date" required> 
															</div>
															<div class="col-md-1 form-group">
																<input type="text" name="report_data[0][inv_no]" class="form-control inv_no" placeholder="InvNo"> 
															</div>
															<div class="col-md-1 form-group">
																<input type="text" name="report_data[0][ref_no]" class="form-control ref_no" placeholder="RefNo"> 
															</div>
															<div class="col-md-3 form-group">
																<input type="text" name="report_data[0][description]" class="form-control description" placeholder="Description" required> 
															</div>
															<div class="col-md-1 form-group">
																<select class="form-control" name="report_data[0][amount_type]">
																	<option value="sales">Sales</option>
																	<option value="expense">Expense</option>
																</select>
															</div>
															<div class="col-md-2 form-group">
																<select class="form-control" name="report_data[0][tax_type]">
																	<option value="tax">Tax invoice</option>
																	<option value="expense">Zero rated</option>
																</select>
															</div>
															<div class="col-md-1 form-group">
																<input type="text" name="report_data[0][amount]" class="form-control amount" placeholder="Amount" required> 
															</div>
														</div>
													</div>

												
												<div style="clear:both"></div>
             
                                                <!-- END FORM-->
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
            
<div class="report_item" style="display:none;">
	
</div>
<script>

jQuery(document).ready(function(){
	$('.report_date').datepicker({
		autoclose: true,
		orientation: "bottom"
	});
	$(document).on('focus',".report_date", function(){
		$(this).datepicker();
	});
	jQuery(document).on('click','.btn_additem',function(){
		
		jQuery(".btn_additem").prop('disabled', true);
		
		var item_count = jQuery(".item_count").val();
		
		var item_div = '<div class="report_item"><div class="col-md-2 form-group"><input type="text" name="report_data['+item_count+'][report_date]" class="form-control report_date" placeholder="Date" required> </div><div class="col-md-1 form-group"><input type="text" name="report_data['+item_count+'][inv_no]" class="form-control inv_no" placeholder="InvNo"> </div><div class="col-md-1 form-group"><input type="text" name="report_data['+item_count+'][ref_no]" class="form-control ref_no" placeholder="RefNo"> </div><div class="col-md-3 form-group"><input type="text" name="report_data['+item_count+'][description]" class="form-control description" placeholder="Description" required> </div><div class="col-md-1 form-group"><select class="form-control" name="report_data['+item_count+'][amount_type]"><option value="sales">Sales</option><option value="expense">Expense</option></select></div><div class="col-md-2 form-group"><select class="form-control" name="report_data['+item_count+'][tax_type]"><option value="tax">Tax invoice</option><option value="expense">Zero rated</option></select></div><div class="col-md-1 form-group"><input type="text" name="report_data['+item_count+'][amount]" class="form-control amount" placeholder="Amount" required> </div><div class="col-md-1"><button type="button" class="btn btn-danger btn_itemremove"><i class="fa fa-remove"></i></button></div></div>';
		
		jQuery(".report_items").append(item_div);
		item_count = parseInt(item_count)+1;
		jQuery(".item_count").val(item_count);
		jQuery(".btn_additem").prop('disabled', false);
		
	});
	jQuery(document).on('click','.btn_itemremove',function(){
		jQuery(this).closest('.report_item').remove();
	});
});
</script>
            
    
