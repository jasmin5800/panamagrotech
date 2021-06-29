  <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title float-left"><?php echo $page_title;?></h4>
                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('Dashbord'); ?>"><?php echo COMPANY; ?></a></li>
                            <li class="breadcrumb-item"><a href="#"><?php echo $page_title;?></a></li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <?php 
            $city_code=((isset($party->city_code) && !empty($party->city_code))?" - ".$party->city_code : "");
            $state_code=((isset($party->state_code) && !empty($party->state_code))?" - ".$party->state_code :"");
            ?>
            <div class="row">
               <div class="col-md-12 border-dark">
                   <div class="card-box">
                      <div class="row">
                          <div class="col-md-12 table-responsive" style="margin-bottom: 0px;">
                            <style type="text/css">
                                @media print {
                                   .table thead th {
                                        border: 1px solid #0c0c0c !important;
                                    }
                                    .table-bordered td, .table-bordered th {
                                        border: 1px solid #0c0c0c !important;
                                    }
                                    .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                                      padding: 6px 10px;
                                    }
                                  }
                                    .table thead th {
                                      border: 1px solid #0c0c0c !important;
                                    }
                                    .table-bordered td, .table-bordered th {
                                      border: 1px solid #0c0c0c !important;
                                    }
                                    .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                                      padding: 6px 10px;
                                    }
                                    h4,h5{
                                      margin: 0px;
                                    }
                            </style>
                            <style type="text/css">
                            </style>
                            <table class="table table-bordered " style="margin: 30px 0;">
                                 <thead>
                                    <tr>
                                        <th colspan="3" >
                                          <div class="row">
                                            
                                            <div class="col-md-12" style="text-align: center; ">
                                              <h2 >OM CASTING</h2>
                                              <h5 ><?php echo "ESTIMATE"; ?></h5>
                                            </div>
                                          </div>
                                              
                                        </th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                        <td colspan="3" class="text-right"><h5>ORIGINAL</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Party : <?php echo $party->name; ?></h5></td>
                                        <td><h5>No : <?php echo "A/".$p_invoice->invoice_no; ?></h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Address : <?php echo $party->city_name; ?></h5></td>
                                        <td rowspan="2"><h5>Date : <?php echo date('d/m/Y', strtotime($p_invoice->date)); ?> </h5></td>
                                    </tr>
                                    
                                 </tbody>
                            </table>
                          </div>
                          <div class="col-md-12 table-responsive" style="margin-top: 0px;">
                              <table class="table table-bordered text-center">
                                  <thead>
                                      <tr>
                                          <th colspan="13"><h4>ITEMS</h4></th>                                       
                                      </tr>
                                      <tr>
                                          <th>No.</th>
                                          <th>ITEM</th>
                                          <th>GR.WT.</th>
                                          <!-- <th>BADLO.</th>
                                         <th>TF</th> -->
                                          <th>FINE</th>
                                          <th>AMOUNT</th>
                                      </tr>                                  
                                  </thead>
                                  <tbody>
                                  <?php $i=1; foreach ($r_item as $r_item): ?>                                      
                                      <tr>
                                          <td><?php echo $i; ?></td>
                                          <td><?php  echo $r_item->item_name; ?></td>
                                          <td><?php $gr_weight[]=$r_item->gr_weight; echo $r_item->gr_weight; ?></td>
                                          <!-- <td><?php echo $r_item->badlo; ?></td>
                                         <td><?php echo $r_item->tf; ?></td>  -->
                                          <td><?php $fine[]=$r_item->fine; echo $r_item->fine; ?></td>
                                          <td><?php $amount[]=$r_item->amount; echo $r_item->amount; ?></td>
                                      </tr>
                                  <?php $i++; endforeach; ?>
                                      <tr>
                                          <td style="height: 250px;"></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>                                          
                                          <td></td>
                                      </tr>
                                      <tr>
                                          <td colspan="2" class="text-center">TOTAL</td>
                                          <td><?php echo array_sum($gr_weight); ?></td>
                                                                            
                                          <td><?php echo array_sum($fine); ?></td>
                                          <td><?php echo array_sum($amount); ?></td>  
                                      </tr>
                                      <!-- <tr>
                                          <td colspan="3" class="text-right"></td>
                                          <td colspan="2" class="text-center"><h5>Previous Balance</h5><br><h5>Closing Balance</h5></td>
                                          <td colspan=""><h5><?php echo number_format($p_invoice->p_fine,0)." ".strtoupper($p_invoice->status_pfine);?></h5><br><h5><?php echo number_format($p_invoice->c_fine,0)." ".strtoupper($p_invoice->status_cfine);?></h5></td>
                                          <td colspan=""><h5><?php echo number_format($p_invoice->p_rs,0)." ".strtoupper($p_invoice->status_prs);?></h5><br><h5><?php echo number_format($p_invoice->c_rs,0)." ".strtoupper($p_invoice->status_crs);?></h5></td>
                                      </tr>   
                                                                         -->
                                        <tr> <td class="text-left" colspan="7"><?php echo "Remark : ".$p_invoice->remark; ?></td>  </tr> 
                                         <tr> <td style="height: 60px;" class="text-right" colspan="7"><?php echo "For, OM CASTING"; ?> </td>  </tr>
                                  </tbody>
                              </table>
                          </div>
                      </div>
                   </div>
               </div>     
               <div class="col-md-12 border-dark">
                   <div class="card-box">
                      <div class="row">
                          <div class="col-md-12 table-responsive" style="margin-bottom: 0px;">
                            <style type="text/css">
                                @media print {
                                   .table thead th {
                                        border: 1px solid #0c0c0c !important;
                                    }
                                    .table-bordered td, .table-bordered th {
                                        border: 1px solid #0c0c0c !important;
                                    }
                                    .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                                      padding: 6px 10px;
                                    }
                                  }
                                    .table thead th {
                                      border: 1px solid #0c0c0c !important;
                                    }
                                    .table-bordered td, .table-bordered th {
                                      border: 1px solid #0c0c0c !important;
                                    }
                                    .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                                      padding: 6px 10px;
                                    }
                                    h4,h5{
                                      margin: 0px;
                                    }
                            </style>
                            <style type="text/css">
                            </style>
                            <table class="table table-bordered " style="margin: 30px 0;">
                                 <thead>
                                    <tr>
                                        <th colspan="3" >
                                          <div class="row">
                                            
                                            <div class="col-md-12" style="text-align: center; ">
                                              <h2 >OM CASTING</h2>
                                              <h5 ><?php echo "ESTIMATE"; ?></h5>
                                            </div>
                                          </div>
                                              
                                        </th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                        <td colspan="3" class="text-right"><h5>DUPLICATE</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Party : <?php echo $party->name; ?></h5></td>
                                        <td><h5>No : <?php echo "A/".$p_invoice->invoice_no; ?></h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Address : <?php echo $party->city_name; ?></h5></td>
                                        <td rowspan="2"><h5>Date : <?php echo date('d/m/Y', strtotime($p_invoice->date)); ?> </h5></td>
                                    </tr>
                                    
                                 </tbody>
                            </table>
                          </div>
                          
                          <div class="col-md-12 table-responsive" style="margin-top: 0px;">
                              <table class="table table-bordered text-center">
                                  <thead>
                                      <tr>
                                          <th colspan="13"><h4>ITEMS</h4></th>                                       
                                      </tr>
                                      <tr>
                                      <th>No.</th>
                                          <th>ITEM</th>
                                          <th>GR.WT.</th>
                                          <!-- <th>BADLO.</th>
                                          <th>TF</th> -->
                                          <th>FINE</th>
                                          <th>AMOUNT</th>
                                      </tr>                                  
                                  </thead>
                                  <tbody>
                                  <?php $i=1; foreach ($r_item1 as $r_item): ?>                                      
                                      <tr>
                                          <td><?php echo $i; ?></td>
                                          <td><?php  echo $r_item->item_name; ?></td>
                                          <td><?php $gr_weight1[]=$r_item->gr_weight; echo $r_item->gr_weight; ?></td>
                                          <!-- <td><?php echo $r_item->badlo; ?></td>
                                          <td><?php echo $r_item->tf; ?></td> -->
                                          <td><?php $fine1[]=$r_item->fine; echo $r_item->fine; ?></td>
                                          <td><?php $amount1[]=$r_item->amount; echo $r_item->amount; ?></td>
                                      </tr>
                                  <?php $i++; endforeach; ?>
                                      <tr>
                                      <td style="height: 250px;"></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>                                          
                                          <td></td>
                                      </tr>
                                      <tr>
                                          <td colspan="2" class="text-center">TOTAL</td>
                                          <td><?php echo array_sum($gr_weight1); ?></td>
                                                                                  
                                          <td><?php echo array_sum($fine1); ?></td>
                                          <td><?php echo array_sum($amount1); ?></td>  
                                      </tr>
                                      <tr> <td class="text-left" colspan="7"><?php echo "Remark : ".$p_invoice->remark; ?></td>  
                                       <tr> <td style="height: 60px;" class="text-right" colspan="7"><?php echo "For, OM CASTING"; ?> </td>  </tr>
                                      </tr>
                                      <!-- <tr>
                                          <td colspan="3" class="text-right"></td>
                                          <td colspan="2" class="text-center"><h5>Previous Balance</h5><br><h5>Closing Balance</h5></td>
                                          <td colspan=""><h5><?php echo number_format($p_invoice->p_fine,0)." ".strtoupper($p_invoice->status_pfine);?></h5><br><h5><?php echo number_format($p_invoice->c_fine,0)." ".strtoupper($p_invoice->status_cfine);?></h5></td>
                                          <td colspan=""><h5><?php echo number_format($p_invoice->p_rs,0)." ".strtoupper($p_invoice->status_prs);?></h5><br><h5><?php echo number_format($p_invoice->c_rs,0)." ".strtoupper($p_invoice->status_crs);?></h5></td>
                                      </tr>                                      -->
                                  </tbody>
                              </table>
                          </div>
                      </div>
                   </div>
               </div>           
            </div>
        </div> 
    </div> 
               