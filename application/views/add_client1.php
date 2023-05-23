 <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-users"></i>
                                <a href="#">Client</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <span><?php echo $formname; ?> Client</span>
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
                                                    <span class="caption-subject font-red-sunglo bold uppercase"><?php echo $formname; ?> Client</span>
                                                    <span class="caption-helper"><?php echo $formname; ?> client details</span>
                                                </div>

                                            </div>
                                            <?php  
                                            if($ClientDetail)
                                            {
                                            foreach ($ClientDetail as $value) {
                                                $client_id = $value->client_id;
                                                $firm_name = $value->firm_name;
                                                $directors = $value->directors;
                                                $registered_address = $value->registered_address;
                                                $physical_address = $value->physical_address;
                                                $postal_address = $value->postal_address;
                                                $bank_accounts = $value->bank_accounts;
                                                $start_month = $value->financial_month_start;
                                                $end_month = $value->financial_month_end;
                                               // $status = $value->status;
                                            }
                                            }
                                            else
                                            {
                                                $client_id = '';
                                                $firm_name = '';
                                                $directors = '';
                                                $registered_address = '';
                                                $physical_address = '';
                                                $postal_address = '';
                                                $bank_accounts = '';
                                                $start_month = '3';
                                                 $end_month = '2';
                                               // $status = '';
                                            }

                                            ?>
                                            <div class="portlet-body form">
                                            <?php echo $this->session->flashdata('client'); ?>
                                                <!-- BEGIN FORM-->
                                                <form action="<?php echo BASE_URL;?>client/<?php echo $form_action; ?>" method="post" class="form-horizontal">
                                                    <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Firm Name</label>
                                                            <div class="col-md-4">
                                                                <input type="text" name="firm_name" class="form-control" placeholder="Firm Name" value="<?php echo $firm_name; ?>" required>
                                                               <!--  <span class="help-block"> A block of help text. </span> -->
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Directors</label>
                                                            <div class="col-md-4">
                                                                <input type="text" name="directors" class="form-control" placeholder="Directors" value="<?php echo $directors; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Registered Address</label>
                                                            <div class="col-md-4">
                                                            	<textarea name="registered_address" class="form-control" placeholder="Registered Address"><?php echo $registered_address; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Physical Address</label>
                                                            <div class="col-md-4">
                                                            	<textarea name="physical_address" class="form-control" placeholder="Physical Address"><?php echo $physical_address; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Postal Address</label>
                                                            <div class="col-md-4">
                                                            	<textarea name="postal_address" class="form-control" placeholder="Postal Address"><?php echo $postal_address; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Bank Accounts</label>
                                                            <div class="col-md-4">
                                                            	<input type="text" class="form-control" name="bank_accounts" placeholder="Bank Accounts" value="<?php echo $bank_accounts; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-3 control-label">Financial Month</label>
                                                            <div class="col-md-2">
                                                               
                                                               <select class="form-control" name="start_month">
                                                                   <option value="1" <?php echo ($start_month=='1')?'selected':''; ?> >January</option>
                                                                   <option value="2" <?php echo ($start_month=='2')?'selected':''; ?> >February</option>
                                                                   <option value="3" <?php echo ($start_month=='3')?'selected':''; ?> >March</option>
                                                                   <option value="4" <?php echo ($start_month=='4')?'selected':''; ?> >April</option>
                                                                   <option value="5" <?php echo ($start_month=='5')?'selected':''; ?> >May</option>
                                                                   <option value="6" <?php echo ($start_month=='6')?'selected':''; ?> >June</option>
                                                                   <option value="7" <?php echo ($start_month=='7')?'selected':''; ?> >July</option>
                                                                   <option value="8" <?php echo ($start_month=='8')?'selected':''; ?> >August</option>
                                                                   <option value="9" <?php echo ($start_month=='9')?'selected':''; ?> >September</option>
                                                                   <option value="10" <?php echo ($start_month=='10')?'selected':''; ?> >October</option>
                                                                   <option value="11" <?php echo ($start_month=='11')?'selected':''; ?> >November</option>
                                                                   <option value="12" <?php echo ($start_month=='12')?'selected':''; ?> >December</option>
                                                               </select>
                                                              <!--  <input type="text" class="form-control" name="start_month" placeholder="Start Month" value="<?php echo $bank_accounts; ?>"> -->
                                                            </div>
                                                            <div class="col-md-1" style="width: 10px;padding: 0px;">
                                                            <p>to</p>
                                                            </div>
                                                            <div class="col-md-2">
                                                               
                                                               <select class="form-control" name="end_month">
                                                                   <option value="1" <?php echo ($end_month=='1')?'selected':''; ?> >January</option>
                                                                   <option value="2" <?php echo ($end_month=='2')?'selected':''; ?> >February</option>
                                                                   <option value="3" <?php echo ($end_month=='3')?'selected':''; ?> >March</option>
                                                                   <option value="4" <?php echo ($end_month=='4')?'selected':''; ?> >April</option>
                                                                   <option value="5" <?php echo ($end_month=='5')?'selected':''; ?> >May</option>
                                                                   <option value="6" <?php echo ($end_month=='6')?'selected':''; ?> >June</option>
                                                                   <option value="7" <?php echo ($end_month=='7')?'selected':''; ?> >July</option>
                                                                   <option value="8" <?php echo ($end_month=='8')?'selected':''; ?> >August</option>
                                                                   <option value="9" <?php echo ($end_month=='9')?'selected':''; ?> >September</option>
                                                                   <option value="10" <?php echo ($end_month=='10')?'selected':''; ?> >October</option>
                                                                   <option value="11" <?php echo ($end_month=='11')?'selected':''; ?> >November</option>
                                                                   <option value="12" <?php echo ($end_month=='12')?'selected':''; ?> >December</option>
                                                               </select>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="form-group">
                                                            <label class="col-md-3 control-label">Status</label>
                                                            <div class="col-md-4">
                                                                <label><input type="radio" name="status" value="1" <?php echo ($status == '1')?'checked':''; ?> required>Active</label>
                                                                <label><input type="radio" name="status" value="0" <?php echo ($status == '0')?'checked':''; ?> required>In-Active</label>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                    <div class="form-actions">
                                                        <div class="row">
                                                            <div class="col-md-offset-3 col-md-9">
                                                                <button type="submit" class="btn green"><?php echo $formname; ?> Client</button>
                                                                <button type="button" class="btn default"><a href="<?php echo BASE_URL; ?>client/add_client">Cancel</a></button>
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
            
    