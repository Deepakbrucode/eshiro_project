<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
	<!-- BEGIN CONTENT BODY -->
	<div class="page-content">
		<!-- BEGIN PAGE HEADER-->
        <div class="page-bar">
			<ul class="page-breadcrumb">
				<li>
					<i class="fa fa-users"></i>
                    <a href="#">Report</a>
                    <i class="fa fa-angle-right"></i>
                 </li>
                 <li>
					<span>Vat201</span>
                 </li>
			</ul>
		</div>
		<!-- END PAGE HEADER-->
		<div class="row">
			<?php 
			
			//echo "<pre>";print_r($this->session->userinfo);echo "</pre>"; 
			echo $this->session->flashdata('report'); ?>
				<div class="col-md-12">
					<div class="portlet light portlet-fit  calendar">
						<div class="portlet-body">
							<div class="row">
								<div class="portlet light bordered">
									<div class="portlet-title">
										<div class="caption">
											<i class="icon-equalizer font-red-sunglo"></i>
											<span class="caption-subject font-red-sunglo bold uppercase">Vat201</span>
											<span class="caption-helper">Vat201</span>
										 </div>
                                    </div>
									<div class="portlet-body form">
										<?php echo $this->session->flashdata('report'); ?>
                                        <!-- BEGIN FORM-->
										<div class="row">
											<form method="post" action="<?php echo BASE_URL; ?>reports/control_account">
												<div class="col-md-12">
													<?php 
            if($usertype == '5') { ?>
            <div class="col-md-12">
                <div class="col-md-2" style="text-align: right;"><span>Client Name</span></div>
                <div class="col-md-6">
                	<div class="row">
                <select name="client_id" class="form-control client_id">
                <?php if($ClientDetails){
                    foreach($ClientDetails as $ClientDetail) { 
                        $selected = ($fclient_id == $ClientDetail->id)?'selected':'';
                    echo "<option value='".$ClientDetail->id."' ".$selected.">".$ClientDetail->name."</option>";

                 } } else {echo "<option value=''>No clients Available</option>";} ?>
                </select><br>
            </div>
                </div>
                </div>
            <?php } else {echo "<input type='hidden' class='client_id' value='".$this->session->userinfo->id."'>"; }?>
													<div class="col-md-6">
														<div class="form-group col-md-12">
															<label class="col-md-4 control-label">Report Period</label>
															<div class="col-md-8">
																<div class="input-group input-large date-picker input-daterange"  >
																	<input type="text" name="opening_bal_from" class="form-control opening_bal_from">
																	<span class="input-group-addon"> to </span>
																	<input type="text" name="opening_bal_to" class="form-control opening_bal_to"> 
																</div>
															</div>
														</div>
													</div>
<!--
													<div class="col-md-2">
														<select class="form-control report_type" name="report_type">
															<option value="selected_date">Selected Timeframe</option>
															<option value="all_date">All Dates</option>
														</select>

													</div>
-->
													<div class="col-md-6" style="text-align:right;margin-bottom:15px;">
														<button type="button" class="btn btn-success btn_casubmit btn_ajaxstart">Show Report</button>
														<button class="btn btn-success btn_ajaxend" style="display:none;"><i class="fa fa-refresh fa-spin"></i>Loading</button>

													</div>
												</div>
											</form>
											
											<div class="col-md-12">
												<div class="table_content"></div>
											</div>
										</div>
									</div>
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
<script type="text/javascript">
jQuery(document).ready(function() {

       $('.date-picker').datepicker({
                autoclose: true,
                  format: "dd/mm/yyyy",
        /*viewMode: "months", 
        minViewMode: "months",*/
                orientation: "bottom"
            });



$(document).ajaxStart(function(){
    jQuery(".btn_ajaxstart").hide();
    jQuery(".btn_ajaxend").show();
});


$(document).ajaxComplete(function(){
    jQuery(".btn_ajaxstart").show();
    jQuery(".btn_ajaxend").hide();
});


jQuery(document).on('click','.btn_casubmit',function(){
	
	var opening_bal_from = $(".opening_bal_from").val();
	var opening_bal_to = $(".opening_bal_to").val();
	var client_id = $(".client_id").val() || '';
	//var report_type = $(".report_type").val();
	
	jQuery(".table_content").html('');
	
	 var src = '<?php echo BASE_URL; ?>'+'reports/ajax_vat';
     $.ajax({
                    url: src,
                    type:'GET',
                    //dataType: "json",
                    dataType: "json",
                    data: {'opening_bal_from':opening_bal_from,"opening_bal_to" : opening_bal_to,'client_id':client_id },
                    success: function(data) {
						
						if(data.status =='1')
						{
							jQuery(".table_content").html(data.table_content);
							//alert("ddddddddd");
							setTimeout(function(){
								

								//window.location.href = data.pdfuurl;
								
								
								//alert("qqqqqqqqqqqqQQQQQ");
								//jQuery(".vat_pdfdownload").trigger('click');
								
								}, 800);
						}
                    },
					complete: function(xhr, textStatus) {
						console.log(xhr.status);
						jQuery(".table_content").html("<br><br><div class='col-md-12' style='text-align:center;' ><a href='https://eshiro.app/uploads/vat201.pdf' class='btn purple-sharp  btn-outline1 vat_pdfdownload' download=''><i class='fa fa-file-excel-o'></i> Download VAT PDF</a></div>");
					} 
                });

	
});
 
});
</script>
           

