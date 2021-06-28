<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left"><?php echo $page_title; ?></h4>
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Dashbord');?>"><?php echo COMPANY; ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Menage/index');?>"><?php echo $page_title; ?></a></li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
           <div class="col-md-12">
               <div class="card-box">
                  <div class="col-md-12">
                      <form method="post" action="<?php echo base_url('Manage/update'); ?>">
                          <div class="row">
                            <div class="col-md-12 m-b-20">
                              <h4 class="m-t-0 header-title text-center">Lot Status</h4>
                            </div>
                            <div class="col-md-6">
                                <?php if($cut->use_for=="1"): ?>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label">Devide Status</label>
                                    <div class="col-sm-8">
                                      <select name="devide_status">
                                        <option value="1" <?php echo (($cut->devide_status=="1")?"selected":"");?>>Show</option>
                                        <option value="0" <?php echo (($cut->devide_status=="0")?"selected":"");?>>Hide</option>
                                      </select>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label">Process Status</label>
                                    <input type="hidden" name="cut_id" value="<?php echo $cut->id_cut; ?>">
                                    <div class="col-sm-8">
                                      <select name="process_status">
                                        <option value="1" <?php echo (($cut->process_status=="1")?"selected":"");?>>Show</option>
                                        <option value="0" <?php echo (($cut->process_status=="0")?"selected":"");?>>Hide</option>
                                      </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-4 col-form-label">Printing Status</label>
                                    <div class="col-sm-8">
                                      <select name="print_status">
                                        <option value="1" <?php echo (($cut->print_status=="1")?"selected":"");?>>Show</option>
                                        <option value="0" <?php echo (($cut->print_status=="0")?"selected":"");?>>Hide</option>
                                      </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 m-t-20 text-center ">
                                <button type="submit" class="btn btn-custom btn-bordered waves-effect w-md waves-light">Update</button>
                            </div>
                          </div>
                      </form>
                  </div>
               </div>
           </div>
       </div>
    </div> 
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('form').parsley();
    $("select").select2();
});
</script>
               