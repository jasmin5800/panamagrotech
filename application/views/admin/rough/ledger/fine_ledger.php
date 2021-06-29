<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left"><?php echo $page_title; ?></h4>
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('dashbord');?>"><?php echo COMPANY; ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('RoughPayment/index');?>"><?php echo $page_title; ?></a></li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <h4 class="header-title m-t-0 text-center m-b-30">PARTY TAREEJ</h4>
                    <form role="form" method="post" action="<?php echo $action ;?>">
                        <div class="row">
                            <div class="form-group row col-md-6">
                                <label for="party" class="col-3 col-form-label">Party<span class="text-danger">*</span></label>
                                <div class="col-9">
                                    <select class="selectpicker" data-live-search="true"  name="party" data-style="btn-secondary btn-rounded">
                                        <?php foreach ($party as $party) { ?>
                                          <option value="<?php echo $party->id_party; ?>" <?php echo (($method=="edit")?(($party->id_party==$party_id)?"selected":""):"");  ?>> <?php echo $party->name; ?></option>  
                                        <?php } ?> 
                                    </select>                                    
                                </div>
                            </div>
                            <div class="form-group row col-md-6">
                                <label for="Date" class="col-3 col-form-label">Date<span class="text-danger">*</span></label>
                                <div class="col-9">
                                    <?php $month= date('d/m/Y',strtotime('-12 month'));?>
                                    <div class="input-daterange input-group" id="date-range">
                                        <input type="text" class="form-control" name="start" autocomplete="off" value="16/11/2020" />
                                        <input type="text" class="form-control" name="end" autocomplete="off"  value="<?php echo (($method=="edit")?$end_date:date('d/m/Y')) ; ?>" />
                                    </div>                            
                                </div>
                            </div>
                        </div>
                        <div class="form-group row m-t-20">
                            <div class="col-12 text-center">
                                <button type="submit" target="_blank" class="btn btn-primary waves-effect waves-light">
                                    Check
                                </button>
                            </div>
                        </div>
                    </form>
                </div> 
            </div>
        </div>
        <?php if($display): ?>
        <div class="row">
            <div class="col-md-12 table-responsive">
                <div class="card-box">
                    <div class="text-left m-b-30">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="text-left font-weight-bold">
                                    Account Statement For  &nbsp;&nbsp;
                                </div>
                                <div class="text-right">
                                    <?php echo $acc_name; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="text-left font-weight-bold">
                                    From :  &nbsp;&nbsp;
                                </div>
                                <div class="text-right">
                                    <?php echo $strt_date.' To '.$end_date ; ?>
                                </div>
                            </div><div class="row">
                                <div class="text-left font-weight-bold">
                                    Opening balance
                                </div>
                                <div class="text-right">
                                    <?php echo "  Fine:".$opening_fine ; ?>
                                </div>
                            </div><div class="row">
                                <div class="text-left font-weight-bold">
                                    Opening balance
                                </div>
                                <div class="text-right">
                                   <?php echo "  Amount:".$opening_amount ; ?>
                                </div>
                            </div>
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
                            <table class="table w-100">
                                <thead>
                                    <tr>
                                        <th scope="col" colspan="6" class="text-center">Credit Particulars</th>
                                    </tr>
                                    <tr>
                                    <th scope="col" class="text-center">DATE</th>
                                        <th scope="col" class="text-center">INVOICE</th>
                                       
                                        <!--<th scope="col" class="text-center">TOUCH + WASTE</th>-->
                                        <th scope="col" class="text-center">FINE</th>
                                        <th scope="col" class="text-center">AMOUNT</th>
                                        <th scope="col" class="text-center">REMARK</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                <tr>
                                     <?php
                                     $credit_fine = array();
                                     $credit_amount = array();
                                     
                                     
                                     if($opening_fine < 0) { ?>
                                        <?php $credit_fine[]=abs($opening_fine); ?>
                                      <?php }  if($opening_amount < 0) { ?>
                                        <?php $credit_amount[]=abs($opening_amount); ?>
                                        <?php } ?>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        
                                        <!--<td class="text-center"><?php echo number_format($debit->touch_wastage,1);  ?></td>-->
                                        <?php if($opening_fine < 0) { ?>
                                        <td class="text-center"><?php echo abs($opening_fine); ?></td>

                                        <?php } else{ ?> <td></td> <?php } if($opening_amount < 0) { ?>
                                        <td class="text-center"><?php echo abs($opening_amount); ?></td>
                                        <?php }else{ ?> <td></td> <?php } if($opening_fine < 0 || $opening_amount < 0) { ?>
                                        <td class="text-center"><?php echo "Opening Balance "; ?></td>
                                          <?php } ?>
                                    </tr>
                                    <?php   if(isset($credit) && !empty($credit)):
                                             foreach ($credit as $credit): ?>
                                    <tr>
                                        <?php $credit_fine[]=$credit->t_fine2; ?>
                                        <?php $credit_amount[]=$credit->t_amount2; ?>
                                        <td class="text-center"><?php echo (date('d/m/Y', strtotime($credit->date))); ?></td>
                                       
                                        <td class="text-center"><?php echo ((isset($credit->invoice_no) && !empty($credit->invoice_no))?"P/".$credit->invoice_no."<br>":"")?></td>
                                        <!--<td class="text-center"><?php echo number_format($credit->touch_wastage,1); ?></td>-->
                                        <td scope="row" class="text-center"><?php echo $credit->t_fine2; ?></td>
                                        <td scope="row" class="text-center"><?php echo $credit->t_amount2; ?></td>
                                        <td class="text-center"><?php echo ((isset($credit->parent_remark) && !empty($credit->parent_remark))?"<br>".strtoupper($credit->parent_remark):''); ?></td>
                                    </tr>
                                    <?php   endforeach; ?>                                    
                                    <tr>                                        
                                        <td colspan="2"></td>
                                        <th scope="row"  class="border-top border-dark text-right p-t-0 p-b-0 text-center"><?php echo number_format((array_sum($credit_fine)),0) ?> </th>
                                        <th scope="row"  class="border-top border-dark text-right p-t-0 p-b-0 text-center"><?php echo number_format((array_sum($credit_amount)),0) ?> </th>
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
                                    <tr>
                                        <th scope="col" class="text-center">DATE</th>
                                        <th scope="col" class="text-center">INVOICE</th>
                                        <!--<th scope="col" class="text-center">TOUCH + WASTE</th>-->
                                        <th scope="col" class="text-center">FINE</th>
                                        <th scope="col" class="text-center">AMOUNT</th>
                                        <th scope="col" class="text-center">REMARK</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                     <tr>
                                     <?php
                                     $debit_fine = array();
                                     $debit_labour = array();
                                     if($opening_fine > 0) { ?>
                                        <?php $debit_fine[]=$opening_fine; ?>
                                      <?php }  if($opening_amount > 0) { ?>
                                        <?php $debit_labour[]=$opening_amount; ?>
                                        <?php } ?>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        
                                        <!--<td class="text-center"><?php echo number_format($debit->touch_wastage,1);  ?></td>-->
                                        <?php if($opening_fine > 0) { ?>
                                        <td class="text-center"><?php echo $opening_fine; ?></td>
                                        <?php } else{ ?> <td></td> <?php } if($opening_amount > 0) { ?>
                                        <td class="text-center"><?php echo $opening_amount; ?></td>
                                        <?php }else{ ?> <td></td> <?php } if($opening_fine > 0 || $opening_amount > 0) { ?>
                                        <td class="text-center"><?php echo "Opening Balance "; ?></td>
                                            <?php } ?>
                                    </tr>
                                    <?php if(isset($debit) && !empty($debit)):
                                            foreach ($debit as $debit): ?>
                                    <tr>
                                        <?php $debit_fine[]=$debit->fine; ?>
                                        <?php $debit_labour[]=$debit->labour; ?>
                                        <td class="text-center"><?php echo date('d/m/Y', strtotime($debit->date));  ?></td>
                                        <td class="text-center"><?php echo "S/".$debit->invoice_no; ?></td>
                                        
                                        <!--<td class="text-center"><?php echo number_format($debit->touch_wastage,1);  ?></td>-->
                                        <td class="text-center"><?php echo $debit->fine; ?></td>
                                        <td class="text-center"><?php echo $debit->labour; ?></td>
                                        <td class="text-center"><?php echo strtoupper($debit->item_name).((isset($debit->parent_remark) && !empty($debit->parent_remark))?"<br>".strtoupper($debit->parent_remark):''); ?></td>
                                    </tr>
                                    <?php   endforeach; ?> 
                                    <tr>
                                        <td colspan="2"></td>
                                        <th scope="row"  class="border-top border-dark text-right p-t-0 p-b-0 text-center"><?php echo number_format((array_sum($debit_fine)),0)?> </th>
                                        <th scope="row"  class="border-top border-dark text-right p-t-0 p-b-0 text-center"><?php echo number_format((array_sum($debit_labour)),0)?> </th>
                                        <td></td>
                                    </tr>
                                    <?php endif;?>
                                </tbody>
                            </table>
                        </div>
                        <?php 
                            
                           $d_fine = number_format((array_sum($debit_fine)),0);
                            $c_fine = number_format((array_sum($credit_fine)),0);
                            $d_amount = number_format((array_sum($debit_labour)),0);
                            $c_amount = number_format((array_sum($credit_amount)),0);

                         /*   $d_fine = $d_total->d_total;
                            $c_fine = $c_total->c_total;
                            $d_amount = $d_total->d_labour;
                            $c_amount = $c_total->c_amount; */

                        
                        
                        ?>
                        <div class="col-md-12 row">
                        
                            <div class="offset-md-6 col-md-6">
                                <table class="table">
                                  <thead>
                                  <th class="text-right">fine</th>
                                  <th class="text-right">Amount</th>

                                  </thead>
                                  <tbody>
                                  <td>
                                    <tr>
                                      <th class="text-right w-50"><?php echo $d_fine; ?></th>
                                     
                                      <th class="text-right w-50"><?php echo $d_amount; ?></th>
                                      
                                     
                                    </tr>
                                    <tr>
                                      <th class="text-right w-50"><?php echo $c_fine;?></th>
                                     
                                      <th class="text-right w-50"><?php echo  $c_amount;?></th>
                                      
                                    </tr>
                                  
                                  
                                    <tr>
                                    <?php
                                   
                                    $fine1 = ($d_total->d_total - $c_total->c_total)+$opening_fine;  
                                  
                                     $rs1 = $d_total->d_labour - $c_total->c_amount+$opening_amount;
                                       $r_status =  ($rs1 < 0) ? "cr" : "db"; 
                                       $f_status =  ($fine1 < 0) ? "cr" : "db"; 
                                       
                                      
                                      ?>
                                    <th class="text-right w-50" style="border-top: 2px solid black; "><?php echo abs($fine1)." ".$f_status;?></th>
                                     
                                     <th class="text-right w-50" style="border-top: 2px solid black; "><?php echo abs($rs1)." ".$r_status; ?></th>
                                      <td>Closing Balance</td>
                                    </tr>
                                 </td>
                                 
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
        </div>
        <?php endif; ?>
    </div> 
</div> 
<script type="text/javascript">
    $(document).ready(function() {
        $('form').parsley();
        $("select").select2();
        jQuery('#date-range').datepicker({
            toggleActive: true,
            format: "dd/mm/yyyy"
        });
});
</script>