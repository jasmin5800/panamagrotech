<style type="text/css">
  .form-group.error input, .form-group.error select, .form-group.error textarea {
    border: 2px solid #ef5350;
  }
  textarea.form-control {
      font-size: large;
  }
</style>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left"><?php echo $page_title; ?></h4>
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('home');?>"><?php echo COMPANY; ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('plate/create');?>"><?php echo $page_title; ?></a></li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="card-box">
                    <h4 class="m-t-0 header-title text-center">Update Plate</h4><br>
                    <form action="<?php echo base_url('plate/update');?>" method="post"  class="form-horizontal" >
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">Design<span class="text-danger">*</span></label>
                                  <div class="col-8">
                                      <input placeholder="Design" type="text" name="design" required class="form-control" autocomplete="off" value="<?= $plate->design; ?>" >
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">DATE<span class="text-danger">*</span></label>
                                  <div class="col-8">
                                      <input placeholder="dd/mm/yy" type="text" name="date" required="" class="form-control datepicker-autoclose" autocomplete="off" value="<?= date('d/m/Y',strtotime($plate->date)); ?>">
                                      <input type="hidden" name="plate_id" required class="form-control" autocomplete="off" value="<?= $plate->id; ?>">
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group row">
                                  <label for="name" class="col-4 col-form-label">REMARK</label>
                                  <div class="col-8">
                                      <textarea class="form-control" name="remark" placeholder="REMARK"><?= $plate->remark; ?></textarea>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="row m-t-50">
                            <div class="col-md-12">
                                <div style="overflow-x:auto;">
                                  <table class="table" style="min-width: 1080px;">
                                    <thead>
                                        <tr>
                                          <th scope="col">Plate No</th>
                                          <th scope="col" class="text-center" width="60%">Color & Gram</th>
                                          <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="myTable">
                                        <?php foreach($plate_lot as $key=>$value): ?>
                                        <tr>
                                          <td>
                                            <input type="text" name="plate_test[]" class="form-control plate_no"    placeholder="Plate No" required  value="<?= $key; ?>">
                                          </td>
                                          <td >
                                            <table width="100%">
                                              <tbody>
                                                <?php foreach($value as $key2=>$value2): ?>
                                                <tr >
                                                  <td>
                                                    <select name="match_no[]" required min="1">
                                                        <?php for($i=1; $i<=20; $i++): ?>
                                                            <option value="<?= $i; ?>" <?= (($i==$value2['match_no'])?"selected":"") ?>><?= $i; ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                  </td>
                                                  <td>
                                                    <select name="color[]" class="clildcolor" required min="1">
                                                        <option value="0">None</option>
                                                        <?php foreach($color as $key10=>$value10): ?>
                                                            <option value="<?= $value10->id; ?>" <?= (($value10->id==$value2['color_id'])?"selected":"") ?>><?= $value10->name; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <input type="hidden"  name="plate_no[]" class="form-control childplate_no" required value="<?= $value2['plate_no'] ?>" />
                                                    <input type="hidden"  name="platelot_id[]" class="form-control" 
                                                          value="<?= $value2['id'] ?>" />
                                                  </td>
                                                  <td>
                                                    <input type="text" name="gram[]" class="form-control clildgram" placeholder="Gram" data-parsley-pattern="^[0-9]+[|]*$" value="<?= $value2['gram']?>" required autocomplete="off"  />
                                                  </td>
                                                  <td width="10%">
                                                  </td>
                                                </tr>
                                                <?php endforeach; ?>
                                                <tr>
                                                  <td colspan="3">
                                                  </td>
                                                  <td>
                                                    <button type="button" class="btn waves-effect waves-light btn-secondary btn-chlidadd btn-sm"> <i class="fa fa-plus"></i> </button>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                          <td>
                                          </td>
                                        </tr>
                                        <?php endforeach;?>
                                        <tr id="xAppendNode">
                                          <td>
                                            <input type="text" name="plate_test[]" class="form-control plate_no"    placeholder="Plate No" required >
                                          </td>
                                          <td class="perenttd">
                                            <table width="100%">
                                              <tbody>
                                                <tr id="chlidtr">
                                                  <td>
                                                    <select name="match_no[]" required min="1">
                                                        <?php for($i=1; $i<=20; $i++): ?>
                                                            <option value="<?= $i; ?>"><?= $i; ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                  </td>
                                                  <td>
                                                    <select name="color[]" class="clildcolor" required min="1">
                                                        <option value="0">None</option>
                                                        <?php foreach($color as $key=>$value): ?>
                                                            <option value="<?= $value->id; ?>"><?= $value->name; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <input type="hidden"  name="plate_no[]" class="form-control childplate_no" required />
                                                    <input type="hidden"  name="platelot_id[]" class="form-control"/>
                                                  </td>
                                                  <td>
                                                    <input type="text" name="gram[]" class="form-control clildgram" placeholder="Gram" data-parsley-pattern="^[0-9]+[|]*$" required autocomplete="off" />
                                                  </td>
                                                  <td width="10%">
                                                    <button type="button" class="btn btn-icon waves-effect waves-light btn-danger btn-sm btn-childremove "><i class=" fa fa-minus"></i></button>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td colspan="3">
                                                  </td>
                                                  <td>
                                                    <button type="button" class="btn waves-effect waves-light btn-secondary btn-chlidadd btn-sm"> <i class="fa fa-plus"></i> </button>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                          <td>
                                            <button type="button" class="btn btn-icon waves-effect waves-light btn-danger btn-sm btn-remove "><i class=" fa fa-minus"></i></button>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td colspan="2">
                                          </td>
                                          <td>
                                            <button type="button" class="btn waves-effect waves-light btn-secondary btn-add btn-sm"> <i class="fa fa-plus"></i> </button>
                                          </td>
                                        </tr>
                                    </tbody>
                                  </table>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20 m-b-20">
                          <button class="btn btn-primary waves-effect waves-light" type="submit">
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
    var i=2;
    let appendnode=$('#xAppendNode').html();
    const chlidtr=$('#chlidtr').html();
    $('#xAppendNode').remove();
    $('body').on('click','.btn-add', function(){
      let tr=$(this).parents('tr');
      tr.before('<tr id="tr'+i+'">'+appendnode+'</tr>');
      $('select').select2();
      $('#tr'+i).find('.bala_no').focus();
      i++;
      return false;
    });
    $('body').on('click','.btn-remove', function(){
        $(this).parents('tr').remove();
      return false;
    });
    $('body').on('click','.btn-chlidadd', function(){
      $(this).parent().parent().before('<tr>'+chlidtr+'</tr>');
      $('select').select2();
    });
    $('body').on('click','.btn-childremove', function(){
        var fst_tr=$(this).parent().parent().attr("id");
        if(fst_tr=="chlidtr"){
          return false;
        }else{
          $(this).parent().parent().remove();
        }
        return false;
    });
    $('body').on('keyup','.clildcolor', function(){
        var fst_tr=$(this).parents('tr').find('.plate_no').val();
        $(this).parents('tr').find('.childplate_no').val(fst_tr);
    });
    $('body').on('keyup','.clildgram', function(){
        var fst_tr=$(this).parents('tr').find('.plate_no').val();
        $(this).parents('tr').find('.childplate_no').val(fst_tr);
    });
    $('body').on('keyup','.plate_no', function(){
        $('.childplate_no').each(function( index ) {
            var data=$(this).parents('tr').find('.plate_no').val();
            $(this).val(data);
        });
    });
    $('select').select2();
});
</script> 