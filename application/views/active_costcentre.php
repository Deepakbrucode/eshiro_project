        
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-users"></i>
                    <a href="#">Cost Centre</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Activate Cost Centre</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE HEADER-->
        <div class="row">
<div class="col-md-12">  
<?php
$set_id = '';
                if($activeuserdetails){
                    foreach($activeuserdetails as $activeuserdetail){
                        $set_id = $activeuserdetail->set_id;
                        $set_ids = explode(',', $set_id);
                    }
                }
                ?>              
                                         <div class="col-md-3"></div>
                                          <!-- password form -->
                                          <form class="login-form" name="profile" action="<?php echo BASE_URL;?>costcentre/importcostset" method="post">
                                            <div class="col-md-3">
                                                <h3 class="form-title font-green">Activate Cost Centre Set</h3>
                                                <?php echo $this->session->flashdata('client'); ?>
                                                <?php
                                                if(!empty($Sets)){
                                                    foreach($Sets as $Set){
                                                        $sid = $Set->set_id;
                                                        $disable = '';
                                                        if (in_array($sid, $set_ids))
                                                        {
                                                            $disable = 'disabled';
                                                        }
                                                    ?>
                                                    <div class="form-group" >
                                                        <label class="control-label"> <input type="radio" name="set_id" value="<?php echo $Set->set_id; ?>" <?php echo $disable; ?> /> <?php echo $Set->set_name; ?></label>
                                                         (<a href="javascript:void(0);" class="btn_viewsetdetails" data-setid="<?php echo $Set->set_id; ?>">View</a>)
                                                    </div>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                                <div class="form-actions">
                                                    <button type="submit" class="btn green" id="passsubmit" name="submit" value="Save Changes">Activate</button>
                                                </div>
                                            </div>
                                            </form>
                                            <!-- /password form -->
                                        </div>



</div>
</div>
</div>



<div id="setmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Cost Centre Details</h4>
      </div>
      <div class="modal-body">
        <table class="table table-border tbset">
            <thead>
                <tr>
                    <td>Account</td>
                    <td>Cost Name</td>
                    <td> Links </td>
                    <td> Category</td>
                    <td> SubCategory </td>

                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
    jQuery(document).on('click','.btn_viewsetdetails',function(){
        jQuery("#setmodal").modal('show');
        var set_id = jQuery(this).attr('data-setid');
        // alert(set_id);
        var src = '<?php echo BASE_URL; ?>'+'costcentre/get_costsets';
        jQuery(".tbset tbody").html('');
        $.ajax({
            url: src,
            type:'POST',
            dataType: "json",
            data: {'set_id':set_id},
            success: function(data) {
                // console.log(data);
                jQuery(".tbset tbody").html();
                var stl_txt = data.stl_txt;
                console.log(stl_txt);
                // var stl_txt = '';
                // jQuery.each(stl_txt,function(key,value){
                //     stl_txt += "<tr><td>"+value['account_no']+"</td><td>"+value['cost_name']+"</td><td>"+value['links']+"</td><td>"+value['category_id']+"</td><td>"+value['category_id']+"</td></tr>";
                // });
                jQuery(".tbset tbody").html(stl_txt);
            }
        });
    })
});
</script>