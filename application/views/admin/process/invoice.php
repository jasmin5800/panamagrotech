<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left"><?php echo $page_title; ?></h4>
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Dashbord');?>"><?php echo COMPANY; ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Devide/index');?>"><?php echo $page_title; ?></a></li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <style type="text/css">
          .table-borderless > tbody > tr > td, .table-borderless > tbody > tr > th, .table-borderless > tfoot > tr > td, .table-borderless > tfoot > tr > th, .table-borderless > thead > tr > td, .table-borderless > thead > tr > th {
            padding: 7px 8px;
          }
          @media print {
              .h2-job{
                  color: white !important;
                  -webkit-print-color-adjust: exact; 
                }
              .header-title {
                font-size: 17px;
              }
          }
          .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                padding: 7px 10px;
          }
          @media print {
             .table thead th {
                 border: 1px solid #0c0c0c !important;
               }
              .table-bordered td, .table-bordered th {
                  border: 1px solid #0c0c0c !important;
              }
              .table thead th {
                  border: 1px solid #0c0c0c !important;
                }
              .table-bordered td, .table-bordered th {
                   border: 1px solid #0c0c0c !important;
              }
          }
          .custom-table > tbody > tr > td, .custom-table > tbody > tr > th, .custom-table > tfoot > tr > td, .custom-table > tfoot > tr > th, .custom-table > thead > tr > td, .custom-table > thead > tr > th {
              font-size: 18px;
          }
        </style>
        <div class="row">
           <div class="col-12">
               <div class="card-box">
                    <div class="col-md-12">
                        <table width="100%">
                            <tbody>
                              <tr>
                                  <td style="width: 66%">
                                    <h1 class="h2-job text-center"><span class="bg-dark text-white" style="padding: 0 20px;"><?php  echo strtoupper($process->process_name); ?>  JOB WORK</span></h1>
                                  </td>
                                  <td style="width: 34%">
                                    <h3 class="m-b-0"><b><?php echo FULL_NAME; ?></b></h3>
                                    <h4 class="m-b-1 header-title"><?php echo ADDRESS2; ?></h4>
                                    <h4 class="m-t-0 header-title"><b>Gst No.  : </b><?php echo GST_NO; ?></h4>
                                    <h4 class="m-t-0 header-title">Mo.: <?php echo MOBILE; ?></h4>
                                  </td>
                              </tr>         
                          </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td style="width: 12%">
                                      <h4 class="header-title m-t-0"><b> M/S :</b> </h4>
                                    </td>
                                    <td colspan="2" style="width: 88%; border-bottom: 1px solid black;">
                                      <h4 class="header-title m-t-0"> <?php echo $process->name; ?></h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 12% padding-top: 10px;">
                                      <h4 class="header-title m-t-0"><b> ADDRESS :</b></h4>
                                    </td>
                                    <td colspan="2" class="td-border" style="width: 88%; border-bottom: 1px solid black;  padding-top: 10px; ">
                                      <h4 class="header-title m-t-0"><?php echo $process->address; ?> </h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12 m-t-20">
                        <table width="100%">
                            <tbody>
                                <tr>
                                    <td style="width: 40% ">
                                      <h4 class="header-title m-t-0"> <b>Lot No.</b> : <?php echo LOT.$process->lot_no; ?> </h4>
                                    </td>
                                    <td style="width: 35% ">
                                      <h4 class="header-title m-t-0"> <b> HSN CODE </b>:    <?php echo " ".HSN; ?> </h4>
                                    </td>
                                    <td style="width: 25% ">
                                      <h4 class="header-title m-t-0"> <b> Vehicle </b>: <?php echo $process->vahicle; ?> </h4>
                                    </td>           
                                </tr>
                                <tr>
                                    <td style="width: 33% " class="td-p">
                                      <h4 class="header-title m-t-0"> <b>Challan No.</b> :  <?php echo $process->challan_no; ?></h4>
                                    </td>
                                    <td style="width: 33% " class="td-p">
                                      <h4 class="header-title m-t-0"> <b>Date.</b> :   <?php echo date('d/m/Y', strtotime($process->date)); ?></h4>
                                    </td>
                                    <td style="width: 34% " class="td-p">
                                      <h4 class="header-title m-t-0"> <b>Vehicle No.</b> : <?php echo $process->vahicle_no; ?> </h4>
                                    </td>           
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <table class="table text-center table-bordered m-t-20" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th class="header-title">SR NO</th>
                                <th class="header-title">DESIGN</th>
                                <th class="header-title">COLOR</th>
                                <th class="header-title">PATLA</th>
                                <th class="header-title">PCS</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach ($process_lot as $key => $value): ?> 
                                <tr>
                                   <td class="header-title"><?php echo $i;?></td>
                                   <td class="header-title"><?php echo $value->design_no; ?></td>
                                   <td class="header-title"><?php echo $value->color; ?></td>
                                   <td class="header-title"><?php echo $value->patla_name;?></td>
                                   <td class="header-title"><?php echo $value->pcs; ?></td>
                                </tr>
                                <?php $i++; endforeach; ?>
                                <tr>
                                   <td colspan="4"  class="header-title">TOTAL PCS</td>
                                   <td class="header-title"><?php echo $process->t_pcs;?></td>
                                </tr>
                            </tbody>
                      </table>        
                   </div>
                   <div class="row m-t-20">
                        <div class="col-md-6">
                          <table class="table custom-table">
                              <tr>
                                  <th style="width:50%">OWNER OF GOOD </th>
                                  <td><?php echo strtoupper($party->srt_name) ?></td>
                              </tr>
                              <tr>
                                  <th>REMARK </th>
                                  <td></td>
                              </tr> 
                          </table>
                        </div>
                        <div class="offset-md-2 col-md-4">
                            <table class="table custom-table">
                                <tr>
                                    <th style="width:50%">TOTAL PCS</th>
                                    <td><?php echo $process->t_pcs; ?></td>
                                </tr>
                                <tr>
                                    <th>SUB TOTAL</th>
                                    <td><i class="fa fa-inr"></i> <?php echo number_format($subtotal,2); ?></td>
                                </tr>
                                <tr>
                                    <th>SGST <?php echo TAX/2; ?>%</th>
                                    <td><i class="fa fa-inr"></i> <?php echo number_format($sgst,2); ?></td>
                                </tr>
                                <tr>
                                    <th>CGST <?php echo TAX/2; ?>%</th>
                                    <td><i class="fa fa-inr"></i>  <?php echo number_format($cgst,2); ?></td>
                                </tr>
                                <tr>
                                    <th>GRAND TOTAL</th>
                                    <td><i class="fa fa-inr"></i> <?php echo number_format(round($g_total),2); ?></td>
                                </tr>
                            </table>
                        </div>
                   </div>
               </div>
           </div>
       </div>
    </div> 
</div>
               