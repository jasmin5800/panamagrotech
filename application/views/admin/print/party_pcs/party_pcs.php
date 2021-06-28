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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('PrintAll/party_pcs');?>"><?php echo $page_title; ?></a></li>
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
                            <h4 class="m-t-0 m-b-20 header-title text-center">Party Detail </h4>
                        </div>
                        <div class="col-md-12 m-t-20">
                            <form method="get" action="<?php echo base_url("PrintAll/party_pcs")?>">
                                <div class="row">   
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <select name="party_id">
                                                    <?php foreach ($party as $key => $value): ?>
                                                    <option value="<?= $value->party_id; ?>"><?= $value->party_name; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>  
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Date</label>
                                            <div class="col-sm-10" id="div-date">
                                                <div class="input-daterange input-group" id="date-range">
                                                    <input type="text" autocomplete="off" class="form-control" name="start" value="<?php echo ((isset($start) && !empty($start))?$start:date('d/m/Y',strtotime('-1 month'))); ?>">
                                                    <input type="text" autocomplete="off" class="form-control" name="end" value="<?php echo ((isset($end) && !empty($end))?$end:date('d/m/Y')); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row m-t-30">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary btn-bordered waves-effect w-md waves-light">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php if($display):?>
                    <div class="row m-t-50">
                        <div class="col-md-12 divscroll">
                            <h4 class="m-t-10 header-title text-center">Cut</h4>
                            <h4 class="m-t-10 header-title text-center"><?php echo $start." To ".$end;?></h4>
                            <?php if($cut): ?>
                            <table class="table text-center table-bordered m-t-0 restable" style="width: 100%" >
                                <thead>
                                    <tr>
                                        <th>No</th> 
                                        <th>Name</th> 
                                        <th>Challan No</th>        
                                        <th>Lot No</th>  
                                        <th>Date</th> 
                                        <th>Party</th>
                                    </tr>                                  
                                </thead>
                                <tbody>
                                    <?php $i=1; //foreach ($cut as $key => $value):?>
                                    <tr>
                                        
                                    </tr> 
                                    <?php $i++; //endforeach;?>
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
    var date=$('#div-date').html();
    console.log(date);
    jQuery('#date-range').datepicker({
        toggleActive: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });
});
</script>
               