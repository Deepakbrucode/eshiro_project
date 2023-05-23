<hr />
<a href="javascript:;" onclick="showAjaxModal('<?php echo BASE_URL;?>/modal/popup/modal_yearlevel_add/');"
    class="btn btn-success pull-right">
        <i class="entypo-plus-circled"></i>
        <?php echo get_phrase('add_new_year_level');?>
    </a>
<div class="row">
	<div class="col-md-12">
    
    	<!------CONTROL TABS START------>
		<ul class="nav nav-tabs bordered">
			<li class="active">
            	<a href="#list" data-toggle="tab"><i class="entypo-menu"></i> 
					<?php echo get_phrase('year_level');?>
                 </a>
             </li>
             <li class="">
            	<a href="#deleted_list" data-toggle="tab"><i class="entypo-trash"></i> 
					<?php echo get_phrase('deleted_year_level');?>
                 </a>
             </li>

		</ul>
    	<!------CONTROL TABS END------>
        
		<div class="tab-content">
        <br>
            <!----TABLE LISTING STARTS-->
            <div class="tab-pane box active" id="list">
				
                <table class="table table-bordered datatable" id="table_export">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div><?php echo get_phrase('year_level');?></div></th>
                    		<th><div><?php echo get_phrase('numeric_name');?></div></th>
                    		
                    		<th><div><?php echo get_phrase('centre_name');?></div></th>
                    		<th><div><?php echo get_phrase('status');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                   
                    	<?php $count = 1;foreach($yearr as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
							<td><?php echo $row['name'];?></td>
							<td><?php echo $row['name_numeric'];?></td>
							
                            <td>
                                <?php 
                                    if($row['centre_id'] != '' || $row['centre_id'] != 0) 
                                        echo $this->crud_model->get_type_name_id('centre',$row['centre_id'],'centre_name');
                                ?>
                            </td>
                            <td><?php  $status = $row['status'];
								    echo $dispstatus = ($status == 1) ? '<span class="label label-sm label-success">'.'Active'.'</span>' : (($status == 2) ? '<span class="label label-sm label-danger">'.'In-Active'.'</span>' : '<span class="label label-sm label-warning"> '.'In-Active'.' </span>' );?></td>
							<td>     
								<a href="<?php echo BASE_URL;?>/admin/year_subjectgroup/<?php echo $row['year_id'];?>" class="btn btn-info">
										<i class="entypo-eye"></i>View
								</a>
								
								<a href="#" onclick="showAjaxModal('<?php echo BASE_URL;?>/modal/popup/modal_yearlevel_edit/<?php echo $row['year_id'];?>');" class="btn btn-orange">
                                                <i class="entypo-pencil"></i>Edit
                                 </a>
                                                
<!--
								<a href="#" onclick="confirm_modal('<?php echo BASE_URL;?>/admin/year/delete/<?php echo $row['year_id'];?>');" class="btn btn-danger">
                                            <i class="entypo-trash"></i>
                                              
                                 </a>
-->
                                 
                                 
                                 
        					</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
			<!-- deleted list -->
			<div class="tab-pane box " id="deleted_list">
				
                <table class="table table-bordered datatable" id="table_export">
                	<thead>
                		<tr>
                    		<th><div>#</div></th>
                    		<th><div><?php echo get_phrase('year_level');?></div></th>
                    		<th><div><?php echo get_phrase('numeric_name');?></div></th>
                    		
                    		<th><div><?php echo get_phrase('centre_name');?></div></th>
                    		<th><div><?php echo get_phrase('status');?></div></th>
                    		<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
                    <tbody>
                   
                    	<?php $count = 1;foreach($deleted_yearr as $row):?>
                        <tr>
                            <td><?php echo $count++;?></td>
							<td><?php echo $row['name'];?></td>
							<td><?php echo $row['name_numeric'];?></td>
							
                            <td>
                                <?php 
                                    if($row['centre_id'] != '' || $row['centre_id'] != 0) 
                                        echo $this->crud_model->get_type_name_id('centre',$row['centre_id'],'centre_name');
                                ?>
                            </td>
                            <td><?php  $status = $row['status'];
								    echo $dispstatus = ($status == 1) ? '<span class="label label-sm label-success">'.'Active'.'</span>' : (($status == 2) ? '<span class="label label-sm label-danger">'.'Deleted'.'</span>' : '<span class="label label-sm label-warning"> '.'In-Active'.' </span>' );?></td>
							<td>  
								
								<a href="#" onclick="active_confirm_modal('<?php echo BASE_URL;?>/admin/year/active/<?php echo $row['year_id'];?>');" class="btn btn-success"><i class="entypo-thumbs-up"></i><?php echo get_phrase('active');?></a>
					
                                 
                                 
                                 
        					</td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
			</div>
			<!-- /deleted list -->
            <!----TABLE LISTING ENDS--->
            
            
		</div>
	</div>
</div>



<!-----  DATA TABLE EXPORT CONFIGURATIONS ---->                      
<script type="text/javascript">

	jQuery(document).ready(function($)
	{
		

		var datatable = $("#table_export").dataTable();
		
		//~ $(".dataTables_wrapper select").select2({
			//~ minimumResultsForSearch: -1
		//~ });
		
		
		
	});
		
</script>
<script>

</script>
