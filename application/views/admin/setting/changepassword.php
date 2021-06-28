<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left"><?php echo $page_title; ?></h4>
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Dashbord');?>"><?php echo COMPANY; ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('MasterAdmin/index');?>"><?php echo $page_title; ?></a></li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card-box">
                    <h4 class="header-title m-t-0 text-center m-b-30">Password Change</h4>
                    <form role="form" id="<?php echo (($method=="edit")?"$frm_id":"$frm_id");?>">
                        <div class="form-group row">
                            <label for="username" class="col-4 col-form-label">USER NAME<span class="text-danger">*</span></label>
                            <div class="col-7">
                                <input type="text" name="username" required class="form-control" readonly placeholder="USER NAME" value="<?php echo (($method=="edit")?$user->username:"")?>">
                                <?php echo (($method=="edit")?'<input type="hidden" name="id" required  value="'.$user->id_master.'">':'')?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hori-pass1" class="col-4 col-form-label">PASSWORD<span class="text-danger">*</span></label>
                            <div class="col-7">
                                <input id="hori-pass1" type="password" name="password" placeholder="PASSWORD" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="hori-pass2" class="col-4 col-form-label">CONFIRM PASSWORD
                                <span class="text-danger">*</span></label>
                            <div class="col-7">
                                <input data-parsley-equalto="#hori-pass1" type="password" required
                                       placeholder="PASSWORD" class="form-control" id="hori-pass2" data-parsley-required-message="Enter password" data-parsley-equalto-message="Password and conform Password are not same">
                            </div>
                        </div>
                        <div class="form-group row m-t-40">
                            <div class="col-8 offset-4">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">
                                    Chnage Password
                                </button>
                            </div>
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
         $("#Edit_frm").submit(function(event){
            event.preventDefault();              
            var data=$(this).serialize();            
            $.ajax({
                url: "<?php echo base_url('MasterAdmin/password_update')?>",
                type: "POST",
                data: data,              
                success: function(result){
                    var result  = JSON.parse(result);
                    if(result.status=="success"){
                        swal("success",result.msg,"success","#4fa7f3").then(function () { 
                         window.location="<?php echo base_url("MasterAdmin");?>";            
                    });
                    }else{
                        swal("error",result.msg,"warning","#4fa7f3");
                    }
                }
            });
        });
    });
</script>