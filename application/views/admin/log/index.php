<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left"><?php echo $page_title; ?></h4>
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Dashbord');?>"><?php echo COMPANY; ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('LogActivity/index');?>"><?php echo $page_title; ?></a></li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
           <div class="col-12">
                <div class="card-box">
	               	<div class="col-md-12 m-b-20">
	               		<a href="<?php echo base_url('LogActivity/dbbackup/'); ?>">
	               			<button type="button" class="btn btn-primary waves-effect w-md waves-light">BACKUP DB</button>
	               		</a>
	               		<a href="<?php echo base_url('LogActivity/clear_log/'); ?>">
	               			<button type="button" class="btn btn-danger waves-effect w-md waves-light">CLEAR ACTIVITY LOG</button>
	               		</a>
	               	</div>
               		<div class="table-responsive">
               			<table id="datatable-buttons" class="table table-striped text-center table-bordered m-t-20" cellspacing="0" width="100%">
               			    <thead>
               			    <tr>
               			       <th>Sr No</th>
               			        <th>USER NAME</th>
               			        <th>LOGIN</th>
               			        <th>LOGOUT</th>
               			        <th>DATE TIME</th>
               			        <th>MESSAGE</th>
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
<script type="text/javascript">
    $(document).ready(function() {
        //Buttons examples
        var table = $('#datatable-buttons').DataTable({
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                   "url": "<?php echo base_url('LogActivity/getLists/'); ?>",
                   "type": "POST"
               },
            "order": [[0, "DESC" ]],
            columns: [  
                        { "data": "index_no" },
                        { "data": "user_name" },
                        { "data": "is_login" },
                        { "data": "is_logout" },
                        { "data": "created_at"},
                        { "data": "description" },
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
               