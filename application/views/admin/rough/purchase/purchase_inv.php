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
                            <table class="table table-bordered ">
                                 <thead>
                                    <tr>
                                        <th colspan="3" >
                                          <div class="row">
                                            <div class="col-md-4 text-right" >
                                              <img src="<?php echo base_url('assets/admin/images/gurukrupa-b.png')?>" height="100" >
                                            </div>
                                            <div class="col-md-8" style="text-align: justify; ">
                                              <h2 style="position: absolute; top: 40%;transform: translate(0, -50%);">SHREE GURUKRUPA SILVER</h2>
                                              <h5 style="position: absolute;top: 80%;left: 9%;transform: translate(0, -50%);"><?php echo ADDRESS1; ?></h5>
                                            </div>
                                          </div>
                                              
                                        </th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <tr>
                                        <td colspan="3" class="text-right"><h5>PURCHASE</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Party</h5></td>
                                        <td><h5><?php echo $party->name; ?></h5></td>
                                        <td><h5>Bill No : <?php echo $p_invoice->invoice_no; ?></h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Address</h5></td>
                                        <td><h5><?php echo $party->address.", ".$party->city_name.$city_code.", ".$party->state_name.$state_code; ?></h5></td>
                                        <td rowspan="2"><h5>Date : <?php echo date('d/m/Y', strtotime($p_invoice->date)); ?> </h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Mo.</h5></td>
                                        <td><h5><?php echo $party->mobile; ?></h5></td>
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
                                          <th>#</th>
                                          <th>ITEM</th>
                                          <th>GR.WT.</th>
                                          <th>BAG WT.</th>
                                          <th>NET WT.</th>
                                          <th>GHAT</th>
                                          <th>TTL WT</th>
                                          <th>TOUNCH</th>
                                          <th>WASTAGE</th>
                                          <th>FINE</th>
                                          <th>NOS</th>
                                          <th>RATE</th>
                                          <th>AMOUNT</th>
                                      </tr>                                  
                                  </thead>
                                  <tbody>
                                  <?php $i=1; foreach ($r_item as $r_item): ?>                                      
                                      <tr>
                                          <td><?php echo $i; ?></td>
                                          <td><?php  echo $r_item->item_name; ?></td>
                                          <td><?php $gr_weight[]=$r_item->gr_weight; echo $r_item->gr_weight; ?></td>
                                          <td><?php $bag_weight[]=$r_item->bag_weight;  echo $r_item->bag_weight; ?></td>
                                          <td><?php $n_weight[]=$r_item->n_weight; echo $r_item->n_weight; ?></td>
                                          <td><?php $ghat[]=$r_item->ghat; echo $r_item->ghat; ?></td>
                                          <td><?php $ttl_weight[]=$r_item->ttl_weight; echo $r_item->ttl_weight; ?></td>
                                          <td><?php echo $r_item->touch; ?></td>
                                          <td><?php echo $r_item->wastage; ?></td>
                                          <td><?php $fine[]=$r_item->fine; echo $r_item->fine; ?></td>
                                          <td><?php echo $r_item->nos; ?></td>
                                          <td><?php echo $r_item->rate; ?></td>
                                          <td><?php $amount[]=$r_item->amount; echo $r_item->amount; ?></td>
                                      </tr>
                                  <?php $i++; endforeach; ?>
                                      <tr>
                                          <td style="height: 50px;"></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>                                          
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                          <td></td>
                                      </tr>
                                      <tr>
                                          <td colspan="2" class="text-center">TOTAL</td>
                                          <td><?php echo array_sum($gr_weight); ?></td>
                                          <td><?php echo array_sum($bag_weight); ?></td> 
                                          <td><?php echo array_sum($n_weight); ?></td>
                                          <td><?php echo array_sum($ghat); ?></td>
                                          <td><?php echo array_sum($ttl_weight); ?></td>  
                                          <td colspan="2"></td>                                         
                                          <td><?php echo array_sum($fine); ?></td>
                                          <td colspan="2"></td>
                                          <td><?php echo array_sum($amount); ?></td>  
                                      </tr>
                                      <tr>
                                          <td colspan="7" class="text-right"></td>
                                          <td colspan="2" class="text-center"><h5>Previous Balance</h5><br><h5>Closing Balance</h5></td>
                                          <td colspan=""><h5><?php echo number_format($p_invoice->p_fine,0)." ".strtoupper($p_invoice->status_pfine);?></h5><br><h5><?php echo number_format($p_invoice->c_fine,0)." ".strtoupper($p_invoice->status_cfine);?></h5></td>
                                          <td colspan="2"></td>
                                          <td colspan=""><h5><?php echo number_format($p_invoice->p_rs,0)." ".strtoupper($p_invoice->status_prs);?></h5><br><h5><?php echo number_format($p_invoice->c_rs,0)." ".strtoupper($p_invoice->status_crs);?></h5></td>
                                      </tr>                                     
                                  </tbody>
                              </table>
                          </div>
                      </div>
                   </div>
               </div>               
            </div>
        </div> 
    </div> 
               