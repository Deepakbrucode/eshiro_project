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
                                            //echo $cost_formact; 
                                           // echo "<pre>";print_r($CostDetail);echo "</pre>";
                                            if($CostSetDetail)
                                            {
                                                foreach ($CostSetDetail as $value) {
    												$set_id = $value->set_id;
                                                    $set_name = $value->set_name;
                                                     $status = $value->status;


                                                }
                                            }
                                            else
                                            {
												$set_id = '';
                                                $set_name = '';
                                                $status='1';

                                            }

                                            ?>
                                            <div class="portlet-body form">
                                            <?php echo $this->session->flashdata('costcentre'); ?>
                                                <!-- BEGIN FORM-->
                                                <form action="<?php echo BASE_URL;?>costcentre/<?php echo $form_action; ?>" method="post" class="form-horizontal">
                                                    <input type="hidden" name="set_id" value="<?php echo $set_id; ?>">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">
                                                                Cost Set Name</label>
                                                            <div class="col-md-4">
                                                                <input type="text" name="set_name" class="form-control " placeholder="Cost Set Name" value="<?php echo $set_name; ?>" required>
                                                               <!--  <span class="help-block"> A block of help text. </span> -->
                                                            </div>
                                                        </div>
                                                       
                                                        

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
                                                                <button type="submit" class="btn green"><?php echo $formname; ?> Set</button>
                                                                <button type="button" class="btn default"><a href="<?php echo BASE_URL; ?>costcentre/show_ccsets">Cancel</a></button>
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
 
    
