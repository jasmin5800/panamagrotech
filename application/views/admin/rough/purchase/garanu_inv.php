  <style>
  h5{
    font-size:20px;
  }
  </style>
  <div class="content">
        <div class="container-fluid" style="font-size: 20px;">
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
                                 
                                 <tbody>
                                    <tr>
                                        <td colspan="3" class="text-center"><h5>GARANU</h5></td>
                                    </tr>
                                    <tr>
                                        <td><h5>PARTY : <?php echo $party->name; ?></h5></td>
                                        <td><h5>DATE : <?php echo date('d/m/Y', strtotime($p_invoice->date)); ?> </h5></td>
                                  </tr>
                                    <tr>
                                          </tr>
                                    
                                 </tbody>
                            </table>
                          </div>
                          <div class="col-md-12 table-responsive" style="margin-top: 0px;">
                              <table class="table table-bordered text-center">
                                  <thead>
                                      <tr>
                                          <th>No.</th>
                                          <th>ITEM</th>
                                          <th>GR.WT.</th>
                                          <th>TOUCH.</th>
                                          <th>FINE</th>
                                      </tr>                                  
                                  </thead>
                                  <tbody>
                                  <?php $i=1; foreach ($r_item as $r_item): ?>                                      
                                      <tr>
                                          <td><?php echo $i; ?></td>
                                          <td><?php  echo $r_item->item_name; ?></td>
                                          <td><?php $gr_weight[]=$r_item->weight; echo $r_item->weight; ?></td>
                                          <td><?php echo $r_item->touch; ?></td>
                                          <td><?php $fine[]=$r_item->fine; echo $r_item->fine; ?></td>
                                      </tr>
                                  <?php $i++; endforeach; ?>
                                     
                                      <tr>
                                          <td colspan="2" class="text-center">TOTAL</td>
                                          <td><?php echo array_sum($gr_weight); ?></td>
                                          <td colspan="1"></td>                                         
                                          <td><?php echo array_sum($fine); ?></td>
                                      </tr>

                                      </tbody>
                                        </table>
                                        <div class="row">
                                       
                                        <div class="col-md-6 text-right">
                                      
                                      <table  class=" table table-bordered text-center">
                                       <tr>
                                           
                                          <td class="text-center"><H5>FINE</H5></td>
                                          <td colspan=""><H5><?php echo $p_invoice->fine1;?></h5></td>
                                          <td class="text-center">COPPER F</td>
                                          <td colspan=""><?php echo $p_invoice->copper_f2;?></h5></td>
                                     </tr> 
                                      
                                         <tr>
                                        
                                          <td class="text-center"><H5>M TOUCH</H5></td>
                                          <td colspan=""><H5><?php echo $p_invoice->m_touch1;?></h5></td>
                                          <td class="text-center">FINE</td>
                                          <td colspan=""><?php echo $p_invoice->fine2;?></h5></td>
                                         </tr>

                                          <tr>
                                         
                                          <td class="text-center">R GARANU</td>
                                          <td colspan=""><?php echo $p_invoice->r_garanu;?></h5></td>
                                            <td class="text-center">TOTAL F</td>
                                          <td colspan=""><?php echo $p_invoice->total_f;?></h5></td>
                                         </tr>     

                                         <tr>  
                                          <td class="text-center"><H5>F BAAD</H5></td>
                                          <td colspan=""><H5><?php echo $p_invoice->f_baad1;?></h5></td>
                                          
                                          <td class="text-center">M TOUCH</td>
                                          <td colspan=""><?php echo $p_invoice->m_touch2;?></h5></td>
                                          </tr> 

                                          <tr>
                                         
                                             <td class="text-center">R COPPER</td>
                                          <td colspan=""><?php echo $p_invoice->r_copper;?></h5></td>
                                          
                                             <td class="text-center"><H5>GARANU</H5></td>
                                          <td colspan=""><H5><?php echo $p_invoice->garanu;?></h5></td>
                                          </tr> 
                                          <tr>
                                         
                                          <td class="text-center">COPPER T</td>
                                          <td colspan=""><?php echo $p_invoice->copper_t;?></h5></td>
                                          <td class="text-center">F BAAD</td>
                                          <td colspan=""><?php echo $p_invoice->f_baad2;?></h5></td>
                                          
                                          </tr> 
                                          <tr>
                                         
                                          <td class="text-center">COPPER F</td>
                                          <td colspan=""><?php echo $p_invoice->copper_f1;?></h5></td>
                                          <td class="text-center"><H5>FINAL COPPER</H5></td>
                                          <td colspan=""><H5><?php echo $p_invoice->final_copper;?></h5></td>
                                          
                                          </tr> 
                                         </table>
                                         </div>
                                         </div>
                          </div>
                      </div>
                   </div>
               </div>     
            </div>
        </div> 
    </div> 
               