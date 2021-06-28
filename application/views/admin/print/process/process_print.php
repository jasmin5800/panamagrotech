<style type="text/css">
    .restable{
        width: 100%; 
        min-width: 720px;   
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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('PrintAll/process');?>"><?php echo $page_title; ?></a></li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card-box">
                    <?php if($display):?>
                    <div class="row m-t-50">
                        <div class="col-md-12 divscroll">
                            <?php if(isset($processing) && !empty($processing)) :?>
                            <h4 class="m-t-10 header-title text-center"><?php echo $start." To ".$end;  ?></h4>
                            <table class="table text-center table-bordered m-t-0 restable" >
                                <thead>
                                    <tr>
                                        <th>No</th> 
                                        <th>Name</th>
                                        <th>Challan No</th>
                                        <th>Lot No</th>
                                        <th>Process</th>
                                        <th>Date</th>
                                        <th>T Design</th>
                                        <th>T Pcs</th>
                                        <th>Cloth Value</th>
                                        <th>G Total</th>
                                    </tr>                                  
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($processing as $key => $value):?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo ucwords($value->name); ?></td>
                                        <td><?php echo $value->challan_no; ?></td>
                                        <td><?php echo LOT.$value->lot_no; ?></td>
                                        <td><?php echo $value->process_name; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($value->date));  ?></td>
                                        <td><?php echo $value->t_design; ?></td>
                                        <td><?php echo $value->t_pcs;  ?></td>
                                        <td><?php  $cloth_value[]=$value->cloth_value; echo number_format($value->cloth_value,2);  ?></td>
                                        <td><?php echo number_format($value->g_total,2); ?></td>
                                    </tr> 
                                    <?php $i++; endforeach;?>
                                    <tr>
                                      <td colspan="8"></td>
                                      <td><?php  echo number_format(array_sum($cloth_value),2);  ?></td>
                                      <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php endif; ?>
                            <?php if(isset($ghadi) && !empty($ghadi)) :?>
                            <h4 class="m-t-10 header-title text-center"> Ghadi &nbsp; &nbsp; <?php echo $start." To ".$end;  ?></h4>
                            <table class="table text-center table-bordered m-t-0 restable" >
                                <thead>
                                    <tr>
                                        <th>No</th> 
                                        <th>Name</th>
                                        <th>Challan No</th>
                                        <th>Lot No</th>
                                        <th>Remark</th>
                                        <th>Process</th>
                                        <th>Date</th>
                                        <th>T DSG</th>
                                        <th>T Pcs</th>
                                        <th>M Pcs</th>
                                        <th>G Saree</th>
                                        <th>Cloth Value</th>
                                        <th>G Total</th>
                                    </tr>                                  
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($ghadi as $key => $value):?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo ucwords($value->name); ?></td>
                                        <td><?php echo $value->challan_no; ?></td>
                                        <td><?php echo LOT.$value->lot_no; ?></td>
                                        <td><?php echo ucwords($value->remark); ?></td>
                                        <td><?php echo (($value->child_sb=="A")?"Kanji":(($value->child_sb=="B")?"Embroidery":"Self Ghadi")); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($value->date));  ?></td>
                                        <td><?php echo $value->t_design; ?></td>
                                        <td><?php echo $value->t_pcs;  ?></td>
                                        <td><?php echo $value->t_missprint;  ?></td>
                                        <td><?php echo $value->t_ghatsaree;  ?></td>
                                        <td><?php  $cloth_value[]=$value->cloth_value; echo number_format($value->cloth_value,2);  ?></td>
                                        <td><?php echo number_format($value->g_total,2); ?></td>
                                    </tr> 
                                    <?php $i++; endforeach;?>
                                    <tr>
                                      <td colspan="11"></td>
                                      <td><?php  echo number_format(array_sum($cloth_value),2);  ?></td>
                                      <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php endif; ?>
                            <?php if(isset($embroidery) && !empty($embroidery)) :?>
                            <h4 class="m-t-10 header-title text-center"> Embroidery &nbsp; &nbsp; <?php echo $start." To ".$end;  ?></h4>
                            <table class="table text-center table-bordered m-t-0 restable" >
                                <thead>
                                    <tr>
                                        <th>No</th> 
                                        <th>Name</th>
                                        <th>Challan No</th>
                                        <th>Lot No</th>
                                        <th>Process</th>
                                        <th>Date</th>
                                        <th>T DSG</th>
                                        <th>T Pcs</th>
                                        <th>M Pcs</th>
                                        <th>M DMG</th>
                                        <th>G Saree</th>
                                        <th>Cloth Value</th>
                                        <th>G Total</th>
                                    </tr>                                  
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($embroidery as $key => $value):?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo ucwords($value->name); ?></td>
                                        <td><?php echo $value->challan_no; ?></td>
                                        <td><?php echo LOT.$value->lot_no; ?></td>
                                        <td><?php echo (($value->child_sb=="A")?"Ghadi":"Em Devide"); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($value->date));  ?></td>
                                        <td><?php echo $value->t_design; ?></td>
                                        <td><?php echo $value->t_pcs;  ?></td>
                                        <td><?php echo $value->t_missprint;  ?></td>
                                        <td><?php echo $value->t_machinedmg;  ?></td>
                                        <td><?php echo $value->t_ghatsaree;  ?></td>
                                        <td><?php  $cloth_value[]=$value->cloth_value; echo number_format($value->cloth_value,2);  ?></td>
                                        <td><?php echo number_format($value->g_total,2); ?></td>
                                    </tr> 
                                    <?php $i++; endforeach;?>
                                    <tr>
                                      <td colspan="11"></td>
                                      <td><?php  echo number_format(array_sum($cloth_value),2);  ?></td>
                                      <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php endif; ?>
                            <?php if(isset($packing) && !empty($packing)) :?>
                            <h4 class="m-t-10 header-title text-center"> Packing &nbsp; &nbsp; <?php echo $start." To ".$end;  ?></h4>
                            <table class="table text-center table-bordered m-t-0 restable" >
                                <thead>
                                    <tr>
                                        <th>No</th> 
                                        <th>Name</th>
                                        <th>Challan No</th>
                                        <th>Lot No</th>
                                        <th>Process</th>
                                        <th>Date</th>
                                        <th>T DSG</th>
                                        <th>T Pcs</th>
                                        <th>M Pcs</th>
                                        <th>G Saree</th>
                                        <th>Cloth Value</th>
                                        <th>G Total</th>
                                    </tr>                                  
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($packing as $key => $value):?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo ucwords($value->name); ?></td>
                                        <td><?php echo $value->challan_no; ?></td>
                                        <td><?php echo LOT.$value->lot_no; ?></td>
                                        <td><?php echo (($value->child_sb=="A")?"Ghadi-Kanji":(($value->child_sb=="B")?"Embroidery":(($value->child_sb=="C")?"Ghadi-Embroidery":"Ghadi-Self"))); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($value->date));  ?></td>
                                        <td><?php echo $value->t_design; ?></td>
                                        <td><?php echo $value->t_pcs;  ?></td>
                                        <td><?php echo $value->t_missprint;  ?></td>
                                        <td><?php echo $value->t_ghatsaree;  ?></td>
                                        <td><?php  $cloth_value[]=$value->cloth_value; echo number_format($value->cloth_value,2);  ?></td>
                                        <td><?php echo number_format($value->g_total,2); ?></td>
                                    </tr> 
                                    <?php $i++; endforeach;?>
                                    <tr>
                                      <td colspan="10"></td>
                                      <td><?php  echo number_format(array_sum($cloth_value),2);  ?></td>
                                      <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php endif; ?>
                            <?php if(isset($emdevide) && !empty($emdevide)) :?>
                            <h4 class="m-t-10 header-title text-center"> Em Devide &nbsp; &nbsp; <?php echo $start." To ".$end;  ?></h4>
                            <table class="table text-center table-bordered m-t-0 restable" >
                                <thead>
                                    <tr>
                                        <th>No</th> 
                                        <th>Name</th>
                                        <th>Challan No</th>
                                        <th>Lot No</th>
                                        <th>Process</th>
                                        <th>Date</th>
                                        <th>T DSG</th>
                                        <th>T Pcs</th>
                                        <th>Cloth Value</th>
                                        <th>G Total</th>
                                    </tr>                                  
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($emdevide as $key => $value):?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo ucwords($value->name); ?></td>
                                        <td><?php echo $value->challan_no; ?></td>
                                        <td><?php echo LOT.$value->lot_no; ?></td>
                                        <td><?php echo (($value->child_sb=="A")?"Kanji":"Em-Devide"); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($value->date));  ?></td>
                                        <td><?php echo $value->t_design; ?></td>
                                        <td><?php echo $value->t_pcs;  ?></td>
                                        <td><?php  $cloth_value[]=$value->cloth_value; echo number_format($value->cloth_value,2);  ?></td>
                                        <td><?php echo number_format($value->g_total,2); ?></td>
                                    </tr> 
                                    <?php $i++; endforeach;?>
                                    <tr>
                                      <td colspan="8"></td>
                                      <td><?php  echo number_format(array_sum($cloth_value),2);  ?></td>
                                      <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php endif; ?>
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
    window.print();
});
</script>
               