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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Embroidery/index');?>"><?php echo $page_title; ?></a></li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="card-box">
                    <h4 class="m-t-0 header-title text-center">Update Embroidery</h4><br>
                    <form action="<?php echo base_url('Embroidery/update');?>" method="post"  class="form-horizontal" >
                        <div class="row">
                          <div class="col-md-3">
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">NAME<span class="text-danger">*</span></label>
                                  <div class="col-8">
                                      <input placeholder="NAME" type="text" name="name" required="" class="form-control" autocomplete="off" value="<?php echo $embroidery->name; ?>">
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">DATE<span class="text-danger">*</span></label>
                                  <div class="col-8">
                                      <input placeholder="dd/mm/yy" type="text" name="date" required="" class="form-control datepicker-autoclose" autocomplete="off"  value="<?php echo date('d/m/Y', strtotime($embroidery->date)); ?>">
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">ADDRESS</label>
                                  <div class="col-8">
                                      <textarea placeholder="ADDRESS" required name="address" class="form-control"><?php echo $embroidery->address; ?></textarea>
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">LOT NO<span class="text-danger">*</span></label>
                                  <div class="col-8">
                                      <select name="lot_no" required class="xLot_no" data-parsley-min="1" data-parsley-min-message="Select AtList One">
                                          <option value="<?php echo $embroidery->lot_no; ?>"><?php echo $embroidery->lot_no; ?></option>
                                      </select>
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">PROCESS<span class="text-danger">*</span></label>
                                  <div class="col-8">
                                      <select name="child_sb" required class="xSub_Process">
                                        <option value="<?php echo $embroidery->child_sb; ?>"> <?php echo (($embroidery->child_sb=="A")?"GHADI":"EM DEVIDE"); ?></option>
                                      </select>
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">VAHICLE</span></label>
                                  <div class="col-8">
                                      <input placeholder="VAHICLE" type="text" name="vahicle" class="form-control" autocomplete="off" value="<?php echo $embroidery->vahicle; ?>">
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="lot_no" class="col-4 col-form-label">VAHICLE NO</label>
                                  <div class="col-8">
                                      <input placeholder="VAHICLE NO" type="text" name="vahicle_no" class="form-control" autocomplete="off" value="<?php echo $embroidery->vahicle_no; ?>">
                                      <input type="hidden" name="embroidery_id" value="<?php echo $embroidery->embroidery_id; ?>">
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="row m-t-50">
                          <div class="col-lg-12">
                              <div style="overflow-x:auto; ">
                                <table class="table" id="myTable" style="min-width: 1300px;">
                                  <thead>
                                      <tr>
                                        <th scope="col" width="11%">DESIGN NO</th>
                                        <th scope="col" width="11%">PATLA</th>
                                        <th scope="col" width="11%">EM NAME</th>
                                        <th scope="col">COLOR</th>
                                        <th scope="col">PCS</th>
                                        <th scope="col">MACHINE DMG</th>
                                        <th scope="col">M PCS</th>
                                        <th scope="col">G SAREE</th>
                                        <th scope="col">FPCS</th>
                                        <th scope="col">RATE</th>
                                        <th scope="col">AMOUNT</th>
                                        <th scope="col"></th>
                                      </tr>
                                  </thead>
                                  <tbody id="tableBody">
                                      <?php foreach ($embroidery_lot as $key => $value): ?>
                                      <tr>
                                        <td>
                                          <select class="sDesign" name="design_no[]">
                                            <option value="<?php echo $value->el_id; ?>"><?php echo $value->design_no; ?></option>
                                          </select>
                                        </td>
                                        <td>
                                          <select name="patla[]" class="sPatla">
                                            <option value="0">None</option>
                                            <?php if(isset($value->patla_id) && !empty($value->patla_id)):?>
                                            <option value="<?php echo $value->patla_id; ?>" selected><?php echo $value->patla_name; ?></option>
                                            <?php endif; ?>
                                          </select>
                                        </td>
                                        <td>
                                          <select name="emuser[]" class="sEm_user">
                                            <option value="0">None</option>
                                            <?php if(isset($value->emuser_id) && !empty($value->emuser_id)):?>
                                            <option value="<?php echo $value->emuser_id; ?>" selected><?php echo $value->em_name; ?></option>
                                            <?php endif; ?>
                                          </select>
                                        </td>
                                        <td>
                                          <input type="text" name="color[]" class="form-control sColor" step="any" placeholder="COLOR" required readonly value="<?php echo $value->color; ?>">
                                          <input type="hidden" name="el_id[]" value="<?php echo $value->el_id; ?>">
                                        </td>
                                        <td>
                                          <input type="number" name="pcs[]" class="form-control sD_Pcs" step="any" placeholder="PCS" required value="<?php echo $value->pcs; ?>" >
                                        </td>
                                        <td>
                                          <input type="number" name="machine_dmg[]" class="form-control sM_dmg" step="any" placeholder="MACHINE DMG" required value="<?php echo $value->machine_dmg; ?>">
                                        </td>
                                        <td>
                                          <input type="number" name="dmg_pcs[]" class="form-control sM_Print" step="any" placeholder="DMG PCS" required value="<?php echo $value->m_pcs; ?>" >
                                        </td>
                                        <td>
                                          <input type="number" name="ghat_saree[]" class="form-control sG_Sadi" step="any" placeholder="G SAREE" required value="<?php echo $value->ghat_saree; ?>">
                                        </td>
                                        <td>
                                          <input type="number" name="fpcs[]" class="form-control sF_Pcs" step="any" placeholder="FPCS" required value="<?php echo $value->f_pcs; ?>" >
                                        </td>
                                        <td>
                                          <input type="number" name="rate[]" class="form-control sRate" step="any" placeholder="RATE" required value="<?php echo $value->rate; ?>" >
                                        </td>
                                        <td>
                                          <input type="number" name="amount[]" class="form-control sS_Total" step="any" placeholder="AMOUNT" required readonly value="<?php echo $value->total; ?>">
                                        </td>
                                        <td colspan="8">
                                        </td>
                                      </tr>
                                      <?php endforeach; ?>
                                      <tr id="tr1">
                                        <td>
                                          <select class="sDesign"data-parsley-min="1" data-parsley-min-message="Select AtList One" name="design_no[]">
                                            <option value="0">None</option>
                                            <?php foreach ($design as $key => $value):?>
                                            <option value="<?php echo $value->design_id; ?>"><?php echo $value->design; ?> </option>
                                            <?php endforeach; ?>
                                          </select>
                                        </td>
                                        <td>
                                          <select name="patla[]" class="sPatla">
                                          </select>
                                        </td>
                                        <td>
                                          <select name="emuser[]" class="sEm_user">
                                          </select>
                                        </td>
                                        <td>
                                          <input type="text" name="color[]" class="form-control sColor" step="any" placeholder="COLOR" required readonly>
                                        </td>
                                        <td>
                                          <input type="number" name="pcs[]" class="form-control sD_Pcs" step="any" placeholder="PCS" required >
                                        </td>
                                        <td>
                                          <input type="number" name="machine_dmg[]" class="form-control sM_dmg" step="any" placeholder="MACHINE DMG" required >
                                        </td>
                                        <td>
                                          <input type="number" name="dmg_pcs[]" class="form-control sM_Print" step="any" placeholder="DMG PCS" required >
                                        </td>
                                        <td>
                                          <input type="number" name="ghat_saree[]" class="form-control sG_Sadi" step="any" placeholder="G SAREE" required >
                                        </td>
                                        <td>
                                          <input type="number" name="fpcs[]" class="form-control sF_Pcs" step="any" placeholder="FPCS" required >
                                        </td>
                                        <td>
                                          <input type="number" name="rate[]" class="form-control sRate" step="any" placeholder="RATE" required >
                                        </td>
                                        <td>
                                          <input type="number" name="amount[]" class="form-control sS_Total" step="any" placeholder="AMOUNT" required readonly>
                                        </td>
                                        <td colspan="8">
                                          <button type="button" class="btn btn-icon waves-effect waves-light btn-danger btn-sm btn-remove "><i class=" fa fa-minus"></i></button>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td colspan="11">
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
                                      <input placeholder="CLOTH VAL" type="number" step="any" name="" required class="form-control xPand_val" readonly autocomplete="off" value="<?php echo $balance->process_val; ?>" >
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">EMBROIDERY VAL</label>
                                  <div class="col-8">
                                      <input placeholder="EMBROIDERY VAL"  type="number" step="any" 
                                      name="embroidery_val" class="form-control xProcess_value" required readonly autocomplete="off" value="<?php echo $embroidery->embroidery_value; ?>">
                                  </div>
                              </div>
                          </div>
                          <div class="offset-md-4 col-md-4">
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">TOTAL DESIGN</label>
                                  <div class="col-8">
                                      <input placeholder="TOTAL DESIGN" type="number" step="any" name="t_design" required readonly class="form-control xT_Design" autocomplete="off" value="<?php echo $embroidery->t_design; ?>" >
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">TOTAL PCS</label>
                                  <div class="col-8">
                                      <input placeholder="TOTAL PCS" type="number" name="t_pcs" required="" class="form-control xT_Pcs" readonly autocomplete="off"  value="<?php echo $embroidery->t_pcs; ?>" >
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">MACHINE DMG</label>
                                  <div class="col-8">
                                      <input placeholder="MACHINE DMG" type="number" name="t_machinedmg" required="" class="form-control xMachine_dmg" readonly autocomplete="off" value="<?php echo $embroidery->t_machinedmg; ?>" >
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">MISS PCS</label>
                                  <div class="col-8">
                                      <input placeholder="MISS PCS" type="number" name="t_missprint" required class="form-control xMissPrint" readonly autocomplete="off" value="<?php echo $embroidery->t_missprint; ?>" >
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">GHAT SAREE</label>
                                  <div class="col-8">
                                      <input placeholder="MISS PCS" type="number" name="t_ghatsaree" required class="form-control xGhat_sharee" readonly autocomplete="off" value="<?php echo $embroidery->t_ghatsaree; ?>" >
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">CLOTH VAL</label>
                                  <div class="col-8">
                                      <input placeholder="CLOTH VAL" type="number" step="any" name="cloth_val" required class="form-control xColth_val" autocomplete="off" value="<?php echo $embroidery->cloth_value; ?>">
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">SUB TOTAL</label>
                                  <div class="col-8">
                                      <input placeholder="SUB TOTAL" type="number" step="any" name="sub_total" required="" class="form-control xSub_Total" readonly autocomplete="off" value="<?php echo $embroidery->sub_total; ?>" >
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">TAX (<?php echo TAX;?>%)</label>
                                  <div class="col-8">
                                      <input placeholder="TAX"  type="number" step="any" name="tax" required="" class="form-control xTax " readonly  autocomplete="off" value="<?php echo $embroidery->tax; ?>">
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">GRAND TOTAL</label>
                                  <div class="col-8">
                                      <input placeholder="GRAND TOTAL" type="number" step="any" name="g_total" required="" class="form-control xGrand_Total" autocomplete="off" readonly="" value="<?php echo $embroidery->g_total; ?>">
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="form-group text-center m-t-20 m-b-20">
                        <button class="btn btn-primary waves-effect waves-light" onclick="return validateForm()" type="submit">
                          Update
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
    $('#tr1').remove();
    var i=2;
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
              url: "<?php echo base_url('Embroidery/design_row'); ?>",
              type: "POST",
              data:data,          
              success: function(data){
                var data  = JSON.parse(data);                                          
                if(data.status=="success"){
                    obj.find('.sColor').val(data.datail.color);
                    obj.find('.sD_Pcs').val(data.datail.pcs);
                    obj.find('.sM_dmg').val("0");
                    obj.find('.sG_Sadi').val("0");
                    obj.find('.sM_Print').val("0");                    
                    obj.find('.sM_Print').val("0");
                    if(data.datail.patla_id==null || data.datail.patla_id=="0"){
                      obj.find('.sPatla').html('<option value="0">None</option>'); 
                    }else{
                      obj.find('.sPatla').html('<option value='+data.datail.patla_id+ '>' +data.datail.p_name  + '</option>'); 
                    }
                    if(data.datail.emuser_id==null || data.datail.emuser_id=="0"){
                      obj.find('.sEm_user').html('<option value="0">None</option>');  
                    }else{
                      obj.find('.sEm_user').html('<option value='+data.datail.emuser_id+'>'+data.datail.em_name+'</option>');   
                    }
                    calculate_meter();
                }
              }
          }); 
    });
    $('body').on('keyup','.sM_dmg', function(e){
          var tr=$(this).parents('tr');
          calculate_obj(tr);
          calculate_meter();
    });
    $('body').on('keyup','.sColor', function(e){
          var tr=$(this).parents('tr');
          calculate_obj(tr);
          calculate_meter();
        });
    $('body').on('keyup','.sD_Pcs', function(e){
          var tr=$(this).parents('tr');
          calculate_obj(tr);
          calculate_meter();
    });  
    $('body').on('keyup','.sEm_name', function(e){
          var tr=$(this).parents('tr');
          calculate_obj(tr);
          calculate_meter();
    });
    $('body').on('keyup','.sM_Print', function(e){  
          var tr=$(this).parents('tr');
          calculate_obj(tr);    
          calculate_meter();      
    }); 
    $('body').on('keyup','.xColth_val', function(e){
          calculate_meter();
    });
    $('body').on('keyup','.sF_Pcs', function(e){
          var tr=$(this).parents('tr');
          calculate_obj(tr);
          calculate_meter();
    });
    $('body').on('keyup','.sG_Sadi', function(e){
          var tr=$(this).parents('tr');
          calculate_obj(tr);
          calculate_meter();
    });
    $('body').on('keyup','.sRate', function(e){
          var tr=$(this).parents('tr');
          calculate_obj(tr);
          calculate_meter();
    });
    $('body').on('keyup','.sS_Total', function(e){
          var tr=$(this).parents('tr');
          calculate_obj(tr);
          calculate_meter();
    });
    $('body').on('click','.btn-add', function(){
          let tr=$(this).parents('tr');
          tr.before('<tr id="tr'+i+'">'+appendnode+'</tr>');
          $('select').select2();
          $('#tr'+i).find('.sDesign').focus();
          calculate_meter();
          i++;
          return false;
    });
    $('body').on('click','.btn-remove', function(){          
        $(this).parents('tr').remove();
        calculate_meter();
    });
    $('select').select2();
});
function calculate_obj($obj){
    var fpcs=parseFloat($obj.find('.sF_Pcs').val());
    var rate=parseFloat($obj.find('.sRate').val());
    var total=fpcs*rate;
    $obj.find('.sS_Total').val(total.toFixed(2));
}
function calculate_meter(){
    var sub_meter = 0;
    var sub_taka = 0;
    var rowCount = $('#myTable >tbody >tr').length;
        $('.xT_Design').val(rowCount-1);
    var D_Pcs = 0;
    $('.sF_Pcs').each(function(){
        D_Pcs += parseFloat($(this).val());        
    });
    $('.xT_Pcs').val(D_Pcs);
    var M_Pcs = 0;
    $('.sM_Print').each(function(){
        M_Pcs += parseFloat($(this).val());         
    });
    $('.xMissPrint').val(M_Pcs);
    var cloth_val=parseFloat($('.xColth_val').val());
    var Pand_val=parseFloat($('.xPand_val').val());
    var T_Pcs=parseFloat($('.xT_Pcs').val());     
    var m_dmg = 0;
    $('.sM_dmg').each(function(){
        m_dmg += parseFloat($(this).val());         
    });
    $('.xMachine_dmg').val(m_dmg);
    var sub_total = 0;      
    $('.sS_Total').each(function(){
        sub_total += parseFloat($(this).val());         
    });
    var xColth_val= sub_total/ D_Pcs;
    $('.xColth_val').val(xColth_val.toFixed(2));
    var G_Sadi=0;  
    $('.sG_Sadi').each(function(){
        G_Sadi += parseFloat($(this).val());          
    }); 
    $('.xGhat_sharee').val(G_Sadi);
    $('.xSub_Total').val(sub_total.toFixed(2));     
    tax=(sub_total*5)/100;
    $('.xTax').val(tax.toFixed(2));
    g_total=Math.round(sub_total+tax);
    $('.xGrand_Total').val(g_total.toFixed(2));
    $('.xProcess_value').val((cloth_val+Pand_val).toFixed(2));
}
</script> 