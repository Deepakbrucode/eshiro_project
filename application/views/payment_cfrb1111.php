
        
           
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-users"></i>
                                <a href="#">Payments</a>
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
                                            <div class="portlet-body form">
                                            <?php echo $this->session->flashdata('client'); ?>
                                                <!-- BEGIN FORM-->
                                                <form action="<?php echo BASE_URL;?>client/add_client/" method="post" class="form-horizontal">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Date</label>
                                                            <div class="col-md-4">
                                                                <input type="text" name="drc_date" class="form-control" placeholder="Date">
                                                               <!--  <span class="help-block"> A block of help text. </span> -->
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Bank</label>
                                                            <div class="col-md-4">
                                                                <input type="text" name="bank" class="form-control" placeholder="Bank">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Amount</label>
                                                            <div class="col-md-4">
                                                            	<input type="text" name="amount" class="form-control" placeholder="Amount">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">File</label>
                                                            <div class="col-md-4">
                                                            	<input type="text" name="file_name" class="form-control" placeholder="File">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Transaction Type</label>
                                                            <div class="col-md-4">
                                                            	<select name="transaction_type" class="form-control">
                                                                    <option>Select Option</option>
                                                                    <option>Refund</option>
                                                                    <option>Cost</option>
                                                                    <option>Bank Cahrges</option>
                                                                    <option>Fee</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    
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
            
    