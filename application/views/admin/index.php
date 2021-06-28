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
                        <h2 class="font-600"><span><i class="mdi mdi-arrow-up"></i></span> <span data-plugin="counterup"><?php echo $lot_count; ?></span></h2>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card-box widget-box-two widget-two-custom">
                    <i class="fa fa-user-secret widget-two-icon"></i>
                    <div class="wigdet-two-content">
                        <p class="m-0 text-uppercase font-bold font-secondary text-overflow text-danger">Total Number of Admins</p>
                        <h2 class="font-600"><span><i class="mdi mdi-arrow-up"></i></span> <span data-plugin="counterup"><?php echo $user_count; ?></span></h2>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card-box widget-box-two widget-two-custom">
                    <i class="fa fa-users widget-two-icon"></i>
                    <div class="wigdet-two-content">
                        <p class="m-0 text-uppercase font-bold font-secondary text-overflow text-danger" >Total Number of Party</p>
                        <h2 class="font-600"><span><i class="mdi mdi-arrow-up"></i></span> <span data-plugin="counterup"><?php echo $user_party; ?></span></h2>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card-box widget-box-two widget-two-custom">
                    <i class="fa fa-users widget widget-two-icon"></i>
                    <div class="wigdet-two-content">
                        <p class="m-0 text-uppercase font-bold font-secondary text-overflow text-danger" >Total Number of Patla</p>
                        <h2 class="font-600"><span><i class="mdi mdi-arrow-up"></i></span> <span data-plugin="counterup"><?php echo $user_patla; ?></span></h2>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="card-box widget-box-two widget-two-custom">
                    <i class="fa fa-product-hunt widget-two-icon"></i>
                    <div class="wigdet-two-content">
                        <p class="m-0 text-uppercase font-bold font-secondary text-overflow text-danger" >Total Number of Item</p>
                        <h2 class="font-600"><span><i class="mdi mdi-arrow-up"></i></span> <span data-plugin="counterup"><?php echo $user_item; ?></span></h2>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="card-box widget-box-two widget-two-custom">
                    <i class="fa fa-users widget widget-two-icon"></i>
                    <div class="wigdet-two-content">
                        <p class="m-0 text-uppercase font-bold font-secondary text-overflow text-danger" >Total Number of Em User</p>
                        <h2 class="font-600"><span><i class="mdi mdi-arrow-up"></i></span> <span data-plugin="counterup"><?php echo $user_emuser; ?></span></h2>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-sm-6">
                <div class="card-box widget-box-two widget-two-custom">
                    <i class="fa fa-truck widget-two-icon"></i>
                    <div class="wigdet-two-content">
                        <p class="m-0 text-uppercase font-bold font-secondary text-overflow text-danger" >Total Number of Transport</p>
                        <h2 class="font-600"><span><i class="mdi mdi-arrow-up"></i></span> <span data-plugin="counterup"><?php echo $user_transport; ?></span></h2>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div> 
<script src="<?php echo base_url('assets/admin/plugins/waypoints/jquery.waypoints.min.js')?>"></script>
<script src="<?php echo base_url('assets/admin/plugins/counterup/jquery.counterup.min.js')?>"></script>
               