<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left"><?php echo $page_title; ?></h4>
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('home');?>"><?php echo COMPANY; ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('color/index');?>"><?php echo $page_title; ?></a></li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card-box">
                    <center><h4 class="header-title m-t-0"><?php echo (($method=="edit")?"Update Color":"Add Color" )?></h4></center><br>
                    <form id="<?php echo (($method=="edit")?"$frm_id":"$frm_id");?>" class="form-horizontal" role="form" >
                          <div class="form-group row">
                              <label for="name" class="col-3 col-form-label">COLOR NAME<span class="text-danger">*</span></label>
                              <div class="col-9">
                                  <input placeholder="COLOR NAME" type="text" name="name" required="" class="form-control" autocomplete="off" value="<?php echo (($method=="edit")?$result->name:"");  ?>">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="price" class="col-3 col-form-label">PRICE<span class="text-danger">*</span></label>
                              <div class="col-9">
                                  <input placeholder="PRICE" type="number" name="price" required="" class="form-control" autocomplete="off" value="<?php echo (($method=="edit")?$result->price:"");  ?>">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="remark" class="col-3 col-form-label">REMARK<span class="text-danger">*</span></label>
                              <div class="col-9">
                                  <input placeholder="REMARK" type="text" name="remark" class="form-control" autocomplete="off" value="<?php echo (($method=="edit")?$result->remark:"");  ?>">
                              </div>
                          </div>
                        <?php if($method=="edit"): ?> 
                        <div class="form-group row">
                            <label for="status" class="col-3 col-form-label">STATUS</label>
                            <div class="col-9">
                                <select class="selectpicker" name="status"  data-style="btn-custom">
                                    <option value="1" <?php echo (($method=="edit")?(($result->status=="1")?"selected":""):"");  ?>>Active</option>                
                                    <option value="0" <?php echo (($method=="edit")?(($result->status=="0")?"selected":""):"");  ?>>InActive</option>
                                </select>
                                <?php echo (($method=="edit")?'<input type="hidden" name="id" value="'.$result->id .'">':""); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="form-group text-center m-t-20 m-b-20 ">
                          <button class="btn btn-primary waves-effect waves-light" type="submit">
                              <?php echo (($method=="edit")?"Update":"Add") ?>
                          </button>
                      </div>
                    </form>
                </div>
            </div>
            <?php if($method !="edit") :?>
            <div class="col-md-8">
                <div class="card-box table-responsive">
                    <table id="datatable-buttons" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>COLOR NAME</th>
                            <th>PRICE</th>
                            <th>REMARK</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
          <?php endif; ?>
        </div>
    </div> 
</div> 
<script type="text/javascript">
    $(document).ready(function() {
      $('form').parsley();
      $('select').select2();
      <?php if($method !="edit") :?>
        var table = $('#datatable-buttons').DataTable({
            processing: true,
            serverSide: true,
            order: [],
            dom: 'Blfrtip',
            ajax: {
                   "url": "<?php echo base_url('color/getLists/'); ?>",
                   "type": "POST",
               },
            columnDefs: [{ "targets": [2],"orderable": false  }],
            buttons: ['print','copy', 'excel', 'colvis'],
            lengthChange: false,
        });
      <?php endif; ?>
        $("#Add_frm").submit(function(event){
           event.preventDefault();
           var data=$(this).serialize();            
           $.ajax({
               url: "<?php echo base_url('color/create')?>",
               type: "POST",
               data: data,              
               success: function(result){
                   var result  = JSON.parse(result);
                   if(result.status=="success"){
                       swal("success",result.msg,"success","#4fa7f3");
                        $('#Add_frm')[0].reset();
                        table.ajax.reload();
                   }else{
                       swal("error",result.msg,"warning","#4fa7f3");
                   }
               }
           });
        });
        $("#Edit_frm").submit(function(event){
           event.preventDefault();              
           var data=$(this).serialize();            
           $.ajax({
               url: "<?php echo base_url('color/update')?>",
               type: "POST",
               data: data,              
               success: function(result){
                   var result  = JSON.parse(result);
                   if(result.status=="success"){
                       swal("success",result.msg,"success","#4fa7f3").then(function () { 
                        window.location="<?php echo base_url("color");?>";            
                   });
                   }else{
                       swal("error",result.msg,"warning","#4fa7f3");
                   }
               }
           });
       });
    });
</script>