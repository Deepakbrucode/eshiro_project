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
@page { margin: 90px 50px 0px; }
    #header { position: fixed; left: 0px; top: -80px; right: 0px; height: 100px;/* background-color: orange;*/ text-align: center; }
</style>


<div id="header">
<p style="font-weight: bold;text-align: center;font-size:19px;margin: 0px;"><?php echo $client_name; ?></p>
                         <p style="font-weight: bold;text-align: center;font-size:13px;    margin: 10px 0px;"><?php echo $file_name; ?></p>
                         <p style="font-weight: bold;text-align: center;font-size:13px;    margin: 10px 0px;"><?php echo $file_number; ?></p>
                         </div>

                    <div class="col-md-12" >
                         <!-- <p style="text-align: center;"><b>Ledger Details</b></p> -->
                         
                         <table style="width:100%;">
                         <thead style="background-color: #ac9076;color: white;">
                         <tr style="">
                         <td style="font-weight: bold;">DATE</td>
                         <td style="font-weight: bold;">DESCRPTION</td>
                         <td style="font-weight: bold;">FILE NO</td>
                         <td style="font-weight: bold;text-align:right;">DR</td>
                         <td style="font-weight: bold;text-align:right;">CR</td>
                         <td style="font-weight: bold;text-align:right;">BALANCE</td>
                         </tr>
                         </thead>
                         <tbody>
                         <?php 
                          $total_amount = 0;
                         if($ledgerarray)
                         {
                            $OpenData = (isset($ledgerarray['open']))?$ledgerarray['open']:'';;
                            $OtherData = (isset($ledgerarray['other']))?$ledgerarray['other']:'';
                            if($OpenData !='')
                             {
                                foreach ($OpenData as $key => $value) {
                                     $file_number = $value['file_number'];
                                    $amount = $value['amount'];
                                    $amount = (float)($amount);
                                    $format_amount = "R".number_format($amount,2);

                                    echo '<tr><td></td><td>Opening Balance</td>';
                                    echo '<td>'.$file_number.'</td>';
                                    echo '<td></td><td style="text-align:right;">'.$format_amount.'</td><td style="text-align:right;">'.$format_amount.'</td>';
                                    $total_amount +=$amount;
                                }
                             }
                             if($OtherData !='')
                             {
                                foreach ($OtherData as $key => $value) {
                                    $val_date = $value['date'];
                                    $transaction_type = $value['transaction_type'];
                                    $file_number = $value['file_number'];
                                    $amount = $value['amount'];
                                    $description = $value['description'];
                                    $trans_txt = '';
                                    if($transaction_type == 'deposit'){$trans_txt = 'Deposit'; }
                                    else if($transaction_type == 'rtd'){$trans_txt = 'RTD';  }
                                    else if($transaction_type == 'credit_interest'){$trans_txt = 'Credit Interest';  }
                                    else if($transaction_type == 'refund'){$trans_txt = 'Refund'; }
                                    else if($transaction_type == 'cost'){$trans_txt = 'Cost';  }
                                    else if($transaction_type == 'bank_charges'){$trans_txt = 'Bank Charges';  }

                                    else if($transaction_type == 'fee'){$trans_txt = 'Fee';}
                                    else {$trans_txt='Fee'; }

                                    echo '<tr><td>'.$val_date.'</td><td>'.$description.'</td>';
                                    echo '<td>'.$file_number.'</td>';
                                    $amount = (float) $amount;
                                    $format_amount = "R".number_format($amount,2);

                                    if($value['ledger_type'] == 'payment')
                                    {
                                        echo '<td style="text-align:right;">'.$format_amount.'</td><td></td>';
                                        $total_amount += $amount;
                                    }
                                    if($value['ledger_type'] == 'receipt')
                                    {
                                        echo '<td></td><td style="text-align:right;">'.$format_amount.'</td>';
                                        $total_amount -= $amount;
                                    }
                                    $format_total = "R".number_format($total_amount,2);
                                    echo '<td style="text-align:right;">'.$format_total.'</td></tr>';
                                    // console.log("total_amount = "+total_amount);
                                }

                             }
                         }
                         $format_total = "R".number_format($total_amount,2);
                        echo '<tr><td colspan="6" style="text-align:right;font-weight:bold;">'.$format_total.'</td></tr></table>';
                         

                         ?>
                         </tbody>
                    </div>
