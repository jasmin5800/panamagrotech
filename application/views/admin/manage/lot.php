<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left"><?php echo $page_title; ?></h4>
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Dashbord');?>"><?php echo COMPANY; ?></a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Menage/lot');?>"><?php echo $page_title; ?></a></li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row">
           <div class="col-md-12">
               <div class="card-box">
                  <div class="row">
                      <div class="col-md-12">
                          <h4 class="m-t-0 m-b-20 header-title text-center">Report Lot</h4>
                      </div>
                      <div class="offset-md-3 col-md-6">
                          <form method="get" action="<?php echo base_url("Manage/lot")?>">
                              <div class="form-group row">
                                  <label class="col-sm-2 col-form-label">LOT NO</label>
                                  <div class="col-sm-10">
                                    <select name="lot_no">
                                        <?php foreach ($lot_no as $key => $value):?>
                                        <option value="<?php echo $value->lot_no; ?>"   <?php echo (($display)?(($value->lot_no==$edit_lotno)?"selected":"") :"") ; ?> ><?php echo LOT.$value->lot_no; ?></option>
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
                  <?php if($display): ?>
                  <div class="row m-t-40">
                      <div class="col-md-12">
                          <div class="table-responsive">
                           <h4 class="m-t-0 m-b-10 header-title text-center">Balance</h4>
                              <table class="table text-center">
                                  <thead class="thead-light">
                                      <tr>
                                        <th>No</th>
                                        <th>Cut Val</th>
                                        <th>Cut Pcs</th>                      
                                        <th>Print Clo</th>      
                                        <th>Silicate  Clo</th>
                                        <th>Dholai Clo</th>
                                        <th>Kanji Clo </th>
                                        <th>Ghadi Clo </th>
                                        <th>Embroidery Clo</th>                     
                                        <th>Packing Clo </th>
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
                      </div>
                      <?php if($cut): ?>
                      <div class="col-md-12 m-t-20">
                          <div class="table-responsive">
                           <h4 class="m-t-0 m-b-10 header-title text-center">Cut</h4>
                              <table class="table text-center table-actions-bar">
                                  <thead class="thead-light">
                                      <tr>
                                        <th>No</th> 
                                        <th>Challan No</th>       
                                        <th>Name</th>      
                                        <th>Lot No</th>
                                        <th>Party</th>
                                        <th>Item</th>
                                        <th>Date</th>
                                        <th>T Pcs </th>
                                        <th>T Mtr </th>
                                        <th>Cut Mtr</th>
                                        <th>Fent</th>                     
                                        <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <tr>
                                          <td>1</td>
                                          <td><?php echo $cut->challan_no; ?></td>
                                          <td><?php echo strtoupper($cut->name);  ?></td>
                                          <td><?php echo strtoupper(LOT.$cut->lot_no);  ?></td>
                                          <td><?php echo $cut->srt_name; ?></td>
                                          <td><?php echo $cut->item_name; ?></td>
                                          <td><?php echo date('d/m/Y',strtotime($cut->date)); ?></td>
                                          <td><?php echo $cut->total_pcs; ?></td>
                                          <td><?php echo number_format($cut->purchase_mtr,2); ?></td>
                                          <td><?php echo number_format($cut->cut_mtr,2); ?></td>
                                          <td><?php echo number_format($cut->total_fent,2); ?></td>
                                          <td>
                                            <a href="<?php echo base_url('Cut/get_editfrm/').$cut->id_cut; ?>" class="table-action-btn">
                                              <i class="mdi mdi-pencil"></i>
                                            </a>
                                            <a href="<?php echo base_url('Cut/view_invoice/').$cut->id_cut; ?>" class="table-action-btn">
                                              <i class="mdi mdi-eye"></i>
                                            </a>
                                          </td>
                                      </tr> 
                                  </tbody>
                              </table>
                          </div>
                      </div>
                      <?php endif; ?>
                      <?php if($devide): ?>
                      <div class="col-md-12 m-t-20">
                          <div class="table-responsive">
                           <h4 class="m-t-0 m-b-10 header-title text-center">Devide</h4>
                              <table class="table text-center table-actions-bar">
                                  <thead class="thead-light">
                                      <tr>
                                        <th>No</th> 
                                        <th>Challan No</th>       
                                        <th>Lot No</th>
                                        <th>Date</th>
                                        <th>Devide Pcs</th>
                                        <th>Patla</th>      
                                        <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php $i=1; foreach ($devide as $key => $value): ?>
                                      <tr>
                                          <td><?php echo $i;?></td>
                                          <td><?php echo $value->challan_no; ?></td>
                                          <td><?php echo strtoupper(LOT.$value->lot_no);  ?></td>
                                          <td><?php echo date('d/m/Y',strtotime($value->date)); ?></td>
                                          <td><?php echo $value->devide_pcs;  ?></td>
                                          <td><?php echo $value->patla_name; ?></td>
                                          <td>
                                            <a href="<?php echo base_url('Devide/get_editfrm/').$value->id_devide; ?>" class="table-action-btn">
                                              <i class="mdi mdi-pencil"></i>
                                            </a>
                                            <a href="<?php echo base_url('Devide/view_invoice/').$value->id_devide; ?>" class="table-action-btn">
                                              <i class="mdi mdi-eye"></i>
                                            </a>
                                          </td>
                                      </tr> 
                                      <?php $i++; endforeach;?>
                                  </tbody>
                              </table>
                          </div>
                      </div>
                      <?php endif; ?>
                      <?php if($printing): ?>
                      <div class="col-md-12 m-t-20">
                          <div class="table-responsive">
                           <h4 class="m-t-0 m-b-10 header-title text-center">Printing</h4>
                              <table class="table text-center table-actions-bar">
                                  <thead class="thead-light">
                                      <tr>
                                          <th>No</th> 
                                          <th>Challan No</th>   
                                          <th>Lot No</th>      
                                          <th>Date</th>
                                          <th>Total Design</th>
                                          <th>Total Pcs</th>
                                          <th>Miss Print</th>
                                          <th>Cloth Value</th>
                                          <th>GRAND TOTAL</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <tr>
                                          <td>1</td>
                                          <td><?php echo $printing->challan_no; ?></td>
                                          <td><?php echo strtoupper(LOT.$printing->lot_no);  ?></td>
                                          <td><?php echo date('d/m/Y',strtotime($printing->date)); ?></td>
                                          <td><?php echo $printing->t_design; ?></td>
                                          <td><?php echo $printing->t_pcs; ?></td>
                                          <td><?php echo $printing->t_missprint;  ?></td>
                                          <td><?php echo number_format($printing->cloth_value,2); ?></td>
                                          <td><?php echo number_format($printing->g_total,2); ?></td>
                                          <td>
                                            <a href="<?php echo base_url('Printing/get_editfrm/').$printing->printing_id ; ?>" class="table-action-btn">
                                              <i class="mdi mdi-pencil"></i>
                                            </a>
                                            <a href="<?php echo base_url('Printing/view_invoice/').$printing->printing_id ; ?>" class="table-action-btn">
                                              <i class="mdi mdi-eye"></i>
                                            </a>
                                          </td>
                                      </tr> 
                                  </tbody>
                              </table>
                          </div>
                      </div>
                      <?php endif; ?>
                      <?php if($processing): ?>
                      <div class="col-md-12 m-t-20">
                          <div class="table-responsive">
                           <h4 class="m-t-0 m-b-10 header-title text-center">Process</h4>
                              <table class="table text-center table-actions-bar">
                                  <thead class="thead-light">
                                      <tr>
                                        <th>No</th> 
                                        <th>Challan No</th>       
                                        <th>Lot No</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Process</th>
                                        <th>T Design</th>
                                        <th>T Pcs</th>
                                        <th>Cloth Val</th>
                                        <th>G Total</th>
                                        <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php $i=1; foreach ($processing as $key => $value): ?>
                                      <tr>
                                          <td><?php echo $i;?></td>
                                          <td><?php echo $value->challan_no; ?></td>
                                          <td><?php echo strtoupper(LOT.$value->lot_no);  ?></td>
                                          <td><?php echo date('d/m/Y',strtotime($value->date)); ?></td>
                                          <td><?php echo strtoupper($value->name);  ?></td>
                                          <td><?php echo strtoupper($value->process_name);  ?></td>
                                          <td><?php echo $value->t_design; ?></td>
                                          <td><?php echo $value->t_pcs; ?></td>
                                          <td><?php echo number_format($value->cloth_value,2); ?></td>
                                          <td><?php echo number_format($value->g_total,2); ?></td>
                                          <td>
                                            <a href="<?php echo base_url('Process/view_invoice/').$value->process_id ; ?>" class="table-action-btn">
                                              <i class="mdi mdi-eye"></i>
                                            </a>
                                          </td>
                                      </tr> 
                                      <?php $i++; endforeach;?>
                                  </tbody>
                              </table>
                          </div>
                      </div>
                      <?php endif; ?>
                      <?php if($ghadi): ?>
                      <div class="col-md-12 m-t-20">
                          <div class="table-responsive">
                           <h4 class="m-t-0 m-b-10 header-title text-center">Ghadi</h4>
                              <table class="table text-center table-actions-bar">
                                  <thead class="thead-light">
                                      <tr>
                                        <th>No</th> 
                                        <th>Challan No</th>       
                                        <th>Lot No</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Process</th>
                                        <th>T DSG</th>
                                        <th>T Pcs</th>
                                        <th>Cloth Val</th>
                                        <th>G Total</th>
                                        <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php $i=1; foreach ($ghadi as $key => $value): ?>
                                      <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value->challan_no; ?></td>
                                        <td><?php echo LOT.$value->lot_no; ?></td>
                                        <td><?php echo date('d/m/Y',strtotime($value->date)); ?></td>
                                        <td><?php echo strtoupper($value->name);  ?></td>
                                        <td><?php echo (($value->child_sb=="A")?"Kanji":(($value->child_sb=="B")?"Embroidery":"Ghadi-self")); ?></td>
                                        <td><?php echo $value->t_design; ?></td>
                                        <td><?php echo $value->t_pcs; ?></td>
                                        <td><?php echo number_format($value->cloth_value,2); ?></td>
                                        <td><?php echo number_format($value->sub_total,2); ?></td>
                                          <td>
                                            <a href="<?php echo base_url('Ghadi/view_invoice/').$value->ghadi_id ; ?>" class="table-action-btn">
                                              <i class="mdi mdi-eye"></i>
                                            </a>
                                          </td>
                                      </tr> 
                                      <?php $i++; endforeach;?>
                                  </tbody>
                              </table>
                          </div>
                      </div>
                      <?php endif; ?>
                      <?php if($emdevide): ?>
                      <div class="col-md-12 m-t-20">
                          <div class="table-responsive">
                           <h4 class="m-t-0 m-b-10 header-title text-center">Em Devide</h4>
                              <table class="table text-center table-actions-bar">
                                  <thead class="thead-light">
                                      <tr>
                                        <th>No</th> 
                                        <th>Challan No</th>       
                                        <th>Lot No</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Process</th>
                                        <th>T DSG</th>
                                        <th>T Pcs</th>
                                        <th>Cloth Val</th>
                                        <th>G Total</th>
                                        <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php $i=1; foreach ($emdevide as $key => $value): ?>
                                      <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value->challan_no; ?></td>
                                        <td><?php echo LOT.$value->lot_no; ?></td>
                                        <td><?php echo date('d/m/Y',strtotime($value->date)); ?></td>
                                        <td><?php echo strtoupper($value->name);  ?></td>
                                        <td><?php echo (($value->child_sb=="A")?"Ghadi":"Em Devide"); ?></td>
                                        <td><?php echo $value->t_design; ?></td>
                                        <td><?php echo $value->t_pcs; ?></td>
                                        <td><?php echo number_format($value->cloth_value,2); ?></td>
                                        <td><?php echo number_format($value->g_total,2); ?></td>
                                          <td>
                                            <a href="<?php echo base_url('Emdevide/view_invoice/').$value->emdevide_id  ; ?>" class="table-action-btn">
                                              <i class="mdi mdi-eye"></i>
                                            </a>
                                          </td>
                                      </tr> 
                                      <?php $i++; endforeach;?>
                                  </tbody>
                              </table>
                          </div>
                      </div>
                      <?php endif; ?>
                      <?php if($embroidery): ?>
                      <div class="col-md-12 m-t-20">
                          <div class="table-responsive">
                           <h4 class="m-t-0 m-b-10 header-title text-center">Embroidery</h4>
                              <table class="table text-center table-actions-bar">
                                  <thead class="thead-light">
                                      <tr>
                                        <th>No</th> 
                                        <th>Challan No</th>       
                                        <th>Lot No</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Process</th>
                                        <th>T DSG</th>
                                        <th>T Pcs</th>
                                        <th>Cloth Val</th>
                                        <th>G Total</th>
                                        <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php $i=1; foreach ($embroidery as $key => $value): ?>
                                      <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value->challan_no; ?></td>
                                        <td><?php echo LOT.$value->lot_no; ?></td>
                                        <td><?php echo date('d/m/Y',strtotime($value->date)); ?></td>
                                        <td><?php echo strtoupper($value->name);  ?></td>
                                        <td><?php echo (($value->child_sb=="A")?"Ghadi":"Em Devide"); ?></td>
                                        <td><?php echo $value->t_design; ?></td>
                                        <td><?php echo $value->t_pcs; ?></td>
                                        <td><?php echo number_format($value->cloth_value,2); ?></td>
                                        <td><?php echo number_format($value->g_total,2); ?></td>
                                          <td>
                                            <a href="<?php echo base_url('Embroidery/view_invoice/').$value->embroidery_id   ; ?>" class="table-action-btn">
                                              <i class="mdi mdi-eye"></i>
                                            </a>
                                          </td>
                                      </tr> 
                                      <?php $i++; endforeach;?>
                                  </tbody>
                              </table>
                          </div>
                      </div>
                      <?php endif; ?>
                      <?php if($packing): ?>
                      <div class="col-md-12 m-t-20">
                          <div class="table-responsive">
                           <h4 class="m-t-0 m-b-10 header-title text-center">Packing</h4>
                              <table class="table text-center table-actions-bar">
                                  <thead class="thead-light">
                                      <tr>
                                        <th>No</th> 
                                        <th>Challan No</th>       
                                        <th>Lot No</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Process</th>
                                        <th>T DSG</th>
                                        <th>T Pcs</th>
                                        <th>Cloth Val</th>
                                        <th>G Total</th>
                                        <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php $i=1; foreach ($packing as $key => $value): ?>
                                      <tr>
                                        <?php $child_sb=(($value->child_sb=="A")? "GHADI-KANJI" :(($value->child_sb=="B")?"EMBROIDERY":(($value->child_sb=="C")?"GHADI-EMBRO":"SELF-GHADI")));?>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $value->challan_no; ?></td>
                                        <td><?php echo LOT.$value->lot_no; ?></td>
                                        <td><?php echo date('d/m/Y',strtotime($value->date)); ?></td>
                                        <td><?php echo strtoupper($value->name);  ?></td>
                                        <td><?php echo $child_sb; ?></td>
                                        <td><?php echo $value->t_design; ?></td>
                                        <td><?php echo $value->t_pcs; ?></td>
                                        <td><?php echo number_format($value->cloth_value,2); ?></td>
                                        <td><?php echo number_format($value->g_total,2); ?></td>
                                          <td>
                                            <a href="<?php echo base_url('Packing/view_invoice/').$value->packing_id   ; ?>" class="table-action-btn">
                                              <i class="mdi mdi-eye"></i>
                                            </a>
                                          </td>
                                      </tr> 
                                      <?php $i++; endforeach;?>
                                  </tbody>
                              </table>
                          </div>
                      </div>
                      <?php endif; ?>
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
            