            <style>

            .btn-group{
                width: 140px;
                position: relative;
                display: inline-flex;
            }
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
                                <a href="#">Setting</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <span>Import Client</span>
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
                                                    <span class="caption-subject font-red-sunglo bold uppercase">Imported client details</span>
                                                    <!-- <span class="caption-helper">details</span> -->
                                                </div>
                                            </div>
                                            <div class="portlet-body ">
                    <?php echo $this->session->flashdata('import_file'); ?>
                      <form action="<?php echo BASE_URL;?>file/import_filesave"  method="post">
                        <div class="col-md-12">
                        <table class="table stl_table" >
                
                  <?php 
                 $import_header = '';
                 $import_content  ='';
                 $import_column ='
                    <td>
                         <select id="supplier" name="db_column[]" class="form-control" style="width:150px;">
                                    <option value=""></option>
                                    <option value="month_year">Month-Year</option>
                                    <option value="ref">REF</option>
                                    <option value="file_name">Client Name</option>
                                    <option value="file_no">File No</option>
                                    <option value="cr_amount">Cr</option>
                                     <option value="dr_amount">Dr</option>
                                    </select>
                        </td>';  ?> 

                  <?php 
                  $j = 0;
                  foreach($client_lists as  $csvinfo){
                    $import_content .= '<tr>';  
                    foreach($csvinfo as $key => $val){
                      if($j == 0){
                          //Header Format
                         $import_header ='<tr>';
                          $aCount = count($csvinfo);
                          for($i=1;$i<=$aCount;$i++){
                             $import_header .=$import_column;
                          }
                          $import_header .='</tr>';                    
                        $import_content .='<td>'.$val.'
                        <input type="hidden" name="csv_column['.$j.'][]" value="'.$val.'"/>
                        </td>'; 
                      }else{

                        $import_content .='<td><input type="hidden" name="csv_column['.$j.'][]" value="'.$val.'"/>'.$val.'</td>'; 
                      }
                    }                    
                    $import_content .= '</tr>';
                     $j++;
                   }                     
                    ?>               
                  <?php $disp_data = '<thead>'.$import_header.'</thead>'.'<tbody>'.$import_content.' </tbody>';
                        echo $disp_data;
                  ?>
               
                </table>

                        </div>
                         <div class="form-actions">
                                                        <div class="row">
                                                            <div class="col-md-offset-5 col-md-7">
                                                                <button type="submit" name="import_submit" class="btn green"> Save</button>
                                                                <!-- <button type="button" class="btn default"><a href="<?php echo BASE_URL; ?>file/add_file">Cancel</button> -->
                                                            </div>
                                                        </div>
                                                    </div>
                       <!--  <input type="submit" name="import_submit" value="Save"> -->
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




            
    
