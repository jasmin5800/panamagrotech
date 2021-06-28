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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('PrintAll/stock');?>"><?php echo $page_title; ?></a></li>
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
                            <h4 class="m-t-0 m-b-20 header-title text-center">Stock</h4>
                        </div>
                        <div class="col-md-12">
                            <form method="get" action="<?php echo base_url("PrintAll/stock")?>">
                                <div class="offset-md-3 col-md-6">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Party</label>
                                        <div class="col-sm-9">
                                          <select name="party">
                                              <option value="all">All</option>
                                              <?php foreach ($party as $key => $value):?>
                                              <option value="<?php echo $value->party_id ; ?>"   <?php echo (($display)?(($value->party_id ==$edit_party)?"selected":"") :"") ; ?> ><?php echo $value->party_name; ?></option>
                                              <?php endforeach; ?>
                                          </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary btn-bordered waves-effect w-md waves-light">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php if($display):?>
                    <div class="row m-t-50">
                        <div class="col-md-12 divscroll">
                            <h4 class="m-t-10 header-title text-center">Stock  &nbsp;  &nbsp; <?php echo $party_name; ?></h4>
                            <?php if(isset($stock) && !empty($stock)) :?>
                            <table class="table text-center table-bordered m-t-0 restable" >
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <?php if($party_name=="all"):?> 
                                        <th>Party</th>  
                                        <?php endif; ?>  
                                        <th>Item Name</th>
                                        <th>Challan</th>
                                        <th>Date</th>
                                        <th>T Bala</th>
                                        <th>Meter</th>
                                        <th>Value</th> 
                                    </tr>                                  
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($stock as $key => $value):?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <?php if($party_name=="all"):?> 
                                        <td><?php echo $value->party_name; ?></td>
                                        <?php endif; ?> 
                                        <td><?php echo $value->item_name; ?></td>
                                        <td><?php echo $value->challan_no; ?></td>
                                        <td><?php echo date('d/m/Y',strtotime($value->date)); ?></td>
                                        <td><?php echo $value->t_bala;  ?></td>
                                        <td><?php echo $value->total_meter;  ?></td>
                                        <td><?php echo $value->meter_value;  ?></td>
                                    </tr> 
                                    <?php $i++; endforeach;?>
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
    $('select').select2();
});
</script>
               