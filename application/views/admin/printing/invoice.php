<style type="text/css">
  .restable{
      width: 100%; 
      min-width: 720px;   
  }
  .divscroll{
      overflow-x: auto;
  }
  .table-borderless > tbody > tr > td, .table-borderless > tbody > tr > th, .table-borderless > tfoot > tr > td, .table-borderless > tfoot > tr > th, .table-borderless > thead > tr > td, .table-borderless > thead > tr > th {
    padding: 7px 8px;
  }
</style>
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
               <div class="card-box">
                    <h4 class="m-t-0 header-title m-b-30 text-right">Printing CHALLAN</h4>
                    <h2 class="m-t-0 text-center"><?php echo FULL_NAME; ?></h2>
                    <h4 class="m-t-0 header-title text-center"><?php echo ADDRESS1; ?></h4>
                    <div class="row m-t-50">
                        <div class="col-md-5">
                          <table class="table table-borderless">
                              <tr>
                                  <th style="width:30%">Challan No</th>
                                  <td> <?php echo $printing->challan_no; ?></td>
                              </tr>
                              <tr>
                                  <th>Lot No</th>
                                  <td><?php  echo LOT.$printing->lot_no; ?></td>
                              </tr>
                          </table>
                        </div>
                        <div class="offset-md-4 col-md-3">
                            <table class="table table-borderless">
                              <tr>
                                <th>Date</th>
                                <td><?php echo date('d/m/Y', strtotime($printing->date)); ?></td>
                              </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 divscroll">
                          <table class="table text-center table-bordered m-t-20 restable">
                            <thead>
                            <tr>
                                <th>Sr No</th>
                                <th>Design No</th>
                                <th>Color</th>
                                <th>Pcs</th>
                                <th>Miss Print</th>
                                <th>Patla Name</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $no = 1;
                                foreach($printing_lot as $rw){?>
                                <tr>
                                   <td><?php echo $no; ?></td>
                                   <td><?php echo $rw->design_no; ?></td>
                                   <td><?php echo $rw->color; ?></td>
                                   <td><?php echo $rw->pcs; ?></td>
                                   <td><?php echo $rw->miss_pcs; ?></td>
                                   <td><?php echo $rw->patla_name;?></td>
                                </tr>
                               <?php $no++; } ?>
                            </tbody>
                        </table>
                      </div>        
                   </div>
                   <div class="row m-t-20">
                        <div class="col-md-4">
                          <table class="table">
                              <tr>
                                  <th style="width:50%">Total Design</th>
                                  <td> <?php echo $printing->t_design; ?></td>
                              </tr>
                              <tr>
                                  <th style="width:50%"></th>
                                  <td></td>
                              </tr>
                          </table>
                        </div>
                        <div class="offset-md-4 col-md-4">
                            <table class="table">
                                <tr>
                                    <th style="width:50%">Miss Print</th>
                                    <td><?php echo $printing->t_missprint; ?></td>
                                </tr>
                                <tr>
                                    <th>Total Pcs</th>
                                    <td><?php echo $printing->t_pcs;?></td>
                                </tr>
                                <tr>
                                    <th>Cloth Value</th>
                                    <td><?php echo number_format($printing->cloth_value,2);?></td>
                                </tr>
                                <tr>
                                    <th>Sub Total</th>
                                    <td><?php echo number_format($printing->sub_total,2); ?></td>
                                </tr>
                                <tr>
                                    <th>Tax (<?php echo TAX;?>%)</th>
                                    <td><?php echo number_format($printing->tax,2); ?></td>
                                </tr>
                                <tr>
                                    <th>Total Fent</th>
                                    <td><?php echo number_format($printing->g_total,2); ?></td>
                                </tr>
                            </table>
                        </div>
                   </div>
               </div>
           </div>
       </div>
    </div> 
</div>
               