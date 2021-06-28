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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('PrintAll/patla_lot');?>"><?php echo $page_title; ?></a></li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-md-12">
                <div class="card-box">
                    <div class="row m-t-50">
                        <div class="col-md-12">
                            <h4 class="m-t-0 header-title text-center">LOT NO : <?php echo LOT.$cut->lot_no;?>  &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; PARTY : <?php echo $cut->party_name ?>   &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; ITEM : <?php echo $cut->item_name; ?> </h4>
                        </div>
                        <div class="col-md-12 divscroll">
                            <h4 class="m-t-10 header-title text-center">Devide</h4>
                            <?php if(isset($devide) && !empty($devide)) : ?>
                            <table class="table text-center table-bordered m-t-0 restable" style="width: 100%" >
                                <thead>
                                    <tr>
                                        <th>No</th> 
                                        <th>Patla</th>       
                                        <th>Devide Pcs</th>      
                                        <th width="60%"></th>
                                    </tr>                                  
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($devide as $key => $value):?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value->patla_name; ?></td>
                                        <td><?php echo $value->devide_pcs; ?></td>
                                        <td></td>
                                    </tr> 
                                    <?php $i++; endforeach;?>
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
                                        <th>Patla</th>   
                                        <th>Printing Pcs</th>
                                        <th>Miss Print</th>
                                        <th>White Saree</th>
                                    </tr>                                  
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($printing as $key => $value):?>
                                    <tr>
                                        <?php 
                                            $total_pcs= $value->printing_pcs+$value->miss_pcs;
                                            $query=$this->db->query("SELECT SUM(devide_pcs) as devide_pcs FROM devide WHERE patla_id='".$value->patla_id."'")->row();
                                            $devide_pcs=$query->devide_pcs;
                                            $result=$devide_pcs-$total_pcs;
                                        ?>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value->patla_name; ?></td>
                                        <td><?php echo $value->printing_pcs; ?></td>
                                        <td><?php echo $value->miss_pcs; ?></td>
                                        <td><?php echo $result; ?></td>
                                    </tr> 
                                    <?php $i++; endforeach;?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <h4 class="m-t-10 header-title text-center">N-A</h4>
                        <?php endif; ?>
                        </div>
                    </div>
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
               