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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Cut/index');?>"><?php echo $page_title; ?></a></li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
           <div class="col-12">
               <div class="card-box">
                    <h4 class="m-t-0 header-title m-b-30 text-right">CUT CHALLAN</h4>
                    <h2 class="m-t-0 text-center"><?php echo FULL_NAME; ?></h2>
                    <h4 class="m-t-0 header-title text-center"><?php echo ADDRESS1; ?></h4>
                    <div class="row m-t-50">
                        <div class="col-md-5">
                          <table class="table table-borderless">
                              <tr>
                                  <th style="width:30%">M/s</th>
                                  <td> <?php echo ucwords($cut->name); ?></td>
                              </tr>
                              <tr>
                                  <th>Lot No</th>
                                  <td><?php  echo LOT.$cut->lot_no; ?></td>
                              </tr>
                              <tr>
                                  <th>Party</th>
                                  <td><?php echo ucwords($cut->party_name); ?></td>
                              </tr> 
                          </table>
                        </div>
                        <div class="offset-md-4 col-md-3">
                            <table class="table table-borderless">
                              <tr>
                                <th style="width:50%">Challan No:</th>
                                <td><?php echo $cut->challan_no;; ?></td>
                              </tr>
                              <tr>
                                <th>Date</th>
                                <td><?php echo date('d/m/Y', strtotime($cut->date)); ?></td>
                              </tr>
                              <tr>
                                  <th>Item</th>
                                  <td><?php echo ucwords($cut->item_name); ?></td>
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
                                    <th>Challan</th>
                                    <th>Mtr</th>
                                    <th>Pcs</th>
                                    <th>Mtr/pcs</th>
                                    <th>Cut Mtr</th>
                                    <th>Fent</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php $no = 1;
                                    foreach($cut_lot as $rw){?>
                                    <tr>
                                       <td><?php echo $no; ?></td>
                                       <td><?php echo $rw->challan_no; ?></td>
                                       <td><?php echo number_format($rw->p_mtr,2); ?></td>
                                       <td><?php echo $rw->pcs; ?></td>
                                       <td><?php echo number_format($rw->mtr_pr_pcs,2); ?></td>
                                       <td><?php echo number_format($rw->cut_mtr,2);?></td>
                                       <td><?php echo number_format($rw->fent,2);?></td>
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
                                  <th style="width:50%">Meter Value</th>
                                  <td> <?php echo $cut->mtr_val; ?></td>
                              </tr>
                              <tr>
                                  <th>Pcs Value</th>
                                  <td><?php echo $cut->pcs_val;?></td>
                              </tr> 
                          </table>
                        </div>
                        <div class="offset-md-4 col-md-4">
                            <table class="table">
                                <tr>
                                    <th style="width:50%">Total Meter</th>
                                    <td><?php echo $cut->purchase_mtr; ?></td>
                                </tr>
                                <tr>
                                    <th>Total Pcs</th>
                                    <td><?php echo $cut->total_pcs; ?></td>
                                </tr>
                                <tr>
                                    <th>Cut Mtr</th>
                                    <td><?php echo $cut->cut_mtr; ?></td>
                                </tr>
                                <tr>
                                    <th>Total Fent</th>
                                    <td><?php echo $cut->total_fent; ?></td>
                                </tr>
                            </table>
                        </div>
                   </div>
               </div>
           </div>
       </div>
    </div> 
</div>