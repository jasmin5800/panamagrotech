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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Cut/index');?>"><?php echo $page_title; ?></a></li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="card-box">
                    <h4 class="m-t-0 header-title text-center">Add Cut</h4><br>
                    <form action="<?php echo base_url('Cut/create');?>" method="post"  class="form-horizontal" >
                        <div class="row">
                          <div class="col-md-4">
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
                          <div class="col-md-4">
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">PARTY<span class="text-danger">*</span></label>
                                  <div class="col-8">
                                      <select name="party" id="party" class="xParty" data-parsley-min="1" data-parsley-min-message="Select AtList One">
                                        <option value="0">None</option>
                                        <?php foreach ($party as $key => $value): ?>
                                            <option value="<?php echo $value->party_id; ?>"><?php echo $value->party_name; ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">ITEM<span class="text-danger">*</span></label>
                                  <div class="col-8">
                                      <select name="item" class="xItem" id="item">
                                      </select>
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group row">
                                  <label for="lot_no" class="col-4 col-form-label">LOT NO<span class="text-danger">*</span></label>
                                  <div class="col-8">
                                      <input placeholder="Lot No" type="number" name="lot_no" required="" class="form-control xLotno" autocomplete="off" value="<?php echo $lot_no; ?>">
                                      <input type="hidden" id="exist" name="exist" value="1">
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="lot_no" class="col-4 col-form-label">USE FOR<span class="text-danger">*</span></label>
                                  <div class="col-8">
                                      <select name="use_for" data-parsley-min="1" data-parsley-min-message="Select Any">
                                        <option value="0">NONE</option>
                                        <option value="1">DEVIDE</option>
                                        <option value="2">EM DEVIDE</option>
                                        <option value="3">GHADI</option>
                                      </select>
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
                                        <th scope="col" width="15%">CHALLAN</th>
                                        <th scope="col">PURCHASE MTR</th>
                                        <th scope="col">BALA</th>
                                        <th scope="col">PURCHASE VAL</th>
                                        <th scope="col">PCS</th>
                                        <th scope="col">MTR / PCS</th>
                                        <th scope="col">CUT MTR</th>
                                        <th scope="col">FENT</th>
                                        <th scope="col"></th>
                                      </tr>
                                  </thead>
                                  <tbody id="tableBody">
                                      <tr id="xAppendNode">
                                        <td>
                                          <select name="schallan_no[]" class="sChallan">
                                          </select>
                                        <td>
                                          <input type="number" name="p_mtr[]" class="form-control sPMeter" step="any" placeholder="PURCHASE MTR" required readonly >
                                        </td>
                                        <td>
                                          <input type="number" name="bala_no[]" class="form-control sbala" step="any" placeholder="BALA" required readonly >
                                        </td>
                                        <td>
                                          <input type="number" name="pur_val[]" class="form-control sVlaue" step="any" placeholder="PURCHASE VAL" required readonly>
                                        </td>
                                        <td>
                                          <input type="number" step="any" name="pcs[]" class="form-control sPcs" placeholder="PCS" required >
                                        </td>
                                        <td>
                                          <input type="number" step="any" name="mtr_pcs[]" class="form-control sMtr_Pcs"  placeholder="MTR / PCS"  required >
                                        </td>
                                        <td>
                                          <input type="number" step="any" name="cut_mtr[]" class="form-control lr_no sCut_Mtr"  placeholder="CUT MTR" required readonly>
                                        </td>
                                        <td>
                                          <input type="number" step="any" name="fent[]" class="form-control sFent"  placeholder="FENT" required readonly  data-parsley-min="0" data-parsley-min-message="Min Value is 0">
                                        </td>
                                        <td>
                                          <button type="button" class="btn btn-icon waves-effect waves-light btn-danger btn-sm btn-remove "><i class=" fa fa-minus"></i></button>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td colspan="8">
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
                                  <label for="name" class="col-4 col-form-label">METER VAL</label>
                                  <div class="col-8">
                                      <input placeholder="METER VAL" type="number" step="any" name="tmtr_val" required="" class="form-control xMeter_Value" readonly autocomplete="off" >
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">PCS VAL</label>
                                  <div class="col-8">
                                      <input placeholder="PCS VAL"  type="number" step="any" name="tpcs_val" class="form-control xGPcs_value " required readonly autocomplete="off">
                                  </div>
                              </div>
                          </div>
                          <div class="offset-md-4 col-md-4">
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">TOTAL BALA</label>
                                  <div class="col-8">
                                      <input placeholder="TOTAL BALA" type="number" name="t_bala" required="" class="form-control xT_Bala" readonly autocomplete="off" >
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">TOTAL P MTR</label>
                                  <div class="col-8">
                                      <input placeholder="TOTAL P MTR"  type="number" step="any" name="tp_mtr" class="form-control xPMtr" required readonly autocomplete="off">
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">TOTAL PCS</label>
                                  <div class="col-8">
                                      <input placeholder="TOTAL PCS" type="number" step="any" name="t_pcs" required class="form-control xTotal_pcs"  readonly autocomplete="off">
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">CUTTING MTR</label>
                                  <div class="col-8">
                                      <input placeholder="CUTTING MTR" type="number" step="any" name="tcuting_mtr" required readonly class="form-control xCut_Mtr" autocomplete="off" >
                                  </div>
                              </div>
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">TOTAL FENT</label>
                                  <div class="col-8">
                                      <input placeholder="TOTAL FENT" type="number" step="any" name="t_fent" required="" class="form-control xTemp_Meter" readonly autocomplete="off" >
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
    let appendnode=$('#xAppendNode').html();
    let tablebody=$('#tableBody').html();
    var i=2;
    check_lot_no();
    $('body').on('change','.xParty', function(e){
        var id = $(this).val(); 
        $('#tableBody').empty();      
        $('#tableBody').html(tablebody);
        $('.xItem').empty();
        $(this).focus();
        $("select").select2();
        $.ajax({                                            
          url:"<?php echo base_url('cut/get_item/') ?>"+id+"",
          type: "POST",
          success: function(result){
            var result  = JSON.parse(result);                            
            if(result.status=="success"){
              $('.xItem').append('<option></option>');
              $.each(result.item,function(key, value)
              {               
                $('.xItem').append('<option value=' + value[0] + '>' + value[1] + '</option>');
              });
            }
          }
        });
    });
    $('body').on('change','.xItem', function(e){
        var item=$(this).val(); 
        $('#tableBody').empty();      
        $('#tableBody').html(tablebody);
        $("select").select2();
        $(this).focus();
        var party=$(".xParty").val();
        $.ajax({                                            
            url:"<?php echo base_url('cut/get_challan/') ?>",
            type: "POST",
            data: {item: item, party: party},
            success: function(result){
                var result  = JSON.parse(result);                                
                if(result.status=="success"){
                  $('.sChallan').append('<option></option>');           
                  $.each(result.challan_no,function(key,value)
                  {
                    $('.sChallan').append('<option value=' + value.challan_no + '>' + value.challan_no + '</option>');
                  });             
                }
            }
        });
    });
    $('body').on('change','.sChallan', function(e){
        var id = $(this).val();
        var tr =$(this).parents('tr'); 
        var party=$('.xParty').val();
        var item=$('.xItem').val(); 
        $.ajax({                                            
            url:"<?php echo base_url('cut/get_rowdetail/') ?>",
            type: "POST",
            data:{challan:id,party:party,item:item},
            success: function(result){
              var result  = JSON.parse(result);                                
              if(result.status=="success"){ 
                tr.find('.sPMeter').val(result.row.total_meter);
                tr.find('.sVlaue').val(result.row.meter_value);
                tr.find('.sbala').val(result.row.t_bala);
                calculate_meter();            
              }
            }
        });
    });
    $('body').on('keyup','.sPcs', function(e){
        tr=$(this).parents('tr');
        calculate_obj(tr);
        calculate_meter();
    });
    $('body').on('keyup','.sMtr_Pcs', function(e){
          tr=$(this).parents('tr');
          calculate_obj(tr);
          calculate_meter();  
    });
    $('.xLotno').keyup(function() {
      
        let value=$(this).val();        
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('Cut/check_lotno')?>",
            data: {lot_no:value},
            success: function(data){
              var data  = JSON.parse(data);                                          
              if(data.status=="success")
              {
                $("#exist").val("1");
                $(".xLotno").removeClass("has-error"); 
              }else
              {
                $("#exist").val("0");
                $.toast({
                        text: data.msg,
                        position: 'top-right',
                        loaderBg: '#bf441d',
                        icon: 'error',
                        hideAfter: 3000,
                        stack: 1
                });
                $(".xLotno").addClass("has-error");               
              }
            } 
        });
    });
    $('body').on('click','.btn-add', function(){
      let tr=$(this).parents('tr');
      var challan=$("#xAppendNode").find('.sChallan').html();
      tr.before('<tr id="tr'+i+'">'+appendnode+'</tr>');
      $("#tr"+i+"").find('.sChallan').html(challan);  
      $('select').select2();
      i++;
      return false;
    });
    $('body').on('click','.btn-remove', function(){
      var fst_tr=$(this).parents('tr').attr("id");
      if(fst_tr=="xAppendNode"){
        return false;
      }else{
        $(this).parents('tr').remove();
        calculate_meter()
      }
      return false;
    });
    $('select').select2();
});
function calculate_obj($tr){
    var mtr=parseFloat($tr.find('.sMtr_Pcs').val());
    var pcs=parseInt($tr.find('.sPcs').val());
    var cut_mtr=pcs*mtr;
    $tr.find('.sCut_Mtr').val(cut_mtr.toFixed(2));
    var sPMeter =parseFloat($tr.find('.sPMeter').val());
    $tr.find('.sFent').val((sPMeter-cut_mtr).toFixed(2));
}
function calculate_meter(){
    var sVlaue = 0;
    $('.sVlaue').each(function(){
        sVlaue += parseFloat($(this).val());         
    });
    $('.xMeter_Value').val(sVlaue.toFixed(2));
    var sPMeter=0;
    $('.sPMeter').each(function(){
        sPMeter += parseFloat($(this).val());        
    });
    $('.xPMtr').val(sPMeter.toFixed(2));
    var sPcs =0;
    $('.sPcs').each(function(){
        sPcs  += parseFloat($(this).val());        
    });
    $('.xTotal_pcs').val(sPcs);
    var sbala=0;
    $('.sbala').each(function(){
        sbala  += parseFloat($(this).val());         
    });
    $('.xT_Bala').val(sbala);
    var sCut_Mtr  =0;
    $('.sCut_Mtr ').each(function(){
        sCut_Mtr   += parseFloat($(this).val());         
    });
    $('.xCut_Mtr').val(sCut_Mtr.toFixed(2));
    var sFent  =0;
    $('.sFent ').each(function(){
        sFent   += parseFloat($(this).val());        
    });
    $('.xTemp_Meter').val(sFent.toFixed(2));
    $('.xGPcs_value').val((sVlaue*5.5).toFixed(2));
  }
  function check_lot_no(){

    let value=$('.xLotno').val();        
    $.ajax({
        type: "POST",
        url: "<?php echo base_url('Cut/check_lotno')?>",
        data: {lot_no:value},
        success: function(data){
          var data  = JSON.parse(data);                                          
          if(data.status=="success")
          {
            $("#exist").val("1");
            $(".xLotno").removeClass("has-error"); 
          }else
          {
            $("#exist").val("0");
            $.toast({
                    text: data.msg,
                    position: 'top-right',
                    loaderBg: '#bf441d',
                    icon: 'error',
                    hideAfter: 3000,
                    stack: 1
            });
            $(".xLotno").addClass("has-error");               
          }
        } 
    });
  }
  function validateForm(){
      var val=$('#exist').val();
      if(val=="1"){
        return true;      
      }else{
        $("#challan_no").focus();
        return false;
      }
  }
</script> 