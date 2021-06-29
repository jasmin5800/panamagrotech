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
                    <h4 class="header-title m-t-0 text-center m-b-30"><?PHP ECHO ($type == "rs") ? "RS ROJMED" : "FINE ROJMED"; ?></h4>
                    <form role="form" method="post" action="<?php echo $action ;?>">
                        <div class="row">
                            <div class="form-group row col-md-6">
                                <label for="party" class="col-3 col-form-label">party<span class="text-danger">*</span></label>
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
                                    <?php $month= date('d/m/Y',strtotime('-1 month'));?>
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
                                    party Statement For  &nbsp;&nbsp;
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