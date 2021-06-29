<div class="content">
  <div class="container-fluid">
      <div class="row">
          <div class="col-12">
              <div class="page-title-box">
                  <h4 class="page-title float-left">AAVAK</h4>
                  <ol class="breadcrumb float-right">
                      <li class="breadcrumb-item"><a href="<?php echo base_url('dashbord');?>"><?php echo COMPANY; ?></a></li>
                      <li class="breadcrumb-item"><a href="#"><?php echo $page_title; ?></a></li>
                  </ol>
                  <div class="clearfix"></div>
              </div>
          </div>
      </div>
      <div class="row">
          <div class="col-lg-12">
              <div class="card-box ">
                  <h4 class="header-title m-t-0"><?php echo (($method=="edit")?"Update AAVAK":"Add AAVAK" )?></h4><br>
                  <form action="<?php echo $action; ?>" method="post" >
                      <div class="row">
                          <div class="col-md-6">   
                              <div class="form-group row">
                                  <label for="party_id" class="col-3 col-form-label">Party</label>
                                      <div class="col-9">
                                          <select data-live-search="true" data-style="btn-custom" name="party_id" id="party_id" data-parsley-required-message="You Must Select 1 Party" required >
                                            <option value="0">None</option>
                                            <?php
                                            foreach ($party as  $party) {
                                              echo '<option value="'.$party->id_party .'"'.
                                              (($method=="edit")?(($party->id_party ==$rough_purchase->party_id)?"selected":""):"")
                                              .' >'.$party->name.'</option>';
                                            }
                                            ?>
                                          </select>
                                      </div>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group row">
                                 <label for="invoice_no" class="col-3 col-form-label">No</label>
                                     <div class="col-9">
                                        <input type="text" class="form-control"  title="Invoice No" name="invoice_no" placeholder="Invoice No." value="<?php echo (($method=="edit")?$rough_purchase->invoice_no:$invoice['no_invoice'] )?>" required >
                                       
                                     </div>
                              </div>
                              <div class="form-group row">
                                  <label for="date" class="col-3 col-form-label">Date</label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="datepicker-autoclose" title="Date" name="date" placeholder="Date" value="<?php echo (($method=="edit")?(date('d/m/Y',strtotime($rough_purchase->date))):date('d/m/Y'));?>">
                                       <?php echo (($method=="edit")?'<input type="hidden" name="id_rough" required value="'.$rough_purchase->id_rough .'">':"");?>
                                    </div>
                              </div>
                          </div>
                      </div>
                      <div class="row">                        
                          <div class="col-md-12 m-b-20">
                              <div style="overflow-x:auto;">
                                 <h4 class="header-title m-t-0">Item Detail</h4>
                                    <table class="table" id="mastertbl" style="min-width: 1200px;">
                                        <thead>
                                            <tr>
                                                <th>ITEM</th>
                                                <th>GR WT</th>
                                                <!-- <th>BADLO</th>
                                               <th>TF</th> -->
                                                <th>FINE</th>
                                                <th>AMOUNT</th>
                                                <th></th>                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php if($method=="edit"):
                                            $j=1; 
                                            foreach ($rough_item as $rough_item) :
                                          ?>
                                          <tr>
                                              <td width="5%">
                                                  <select name="item_id[]" class="sItem_id"  data-live-search="true"   data-style="btn-custom" required>
                                                      <?php
                                                      $items=$this->General_model->get_all_where('item','status','1');
                                                      foreach ($items as  $items) {
                                                        echo '<option value="'.$items->id_item.'"'.(($items->id_item==$rough_item->item_id)?"selected":"").'>'.$items->name.'</option>';
                                                      }
                                                      ?>
                                                  </select>
                                              </td>
                                              <td>
                                                  <input type="number" name="mg_weight[]" class="form-control mGr_W"  placeholder="GR WT " required step="any" value="<?php echo $rough_item->gr_weight; ?>"/>
                                                  <input type="hidden" name="roughitem_id[]" class="form-control" required  value="<?php echo $rough_item->id; ?>" step="any" />
                                           
                                              </td>
                                            
                                              <!-- <td>
                                                  <input type="hidden" name="mt_badlo[]" class="form-control mBadlo"  placeholder="BADLO" required step="any"  value="0"  />
                                              </td>
                                             <td>
                                                  <input type="hidden" name="mtf[]" class="form-control mTf"  placeholder="TF"  value="0" step="any" />
                                              </td>  -->
                                             
                                              <td>
                                              <input type="number" name="mfine[]" class="form-control mFine"  readonly placeholder="FINE"  value="<?php echo $rough_item->fine; ?>" step="any" />
                                              </td>
                                              
                                              <td>
                                              <input type="number" name="mamount[]" class="form-control mAmount"  placeholder="AMOUNT" step="any" value="<?php echo $rough_item->amount; ?>"/>
                                              </td>
                                              <td>
                                                <?php if($j!=1):?>
                                                  <button type="button" data-id="masterDltBtn" data-value="<?php echo $rough_item->id; ?>" class="btn btn-icon waves-effect waves-light btn-warning btn-sm"><i class="mdi mdi-delete"></i></button>
                                                <?php endif; ?>
                                              </td>
                                          </tr>
                                          <?php $j++; endforeach; endif; ?>
                                            <tr id="xMsaterTr">
                                              <td width="10%">
                                                  <select name="item_id[]" class="sItem_id"  data-live-search="true"   data-style="btn-custom" required>
                                                      <?php
                                                      foreach ($item as  $item) {
                                                        echo '<option value="'.$item->id_item.'">'.$item->name.'</option>';
                                                      }
                                                      ?>
                                                  </select>
                                              </td>
                                              <td>
                                                  <input type="number" name="mg_weight[]" class="form-control mGr_W"  placeholder="GR WT " required step="any"/>
                                                  <input type="hidden" name="roughitem_id[]" class="form-control" required  value="0" step="any" />
                                              </td>
                                              
                                              <!-- <td>
                                                  <input type="hidden" name="mt_badlo[]" class="form-control mBadlo" value="0"    placeholder="Badlo" required step="any"/ >
                                              </td>
                                             <td>
                                                  <input type="hidden" name="mtf[]" class="form-control mTf" value="0"  placeholder="TF" step="any" />
                                              </td>  -->
                                             
                                              <td>
                                              <input type="number" name="mfine[]" class="form-control mFine"  readonly placeholder="FINE" step="any"/>
                                              </td>
                                              
                                              <td>
                                              <input type="number" name="mamount[]" class="form-control mAmount"  placeholder="AMOUNT" step="any"/>
                                              </td>
                                              <td>
                                                  <button type="button" class="btn btn-icon waves-effect waves-light masterRmvBtn  btn-danger btn-sm"><i class="fa fa-minus"></i></button>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td colspan="12"></td>
                                              <td><button type="button" class="btn btn-icon waves-effect waves-light btn-secondary btn-sm masterdAddBtn" style="margin-left: 2px;"> <i class=" fa fa-plus"></i> </button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                              </div>
                          </div>
                          <div class="col-md-4 m-b-30">
                            <div class="form-group row">
                               <label for="remark" class="col-3 col-form-label">Remark</label>
                                   <div class="col-9">
                                      <textarea  class="form-control"  name="remark" placeholder="REMARK"  ><?php echo (($method=="edit")?$rough_purchase->remark:"")?></textarea>
                                   </div>
                            </div>
                        
                            <div class="form-group row" style="display:none">
                                 <label for="t_fine" class="col-3 col-form-label">Tf</label>
                                     <div class="col-9">
                                        <input type="number" class="form-control "  name="tf" placeholder="tf" value="<?php echo (($method=="edit")?$rough_purchase->tf:'');?>"   step="any"/>
                                     </div>
                              </div>
                              <div class="form-group row">
                               <label for="remark" class="col-3 col-form-label">Previous Amount</label>
                                   <div class="col-9">
                                   <input type="number" class="form-control pamount"  name="pamount" placeholder="pamount" value="<?php echo (($method=="edit")?$rough_purchase->p_rs:'');?>"   step="any"/> <lable class="pamounts"><?php echo (($method=="edit")?$rough_purchase->status_prs:'');?></lable>
                                   <input type="hidden" class="form-control pamountst"  name="pamounts" placeholder="pamounts" value="<?php echo (($method=="edit")?$rough_purchase->status_prs:'');?>"   step="any"/>
                                    </div>
                            </div>

                            <div class="form-group row">
                                 <label for="t_fine" class="col-3 col-form-label">Previous Fine</label>
                                     <div class="col-9">
                                        <input type="number" class="form-control pfine"  name="pfine" placeholder="pfine" value="<?php echo (($method=="edit")?$rough_purchase->p_fine:'');?>"   step="any"/> <lable class="pfines"><?php echo (($method=="edit")?$rough_purchase->status_pfine:'');?></lable>
                                        <input type="hidden" class="form-control pfinest"  name="pfines" placeholder="pfine" value="<?php echo (($method=="edit")?$rough_purchase->status_pfine:'');?>"   step="any"/>
                                     </div>
                                    
                              </div>
                            
                          </div>
                          <div class="col-md-4 offset-md-4 m-b-30">
                              <div class="form-group row">
                                 <label for="t_fine" class="col-3 col-form-label">Total Fine</label>
                                     <div class="col-9">
                                        <input type="number" class="form-control tFine"  name="t_fine" placeholder="Total Fine" value="" readonly step="any"/>
                                     </div>
                              </div>
                              <div class="form-group row">
                                 <label for="t_labour" class="col-3 col-form-label">Total Amount</label>
                                     <div class="col-9">
                                        <input type="number" class="form-control tAmount"  name="t_amount" placeholder="Total Amount" value="" readonly step="any"/ >
                                     </div>
                              </div><div class="form-group row">
                                 <label for="t_fine" class="col-3 col-form-label">Round off Fine</label>
                                     <div class="col-9">
                                        <input type="number" class="form-control rFine"  name="r_fine" placeholder="Round off Fine" value="<?php echo (($method=="edit")?$rough_purchase->r_fine:'0');?>"  step="any"/>
                                     </div>
                              </div>
                              <div class="form-group row">
                                 <label for="t_labour" class="col-3 col-form-label">Round off Amount</label>
                                     <div class="col-9">
                                        <input type="number" class="form-control rAmount"  name="r_amount" placeholder="Round off Amount" value="<?php echo (($method=="edit")?$rough_purchase->r_amount:'0');?>"  step="any"/ >
                                     </div>
                              </div><div class="form-group row">
                                 <label for="t_fine" class="col-3 col-form-label">Total Fine</label>
                                     <div class="col-9">
                                        <input type="number" class="form-control tFine2"  name="t_fine2" placeholder="Total Fine2" value="" readonly step="any"/>
                                     </div>
                              </div>
                              <div class="form-group row">
                                 <label for="t_labour" class="col-3 col-form-label">Total Amount</label>
                                     <div class="col-9">
                                        <input type="number" class="form-control tAmount2"  name="t_amount2" placeholder="Total Amount2" value="" readonly step="any"/ >
                                     </div>
                              </div>
                              <div class="form-group row">
                               <label for="remark" class="col-3 col-form-label">Closing Amount</label>
                                   <div class="col-9">
                                   <input type="number" class="form-control camount"  name="camount" placeholder="camount" value="<?php echo (($method=="edit")?$rough_purchase->c_rs:'');?>"   step="any"/> <lable class="camounts"><?php echo (($method=="edit")?$rough_purchase->status_crs:'');?></lable>
                                   <input type="hidden" class="form-control camountst"  name="camounts" placeholder="camount" value="<?php echo (($method=="edit")?$rough_purchase->status_crs:'');?>"   step="any"/>
                                    </div>
                            </div>
                            <div class="form-group row">
                                 <label for="t_fine" class="col-3 col-form-label">Closing Fine</label>
                                     <div class="col-9">
                                        <input type="number" class="form-control cfine"  name="cfine" placeholder="cfine" value="<?php echo (($method=="edit")?$rough_purchase->c_fine:'');?>"   step="any"/> <lable class="cfines"><?php echo (($method=="edit")?$rough_purchase->status_cfine:'');?></lable>
                                        <input type="hidden" class="form-control cfinest"  name="cfines" placeholder="cfine" value="<?php echo (($method=="edit")?$rough_purchase->status_cfine:'');?>"   step="any"/>
                                     </div>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12 d-flex justify-content-center">
                          <button type="submit" onclick="return validateForm()" class="btn btn-purple waves-effect waves-light justify-content-center"><?php echo (($method=="edit")?"Update":"Add")?></button>                            
                        </div>                        
                      </div>
                  </form>
              </div> 
          </div>
      </div>
    </div> <!-- container -->
</div> <!-- content -->
<script type="text/javascript">
  <?php if($method=="edit"): ?>
    var method= "edit";
  <?php else: ?>
    var method="add";
  <?php endif; ?>
</script>
<script src="<?php echo base_url('assets/admin/custom/roughpurchase.js');?>"></script>