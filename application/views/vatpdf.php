<style type="text/css">
html {font-size: 10px;-webkit-tap-highlight-color: transparent; }
body {font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;font-size: 14px; line-height: 1.42857;color: #333333;background-color: #fff; }
table {border-collapse: collapse;border-spacing: 0; }
td,th {padding: 0; }
table {background-color: transparent; }
th {text-align: left; }
.table {width: 100%;max-width: 100%;margin-bottom: 20px; }
.table > thead > tr > th,
.table > thead > tr > td,
.table > tbody > tr > th,
.table > tbody > tr > td,
.table > tfoot > tr > th,
.table > tfoot > tr > td {padding: 8px;line-height: 1.42857;vertical-align: top;border-top: 1px solid #e7ecf1; }
.table > thead > tr > th {vertical-align: bottom;border-bottom: 2px solid #e7ecf1; }
.table > thead:first-child > tr:first-child > th,
.table > thead:first-child > tr:first-child > td {border-top: 0; }
.table > tbody + tbody {border-top: 2px solid #e7ecf1; }
.table .table {background-color: #fff; }

@page {size: 8.5in 11in;margin: 1mm;margin-header: 0mm;margin-footer: 5mm; margin-left: 0cm;margin-right: 0cm;}

.container{width: 190mm;height: auto;margin:auto;}
.logo_container{width:50%;float: left;}
.value_added_content{width: 100%;float: right;border-bottom: 1px solid black;}
.val_tax_addng{width: 50%;float: right;font-size: 10px;}
.value_added_content .val_tax{float: left;width: 67%;bottom: 0px;font-size: 12px;line-height: 32px;display: inline-block;}
		.value_added_content .valu_butn{float: right;font-weight:bold;margin-bottom: 2px;background: black;color:white;border: none;width: 185px;height: 30px;width: 33%;line-height: 28px;text-align: center;}
		}
		.return_remt{width: 50%;float:right;}
		.remint_vat{width: 67%;float: left;font-size: 10px;}
		.part_2{width: 32%;float: right;border:1px solid black;margin-top: 2px;text-align: center; }
		.table_text{margin-top: 10px;}
		.table_text .input_div{    width: 80%;height: 35px;}
		.table_text .inpu_half_div{width: 30%;}
		.registratn_quote{width: 100%;}
		.dot {height: 10px;width: 10px;background-color: black;border-radius: 50%;display: inline-block;margin-left: 5px;}
		.val_text_area_left{width: 70%;margin-top: 5px;float: left;}
		.val_text_area_left .input_test{width:90%;border:1px solid gray;background: white;height: 10px;margin-bottom: 2px;}
		.val_text_area_right{float: right;width: 30%;}
		.val_text_rspan{font-size: 8px;}
	</style>
<style type="text/css">
	/*@page {
	size: 8.5in 11in;

	margin: 1mm;

	margin-header: 0mm;
	margin-footer: 5mm; 
	margin-left: 0cm;
	margin-right: 0cm;

}
		.container{
			width: 190mm;
			height: auto;
			margin:auto;
			
		}
	
		.logo_container{width:50%;float: left;}
		.value_added_content{width: 100%;float: right;border-bottom: 1px solid black;}
		
		.val_tax_addng{width: 50%;float: right;font-size: 10px;}
		.value_added_content .val_tax{float: left;width: 67%;bottom: 0px;font-size: 12px;line-height: 32px;display: inline-block;}
		.value_added_content .valu_butn{float: right;font-weight:bold;margin-bottom: 2px;background: black;color:white;border: none;width: 185px;height: 30px;width: 33%;line-height: 28px;text-align: center;}
		}
		.return_remt{width: 50%;float:right;}
		.remint_vat{width: 67%;float: left;font-size: 10px;}
		.part_2{width: 32%;float: right;border:1px solid black;margin-top: 2px;text-align: center; }
		.table_text{margin-top: 10px;}
		.table_text .input_div{    width: 80%;height: 35px;}
		.table_text .inpu_half_div{width: 30%;}
		.registratn_quote{width: 100%;}
		.dot {height: 10px;width: 10px;background-color: black;border-radius: 50%;display: inline-block;margin-left: 5px;}
		.val_text_area_left{width: 70%;margin-top: 5px;float: left;}
		.val_text_area_left .input_test{width:90%;border:1px solid gray;background: white;height: 10px;margin-bottom: 2px;}
		.val_text_area_right{float: right;width: 30%;}
		.val_text_rspan{font-size: 8px;}*/
	</style>
<?php //echo "<pre>";print_r($user_details);echo "</pre>"; 
$address1 = $address2 = $name = $vat_no  = $trading_name = $zip_code = '';
if($user_details)
{
	foreach($user_details as $user_detail)
	{
		$address1 = $user_detail->address1;
		$address2 = $user_detail->address2;
		$name = $user_detail->name;
		$vat_no = $user_detail->vat_no;
		$trading_name = $user_detail->trading_name;
		$zip_code = $user_detail->zip_code;
		$address1 = $user_detail->address1;
		$address1 = $user_detail->address1;
	}
}
?>


<div class="container">
	<div class="text_content">
		<div class="logo_container">
			<div class="logo">
				<img src="<?php echo BASE_URL; ?>/uploads/vat-201_new.jpg" width="80%">
			</div>
			
			<div class="table_text">
				<div class="" style="width: 80%;height: 10px;border: 1px solid #ddd;background: white;font-size: 8px;line-height: 14px;"><?php echo $name; ?></div>
				<div class="" style="width: 80%;height:10px;border: 1px solid #ddd;background: white;font-size: 8px;line-height: 14px;"><?php echo $address1; ?></div>
				<div class="" style="width: 80%;height: 10px;border: 1px solid #ddd;background: white;font-size: 8px;line-height: 14px;"><?php echo $address2; ?></div>
<!--
				<div class="" style="width: 80%;height: 10px;border: 1px solid #ddd;background: white;font-size: 8px;line-height: 14px;"></div>
-->
<!--
				<div class="" style="width: 80%;height: 10px;border: 1px solid #ddd;background: white;font-size: 8px;line-height:14px;"></div>
-->
				<div class="" style="width: 30%;height: 10px;border: 1px solid #ddd;background: white;font-size: 8px;line-height: 14px;"><?php echo $zip_code; ?></div>
		
			</div>
		</div>
		<div class="val_tax_addng">
			<div class="value_added_content" >
			
				<div  class="val_tax" style="" >VALUE-ADDED TAX</div>
				<div class="valu_butn">VAT 201</div>
			</div>
			<div class="return_remt">
				<div class="remint_vat">Return for remitance of VAT</div>
				<div class="part_2"> PART 2</div>
			</div>
			<div class="registratn_quote">
				<div class="val_text_area_left" style="">
						<div class="input_test" type="text" name="" style="width:90%;border:1px solid #ddd;background: white;height: 10px;font-size: 10px;line-height: 10px;"><?php echo $vat_no; ?></div>
						<div class="" type="text" name="" style="width:90%;background: #ddd;border:1px solid #ddd;height: 10px;font-size: 8px;line-height: 10px;">Please use this telephone no. for any enquiries</div>
						<div class="" type="text" name="" style="width:90%;background: #ddd;height: 10px;font-size: 8px;line-height: 10px;border:1px solid #ddd;background: white;margin-bottom: 2px;"></div>
					</div>
					<div class="val_text_area_right" >
						<span class="val_text_rspan" style="">always quote this registration number in correspondence and during intervals</span>
					</div>
					<div class="" style="clear: both;"></div>
					
					<table style="width: 100%;margin-bottom: 2px;">
						<tr>
							<td style="border:1px solid #ddd;background: #ddd;font-size: 8px;height: 10px;width: 50%;float: left;margin-bottom: 2px;">last day for rendering return / payments</td>
							
							<td style="border:1px solid #ddd;background: white;font-size: 8px;height: 10px;width: 45%;float: right;line-height: 10px;margin-bottom: 2px;text-indent: 5px;"></td>
						</tr>
					</table>
					<div style="clear: both;"></div>

					<div class="last_date">
					<table style="width: 100%;margin-bottom: 2px;">
						<tr>
							<td style="background: #ddd;font-size: 8px;width: 40%;height: 20px">Amount of Payment</td>
							<td style="font-size: 8px;width: 5%;text-align: center;height: 20px;">R</td>
							<td style="border:1px solid #ddd;font-size: 8px;width: 50%;height: 20px;"></td>
						</tr>
					</table>
						
					</div>
					<table style="width: 100%;margin-bottom: 2px;">
						<tr>
							<td style="border:1px solid #ddd;background: #ddd;font-size: 8px;height: 10px;width: 30%;float: left;margin-bottom: 2px;line-height: 10px;">Remittance received on</td>
							
							<td style="border:1px solid #ddd;background: white;font-size: 8px;height: 10px;width: 65%;float: right;line-height: 10px;margin-bottom: 2px;text-indent: 5px;"></td>
						</tr>
					</table>
					<table style="width: 100%;margin-bottom: 2px;">
						<tr>
							<td  style="background: #ddd;font-size: 8px;height: 12px;margin-bottom: 1px;">Method of payment / indicate with an "x" below</td>
						</tr>
					</table>
					<table style="width: 100%;margin-bottom: 2px;">
						<tr>
							<td style="border:1px solid #ddd;background: white;font-size: 8px;height: 20px;width: 20%;margin-bottom: 2px;line-height: 20px;text-align: left;text-indent: 5px;text-align: center;">Check</td>
							<td style="font-size: 8px;text-align: center;height: 20px;width: 8%;">2</td>
							<td style="font-size: 8px;width: 5%;text-align: center;height: 20px;border:1px solid #ddd;background: white;"></td>
							<td style="width: 5%;"></td>
							<td style="border:1px solid #ddd;background: white;font-size: 8px;height: 20px;width: 15%;margin-bottom: 2px;line-height: 20px;text-align: left;text-indent: 5px;text-align: center;">Cash</td>
							<td style="font-size: 8px;text-align: center;height: 20px;width: 8%;">1</td>
							<td style="font-size: 8px;width: 5%;text-align: center;height: 20px;border:1px solid #ddd;background: white;"></td>
							<td style="width: 5%;"></td>
							<td style="border:1px solid #ddd;background: white;font-size: 8px;height: 20px;width: 25%;margin-bottom: 2px;line-height: 20px;text-align: left;text-indent: 5px;text-align: center;">Bank / Indent</td>
							<td style="font-size: 8px;text-align: center;height: 20px;width: 2%;"></td>
							<td style="font-size: 8px;width: 5%;text-align: center;height: 20px;border:1px solid #ddd;background: white;"></td>

							
						</tr>
					</table>
					
					

					
			</div>

		
		</div>
	</div>
	<div style="clear: both;"></div>
	<div style="width: 100%;">
		<div class="" style="width: 49%;float: left;">
				<table style="width: 100%; float: left; ">
						<tr>
							<td style=" font-size: 8px; height: 10px;width: 100%;"></td>
						</tr>
						
						<tr>
							<td style=" font-size: 8px; height: 10px;">Trading or other name</td>
						</tr>
						<tr>
							<td style=" font-size: 8px; height: 18px;width: 100%;border:1px solid #ddd;"><?php echo $trading_name; ?></td>
						</tr>
				</table>
		</div>
		<div style="width: 50%;float: right;">
		<table style="width: 100%;">
						<tr>
							<td style="border: 1px solid #ddd; font-size: 8px; height: 15px;color: black;font-weight: bold;">Bank Details</td>
						</tr>
					</table>
			<table style="width: 100%;">
						<tr>
							<td style=" font-size: 8px; height: 10px;color: black;width: 25%;line-height: 10px;">Refer no:4</td>
							<td style=" font-size: 8px; height: 10px;color: black;width: 75%;line-height: 10px;">VDO</td>
						</tr>
					</table>
					<table style="width: 100%;">
						<tr>
							<td style=" font-size: 8px; height: 10px;width: 30%">Beneficiary ID Account no:</td>
						
							<td style=" font-size: 8px; height: 10px;width: 70%;">SARS-VAT</td>
						</tr>
					</table>
		</div>
		<div style="clear: both;"></div>
		<div style="width: 100%;">
			<div class="" style="float: left;width: 49%;">
				<table style="width: 100%;float: left;margin-top: 2px;">
						<tr>
							<td style=" font-size: 8px; height: 10px;width: 20%;height:20px;border:1px solid #ddd;background: #ddd;margin-top: 1px;">Tax period ending</td>
							<td style="width: 1%;"></td>
							<td style="width: 34%;height: 10px; border:1px solid #ddd;height:20px;"><?php echo $start_month.'/'.$end_month; ?></td>
							<td style="width: 1%;"></td>
							<td style="width: 34%;height: 10px; border:1px solid #ddd;height:20px;"><?php echo $month_year; ?></td>
						</tr>
				</table>
				<table style="width: 100%;float: left;margin-top: 2px;">	
						<tr>
							<td style=" font-size: 8px; height: 10px;width: 20%;height:20px;border:1px solid #ddd;background: #ddd;">VAT registration number</td>
							<td style="width: 1%;"></td>
							<td  style="width: 79%;height: 10px; border:1px solid #ddd;height:20px;font-size: 8px;line-height: 20px;"><?php echo $vat_no; ?></td>
							
						</tr>
				</table>
			</div>
			<div style="width: 50%;float: right;">
				 <table style="width: 100%;float: right;margin-top: 2px;">
						<tr>
							<td style=" font-size: 8px;height:20px; width: 20%;border:1px solid #ddd;background: #ddd;">Date received</td>
							<td style="width: 1%"></td>
							<td style="width: 59%;height: 20px; border:1px solid #ddd;"></td>
							<td style="width: 1%;"></td>
							<td style="width: 19%;height: 20px; border:1px solid #ddd;background: black;color: white;text-align: center;">VAT 201</td>
						</tr>
				</table>
				 <table style="width: 100%;float: right;margin-top: 2px;">
						<tr>
							<td style=" font-size: 8px;height:20px;text-align: center; width: 20%;border:1px solid #ddd;background: #ddd;">Area</td>
							<td style="width: 1%;"></td>
							<td style="width: 39%;height: 20px; border:1px solid #ddd;"></td>
							<td style="width: 1%;"></td>
							<td style="width: 19%;height: 20px; border:1px solid #ddd;"></td>
							<td style="width: 1%;"></td>
							<td style="width: 19%;height: 20px; border:1px solid #ddd;color: black;text-align: center;">PART 1</td>
						</tr>
				</table> 
			</div>
			</div>
			<div style="clear: both;"></div>
			<div style="width: 100%;">
				<div style="width: 40%;float: left;">
					<table style="width: 100%;float: right;margin-top: 2px;">
						<tr>
							<td style=" font-size: 8px;height:10px;text-align: left; text-transform:  uppercase;">A.Calculation of output tax</td>
							
						</tr>
						<tr>
							<td style=" font-size: 8px;height:10px;text-align: left; ">Supply of goods and / or service by you:</td>
							
						</tr>
						<tr>
							<td style=" font-size: 8px;height:20px;text-align: left; border:1px solid #ddd;">Standard-rate(excluding capital goods and / or services and accomadation) </td>
							
						</tr>
						<tr>
							<td style=" font-size: 8px;height:20px;text-align: left; border:1px solid #ddd;">Standard-rate(excluding capital goods and / or services ) </td>
						</tr>
						<tr>
							<td style=" font-size: 8px;height:20px;text-align: left; border:1px solid #ddd;">Zero-rate</td>
						</tr>
						<tr>
							<td style=" font-size: 8px;height:20px;text-align: left; border:1px solid #ddd;">Exempt and non-supplies</td>
						</tr>
				</table>
				<table style="width: 100%;float: right;">
						<tr>
							<td style=" font-size: 8px;height:20px;text-align: left; width: 40%;border:1px solid #ddd ;">Supply of accomadation:</td>
							<td colspan="2" style=" font-size: 8px;height:20px;text-align: left; border:1px solid #ddd;background: #ddd;">TOTAL AMOUNT (EXCLUDING VAT)</td>
							<td style="width: 20%;border: 1px solid #ddd;"></td>
						</tr>
						<tr>
							<td style=" font-size: 8px;height:20px;text-align: left; width: 20%;border:1px solid #ddd;">EXceeding 28 Days</td>
							<td style="width: 5%;text-align: center;background: #ddd;font-size: 8px; line-height: 10px;">5</td>
							<td style=" font-size: 8px;height:20px;text-align: left; width: 40%;border:1px solid #ddd;background: white;"></td>
							<td style="width: 20%;border: 1px solid #ddd;text-align: center;font-size: 8px;line-height: 10px; "> x 60%</td>
						</tr>
						<tr>
							<td colspan="4" style="font-size: 8px;line-height: 10px;border: 1px solid #ddd;height: 20px;">Not exceeding 28 Days</td>
						</tr>
						<tr>
							<td colspan="4" style="font-size: 8px;line-height: 10px;color: black;font-weight: bold;text-align:right;text-transform: uppercase;height: 20px;">Total</td>
						</tr>
						<tr>
							<td colspan="4" style="font-size: 8px;line-height: 10px;color: black;font-weight: bold;text-align:left;text-transform: uppercase;height: 20px;">Adjustments:</td>
						</tr>
						<tr>
							<td colspan="4" style="font-size: 8px;line-height: 10px;color: black;font-weight: bold;text-align:left;text-transform: uppercase;height: 20px;border:1px solid #ddd;">Change in use and export of second-hand goods</td>
						</tr>


				</table> 
				</div>
				<div style="width: 30%;float: left;">
					<div style="width: 90%;margin: auto;">
						<table style="width: 100%;">
							<tr>
								<td colspan="2" style="font-size: 8px;height:10px;text-align: center; text-transform:  uppercase;">RANDS ONLY</td>
							</tr>
							<tr>
								<td colspan="2" style="font-size: 8px;height:10px;text-align: left;background: #ddd; ">Consideration (Including VAT)</td>
							</tr>
							<tr>
								<td style="font-size: 8px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 5%;border-right: 1px solid white; ">1 </td>
								<td style="font-size: 8px;height:20px;text-align: center;border: 1px solid #ddd;background: white;width: 95%; "><?php echo $total_sale; ?> </td>
							</tr>
							<tr>
								<td style="font-size: 8px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 5%;border-right: 1px solid white; ">1A </td>
								<td style="font-size: 8px;height:20px;text-align: center;border: 1px solid #ddd;background: white;width: 95%; "> </td>
							</tr>
							<tr>
								<td style="font-size: 8px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 5%;border-right: 1px solid white; ">2 </td>
								<td style="font-size: 8px;height:20px;text-align: center;border: 1px solid #ddd;background: white;width: 95%; "><?php if(!empty($sales_zer_arr)) echo $sales_zer_arr[0]; ?> </td>
							</tr>
							<tr>
								<td style="font-size: 8px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 5%;border-right: 1px solid white; ">3 </td>
								<td style="font-size: 8px;height:20px;text-align: center;border: 1px solid #ddd;background: white;width: 95%; "><?php if(!empty($sales_zer_arr)) echo $sales_zer_arr[1]; ?> </td>
							</tr>
							<tr>
								<td colspan="2" style="font-size: 8px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 5%;border-right: 1px solid white;text-transform: uppercase; ">Taxable value (Excluding vat) </td>
								
							</tr>
							<tr>
								<td style="font-size: 8px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 5%;border-right: 1px solid white; ">6 </td>
								<td style="font-size: 8px;height:20px;text-align: center;border: 1px solid #ddd;background: white;width: 95%; "> </td>
							</tr>
							<tr>
								<td style="font-size: 8px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 5%;border-right: 1px solid white; ">7 </td>
								<td style="font-size: 8px;height:20px;text-align: center;border: 1px solid #ddd;background: white;width: 95%; "> </td>
							</tr>
							<tr>
								<td style="font-size: 8px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 5%;border-right: 1px solid white; ">8 </td>
								<td style="font-size: 8px;height:20px;text-align: center;border: 1px solid #ddd;background: white;width: 95%; "> </td>
							</tr>
							<tr>
								<td colspan="2" style="font-size: 8px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 5%;border-right: 1px solid white;text-transform: uppercase; ">Consideration (Including vat) </td>
								
							</tr>
							<tr>
								<td style="font-size: 8px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 10%;border-right: 1px solid white; ">10 </td>
								<td style="font-size: 8px;height:20px;text-align: center;border: 1px solid #ddd;background: white;width: 90%; "> </td>
							</tr>

						</table>
					</div>
				</div>
				<div style="width: 10%;float: left;">
					<div style="width: 90%;margin:auto;">
						<table style="width: 100%;">
							<tr style="width: 100%;height: 20px;"><td style="height: 20px;"></td></tr>
							<tr style="width: 100%;height: 20px;border: 1px solid #ddd;font-size: 8px;">
								<td style="border:1px solid #ddd;text-align: center;font-size: 8px;height: 20px;"> X r/100-r</td>
							</tr>
							<tr style="width: 100%;height: 20px;border: 1px solid #ddd;font-size: 8px;">
								<td style="border:1px solid #ddd;text-align: center;font-size: 8px;height: 20px;"> X r/100-r</td>
							</tr>
							<tr style="width: 100%;height: 20px;"><td style="height: 20px;"></td></tr>
							<tr style="width: 100%;height: 20px;"><td style="height: 20px;"></td></tr>
							<tr style="width: 100%;height: 20px;"><td style="height: 20px;"></td></tr>
							<tr style="width: 100%;height: 20px;"><td style="height: 20px;"></td></tr>
							<tr style="width: 100%;height: 20px;"><td style="height: 20px;"></td></tr>
							<tr style="width: 100%;height: 20px;border: 1px solid #ddd;font-size: 8px;line-height: 15px;">
								<td style="border:1px solid #ddd;text-align: center;font-size: 8px;height: 20px;"> X r/100-r</td>
							</tr>
							<tr style="width: 100%;height: 20px;"><td style="height: 20px;"></td></tr>
							<tr style="width: 100%;height: 20px;border: 1px solid #ddd;font-size: 8px;line-height: 15px;">
								<td style="border:1px solid #ddd;text-align: center;font-size: 8px;height: 20px;"> X r/100-r</td>
							</tr>
						</table>
					</div>
				</div>
				<div style="width: 20%;float: left;">
					<div style="width: 100%;margin: auto;">
						<table style="width: 100%;">
							<tr style="">
								<td  style="width:20%;font-size: 8px;height:10px;text-align: left; text-transform:  uppercase;"></td>
								<td  style="font-size: 8px;height:10px;text-align: left; text-transform:  uppercase;width: 40%;">R</td>
								<td  style="font-size: 8px;height:10px;text-align: right; text-transform:  uppercase;width: 40%;">c</td>
							</tr>
							<tr>
								<td colspan="3" style="font-size: 8px;height:10px;text-align: left; text-transform:  uppercase;text-align: center;background: #ddd;">VAT</td>
								
							</tr>
							<tr>
								<td style="font-size: 8px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 10%;border-right: 1px solid white; ">4 </td>
								<td colspan="2" style="font-size: 8px;height:20px;text-align: center;border: 1px solid #ddd;background: white;width: 90%; "><?php echo $sale_total_vatfornet_ta; ?> </td>
							</tr>
							<tr>
								<td style="font-size: 8px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 10%;border-right: 1px solid white; ">4A </td>
								<td colspan="2" style="font-size: 8px;height:20px;text-align: center;border: 1px solid #ddd;background: white;width: 90%; "> </td>
							</tr>
							<tr style="width: 100%;height: 20px;"><td style="height: 20px;"></td></tr>
							<tr style="width: 100%;height: 20px;"><td style="height: 20px;"></td></tr>
							<tr style="width: 100%;height: 20px;"><td style="height: 20px;"></td></tr>
							<tr style="width: 100%;height: 20px;"><td style="height: 20px;"></td></tr>
							<tr>
								<td colspan="3" style="font-size: 8px;height:20px;text-align: left; text-transform:  uppercase;text-align: center;background: #ddd;">VAT</td>
								
							</tr>
							<tr>
								<td style="font-size: 8px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 10%;border-right: 1px solid white; ">9 </td>
								<td colspan="2" style="font-size: 8px;height:20px;text-align: center;border: 1px solid #ddd;background: white;width: 90%; "> </td>
							</tr>
							<tr>
								<td colspan="3" style="font-size: 8px;height:20px;text-align: left; text-transform:  uppercase;text-align: center;background: #ddd;">VAT</td>
								
							</tr>
							<tr>
								<td style="font-size: 8px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 10%;border-right: 1px solid white; ">11 </td>
								<td colspan="2" style="font-size: 8px;height:20px;text-align: center;border: 1px solid #ddd;background: white;width: 90%; "> </td>
							</tr>
						</table>
					</div>
				</div>
				
			</div>
	</div>
	<div style="clear: both;"></div>
	<div style="width: 100%;">

		<div style="width: 80%;float:left;">
				<table style="width: 99.5%;">
							<tr style="">
								<td  style="font-size: 8px;line-height: 10px;color: black;font-weight: bold;text-align:left;height: 20px;border:1px solid #ddd;">Other</td>
							</tr>
				</table>
			<div style="width: 95%;">
						<table style="width: 100%;">
							<tr style="">
								<td  style="font-size: 8px;height:20px;text-align: left; text-transform:  uppercase;width: 20%;background: #ddd;">total a</td>
								<td style="width: 10%;"></td>
								<td  style="font-size: 8px;height:20px;text-align: left; text-transform:  uppercase;width: 70%;background:  #ddd;"> total output tax(4 + 4a +9 + 11 + 12)</td>
							</tr>
							<tr style="">
								<td colspan="3" style="font-size: 8px;height:15px;text-align: left; width: 20%;">B CALCULATION OF INPUT TAX (Input tax in respect of):</td>
							</tr>
							<tr style="">
								<td colspan="3" style="font-size: 8px;height:20px;text-align: left; width: 20%;border:1px solid #ddd;"><strong>Capital goods and / or services</strong> imported by and/or supplied  to you</td>
							</tr>
							<tr style="">
								<td colspan="3" style="font-size: 8px;height:20px;text-align: left; width: 20%;border:1px solid #ddd;"><strong>Other goods and / or services</strong> imported by and/or supplied  to you (not capital goods and or services)</td>
							</tr>
							<tr style="">
								<td colspan="3" style="font-size: 8px;height:20px;text-align: left; width: 20%;font-weight: bold;line-height: 20px;">Tax on adjustment:</td>
							</tr>
							<tr style="">
								<td colspan="3" style="font-size: 8px;line-height: 20px;height:20px;text-align: left; width: 20%;border:1px solid #ddd;">Change in use</td>
							</tr>
							<tr style="">
								<td colspan="3" style="font-size: 8px;line-height: 20px;height:20px;text-align: left; width: 20%;border:1px solid #ddd;"> Bad Debits</td>
							</tr>
							<tr style="">
								<td colspan="3" style="font-size: 8px;line-height: 20px;height:20px;text-align: left; width: 20%;border:1px solid #ddd;">Other</td>
							</tr>
							<tr style="">
								<td  style="font-size: 8px;height:20px;line-height: 20px;text-align: left; text-transform:  uppercase;width: 20%;background: #ddd;">total b</td>
								<td style="width: 20%;"></td>
								<td  style="font-size: 8px;height:20px;line-height: 20px;text-align: left; text-transform:  uppercase;width: 60%;background:  #ddd;"> total output tax(14 + 15 + 16 + 17 + 18)</td>
							</tr>
							<tr style="border:1px solid white;">
								<td colspan="2" style="font-size: 8px;height:20px;text-align: left;line-height: 20px; width: 50%;background: #ddd;"> VAT PAYABLE / REFUNDABLE (Total A - Total B)</td>
								
								<td  style="font-size: 8px;height:20px;text-align: left; text-transform:  uppercase;width: 50%;background:  #ddd;"> This must be completed</td>
							</tr>
							<tr style="border:1px solid white;">
								<td colspan="2" style="font-size: 8px;height:10px;line-height: 20px;text-align: left; width: 50%;"> </td>
								
								<td  style="font-size: 8px;height:10px;line-height: 20px;text-align: left; text-transform:  uppercase;width: 50%;"></td>
							</tr>
						</table>
						<table style="width: 100%;">
							<tr >
								<td style="font-size: 8px;height:20px;line-height: 20px;text-align: left; width: 20%;border:1px solid #ddd;">Additional penalty R </td>
								<td style="width: 20%;font-size: 8px;border:1px solid #ddd;">c</td>
								<td style="width: 20%;font-size: 8px;border:1px solid #ddd;">+ Interest R</td>
								<td style="width: 20%;font-size: 8px;border:1px solid #ddd;">C</td>
								<td  style="font-size: 8px;height:20px;line-height: 20px;text-align: left; width: 10%;border:1px solid #ddd;">=</td>
							</tr>
							<tr >
								<td colspan="3" style="font-size: 8px;height:20px;line-height: 20px;text-align: left; width: 20%;border:1px solid #ddd;text-transform: uppercase;">Amount payable or refundable </td>
								
								<td colspan="2" style="font-size: 8px;height:20px;line-height: 20px;text-align: right; width: 10%;border:1px solid #ddd;">(Total 20 + Total 22)</td>
							</tr>
							<tr >
								<td colspan="5" style="font-size: 8px;height:20px;line-height: 20px;text-align: left; width: 20%;text-transform: uppercase;">CALCULATION OF DIESEL REFUND IN TERMS  OF THE CUSTOMS AND EXCISE ACT  </td>
								
								
							</tr>
							
						</table> 
			</div>

			


		</div>

		<div style="width: 20%;float:right;">
			<table style="width: 100%;">
							<tr>
								<td style="font-size: 7px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 5%;border-right: 1px solid white;width: 20%; ">12 </td>
								<td  style="font-size: 7px;height:20px;text-align: center;border: 1px solid #ddd;background: white;width: 80%; ">1 </td>
							</tr>
							<tr>
								<td style="font-size: 7px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 5%;border-right: 1px solid white;width: 20%; ">13 </td>
								<td  style="font-size: 7px;height:20px;text-align: center;border: 1px solid #ddd;background: white;width: 80%; "><?php echo $sale_total_vatfornet_ta; ?> </td>
							</tr>
							<tr style="width: 100%;height: 10px;"><td style="height: 10px;"></td></tr>
							<tr>
								<td style="font-size: 7px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 5%;border-right: 1px solid white;width: 20%; ">14 </td>
								<td  style="font-size: 7px;height:20px;text-align: center;border: 1px solid #ddd;background: white;width: 80%; "> </td>
							</tr>
							<tr>
								<td style="font-size: 7px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 5%;border-right: 1px solid white;width: 20%; ">15 </td>
								<td  style="font-size: 7px;height:20px;text-align: center;border: 1px solid #ddd;background: white;width: 80%; "><?php echo $cost_total_vatfornet_ta; ?> </td>
							</tr>
							<tr style="width: 100%;height: 15px;"><td style="height: 15px;"></td></tr>
							<tr>
								<td style="font-size: 7px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 5%;border-right: 1px solid white;width: 20%; ">16 </td>
								<td  style="font-size: 7px;height:20px;text-align: center;border: 1px solid #ddd;background: white;width: 80%; "> </td>
							</tr>
							<tr>
								<td style="font-size: 7px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 5%;border-right: 1px solid white;width: 20%; ">17 </td>
								<td  style="font-size: 7px;height:20px;text-align: center;border: 1px solid #ddd;background: white;width: 80%; "> </td>
							</tr>
							<tr>
								<td style="font-size: 7px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 5%;border-right: 1px solid white;width: 20%; ">18 </td>
								<td  style="font-size: 7px;height:20px;text-align: center;border: 1px solid #ddd;background: white;width: 80%; "> </td>
							</tr>
							<tr>
								<td style="font-size: 7px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 5%;border-right: 1px solid white;width: 20%; ">19 </td>
								<td  style="font-size: 7px;height:20px;text-align: center;border: 1px solid #ddd;background: white;width: 80%; "><?php echo $cost_total_vatfornet_ta; ?> </td>
							</tr>
							<tr>
								<td style="font-size: 7px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 5%;border-right: 1px solid white;width: 20%; ">20 </td>
								<td  style="font-size: 7px;height:20px;text-align: center;border: 1px solid #ddd;background: white;width: 80%; "><?php echo $final_vat; ?> </td>
							</tr>
							<tr style="width: 100%;height: 10px;"><td style="height: 10px;"></td></tr>
							 <tr>
								<td style="font-size: 7px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 5%;border-right: 1px solid white;width: 20%; ">22 </td>
								<td  style="font-size: 7px;height:20px;text-align: center;border: 1px solid #ddd;background: white;width: 80%; "> </td>
							</tr> 
							<tr>
								<td style="font-size: 7px;height:20px;text-align: center;border-top: 1px solid white;background: #ddd;border-bottom:1px solid white;width: 5%;border-right: 1px solid white;width: 20%; ">23 </td>
								<td  style="font-size: 7px;height:20px;text-align: center;border: 1px solid #ddd;background: white;width: 80%; "> <?php echo $final_vat; ?></td>
							</tr> 
							<tr style="width: 100%;height: 20px;"><td style="height: 20px;"></td></tr>
							
			</table>
		</div>
	</div>
			<div style="clear: both;"></div>
				<div style="width: 100%;">
						<div class="" style="width: 40%;float: left;">
							<table style="width: 100%;">
								<tr>
									<td style="width: 10%;background: #ddd;font-size: 8px;text-align: center;">24</td>
									<td style="width: 40%;border:1px solid #ddd;background: #ddd;font-size: 8px;line-height: 20px;height: 20px;">On land</td>
									<td style="width: 40%;"></td>
									<td style="width: 10%;"></td>
								</tr>
								<tr style="">
									<td style="width: 10%;background: #ddd;font-size: 8px;line-height: 20px;height: 20px;border-top:1px solid white; text-align: center;">25</td>
									<td style="width: 40%;border:1px solid #ddd;font-size: 8px;line-height: 20px;height: 20px;border-top:1px solid white;">Total purchase(1)</td>
									<td style="width: 40%;border:1px solid #ddd;height: 20px;font-size: 8px;"></td>
									<td style="width: 10%;"></td>
								</tr>
								<tr style="">
									<td style="width: 10%;background: #ddd;font-size: 8px;line-height: 20px;height: 20px;border-top:1px solid white; text-align: center;">27</td>
									<td style="width: 40%;border:1px solid #ddd;font-size: 8px;line-height: 20px;height: 20px;border-top:1px solid white;">Eligible purchase(1)</td>
									<td style="width: 40%;border:1px solid #ddd;height: 20px;font-size: 8px;"></td>
									<td style="width: 10%;height: 20px;font-size: 8px;text-align: center;"> X</td>
								</tr>
								<tr style="">
									<td style="width: 10%;background: #ddd;font-size: 8px;line-height: 20px;height: 20px;border-top:1px solid white; text-align: center;">30</td>
									<td style="width: 40%;border:1px solid #ddd;font-size: 8px;line-height: 20px;height: 20px;border-top:1px solid white;background: #ddd;">Offshore</td>
									<td style="width: 40%;height: 20px;font-size: 8px;"></td>
									<td style="width: 10%;"></td>
								</tr>
								<tr style="">
									<td style="width: 10%;background: #ddd;font-size: 8px;line-height: 20px;height: 20px;border-top:1px solid white; text-align: center;">25</td>
									<td style="width: 40%;border:1px solid #ddd;font-size: 8px;line-height: 20px;height: 20px;border-top:1px solid white;">Total purchase(1)</td>
									<td style="width: 40%;border:1px solid #ddd;height: 20px;font-size: 8px;"></td>
									<td style="width: 10%;"></td>
								</tr>
								<tr style="">
									<td style="width: 10%;background: #ddd;font-size: 8px;line-height: 20px;height: 20px;border-top:1px solid white; text-align: center;">27</td>
									<td style="width: 40%;border:1px solid #ddd;font-size: 8px;line-height: 20px;height: 20px;border-top:1px solid white;">Eligible purchase(1)</td>
									<td style="width: 40%;border:1px solid #ddd;height: 20px;font-size: 8px;"></td>
									<td style="width: 10%;height: 20px;font-size: 8px;text-align: right;"> </td>
								</tr>
								<tr style="">
									<td style="width: 10%;background: #ddd;font-size: 8px;line-height: 20px;height: 20px;border-top:1px solid white; text-align: center;">30</td>
									<td style="width: 40%;border:1px solid #ddd;font-size: 8px;line-height: 20px;height: 20px;border-top:1px solid white;background: #ddd;">Rail & Harbour services</td>
									<td style="width: 40%;height: 20px;font-size: 8px;"></td>
									<td style="width: 10%;"></td>
								</tr>
								<tr style="">
									<td style="width: 10%;background: #ddd;font-size: 8px;line-height: 20px;height: 20px;border-top:1px solid white; text-align: center;">25</td>
									<td style="width: 40%;border:1px solid #ddd;font-size: 8px;line-height: 20px;height: 20px;border-top:1px solid white;">Total purchase(1)</td>
									<td style="width: 40%;border:1px solid #ddd;height: 20px;font-size: 8px;"></td>
									<td style="width: 10%;"></td>
								</tr>
								<tr style="">
									<td style="width: 10%;background: #ddd;font-size: 8px;line-height: 20px;height: 20px;border-top:1px solid white; text-align: center;">27</td>
									<td style="width: 40%;border:1px solid #ddd;font-size: 8px;line-height: 20px;height: 20px;border-top:1px solid white;">Eligible purchase(1)</td>
									<td style="width: 40%;border:1px solid #ddd;height: 20px;font-size: 8px;"></td>
									<td style="width: 10%;height: 20px;font-size: 8px;text-align: right;"> </td>
								</tr>
							</table>
						</div>
						<div style="width: 40%;float: left;">
							
							<table style="width: 70%;margin: auto;">
							<tr style="">
									<td colspan="4" style="width: 100%; height: 25px;"></td>
								
									
								</tr>
							<tr style="">
									<td style="width: 10%;font-size: 8px;height: 20px;border-top:1px solid white; text-align: center;">26</td>
									<td colspan="2" style="width: 10%;border:1px solid #ddd;font-size: 8px;line-height: 20px;height: 25px;border-top:1px solid #ddd;">Non Eligible purchase(1)</td>
									<td style="width: 10%;border:1px solid #ddd;height: 20px;font-size: 8px;"></td>
									<td style="width: 10%;"></td>
								
									
								</tr>
								<tr style="">
									<td style="width: 20%;font-size: 8px;height: 20px;border-top:1px solid white;">80%</td>
									<td style="width: 10%;border:1px solid #ddd;background: #ddd;font-size: 8px;line-height: 20px;height: 25px;border-top:1px solid white; text-align: center;">28</td>
									<td style="width: 40%;border:1px solid #ddd;height: 20px;font-size: 8px;"></td>
									<td style="width: 20%;height: 20px;font-size: 8px;text-align: center;">X</td>
									
								</tr>
								<tr style="">
									<td style="width: 20%;font-size: 8px;height: 25px;"></td>
									<td style="width: 10%;font-size: 8px;;height:25px;border-bottom:1px solid #ddd;"></td>
									<td style="width: 40%;height: 20px;font-size: 8px;"></td>
									<td style="width: 30%;height: 20px;font-size: 8px;text-align: center;"></td>
									
								</tr>
								<tr style="">
									<td style="width: 10%;background: #ddd;font-size: 8px;line-height: 20px;height: 20px;border-top:1px solid white; text-align: center;">32</td>
									<td style="width: 70%;border:1px solid #ddd;font-size: 8px;line-height: 20px;height: 25px;border-top:1px solid white;">Non Eligible purchase(1)</td>
									<td colspan="2" style="width: 20%;border:1px solid #ddd;height: 20px;font-size: 8px;"></td>
									
								</tr>
								<tr style="">
									<td style="width: 20%;font-size: 8px;height: 20px;"></td>
									<td style="width: 10%;font-size: 8px;height: 20px;border-top:1px solid white;"></td>
									<td style="width: 40%;height: 25px;font-size: 8px;"></td>
									<td style="width: 30%;height: 20px;font-size: 8px;text-align: center;">X</td>
									
								</tr>
								<tr style="">
									<td style="width: 20%;font-size: 8px;height: 25px;"></td>
									<td style="width: 10%;font-size: 8px;;height:25px;border-bottom:1px solid #ddd;"></td>
									<td style="width: 40%;height: 20px;font-size: 8px;"></td>
									<td style="width: 30%;height: 20px;font-size: 8px;text-align: center;"></td>
									
								</tr>
								<tr style="">
									<td style="width: 10%;background: #ddd;font-size: 8px;line-height: 20px;height: 20px;border-top:1px solid white; text-align: center;">32</td>
									<td style="width: 70%;border:1px solid #ddd;font-size: 8px;line-height: 20px;height: 25px;border-top:1px solid white;">Non Eligible purchase(1)</td>
									<td colspan="2" style="width: 20%;border:1px solid #ddd;height: 20px;font-size: 8px;"></td>
									
								</tr>
								<tr style="">
									<td style="width: 20%;font-size: 8px;height: 20px;"></td>
									<td style="width: 10%;font-size: 8px;height: 20px;"></td>
									<td style="width: 40%;height: 25px;font-size: 8px;"></td>
									<td style="width: 30%;height: 20px;font-size: 8px;text-align: center;">X</td>
									
								</tr>
							</table>
						</div>
						<div style="width: 20%;float: left;">
							<table style="width: 100%;">
								<tr>
									<td colspan ="2" style="width: 10%;font-size: 8px;"></td>
									
									<td colspan="2" style="width: 40%;border:1px solid #ddd;text-align: center;font-size: 8px;height: 20px;">DIESEL</td>
									
								</tr>
								<tr>
									<td style="width: 10%;font-size: 8px;"></td>
									<td style="width: 10%;font-size: 8px;"></td>
									<td style="width: 40%;text-align: left;font-size: 8px;height: 20px;">R</td>
									<td style="width: 40%;text-align: right;font-size: 8px;height: 20px;">C</td>
									
								</tr>
								<tr>
									<td style="width: 10%;font-size: 8px;height: 20px;">C/l</td>
									<td style="width: 10%;font-size: 8px;background: #ddd; text-align: center;">29</td>
									<td colspan=2 style="width: 40%;border:1px solid #ddd;text-align: center;font-size: 8px;height: 20px;"></td>
									
								</tr>
								<tr>
									
									<td colspan=4 style="width: 40%;text-align: center;font-size: 8px;height: 44px;"></td>
									
								</tr>
									<tr>
									<td style="width: 10%;font-size: 8px;height: 20px;">C/l</td>
									<td style="width: 10%;font-size: 8px;background: #ddd; text-align: center;">34</td>
									<td colspan=2 style="width: 40%;border:1px solid #ddd;text-align: center;font-size: 8px;height: 20px;"></td>
									
								</tr>
								<tr>
									
									<td colspan=4 style="width: 40%;text-align: center;font-size: 8px;height: 44px;"></td>
									
								</tr>
									<tr>
									<td style="width: 10%;font-size: 8px;height: 20px;">C/l</td>
									<td style="width: 10%;font-size: 8px;background: #ddd; text-align: center;">39</td>
									<td colspan=2 style="width: 40%;border:1px solid #ddd;text-align: center;font-size: 8px;height: 20px;"></td>
									
								</tr>
								</tr>
								
							</table>
						</div>
				</div>
				<div style="width: 100%;">
					<div style="width: 80%;float: left;">
					<table style="width: 100%;float: left;">
						<tr>
							<td style="width: 50%;border:1px solid #ddd;font-size: 8px;height: 20px;">total amount payable or refundable</td>
							<td style="width: 50%; text-align: center;border:1px solid #ddd;font-size: 8px;">20-(29+34+39) or 20+(39+34+39)</td>
						</tr>
					</table>
					</div>
					<div style="width: 20%;float: right;">
						<table style="width: 100%;">
								<tr>
									<td style="width: 10%;font-size: 8px"></td>
									<td style="width: 10%;font-size: 8px;background: #ddd; text-align: center;">40</td>
									<td style="width: 80%;border:1px solid #ddd;text-align: center;font-size: 8px;height: 20px;"><?php echo $final_vat; ?></td>
									
								</tr>
						</table>
					</div>
				</div>
				<div style="width: 100%;">
					<table style="width: 100%;">
						<tr>
							<td style="width: 20%; border: 1px solid #ddd;height: 40px;font-size: 8px;line-height: 20px;">Tell no:<br>Fax no:</td>
							<td style="width: 25%;border: 1px solid #ddd;height: 40px;font-size: 8px;line-height: 20px;">I certify that  the particulars in this return are true and correct</td>
							<td style="width: 20%;border: 1px solid #ddd;height: 40px;font-size: 8px;line-height: 10px;"></td>
							<td style="width: 15%;border: 1px solid #ddd;height: 40px;font-size: 8px;line-height: 20px;"></td>
						</tr>
						<tr>
							<td style="width: 20%;height: 20px;font-size: 8px;">Contact details for THIS return only</td>
							<td style="width: 25%;height: 20px;font-size: 8px;">Authorised person's signature</td>
							<td style="width: 20%;height: 20px;font-size: 8px;">Capacity</td>
							<td style="width: 15%;height: 20px;font-size: 8px;">Date</td>
						</tr>
					</table>
				</div>
						

</div>
