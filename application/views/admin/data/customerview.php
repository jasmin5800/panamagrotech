<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left"><?php echo $page_title; ?></h4>
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Dashbord');?>"><?php echo COMPANY; ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Customer/index');?>"><?php echo $page_title; ?></a></li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
           
            <div class="col-md-12">
                <div class="card-box table-responsive">
                    <table id="datatable-buttons" class="table table-striped table-bordered text-center" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Party Name</th>
                            <th>Mobile No.</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>GST No.</th>
                            <th>Pan No.</th>
                            <th>Bank No.</th>
                            <th>Action</th>
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
          dom: 'Blfrtip',
          ajax: {
                 "url": "<?php echo base_url('Customer/getLists/'); ?>",
                 "type": "POST",
             },
          columnDefs: [{ "targets": [0],"orderable": false  }],
          buttons: ['print','copy', 'excel', 'colvis'],
          lengthChange: false,
    });
                    
   $('#datatable-buttons').on('click', '[data-id=delete]', function () {                        
        var id= $(this).data("value");
        swal({
                title: 'Are you sure delete?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4fa7f3',
                cancelButtonColor: '#d57171',
                confirmButtonText: 'Yes, delete it!'
            }).then(function () {
            $.ajax({
              type: "POST",
              url: "<?php echo base_url('Customer/delete/');?>"+id+"",
              success: function(data){
                var data  = JSON.parse(data);
                if(data.status=="success"){
                    swal("success",data.message,"success","#4fa7f3");
                   table.ajax.reload();
                }else{
                    swal("error",data.message,"warning","#4fa7f3");
                }              
              }
           })
        });
     });
 });
</script>
 