<style type="text/css"> 

    table {
    border-collapse: collapse;
        table-layout: fixed;
    border:0px;
     border: 1px solid #b4b4b4;
     /*width:200px;*/
}

table, td, th {
    font-size: 11px;
   /* border-bottom: 1px solid black!important; */
/*    border:none;*/
}

.col-md-12{width: 100%;}
 td, th {

        border-bottom: 1px solid #b4b4b4;
}

/*.col-md-6{width: 49%;display:inline-block;float: left;}
.col-md-8{    width: 66.66667%; display: inline-block;margin:0px auto;}*/

table {
    table-layout: fixed;
    width: 100%;   
}

      th,td {

    word-wrap: break-word;padding-top:5px;padding-bottom:5px;
}

tr td:first-child{padding-left:10px;}
tr td:last-child {
 padding-right:10px;
}
thead{background-color: #ac9076;color: white;}

 tr td:nth-last-child(1), tr td:nth-last-child(2), tr td:nth-last-child(3) {
text-align:right;
}


 tr:last-child {
font-weight: bold;
}
@page { margin: 90px 50px 0px; }
    #header { position: fixed; left: 0px; top: -80px; right: 0px; height: 100px;/* background-color: orange;*/ text-align: center; }

</style>

<?php
/*$rbalance_total = 0;
$rsundry_total1 = 'R 0.00';
$rclient_total1 = 'R 0.00';
$rbank_total1 = 'R 0.00';
$rbalance_total1 = 'R 0.00';

$rsundry_total=0;
$rclient_total = 0;
$rbank_total = 0;


$pbalance_total = 0;
$psundry_total1 = 'R 0.00';
$pclient_total1 = 'R 0.00';
$pbank_total1 = 'R 0.00';
$pbalance_total1 = 'R 0.00';
$psundry_total=0;
$pclient_total = 0;
$pbank_total = 0;
setlocale(LC_MONETARY, 'en_IN');*/
                        ?>
<div id="header">
<p style="font-weight: bold;text-align: center;font-size:19px;margin: 0px;"><?php echo $filtered_client_name; ?></p>
                         <p style="font-weight: bold;text-align: center;font-size:13px;    margin: 10px 0px;">TRUST CASHBOOK </p>
                         <p style="font-weight: bold;text-align: center;font-size:13px;    margin: 10px 0px;"><?php echo $month_name.'-'.$year; ?></p>
                         </div>

                       <div class="col-md-12">
                            
                                    <table class="table table-striped table-hover table-bordered" id="cashbook1" style="table-layout: fixed;border-collapse: collapse;width: 100%; ">
                                        <thead>
                                            <tr>
                                                <td>Date</td>
                                                <td>Details</td>
                                                <td>File No</td>
                                                <td>File Name</td>
                                                <td>Dr</td>
                                                <td>Cr</td>
                                                <td>Balance</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if($ajax_array)
                                        {
                                            foreach ($ajax_array as $cash_key => $cash_value) {
                                                echo "<tr>";
                                                foreach ($cash_value as $key => $value) {
                                                    echo "<td>$value</td>";
                                                
                                                 }
                                                 echo "</tr>";
                                            }
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>


                   <!--  <div class="col-md-12" >
                        <div class="col-md-6 col-sm-6" >
                        <p style="text-align: center;"><b>RECEIPTS SIDE</b></p>
                            <table class="table table-striped table-hover table-bordered" id="cashbook1" style="table-layout: fixed;border-collapse: collapse;width: 100%; ">
                                <thead>

                                    <tr>
                                        <th style="width:1cm;word-wrap: break-word;"> Date </th>
                                        <th style="width:1cm;word-wrap: break-word;"> Details </th>
                                        <th style="width:1cm;word-wrap: break-word;"> File No </th>
                                        <th style="width:1cm;word-wrap: break-word;text-align:right;">  Sundry </th>
                                        <th style="width:1cm;word-wrap: break-word;text-align:right;"> Client </th>
                                        <th style="width:1cm;word-wrap: break-word;text-align:right;"> Bank </th>
                                    </tr> 
                                </thead>
                                
                                <tbody>


                                <?php
                                if($OpenBalDetails)
                                {
                                    foreach ($OpenBalDetails as $key => $value) {
                                        $openbal_date = $value->openbal_date;
                                        $openbal_date = date('d-M-Y', strtotime($openbal_date));
                                        $oamount = $value->amount;
                                        //setlocale(LC_MONETARY, 'en_IN');
                                        $oformat_amount = "R".money_format('%!i', $oamount);
                                        //$oformat_amount = "R".number_format($oamount,2);
                                         echo "<tr>
                                         <td style='width:30px;word-wrap: break-word;'><b>".$openbal_date."</b></td>
                                         <td style='width:30px;word-wrap: break-word;'><b>Opening Balance</b></td>
                                         <td style='width:30px;word-wrap: break-word;'></td>
                                         <td style='width:30px;word-wrap: break-word;text-align:right;'></td>
                                         <td style='width:30px;word-wrap: break-word;text-align:right;'><b>".$oformat_amount."</b></td>
                                         <td style='width:30px;word-wrap: break-word;text-align:right;'><b>".$oformat_amount."</b></td>
                                         </tr>";
                                         $rbank_total+=$oamount;
                                         $rclient_total+=$oamount;
                                    }
                                }
                                if($ReceiptsDetails)
                                {
                                    foreach ($ReceiptsDetails as $key => $value) {
                                        $receipt_date = $value->receipt_date;
                                        $receipt_date = date('d-M-Y', strtotime($receipt_date));
                                        //$receipt_date = $value->receipt_date;
                                        $transaction_type = $value->transaction_type;
                                        $file_number = $value->file_number;
                                        $file_name = $value->file_name;
                                        $ramount = $value->amount;

                                        //setlocale(LC_MONETARY, 'en_IN');
                                        $rformat_amount = "R".money_format('%!i', $ramount);

                                        //$rformat_amount = "R".number_format($ramount,2);

                                        $trans_txt='';
                                        $rsundry_amt = 0;
                                        $rclient_amt = 0;

                                       if($transaction_type == 'deposit'){$trans_txt = 'Deposit'; $rsundry_amt=''; $rclient_amt =$rformat_amount;$rclient_total+=$ramount;}
                                         else if($transaction_type == 'rtd'){$trans_txt = 'RTD'; $rsundry_amt='';$rclient_amt = $rformat_amount;$rclient_total+=$ramount; }
                                        else if($transaction_type == 'credit_interest'){$trans_txt = 'Credit Interest'; $rsundry_amt= $rformat_amount;$rclient_amt = "";
                                        $rsundry_total+= $ramount; }
                                        else {$trans_txt=''; $rsundry_amt='';$rclient_amt = $rformat_amount;$rclient_total+= $ramount;}

                                        //$receipt_date = $value->receipt_date;
                                        //$receipt_date = $value->receipt_date;
                                        echo "<tr><td style='width:30px;word-wrap: break-word;'>".$receipt_date."</td><td style='width:30px;word-wrap: break-word;'>".$trans_txt."</td><td style='width:30px;word-wrap: break-word;'>".$file_name."</td><td style='width:30px;word-wrap: break-word;text-align:right;'>".$rsundry_amt."</td><td style='width:30px;word-wrap: break-word;text-align:right;'>".$rclient_amt."</td><td style='width:30px;word-wrap: break-word;text-align:right;'>".$rformat_amount."</td></tr>";

                                        $rbank_total+=$ramount;
                                    }


//setlocale(LC_MONETARY, 'en_IN');
$rformat_amount = money_format('%!i', $ramount);
//setlocale(LC_MONETARY, 'en_IN');
$rsundry_total1 = money_format('%!i', $rsundry_total);
//setlocale(LC_MONETARY, 'en_IN');
$rclient_total1 = money_format('%!i', $rclient_total);
//setlocale(LC_MONETARY, 'en_IN');
$rbank_total1 = money_format('%!i', $rbank_total);


//$rformat_amount = number_format($ramount,2);

   // $rsundry_total1 = number_format($rsundry_total,2);
   //$rclient_total1 = number_format($rclient_total,2); 
   // $rbank_total1 = number_format($rbank_total,2);
$rbalance_total = ($rclient_total+$rsundry_total) - $rbank_total;
// $rbalance_total1 =  number_format($rbalance_total,2); 
 $rbalance_total1 = money_format('%!i', $rbalance_total);


                                }

                                ?>
                                  
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3"></td>
                                            <th style="text-align:right;">R <?php echo $rsundry_total1; ?></th>
                                            <th style="text-align:right;">R <?php echo $rclient_total1; ?></th>
                                            <th style="text-align:right;">R <?php echo $rbank_total1; ?></th>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td colspan="3" style="text-align:center;">R <?php echo $rbalance_total1; ?></td>
                                    </tr>
                                </tfoot>

                            </table>

                        </div>
                        <div class="col-md-6 col-sm-6">
                            <p style="text-align: center;"><b>PAYMENT SIDE</b></p>
                            <table class="table table-striped table-hover table-bordered" style="width:100%;">
                                <thead>

                                    <tr>
                                        <th style="width: 15%;"> Date </th>
                                        <th> Details </th>
                                        <th> File No </th>
                                        <th> Sundry </th>
                                        <th> Client </th>
                                        <th> Bank </th>

                                    </tr>
                                </thead>
                                
                                <tbody>

                                <?php
                                if($PaymentDetails)
                                {
                                    foreach ($PaymentDetails as $key => $value) {
                                        $payment_date = $value->payment_date;
                                        $payment_date = date('d-M-Y', strtotime($payment_date));
                                        //$payment_date = $value->payment_date;
                                        $transaction_type = $value->transaction_type;
                                        $file_number = $value->file_number;
                                        $file_name = $value->file_name;
                                        $pamount = $value->amount;
                                        //setlocale(LC_MONETARY, 'en_IN');
                                        $pformat_amount = "R".money_format('%!i', $pamount);

                                        //$pformat_amount = "R".number_format($pamount,2);

                                        $trans_txt='';
                                        $psundry_amt = 0;
                                        $pclient_amt = 0;


                                        if($transaction_type == 'refund'){$trans_txt = 'Refund'; $psundry_amt='';$pclient_amt = $pformat_amount;
        $pclient_total+=$pamount;}
        else if($transaction_type == 'cost'){$trans_txt = 'Cost'; $psundry_amt='';$pclient_amt = $pformat_amount;$pclient_total+=$pamount; }
        else if($transaction_type == 'bank_charges'){$trans_txt = 'Bank Charges'; $psundry_amt= $pformat_amount;$pclient_amt = "";
        $psundry_total+= $pamount; }

        else if($transaction_type == 'fee'){$trans_txt = 'Fee'; $psundry_amt= ''; $pclient_amt = $pformat_amount;$pclient_total+=$pamount;}

        else {$trans_txt=''; $psundry_total='';$psundry_amt= '';$pclient_amt = $pformat_amount;$pclient_total+= $pamount;}


                                      

                                        echo "<tr><td>".$payment_date."</td><td>".$trans_txt."</td><td>".$file_name."</td><td style='text-align:right;'>".$psundry_amt."</td><td style='text-align:right;'>".$pclient_amt."</td><td style='text-align:right;'>".$pformat_amount."</td></tr>";

                                        $pbank_total+=$pamount;
                                    }

                                    
                                    $psundry_total1 = money_format('%!i', $psundry_total);
                                    $pclient_total1 = money_format('%!i', $pclient_total);
                                    $pbank_total1 = money_format('%!i', $pbank_total);
                                    $pbalance_total = ($pclient_total+$psundry_total) - $pbank_total;
                                    $pbalance_total1 = money_format('%!i', $pbalance_total);




                                }

                               $sundry_total = $rsundry_total - $psundry_total;
//$sundry_total1 = number_format($psundry_total,2); 
$sundry_total1 = money_format('%!i', $psundry_total);


$client_total = $rclient_total - $pclient_total;
//$client_total1 = number_format($client_total,2); 
$client_total1 = money_format('%!i', $client_total);

$bank_total = $rbank_total - $pbank_total;
//$bank_total1 = number_format($bank_total,2);
$bank_total1 = money_format('%!i', $bank_total);


$bal_ccashbook = $client_total + $rsundry_total;
//$bal_ccashbook1 = number_format($bal_ccashbook,2);
$bal_ccashbook1 = money_format('%!i', $bal_ccashbook);
//$bal_ccashbook1 = $bal_ccashbook.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

$bal_bcashbook = $bal_ccashbook - $psundry_total;
//$bal_bcashbook1 = number_format($bal_bcashbook,2);
$bal_bcashbook1 = money_format('%!i', $bal_bcashbook);
//$bal_bcashbook1 = $bal_bcashbook.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

$bal_diff = $bank_total - $bal_bcashbook;
//$bal_diff1 = number_format($bal_diff,2);
$bal_diff1 = money_format('%!i', $bal_diff);
//$bal_diff1 = $bal_diff.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');



                                ?>


                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="3"></td>
                                        <th style="text-align:right;">R <?php echo $psundry_total1; ?></th>
                                        <th style="text-align:right;">R <?php echo $pclient_total1; ?></th>
                                        <th style="text-align:right;">R <?php echo $pbank_total1; ?></th>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="font-weight:400!important"></td>
                                        <td style="text-align:right;">R <?php echo $sundry_total1; ?></td>
                                        <td style="text-align:right;">R <?php echo $client_total1; ?></td>
                                        <td style="text-align:right;">R <?php echo $bank_total1; ?></td>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>

                    </div>
                    <div style="clear:both;"></div>
                     
                    <div class="col-md-12" style="margin-top:-100px;">

                        <div class="col-md-8" id="tab-content">
                            <div style="text-align: center;">
                                <p><b> Bank Reconciliation Statement</b></p>
                                <p>As At <?php echo $month_name; ?>, <?php echo $year; ?></p>
                            </div>
                            <table class="table table-striped table-hover table-bordered" style="margin-top:15px;width:100%;">

                                <tbody>

                                    <tr>
                                        <td>Balance as per Cashbok</td>
                                        <td>R <?php echo $client_total1; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Add:</td>
                                    </tr>
                                    <tr>
                                        <td>Credit Interest</td>
                                        <td>R <?php echo $rsundry_total1; ?> </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="font-weight:bold;border-bottom: 2px solid;">R <?php echo $bal_ccashbook1; ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight:bold;">Less:</td>
                                    </tr>
                                    <tr>
                                        <td>Bank Charges</td>
                                        <td>R <?php echo $psundry_total1; ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="font-weight:bold;border-bottom: 2px solid;">R <?php echo $bal_bcashbook1; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Balance as per Bank Statement</td>
                                        <td style="font-weight:bold;border-bottom: 2px solid;">R <?php echo $bank_total1; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold;">Unreconcilable Difference</td>
                                        <td style="font-weight:bold;">R <?php echo $bal_diff1; ?></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div> -->
