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
                  <div class="row">
                      <div class="col-md-12">
                          <h4 class="m-t-0 m-b-20 header-title text-center">Lot Status</h4>
                            <div class="table-responsive">
                                <table id="datatable-buttons" class="table table-striped text-center table-bordered m-t-20" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>LOT NO</th>
                                        <th>USE</th>
                                        <th>Devide</th>
                                        <th>Printing</th>
                                        <th>Process</th>
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
       </div>
    </div> 
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('form').parsley();
    $('select').select2();
    var table = $('#datatable-buttons').DataTable({
        processing: true,
        serverSide: true,
        order: [],
        ajax: {
               "url": "<?php echo base_url('Manage/getLists/'); ?>",
               "type": "POST"
           },
        "order": [[0, "DESC" ]],
        columns: [     
                    { "data": "sr_no" },
                    { "data": "lot_no" },
                    { "data": "use_for" },
                    { "data": "devide_status" },
                    { "data": "print_status" },
                    { "data": "process_status" },
                    { "data": "button" }
                ],
        columnDefs: [{ "targets": [6],"orderable": false}],
        buttons: ['print','copy', 'excel', 'colvis'],
        lengthChange: false,
        dom: 'Blfrtip'
    });
    table.buttons().container()
            .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
});
</script>
            