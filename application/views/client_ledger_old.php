
        
           
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-users"></i>
                                <a href="#">Report</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <span>Client ledger</span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->
                    <div class="row">
                    <?php echo $this->session->flashdata('client_ledger'); ?>
                        <div class="col-md-12">
                            <table class="table table-striped table-hover table-bordered" id="client_ledger" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th> S.No </th>
                                                <th> Client Name </th>
                                                <th> File.No </th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php 
                                        if($ClientlDetails){
                                            $k=0;
                                            foreach ($ClientlDetails as $value) {
                                                $k++;
                                               $client_name = $value->firm_name;
                                               $client_id = $value->client_id;
                                               $file_number = $value->file_number;
                                               $file_id = $value->file_id;
                                        ?>
                                            <tr data-id="<?php echo $client_id; ?>" data-cname="<?php echo $client_name; ?>" data-fname="<?php echo $file_number; ?>">
                                                <td><?php echo $k; ?></td>
                                               <td><?php echo $client_name; ?></td>
                                                <td><?php echo $file_number; ?></td>
                                                <td>
                                        <a class="accordion-toggle collapsed" data-toggle="collapse" href="#collapseOne_<?php echo $k; ?>">View</a>
                                    </td>

                                            </tr>
                                        <?php 
                                        }
                                    }
                                            ?>                                           
                                        </tbody>
                                    </table>

                        </div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->

            <script type="text/javascript">
            var oTable;
jQuery(document).ready(function() {










    jQuery(document).on('click',".accordion-toggle.collapsed",function(){

            var tr = jQuery(this).closest('tr');
            var tr_id = jQuery(this).closest('tr').attr('data-id');
            var tr_cname = jQuery(this).closest('tr').attr('data-cname');
            var tr_fname = jQuery(this).closest('tr').attr('data-fname');
            console.log(tr_cname);
        var row = oTable.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(tr_id,tr_cname,tr_fname) ).show();
            tr.addClass('shown');
        }

}); 



function format ( client_id,client_name, file_number ) {

var response_value = '';






response_value = '<div class="col-md-12 ledger_details" style="padding: 30px 20px;"></div>';
   
  console.log(response_value);
   
   //response_value += '<tr><td>31/03/2015</td><td>CREDIT INTEREST</td><td></td><td></td><td>865.32</td><td>865.32</td></tr>';
  

show_ledgerdetails(client_id,client_name, file_number);

return response_value;


}

function show_ledgerdetails(client_id,client_name, file_number){

 src = '<?php echo BASE_URL; ?>'+'reports/get_ClientLedger';

             $.ajax({
                url: src,
                dataType: "json",
                data: {
                    client_id : client_id
                },
                success: function(data) {
                   // response(data);
                    //console.log(data);
                    var total_amount = 0;
                     response_value = '<p><span style="font-weight: bold;">Client Name: </span><span>'+client_name+'</span></p><p><span style="font-weight: bold;">FILE NO: </span><span>'+file_number+'</span></p><table style="width:100%">';
                    if(data.length > 0){
                         response_value += '<tr><td style="font-weight: bold;">DATE</td><td style="font-weight: bold;">DESCRPTION</td><td style="font-weight: bold;">FILE NO</td><td style="font-weight: bold;text-align:right;">DR</td><td style="font-weight: bold;text-align:right;">CR</td><td style="font-weight: bold;text-align:right;">BALANCE</td></tr>';
                        jQuery.each(data,function(key,value){
                            response_value += '<tr><td>'+value['date']+'</td><td>'+value['transaction_type']+'</td>';
                            response_value +='<td>'+value['file_number']+'</td>';
                            var amount = parseFloat(value['amount']);

                            var format_amount = amount.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

                            if(value['ledger_type'] == 'payment')
                            {
                            response_value +='<td style="text-align:right;">R'+format_amount+'</td><td></td>';
                            total_amount +=amount;
                        }
                        if(value['ledger_type'] == 'receipt')
                        {
                            response_value +='<td></td><td style="text-align:right;">R'+format_amount+'</td>';
                            total_amount +=amount;
                        }
                        var format_total = total_amount.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                            response_value +='<td style="text-align:right;">R'+format_total+'</td></tr>';
                           // console.log("total_amount = "+total_amount);

                        })
                    }
                    var format_total = total_amount.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                     response_value += '<tr><td colspan="6" style="text-align:right;font-weight:bold;">R'+format_total+'</td></tr></table>';
                     jQuery(".ledger_details").html(response_value);
                }
            });
}


oTable = jQuery('#client_ledger').DataTable({ 

        "language": {
            "lengthMenu": "Show _MENU_ Clients",
            "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "No entries found",
                "infoFiltered": "(filtered1 from _MAX_ total entries)",
                "search": "Search:",
                "zeroRecords": "No matching records found"}, 
        "bDestroy": true,
        buttons: [
                { extend: 'print', className: 'btn dark btn-outline' },
                { extend: 'pdf', className: 'btn green btn-outline' },
                { extend: 'csv', className: 'btn purple btn-outline ' }
            ],
             responsive: {
                details: {
                   
                }
            },
    });

        



});


function PrintDiv() {
                        var contents = document.getElementById("div_print").innerHTML;
                        var frame1 = document.createElement('iframe');
                        frame1.name = "frame1";
                        frame1.style.position = "absolute";
                        frame1.style.top = "-1000000px";
                        document.body.appendChild(frame1);
                        var frameDoc = frame1.contentWindow ? frame1.contentWindow : frame1.contentDocument.document ? frame1.contentDocument.document : frame1.contentDocument;
                        frameDoc.document.open();
                        frameDoc.document.write('<html><head><title>' + document.title + '</title>');
                        frameDoc.document.write('</head><body>');
                        frameDoc.document.write(contents);
                        frameDoc.document.write('</body></html>');
                        frameDoc.document.close();
                        setTimeout(function () {
                            window.frames["frame1"].focus();
                            window.frames["frame1"].print();
                            document.body.removeChild(frame1);
                        }, 500);
                        return false;
                 }
            </script>



            
    