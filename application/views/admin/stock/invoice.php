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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Stock/index');?>"><?php echo $page_title; ?></a></li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
           <div class="col-12">
               <div class="card-box">
                    <h4 class="m-t-0 header-title m-b-30 text-right">STOCK CHALLAN</h4>
                    <h2 class="m-t-0 text-center"><?php echo FULL_NAME; ?></h2>
                    <h4 class="m-t-0 header-title text-center"><?php echo ADDRESS1; ?></h4>
                    <div class="row m-t-50">
                        <div class="col-md-5">
                            <table class="table table-borderless">
                                <tr>
                                    <th style="width:30%">Party</th>
                                    <td> <?php echo ucwords($stock->party_name); ?></td>
                                </tr>
                                <tr>
                                    <th>Gst No </th>
                                    <td><?php  echo $stock->gst_no; ?></td>
                                </tr>
                                <tr>
                                    <th>Item</th>
                                    <td><?php echo ucwords($stock->item_name); ?></td>
                                </tr>  
                            </table>
                        </div>
                        <div class="offset-md-4 col-md-3">
                            <table class="table table-borderless">
                                <tr>
                                  <th style="width:50%">Challan No:</th>
                                  <td><?php echo $stock->challan_no;; ?></td>
                                </tr>
                                <tr>
                                  <th>Date</th>
                                  <td><?php echo date('d/m/Y', strtotime($stock->date)); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 divscroll">
                            <table class="table text-center table-bordered m-t-20 restable" cellspacing="0">
                                <thead>
                                    <tr>
                                      <th>Sr No</th>
                                      <th>Bale No</th>
                                      <th>Taka</th>
                                      <th>Meter</th>
                                      <th>Lr No</th>
                                      <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach($stockdetail as $rw){?>
                                    <tr>
                                       <td><?php echo $no++; ?></td>
                                       <td><?php echo $rw->bala_no; ?></td>
                                       <td><?php echo $rw->taka; ?></td>
                                       <td><?php echo  number_format($rw->mtr,2); ?></td>
                                       <td><?php echo $rw->lr_no; ?></td>
                                       <td><?php echo date('d/m/Y', strtotime($rw->lr_date));?></td>
                                    </tr>
                                   <?php } ?>
                                </tbody>
                          </table> 
                      </div>
                   </div>
                   <div class="row m-t-20">
                        <div class="col-md-4">
                          <table class="table">
                              <tr>
                                  <th style="width:50%">Total Taka :</th>
                                  <td> <?php echo $stock->t_bala; ?></td>
                              </tr>
                              <tr>
                                  <th>Total Meter</th>
                                  <td><?php echo number_format($stock->total_meter,2);?></td>
                              </tr> 
                          </table>
                        </div>
                        <div class="offset-md-4 col-md-4">
                            <table class="table">
                                <tr>
                                  <th style="width:50%">Subtotal:</th>
                                  <td><i class="fa fa-inr"></i> <?php echo $stock->sub_total; ?></td>
                                </tr>
                                <tr>
                                  <th>Tax (<?php echo TAX; ?>%)</th>
                                  <td><i class="fa fa-inr"></i> <?php echo $stock->tax; ?></td>
                                </tr>
                                <tr>
                                  <th>Total:</th>
                                  <td><i class="fa fa-inr"></i> <?php echo number_format($stock->g_total,2); ?></td>
                                </tr>
                            </table>
                        </div>
                   </div>
               </div>
           </div>
       </div>
    </div> 
</div>
    