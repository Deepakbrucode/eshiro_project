<style type="text/css">
.fin_div {
    border: 1px solid #ccc;
}

.page-content {
    background: #fff !important;
}

.stl_financial_tab {
    padding: 10px;
}

.btn_financial_save {
    float: right;
    margin-bottom: 10px;
}

.trumbowyg-box {
    clear: both;
}

tr.custom-non-asset th {
    font-weight: 400;
}
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
                    <a href="#">Financial Report</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span><?php echo $ledger_title; ?></span>
                </li>
            </ul>
        </div>
        <!-- END PAGE HEADER-->
        <div class="row">

            <?php echo $this->session->flashdata('report'); ?>
            <center>
                <h3>STATEMENT OF FINANCIAL REPORT(<?php echo $start_date."-".$end_date; ?>)</h3>
                <input type="hidden" class="freport_id" value="<?php echo $freport_id; ?>">
                <a href="<?php echo BASE_URL; ?>/uploads/financial_report.pdf" class="finanacial_pdfdownload" download
                    style="display:none;">Download</a>
                <button type="button" class="btn btn-danger btn-md btn_financial_save btn_generate_pdf">Generate
                    PDF</button>
            </center>

            <!-- BEGIN FORM-->
            <div class="col-md-12">

                <div class="fin_div">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#cover">Cover</a></li>
                        <li><a data-toggle="tab" href="#general_info">Main Info</a></li>
                        <li><a data-toggle="tab" href="#reviewer_report"> Report Review</a></li>
                        <li><a data-toggle="tab" href="#response">Response </a></li>
                        <li><a data-toggle="tab" href="#directors">Directors </a></li>
                        <li><a data-toggle="tab" href="#balance">Balance </a></li>
                        <li><a data-toggle="tab" href="#income">Income </a></li>
                        <li><a data-toggle="tab" href="#equity">Equity </a></li>
                        <li><a data-toggle="tab" href="#cash_flow">Cash Flow </a></li>

                        <li><a data-toggle="tab" href="#accpolicies">AccPolicies </a></li>
                        <!-- <li><a data-toggle="tab" href="#asset_schedule">Asset Schedule </a></li> -->
                        <li><a data-toggle="tab" href="#notes">Notes </a></li>

                        <li><a data-toggle="tab" href="#detailedis">DetailedIS </a></li>
                    </ul>

                    <div class="stl_financial_tab tab-content">
                        <div id="cover" class="tab-pane fade in active">
                            <form class="form_cover">
                                <button type="button"
                                    class="btn btn-success btn-lg btn_financial_save btn_save_report">Save</button>
                                <?php
                                $rid = $cover_txt = '';
                                    if($cover_data) { 
                                        $rid = $cover_data->id;
                                        $cover_txt = $cover_data->meta_value;
                                    }
                                ?>

                                <input type="hidden" class="rid" value="<?php echo $rid; ?>">
                                <input type="hidden" class="rid_meta" value="cover">
                                <textarea name="cover_txt" class="editor_textarea"
                                    id="cover_txt"><?php echo $cover_txt; ?></textarea>
                            </form>
                        </div>
                        <div id="general_info" class="tab-pane fade">
                            <!-- <h3>GENERAL INFORMATION</h3> -->
                            <form class="form_general_info">
                                <button type="button"
                                    class="btn btn-success btn-lg btn_financial_save btn_save_report">Save</button>
                                <?php
                                $rid = $general_info_txt = '';
                                    if($general_info_data) { 
                                        $rid = $general_info_data->id;
                                        $general_info_txt = $general_info_data->meta_value;
                                    }
                                ?>

                                <input type="hidden" class="rid" value="<?php echo $rid; ?>">
                                <input type="hidden" class="rid_meta" value="general_info">
                                <textarea name="general_info_txt" class="editor_textarea"
                                    id="general_info_txt"><?php echo $general_info_txt; ?></textarea>
                            </form>
                        </div>
                        <!-- report review start -->
                        <div id="reviewer_report" class="tab-pane fade">
                            <form class="form_general_info">
                                <button type="button"
                                    class="btn btn-success btn-lg btn_financial_save btn_save_report">Save</button>
                                <?php
                                $rid = $independent_review_report_txt = '';
                                    if($independent_review_report_data) { 
                                        $rid = $independent_review_report_data->id;
                                        $independent_review_report_txt = $independent_review_report_data->meta_value;
                                    }
                                ?>

                                <input type="hidden" class="rid" value="<?php echo $rid; ?>">
                                <input type="hidden" class="rid_meta" value="independent_review_report">
                                <textarea name="indepent_review_txt" class="editor_textarea"
                                    id="indepent_review_txt"><?php echo $independent_review_report_txt; ?></textarea>
                            </form>
                        </div>
                        <!-- report review end -->

                        <!-- Response start -->
                        <div id="response" class="tab-pane fade">
                            <form class="form_general_info">
                                <button type="button"
                                    class="btn btn-success btn-lg btn_financial_save btn_save_report">Save</button>
                                <?php
                                $rid = $response_txt = '';
                                    if($response_data) { 
                                        $rid = $response_data->id;
                                        $response_txt = $response_data->meta_value;
                                    }
                                ?>

                                <input type="hidden" class="rid" value="<?php echo $rid; ?>">
                                <input type="hidden" class="rid_meta" value="response">
                                <textarea name="response_txt" class="editor_textarea"
                                    id="response_txt"><?php echo $response_txt; ?></textarea>
                            </form>
                        </div>
                        <!-- Response end -->

                        <!-- Directors start -->
                        <div id="directors" class="tab-pane fade">
                            <form class="form_general_info">
                                <button type="button"
                                    class="btn btn-success btn-lg btn_financial_save btn_save_report">Save</button>
                                <?php
                                $rid = $directors_txt = '';
                                    if($directors_data) { 
                                        $rid = $directors_data->id;
                                        $directors_txt = $directors_data->meta_value;
                                    }
                                ?>

                                <input type="hidden" class="rid" value="<?php echo $rid; ?>">
                                <input type="hidden" class="rid_meta" value="directors">
                                <textarea name="directors_txt" class="editor_textarea"
                                    id="directors_txt"><?php echo $directors_txt; ?></textarea>
                            </form>
                        </div>
                        <!-- Directors end -->

                        <!-- balance start -->
                        <div id="balance" class="tab-pane fade">
                            <?php
                            if($balance_data) { 
                                echo $balance_data;
                            }
                            ?>
                        </div>
                        <!-- balance end -->

                        <!-- income start -->
                        <div id="income" class="tab-pane fade">
                            <?php
                            if($income_data)
                            {
                                echo $income_data;

                            }
                            ?>
                        </div>
                        <!-- income end -->

                        <!-- equity start -->
                        <div id="equity" class="tab-pane fade">
                            <?php
                            if($equity_data)
                            {
                                echo $equity_data;
                            }
                            ?>
                        </div>

                        <!-- equity end -->
                        <!-- cash_flow_data start -->
                        <div id="cash_flow" class="tab-pane fade">
                            <?php
                            $cf_rowcount = 0;$rid ='';
                            $meta_value = array();
                            if($cash_flow_data)
                            {
                                $meta_value = $cash_flow_data->meta_value;
                                $rid = $cash_flow_data->id;
                                $meta_value = unserialize($meta_value);
                                $cf_rowcount = count($meta_value);
                            }
                            ?>
                            <form class="form_cash_flow">
                                <input type="hidden" class="cfreport_id" name='cfreport_id'
                                    value="<?php echo $freport_id; ?>">
                                <input type="hidden" class="cf_rowcount" value="<?php echo $cf_rowcount; ?>">
                                <input type="hidden" class="rid" name='rid' value="<?php echo $rid; ?>">
                                <input type="hidden" class="rid_meta" name='rid_meta' value="cash_flow">

                                <button type="button" class="btn btn-primary btn-md  btn_add_cashflow_row">Add
                                    Row</button>
                                <button type="button" class="btn btn-success btn-lg  btn_save_cashflow"
                                    style="float:right;">Save</button>
                                <table class="table table-striped table-hover stl_costtbl cashflow_tb">
                                    <thead>
                                        <tr>
                                            <th>Figures in R</th>
                                            <th><?php echo $end_day; ?></th>
                                            <th><?php echo $previous_end_day; ?></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ccount = 0;
                                            foreach($meta_value as $key => $val)
                                            {
                                                $ccount++;
                                                ?>
                                        <tr>
                                            <td><input type='text' class='form-control cf_desc'
                                                    name='cashflow[<?php echo $ccount; ?>][desc]'
                                                    value="<?php echo $val['desc']; ?>"></td>
                                            <td><input type='text' class='form-control curr_cost'
                                                    name='cashflow[<?php echo $ccount; ?>][ccost]'
                                                    value="<?php echo $val['ccost']; ?>"></td>
                                            <td><input type='text' class='form-control prev_cost'
                                                    name='cashflow[<?php echo $ccount; ?>][pcost]'
                                                    value="<?php echo $val['pcost']; ?>"></td>
                                            <td><button type='button'
                                                    class='btn btn-sm btn-danger btn_deleterow'>X</button></td>
                                        </tr>
                                        <?php

                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </form>
                        </div>

                        <!-- cash_flow_data end -->

                        <!-- accpolicies start -->
                        <div id="accpolicies" class="tab-pane fade">
                            <form class="form_general_info">
                                <button type="button"
                                    class="btn btn-success btn-lg btn_financial_save btn_save_report">Save</button>
                                <?php
                                $rid = $accpolicies_txt = '';
                                    if($accpolicies_data) { 
                                        $rid = $accpolicies_data->id;
                                        $accpolicies_txt = $accpolicies_data->meta_value;
                                    }
                                ?>

                                <input type="hidden" class="rid" value="<?php echo $rid; ?>">
                                <input type="hidden" class="rid_meta" value="accpolicies">
                                <textarea name="accpolicies_txt" class="editor_textarea"
                                    id="accpolicies_txt"><?php echo $accpolicies_txt; ?></textarea>
                            </form>
                        </div>
                        <!-- accpolicies end -->
                        <!--  start ---->
                        <!-- <div id="asset_schedule" class="tab-pane fade">
                            <?php echo $asset_sch_data; ?>
                           
                        </div> -->
                        <!-- asset_schedule end -------->
                        <!-- notes start -->
                        <div id="notes" class="tab-pane fade">
                            <?php echo $asset_sch_data; ?>

                            <?php
                            $ca_rowcount = 0;$rid ='';
                            $meta_value = array();
                            if($cur_asset_data)
                            {
                                $meta_value = $cur_asset_data->meta_value;
                                $rid = $cur_asset_data->id;
                                $meta_value = unserialize($meta_value);
                                $ca_rowcount = count($meta_value);
                            }
                            ?>
                            <form class="form_current_asset">
                                <input type="hidden" class="cfreport_id" name='cfreport_id'
                                    value="<?php echo $freport_id; ?>">
                                <input type="hidden" class="ca_rowcount" value="<?php echo $ca_rowcount; ?>">
                                <input type="hidden" class="rid" name='rid' value="<?php echo $rid; ?>">
                                <input type="hidden" class="rid_meta" name='rid_meta' value="current_asset">

                                <button type="button" class="btn btn-primary btn-md  btn_add_casset_row">Add
                                    Row</button>
                                <button type="button" class="btn btn-success btn-lg  btn_save_casset"
                                    style="float:right;">Save</button>
                                <table class="table table-striped table-hover stl_costtbl cur_asset_tb">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>NBV</th>
                                            <th>Additions</th>
                                            <th>Disposals</th>
                                            <th>Depreciation</th>
                                            <th><?php echo $end_day; ?> Carrying value at beginning of year</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ccount = 0;
                                            foreach($meta_value as $key => $val)
                                            {
                                                $ccount++;
                                                ?>
                                        <tr>
                                            <td><input type='text' class='form-control desc'
                                                    name='cur_asset[<?php echo $ccount; ?>][desc]'
                                                    value="<?php echo $val['desc']; ?>"></td>
                                            <td><input type='text' class='form-control nbv'
                                                    name='cur_asset[<?php echo $ccount; ?>][nbv]'
                                                    value="<?php echo $val['nbv']; ?>"></td>
                                            <td><input type='text' class='form-control addit'
                                                    name='cur_asset[<?php echo $ccount; ?>][addit]'
                                                    value="<?php echo $val['addit']; ?>"></td>
                                            <td><input type='text' class='form-control disp'
                                                    name='cur_asset[<?php echo $ccount; ?>][disp]'
                                                    value="<?php echo $val['disp']; ?>"></td>
                                            <td><input type='text' class='form-control depr'
                                                    name='cur_asset[<?php echo $ccount; ?>][depr]'
                                                    value="<?php echo $val['depr']; ?>"></td>
                                            <td><input type='text' class='form-control cyear_nbv'
                                                    name='cur_asset[<?php echo $ccount; ?>][cyear_nbv]'
                                                    value="<?php echo $val['cyear_nbv']; ?>"></td>
                                            <td><button type='button'
                                                    class='btn btn-sm btn-danger btn_deleterow'>X</button></td>
                                        </tr>
                                        <?php

                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </form>

                            <?php
                            $pa_rowcount = 0;$rid ='';
                            $meta_value = array();
                            if($pr_asset_data)
                            {
                                $meta_value = $pr_asset_data->meta_value;
                                $rid = $pr_asset_data->id;
                                $meta_value = unserialize($meta_value);
                                $pa_rowcount = count($meta_value);
                            }
                            ?>
                            <form class="form_previous_asset">
                                <input type="hidden" class="cfreport_id" name='cfreport_id'
                                    value="<?php echo $freport_id; ?>">
                                <input type="hidden" class="pa_rowcount" value="<?php echo $pa_rowcount; ?>">
                                <input type="hidden" class="rid" name='rid' value="<?php echo $rid; ?>">
                                <input type="hidden" class="rid_meta" name='rid_meta' value="previous_asset">

                                <button type="button" class="btn btn-primary btn-md  btn_add_passet_row">Add
                                    Row</button>
                                <button type="button" class="btn btn-success btn-lg  btn_save_passet"
                                    style="float:right;">Save</button>
                                <table class="table table-striped table-hover stl_costtbl pr_asset_tb">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>NBV</th>
                                            <th>Additions</th>
                                            <th>Disposals</th>
                                            <th>Depreciation</th>
                                            <th><?php echo $previous_end_day; ?> Carrying value at beginning of year
                                            </th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ccount = 0;
                                            foreach($meta_value as $key => $val)
                                            {
                                                $ccount++;
                                                ?>
                                        <tr>
                                            <td><input type='text' class='form-control desc'
                                                    name='pr_asset[<?php echo $ccount; ?>][desc]'
                                                    value="<?php echo $val['desc']; ?>"></td>
                                            <td><input type='text' class='form-control nbv'
                                                    name='pr_asset[<?php echo $ccount; ?>][nbv]'
                                                    value="<?php echo $val['nbv']; ?>"></td>
                                            <td><input type='text' class='form-control addit'
                                                    name='pr_asset[<?php echo $ccount; ?>][addit]'
                                                    value="<?php echo $val['addit']; ?>"></td>
                                            <td><input type='text' class='form-control disp'
                                                    name='pr_asset[<?php echo $ccount; ?>][disp]'
                                                    value="<?php echo $val['disp']; ?>"></td>
                                            <td><input type='text' class='form-control depr'
                                                    name='pr_asset[<?php echo $ccount; ?>][depr]'
                                                    value="<?php echo $val['depr']; ?>"></td>
                                            <td><input type='text' class='form-control cyear_nbv'
                                                    name='pr_asset[<?php echo $ccount; ?>][cyear_nbv]'
                                                    value="<?php echo $val['cyear_nbv']; ?>"></td>
                                            <td><button type='button'
                                                    class='btn btn-sm btn-danger btn_deleterow'>X</button></td>
                                        </tr>
                                        <?php

                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </form>

                            <form class="form_general_info">
                                <button type="button"
                                    class="btn btn-success btn-lg btn_financial_save btn_save_report">Save</button>
                                <?php
                                $rid = $notes_txt = '';
                                // $notes_txt = $notes_data;
                                    if($notes_data) { 
                                        $rid = $notes_data->id;
                                        $notes_txt = $notes_data->meta_value;
                                    }
                                ?>

                                <input type="hidden" class="rid" value="<?php echo $rid; ?>">
                                <input type="hidden" class="rid_meta" value="notes">
                                <textarea name="notes_txt" class="editor_textarea"
                                    id="notes_txt"><?php echo $notes_txt; ?></textarea>
                            </form>
                        </div>
                        <!-- notes end -->

                        <!-- detailedis start -->
                        <div id="detailedis" class="tab-pane fade">
                            <?php
                            if($detailedis_data)
                            {
                                echo $detailedis_data;
                            }
                            ?>
                        </div>
                        <!-- detailedis end -->


                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/ui/trumbowyg.min.css -->
">
<!-- https://alex-d.github.io/Trumbowyg/documentation/ -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.2/trumbowyg.min.js"></script> -->
<script type="text/javascript">
$(document).ready(function() {
    // $('#cover_txt').trumbowyg();
    $('.editor_textarea').trumbowyg({
        btns: [
            ['viewHTML'],
            ['undo', 'redo'], // Only supported in Blink browsers
            ['formatting'],
            ['strong', 'em', 'del'],
            ['superscript', 'subscript'],
            ['link'],
            ['insertImage'],
            ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
            ['unorderedList', 'orderedList'],
            ['horizontalRule'],
            ['removeformat'],
            ['fullscreen'],
            ['table']
        ],
    });


    $(".btn_add_cashflow_row").click(function() {
        // console.log("ttttt");
        var cf_rowcount = $(".cf_rowcount").val();
        cf_rowcount = parseInt(cf_rowcount) + 1;
        var add_r = "<tr><td><input type='text' class='form-control cf_desc' name='cashflow[" +
            cf_rowcount +
            "][desc]'></td><td><input type='text' class='form-control curr_cost' name='cashflow[" +
            cf_rowcount +
            "][ccost]'></td><td><input type='text' class='form-control prev_cost' name='cashflow[" +
            cf_rowcount +
            "][pcost]'></td><td><button type='button' class='btn btn-sm btn-danger btn_deleterow'>X</button></td></tr>";
        $(".cf_rowcount").val(cf_rowcount);
        $(".cashflow_tb tbody").append(add_r);
    });
    $(".btn_add_casset_row").click(function() {
        // console.log("ttttt");
        var ca_rowcount = $(".ca_rowcount").val();
        ca_rowcount = parseInt(ca_rowcount) + 1;

        var add_r = "<tr><td><input type='text' class='form-control desc' name='cur_asset[" +
            ca_rowcount +
            "][desc]'></td><td><input type='text' class='form-control currnbv_cost' name='cur_asset[" +
            ca_rowcount +
            "][nbv]'></td><td><input type='text' class='form-control addit' name='cur_asset[" +
            ca_rowcount +
            "][addit]'></td><td><input type='text' class='form-control disp' name='cur_asset[" +
            ca_rowcount +
            "][disp]'></td><td><input type='text' class='form-control depr' name='cur_asset[" +
            ca_rowcount +
            "][depr]'></td><td><input type='text' class='form-control cyear_nbv' name='cur_asset[" +
            ca_rowcount +
            "][cyear_nbv]'></td><td><button type='button' class='btn btn-sm btn-danger btn_deleterow'>X</button></td></tr>";
        $(".ca_rowcount").val(ca_rowcount);
        $(".cur_asset_tb tbody").append(add_r);
    });
    $(".btn_add_passet_row").click(function() {
        // console.log("ttttt");
        var pa_rowcount = $(".pa_rowcount").val();
        pa_rowcount = parseInt(pa_rowcount) + 1;

        var add_r = "<tr><td><input type='text' class='form-control desc' name='pr_asset[" +
            pa_rowcount +
            "][desc]'></td><td><input type='text' class='form-control currnbv_cost' name='pr_asset[" +
            pa_rowcount +
            "][nbv]'></td><td><input type='text' class='form-control addit' name='pr_asset[" +
            pa_rowcount +
            "][addit]'></td><td><input type='text' class='form-control disp' name='pr_asset[" +
            pa_rowcount +
            "][disp]'></td><td><input type='text' class='form-control depr' name='pr_asset[" +
            pa_rowcount +
            "][depr]'></td><td><input type='text' class='form-control cyear_nbv' name='pr_asset[" +
            pa_rowcount +
            "][cyear_nbv]'></td><td><button type='button' class='btn btn-sm btn-danger btn_deleterow'>X</button></td></tr>";
        $(".pa_rowcount").val(pa_rowcount);
        $(".pr_asset_tb tbody").append(add_r);
    });
    $(document).on('click', '.btn_deleterow', function() {
        $(this).closest('tr').remove();
    })




    /*$(document).on('click','.btn_save_cover',function(){
         var cover_txt = jQuery("#cover_txt").val();
         var freport_id = jQuery(".freport_id").val();
         var rid = jQuery(".rid_cover").val();
         ajax_save_fn(cover_txt,freport_id,rid,'cover');
     })
    $(document).on('click','.btn_save_general_info',function(){
         var general_info_txt = jQuery("#general_info_txt").val();
         var freport_id = jQuery(".freport_id").val();
         var rid = jQuery(".rid_general").val();
         ajax_save_fn(general_info_txt,freport_id,rid,'general_info');
     })
    $(document).on('click','.btn_save_independent_review_report',function(){
         var info_txt = jQuery("#indepent_review_txt").val();
         var freport_id = jQuery(".freport_id").val();
         var rid = jQuery(".rid_general").val();
         ajax_save_fn(info_txt,freport_id,rid,'independent_review_report');

     });*/


    $(document).on('click', '.btn_save_cashflow', function() {

        $.ajax({
            url: '<?php echo BASE_URL; ?>' + 'financialreport/ajax_save_cash_flow',
            type: 'POST',
            dataType: "json",
            data: $('.form_cash_flow').serialize(),
            success: function(data) {
                if (data['insert_status']) {
                    alert("Details saved successfully");
                } else {
                    alert("Error in save function");
                }
            }
        });

    });
    $(document).on('click', '.btn_save_casset', function() {

        $.ajax({
            url: '<?php echo BASE_URL; ?>' + 'financialreport/ajax_save_current_asset',
            type: 'POST',
            dataType: "json",
            data: $('.form_current_asset').serialize(),
            success: function(data) {
                if (data['insert_status']) {
                    alert("Details saved successfully");
                } else {
                    alert("Error in save function");
                }
            }
        });

    });
    $(document).on('click', '.btn_save_passet', function() {

        $.ajax({
            url: '<?php echo BASE_URL; ?>' + 'financialreport/ajax_save_previous_asset',
            type: 'POST',
            dataType: "json",
            data: $('.form_previous_asset').serialize(),
            success: function(data) {
                if (data['insert_status']) {
                    alert("Details saved successfully");
                } else {
                    alert("Error in save function");
                }
            }
        });

    });
    $(document).on('click', '.btn_save_report', function() {
        // var info_txt = jQuery("#indepent_review_txt").val();
        // var freport_id = jQuery(".freport_id").val();
        // var rid = jQuery(".rid_general").val();
        var info_txt = jQuery(this).closest('form').find('.editor_textarea').val();
        var freport_id = jQuery(".freport_id").val();
        var rid = jQuery(this).closest('form').find(".rid").val();
        var rid_meta = jQuery(this).closest('form').find(".rid_meta").val();

        ajax_save_fn(info_txt, freport_id, rid, rid_meta);

    });

    function ajax_save_fn(info_txt, freport_id, rid, meta_key) {
        $.ajax({
            url: '<?php echo BASE_URL; ?>' + 'financialreport/ajax_save_financial_report',
            type: 'POST',
            dataType: "json",
            data: {
                'info_txt': info_txt,
                'freport_id': freport_id,
                'rid': rid,
                'meta_key': meta_key
            },
            success: function(data) {
                if (data['insert_status']) {
                    alert("Details saved successfully");
                }
            }
        });
    }




    $(document).on('click', '.btn_generate_pdf', function() {
        var freport_id = jQuery(".freport_id").val();
        $.ajax({
            url: '<?php echo BASE_URL; ?>' + 'financialreport/generate_financial_report_pdf',
            type: 'POST',
            dataType: "html",
            data: {
                'freport_id': freport_id
            },
            success: function(data) {

                $('.finanacial_pdfdownload')[0].click();

            }
        });



    })


});
</script>