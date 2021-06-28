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
                                <h4 class="m-t-0 header-title m-b-30 text-right"><?php echo $packing->process_name;?> CHALLAN</h4>
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
                            </div>
                            <div class="col-md-6" style="margin-top: 9px;">
                                <div class="row">
                                    <div class="col-3  text-right">
                                        <h4 class="m-t-0 header-title"><b>Invoice No :</b></h4>
                                    </div>
                                    <div class="col-3">
                                        <h4 class="m-t-0 header-title"><?php echo $packing->challan_no; ?></h4>
                                    </div>
                                    <div class="col-3 text-right">
                                        <h4 class="m-t-0 header-title"><b>LOT NO : </b></h4>
                                    </div>
                                    <div class="col-3">
                                        <h4 class="m-t-0 header-title"><?php echo  LOT.$packing->lot_no; ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 divscroll m-t-20">
                        <table class="table text-center table-bordered restable" width="100%">
                            <thead>
                            <tr>
                                <th class="header-title" width="5%">SR NO</th>
                                <th class="header-title">DESIGN</th>
                                <th class="header-title">COLOR</th>
                                <th class="header-title">PCS</th>
                                <th class="header-title">GHAT SHREE</th>
                                <th class="header-title">M PCS</th>
                                <th class="header-title">PATLA</th>
                                <th class="header-title">E NAME</th>
                                <th width="23%"></th>
                                <th width="23%"></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php if(isset($packing_lot) && !empty($packing_lot)): ?>
                                <?php $i=1; foreach ($packing_lot as $key => $value): ?> 
                                <tr>
                                   <td class="header-title"><?php echo $i;?></td>
                                   <td class="header-title"><?php echo $value->design_no; ?></td>
                                   <td class="header-title"><?php echo $value->color; ?></td>
                                   <td class="header-title"><?php $pcs[]=$value->pcs; echo $value->pcs; ?></td>
                                   <td class="header-title"><?php $ghat_saree[]=$value->ghat_saree; echo $value->ghat_saree; ?></td>
                                   <td class="header-title"><?php $m_pcs[]=$value->m_pcs; echo $value->m_pcs; ?></td>
                                   <td class="header-title"><?php echo $value->patla_name;?></td>
                                   <td class="header-title"><?php echo $value->em_name;?></td>
                                   <td class="header-title"></td>
                                   <td class="header-title"></td>
                                </tr>
                                <?php $i++; endforeach; ?>
                                <tr style="height: 20px;">
                                  <td class="header-title text-center" colspan="3">TOTAL</td>
                                  <td class="header-title"><?php echo array_sum($pcs); ?></td>
                                  <td class="header-title"><?php echo array_sum($ghat_saree); ?></td>
                                  <td class="header-title"><?php echo array_sum($m_pcs); ?></td>
                                  <td class="header-title" colspan="4"></td>
                                </tr>
                              <?php endif; ?>
                            </tbody>
                      </table>        
                   </div>
               </div>
           </div>
       </div>
    </div> 
</div>
<script type="text/javascript">
</script> 
               