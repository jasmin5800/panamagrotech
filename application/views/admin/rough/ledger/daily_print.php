<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left"><?php echo $page_title; ?></h4>
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="#"><?php echo COMPANY; ?></a></li>
                        <li class="breadcrumb-item"><a href="#"><?php echo $page_title; ?></a></li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>        
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <style type="text/css">
                      .table td, .table th{
                        border-top: none;
                      }
                      .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                            padding: 7px 10px;
                      }
                      .responsive {
                        width: 100%;
                        max-width: 400px;
                        height: auto;
                      }
                    </style>
                    <div class="text-center">
                    <h5><?php echo COMPANY; ?></h5>
                    </div>
                  
                    <?php if($display) :?>
                        <div class="row">
                    <div class="col-md-12 table-responsive">
                        <div class="card-box">
                            <div class="text-left m-b-30">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="text-left font-weight-bold">
                                            party Statement For  &nbsp;&nbsp;
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="text-left font-weight-bold">
                                            of :  &nbsp;&nbsp;
                                        </div>
                                        <div class="text-right">
                                            <?php echo $end_date; ?>
                                        </div>
                                    </div>
                                    <?php if($type == "rs") {  ?>
                                     <div class="row">
                                        <div class="text-left font-weight-bold">
                                            Opening Balance rs
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="row">
                                        <div class="text-left font-weight-bold">
                                            of :  &nbsp;&nbsp;
                                        </div>
                                        <div class="text-right">
                                            <?php echo $opening_balance_rs; ?>
                                        </div>
                                    </div>
                                    <?php } else { ?>
                                     <div class="row">
                                        <div class="text-left font-weight-bold">
                                            Opening Balance fine
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="text-left font-weight-bold">
                                            of :  &nbsp;&nbsp;
                                        </div>
                                        <div class="text-right">
                                            <?php echo $opening_balance_fine; ?>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-6 table-responsive">
                                    <style type="text/css">
                                        .table td, .table th{
                                            border-top: none;
                                        }
                                        .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                                                padding: 7px 10px;
                                        }
                                    </style>
                                    <table class="table w-100" >
                                        <thead>
                                            <tr>
                                                <th scope="col" colspan="6" class="text-center">Credit Particulars</th>
                                            </tr>
                                            <tr>
                                                <th scope="col" class="text-center">Account</th>
                                                <?php if($type == "rs") {  ?>
                                                <th scope="col" class="text-center">Rs</th>
                                                <?php } else { ?>
                                                <th scope="col" class="text-center">Fine</th>
                                                <?php } ?> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                               

                                            <?php   if(isset($credit) && !empty($credit)): ?>

                                               
                                                  <?php  foreach ($credit as $credit): ?>
                                                <?php if($type == "rs" && $credit->rs != '0') {  ?>
                                                    <tr>
                                                    <td scope="row" class="text-center"><?php echo $credit->party_name;   ?></td>
                                            
                                            
                                                <td scope="row" class="text-center"><?php echo $credit->rs;   ?></td>
                                            
                                                </tr>
                                                <?php } ?> 
                                                <?php   if($type == "fine") { ?>
                                                    <tr>
                                                    <td scope="row" class="text-center"><?php echo $credit->party_name;   ?></td>
                                                
                                            <td scope="row" class="text-center"><?php echo $credit->fine;   ?></td>
                                            
                                            </tr>
                                                    <?php } ?>  
                                            
                                            <?php   endforeach; ?>                                    
                                            <tr>                                        
                                                <td></td>
                                                <?php if($type == "rs" && $credit->rs != '0') {  ?>
                                                <th scope="row"  class="border-top border-dark text-right p-t-0 p-b-0 text-center"><?php echo number_format($credit_t->total,0) ?> </th>
                                                <?php } ?> 
                                                <?php   if($type == "fine") { ?>
                                                    <th scope="row"  class="border-top border-dark text-right p-t-0 p-b-0 text-center"><?php echo number_format($credit_t->ftotal,0) ?> </th>
                                                    <?php } ?> 
                                                <td></td>
                                            </tr>
                                            <?php endif; ?>                                    
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6 table-responsive">
                                    <table class="table" width="100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" colspan="6" class="text-center">Debit Particulars</th>
                                            </tr>
                                            <?php if($type == "rs") {  ?>
                                            <tr>
                                                <th scope="col" class="text-center">Account</th>
                                            
                                                <th scope="col" class="text-center">Rs</th>
                                            
                                            
                                                </tr>
                                                <?php } else { ?>
                                                    <tr>
                                                <th scope="col" class="text-center">Account</th>
                                            
                                                <th scope="col" class="text-center">Fine</th>
                                            
                                                </tr>
                                                    <?php } ?>  
                                            </tr>
                                        </thead>
                                        <tbody>
                                    

                                            <?php if(isset($debit) && !empty($debit)):
                                                    foreach ($debit as $debit): ?>
                                                   

                                            
                                            <?php if($type == "rs" && $debit->rs!=0) {  ?>
                                            <tr> 
                                            <td scope="row" class="text-center"><?php echo $debit->party_name;   ?></td>
                                            
                                            
                                                <td class="text-center"><?php echo $debit->rs; ?></td>
                                            
                                            
                                            </tr>
                                            <?php }  if($type == "fine") { ?>
                                                <tr>
                                                <td scope="row" class="text-center"><?php echo $debit->party_name;   ?></td>
                                            
                                            
                                                <td class="text-center"><?php echo $debit->fine; ?></td>
                                            
                                            </tr>
                                                <?php } ?>  
                                            <?php   endforeach; ?> 
                                        
                                            <tr>                                        
                                                <td></td>
                                                <?php if($type == "rs" && $debit->rs != '0') {  ?>
                                                <th scope="row"  class="border-top border-dark text-right p-t-0 p-b-0 text-center"><?php echo number_format($debit_t->total,0) ?> </th>
                                                <?php } ?> 
                                                <?php   if($type == "fine") { ?>
                                                    <th scope="row"  class="border-top border-dark text-right p-t-0 p-b-0 text-center"><?php echo number_format($debit_t->ftotal,0) ?> </th>
                                                    <?php } ?> 
                                                <td></td>
                                            </tr>
                                            <?php endif;?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12 row">
                                
                                    <div class="col-md-6">
                                        <table class="table">
                                            <tbody>
                                            <tr>
                                            <?php if($type == "rs") {  ?>
                                                <th class="text-right w-50"><?php echo number_format(abs($opening_balance_rs),0); ?> </th><td> <?php  echo ($opening_balance_rs < 0) ? "cr " : "db ";?> Opening Balance </td>
                                                <?php } else { ?>
                                                <th class="text-right w-50"><?php echo number_format(abs($opening_balance_fine),0);?></th><td> <?php  echo ($opening_balance_fine < 0) ? "cr " : "db ";?>Opening Balance </td>
                                                <?php } ?>  
                                            </tr>
                                            <tr>
                                            <?php if($type == "rs") {  ?>
                                                <th class="text-right w-50"><?php echo number_format($credit_t->total,0);?></th>
                                                <?php } else { ?>
                                                <th class="text-right w-50"><?php echo number_format($credit_t->ftotal,0);?></th>
                                                <?php } ?>  
                                            </tr> 
                                            <tr>
                                            <?php if($type == "rs") {  ?>
                                                <th class="text-right w-50 style="border-top: 2px solid black;"><?php echo number_format($opening_balance_rs + $credit_t->total,0);?></th>
                                                <?php } else { ?>
                                                <th class="text-right w-50 style="border-top: 2px solid black;" ><?php echo number_format($opening_balance_fine+ $credit_t->ftotal,0);?></th>
                                                <?php } ?>  
                                            </tr>
                                            <tr>
                                            <?php if($type == "rs") {  ?>
                                                <th class="text-right w-50"><?php echo number_format($debit_t->total,0);?></th>
                                                <?php } else { ?>
                                                <th class="text-right w-50"><?php echo number_format($debit_t->ftotal,0);?></th>
                                                <?php } ?>  
                                            </tr>
                                            
                                           
                                            <?php if($type == "rs") {
                                                
                                                $rs2 =  $debit_t->total-$credit_t->total; 
                                                $final = $opening_balance_rs + $credit_t->total - $debit_t->total;
                                               
                                                
                                                ?>
                                                <th class="text-right w-50" style="border-top: 2px solid black; "><?php echo number_format(abs($final),0);?></th>
                                                <td> <?php echo ($rs2 < 0) ? "cr" : "db"; ?> closing balance</td>
                                                <?php } else {
                                                    
                                                    $fine12 =$debit_t->ftotal-$credit_t->ftotal; 
                                                    $final1 = number_format($opening_balance_fine+ $credit_t->ftotal,0) - $debit_t->ftotal;
                                                    ?>
                                                <th class="text-right w-50" style="border-top: 2px solid black; "><?php echo number_format($final1,0);?></th>
                                                <td> <?php
                                                $fine =$debit_t->ftotal-$credit_t->ftotal; 
                                                echo ($fine12 < 0) ? "cr" : "db"; ?>closing balance </td>
                                                <?php } ?> 
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                
                                </div>
                                <div class="col-md-12 text-center m-t-50">
                                    <a href="<?php echo $btn_url; ?>" target="_blank" class="btn btn-danger btn-bordered waves-effect  waves-light"><i class="mdi mdi-printer"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  <?php endif;?>
                    <?php if($display) :?>
                        <div class="row ">
                        <div class="col-md-6 table-responsive">
                            <style type="text/css">
                                .table td, .table th{
                                    border-top: none;
                                }
                                .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
                                        padding: 7px 10px;
                                }
                            </style>
                            <table class="table w-100" >
                                <thead>
                                    <tr>
                                        <th scope="col" colspan="6" class="text-center">Credit Particulars</th>
                                    </tr>
                                    <tr>
                                        <th scope="col" class="text-center">DATE</th>
                                        <?php if($type == "rs") {  ?>
                                        <th scope="col" class="text-center">Rs</th>
                                        <?php } else { ?>
                                        <th scope="col" class="text-center">Fine</th>
                                        <?php } ?> 
                                        <th scope="col" class="text-center">REMARK</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php   if(isset($credit) && !empty($credit)):
                                             foreach ($credit as $credit): ?>
                                   
                                        <?php $credit_rs[]=$credit->rs; ?>
                                        <?php $credit_fine[]=$credit->fine; ?>
                                        <?php if($type == "rs" && $credit->rs != '0') {  ?>
                                            <tr>
                                        <td class="text-center"><?php echo (date('d/m/Y', strtotime($credit->date))); ?></td>
                                    
                                        <td scope="row" class="text-center"><?php echo $credit->rs;   ?></td>
                                     
                                        <td class="text-center"><?php echo strtoupper($credit->remark); ?></td>
                                        </tr>
                                        <?php } ?> 
                                        <?php   if($type == "fine") { ?>
                                            <tr>
                                            <td class="text-center"><?php echo (date('d/m/Y', strtotime($credit->date))); ?></td>
                                     
                                      <td scope="row" class="text-center"><?php echo $credit->fine;   ?></td>
                                     
                                      <td class="text-center"><?php echo strtoupper($credit->remark); ?></td>
                                      </tr>
                                            <?php } ?>  
                                    
                                    <?php   endforeach; ?>                                    
                                    <tr>                                        
                                        <td></td>
                                        <?php if($type == "rs" && $credit->rs != '0') {  ?>
                                        <th scope="row"  class="border-top border-dark text-right p-t-0 p-b-0 text-center"><?php echo number_format((array_sum($credit_rs)),0) ?> </th>
                                        <?php } ?> 
                                        <?php   if($type == "fine") { ?>
                                            <th scope="row"  class="border-top border-dark text-right p-t-0 p-b-0 text-center"><?php echo number_format((array_sum($credit_fine)),0) ?> </th>
                                            <?php } ?> 
                                        <td></td>
                                    </tr>
                                    <?php endif; ?>                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6 table-responsive">
                            <table class="table" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col" colspan="6" class="text-center">Debit Particulars</th>
                                    </tr>
                                    <?php if($type == "rs") {  ?>
                                    <tr>
                                        <th scope="col" class="text-center">DATE</th>
                                       
                                        <th scope="col" class="text-center">Labour Rs</th>
                                     
                                       
                                        <th scope="col" class="text-center">REMARK</th>
                                        </tr>
                                        <?php } else { ?>
                                            <tr>
                                        <th scope="col" class="text-center">DATE</th>
                                     
                                        <th scope="col" class="text-center">Fine</th>
                                       
                                        <th scope="col" class="text-center">REMARK</th>
                                        </tr>
                                            <?php } ?>  
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($debit) && !empty($debit)):
                                            foreach ($debit as $debit): ?>
                                             <?php $debit_labour[]=$debit->rs; ?>
                                        <?php $debit_fine[]=$debit->fine; ?>
                                       
                                    <?php if($type == "rs" && $debit->rs!=0) {  ?>
                                    <tr>
                                        <td class="text-center"><?php echo date('d/m/Y', strtotime($debit->date)); ?></td>
                                       
                                        <td class="text-center"><?php echo $debit->rs; ?></td>
                                       
                                       
                                        <td class="text-center"><?php echo strtoupper($debit->remark); ?></td>
                                    </tr>
                                    <?php }  if($type == "fine") { ?>
                                        <tr>
                                        <td class="text-center"><?php echo date('d/m/Y', strtotime($debit->date)); ?></td>
                                       
                                        <td class="text-center"><?php echo $debit->fine; ?></td>
                                       
                                        <td class="text-center"><?php echo strtoupper($debit->remark); ?></td>
                                    </tr>
                                        <?php } ?>  
                                    <?php   endforeach; ?> 
                                  
                                    <tr>                                        
                                        <td></td>
                                        <?php if($type == "rs" && $debit->rs != '0') {  ?>
                                        <th scope="row"  class="border-top border-dark text-right p-t-0 p-b-0 text-center"><?php echo number_format((array_sum($debit_labour)),0) ?> </th>
                                        <?php } ?> 
                                        <?php   if($type == "fine") { ?>
                                            <th scope="row"  class="border-top border-dark text-right p-t-0 p-b-0 text-center"><?php echo number_format((array_sum($debit_fine)),0) ?> </th>
                                            <?php } ?> 
                                        <td></td>
                                    </tr>
                                    <?php endif;?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 row">
                           
                            <div class="offset-md-6 col-md-6">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                    <?php if($type == "rs") {  ?>
                                        <th class="text-right w-50"><?php echo number_format($d_total->d_total,0);?></th>
                                        <?php } else { ?>
                                        <th class="text-right w-50"><?php echo number_format($d_total->d_fine,0);?></th>
                                        <?php } ?>  
                                    </tr>
                                    <tr>
                                    <?php if($type == "rs") {  ?>
                                        <th class="text-right w-50"><?php echo number_format($c_total->c_total,0);?></th>
                                        <?php } else { ?>
                                        <th class="text-right w-50"><?php echo number_format($c_total->c_fine,0);?></th>
                                        <?php } ?>  
                                    </tr>
                                    <tr>
                                    <?php if($type == "rs") {
                                        
                                        $rs =$d_total->d_total-$c_total->c_total; 
                                        
                                        ?>
                                        <th class="text-right w-50" style="border-top: 2px solid black; "><?php echo number_format(abs($d_total->d_total-$c_total->c_total),0);?></th>
                                        <td> <?php echo ($rs < 0) ? "cr" : "db"; ?> </td>
                                        <?php } else { ?>
                                        <th class="text-right w-50" style="border-top: 2px solid black; "><?php echo number_format(abs($d_total->d_fine-$c_total->c_fine),0);?></th>
                                        <td> <?php
                                         $fine =$d_total->d_fine-$c_total->c_fine; 
                                        echo ($fine < 0) ? "cr" : "db"; ?> </td>
                                        <?php } ?> 
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                           
                        </div>
                       
                    </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div> 
</div> 
<script type="text/javascript">
    $(document).ready(function() {
        window.print();
});
</script>