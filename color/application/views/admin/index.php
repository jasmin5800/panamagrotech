<style type="text/css">
    .widget-box-two p {
        font-size: 14px;
    }
</style>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left"><?php echo $page_title; ?></h4>
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="#"><?php echo COMPANY; ?></a></li>
                        <li class="breadcrumb-item"><a href="#"><?php echo $page_title; ?></a></li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-sm-6">
                <div class="card-box widget-box-two widget-two-custom">
                    <i class="mdi mdi-crown widget-two-icon"></i>
                    <div class="wigdet-two-content">
                        <p class="m-0 text-uppercase font-bold font-secondary text-overflow text-danger">Total Number of Lot</p>
                        <h2 class="font-600"><span><i class="mdi mdi-arrow-up"></i></span> <span data-plugin="counterup"><?php $lot_count=0;  echo $lot_count; ?></span></h2>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div> 
<script src="<?php echo base_url('public/admin/plugins/waypoints/jquery.waypoints.min.js')?>"></script>
<script src="<?php echo base_url('public/admin/plugins/counterup/jquery.counterup.min.js')?>"></script>
               