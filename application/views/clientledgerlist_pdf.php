 <style type="text/css"> 

    table {
    border-collapse: collapse;
        table-layout: fixed;
    border:0px;
     border: 1px solid #b4b4b4;
     width:200px;
}

table, td, th {
    font-size: 12px;
   /* border-bottom: 1px solid black!important; */
/*    border:none;*/
}
     #tab-content table, td, th {
    border-bottom: 1px solid #e7ecf1;
        border-bottom: 1px solid #b4b4b4;
}


table {
    table-layout: fixed;
    width: 100%;   
}
th{font-weight:bold;}
td {font-size:12px;}
      th,td {

    word-wrap: break-word;padding-top:5px;padding-bottom:5px;
}

tr td:first-child{padding-left:10px;}
tr td:last-child {
 padding-right:10px;
}
.client_ledger_list p{text-align: center;font-weight: bold;}
@page { margin: 90px 50px 0px; }
    #header { position: fixed; left: 0px; top: -80px; right: 0px; height: 100px;/* background-color: orange;*/ text-align: center; }
 </style>
                    <!-- END PAGE HEADER-->
                    
        <div id="header">
        <?php echo $client_ledger_list_header; ?>
        </div>            

                    <?php echo $this->session->flashdata('client_ledger'); ?>
                        <div class="col-md-12 client_ledger_list" id="div_print">
                                        <?php echo $client_ledger_list; ?>
                    
                        </div>
 
                   
 