<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left"><?php echo $page_title; ?></h4>
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Dashbord');?>"><?php echo COMPANY; ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Balance/index');?>"><?php echo $page_title; ?></a></li>
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
                           <th>LOT NO</th>
                           <th>CUT MTR</th>
                           <th>CUT PCS</th>
                           <th>PRINT CLO</th>
                           <th>SILICATE CLO</th>
                           <th>DHOLAI CLO</th>
                           <th>KANJI CLO</th>
                           <th>GHADI CLO</th>
                           <th>EMBROIDERY CLO</th>
                           <th>PACKING CLO</th>
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
        var table = $('#datatable-buttons').DataTable({
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                   "url": "<?php echo base_url('Balance/getLists/'); ?>",
                   "type": "POST"
               },
            "order": [[0, "DESC" ]],
            columns: [    
                        { "data": "lot_no" },
                        { "data": "cut_meter" },
                        { "data": "cut_pcs" },
                        { "data": "print_cloth"},
                        { "data": "silicate_cloth" },
                        { "data": "dholai_cloth" },
                        { "data": "kanji_cloth" },
                        { "data": "ghadi_cloth" },
                        { "data": "embroidery_cloth" },
                        { "data": "packing_cloth" }
                    ],
            columnDefs: [{ "targets": [],"orderable": false}],
            buttons: ['print','copy', 'excel', 'colvis'],
            lengthChange: false,
            dom: 'Blfrtip'
        });
        table.buttons().container()
                .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
        
    });
</script> 
               