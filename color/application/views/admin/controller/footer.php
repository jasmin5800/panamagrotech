                <footer class="footer text-right" style="background-color: #777;" >
                    <div class="row">
                    <div class="col-6" style="color:#FFFFFF;">2019 - <?php echo date("Y"); ?> © <a href="<?php echo base_url('home'); ?>" class="text-white" ><?php echo COMPANY_NAME; ?></a>
                    </div>
                    <div class="col-6 text-right" style="color:#FFFFFF;">POWERED BY <a href="<?php echo DEVELOP_URL;?>" class="text-white" target="_blank" ><?php echo DEVELOP_BY; ?></a>.</div>
                    </div>
                </footer>
            </div>
        </div>
        <style>
            /* Chrome, Safari, Edge, Opera */
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
              -webkit-appearance: none;
              margin: 0;
            }
            /* Firefox */
            input[type=number] {
              -moz-appearance: textfield;
            }
            .select2-container *:focus  {
                border-color: #66afe9;
                border:2px;
                outline: 0;
                -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(102, 175, 233, 0.6);
                box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(102, 175, 233, 0.6);
                }
            .form-control:focus {
                border-color: #66afe9;
                outline: 0;
                -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(102, 175, 233, 0.6);
                box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(102, 175, 233, 0.6);
            }
            .btn:focus {
                border-color: #66afe9;
                outline: 0;
                -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(102, 175, 233, 0.6);
                box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(102, 175, 233, 0.6);
            }
            .has-error{
                border-color: #f26563;
                background-color: #F2DEDE;
            }
            .has-error:focus {
                border-color: #f26563;
                background-color: #F2DEDE;
                -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px #f40000;
                box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px #ff0300;            
            }
        </style>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.datepicker-autoclose').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'dd/mm/yyyy'
                });
            <?php if(isset($_SESSION['status']) && !empty($_SESSION['status']) && isset($_SESSION['msg']) && !empty($_SESSION['msg']) ): ?>
                    $.toast({
                        heading: '<?php echo (($_SESSION['status']=="success")?"Well done!":"Oh snap!");?>',
                        text: '<?php echo $_SESSION['msg']; ?>',
                        position: 'top-right',
                        loaderBg: '<?php echo (($_SESSION['status']=="success")?"#5ba035":"#bf441d");?>',
                        icon: '<?php echo (($_SESSION['status']=="success")?"success":"warning");?>',
                        hideAfter: 7000,
                        stack: 1
                    });
            <?php unset($_SESSION['status']); unset($_SESSION['msg']);?>
            <?php endif;?>
            });
        </script> 
        <script src="<?php echo base_url('public/admin/plugins/select2/js/select2.min.js');?>"></script>        
        <script src="<?php echo base_url('public/admin/plugins/sweet-alert2/sweetalert2.min.js');?>"></script>
        <script src="<?php echo base_url('public/admin/pages/jquery.sweet-alert.init.js');?>"></script>
        <script src="<?php echo base_url('public/admin/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>
        <script src="<?php echo base_url('public/admin/plugins/bootstrap-daterangepicker/daterangepicker.js')?>"></script>
        <script src="<?php echo base_url('public/admin/plugins/datatables/jquery.dataTables.min.js');?>"></script>
        <script src="<?php echo base_url('public/admin/plugins/datatables/dataTables.bootstrap4.min.js');?>"></script>
        <script src="<?php echo base_url('public/admin/plugins/datatables/dataTables.buttons.min.js');?>"></script>
        <script src="<?php echo base_url('public/admin/plugins/datatables/buttons.bootstrap4.min.js');?>"></script>
        <script src="<?php echo base_url('public/admin/plugins/datatables/jszip.min.js');?>"></script>
        <script src="<?php echo base_url('public/admin/plugins/datatables/pdfmake.min.js');?>"></script>
        <script src="<?php echo base_url('public/admin/plugins/datatables/vfs_fonts.js');?>"></script>
        <script src="<?php echo base_url('public/admin/plugins/datatables/buttons.html5.min.js');?>"></script>
        <script src="<?php echo base_url('public/admin/plugins/datatables/buttons.print.min.js');?>"></script>
        <script src="<?php echo base_url('public/admin/plugins/datatables/buttons.colVis.min.js');?>"></script>
        <script src="<?php echo base_url('public/admin/plugins/datatables/dataTables.responsive.min.js');?>"></script>
        <script src="<?php echo base_url('public/admin/plugins/datatables/responsive.bootstrap4.min.js');?>"></script>
        <script src="<?php echo base_url('public/admin/plugins/jquery-toastr/jquery.toast.min.js');?>" type="text/javascript"></script>
        <script src="<?php echo base_url('public/admin/js/popper.min.js');?>"></script><!-- Popper for Bootstrap -->
        <script src="<?php echo base_url('public/admin/js/bootstrap.min.js');?>"></script>
        <script src="<?php echo base_url('public/admin/js/metisMenu.min.js');?>"></script>
        <script src="<?php echo base_url('public/admin/js/waves.js');?>"></script>
        <script src="<?php echo base_url('public/admin/js/jquery.slimscroll.js');?>"></script>
        <!-- App js -->
        <script src="<?php echo base_url('public/admin/js/jquery.core.js');?>"></script>
        <script src="<?php echo base_url('public/admin/js/jquery.app.js');?>"></script>
    </body>
</html>