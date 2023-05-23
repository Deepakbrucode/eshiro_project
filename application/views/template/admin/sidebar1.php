 <div class="clearfix"> </div>
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
                                <i class="icon-home"></i>
                                <span class="title">Dashboard</span>
                                <span class="arrow"></span>
                            </a>

                        </li>
                        

                        <?php if((isset($_SESSION['filtered_client_id']) && $_SESSION['filtered_client_id'] != '' ) && $current_menu != 'dashboard' && $current_menu != 'add_client') { ?>

                        <li class="nav-item <?php if( $current_menu == 'add_file' || $current_menu == 'show_file' || $current_menu == 'import_file'){echo 'active';}?>">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <i class="icon-settings"></i>
                                <span class="title">Setting</span>
                                <span class="arrow "></span>
                            </a>
                            <ul class="sub-menu">
                                <!--<li class="nav-item <?php if($current_menu == 'add_client' || $current_menu == 'show_client'){echo 'active';}?>" >
                                    <a href="<?php echo BASE_URL; ?>client/index" class="nav-link nav-toggle">
                                        <i class="fa fa-users"></i> Client
                                        <span class="arrow"></span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="nav-item <?php if($current_menu == 'add_client'){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>client/add_client" target="_blank" class="nav-link">
                                                <i class="fa fa-user-plus"></i> Add Client
                                            </a>
                                        </li>
                                        <li class="nav-item <?php if($current_menu == 'show_client'){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>client/index" class="nav-link">
                                                <i class="fa fa-list"></i> Show Client</a>
                                        </li>
                                    </ul>
                                </li>-->
                                <li class="nav-item <?php if($current_menu == 'add_file' || $current_menu == 'show_file' ){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>file/index" class="nav-link">
                                        <i class="fa fa-file"></i> File
                                        <span class="arrow nav-toggle"></span>
                                    </a>
                                    <ul class="sub-menu <?php if($current_menu == 'add_file'){echo 'active';}?>">
                                        <li class="nav-item">
                                            <a href="<?php echo BASE_URL; ?>file/add_file" class="nav-link">
                                                <i class="fa fa-file-o"></i> Add File</a>
                                        </li>
                                        <li class="nav-item <?php if($current_menu == 'show_file'){echo 'active';}?>">
                                            <a href="<?php echo BASE_URL; ?>file/index" class="nav-link">
                                                <i class="fa fa-file-text"></i> Show File</a>
                                        </li>
                                        

                                    </ul>
                                </li>
                                <li class="nav-item <?php if($current_menu == 'import_file'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>file/import_file" class="nav-link">
                                        <i class="fa fa-file-text"></i> Import Client</a>
                                </li>
                                <li class="nav-item <?php if($current_menu == 'import_cashbook'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>OpeningBalance/import_cashbook" class="nav-link">
                                        <i class="fa fa-file-text"></i> Import Cashbook</a>
                                </li>
                            </ul>
                        </li>




                        <li class="nav-item  <?php if($current_menu == 'add_deposit' || $current_menu == 'add_rtd' || $current_menu == 'add_creditinterest' || $current_menu == 'show_receipt'){echo 'active';}?>">
                            <a href="<?php echo BASE_URL; ?>receipts/index" class="nav-link nav-toggle">
                                <i class="fa fa-file"></i>
                                <span class="title">Receipts</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">

                                <li class="nav-item  <?php if($current_menu == 'show_receipt'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>receipts/index" class="nav-link ">
                                        <i class="fa fa-list-alt"></i>
                                        <span class="title">Show Receipts </span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php if($current_menu == 'add_deposit'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>receipts/deposit?txn_type=deposit" class="nav-link ">
                                        <i class="fa fa-money"></i>
                                        <span class="title">Add Deposit</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php if($current_menu == 'add_rtd'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>receipts/rtd?txn_type=rtd" class="nav-link ">
                                        <i class="fa fa-money"></i>
                                        <span class="title">RTD</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php if($current_menu == 'add_creditinterest'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>receipts/credit_interest?txn_type=credit_interest" class="nav-link ">
                                        <i class="fa fa-money"></i>
                                        <span class="title">Credit Interest</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php if($current_menu == 'opening_balance'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>receipts/opening_balance" class="nav-link ">
                                        <i class="fa fa-money"></i>
                                        <span class="title">Opening Balance</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item  <?php if($current_menu == 'show_paymentfile' || $current_menu == 'add_paymentfile' || $current_menu == 'add_cost' || $current_menu == 'add_fee' || $current_menu == 'add_refund' || $current_menu == 'add_bank_charges' || $current_menu =='show_payment'){echo 'active';}?>">
                            <a href="<?php echo BASE_URL; ?>payments/index" class="nav-link nav-toggle">
                                <i class="fa fa-cc-amex"></i>
                                <span class="title">Payments</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">

                                <li class="nav-item  <?php if($current_menu == 'show_payment'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>payments/index" class="nav-link ">
                                        <i class="fa fa-list-alt"></i>
                                        <span class="title">Show Payments</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php if($current_menu == 'add_cost'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>payments/cost?txn_type=cost" class="nav-link ">
                                        <i class="fa fa-money"></i>
                                        <span class="title">Cost</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php if($current_menu == 'add_fee'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>payments/fee?txn_type=fee" class="nav-link ">
                                        <i class="fa fa-money"></i>
                                        <span class="title">Fee</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php if($current_menu == 'add_refund'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>payments/refund?txn_type=refund" class="nav-link ">
                                        <i class="fa fa-money"></i>
                                        <span class="title">Refund</span>
                                    </a>
                                </li>
                                <li class="nav-item  <?php if($current_menu == 'add_bank_charges'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>payments/bank_charges?txn_type=bank_charges" class="nav-link ">
                                        <i class="fa fa-money"></i>
                                        <span class="title">Bank Charges</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item  <?php if($current_menu == 'cashbook' || $current_menu == 'client_ledger' || $current_menu == 'trial_balance' || $current_menu == 'clientledger_list'){echo 'active';}?>">
                            <a href="<?php echo BASE_URL; ?>reports/index" class="nav-link nav-toggle">
                                <i class="fa fa-file"></i>
                                <span class="title">Reports</span>
                                <span class="arrow"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item <?php if($current_menu == 'cashbook'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>reports/index" class="nav-link ">
                                        <!-- <i class="fa fa-user-plus"></i> -->
                                        <span class="title">Cashbook</span>
                                    </a>
                                </li>
                                <li class="nav-item <?php if($current_menu == 'cashbook_list'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>reports/cashbook_list" class="nav-link ">
                                        <!-- <i class="fa fa-user-plus"></i> -->
                                        <span class="title">Cashbook List</span>
                                    </a>
                                </li>
                                  <!-- <li class="nav-item <?php if($current_menu == 'client1'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>reports/client1" class="nav-link ">
                                        <span class="title">Client1</span>
                                    </a>
                                    </li> -->
                                <li class="nav-item <?php if($current_menu == 'client_ledger'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>reports/client_ledger" class="nav-link ">
                                        <!-- <i class="fa fa-user-plus"></i> -->
                                        <span class="title">Clients Ledger</span>
                                    </a>
                                </li>
                                <li class="nav-item <?php if($current_menu == 'clientledger_list'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>reports/clientledger_list" class="nav-link ">
                                        <!-- <i class="fa fa-user-plus"></i> -->
                                        <span class="title">Clientsledger List</span>
                                    </a>
                                </li>
                                <li class="nav-item <?php if($current_menu == 'trial_balance'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>reports/trial_balance" class="nav-link ">
                                        <!-- <i class="fa fa-user-plus"></i> -->
                                        <span class="title">Trial Balance</span>
                                    </a>
                                </li>
                                <li class="nav-item <?php if($current_menu == 'fees_journal'){echo 'active';}?>">
                                    <a href="<?php echo BASE_URL; ?>reports/fees_journal" class="nav-link ">
                                        <!-- <i class="fa fa-user-plus"></i> -->
                                        <span class="title">Fees Journal</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <?php } else {?>
                        <li class="nav-item start <?php if($current_menu == 'add_client'){echo 'active';}?>">
                            <a href="<?php echo BASE_URL; ?>client/add_client" class="nav-link nav-toggle">
                                <i class="fa fa-users"></i>
                                <span class="title">Add Client</span>
                                <span class="arrow"></span>
                            </a>

                        </li>
                        <?php } ?>
                        
                    </ul>
                    <!-- END SIDEBAR MENU -->
                </div>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->
