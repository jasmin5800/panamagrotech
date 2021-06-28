<style type="text/css">
  .restable{
      width: 100%; 
      min-width: 720px;   
  }
  .divscroll{
      overflow-x: auto;
  }
  .table-borderless > tbody > tr > td, .table-borderless > tbody > tr > th, .table-borderless > tfoot > tr > td, .table-borderless > tfoot > tr > th, .table-borderless > thead > tr > td, .table-borderless > thead > tr > th {
            padding: 7px 8px;
  }
  .table td, .table th {
    padding: 2px;
  }
  .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th  {
    padding: 3px;
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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Stock/index');?>"><?php echo $page_title; ?></a></li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
           <div class="col-12">
               <div class="card-box">
                    <h4 class="m-t-0 header-title m-b-30 text-right">PLATE CHITTI</h4>
                    <h2 class="m-t-0 text-center"><?php echo FULL_NAME; ?></h2>
                    <h4 class="m-t-0 header-title text-center"><?php echo ADDRESS1; ?></h4>
                    <div class="row m-t-50">
                        <div class="col-md-5">
                            <table class="table table-borderless">
                                <tr>
                                    <th style="width:30%">Design</th>
                                    <td> <?php echo ucwords($plate->design); ?></td>
                                </tr>
                                <tr>
                                    <th>Remark</th>
                                    <td><?php echo ucwords($plate->remark); ?></td>
                                </tr>  
                            </table>
                        </div>
                        <div class="offset-md-4 col-md-3">
                            <table class="table table-borderless">
                                <tr>
                                  <th style="width:50%">Challan No:</th>
                                  <td><?php echo $plate->challan_no;; ?></td>
                                </tr>
                                <tr>
                                  <th>Date</th>
                                  <td><?php echo date('d/m/Y', strtotime($plate->date)); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                            <table class="table text-center table-bordered m-t-20" cellspacing="0">
                                <thead>
                                    <tr>
                                      <th width="5%">Sr</th>
                                      <th width="20%">FRAME COLOR NAME </th>
                                      <th colspan="2">MATCH NO  &&  CLOTHE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($custom_plate as $key=>$value): ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $key;?></td> 
                                              <td colspan="2">
                                                  <table width="100%">
                                                    <tbody>
                                                      <?php foreach ($value as $key2 => $value2): ?>
                                                      <?php if($key2=="1"): ?>
                                                      <tr>
                                                        <td width="5%">
                                                          <?php echo $key2; ?>
                                                        </td>
                                                        <?php foreach ($value2 as $key3 => $value3): ?>
                                                        <td width="17%">
                                                            <span style="border-bottom: 2px solid; text-align: center; padding: 0px 5px;">
                                                              <?php echo $value3['color_name']."<br/>"; ?>
                                                            </span>
                                                            <span>
                                                              <?php echo $value3['gram']; ?>
                                                            </span>
                                                        </td>
                                                         <?php endforeach;?>
                                                         <td></td>
                                                      </tr>
                                                    <?php endif;?>
                                                      <?php endforeach;?>
                                                    </tbody>
                                                  </table>
                                              </td>
                                        </tr>
                                    <?php $i++; endforeach;?>
                                </tbody>
                          </table>
                      </div>
                      <div class="col-md-6">
                            <table class="table text-center table-bordered m-t-20" cellspacing="0">
                                <thead>
                                    <tr>
                                      <th width="5%">Sr</th>
                                      <th width="20%">FRAME COLOR NAME </th>
                                      <th colspan="2">MATCH NO  &&  CLOTHE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($custom_plate as $key=>$value): ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $key;?></td> 
                                              <td colspan="2">
                                                  <table width="100%">
                                                    <tbody>
                                                      <?php foreach ($value as $key2 => $value2): ?>
                                                      <?php if($key2=="2"): ?>
                                                      <tr>
                                                        <td width="5%">
                                                          <?php echo $key2; ?>
                                                        </td>
                                                        <?php foreach ($value2 as $key3 => $value3): ?>
                                                        <td width="17%">
                                                            <span style="border-bottom: 2px solid; text-align: center; padding: 0px 5px;">
                                                              <?php echo $value3['color_name']."<br/>"; ?>
                                                            </span>
                                                            <span>
                                                              <?php echo $value3['gram']; ?>
                                                            </span>
                                                        </td>
                                                         <?php endforeach;?>
                                                         <td></td>
                                                      </tr>
                                                    <?php endif;?>
                                                      <?php endforeach;?>
                                                    </tbody>
                                                  </table>
                                              </td>
                                        </tr>
                                    <?php $i++; endforeach;?>
                                </tbody>
                          </table>
                      </div>
                      <div class="col-md-6">
                            <table class="table text-center table-bordered m-t-20" cellspacing="0">
                                <thead>
                                    <tr>
                                      <th width="5%">Sr</th>
                                      <th width="20%">FRAME COLOR NAME </th>
                                      <th colspan="2">MATCH NO  &&  CLOTHE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($custom_plate as $key=>$value): ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $key;?></td> 
                                              <td colspan="2">
                                                  <table width="100%">
                                                    <tbody>
                                                      <?php foreach ($value as $key2 => $value2): ?>
                                                      <?php if($key2=="3"): ?>
                                                      <tr>
                                                        <td width="5%">
                                                          <?php echo $key2; ?>
                                                        </td>
                                                        <?php foreach ($value2 as $key3 => $value3): ?>
                                                        <td width="17%">
                                                            <span style="border-bottom: 2px solid; text-align: center; padding: 0px 5px;">
                                                              <?php echo $value3['color_name']."<br/>"; ?>
                                                            </span>
                                                            <span>
                                                              <?php echo $value3['gram']; ?>
                                                            </span>
                                                        </td>
                                                         <?php endforeach;?>
                                                         <td></td>
                                                      </tr>
                                                    <?php endif;?>
                                                      <?php endforeach;?>
                                                    </tbody>
                                                  </table>
                                              </td>
                                        </tr>
                                    <?php $i++; endforeach;?>
                                </tbody>
                          </table>
                      </div>
                      <div class="col-md-6">
                            <table class="table text-center table-bordered m-t-20" cellspacing="0">
                                <thead>
                                    <tr>
                                      <th width="5%">Sr</th>
                                      <th width="20%">FRAME COLOR NAME </th>
                                      <th colspan="2">MATCH NO  &&  CLOTHE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($custom_plate as $key=>$value): ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $key;?></td> 
                                              <td colspan="2">
                                                  <table width="100%">
                                                    <tbody>
                                                      <?php foreach ($value as $key2 => $value2): ?>
                                                      <?php if($key2=="4"): ?>
                                                      <tr>
                                                        <td width="5%">
                                                          <?php echo $key2; ?>
                                                        </td>
                                                        <?php foreach ($value2 as $key3 => $value3): ?>
                                                        <td width="17%">
                                                            <span style="border-bottom: 2px solid; text-align: center; padding: 0px 5px;">
                                                              <?php echo $value3['color_name']."<br/>"; ?>
                                                            </span>
                                                            <span>
                                                              <?php echo $value3['gram']; ?>
                                                            </span>
                                                        </td>
                                                         <?php endforeach;?>
                                                         <td></td>
                                                      </tr>
                                                    <?php endif;?>
                                                      <?php endforeach;?>
                                                    </tbody>
                                                  </table>
                                              </td>
                                        </tr>
                                    <?php $i++; endforeach;?>
                                </tbody>
                          </table>
                      </div>
                   </div>
               </div>
           </div>
       </div>
    </div> 
</div>