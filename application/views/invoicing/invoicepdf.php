<style type="text/css">
html {font-size: 11px;-webkit-tap-highlight-color: transparent; }
body {font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;font-size: 14px; line-height: 1.42857;color: #333333;background-color: #fff;border-collapse: collapse; }
.table3_head th {
    border-top: 2px solid #9E9E9E;
    border-bottom: 2px solid #9E9E9E;
    height: 20px;
}
.table3_head tr {
    border-top: 2px solid #9E9E9E;
    border-bottom: 2px solid #9E9E9E;
    border-collapse: collapse;
    padding:10px 0;
}
table{border-collapse: collapse;}
</style>
<?php
$report_type = $invoiceDetail->report_type;
$report_date = $invoiceDetail->report_date;
$due_date = $invoiceDetail->due_date;
$report_date = date('d/m/Y',strtotime($report_date));
$due_date = date('d/m/Y',strtotime($due_date));
$total_excl_price = (float)$invoiceDetail->total_excl_price;
$total_vat = (float)$invoiceDetail->total_vat;
$amount = (float)$invoiceDetail->amount;
$cus_vatno = $invoiceDetail->vat_no;
$user_vatno = $user_details['vat_no'];
$pdf_logo = $user_details['pdf_logo'];
$user_vatno = trim($user_vatno);

// echo "user_vatno = ".$user_vatno." = cus_vatno = ".$cus_vatno;

if($user_vatno == '' && ($report_type == '5' || $report_type == '6'))
{
	// echo "iffff";
	$cusvat = '0';
}
else if($user_vatno != '' && ($report_type == '5' || $report_type == '6'))
{
	// echo "else if";
	$cusvat = '0.15';
}
else if($cus_vatno !='')
{
	// echo "else else if";
	$cusvat = '0.15';
}
else
{
	// echo "else";
	$cusvat = '0';
}

// echo "cusvat = ".$cusvat;
// exit;
// $vat_percentage = 15;
// $vat_price = ($excl_price*$vat_percentage)/100;
// $inclusive_total = $excl_price+$vat_price;

$total_excl_price =  number_format($total_excl_price,2);
$total_vat =  number_format($total_vat,2);
$amount =  number_format($amount,2);

if($report_type == '5'){$inv_txt = 'Customer Invoice';}
else if($report_type == '6'){$inv_txt = 'Customer Quote';}
else{$inv_txt = 'Supplier Invoice';}

if($report_type == '5' || $report_type == '6'){
$from_name = $user_details['name'];
$from_vatno = $user_details['vat_no'];
$from_address1 = $user_details['address1'];
$from_address2 = $user_details['address2'];
$from_zipcode = $user_details['zip_code'];
$to_name = $invoiceDetail->name;
$to_vatno = $invoiceDetail->vat_no;
$to_address1 = $invoiceDetail->address1;
$to_address2 = $invoiceDetail->address2;
$to_zipcode = $invoiceDetail->zip_code;
if($pdf_logo !='')
{
	$logo = '<img src="'.BASE_URL.'/images/pdflogo/'.$pdf_logo.'" style="width:200px;height:100px;">';
}
else
{
	$logo = '<img src="'.BASE_URL.'/images/pdf-logo.png" style="width:200px;height:100px;">';
}

}
else
{
	$to_name = $user_details['name'];
$to_vatno = $user_details['vat_no'];
$to_address1 = $user_details['address1'];
$to_address2 = $user_details['address2'];
$to_zipcode = $user_details['zip_code'];
$from_name = $invoiceDetail->name;
$from_vatno = $invoiceDetail->vat_no;
$from_address1 = $invoiceDetail->address1;
$from_address2 = $invoiceDetail->address2;
$from_zipcode = $invoiceDetail->zip_code;
$logo = '';
}
?>

<div class="container">
	  <div class="row">
		    <div class="col-md-6" style="width:50%;float:left;">
		     <?php echo $logo; ?>
		    </div>
		    <div class="col-md-6" style="width:50%;float:right;">
		    	<h2 style="text-align: right;padding:40px 0;"> <?php echo $inv_txt; ?></h2>
		    </div>
	  </div>


	  <div class="row">
		    <div class="col-md-6" style="width:50%;float:left;">
		    	
		    </div>
		    <div class="col-md-6" style="width:50%;float:right;">
		    	<p style="text-align: right;font-size:11px;font-weight:bold;"> <?php echo $from_name; ?></p>
		    </div>
	  </div>

	  <div class="table1" style="border-bottom:2px solid #9E9E9E;padding-bottom: 10px;">
		  	 <div class="col-md-6" style="width:50%;float:left;">
				  	<table style="width:100%;">
			            <tr>
			              <td style="font-size:11px;font-weight:bold;width:35%;"> VAT No:</td>  
			              <td style="font-size:11px;width:65%;"><?php echo $from_vatno; ?> </td>  
			            </tr>
			            <tr>
			              <td><p style="display: none;">empty</p></td>
			              <td></td>
			            </tr>
	              </table>
			      <table style="width:100%">
			            <tr>
			              <td style="font-size:11px;width:65%;"> <?php echo $from_address1; ?></td> 
			              <!-- <td style="width:35%;font-size:11px"> 42 Frances Street</td>   -->
			            </tr>
			            <tr>
			              <td style="font-size:11px;width:65%;"><?php echo $from_address2; ?></td> 
			              <!-- <td style="width:35%;font-size:11px">Colbyn</td>   -->
			            </tr>
			           <!--  <tr>
			              <td style="font-size:11px;width:65%;">Pretoria</td> 
			              <td style="width:35%;font-size:11px">Pretoria</td>  
			            </tr> -->
			            <tr>
			              <td><p style="display: none;">empty</p></td>
			              <td></td>
			            </tr><tr>
			              <td><p style="display: none;">empty</p></td>
			              <td></td>
			            </tr><tr>
			              <td><p style="display: none;">empty</p></td>
			              <td></td>
			            </tr>

			              <tr>
			              <td style="font-size:11px;width:65%;"><?php echo $from_zipcode; ?></td> 
			              <!-- <td style="width:35%;font-size:11px">0083</td>   -->
			            </tr>

	          </table>
		    </div>

	     <div class="col-md-6" style="width:35%;float:right;text-align: right;">
		  	<table style="float:right;width:100%;">
		  		<tr>
		  			<td style="font-size:11px;font-weight:bold;"> Number:</td>	
		  			<td style="font-size:11px;text-align:right;"> <?php echo $invoiceDetail->inv_no; ?></td>	
		  		</tr>
		  		<tr>
		  			<td style="font-size:11px;font-weight:bold;">Date:</td>	
		  			<td style="font-size:11px;text-align:right;"><?php echo $report_date; ?></td>	
		  		</tr>
		  		<tr>
		  			<td style="font-size:11px;font-weight:bold;">Reference:</td>	
		  			<td style="font-size:11px;text-align:right;"> <?php echo $invoiceDetail->ref_no; ?></td>	
		  		</tr>
		  		<!-- <tr>
		  			<td style="font-size:11px;font-weight:bold;">Page:</td>	
		  			<td style="font-size:11px;text-align:right;">1/1</td>	
		  		</tr>
		  		<tr>
		  			<td style="font-size:11px;font-weight:bold;">Reference:</td>	
		  			<td style="font-size:11px;text-align:right;"> </td>	
		  		</tr>
		  		<tr>
		  			<td style="font-size:11px;font-weight:bold;">Sales Rep:</td>	
		  			<td style="font-size:11px;text-align:right;"> </td>	
		  		</tr> -->
		  		<tr>
		  			<td style="font-size:11px;font-weight:bold;">Due Date</td>	
		  			<td style="font-size:11px;text-align:right;"> <?php echo $due_date; ?></td>	
		  		</tr>
		  		<!-- <tr>
		  			<td style="font-size:11px;font-weight:bold;">Overall Discount %:</td>	
		  			<td style="font-size:11px;text-align:right;"> 0.00%</td>	
		  		</tr> -->
		  	</table>
	  		
	    </div>

	</div>


	 <div class="table2" style="padding-bottom: 20px;">
		  	 <div class="col-md-6" style="width:50%;float:left;">
		  	 	<p style="text-align:left;font-size:11px;font-weight:bold;"> <?php echo $to_name; ?></p>
			  	<table style="width:100%;">
			  		<tr>
			  		  <td style="font-size:11px;font-weight:bold;width:35%;"> Customer VAT No:</td>	
			  		  <td style="font-size:11px;width:65%;"><?php echo $to_vatno; ?> </td>		
			  		</tr>
			        <tr>
			  		   <td><p style="display: none;">empty</p></td>
			  		   <td></td>
			  		</tr><tr>
			  			<td><p style="display: none;">empty</p></td>
			  			<td></td>
			  		</tr>
			  	</table>
			  	<table style="width:100%;">
			  		<tr>
			  		  <td style="font-size:11px;width:65%;"> <?php echo $to_address1; ?></td>	
			  		  <!-- <td style="width:35%;font-size:11px"> <?php echo $invoiceDetail->address2; ?></td>	 -->
			  		</tr>
			  		<tr>
			  		  <!-- <td style="font-size:11px;width:65%;">Kempton Park</td>	 -->
			  		  <td style="width:35%;font-size:11px"><?php echo $to_address2; ?></td>	
			  		</tr>
			  		<tr>
			  			<td><p style="display: none;">empty</p></td>
			  			<td></td>
			  		</tr>
			  		<tr>
			  			<td><p style="display: none;">empty</p></td>
			  			<td></td>
			  		</tr>
			  		<tr>
			  			<td><p style="display: none;">empty</p></td>
			  			<td></td>
			  		</tr>
			        <tr>
			  		  <td style="font-size:11px;width:70%;"><?php echo $to_zipcode; ?></td>	
			  		  <!-- <td style="width:30%;font-size:11px">1620</td>	 -->
			  		</tr>

			  	</table>
		    </div>
		    <div class="col-md-6" style="width:50%;"></div>
	</div>

	 <div class="table3" style="width:100%;">
      <table style="width:100%; ">
         <thead class="table3_head">
         <tr>
          <th style="font-size:11px;font-weight:bold;text-align:left;">Description</th>
          <th style="font-size:11px;font-weight:bold;text-align:right;"> Quantity </th>
           <th style="font-size:11px;font-weight:bold;text-align:right;"> Excl. Price </th>
          <!-- <th style="font-size:11px;font-weight:bold;text-align:left;">  Disc % </th>-->
          <th style="font-size:11px;font-weight:bold;text-align:right;"> VAT </th>
          <th style="font-size:11px;font-weight:bold;text-align:right;"> Exclusive Total</th> 
          <th style="font-size:11px;font-weight:bold;text-align:right;"> Inclusive Total</th>
        </tr>
      </thead>
      <tbody>
      	<?php
      	$total_excl_price = 0;
      	$total_vat = 0;
      	$amount = 0;
      	if($InvoiceMetaDetails)
      	{
      		foreach($InvoiceMetaDetails as $InvoiceMetaDetail){
      			$inv_eprice = (float)$InvoiceMetaDetail->inv_eprice;
				$inv_qty = $InvoiceMetaDetail->inv_qty;
				$inv_teprice = (float)$InvoiceMetaDetail->inv_teprice;
				
				// $inv_vat = (float)$InvoiceMetaDetail->inv_vat;
				
				// $inv_total = (float)$InvoiceMetaDetail->inv_total;
				

				$inv_vat = (float)$cusvat*$inv_teprice;
				$inv_total = $inv_vat+ $inv_teprice;
				$total_vat += $inv_vat;
				$total_excl_price += $inv_teprice;
				$amount += $inv_total;

				$inv_eprice =  number_format($inv_eprice,2);
				$inv_teprice =  number_format($inv_teprice,2);
				$inv_vat =  number_format($inv_vat,2);
				$inv_total =  number_format($inv_total,2);
      			?>
      	<tr>
      		<td style="font-size:11px;"><?php echo $InvoiceMetaDetail->inv_desc; ?></td>
      		<td style="font-size:11px;text-align:right;"> <?php echo $inv_qty; ?> </td>
      		 <td style="font-size:11px;text-align:right;">R <?php echo $inv_eprice; ?></td>
      		<!-- <td style="font-size:11px;"> 0.00%</td>-->
      		<td style="font-size:11px;text-align:right;">R <?php echo $inv_vat; ?></td>
      		<td style="font-size:11px;text-align:right;"> R <?php echo $inv_teprice; ?></td> 
      		<td style="font-size:11px;text-align:right;"> R <?php echo $inv_total; ?></td>
      	</tr>
      			<?php
      		}
      	}
      	?>
      	
      </tbody>


      </table>
  </div>
  <div class="empty_space" style="height:300px;"></div>
  <div class="table4" style="border-top:2px solid #9E9E9E;">
  	<div class="col-md-6" style="width:50%;float:left;"></div>
  	 <div class="col-md-6" style="width:35%;float:right;text-align: right;">
		  	<table style="float:right;width:100%;">
		  		<!-- <tr>
		  			<td style="font-size:11px;font-weight:bold;">Total Discount:</td>	
		  			<td style="font-size:11px;text-align:right;"> R 0.00</td>	
		  		</tr>-->
		  		<?php
		  		$total_excl_price =  number_format($total_excl_price,2);
				$total_vat =  number_format($total_vat,2);
				$amount =  number_format($amount,2);
				?>
		  		<tr>
		  			<td style="font-size:11px;font-weight:bold;">Total Exclusive:</td>	
		  			<td style="font-size:11px;text-align:right;">R <?php echo $total_excl_price; ?></td>	
		  		</tr>
		  		<tr>
		  			<td style="font-size:11px;font-weight:bold;">Total VAT:</td>	
		  			<td style="font-size:11px;text-align:right;">R <?php echo $total_vat; ?></td>	
		  		</tr>
		  		<tr>
		  			<td style="font-size:11px;font-weight:bold;">Sub Total:</td>	
		  			<td style="font-size:11px;text-align:right;"> R <?php echo $amount; ?></td>	
		  		</tr>
		  		<tr>
			  		<td><p style="display: none;">empty</p></td>
			  		<td></td>
			  	</tr>
			  	<tr>
			  		<td><p style="display: none;">empty</p></td>
			  		<td></td>
			  	</tr> 
		  		<tr>
		  			<td style="font-size:11px;font-weight:bold;">Total:</td>	
		  			<td style="font-size:11px;text-align:right;">R <?php echo $amount; ?> </td>	
		  		</tr>
		  		
		  	</table>
	  		
	    </div>
  </div>
 
</div>
