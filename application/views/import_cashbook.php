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
                                <span>Import Cashbook</span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->
                    <div class="row">
                    <?php echo $this->session->flashdata('import_cashbook'); ?>
                        <div class="col-md-12">

                        <div class="portlet light portlet-fit  calendar">
                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="portlet light bordered">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="icon-equalizer font-red-sunglo"></i>
                                                    <span class="caption-subject font-red-sunglo bold uppercase">Import Cashbook</span>
                                                    <!-- <span class="caption-helper">details</span> -->
                                                </div>
                                                <div class="actions">
                                                           Download Sample: <a  href="<?php echo BASE_URL; ?>uploads/samples/sample_cashbook.csv" download>
                                                                <i class="fa fa-cloud-download"></i>  CSV
                                                            </a> / 
                                                            <a  href="<?php echo BASE_URL; ?>uploads/samples/sample_cashbook.xls" download>
                                                                <i class="fa fa-cloud-download"></i>   Excel
                                                            </a>

                                                </div>
                                                <!-- <div class="actions">
                                                            <a  href="<?php echo BASE_URL; ?>uploads/sample_cashbook.csv" download>
                                                                <i class="fa fa-cloud-download"></i> Download Sample CSV
                                                            </a>

                                                        </div> -->
                                            </div>
                                                <div class="portlet-body form">
                                                <br>
                                                    <form action="<?php echo BASE_URL; ?>OpeningBalance/import_cashmaping" method="post" enctype="multipart/form-data" name="form1" class="form-horizontal"> 
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label1" style="text-align: right;">Financial Year:</label>
															 <div class="input-group input-large date-picker input-daterange"  >
																<input type="text" name="opening_bal_from" class="form-control" required>
																<span class="input-group-addon"> to </span>
																<input type="text" name="opening_bal_to" class="form-control" required> 
															</div>
														</div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label1" style="text-align: right;">Choose your file:</label>
                                                            <div class="col-md-4">
                                                                <input name="cashbookfile" type="file" id="csv" />
                                                            </div>
                                                        </div>

                                                        <div class="form-actions">
                                                        <div class="row">
                                                            <div class="col-md-offset-3 col-md-9">
                                                                <button type="submit" class="btn green"> Upload</button>
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
   $('.date-picker').datepicker({
                autoclose: true,
                  format: "mm-yyyy",
        viewMode: "months", 
        minViewMode: "months",
                orientation: "bottom"
            });
});
</script>



            
    
