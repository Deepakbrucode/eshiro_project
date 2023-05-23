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

   .fees_pdf table {
    border-collapse: collapse;
        table-layout: fixed;
    border:0px;
     border: 1px solid #b4b4b4;
     width:200px;
}

.fees_pdf table, .fees_pdf td, .fees_pdf th {
    font-size: 12px;
   
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
.fees_pdf td,.fees_pdf th{border:1px solid #ccc;padding:5px;}

      .fees_pdf th,.fees_pdf td {

    word-wrap: break-word;
}

@page { margin: 90px 50px 0px; }
    #header { position: fixed; left: 0px; top: -30px; right: 0px; height: 100px;text-align: center; }
  

</style>

<div id="header">
	<center><p style="margin:4px 0px;"><span style="font-weight: bold;text-align: center;font-size:12px;">Control Account</span></p></center>
</div>
<div class="col-md-12 fees_pdf">
	<?php echo $table_div; ?> 
</div>
