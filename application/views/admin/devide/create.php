<style type="text/css">
  .form-group.error input, .form-group.error select, .form-group.error textarea {
    border: 2px solid #ef5350;
}
</style>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left"><?php echo $page_title; ?></h4>
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Dashbord');?>"><?php echo COMPANY; ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Devide/index');?>"><?php echo $page_title; ?></a></li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="card-box">
                    <h4 class="m-t-0 header-title text-center">Add Devide</h4><br>
                    <form action="<?php echo base_url('Devide/create');?>" method="post"  class="form-horizontal" >
                        <div class="row">                          
                          <div class="col-md-3">
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">LOT NO<span class="text-danger">*</span></label>
                                  <div class="col-8">
                                      <select name="lot_no" required class="xLot_No" data-parsley-min="1" data-parsley-min-message="Select AtList One">
                                        <option value="0">None</option>
                                        <?php foreach ($lot_no as $key => $value): ?>
                                            <option value="<?php echo $value->lot_no; ?>"><?php echo LOT.$value->lot_no; ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">DATE<span class="text-danger">*</span></label>
                                  <div class="col-8">
                                      <input placeholder="dd/mm/yy" type="text" name="date" required="" class="form-control datepicker-autoclose" autocomplete="off" value="<?php echo date('d/m/Y'); ?>">
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">VAHICLE</label>
                                  <div class="col-8">
                                      <input placeholder="VAHICLE" type="text" name="vahicle"  class="form-control" autocomplete="off">
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="lot_no" class="col-4 col-form-label">VAHICLE NO</label>
                                  <div class="col-8">
                                      <input placeholder="VAHICLE NO" type="text" name="vahicle_no"  class="form-control" autocomplete="off">
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">ADDRESS<span class="text-danger">*</span></label>
                                  <div class="col-8">
                                      <textarea placeholder="ADDRESS" name="address" class="form-control" required></textarea>
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">TOTAL PCS<span class="text-danger">*</span></label>
                                  <div class="col-8">
                                      <input placeholder="TOTAL PCS" type="text" name="total_pcs" required="" class="form-control xtotalPcs" autocomplete="off" readonly>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="row m-t-50">
                          <div class="col-md-12">
                              <div class="row">
                                  <div class="offset-md-2 col-md-8" style="overflow-x: auto;">
                                      <table class="table" id="myTable" style="min-width: 600px;">
                                        <thead>
                                            <tr>
                                              <th scope="col" width="50%">CHALLAN</th>
                                              <th scope="col">PCS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                              <td>
                                                <select name="patla">
                                                  <?php foreach ($patla as $key => $value): ?>
                                                      <option value="<?php echo $value->patla_id; ?>"><?php echo $value->patla_name; ?></option>
                                                  <?php endforeach; ?>
                                                </select>
                                              </td>
                                              <td>
                                                <input type="number" name="pcs" class="form-control xPcs " step="any" placeholder="PCS" required>
                                              </td>
                                            </tr>
                                        </tbody>
                                      </table>
                                  </div>
                              </div>
                          </div>
                          <div class="offset-md-8 col-md-4 m-t-50">
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">TOTAL PCS</label>
                                  <div class="col-8">
                                      <input placeholder="TOTAL PCS" type="number" name="t_pcs" required="" class="form-control xCTotal_pcs " readonly autocomplete="off" >
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="form-group text-center m-t-20 m-b-20">
                        <button class="btn btn-primary waves-effect waves-light" onclick="return validateForm()" type="submit">
                          Add
                        </button>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('form').parsley();
    $('select').select2();
    $('body').on('keyup','.xPcs', function(e){
          $('.xCTotal_pcs').val($(this).val()); 
    });
    $('body').on('change','.xLot_No', function(e){
        var lot_no=$(this).val();
        $.ajax({                                            
              url:"<?php echo base_url('Devide/totalpcs/')?>"+lot_no+"",
              type: "POST",
              success: function(result){
                  var result  = JSON.parse(result);                                
              if(result.status=="success"){
                    $('.xtotalPcs').val((result.flag.total_pcs));
                  }
                } 
            });
        });
    });
  function validateForm(){
      var t_pcs = $('.xCTotal_pcs').val(); 
      var Lot_pcs=parseInt($('.xtotalPcs').val())+1 ;
          if(t_pcs==0){
            $.toast({
                      heading: 'Oh snap!',
                      text: 'Pcs is zero',
                      position: 'top-right',
                      loaderBg: '#bf441d',
                      icon: 'error',
                      hideAfter: 3000,
                      stack: 1
              });
              return false;
          }
          if(t_pcs <Lot_pcs){
            return true;
          }else{
              $.toast({
                      heading: 'Oh snap!',
                      text: 'Enter Valid Pcs',
                      position: 'top-right',
                      loaderBg: '#bf441d',
                      icon: 'error',
                      hideAfter: 3000,
                      stack: 1
              });
              return false;
          }
  }
</script> 