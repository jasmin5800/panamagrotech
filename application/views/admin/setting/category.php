<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left"><?php echo $page_title; ?></h4>
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Dashbord');?>"><?php echo COMPANY; ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Category/index');?>"><?php echo $page_title; ?></a></li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card-box">
                    <h4 class="header-title m-t-0 text-center m-b-30"><?php echo (($method=="edit")?"Update":"Add")?> Category</h4>
                    <form role="form" id="<?php echo (($method=="edit")?"$frm_id":"$frm_id");?>">
                        <div class="form-group row">
                            <label for="name" class="col-4 col-form-label">Category Name<span class="text-danger">*</span></label>
                            <div class="col-7">
                                <input type="text" name="name" required class="form-control" placeholder="Category Name" value="<?php echo (($method=="edit")?$category->name:"")?>">
                                <?php echo (($method=="edit")?'<input type="hidden" name="id" required  value="'.$category->id.'">':'')?>
                            </div>
                        </div>
                       
                        <?php if($method=="edit"){ ?>
                        <div class="form-group row">
                            <label for="status" class="col-4 col-form-label">Status<span class="text-danger">*</span></label>
                            <div class="col-7">
                                <select class="selectpicker" data-style="btn-custom" name="status">
                                    <option value="1"  <?php echo (($method=="edit")?(($category->status=="1")?"selected":""):"") ?>>Active</option>
                                    <option value="0" <?php echo (($method=="edit")?(($category->status=="0")?"selected":""):"") ?>>InActive</option>
                                </select>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="form-group row m-t-40">
                            <div class="col-8 offset-4">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    <?php echo (($method=="edit")?"Update":"Register")?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div> 
            </div>
            <div class="col-md-6">
                <div class="card-box table-responsive">
                    <table id="datatable-buttons" class=" table table-striped table-bordered text-center" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Category Name</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div> 
</div> 
<script type="text/javascript">
    $(document).ready(function() {
        $('form').parsley();
        $("select").select2();
        var table = $('#datatable-buttons').DataTable({
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                   "url": "<?php echo base_url('Category/getLists/'); ?>",
                   "type": "POST"
               },
            columnDefs: [{ "targets": [0],"orderable": false }],
            buttons: ['print','copy', 'excel', 'colvis'],
            lengthChange: false,
            dom: 'Blfrtip'
        });
        table.buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
        $("#Add_frm").submit(function(event){
            event.preventDefault();
            var data=$(this).serialize();   
            $.ajax({
                url: "<?php echo base_url('Category/create')?>",
                type: "POST",
                data: data,              
                success: function(result){
                    var result  = JSON.parse(result);
                    if(result.status=="success"){
                        swal("success",result.msg,"success","#4fa7f3");
                         $('#Add_frm')[0].reset();
                         $('#datatable-buttons').DataTable().ajax.reload();
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
                url: "<?php echo base_url('Category/update')?>",
                type: "POST",
                data: data,              
                success: function(result){
                    var result  = JSON.parse(result);
                    if(result.status=="success"){
                        swal("success",result.msg,"success","#4fa7f3").then(function () { 
                         window.location="<?php echo base_url("Category");?>";            
                    });
                    }else{
                        swal("error",result.msg,"warning","#4fa7f3");
                    }
                }
            });
        });
    } );
</script>