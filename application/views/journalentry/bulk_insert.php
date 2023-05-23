 <!-- BEGIN CONTENT -->
 <?php
 $cost_options = '';
if($CostDetails)
{
    foreach($CostDetails as $CostDetail)
    {
        $cost_id1 = $CostDetail->cost_id;
        $links = $CostDetail->links;
        $category_id1 = $CostDetail->category_id;
        $subcategory_id1 = $CostDetail->subcategory_id;
        $opt_val = $category_id1.'-'.$subcategory_id1.'-'.$cost_id1; 
                                                                            
        $cost_options .= "<option value='".$opt_val."' >".$CostDetail->cost_name." (".$links.")</option>";

    }
}
?>
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-users"></i>
                    <a href="#">Journal Entries</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Journal Entry</span>
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
                                    <div class="caption">
                                        <i class="icon-equalizer font-red-sunglo"></i>
                                        <span class="caption-subject font-red-sunglo bold uppercase">Journal Entry</span>
                                        <span class="caption-helper">Journal Entry details</span>
                                     </div>

                                </div>
                                
                                <div class="portlet-body form">
                                    <?php echo $this->session->flashdata('report'); ?>
                                    <div id="alretdanger" class="alert alert-danger" style="display:none"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>The CR and DR amount not equal</span></div>
                                    <div id="alretsuccess"  class="alert alert-success" style="display:none"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><span>Journal entry data Saved Successfully</span></div>
                                    <!-- BEGIN FORM-->
                                    <form action="" name="insetbulkjournal" id="insetbulkjournal" method="post" class="form-horizontal">
                                        <div class="form-body">
                                            <?php if($usertype == '5') { ?>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Client Name</label>
                                                <div class="col-md-4">
                                                    <select name="user_id" class="form-control">
                                                    <?php
                                                        if($ClientDetails)
                                                        {
                                                            foreach($ClientDetails as $ClientDetail)
                                                            {
                                                                
                                                                echo "<option value='".$ClientDetail->id."' >".$ClientDetail->name."</option>";
                                                            }
                                                        }
                                                        else
                                                        {
                                                            echo "<option value=''>No clients avaiable</option>";
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php } else { ?>
                                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                                            <?php } ?>
                                            <input type="hidden" class="journal_count"  id="journal_count"value="1">
                                            <table class="table jounal_bulktb">
                                                <thead>
                                                    <tr>
                                                        <th width="8%">Type</th>
                                                        <th width="11%">Date</th>
                                                        <th>Details</th>
                                                        <th width="11%">Amount</th>
                                                        <th   style="width: 350px;">Account</th>
                                                        <th>Ledger</th>
                                                        <th width="11%"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr id="row_0">
                                                        <td>
                                                            <select id="amount_type0" name="journal_data[0][amount_type]" class="form-control">
                                                                <option value="sales">DR</option>
                                                                <option value="expense">CR</option>
                                                                
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="journal_data[0][report_date]" id="report_date0" class="form-control report_date" placeholder="Date" value="" required>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="journal_data[0][description]" class="form-control" placeholder="Description" value="" id="description0" required>
                                                        </td>
                                                        
                                                        <td>
                                                            <input type="text" name="journal_data[0][amt]" class="form-control" id="amount0"  placeholder="Amount" value="" required>
                                                        </td>
                                                        <td>
                                                            <select name="journal_data[0][cost_id]" class="table_frminput form-control" id="cost_id0">
                                                                <option value="">Select Cost Centre</option>
                                                                <?php
                                                                    if($CostDetails)
                                                                    {
                                                                        foreach($CostDetails as $CostDetail)
                                                                        {

                                                                            $cost_id1 = $CostDetail->cost_id;
                                                                            $links = $CostDetail->links;
                                                                            $category_id1 = $CostDetail->category_id;
                                                                            $subcategory_id1 = $CostDetail->subcategory_id;
                                                                            $opt_val = $category_id1.'-'.$subcategory_id1.'-'.$cost_id1; 
                                                                            
                                                                            echo "<option value='".$opt_val."' >".$CostDetail->cost_name." (".$links.")</option>";

                                                                        }
                                                                    }
                                                                ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                             <select name="journal_data[0][ledgertype]" class="table_frminput form-control " id="ledgertype0">
                                                                <option value="1">Invoice</option>
                                                                <option value="2">Bank</option>
                                                             </select>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-info btn_addrow"><i class="fa fa-plus"></i></button>
                                                             <button type="button" class="btn btn-sm btn-info btn_duplicaterow" data-id="0"><i class="fa fa-clone"></i></button>
                                                         </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button type="submit" id="savedata" class="btn green">Save</button>
                                                    <button type="button" class="btn default"><a href="<?php echo BASE_URL; ?>journalentry/index">Cancel</a></button>
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
    jQuery("#insetbulkjournal").validate({
         debug: true,
         submitHandler: function(form) {
                var formData = new FormData(document.getElementsByName('insetbulkjournal')[0]);
                  $.ajax({
                url: "<?php echo BASE_URL; ?>journalentry/check_jouralentry", 
                type: "POST",             
                data: formData,
                contentType : false,
                cache: false,
                processData : false,
                 success: function(dataval) 
                { 
                    //alert(dataval);
                    if(dataval ==1)
                    {
                        jQuery('#alretdanger').hide();
                         $.ajax({
                            url: "<?php echo BASE_URL; ?>journalentry/saveBulkData", 
                            type: "POST",             
                            data: formData,
                            contentType : false,
                            cache: false,
                            processData : false,
                             success: function(datas) 
                            { 
                                 
                                jQuery('#alretsuccess').show();
                                window.setTimeout(function(){
                                     window.location.href = "<?php echo BASE_URL;?>"+'journalentry/bulk_insert';

                                }, 2000);

                            }
                         });

                        //insert
                    }else{
                        jQuery('#alretdanger').show();
                    }
                }
            });
        }
    });

    //<?php echo BASE_URL;?>journalentry/saveBulkData

    jQuery(document).ready(function(){
        $('.report_date').datepicker({
            autoclose: true,
            format: 'dd/mm/yyyy',
            orientation: "bottom"
        });
/*************** sta arul new code for duplicate **********************/
jQuery(document).on('click','.btn_duplicaterow',function(){

      var journal_count = jQuery(".journal_count").val();
      var journal_datalength = jQuery(".report_date").val().length;
      var journal_dateold = jQuery(".report_date").val();
       if(journal_datalength==0){   jQuery(".report_date").addClass('errorval'); return false;}
       if(jQuery(".report_date").hasClass('errorval')){ jQuery(".report_date").removeClass('errorval'); }
        //var journal_countget = parseInt(journal_count-1);
        var journal_countget = jQuery(this).data('id');
       // alert(id);
        /************** get the value from row***************/
        var journal_date = jQuery("#report_date"+journal_countget).val();
        var description = jQuery("#description"+journal_countget).val();
        var amount = jQuery("#amount"+journal_countget).val();
        var amount_type = jQuery("#amount_type"+journal_countget).val();
         var salessel='';var exponsesel='';
         if(amount_type =='expense'){ var salessel = 'selected';} else{ var exponsesel = 'selected'; }
         var $amountypeoption = '<option value="sales" '+salessel+'>DR</option><option value="expense" '+exponsesel+'>CR</option>';
          var costenter = jQuery("#cost_id"+journal_countget).val();
          var ledgertype = jQuery("#ledgertype"+journal_countget).val();
        //var journal_date = jQuery("#report_date"+journal_countget).val();
       // $( "#row_0" ).clone().insertAfter( "#row_0" );
        /*********************************************************/
        journal_count = parseInt(journal_count);
        var cost_options = "<?php echo $cost_options; ?>";
        var tr_txt = '<tr id="row_'+journal_count+'"><td><select id="amount_type'+journal_count+'" name="journal_data['+journal_count+'][amount_type]" class="form-control">'+$amountypeoption+'   </select></td><td><input type="text" name="journal_data['+journal_count+'][report_date]" id="report_date'+journal_count+'" class="form-control report_date" placeholder="Date" value="'+journal_date+'" required></td><td><input type="text" name="journal_data['+journal_count+'][description]" id="description'+journal_count+'" class="form-control" placeholder="Description" value="'+description+'" required></td><td><input type="text" name="journal_data['+journal_count+'][amt]" class="form-control" id="amount'+journal_count+'" placeholder="Amount" value="'+amount+'" required></td><td><select name="journal_data['+journal_count+'][cost_id]" class="table_frminput form-control " id="cost_id'+journal_count+'"><option value="">Select Cost Centre</option>'+cost_options+'</select></td><td> <select name="journal_data['+journal_count+'][ledgertype]" class="table_frminput form-control " id="ledgertype'+journal_count+'"> <option value="1">Invoice</option><option value="2">Bank</option></select></td><td><button type="button" class="btn btn-sm btn-info btn_addrow"><i class="fa fa-plus"></i></button><button type="button" class="btn btn-sm btn-info btn_duplicaterow" data-id="'+journal_count+'"><i class="fa fa-clone"></i></button> / <button type="button" class="btn btn-sm btn-danger btn_removerow"><i class="fa fa-remove"></i></button> </tr>';
            var beforeinc = journal_count;
            journal_count++;
            jQuery(".journal_count").val(journal_count);
            jQuery(".jounal_bulktb tbody").append(tr_txt);
            $('.report_date').datepicker({
                autoclose: true,
                format: 'dd/mm/yyyy',
                orientation: "bottom"
            });
            $("#cost_id"+beforeinc).val( costenter); 
             $("#ledgertype"+beforeinc).val( ledgertype); 
              
});
/*************** sta arul new code for duplicate end**********************/

        jQuery(document).on('click','.btn_addrow',function(){

            var journal_count = jQuery(".journal_count").val();
            /*************** sta arul **********************/
            var journal_datalength = jQuery(".report_date").val().length;
            var journal_dateold = jQuery(".report_date").val();
              if(journal_datalength==0){   jQuery(".report_date").addClass('errorval'); return false;}
              if(jQuery(".report_date").hasClass('errorval')){ jQuery(".report_date").removeClass('errorval'); }
             var journal_countget = parseInt(journal_count-1);
             var journal_date = jQuery("#report_date"+journal_countget).val();
             /*************** sta arul end **********************/ 
            journal_count = parseInt(journal_count);
            var cost_options = "<?php echo $cost_options; ?>";

            var tr_txt = '<tr><td><select name="journal_data['+journal_count+'][amount_type]" class="form-control" id="amount_type'+journal_count+'"><option value="sales">DR</option><option value="expense">CR</option></select></td><td><input type="text" name="journal_data['+journal_count+'][report_date]" id="report_date'+journal_count+'" class="form-control report_date" placeholder="Date" value="'+journal_date+'" required></td><td><input type="text" name="journal_data['+journal_count+'][description]" id="description'+journal_count+'" class="form-control" placeholder="Description" value="" required></td><td><input type="text" name="journal_data['+journal_count+'][amt]" class="form-control" id="amount'+journal_count+'" placeholder="Amount" value="" required></td><td><select name="journal_data['+journal_count+'][cost_id]" class="table_frminput form-control " id="cost_id'+journal_count+'"><option value="">Select Cost Centre</option>'+cost_options+'</select></td><td> <select name="journal_data['+journal_count+'][ledgertype]" class="table_frminput form-control " id="ledgertype'+journal_count+'"> <option value="1">Invoice</option><option value="2">Bank</option></select></td><td><button type="button" class="btn btn-sm btn-info btn_addrow"><i class="fa fa-plus"></i></button><button type="button" class="btn btn-sm btn-info btn_duplicaterow" data-id="'+journal_count+'"><i class="fa fa-clone"></i></button> / <button type="button" class="btn btn-sm btn-danger btn_removerow"><i class="fa fa-remove"></i></button> </tr>';

            journal_count++;
            jQuery(".journal_count").val(journal_count);
            jQuery(".jounal_bulktb tbody").append(tr_txt);
            $('.report_date').datepicker({
                autoclose: true,
                format: 'dd/mm/yyyy',
                orientation: "bottom"
            });

        });
        jQuery(document).on('click','.btn_removerow',function(){
            var journal_count = jQuery(".journal_count").val();
            jQuery("#journal_count").val(parseInt(journal_count -1));
            jQuery(this).closest('tr').remove();
        })


    });
</script>    
    
<style>
.errorval{ border-color: red;background-color: #ffe0e0; }
.jounal_bulktb .form-control { padding:6px 8px;  }
</style>