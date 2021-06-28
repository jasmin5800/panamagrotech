<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left"><?php echo $page_title; ?></h4>
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Dashbord');?>"><?php echo COMPANY; ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Printing/index');?>"><?php echo $page_title; ?></a></li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
           <div class="col-12">
               <div class="card-box table-responsive">
                   <table id="datatable-buttons" class="table table-striped text-center table-bordered m-t-20" cellspacing="0" width="100%">
                       <thead>
                       <tr>
                           <th>#</th>
                           <th>LOT NO</th>
                           <th>CHALLAN NO</th>
                           <th>DATE</th>
                           <th>T MISSPRINT</th>
                           <th>TOTAL PCS</th>
                           <th>CLOTH VAL</th>
                           <th>G TOTAL</th>
                           <th>PRINT VALUE</th>
                           <?php if($_SESSION['auth_role_id']=="1"): ?>
                           <th>ADD BY</th>
                           <?php endif;?>
                           <th>ACTION</th>
                       </tr>
                       </thead>
                       <tbody>
                       </tbody>
                   </table>
               </div>
           </div>
       </div>
    </div> 
</div>
<script type="text/javascript">
    $(document).ready(function() {
        //Buttons examples
        <?php if($_SESSION['auth_role_id']=="1"): ?>
        var table = $('#datatable-buttons').DataTable({
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                   "url": "<?php echo base_url('Printing/getLists/'); ?>",
                   "type": "POST"
               },
            "order": [[0, "DESC" ]],
            columns: [      
                        { "data": "sr_no" },
                        { "data": "lot_no" },
                        { "data": "challan_no" },
                        { "data": "date"},
                        { "data": "t_missprint" },
                        { "data": "t_pcs" },
                        { "data": "cloth_value" },
                        { "data": "g_total" },
                        { "data": "print_val" },
                        { "data": "user_name" },
                        { "data": "button" }
                    ],
            columnDefs: [{ "targets": [10],"orderable": false}],
            buttons: ['print','copy', 'excel', 'colvis'],
            lengthChange: false,
            dom: 'Blfrtip'
        });
        <?php else :?>
        var table = $('#datatable-buttons').DataTable({
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                   "url": "<?php echo base_url('Printing/getLists/'); ?>",
                   "type": "POST"
               },
            "order": [[0, "DESC" ]],
            columns: [      
                        { "data": "sr_no" },
                        { "data": "lot_no" },
                        { "data": "challan_no" },
                        { "data": "date"},
                        { "data": "t_missprint" },
                        { "data": "t_pcs" },
                        { "data": "cloth_value" },
                        { "data": "g_total" },
                        { "data": "print_val" },
                        { "data": "button" }
                    ],
            columnDefs: [{ "targets": [9],"orderable": false}],
            buttons: ['print','copy', 'excel', 'colvis'],
            lengthChange: false,
            dom: 'Blfrtip'
        });
        <?php endif; ?>
        table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
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
                   url: "<?php echo base_url('Printing/delete/');?>"+id+"",
                   success: function(data){
                     var data  = JSON.parse(data);
                     if(data.status=="success"){
                         swal("success",data.msg,"success","#4fa7f3");
                        table.ajax.reload();
                     }else{
                         swal("error",data.msg,"warning","#4fa7f3");
                     }
                   }
                 });
             })
         })
    });
</script> 
               