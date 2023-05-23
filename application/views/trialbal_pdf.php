
<style type="text/css">
    /* .title_trial{
        text-align:center;
      }
      .title_trial h1{
        font-size: 18px;
     }*/
.align_right{text-align: right;}

   .trial_pdf table {
    border-collapse: collapse;
        table-layout: fixed;
    border:0px;
     border: 1px solid #b4b4b4;
     width:200px;
}

.trial_pdf table, .trial_pdf td, .trial_pdf th {
    font-size: 12px;
   /* border-bottom: 1px solid black!important; */
/*    border:none;*/
}
     .trial_pdf #tab-content table, .trial_pdf td, .trial_pdf th {
    border-bottom: 1px solid #e7ecf1;
        border-bottom: 1px solid #b4b4b4;
}
.col-md-12.trial_pdf {width: 100%;}


.trial_pdf table {
    table-layout: fixed;
    width: 100%;   
}

      .trial_pdf th,.trial_pdf td {

    word-wrap: break-word;
}
@page { margin: 90px 50px 0px; }
    #header { position: fixed; left: 0px; top: -80px; right: 0px; height: 100px;/* background-color: orange;*/ text-align: center; }
 </style>

       <div id="header"> 

            <center><p style="margin:4px 0px;"><span style="font-weight: bold;text-align: center;font-size:15px;"><?php echo $client_name; ?></span></p></center>
                         <center><p style="margin:4px 0px;"><span style="font-weight: bold;text-align: center;font-size:12px;">Trial Balance</span></p></center>
                         <center><p style="margin:4px 0px;"><span style="text-align: center;font-size:12px;"><?php echo $date; ?></span></p></center>
                       
                         </div>
                         
  <div class="col-md-12 trial_pdf">    



                        <!--  <h1> <?php echo $client_name;?></h1><h3> Trial Balance </h3><?php echo $date;?></div>   -->   
                           
         <div style="clear:both;margin:10px;"></div>
                     
         <table class="table table-striped table-hover table-bordered trial_table" id="trial_balance" style="width:100%">

                <thead>
                    <tr>
                        <th> S.No </th>
                        <th> Name </th>
                        <th> File No </th>
                        <th class="align_right"> Dr</th>
                        <th class="align_right"> Cr </th>
                        <!-- <th class="align_right"> Balance </th> -->
                    </tr>
                </thead>
                <?php 
                setlocale(LC_MONETARY, 'en_IN');
                    $i=0;
                    $total_balance = 0;
                    $open_bal_amt = 'R 0.00';
                    ?>
                <tbody>
                    <?php 
                    
                    if($trial_balance) {
                        foreach ($trial_balance as $key => $value) {
                            $i++;
                            $file_id = $value['file_id'];
                            $ledger_openbalss = (float)$value['ledger_openbalss'];
                            $file_name = $value['file_name'];
                            $file_number = $value['file_number'];
                            $payment_total = (float) $value['payment_total'];
                            $receipt_total = (float)$value['receipt_total'];
                            //$payment_total_amt = "R".money_format('%!i', $payment_total);
                            //$receipt_total_amt = "R".money_format('%!i', $receipt_total);
                            $payment_total_amt = "R".number_format($payment_total,2);
                            $receipt_total_amt = "R".number_format($receipt_total,2);
                            /*$balance =  $receipt_total - $payment_total ;
                            $total_balance += $balance;
                            //$balance_amt = "R".money_format('%!i', $balance);
                            $balance_amt = "R".number_format($balance,2);*/
                            $balancess =  $receipt_total - $payment_total;
                            //$balancess =  $payment_total - $receipt_total;
                            $balancess =  $balancess + $ledger_openbalss;
                            // echo "<br>";
                            $total_balance += $balancess;
                            $balance_amt = "R".number_format($balancess,2);                                   
                                                                
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $file_name; ?></td>
                                <td><?php echo $file_number; ?></td>
                                <td></td>
                                <!-- <td class="align_right"><?php echo $payment_total_amt; ?></td>
                                <td class="align_right"><?php echo $receipt_total_amt; ?></td> -->
                                <td class="align_right"><?php echo $balance_amt; ?></td>
                            </tr>
                            <?php
                        }

                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <?php
                        $open_bal = 0;
                        //$total_balance_amt = "R".money_format('%!i', $total_balance);
                        $total_balance_amt = "R".number_format($total_balance,2);
                        /*if($open_balance)
                        {
                            foreach ($open_balance as $key => $value) {
                               $open_bal = $value->amount;
                              // $open_bal_amt = "R".money_format('%!i', $open_bal);
                               $open_bal_amt = "R".number_format($open_bal,2);
                            }
                        }*/
                        $total_balance = (float) $total_balance;
                                                //$open_bal_amt = "R".money_format('%!i', $Open_total);
                                                $open_total_amt = "R".number_format($Open_total,2);
                                                $Open_total = (float) $Open_total;
                                                $remaining= $total_balance - $Open_total;
                                                //$remaining_amt = "R".money_format('%!i', $remaining);
                                                $remaining_amt = "R".number_format($remaining,2);
                                                if($remaining_amt == 'R-0.00'){$remaining_amt = 'R0.00';}
                        ?>
                        <th></th>
                        <th>BALANCE PER BANK STATEMENT</th>
                        <th></th>
                        <th class="align_right"><?php echo $open_total_amt; ?></th>
                        <!-- <th></th> -->
                        <th class="align_right"><?php echo $total_balance_amt; ?></th>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="2" class="align_right" style="border-top:1px solid #000;border-bottom:1px solid #000;"><?php echo $remaining_amt; ?></td>
                    </tr>
                </tfoot>
            </table>       
   </div>
