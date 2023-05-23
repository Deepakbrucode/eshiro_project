            <style>

            .btn-group{
                width: 140px;
                position: relative;
                display: inline-flex;
            }
            .popover.confirmation.fade.top.in{margin-left: -5%;}

             </style>
        
           
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-users"></i>
                                <a href="#">Setting</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <span><?php echo $title; ?></span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->
                    <div class="row">
                    <?php echo $this->session->flashdata('Rollback'); ?>
                        <div class="col-md-12">

                        <div class="portlet light portlet-fit  calendar">
                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="portlet light bordered">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="icon-equalizer font-red-sunglo"></i>
                                                    <span class="caption-subject font-red-sunglo bold uppercase"><?php echo $title; ?></span>
                                                    <!-- <span class="caption-helper">details</span> -->
                                                </div>
                                                <div class="actions">
                                                           

                                                </div>
                                            </div>
                                                <div class="portlet-body form">
                                                <br>
                                                    <form action="<?php echo BASE_URL; ?>OpeningBalance/ajax_rollforward" method="post" enctype="multipart/form-data" name="form1" class="form-horizontal"> 
														<div class="form-group">
                                                            <label class="col-md-3 control-label1" style="text-align: right;">Previous Financial Year:</label>
															 <div class="input-group input-large roll_backfrom date-picker input-daterange"  >
																<input type="text" name="roll_back_pfrom" class="form-control roll_back_pfrom" required>
																<span class="input-group-addon"> to </span>
																<input type="text" name="roll_back_pto" class="form-control roll_back_pto" required> 
															</div>
														</div>
														<div class="form-group">
                                                            <label class="col-md-3 control-label1" style="text-align: right;">Next Financial Year:</label>
															 <div class="input-group input-large roll_backto date-picker input-daterange"  >
																<input type="text" name="roll_back_nfrom" class="form-control roll_back_nfrom" required>
																<span class="input-group-addon"> to </span>
																<input type="text" name="roll_back_nto" class="form-control roll_back_nto" required> 
															</div>
														</div>

                                                        <div class="form-actions">
                                                        <div class="row">
                                                            <div class="col-md-offset-3 col-md-9">
                                                                <button type="submit" class="btn green btn_submit"> Roll Forward</button>
                                                                <!-- <button type="button" class="btn default"><a href="<?php echo BASE_URL; ?>file/add_file">Cancel</button> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </form> 
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
<script>
jQuery(document).ready(function(){
   $('.roll_backfrom').datepicker({
                autoclose: true,
                  format: "mm-yyyy",
        viewMode: "months", 
        minViewMode: "months",
                orientation: "bottom"
            });
            
            $('.roll_backto').datepicker({
                autoclose: true,
                  format: "mm-yyyy",
        viewMode: "months", 
        minViewMode: "months",
                orientation: "bottom"
            });
            
            
            $(document).on('click','.btn_submit',function(){
				var roll_back_pfrom = jQuery(".roll_back_pfrom").val();
				var roll_back_pto = jQuery(".roll_back_pto").val();
				var roll_back_nfrom = jQuery(".roll_back_nfrom").val();
				var roll_back_nto = jQuery(".roll_back_nto").val();
				var src = '<?php echo BASE_URL; ?>'+'openingbalance/ajax_rollforward';
				 $.ajax({
                    url: src,
                    type:'POST',
                    dataType: "json",
                    data: {'roll_back_pfrom':roll_back_pfrom,'roll_back_pto':roll_back_pto,'roll_back_nfrom':roll_back_nfrom,'roll_back_nto':roll_back_nto},
                    success: function(data) {



                 


                    }
                });
                
			});
});
</script>



            
    
