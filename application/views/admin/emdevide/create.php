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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Emdevide/index');?>"><?php echo $page_title; ?></a></li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="card-box">
                    <h4 class="m-t-0 header-title text-center">Add Em Devide</h4><br>
                    <form action="<?php echo base_url('Emdevide/create');?>" method="post"  class="form-horizontal" >
                        <div class="row">
                          <div class="col-md-3">
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">NAME<span class="text-danger">*</span></label>
                                  <div class="col-8">
                                      <input placeholder="NAME" type="text" name="name" required="" class="form-control" autocomplete="off">
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
                                  <label for="name" class="col-4 col-form-label">ADDRESS</label>
                                  <div class="col-8">
                                      <textarea placeholder="ADDRESS" required name="address" class="form-control"></textarea>
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">LOT NO<span class="text-danger">*</span></label>
                                  <div class="col-8">
                                      <select name="lot_no" required class="xLot_no" data-parsley-min="1" data-parsley-min-message="Select AtList One">
                                        <option value="0">None</option>
                                        <?php foreach ($lot_no as $key => $value): ?>
                                            <option value="<?php echo $value->lot_no; ?>"><?php echo LOT.$value->lot_no; ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">PROCESS<span class="text-danger">*</span></label>
                                  <div class="col-8">
                                      <select name="child_sb" required class="xSub_Process">
                                        <option value="0">NONE</option>
                                        <option value="A">GHADI</option>
                                        <option value="B">EM DEVIDE</option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">VAHICLE</span></label>
                                  <div class="col-8">
                                      <input placeholder="VAHICLE" type="text" name="vahicle" class="form-control" autocomplete="off">
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="lot_no" class="col-4 col-form-label">VAHICLE NO</label>
                                  <div class="col-8">
                                      <input placeholder="VAHICLE NO" type="text" name="vahicle_no" class="form-control" autocomplete="off">
                                  </div>
                              </div>
                              <div class="custom-emdevide">
                                <div class="form-group row">
                                    <label for="lot_no" class="col-4 col-form-label">LOT PCS</label>
                                    <div class="col-8">
                                        <input placeholder="LOT PCS" type="number" name="lot_pcs" class="form-control xSlotpcs" autocomplete="off" readonly="">
                                    </div>
                                </div>
                              </div>
                          </div>
                      </div>
                      <div class="row m-t-50">
                          <div class="col-lg-12">
                              <div style="overflow-x:auto; ">
                                <table class="table" id="myTable" style="min-width: 1080px;">
                                  <thead>
                                      <tr>
                                        <th scope="col" width="15%">DESIGN NO</th>
                                        <th scope="col" width="15%">N DESIGN</th>
                                        <th scope="col" width="15%">PATLA</th>
                                        <th scope="col" width="15%">EM NAME</th>
                                        <th scope="col">COLOR</th>
                                        <th scope="col">PCS</th>
                                        <th scope="col"></th>
                                      </tr>
                                  </thead>
                                  <tbody id="tableBody">
                                      <tr id="tr1">
                                        <td>
                                          <select class="sDesign" name="design_no[]">
                                          </select>
                                        </td>
                                        <td>
                                          <input type="text" name="n_design[]" class="form-control sNDesign" step="any" placeholder="N DESIGN" required>
                                        </td>
                                        <td>
                                          <select name="patla[]" class="sPatla">
                                          </select>
                                        </td>
                                        <td>
                                          <select name="emuser[]" class="sEm_user">
                                          <option value="0" >None</option>
                                          <?php foreach ($emuser as $key => $value): ?>
                                              <option value="<?php echo $value->emuser_id; ?>"><?php echo $value->em_name; ?></option>
                                          <?php endforeach; ?>
                                          </select>
                                        </td>
                                        <td>
                                          <input type="text" name="color[]" class="form-control sColor" step="any" placeholder="COLOR" required>
                                        </td>
                                        <td>
                                          <input type="number" name="pcs[]" class="form-control sD_Pcs" step="any" placeholder="PCS" required >
                                        </td>
                                        <td colspan="8">
                                          <button type="button" class="btn btn-icon waves-effect waves-light btn-danger btn-sm btn-remove "><i class=" fa fa-minus"></i></button>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td colspan="6">
                                        </td>
                                        <td>
                                          <button type="button" class="btn waves-effect waves-light btn-secondary btn-add btn-sm"> <i class="fa fa-plus"></i> </button>
                                        </td>
                                      </tr>
                                  </tbody>
                                </table>
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">PREVOIUS CLOTH VAL</label>
                                  <div class="col-8">
                                      <input placeholder="CLOTH VAL" type="number" step="any" name="" required class="form-control xPand_val" readonly autocomplete="off" >
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">EMDEVIDE VAL</label>
                                  <div class="col-8">
                                      <input placeholder="EMDEVIDE VAL"  type="number" step="any" 
                                      name="emdevide_val" class="form-control xProcess_value" required readonly autocomplete="off">
                                  </div>
                              </div>
                          </div>
                          <div class="offset-md-4 col-md-4">
                            <div class="form-group row">
                                <label for="name" class="col-4 col-form-label">TOTAL DESIGN</label>
                                <div class="col-8">
                                    <input placeholder="TOTAL DESIGN" type="number" step="any" name="t_design" required readonly class="form-control xT_Design" autocomplete="off" >
                                </div>
                            </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">TOTAL PCS</label>
                                  <div class="col-8">
                                      <input placeholder="TOTAL PCS" type="number" name="t_pcs" required="" class="form-control xT_Pcs" readonly autocomplete="off" >
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">CLOTH VAL</label>
                                  <div class="col-8">
                                      <input placeholder="CLOTH VAL" type="number" step="any" name="cloth_val" required class="form-control xColth_val" autocomplete="off">
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">SUB TOTAL</label>
                                  <div class="col-8">
                                      <input placeholder="SUB TOTAL" type="number" step="any" name="sub_total" required="" class="form-control xSub_Total" readonly autocomplete="off" >
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">TAX (<?php echo TAX;?>%)</label>
                                  <div class="col-8">
                                      <input placeholder="TAX"  type="number" step="any" name="tax" required="" class="form-control xTax " readonly  autocomplete="off">
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">GRAND TOTAL</label>
                                  <div class="col-8">
                                      <input placeholder="GRAND TOTAL" type="number" step="any" name="g_total" required="" class="form-control xGrand_Total" autocomplete="off" readonly="">
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
    let appendnode=$('#tr1').html();
    let tablebody=$('#tableBody').html();
    let emdevide_self=$('.custom-emdevide').html();
    $('.custom-emdevide').empty();
    var i=2;
    $('body').on('change','.xLot_no', function(){
          $('#tableBody').empty();      
          $('#tableBody').html(tablebody);
          $("select").select2();
          $(this).focus();      
    });
    $('body').on('change','.xSub_Process', function(){
          let lot_no=$('.xLot_no').val();     
          let child_sb=$(this).val(); 
          let data={lot_no:lot_no,child_sb:child_sb}  
          $('#tableBody').empty();
          $('#tableBody').html(tablebody);
          $("select").select2();
          $('#tr1').find('.sDesign').attr('id','design');         
          $(this).focus();  
          $.ajax({
              url: "<?php echo base_url('Emdevide/get_design'); ?>",
              type: "POST",
              data:data,          
              success: function(data){
                var data  = JSON.parse(data);                                          
                  if(data.status=="success"){
                  $('.xPand_val').val(data.balance.process_val);
                  $('.xColth_val').val(data.balance.process_val);
                  if(child_sb=="A"){
                    $('.custom-emdevide').empty();
                    $('.sDesign ').append("<option value'0'>None</option>");
                    $.each(data.design,function(key,value)
                      { 
                        $('.sDesign ').append('<option value=' + value.design_id + '>' + value.design + '</option>');
                    });
                  }else{
                    $('.custom-emdevide').html(emdevide_self);
                    $('.xSlotpcs').val(data.lot_pcs)
                  }
                  calculate_meter();
                }
            }
        });     
    });
    $('body').on('change','.sDesign', function(){
          let design=$(this).val();
          let tr=$(this).parents('tr').attr('id');
          let obj=$(this).parents('tr');
          let child_sb=$('.xSub_Process').val();
          let data= {design:design}
          $(".sDesign").each(function() {
              find_tr=$(this).parents('tr').attr('id');
              if(find_tr==tr){
              }else{
                $('#'+find_tr).find('.sDesign option[value='+design+']').remove();
              }
          });
          $.ajax({
              url: "<?php echo base_url('Emdevide/design_row'); ?>",
              type: "POST",
              data:data,          
              success: function(data){
                var data  = JSON.parse(data);                                          
                if(data.status=="success"){
                    obj.find('.sColor').val(data.datail.color);
                    obj.find('.sD_Pcs').val(data.datail.pcs);
                    obj.find('.sNDesign').val(data.datail.design);
                    obj.find('.sPatla').html('<option value='+data.datail.patla_id+ '>' +data.datail.p_name  + '</option>');
                    calculate_meter();
                }
              }
          }); 
    });
    $('body').on('keyup','.sD_Pcs', function(e){
          calculate_meter();
    }); 
    $('body').on('keyup','.xColth_val', function(e){
          calculate_meter();
    });
    $('body').on('click','.btn-add', function(){
          let tr=$(this).parents('tr');
          let design_no=$('#tr1').find('.sDesign').html();
          tr.before('<tr id="tr'+i+'">'+appendnode+'</tr>');
          $('select').select2();
          $('#tr'+i).find('.sDesign').focus();
          $('#tr'+i).find('.sDesign').html(design_no);
          calculate_meter();
          i++;
          return false;
    });
    $('body').on('click','.btn-remove', function(){
          var fst_tr=$(this).parents('tr').attr("id");
          if(fst_tr=="tr1"){
            return false;
          }else{
            $(this).parents('tr').remove();
          }
          calculate_meter();
          return false;
    });
    $('select').select2();
});
function calculate_meter(){
    var sub_meter = 0;
    var sub_taka = 0;
    var rowCount = $('#tableBody >tr').length;
    $('.xT_Design').val(rowCount-1);
    var D_Pcs = 0;
    $('.sD_Pcs').each(function(){
        D_Pcs += parseFloat($(this).val());        
    });
    $('.xT_Pcs').val(D_Pcs);
    var cloth_val=parseFloat($('.xColth_val').val());
    var Pand_val=parseFloat($('.xPand_val').val());
    $('.xProcess_value').val((cloth_val+Pand_val).toFixed(2));
    var T_Pcs=parseFloat($('.xT_Pcs').val());     
    var sub_total=T_Pcs*cloth_val
    $('.xSub_Total').val((sub_total).toFixed(2));     
    tax=(sub_total*5)/100;
    $('.xTax').val(tax.toFixed(2));
    g_total=Math.round(sub_total+tax);
    $('.xGrand_Total').val(g_total.toFixed(2));
}
function validateForm(argument) {
  let child_sb=$('.xSub_Process').val();
  if(child_sb=="B"){
    $('.sEm_user').each(function (index) {
       $(this).attr("data-parsley-min","1").parsley();
       $(this).attr("data-parsley-min-message","Select AtList One").parsley();
    });
    let lot_pcs=parseInt($('.xSlotpcs').val())+1;
    let t_pcs=parseInt($('.xT_Pcs').val());
    if(t_pcs <lot_pcs){
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
}
</script> 