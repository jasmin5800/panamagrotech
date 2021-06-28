<style type="text/css">
    .restable{
        width: 100%; 
        min-width: 1080px;   
    }
    .divscroll{
        overflow-x: auto;
    }
    @media print {
        .header-title {
          font-size: 15px;
        }
    }
    .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
          padding: 4px 8px;
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
             font-size: 15px;
        }
    }
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
</style>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left"><?php echo $page_title; ?></h4>
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Dashbord');?>"><?php echo COMPANY; ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('PrintAll/general_lot');?>"><?php echo $page_title; ?></a></li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="m-t-0 m-b-20 header-title text-center">General Lot</h4>
                        </div>
                        <div class="offset-md-3 col-md-6">
                            <form method="get" action="<?php echo base_url("PrintAll/general_lot")?>">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">LOT NO</label>
                                    <div class="col-sm-10">
                                      <select name="lot_no">
                                          <?php foreach ($lot_no as $key => $value):?>
                                          <option value="<?php echo $value->lot_no; ?>" <?php echo (($display)?(($value->lot_no==$edit_lotno)?"selected":"") :"") ; ?> ><?php echo LOT.$value->lot_no; ?></option>
                                          <?php endforeach; ?>
                                      </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary btn-bordered waves-effect w-md waves-light">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php if($display):?>
                    <div class="row m-t-50">
                        <div class="col-md-12">
                            <h4 class="m-t-0 header-title text-center">LOT NO : <?php echo LOT.$cut->lot_no;?>  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; PARTY : <?php echo $cut->party_name ?>   &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; ITEM : <?php echo $cut->item_name; ?> </h4>
                        </div>
                        <div class="col-md-12 m-t-10 divscroll">
                            <table class="table text-center table-bordered m-t-0 restable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Val</th>
                                        <th>Pcs Val</th>
                                        <th>Print</th>      
                                        <th>Silicate</th>
                                        <th>Dholai</th>
                                        <th>Kanji </th>
                                        <th>Ghadi </th>
                                        <th>Embroidery</th>
                                        <th>Packing </th>
                                    </tr>                                   
                                </thead>
                                <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td><?php echo $balance->cut_meter; ?></td>
                                            <td><?php echo $balance->cut_pcs; ?></td>
                                            <td><?php echo $balance->print_cloth; ?></td>
                                            <td><?php echo (($balance->silicate_status =="1")?"N-A":$balance->silicate_cloth); ?></td>
                                            <td><?php echo (($balance->dholai_status =="1")?"N-A":$balance->dholai_cloth); ?></td>             
                                            <td><?php echo (($balance->kanji_status =="1")?"N-A":$balance->kanji_cloth); ?></td>
                                            <td><?php echo (($balance->ghadi_status =="1")?"N-A":$balance->ghadi_cloth); ?></td>
                                            <td><?php echo (($balance->embroidery_status=="1")?"N-A":$balance->embroidery_cloth); ?></td>
                                            <td><?php echo (($balance->packing_status =="1")?"N-A":$balance->packing_cloth); ?></td>              
                                        </tr> 
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 divscroll">
                            <h4 class="m-t-10 header-title text-center">CUT</h4>
                            <table class="table text-center table-bordered m-t-0 restable" style="width: 100%" >
                                <thead>
                                    <tr>
                                        <th>No</th> 
                                        <th>Challan No</th>       
                                        <th>Name</th>      
                                        <th>Purchse Mtr</th>
                                        <th>Challan No</th>
                                        <th>Date</th>
                                        <th>Total Pcs </th>
                                        <th>Cut Mtr</th>
                                        <th>Fent</th>
                                        <th>TBale</th>                                      
                                    </tr>                                  
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><?php echo $cut->challan_no; ?></td>
                                        <td><?php echo strtoupper($cut->name);  ?></td>
                                        <td><?php echo number_format($cut->purchase_mtr,2); ?></td>
                                        <td><?php foreach ($cut_lot as $key => $value) {
                                            echo $value->challan_no.",   &nbsp;&nbsp;";
                                        } ?></td>
                                        <td><?php echo date('d/m/Y',strtotime($cut->date)); ?></td>
                                        <td><?php echo $cut->total_pcs; ?></td>
                                        <td><?php echo number_format($cut->cut_mtr,2); ?></td>
                                        <td><?php echo number_format($cut->total_fent,2); ?></td>
                                        <td><?php echo $cut->t_bala; ?></td>
                                    </tr> 
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 divscroll">
                            <h4 class="m-t-10 header-title text-center">DEVIDE</h4>
                            <?php if(isset($devide) && !empty($devide)) :?>
                            <table class="table text-center table-bordered m-t-0 restable" >
                                <thead>
                                    <tr>
                                        <th>No</th> 
                                        <th>Challan No</th>       
                                        <th>Date</th>
                                        <th>Patla</th>
                                        <th>Devide Pcs</th>      
                                    </tr>                                  
                                </thead>
                                <tbody>
                                    <?php  $i=1; foreach ($devide as $key => $value): ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value->challan_no; ?></td>
                                        <td><?php echo date('d/m/Y',strtotime($value->date)); ?></td>
                                        <td><?php echo strtoupper($value->patla_name); ?></td>
                                        <td><?php echo $value->devide_pcs;  ?></td>
                                    </tr> 
                                    <?php $i++; endforeach;?>
                                    <tr>
                                        <td colspan="4">Total Pcs</td>
                                        <td><?php echo $t_devide->devide_pcs;  ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <h4 class="m-t-10 header-title text-center">N-A</h4>
                        <?php endif; ?>
                        </div>
                        <div class="col-md-12 divscroll">
                            <h4 class="m-t-10 header-title text-center">Printing</h4>
                            <?php if(isset($printing) && !empty($printing)) :?>
                            <table class="table text-center table-bordered m-t-0 restable" >
                                <thead>
                                    <tr>
                                        <th>No</th> 
                                        <th>Challan No</th>   
                                        <th>Date</th>
                                        <th>T Design</th>
                                        <th>T Pcs</th>
                                        <th>M Print</th>
                                        <th>Cloth Val</th>
                                        <th>G Ttotal</th>
                                    </tr>                                  
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td><?php echo $printing->challan_no; ?></td>
                                        <td><?php echo date('d/m/Y',strtotime($printing->date)); ?></td>
                                        <td><?php echo $printing->t_design; ?></td>
                                        <td><?php echo $printing->t_pcs;  ?></td>
                                        <td><?php echo $printing->t_missprint; ?></td>
                                        <td><?php echo number_format($printing->cloth_value,2); ?></td>
                                        <td><?php echo $printing->g_total;  ?></td>
                                    </tr> 
                                </tbody>
                            </table>
                        <?php else: ?>
                            <h4 class="m-t-10 header-title text-center">N-A</h4>
                        <?php endif; ?>
                        </div>
                        <div class="col-md-12 divscroll">
                            <h4 class="m-t-10 header-title text-center">PRINT LOT</h4>
                            <?php if(isset($printing_pcs) && !empty($printing_pcs)) :?>
                            <table class="table text-center table-bordered m-t-0 restable" >
                                <thead>
                                    <tr>
                                        <th>No</th> 
                                        <th>Patla</th>
                                        <th>Design</th>       
                                        <th>Total Pcs</th>
                                        <th>M Pcs</th>      
                                    </tr>                                  
                                </thead>
                                <tbody>
                                    <?php  $i=1; foreach ($printing_pcs as $key => $value): ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value->patla_name; ?></td>
                                        <td><?php echo $value->design_no;  ?></td>
                                        <td><?php echo $value->cut_pcs; ?></td>
                                        <td><?php echo $value->miss_pcs;  ?></td>
                                    </tr> 
                                    <?php $i++;  endforeach;?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <h4 class="m-t-10 header-title text-center">N-A</h4>
                        <?php endif; ?>
                        </div>
                        <div class="col-md-12 divscroll">
                            <h4 class="m-t-10 header-title text-center">PROCESS</h4>
                            <?php if(isset($processing) && !empty($processing)) :?>
                            <table class="table text-center table-bordered m-t-0 restable" >
                                <thead>
                                    <tr>
                                        <th>No</th>      
                                        <th>Challan No</th>       
                                        <th>Name</th>  
                                        <th>Process</th>
                                        <th>Date</th>
                                        <th>T Design</th>
                                        <th>T Pcs</th>
                                        <th>Cloth Val</th>
                                        <th>Sub Total</th>
                                    </tr>                                  
                                </thead>
                                <tbody>
                                    <?php  $i=1; foreach ($processing as $key => $value): ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value->challan_no; ?></td>
                                        <td><?php echo strtoupper($value->name);  ?></td>
                                        <td><?php echo $value->process_name; ?></td>
                                        <td><?php echo date('d/m/Y',strtotime($value->date)); ?></td>
                                        <td><?php echo $value->t_design; ?></td>
                                        <td><?php echo $value->t_pcs; ?></td>
                                        <td><?php echo number_format($value->cloth_value,2); ?></td>
                                        <td><?php echo number_format($value->sub_total,2); ?></td>
                                    </tr> 
                                    <?php $i++;  endforeach;?>
                                    <tr>
                                        <td colspan="3"><b>Silicate:<?php  echo " ".$silicate_pcs->t_pcs;  ?></b></td>
                                        <td colspan="3"><b>Dholai:<?php  echo " ". $dholai_pcs->t_pcs;  ?></b></td>
                                        <td colspan="3"><b>Kanji: <?php  echo " ".$kanji_pcs->t_pcs;  ?></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <h4 class="m-t-10 header-title text-center">N-A</h4>
                        <?php endif; ?>
                        </div>
                        <div class="col-md-12 divscroll">
                            <h4 class="m-t-10 header-title text-center">Ghadi</h4>
                            <?php if(isset($ghadi) && !empty($ghadi)) :?>
                            <table class="table text-center table-bordered m-t-0 restable" >
                                <thead>
                                    <tr>
                                        <th>No</th>      
                                        <th>C No</th>
                                        <th>Name</th>
                                        <th width="12%">Remark</th>     
                                        <th>Process</th>     
                                        <th>Date</th>
                                        <th>T DSG.</th>
                                        <th>T Pcs</th>
                                        <th>M Pcs</th>
                                        <th>G Saree</th>
                                        <th>Cloth Val</th>
                                        <th>Sub Total</th>
                                    </tr>                                  
                                </thead>
                                <tbody>
                                    <?php  $i=1; foreach ($ghadi as $key => $value): ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value->challan_no; ?></td>
                                        <td><?php echo strtoupper($value->name);  ?></td>
                                        <td><?php echo $value->remark; ?></td>
                                        <td><?php echo (($value->child_sb=="A")?"Kanji":(($value->child_sb=="B")?"Embroidery":"Ghadi-self")); ?></td>
                                        <td><?php echo date('d/m/Y',strtotime($value->date)); ?></td>
                                        <td><?php echo $value->t_design; ?></td>
                                        <td><?php echo $value->t_pcs; ?></td>
                                        <td><?php echo $value->t_missprint; ?></td>
                                        <td><?php echo $value->t_ghatsaree; ?></td>
                                        <td><?php echo number_format($value->cloth_value,2); ?></td>
                                        <td><?php echo number_format($value->sub_total,2); ?></td>
                                    </tr> 
                                    <?php $i++;  endforeach;?>
                                    <tr>
                                        <td colspan="7"></td>
                                        <td ><b><?php  echo $ghadi_pcs->t_pcs;  ?></b></td>
                                        <td colspan="4"></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <h4 class="m-t-10 header-title text-center">N-A</h4>
                        <?php endif; ?>
                        </div>
                        <div class="col-md-12 divscroll">
                            <h4 class="m-t-10 header-title text-center">Em Devide</h4>
                            <?php if(isset($emdevide) && !empty($emdevide)) :?>
                            <table class="table text-center table-bordered m-t-0 restable" >
                                <thead>
                                    <tr>
                                        <th>No</th>      
                                        <th>Challan No</th>
                                        <th>Name</th> 
                                        <th>Process</th> 
                                        <th>Date</th>
                                        <th>T Design</th>
                                        <th>T Pcs</th>
                                        <th>Cloth Val</th>
                                        <th>Sub Total</th>
                                    </tr>                                 
                                </thead>
                                <tbody>
                                    <?php  $i=1; foreach ($emdevide as $key => $value): ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value->challan_no; ?></td>
                                        <td><?php echo strtoupper($value->name);  ?></td>
                                        <td><?php echo date('d/m/Y',strtotime($value->date)); ?></td>
                                        <td><?php echo (($value->child_sb=="A")?"Ghadi":"Em Devide"); ?></td>
                                        <td><?php echo $value->t_design; ?></td>
                                        <td><?php echo $value->t_pcs; ?></td>
                                        <td><?php echo number_format($value->cloth_value,2); ?></td>
                                        <td><?php echo number_format($value->sub_total,2); ?></td>
                                    </tr> 
                                    <?php $i++;  endforeach;?>
                                    <tr>
                                        <td colspan="6"></td>
                                        <td ><b><?php  echo $emdevide_pcs->t_pcs;  ?></b></td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <h4 class="m-t-10 header-title text-center">N-A</h4>
                        <?php endif; ?>
                        </div>
                        <div class="col-md-12 divscroll">
                            <h4 class="m-t-10 header-title text-center">Embroidery</h4>
                            <?php if(isset($embroidery) && !empty($embroidery)) :?>
                            <table class="table text-center table-bordered m-t-0 restable" >
                                <thead>
                                    <tr>
                                        <th>No</th>      
                                        <th>C No</th>
                                        <th>Name</th> 
                                        <th>Date</th>
                                        <th>T Design</th>
                                        <th>T Pcs</th>
                                        <th>M Dmg</th>
                                        <th>Ghat Saree</th>
                                        <th>EM Mpcs</th>
                                        <th>Sub Total</th>
                                    </tr>                                 
                                </thead>
                                <tbody>
                                    <?php  $i=1; foreach ($embroidery as $key => $value): ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value->challan_no; ?></td>
                                        <td><?php echo strtoupper($value->name);  ?></td>
                                        <td><?php echo date('d/m/Y',strtotime($value->date)); ?></td>
                                        <td><?php echo $value->t_design; ?></td>
                                        <td><?php echo $value->t_pcs; ?></td>
                                        <td><?php echo $value->t_machinedmg; ?></td>
                                        <td><?php echo $value->t_ghatsaree; ?></td>
                                        <td><?php echo $value->t_missprint; ?></td>
                                        <td><?php echo number_format($value->sub_total,2); ?></td>
                                    </tr> 
                                    <?php $i++;  endforeach;?>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td ><b><?php  echo $embroidery_pcs->t_pcs;  ?></b></td>
                                        <td colspan="4"></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <h4 class="m-t-10 header-title text-center">N-A</h4>
                        <?php endif; ?>
                        </div>
                        <div class="col-md-12 divscroll">
                            <h4 class="m-t-10 header-title text-center">Packing</h4>
                            <?php if(isset($packing) && !empty($packing)) :?>
                            <table class="table text-center table-bordered m-t-0 restable" >
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Challan No</th>       
                                        <th>Name</th> 
                                        <th>Process</th>     
                                        <th>Date</th>
                                        <th>T DSG.</th>
                                        <th>T Pcs</th>
                                        <th>M Pcs</th>
                                        <th>G Saree</th>
                                        <th>Cloth Val</th>
                                        <th>Sub Total</th>
                                        </tr>                                
                                </thead>
                                <tbody>
                                    <?php  $i=1; foreach ($packing as $key => $value): ?>
                                    <tr>
                                        <?php $child_sb=(($value->child_sb=="A")? "GHADI-KANJI" :(($value->child_sb=="B")?"EMBROIDERY":(($value->child_sb=="C")?"GHADI-EMBRO":"SELF-GHADI")));?>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value->challan_no; ?></td>
                                        <td><?php echo strtoupper($value->name);  ?></td>
                                        <td><?php echo $child_sb;  ?></td>
                                        <td><?php echo date('d/m/Y',strtotime($value->date)); ?></td>
                                        <td><?php echo $value->t_design; ?></td>
                                        <td><?php echo $value->t_pcs; ?></td>
                                        <td><?php echo $value->t_ghatsaree; ?></td>
                                        <td><?php echo $value->t_missprint; ?></td>
                                        <td><?php echo number_format($value->cloth_value,2); ?></td>
                                        <td><?php echo number_format($value->sub_total,2); ?></td>
                                    </tr> 
                                    <?php $i++;  endforeach;?>
                                    <tr>
                                        <td colspan="5"></td>
                                        <td ><b><?php  echo $packing_pcs->t_pcs;  ?></b></td>
                                        <td colspan="5"></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <h4 class="m-t-10 header-title text-center">N-A</h4>
                        <?php endif; ?>
                        </div>
                        <div class="col-md-12 text-center m-t-20">
                           <a href="<?php echo $button;?>" target="_blank"><button type="button" class="btn btn-icon waves-effect waves-light btn-primary"> <i class="mdi mdi-printer"></i> </button></a> 
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div> 
</div> 
<script type="text/javascript">
$(document).ready(function() {
    $('form').parsley();
    $('select').select2();
});
</script>
               