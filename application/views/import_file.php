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
                                <span>Import Client</span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->
                    <div class="row">
                    <?php echo $this->session->flashdata('import_file'); ?>
                        <div class="col-md-12">

                        <div class="portlet light portlet-fit  calendar">
                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="portlet light bordered">
                                            <div class="portlet-title">
                                                <div class="caption">
                                                    <i class="icon-equalizer font-red-sunglo"></i>
                                                    <span class="caption-subject font-red-sunglo bold uppercase">Import Client Opening Balance</span>
                                                    <!-- <span class="caption-helper">details</span> -->
                                                </div>
                                                <div class="actions">
                                                           Download Sample: <a  href="<?php echo BASE_URL; ?>uploads/samples/sample_openingbalance.csv" download>
                                                                <i class="fa fa-cloud-download"></i>  CSV
                                                            </a> / 
                                                            <a  href="<?php echo BASE_URL; ?>uploads/samples/sample_clientledger_excel.xls" download>
                                                                <i class="fa fa-cloud-download"></i>   Excel
                                                            </a>

                                                </div>
                                            </div>
                                                <div class="portlet-body form">
                                                <br>
                                                    <form action="<?php echo BASE_URL; ?>file/import_maping" method="post" enctype="multipart/form-data" name="form1" class="form-horizontal"> 
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label1" style="text-align: right;">Choose your file:</label>
                                                            <div class="col-md-4">
                                                                <input name="userfile" type="file" id="csv" />
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




            
    