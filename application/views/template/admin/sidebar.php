 <div class="clearfix"> </div>
 <?php 
 $client_id= $this->session->id;
 // $client_id = '31';
 $bank_accounts = $this->reports_model->getDetails('bank_accounts',array('client_id' => $client_id));
 // echo "<pre>";print_r($bank_accounts);echo "</pre>";
 // if(!empty($bank_accounts))
 // echo "sizeof = ".sizeof($bank_accounts);
 // echo "<pre>bank_accounts";print_r($bank_accounts);echo "</pre>";
 ?>
 <!-- BEGIN HEADER & CONTENT DIVIDER -->
       
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER --> <!-- container end in footer.php -->
        <div class="page-container">
 <!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- END SIDEBAR -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                <div class="page-sidebar navbar-collapse collapse">
                    <!-- BEGIN SIDEBAR MENU -->
                    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                        <li class="nav-item start <?php if($current_menu == 'dashboard'){echo 'active';}?>">
                            <a href="<?php echo BASE_URL; ?>dashboard" class="nav-link nav-toggle">
                                <i class="fa fa-dashboard"></i>
                                <span class="title">Dashboard</span>
                                <span class="arrow"></span>
                            </a>
                        </li>
                        <?php 
                         if(($_SESSION['usertype'])== 5) {
							 ?>
                        <li class="nav-item start <?php if($current_menu == 'show_clients' || $current_menu == 'add_client'){echo 'active';}?>">
                            <a href="<?php echo BASE_URL; ?>client/" class="nav-link nav-toggle">
                                <i class="fa fa-users"></i>
                                <span class="title">Clients</span>
                                <?php if($current_menu == 'show_clients' || $current_menu == 'add_client'){ echo '<span class="selected"></span>'; }
                                 ?>
                                <span class="arrow"></span>
                            </a>

                        </li>
                        <?php } ?>

                        <!-- <li class="nav-item start <?php if($current_menu == 'show_costcentre' || $current_menu == 'add_costcentre'){echo 'active';}?>">
                            <a href="<?php echo BASE_URL; ?>costcentre/" class="nav-link nav-toggle">
                                <i class="fa fa-anchor"></i>
                                <span class="title">Cost Centres</span>
                                <span class="arrow"></span>
                            </a>

                        </li> -->
                        <li class="nav-item start <?php if($current_menu == 'show_costcentre' || $current_menu == 'add_costcentre' || $current_menu == 'show_category' || $current_menu == 'show_subcategory'  || $current_menu =='show_ccsets'  || $current_menu == 'add_costset' || $current_menu == 'add_bankaccount' || $current_menu == 'fixed_asset_setting' || $current_menu=='edit_asset_dep'){echo 'active';}?>">
                            <a href="javascript:void(0);" class="nav-link nav-toggle">
                                <i class="icon-settings"></i>
                                <span class="title">Settings</span>
                                <?php if($current_menu == 'show_costcentre' || $current_menu == 'add_costcentre' || $current_menu == 'show_category' || $current_menu == 'show_subcategory' || $current_menu =='show_ccsets' || $current_menu == 'add_costset'){ echo '<span class="selected"></span>'; }
                                 ?>


                                <span class="arrow"></span>
                            </a>
                             <ul class="sub-menu">

                                <li class="nav-item start <?php if($current_menu == 'show_costcentre' || $current_menu == 'add_costcentre'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>costcentre/" class="nav-link nav-toggle">
                                        <i class="fa fa-anchor"></i>
                                        <span class="title">Cost Centres</span>
                                        <span class="arrow"></span>
                                    </a>

                                </li>
                                <li class="nav-item start <?php if($current_menu == 'bank_accounts' || $current_menu == 'add_bankaccount'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>client/showBankAccounts" class="nav-link nav-toggle">
                                        <i class="fa fa-anchor"></i>
                                        <span class="title">Bank Accounts</span>
                                        <span class="arrow"></span>
                                    </a>

                                </li>
                                <li class="nav-item start <?php if($current_menu == 'fixed_asset_setting' || $current_menu == 'edit_asset_dep'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>financialreport/fixed_asset_setting" class="nav-link nav-toggle">
                                        <i class="fa fa-anchor"></i>
                                        <span class="title">Fixed Asset</span>
                                        <span class="arrow"></span>
                                    </a>

                                </li>
                                <?php
                                $usertype= $this->session->usertype;
                                if($usertype == '5') {
                                ?>
                                <li class="nav-item start <?php if($current_menu == 'show_category'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>costcentre/show_category/" class="nav-link nav-toggle">
                                        <i class="fa fa-anchor"></i>
                                        <span class="title">Show Category</span>
                                        <span class="arrow"></span>
                                    </a>

                                </li>
                                <li class="nav-item start <?php if($current_menu == 'show_subcategory'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>costcentre/show_subcategory/" class="nav-link nav-toggle">
                                        <i class="fa fa-anchor"></i>
                                        <span class="title">Show SubCategory</span>
                                        <span class="arrow"></span>
                                    </a>

                                </li>
                                <li class="nav-item start <?php if($current_menu == 'show_ccsets'  || $current_menu == 'add_costset'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>costcentre/show_ccsets/" class="nav-link nav-toggle">
                                        <i class="fa fa-anchor"></i>
                                        <span class="title">Cost Centre Set</span>
                                        <span class="arrow"></span>
                                    </a>

                                </li>
                            <?php } ?>
                            </ul>

                        </li>

                        <li class="nav-item start <?php if($current_menu == 'report' || $current_menu ==  'add_report' || $current_menu == 'import_data' || $current_menu == 'analysis_data'  || $current_menu == 'analysis_data_month' || $current_menu == 'unanalysis_data'  || $current_menu == 'unanalysis_data_month'   || $current_menu == 'show_customers' || $current_menu ==  'inv_add_client' || $current_menu ==  'show_customer_invoice'  || $current_menu ==  'show_customer_quote' || $current_menu ==  'add_cusomter_invoice'  || $current_menu ==  'add_cusomter_quote'  || $current_menu ==  'edit_cusomter_invoice'  || $current_menu ==  'edit_cusomter_quote' || $current_menu == 'inv_add_supplier' || $current_menu ==  'show_suppliers' || $current_menu == 'edit_supplier_invoice' || $current_menu == 'add_supplier_invoice' || $current_menu == 'show_supplier_invoice' || $current_menu == 'customer_receipts' || $current_menu == 'supplier_payments'){echo 'active';}?>">
                            <a href="javascript:void(0);" class="nav-link nav-toggle">
                                <i class="fa fa-calendar"></i>
                                <span class="title">Invoices</span>
                                <?php if($current_menu == 'report' || $current_menu ==  'add_report' || $current_menu == 'import_data' || $current_menu == 'analysis_data'   || $current_menu == 'analysis_data_month'   || $current_menu == 'show_customers' || $current_menu ==  'inv_add_client' || $current_menu ==  'show_customer_invoice'  || $current_menu ==  'show_customer_quote' || $current_menu ==  'add_cusomter_invoice'  || $current_menu ==  'add_cusomter_quote'  || $current_menu ==  'edit_cusomter_invoice'  || $current_menu ==  'edit_cusomter_quote' || $current_menu == 'inv_add_supplier' || $current_menu ==  'show_suppliers' || $current_menu == 'edit_supplier_invoice' || $current_menu == 'add_supplier_invoice' || $current_menu == 'show_supplier_invoice' || $current_menu == 'customer_receipts' || $current_menu == 'supplier_payments'){ echo '<span class="selected"></span>'; }
                                 ?>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">

                                 <li class="nav-item <?php if($current_menu == 'inv_add_client' || $current_menu ==  'show_customers' || $current_menu ==  'show_customer_invoice'  || $current_menu ==  'show_customer_quote' || $current_menu ==  'add_cusomter_invoice'  || $current_menu ==  'add_cusomter_quote'  || $current_menu ==  'edit_cusomter_invoice'  || $current_menu ==  'edit_cusomter_quote' || $current_menu == 'customer_receipts' ){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>invoicing" class="nav-link ">
                                        <i class="fa fa-users"></i>
                                        <span class="title">Customer Invoices</span>
                                    </a>
                                
                                     <ul class="sub-menu">
                                        <li class="nav-item  <?php if($current_menu == 'inv_add_client'  ){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>invoicing" class="nav-link ">
                                                <i class="fa fa-users"></i>
                                                <span class="title">Show Customer</span>
                                            </a>
                                        </li>
                                        <li class="nav-item  <?php if($current_menu == 'inv_add_client'  ){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>invoicing/add_customer" class="nav-link ">
                                                <i class="fa fa-user-plus"></i>
                                                <span class="title">Add Customer</span>
                                            </a>
                                        </li>
                                        <li class="nav-item  <?php if($current_menu == 'add_cusomter_invoice'  || $current_menu ==  'show_customer_invoice'  || $current_menu ==  'edit_cusomter_invoice' ){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>invoicing/show_customer_invoice" class="nav-link ">
                                                <i class="icon-envelope-open"></i>
                                                <span class="title">Customer Invoice</span>
                                            </a>
                                        </li>
                                        <li class="nav-item start <?php if($current_menu == 'customer_receipts' ){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>invoicing/customer_receipts" class="nav-link nav-toggle">
                                                <i class="fa fa-envelope-o"></i>
                                                <span class="title">Customers Receipts</span>
                                                <span class="arrow"></span>
                                            </a>

                                        </li>
                                        <li class="nav-item start <?php if($current_menu == 'add_cusomter_quote' || $current_menu == 'edit_cusomter_invoice' || $current_menu ==  'show_customer_quote' ){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>invoicing/show_customer_quote" class="nav-link nav-toggle">
                                                <i class="fa fa-envelope-o"></i>
                                                <span class="title">Customer Quote</span>
                                                <span class="arrow"></span>
                                            </a>

                                        </li>
                                        <li class="nav-item start <?php if($current_menu == 'analysis_data' || $current_menu == 'analysis_data_month' ){echo 'active';}?>">
                                            <a href="#" class="nav-link nav-toggle">
                                                <i class="icon-basket"></i>
                                                <span class="title">Sales by Customers</span>
                                                <span class="arrow"></span>
                                            </a>

                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item <?php if($current_menu == 'inv_add_supplier' || $current_menu ==  'show_suppliers' || $current_menu == 'edit_supplier_invoice' || $current_menu == 'add_supplier_invoice' || $current_menu == 'show_supplier_invoice' || $current_menu == 'supplier_payments'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>invoicing/show_suppliers" class="nav-link ">
                                        <i class="fa fa-users"></i>
                                        <span class="title">Supplier Invoices</span>
                                    </a>
                                
                                     <ul class="sub-menu">

                                        <li class="nav-item  <?php if($current_menu == 'show_suppliers' ){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>invoicing/show_suppliers" class="nav-link ">
                                                <i class="fa fa-users"></i>
                                                <span class="title">Show Suppliers</span>
                                            </a>
                                        </li>
                                        <li class="nav-item  <?php if($current_menu == 'inv_add_supplier' ){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>invoicing/add_supplier" class="nav-link ">
                                                <i class="fa fa-user-plus"></i>
                                                <span class="title">Add Supplier</span>
                                            </a>
                                        </li>
                                        <li class="nav-item  <?php if($current_menu == 'edit_supplier_invoice' || $current_menu == 'add_supplier_invoice' || $current_menu == 'show_supplier_invoice'){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>invoicing/show_supplier_invoice" class="nav-link ">
                                                <i class="icon-envelope-open"></i>
                                                <span class="title">Supplier Invoice</span>
                                            </a>
                                        </li>
                                        <li class="nav-item  <?php if($current_menu == 'supplier_payments'){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>invoicing/supplier_payments" class="nav-link ">
                                                <i class="icon-envelope-open"></i>
                                                <span class="title">Suppliers Payments</span>
                                            </a>
                                        </li>
                                        <li class="nav-item start <?php if($current_menu == 'bk_analysis_data' ){echo 'active';}?>">
                                            <a href="#" class="nav-link nav-toggle">
                                                <i class="icon-basket"></i>
                                                <span class="title">Purchases by Suppliers</span>
                                                <span class="arrow"></span>
                                            </a>

                                        </li>
                                    </ul>
                                </li>


                                <li class="nav-item <?php if($current_menu == 'report' || $current_menu ==  'add_report' || $current_menu == 'import_data' || $current_menu == 'analysis_data'  || $current_menu == 'analysis_data_month'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>reports" class="nav-link ">
                                        <i class="fa fa-envelope"></i>
                                        <span class="title">Manual Invoices</span>
                                    </a>
                                
                                     <ul class="sub-menu">

                                        <li class="nav-item  <?php if($current_menu == 'report' || $current_menu ==  'add_report'){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>reports" class="nav-link ">
                                                <i class="fa fa-database"></i>
                                                <span class="title">Input Data</span>
                                            </a>
                                        </li>
                                        <li class="nav-item  <?php if($current_menu == 'import_data'){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>reports/import_data" class="nav-link ">
                                                <i class="fa fa-file-pdf-o"></i>
                                                <span class="title">Import Data</span>
                                            </a>
                                        </li>
                                        <li class="nav-item start <?php if($current_menu == 'analysis_data' || $current_menu == 'analysis_data_month'  ){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>reports/analysis_data_month" class="nav-link nav-toggle">
                                                <i class="fa fa-trash"></i>
                                                <span class="title">Analysed Data</span>
                                                <span class="arrow"></span>
                                            </a>

                                        </li>
                                        <li class="nav-item start <?php if($current_menu == 'unanalysis_data' || $current_menu == 'unanalysis_data_month'  ){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>reports/unanalysis_data_month" class="nav-link nav-toggle">
                                                <i class="fa fa-trash"></i>
                                                <span class="title"> Unanalysed Data</span>
                                                <span class="arrow"></span>
                                            </a>

                                        </li>
                                    </ul>
                                </li>
                                
                            </ul>
                        </li>

                        <li class="nav-item start <?php if(  $current_menu == 'bk_report' || $current_menu ==  'bk_add_report' || $current_menu == 'bk_import_data' || $current_menu == 'bk_unanalysis_data'  || $current_menu == 'bk_unanalysis_data_month' || $current_menu == 'bk_analysis_data'  || $current_menu == 'bk_analysis_data_month' ){echo 'active';}?>">
                            <a href="javascript:void(0);" class="nav-link nav-toggle">
                                <i class="fa fa-calendar"></i>
                                <span class="title">Bank Transactions</span>
                                <?php if( $current_menu == 'bk_report' || $current_menu ==  'bk_add_report' || $current_menu == 'bk_import_data' || $current_menu == 'bk_analysis_data'  ||  $current_menu == 'bk_analysis_data_month' ){ echo '<span class="selected"></span>'; }
                                 ?>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <?php
                                if($bank_accounts)
                                {
                                    foreach($bank_accounts as $bank_account){
                                    ?>
                                    <li class="nav-item  <?php if($current_menu == 'bk_report' || $current_menu == 'bk_add_report' || $current_menu == 'bk_import_data' || $current_menu == 'bk_analysis_data' || $current_menu == 'bk_analysis_data_month'){echo 'active';}?>">
                                    <a href="#" class="nav-link ">
                                        <i class="fa fa-file-pdf-o"></i>
                                        <span class="title"><?php echo $bank_account->bank_name; ?></span>
                                    </a>
                                    <ul class="sub-menu">

                                         <li class="nav-item  <?php if($current_menu == 'bk_report' || $current_menu ==  'bk_add_report'){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>banktransactions?bank_id=<?php echo $bank_account->bank_id; ?>" class="nav-link ">
                                                <i class="fa fa-database"></i>
                                                <span class="title">Input Data</span>
                                            </a>
                                        </li>
                                        <li class="nav-item  <?php if($current_menu == 'bk_import_data'){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>banktransactions/import_data?bank_id=<?php echo $bank_account->bank_id; ?>" class="nav-link ">
                                                <i class="fa fa-file-pdf-o"></i>
                                                <span class="title">Import Data</span>
                                            </a>
                                        </li>
                                        <li class="nav-item start <?php if($current_menu == 'bk_analysis_data' || $current_menu == 'bk_analysis_data_month' ){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>banktransactions/analysis_data_month?bank_id=<?php echo $bank_account->bank_id; ?>" class="nav-link nav-toggle">
                                                <i class="fa fa-trash"></i>
                                                <span class="title">Analysed Data</span>
                                                <span class="arrow"></span>
                                            </a>
                                        </li>
                                        <li class="nav-item start <?php if($current_menu == 'bk_unanalysis_data' || $current_menu == 'bk_unanalysis_data_month' ){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>banktransactions/unanalysis_data_month?bank_id=<?php echo $bank_account->bank_id; ?>" class="nav-link nav-toggle">
                                                <i class="fa fa-trash"></i>
                                                <span class="title">Unanalysed Data</span>
                                                <span class="arrow"></span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <?php
                                } }
                                else{
                                ?>
                                <li class="nav-item  <?php if($current_menu == 'bk_report' || $current_menu ==  'bk_add_report'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>banktransactions" class="nav-link ">
                                        <i class="fa fa-database"></i>
                                        <span class="title">Input Data</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php if($current_menu == 'bk_import_data'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>banktransactions/import_data" class="nav-link ">
                                        <i class="fa fa-file-pdf-o"></i>
                                        <span class="title">Import Data</span>
                                    </a>
                                </li>
                                <li class="nav-item start <?php if($current_menu == 'bk_analysis_data' || $current_menu == 'bk_analysis_data_month' ){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>banktransactions/analysis_data_month" class="nav-link nav-toggle">
                                        <i class="fa fa-trash"></i>
                                        <span class="title">Data Analysis</span>
                                        <span class="arrow"></span>
                                    </a>
                                </li>
                            <?php } ?>
                            </ul>
                        </li>


                        <li class="nav-item start <?php if(  $current_menu == 'bulk_insert' || $current_menu == 'journal_datas'){echo 'active';}?>">
                            <a href="javascript:void(0);" class="nav-link nav-toggle">
                                <i class="fa fa-calendar"></i>
                                <span class="title">Journal Entries</span>
                                <?php if( $current_menu == 'bulk_insert'  || $current_menu == 'journal_datas' ){ echo '<span class="selected"></span>'; }
                                 ?>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item  <?php if($current_menu == 'bulk_insert'  || $current_menu == 'journal_datas' ){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>journalentry" class="nav-link ">
                                        <i class="fa fa-database"></i>
                                        <span class="title">Process Journal Entries</span>
                                    </a>
                                </li> 
                            </ul>
                        </li>

                        <li class="nav-item start <?php if($current_menu == 'investigation_data' || $current_menu == 'bk_investigation_data'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>reports/investigation_data" class="nav-link nav-toggle">
                                        <i class="fa fa-trash"></i>
                                        <span class="title">Data Investigation</span>
                                        <?php if($current_menu == 'investigation_data' || $current_menu == 'bk_investigation_data'){ echo '<span class="selected"></span>'; }
                                        ?>
                                        <span class="arrow"></span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="nav-item  <?php if($current_menu == 'investigation_data'){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>reports/investigation_data" class="nav-link ">
                                                <i class="fa fa-envelope"></i>
                                                <span class="title">Invoices</span>
                                            </a>
                                        </li>
                                        <li class="nav-item  <?php if($current_menu == 'bk_investigation_data'){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>banktransactions/investigation_data" class="nav-link ">
                                                <i class="fa fa-bank"></i>
                                                <span class="title">Bank Transactions</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                        
                        <li class="nav-item start <?php if($current_menu == 'show_report' || $current_menu == 'vat201' || $current_menu == 'iospreedsheet' || $current_menu == 'control_account' || $current_menu == 'invoice_financial' || $current_menu == 'banktrans_financial'  || $current_menu == 'bank_statement' || $current_menu == 'invoice_ledger' || $current_menu == 'banktrans_ledger'  || $current_menu == 'fixed_asset_register' || $current_menu == 'financial_report_invoice' || $current_menu == 'financial_report_bk' ){echo 'active';}?>">
                            <a href="javascript:void(0);" class="nav-link nav-toggle">
                                <i class="icon-bar-chart"></i>
                                <span class="title">Reports</span>
                                <?php if($current_menu == 'show_report' || $current_menu == 'vat201' || $current_menu == 'iospreedsheet' || $current_menu == 'control_account' || $current_menu == 'cost_group' || $current_menu == 'banktrans_financial' || $current_menu == 'bank_statement' || $current_menu == 'financial_report'){ echo '<span class="selected"></span>'; }
                                        ?>
                                <span class="arrow"></span>
                            </a>
                             <ul class="sub-menu" id="report_sidemenu">


                                <li class="nav-item  <?php if($current_menu == 'vat201'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>reports/vat201" class="nav-link ">
                                        <i class="fa fa-file-pdf-o"></i>
                                        <span class="title">VAT 201</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php if($current_menu == 'iospreedsheet'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>reports/iospreedsheet" class="nav-link ">
                                        <i class="fa fa-file-pdf-o"></i>
                                        <span class="title">Input/Output Speadsheet</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php if($current_menu == 'control_account'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>reports/control_account" class="nav-link ">
                                        <i class="fa fa-file-pdf-o"></i>
                                        <span class="title">Control Account</span>
                                    </a>
                                </li>

                                <!-- <li class="nav-item  <?php if($current_menu == 'invoice_financial' || $current_menu == 'banktrans_financial'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>reports/invoice_financial" class="nav-link ">
                                        <i class="fa fa-file-pdf-o"></i>
                                        <span class="title">Financials</span>
                                    </a>
                                    <ul class="sub-menu">

                                         <li class="nav-item  <?php if($current_menu == 'invoice_financial'){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>reports/invoice_financial" class="nav-link ">
                                                <i class="fa fa-file-pdf-o"></i>
                                                <span class="title">Invoices Financials</span>
                                            </a>
                                        </li>
                                        <li class="nav-item  <?php if($current_menu == 'banktrans_financial'){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>reports/banktrans_financial" class="nav-link ">
                                                <i class="fa fa-bank"></i>
                                                <span class="title">Bank Transactions Financials</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li> -->

                                <li class="nav-item  <?php if($current_menu == 'invoice_trialbal' || $current_menu == 'banktrans_trialbal'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>reports/invoice_trialbal" class="nav-link ">
                                        <i class="fa fa-file-pdf-o"></i>
                                        <span class="title">Trial Balance</span>
                                    </a>
                                    <ul class="sub-menu">
                                        
                                         <li class="nav-item  <?php if($current_menu == 'invoice_trialbal'){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>reports/invoice_trialbal" class="nav-link ">
                                                <i class="fa fa-file-pdf-o"></i>
                                                <span class="title">Invoices</span>
                                            </a>
                                        </li>
                                        <li class="nav-item  <?php if($current_menu == 'banktrans_trialbal'){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>reports/banktrans_trialbal" class="nav-link ">
                                                <i class="fa fa-bank"></i>
                                                <span class="title">Bank Transactions</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-item  <?php if($current_menu == 'invoice_ledger' || $current_menu == 'banktrans_ledger'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>reports/invoice_ledger" class="nav-link ">
                                        <i class="fa fa-file-pdf-o"></i>
                                        <span class="title">Ledger</span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="nav-item  <?php if($current_menu == 'invoice_ledger'){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>reports/invoice_ledger" class="nav-link ">
                                                <i class="fa fa-file-pdf-o"></i>
                                                <span class="title">Invoices Ledger</span>
                                            </a>
                                        </li>
                                        <li class="nav-item  <?php if($current_menu == 'banktrans_ledger'){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>reports/banktrans_ledger" class="nav-link ">
                                                <i class="fa fa-bank"></i>
                                                <span class="title">Bank Transactions Ledger</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-item  <?php if($current_menu == 'bank_statement'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>reports/bank_statement" class="nav-link ">
                                        <i class="fa fa-bank"></i>
                                        <span class="title">Bank Statement</span>
                                    </a>
                                    <ul class="sub-menu">

                                    <?php
                                        if($bank_accounts)
                                        {
                                            foreach($bank_accounts as $bank_account){
                                            ?>
                                            <li class="nav-item  <?php if($current_menu == 'bk_report' || $current_menu == 'bk_add_report' || $current_menu == 'bk_import_data' || $current_menu == 'bk_analysis_data' || $current_menu == 'bk_analysis_data_month'){echo 'active';}?>">
                                                <a href="<?php echo BASE_URL; ?>reports/bank_statement?bank_id=<?php echo $bank_account->bank_id; ?>" class="nav-link ">
                                                    <i class="fa fa-file-pdf-o"></i>
                                                    <span class="title"><?php echo $bank_account->bank_name; ?></span>
                                                </a>
                                        </li>
                                    <?php }} ?>
                                </ul>
                                    


                                </li>

                                <li class="nav-item  <?php if($current_menu == 'asset_register_invoice' || $current_menu == 'asset_register_bk'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>reports/asset_register_invoice" class="nav-link ">
                                        <i class="fa fa-bank"></i>
                                        <span class="title">Fixed Asset</span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="nav-item  <?php if($current_menu == 'asset_register_invoice'){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>reports/asset_register_invoice" class="nav-link ">
                                                <i class="fa fa-file-pdf-o"></i>
                                                <span class="title">Invoices</span>
                                            </a>
                                        </li>
                                        <li class="nav-item  <?php if($current_menu == 'asset_register_bk'){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>reports/asset_register_bk" class="nav-link ">
                                                <i class="fa fa-bank"></i>
                                                <span class="title">Bank Statement</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-item  <?php if($current_menu == 'financial_report_invoice' || $current_menu == 'financial_report_bk'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>financialreport/financial_report_invoice" class="nav-link ">
                                        <i class="fa fa-bank"></i>
                                        <span class="title">Financial Report</span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="nav-item  <?php if($current_menu == 'financial_report_invoice'){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>financialreport/financial_report_invoice" class="nav-link ">
                                                <i class="fa fa-file-pdf-o"></i>
                                                <span class="title">Invoices</span>
                                            </a>
                                        </li>
                                        <li class="nav-item  <?php if($current_menu == 'financial_report_bk'){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>financialreport/financial_report_bk" class="nav-link ">
                                                <i class="fa fa-bank"></i>
                                                <span class="title">Bank Statement</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                
                                        

                            </ul>

                        </li>
                    </ul>
                    <!-- END SIDEBAR MENU -->
                </div>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->
