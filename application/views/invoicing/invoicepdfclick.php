<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-users"></i>
                    <a href="#">Bank Transactions</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Analysis Data</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE HEADER-->
        <div class="row">

<button type="button" class="btn btn-success btn_invoicee">Invoice</button>

<div class="table_content"></div>
</div>
</div>
</div>

<script type="text/javascript">
	jQuery(document).on('click','.btn_invoicee',function(){

	
	jQuery(".table_content").html('');
	
	 var src = '<?php echo BASE_URL; ?>'+'reports/invoice_pdf';
     $.ajax({
                    url: src,
                    type:'GET',
                    //dataType: "json",
                    dataType: "json",
                    data: {},
                    success: function(data) {
						
						if(data.status =='1')
						{
							jQuery(".table_content").html(data.table_content);
							//alert("ddddddddd");
	
						}
                    }
                });

	
});
</script>