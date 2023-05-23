
<style>
    .btn-group{
        /*width: 140px;*/
        width: auto;
        position: relative;
        display: inline-flex;
    }
    .popover.confirmation.fade.top.in{margin-left: -5%;}
    .table_frminput{    margin-bottom: 5px;
    clear: both;}
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
                    <a href="#">Financials</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>STATEMENT OF FINANCIAL POSITION</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE HEADER-->
        <div class="row">

            <?php echo $this->session->flashdata('report'); ?>
            <center><h3>STATEMENT OF FINANCIAL POSITION</h3></center>
            <input type="hidden" class="report_type" value="<?php echo $report_type; ?>">
            <a href="<?php echo BASE_URL; ?>/uploads/financial_position.pdf" class="cash_pdfdownload" download >Download</a>  
        
            
            <!-- BEGIN FORM-->
            <div class="col-md-12">
                
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->





<script type="text/javascript">
    


            </script>
