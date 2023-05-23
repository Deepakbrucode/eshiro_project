 <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-users"></i>
                                <a href="#"><?php echo $invoice_txt; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <span><?php echo $formname." ".$invoice_txt; ?></span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light portlet-fit  calendar">
                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="portlet light bordered">
                                            <div class="portlet-title">
                                                <?php echo $this->session->flashdata('invoicing'); ?>
                                
                                                <div class="caption">
                                                    <i class="icon-equalizer font-red-sunglo"></i>
                                                    <span class="caption-subject font-red-sunglo bold uppercase"><?php echo $formname." ".$invoice_txt; ?></span>
                                                    <span class="caption-helper"><?php echo $formname; ?> details</span>
                                                </div>

                                            </div>
                                            <?php  
                                           // echo "<pre>";print_r($ReportDetail);echo "</pre>";
                                            if($ReportDetail)
                                            {
                                            foreach ($ReportDetail as $value) {
												$report_id = $value->report_id;
                                                $user_id = $value->user_id;
                                                $report_date = $value->report_date;
                                                $report_date = date('d/m/Y',strtotime($report_date));
                                                $due_date = $value->due_date;
                                                $due_date = date('d/m/Y',strtotime($due_date));
                                                 $inv_no = $value->inv_no;
                                                 $ref_no = $value->ref_no;
                                                // $description = $value->description;
                                                // $amount_type = $value->amount_type;
                                                // $amount = $value->amount;
                                                // $tax_type = $value->tax_type;
                                                $status = $value->status;
                                                $inv_user_id = $value->inv_user_id;
                                                $amount = $value->amount;
                                                $total_vat = $value->total_vat;
                                                $total_excl_price = $value->total_excl_price;
                                                $invoice_item_count = count($InvoiceMetaDetails);
                                                

                                            }
                                            }
                                            else
                                            {
												$report_id = '';
                                                $report_date = '';
                                                $due_date = '';
                                                $inv_no='';
                                                $ref_no='';
                                                // $description = '';
                                                // $amount_type = '';
                                                // $amount = '';
                                                // $tax_type = '';
                                                $status = 1;
                                                $inv_user_id = '';
                                                $invoice_item_count = 1;
                                                $amount = '';
                                                $total_vat = '';
                                                $total_excl_price = '';
                                              

                                            }
                                            ?>

                               


                                            <div class="portlet-body form">
                                            <?php echo $this->session->flashdata('report'); ?>
                                                <!-- BEGIN FORM-->
                                                <form action="<?php echo BASE_URL;?>invoicing/save_invoice" method="post" class="form-horizontal">
                                                    <input type="hidden" name="report_id" value="<?php echo $report_id; ?>">
                                                    <input type="hidden" name="report_type" value="<?php echo $report_type; ?>">
                                                    
                                                    <div class="form-body">
                                                 
                                                       


<div class="row">
    <div class="col-md-8 col-md-offset-1">
        <div class="col-md-12">
            <div class="col-md-12">
                 <div class="form-group row">
                    <label class="col-md-3 control-label"><?php echo $inv_usertype_txt; ?> Name</label>
                    <div class="col-md-9">

                        <select name="inv_user_id" class="form-control inv_user_id" required>
                            <option value="">Select <?php echo $inv_usertype_txt; ?> Name</option>
                            <?php
                            // echo "<pre>";print_r($InvClientDetails);echo "</pre>";
                                if($InvClientDetails)
                                {
                                    foreach($InvClientDetails as $InvClientDetail)
                                    {
                                       $user_vatno = $InvClientDetail->user_vat;
                                        if($user_vatno == '' && ($report_type == '5' || $report_type == '6'))
                                        {
                                            // echo "iffF";
                                            $cusvat = '';
                                        }
                                        else if($user_vatno != '' && ($report_type == '5' || $report_type == '6'))
                                        {
                                            // echo "elseeeee";
                                            $cusvat = '1';
                                        }
                                        else
                                        {
                                            // echo "finall";
                                            $cusvat = $InvClientDetail->vat_no;
                                        }
                                        // echo "cusvat = ".$cusvat;
                                        $selected = ($inv_user_id == $InvClientDetail->id)?'selected':'';
                                        echo "<option data-vat='".$cusvat."' value='".$InvClientDetail->id."' ".$selected.">".$InvClientDetail->name."</option>";
                                    }
                                }
                                else
                                {
                                    echo "<option value=''>No ".$inv_usertype_txt." avaiable</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6 ">

                <div class="form-group row">
                    <label class="col-md-5 control-label">Inv No</label>
                    <div class="col-md-7">
                        <input type="text" name="inv_no" class="form-control" placeholder="Inv No" value="<?php echo $inv_no; ?>" required>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-md-5 control-label">Ref No</label>
                    <div class="col-md-7">
                        <input type="text" name="ref_no" class="form-control" placeholder="Ref No" value="<?php echo $ref_no; ?>" required>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-md-5 control-label">Inv Date</label>
                    <div class="col-md-7">
                        <input type="text" name="report_date" class="form-control report_date" placeholder="Invoice Date" value="<?php echo $report_date; ?>" required>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-md-5 control-label">Due Date</label>
                    <div class="col-md-7">
                        <input type="text" name="due_date" class="form-control report_date" placeholder="Due Date" value="<?php echo $due_date; ?>" required>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-md-3 control-label" style="padding-top: 0px;">Status</label>
                    <div class="col-md-7">
                        <input type="radio"  name="status" value="1" <?php echo ($status == '1')?'checked':''; ?>>Active &nbsp;&nbsp;&nbsp;
                        <input type="radio"  name="status" value="2" <?php echo ($status == '2')?'checked':''; ?> >In-active
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


                                                        

                                                        

<div class="form-group">
<div class="col-md-12">
    <input type="hidden" class="invoice_item_count" value="<?php echo $invoice_item_count; ?>">
    <input type="hidden" class="vat_basic" value="0">
    <button type="button" class="btn btn-success btn_addinvoice pull-right"><i class="fa fa-plus-square"></i> Add Item</button>
</div>
</div>
<div class="form-group">
<div class="col-md-12">
    <table class="table table-striped table-bordered table-hover invoice_table">
        <thead>
            <tr>
                <th>Description</th>
                <th>Qty</th>
                <th>Excl. Price</th>
                <th>Exclusive</th>
                <th>VAT</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $ii = 0;
            if(!empty($InvoiceMetaDetails)) { 
                foreach($InvoiceMetaDetails as $InvoiceMetaDetail) {?>
            <tr>
                <td><input type="text" class="form-control inv_desc" name="invoice_items[<?php echo $ii; ?>][desc]" placeholder="Description" value="<?php echo $InvoiceMetaDetail->inv_desc; ?>" required></td>
                <td><input type="text" class="form-control inv_qty" name="invoice_items[<?php echo $ii; ?>][qty]" placeholder="Qnaltity" value="<?php echo $InvoiceMetaDetail->inv_qty; ?>" required></td>
                <td><input type="text" class="form-control inv_eprice" name="invoice_items[<?php echo $ii; ?>][excel_price]" placeholder="Excl. Price" value="<?php echo $InvoiceMetaDetail->inv_eprice; ?>" required></td>
                <td><input type="text" class="form-control inv_teprice" name="invoice_items[<?php echo $ii; ?>][excel_price_total]" placeholder="Exclusive" value="<?php echo $InvoiceMetaDetail->inv_teprice; ?>" readonly></td>
                <td><input type="text" class="form-control inv_vat" name="invoice_items[<?php echo $ii; ?>][vat]" placeholder="Vat" value="<?php echo $InvoiceMetaDetail->inv_vat; ?>" readonly> </td>
                <td><input type="text" class="form-control inv_total" name="invoice_items[<?php echo $ii; ?>][total_price]" placeholder="Total Amount" value="<?php echo $InvoiceMetaDetail->inv_total; ?>" readonly></td>
                <td>
                    <?php
                    if($ii !=0) {
                        ?>
                        <button type="button" class="btn btn-circle btn-danger btn_invdelete"><i class="fa fa-trash"></i></button> 
                        <?php } ?></td>
            </tr>
            <?php $ii++; } } else { ?>
                <tr>
                <td><input type="text" class="form-control inv_desc" name="invoice_items[0][desc]" placeholder="Description" value="" required></td>
                <td><input type="text" class="form-control inv_qty" name="invoice_items[0][qty]" placeholder="Qnaltity" value="" required></td>
                <td><input type="text" class="form-control inv_eprice" name="invoice_items[0][excel_price]" placeholder="Excl. Price" value="" required></td>
                <td><input type="text" class="form-control inv_teprice" name="invoice_items[0][excel_price_total]" placeholder="Exclusive" value="" readonly></td>
                <td><input type="text" class="form-control inv_vat" name="invoice_items[0][vat]" placeholder="Vat" value="" readonly> </td>
                <td><input type="text" class="form-control inv_total" name="invoice_items[0][total_price]" placeholder="Total Amount" value="" readonly></td>
                <td><!-- <button type="button" class="btn btn-circle btn-danger"><i class="fa fa-trash"></i></button> --></td>
            </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" style="text-align: right;">Total Exclusive</th>
                <th><input type="text" class="form-control total_excl_price" name="total_excl_price" placeholder="Total Exclusive" value="<?php echo $total_excl_price; ?>" readonly></th>
                <th></th>
            </tr>
            <tr>
                <th colspan="5" style="text-align: right;">Total VAT</th>
                <th><input type="text" class="form-control total_vat" name="total_vat" placeholder="Total VAT" value="<?php echo $total_vat; ?>" readonly></th>
                <th></th>
            </tr>
            <tr>
                <th colspan="5" style="text-align: right;">Total</th>
                <th><input type="text" class="form-control amount" name="amount" placeholder="Final Price" value="<?php echo $amount; ?>" readonly></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
</div>
</div>


													</div>


                                                    <div class="form-actions">
                                                        <div class="row">
                                                            <div class="col-md-offset-3 col-md-9">
                                                                <button type="submit" class="btn green"><?php echo $formname; ?> <?php echo $base_txt; ?></button>
                                                                <button type="button" class="btn default"><a href="<?php echo BASE_URL; ?>invoicing/<?php echo $cancel_url; ?>">Cancel</a></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!-- END FORM-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        <script>
        jQuery(document).ready(function(){
	$('.report_date').datepicker({
		autoclose: true,
        format: 'dd/mm/yyyy',
		orientation: "bottom"
	});




jQuery(".inv_user_id").trigger('change');
});

jQuery(document).on('change','.inv_user_id',function(){
    var this_vat = jQuery(this).find(':selected').attr('data-vat');
    var this_val = jQuery('.tax_type').find(":selected").val();
   // console.log(this_vat+" = this_val ="+this_val);
    // var invoice_type = jQuery(".invoice_type").val();
    // if(invoice_type == '1' || invoice_type == 2)
    // {
    //     jQuery.ajax(function(){
    //         type: 'POST',
    //         url: '<?php echo BASE_URL; ?>'+'invoicing/ajax_customervatcheck';,
    //         data: {customer_id: this_val},
    //         dataType: 'json',
    //         success: function(response){
    //             console.log(response);
    //         }

    //     })
    // }
    
    if(this_vat =='' || typeof this_vat == 'undefined')
    {
        jQuery(".vat_basic").val(0);
        // console.log("iffffff");
        // $(".tax_type option[value=tax]").attr("disabled","disabled");
        // if(this_val == 'tax')
        // $(".tax_type option:selected").prop("selected", false)

    }
    else
    {
        jQuery(".vat_basic").val(0.15);
        // console.log("elseeeeeeeee");
        //  $(".tax_type option[value=tax]").attr("disabled",false);
    }
    price_calculation();
});



jQuery(document).on('click','.btn_addinvoice',function(){
    var invoice_icount = jQuery(".invoice_item_count").val();
    var tr_txt = '<tr><td><input type="text" class="form-control inv_desc" name="invoice_items['+invoice_icount+'][desc]" placeholder="Description" value="" required></td><td><input type="number" class="form-control inv_qty" name="invoice_items['+invoice_icount+'][qty]" placeholder="Qnaltity" value="" required></td><td><input type="text" class="form-control inv_eprice" name="invoice_items['+invoice_icount+'][excel_price]" placeholder="Excl. Price" value="" required></td><td><input type="number" class="form-control inv_teprice" name="invoice_items['+invoice_icount+'][excel_price_total]" placeholder="Exclusive" value="" readonly></td><td><input type="number" class="form-control inv_vat" name="invoice_items['+invoice_icount+'][vat]" placeholder="Vat" value="" readonly></td><td><input type="number" class="form-control inv_total" name="invoice_items['+invoice_icount+'][total_price]" placeholder="Total Amount" value="" readonly></td><td><button type="button" class="btn btn-circle btn-danger btn_invdelete"><i class="fa fa-trash"></i></button></td></tr>';
    jQuery(".invoice_table tbody").append(tr_txt);
    invoice_icount = parseInt(invoice_icount)+1;
    jQuery(".invoice_item_count").val(invoice_icount);
});

jQuery(document).on('click','.btn_invdelete',function(){
    jQuery(this).closest('tr').remove();
    price_calculation();
});

jQuery(document).on('change','.inv_qty, .inv_eprice',function(){
    price_calculation();
})

function price_calculation(){
    var final_total = total_vat = total_excl_price = 0;
    var vat_basic = jQuery(".vat_basic").val();
   jQuery(".invoice_table tbody tr").each(function(){
    var this_val = jQuery(this);
    var inv_qty = jQuery(this).find('.inv_qty').val() || '';
    var inv_eprice = jQuery(this).find('.inv_eprice').val() || '';

    if(inv_qty !='' && inv_eprice !='' )
    {
        
        var inv_teprice = parseInt(inv_qty) * parseFloat(inv_eprice);
        var inv_vat = inv_teprice*parseFloat(vat_basic);
        
        var inv_total = inv_teprice+inv_vat;
        console.log("inv_teprice = "+inv_teprice+" = inv_vat = "+inv_vat);
        final_total +=inv_total;
        total_vat += inv_vat;
        total_excl_price += inv_teprice;

        var inv_teprice1 = inv_teprice.toFixed(2);
        var inv_vat1 = inv_vat.toFixed(2);
        var inv_total1 = inv_total.toFixed(2);
        this_val.find(".inv_teprice").val(inv_teprice1);
        this_val.find(".inv_vat").val(inv_vat1);
        this_val.find(".inv_total").val(inv_total1);
    }
    
    
   }) 
   var total_vat1 = total_vat.toFixed(2);
   var total_excl_price1 = total_excl_price.toFixed(2);
   var final_total1 = final_total.toFixed(2);

   jQuery(".total_vat").val(total_vat1);
   jQuery(".total_excl_price").val(total_excl_price1);
   jQuery(".amount").val(final_total1);
}

        </script>    
    
