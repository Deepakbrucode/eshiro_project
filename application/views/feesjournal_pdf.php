<style type="text/css"> 

   .fees_pdf table {
    border-collapse: collapse;
        table-layout: fixed;
    border:0px;
     border: 1px solid #b4b4b4;
     width:200px;
}

.fees_pdf table, .fees_pdf td, .fees_pdf th {
    font-size: 12px;
   /* border-bottom: 1px solid black!important; */
/*    border:none;*/
}
     .fees_pdf #tab-content table, .fees_pdf td, .fees_pdf th {
    border-bottom: 1px solid #e7ecf1;
        border-bottom: 1px solid #b4b4b4;
}
.col-md-12.fees_pdf {width: 100%;}


.fees_pdf table {
    table-layout: fixed;
    width: 100%;   
}

      .fees_pdf th,.fees_pdf td {

    word-wrap: break-word;
}

@page { margin: 90px 50px 0px; }
    #header { position: fixed; left: 0px; top: -80px; right: 0px; height: 100px;/* background-color: orange;*/ text-align: center; }
   /* #footer { position: fixed; left: 0px; bottom: -180px; right: 0px; height: 150px; background-color: lightblue; }*/
  /*  #footer .page:after { content: counter(page, upper-roman); }*/

</style>

 <div id="header">
    <!-- <h1>Widgets Express</h1> -->
    <center><p style="margin:4px 0px;"><span style="font-weight: bold;text-align: center;font-size:15px;"><?php echo $client_name; ?></span></p></center>
                         <center><p style="margin:4px 0px;"><span style="font-weight: bold;text-align: center;font-size:12px;">Fees Journals</span></p></center>
                         <center><p style="margin:4px 0px;"><span style="text-align: center;font-size:12px;"><?php echo $date_txt; ?></span></p></center>
  </div>
<!--   <div id="footer">
    <p class="page">Page </p>
  </div> -->


                    <div class="col-md-12 fees_pdf">
                         
                         
                         <?php 
                          $total_amount = 0;
                         if($fees_journals)
                         {

                                foreach ($fees_journals as $key => $value) {
                                     $payment_date = $value->payment_date;
                                    $payment_date = date('d-M-Y', strtotime($payment_date));
                                    $file_number = $value->file_number;
                                    $amount = $value->amount;
                                    //$format_amount = "R".money_format('%!i', $amount) ;
                                    $format_amount = "R".number_format((float)$amount, 2);

                                    ?>
                                    <table style="width:100%;margin-top:15px;">
                                        <thead>
                                            <tr>
                                                <th style="font-weight: bold;text-align:left;">Date</th>
                                                <th style="font-weight: bold;text-align:left;">Description</th>
                                                <th style="font-weight: bold;text-align:right;">Dr</th>
                                                <th style="font-weight: bold;text-align:right;">Cr</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $payment_date; ?></td>
                                                <td>TRF TO BUSINESS</td>
                                                <td style="text-align:right;"><?php echo $format_amount; ?></td>
                                                <td style="text-align:right;"></td>
                                            </tr>
                                            <tr>
                                                <td><?php echo $payment_date; ?></td>
                                                <td>BANK</td>
                                                <td style="text-align:right;"></td>
                                                <td style="text-align:right;"><?php echo $format_amount; ?></td>
                                                
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td style="font-weight: bold;text-align:right;"><?php echo $format_amount; ?></td>
                                                <td style="font-weight: bold;text-align:right;"><?php echo $format_amount; ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <?php
                                }
                                }?>
                                    
                    </div>