<style>
.btn-group{width: 140px;position: relative;display: inline-flex;}
.popover.confirmation.fade.top.in{margin-left: -5%;}
</style>      
<!-- BEGIN CONTENT -->
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
          <span>Import Datas</span>
        </li>
      </ul>
    </div>
    <!-- END PAGE HEADER-->
    <div class="row">
      <div class="col-md-12">
        <div class="portlet light portlet-fit  calendar">
          <div class="portlet-body">
            <div class="row">
              <div class="portlet light bordered col-md-12">
                <div class="portlet-title">
                  <div class="caption">
                    <i class="icon-equalizer font-red-sunglo"></i>
                    <span class="caption-subject font-red-sunglo bold uppercase">Imported Details</span>
                    <!-- <span class="caption-helper">details</span> -->
                  </div>
                </div>
                <div class="portlet-body ">
                  <?php echo $this->session->flashdata('import_cashbook'); ?>
                  <form action="<?php echo BASE_URL;?>banktransactions/import_datafilesave" class="import_datafilesave"  method="post">
                    <input type="hidden" name="bank_id" value="<?php echo $bank_id; ?>">
                    <input type="hidden" name="client_id" value="<?php echo $client_id; ?>">
                    <div class="col-md-12">
                      <div class="form-actions">
                        <div class="row">
                          <div class="col-md-offset-5 col-md-7">
                            <button type="submit" name="import_submit" class="btn green"> Save</button>
                            <!-- <button type="button" class="btn default"><a href="<?php echo BASE_URL; ?>file/add_file">Cancel</button> -->
                          </div>
                        </div>
                      </div> <br>
                      <table class="table stl_table" style="table-layout:fixed;">
                        <?php 
                          $import_header = '';
                          $import_content  ='';
                          $import_column ='
                                <td>
                                     <select id="supplier" name="db_column[]" class="form-control" style="width:auto;">
                                                <option value=""></option>
                                                <option value="date">Date</option>
                                                <option value="desc">Description</option>
                                                <option value="expense">Payments</option>
                                                <option value="sales">Receipts</option>
                                                <option value="links">Links</option>
                                                <!--<option value="tax_type">Tax Type</option>-->
                                      </select>
                                    </td>';  
                        ?> 
                        
                        <?php 
                        //echo "<pre>";print_r($data_list);echo "</pre>";
                          $j = 0;
                          foreach($data_list as  $csvinfo){
                            $import_content .= '<tr>';  
                            foreach($csvinfo as $key => $val){
                              if($j == 0){
                                $import_header ='<tr>';
                                $aCount = count($csvinfo);
                                for($i=1;$i<=$aCount;$i++){
                                  $import_header .=$import_column;
                                }
                                $import_header .='</tr>';                    
                                $import_content .='<td>'.$val.'<input type="hidden" name="csv_column['.$j.'][]" value="'.$val.'"/></td>'; 
                              }else{
                                $import_content .='<td><input type="hidden" name="csv_column['.$j.'][]" value="'.$val.'"/>'.$val.'</td>'; 
                              }
                            }                    
                            $import_content .= '</tr>';
                            $j++;
                          }                     
                        ?>               
                        <?php 
                          $disp_data = '<thead>'.$import_header.'</thead>'.'<tbody>'.$import_content.' </tbody>';
                          echo $disp_data;
                        ?>
                      </table>
                    </div>
                  </form>
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




            
    