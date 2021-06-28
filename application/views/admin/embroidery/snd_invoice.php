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
          .restable{
              width: 100%; 
              min-width: 720px;   
          }
          .divscroll{
              overflow-x: auto;
          }
          @media print {
              .h2-job{
                  color: white !important;
                  -webkit-print-color-adjust: exact; 
                }
              .header-title {
                font-size: 15px;
              }
          }
          .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                padding: 3px 10px
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
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="m-t-0 header-title m-b-30">DELIVERY CHALAN</h4>
                            </div>
                            <div class="col-md-6">
                                <h4 class="m-t-0 header-title m-b-30 text-right"><?php echo $embroidery->process_name;?> CHALLAN</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="border-bottom: 2px solid black;padding-bottom: 10px;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-9 text-center">
                                        <h3 class="m-b-0 m-t-0"><b><?php echo FULL_NAME; ?></b></h3>
                                    </div>
                                    <div class="col-3">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-9">
                                        <p class="m-b-0 text-center"><?php echo COM_HEADER; ?></p>
                                    </div>
                                    <div class="col-3">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-9">
                                        <p class="m-b-0  text-center"><?php echo ADDRESS2; ?></p>
                                    </div>
                                    <div class="col-3">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-top: 9px;">
                                <div class="row">
                                    <div class="col-8 text-right">
                                        <h4 class="m-t-0 header-title"><b>Gst No :</b></h4>
                                    </div>
                                    <div class="col-4">
                                        <h4 class="m-t-0 header-title"><?php echo GST_NO; ?></h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8  text-right">
                                        <h4 class="m-t-0 header-title"><b>Pan No :</b></h4>
                                    </div>
                                    <div class="col-4">
                                        <h4 class="m-t-0 header-title"><?php echo PAN_NO; ?></h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8  text-right">
                                        <h4 class="m-t-0 header-title"><b>Mobile :</b></h4>
                                    </div>
                                    <div class="col-4">
                                        <h4 class="m-t-0 header-title"><?php echo MOBILE; ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 m-t-20">
                        <div class="row">
                            <div class="col-md-5">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                          <th style="width:30%">M/S</th>
                                          <td> <?php echo $embroidery->name; ?></td>
                                        </tr>
                                        <tr>
                                            <th>PARTY</th>
                                            <td><?php echo $party->srt_name; ?></td>
                                        </tr>
                                        <tr>
                                          <th style="width:30%">ADDRESS</th>
                                          <td> <?php echo strtoupper($embroidery->address); ?></td>
                                        </tr>
                                        <tr>
                                            <th>GST NO</th>
                                            <td><?php echo $party->gst_number; ?></td>
                                        </tr>  
                                  </tbody>
                              </table>
                            </div>
                            <div class="offset-md-4 col-md-3">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                          <th style="width:50%">INVOICE NO</th>
                                          <td> <?php echo $embroidery->challan_no; ?></td>
                                        </tr>
                                        <tr>
                                            <th>DATE</th>
                                            <td><?php echo date('d/m/Y', strtotime($embroidery->date)); ?></td>
                                        </tr>
                                        <tr>
                                            <th>VEHICLE </th>
                                            <td><?php echo $embroidery->vahicle; ?></td>
                                        </tr>
                                        <tr>
                                            <th>VEHICLE NO</th>
                                            <td><?php echo $embroidery->vahicle_no; ?></td>
                                        </tr>    
                                  </tbody>
                              </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 divscroll">
                        <table class="table text-center table-bordered restable" width="100%">
                            <thead>
                            <tr>
                                <th class="header-title">SR NO</th>
                                <th class="header-title">DESIGN</th>
                                <th class="header-title">COLOR</th>
                                <th class="header-title">PCS</th>
                                <th class="header-title">G SAREE</th>
                                <th class="header-title">M PCS</th>
                                <th class="header-title">MACHINE DMG</th>
                                <th class="header-title">PATLA</th>
                                <th class="header-title">E NAME</th> 
                                <th class="header-title">FPCS</th>
                                <th class="header-title">RATE</th>
                                <th class="header-title">TOTAL</th>
                              </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach ($embroidery_lot as $key => $value): ?> 
                                <tr>
                                   <td class="header-title"><?php echo $i;?></td>
                                   <td class="header-title"><?php echo $value->design_no; ?></td>
                                   <td class="header-title"><?php echo $value->color; ?></td>
                                   <td class="header-title"><?php echo $value->pcs; ?></td>
                                   <td class="header-title"><?php echo $value->ghat_saree; ?></td>
                                   <td class="header-title"><?php echo $value->m_pcs; ?></td>
                                   <td class="header-title"><?php echo $value->machine_dmg; ?></td>
                                   <td class="header-title"><?php echo $value->patla_name;?></td>
                                   <td class="header-title"><?php echo $value->em_name; ?></td>
                                   <td class="header-title"><?php echo $value->f_pcs; ?></td>
                                   <td class="header-title"><?php echo number_format($value->rate,2); ?></td>
                                   <td class="header-title"><?php echo number_format($value->total,2); ?></td>
                                </tr>
                                <?php $i++; endforeach; ?>
                            </tbody>
                      </table>        
                   </div>
                   <div class="row m-t-20" style=" border-bottom: 1px solid black;">
                        <div class="col-md-6">
                          <table class="table custom-table m-b-0">
                              <tr>
                                  <th style="width:50%">LOT NO </th>
                                  <td><?php echo LOT.$embroidery->lot_no; ?></td>
                              </tr>
                              <tr>
                                  <th style="width:50%">M PCS </th>
                                  <td><?php echo $embroidery->t_missprint; ?></td>
                              </tr>
                              <tr>
                                  <th style="width:50%">GHAT SAREE</th>
                                  <td><?php echo $embroidery->t_ghatsaree; ?></td>
                              </tr>
                          </table>
                          <div class="offset-md-2 col-md-8 m-t-20" style="border: 1px solid black;">
                              <table width="100%" >
                                  <tbody>
                                      <tr>
                                          <td width="60%" style="padding-left:5px;">Input Good Value</td>
                                          <td><?php $val1= $balance->process_val*$embroidery->t_pcs; echo number_format($val1,2);?></td>
                                      </tr>
                                      <tr>
                                          <td width="60%" style="padding-left:5px;">Job Work Value</td>
                                          <td width="30%" style="border-bottom: 1px solid black;"><?php $val2=$embroidery->g_total; echo number_format($val2,2); ?></td>
                                      <td width="10%"></td>
                                      </tr>
                                      <tr>
                                          <td width="60%" style="padding-left:5px;">Total Value</td>
                                          <td><?php echo number_format($val1+$val2,2); ?></td>
                                      </tr>
                                  </tbody>
                              </table>
                          </div>
                        </div>
                        <div class="offset-md-2 col-md-4">
                            <table class="table custom-table">
                                <tr>
                                    <th style="width:50%">TOTAL DESIGN</th>
                                    <td><?php echo $embroidery->t_design; ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">TOTAL PCS</th>
                                    <td><?php echo $embroidery->t_pcs; ?></td>
                                </tr>
                                <tr>
                                    <th style="width:50%">MACHINE DMG</th>
                                    <td><?php echo $embroidery->t_machinedmg; ?></td>
                                </tr>
                                <tr>
                                    <th>SUB TOTAL</th>
                                    <td><i class="fa fa-inr"></i> <?php echo number_format($embroidery->sub_total,2); ?></td>
                                </tr>
                                <tr>
                                    <th>SGST <?php echo TAX/2; ?>%</th>
                                    <td><i class="fa fa-inr"></i> <?php echo number_format($embroidery->tax/2,2); ?></td>
                                </tr>
                                <tr>
                                    <th>CGST <?php echo TAX/2; ?>%</th>
                                    <td><i class="fa fa-inr"></i>  <?php echo number_format($embroidery->tax/2,2); ?></td>
                                </tr>
                                <tr>
                                    <th>GRAND TOTAL</th>
                                    <td><i class="fa fa-inr"></i> <?php echo number_format(round($embroidery->g_total),2); ?></td>
                                </tr>
                            </table>
                        </div>
                   </div>
                   <div class="col-md-12">
                      <div class="row">
                          <div class="col-md-6">
                              <p class="text-uppercase">FOR. <?php echo SUBJECT; ?></p>
                          </div>
                          <div class="col-md-6 text-right">
                              <p>FOR. <?php echo FULL_NAME; ?></p>
                              <p class="text-uppercase" style="margin-right: 25px;">Authorised Sign</p>
                          </div>
                      </div>
                   </div>
               </div>
           </div>
       </div>
    </div> 
</div>
<script type="text/javascript">
</script> 
               