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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('PrintAll/printing');?>"><?php echo $page_title; ?></a></li>
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
                            <h4 class="m-t-10 header-title text-center">Printing &nbsp; &nbsp; <?php echo $patla_name->patla_name; ?></h4>
                            <?php if(isset($printing) && !empty($printing)) :?>
                            <table class="table text-center table-bordered m-t-0 restable" >
                                <thead>
                                    <tr>
                                        <th>No</th> 
                                        <th>Party</th>
                                        <th>Lot No</th>
                                        <th>Date</th>
                                        <th>Design</th>
                                        <th>Pcs</th>
                                        <th>Miss Print</th>
                                        <th>Value</th>
                                        <th>Sub Total</th>
                                    </tr>                                  
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($printing as $key => $value):?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo ucwords($value->srt_name); ?></td>
                                        <td><?php echo LOT.$value->lot_no; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($value->date));  ?></td>
                                        <td><?php echo $value->design_no; ?></td>
                                        <td><?php $pcs[]=$value->pcs; echo $value->pcs;  ?></td>
                                        <td><?php echo $value->miss_pcs; ?></td>
                                        <td><?php echo number_format($value->cloth_value,2);  ?></td>
                                        <td><?php $sub_total[]=$value->cloth_value*$value->pcs; echo number_format(($value->cloth_value*$value->pcs),2); ?></td>
                                    </tr> 
                                    <?php $i++; endforeach;?>
                                    <tr>
                                      <td colspan="5"></td>
                                      <td><?php echo array_sum($pcs); ?></td>
                                      <td colspan="2"></td>
                                      <td><?php echo number_format(array_sum($sub_total),2); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <h4 class="m-t-10 header-title text-center">N-A</h4>
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
               