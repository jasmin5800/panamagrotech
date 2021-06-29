<div class="content">
  <div class="container-fluid" >
      <div class="row">
          <div class="col-12">
              <div class="page-title-box">
                  <h4 class="page-title float-left">GARANU</h4>
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
                  <h4 class="header-title m-t-0"><?php echo (($method=="edit")?"Update Purchase":"Add Garanu" )?></h4><br>
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
                                              echo '<option value="'.$party->id_party .'">'.$party->name.'</option>';
                                            }
                                            ?>
                                          </select>
                                      </div>
                              </div>
                          </div>
                          <div class="col-md-6">
                              
                              <div class="form-group row">
                                  <label for="date" class="col-3 col-form-label">Date</label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="datepicker-autoclose" title="Date" name="date" placeholder="Date" value="<?php echo date('d/m/Y');?>">
                                      
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
                                                <th>TOUCH</th>
                                                <th>FINE</th>
                                                <th></th>                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id="xMsaterTr">
                                              <td width="10%">
                                                  <select name="item_id[]" class="sItem_id"  data-live-search="true"   data-style="btn-custom" required>
                                                  <option></option>
                                                      <?php
                                                      foreach ($item as  $item) {
                                                        echo '<option value="'.$item->id_item.'">'.$item->name.'</option>';
                                                      }
                                                      ?>
                                                  </select>
                                              </td>
                                              <td>
                                                  <input type="number" name="weight[]" class="form-control mGr_W"  placeholder="GR WT " required step="any"/>
                                              </td>
                                             
                                              <td>
                                                  <input type="number" name="touch[]" class="form-control mtouch"  placeholder="TOUCH" step="any" />
                                              </td>
                                             
                                              <td>
                                              <input type="number" name="fine[]" class="form-control mFine"  readonly placeholder="FINE" step="any"/>
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
                         
                         
                                       
                          <div class="col-md-4  m-b-30">
                              <div class="form-group row">
                                 <label for="t_fine" class="col-3 col-form-label">Fine</label>
                                     <div class="col-9">
                                        <input type="number" class="form-control tFine"  name="fine1" placeholder="Total fine1" value="" readonly step="any"/>
                                     </div>
                              </div>
                              <div class="form-group row">
                                 <label for="t_fine" class="col-3 col-form-label">M TOUCH</label>
                                     <div class="col-9">
                                        <input type="number" class="form-control s_Touch"  name="m_touch1" placeholder="m_touch1" value=""  step="any"/>
                                     </div>
                              </div>
                              <div class="form-group row">
                                 <label for="t_labour" class="col-3 col-form-label">r_garanu</label>
                                     <div class="col-9">
                                        <input type="number" class="form-control rGaranu"  name="r_garanu" placeholder="r_garanu" value="" readonly step="any"/ >
                                     </div>
                              </div>
                              <div class="form-group row">
                                 <label for="t_fine" class="col-3 col-form-label">gWeight</label>
                                     <div class="col-9">
                                        <input type="number" class="form-control t_gweight"  name="f_baad1" placeholder="f_baad1" value="" readonly step="any"/>
                                     </div>
                              </div>
                            
                              <div class="form-group row">
                                 <label for="t_fine" class="col-3 col-form-label">r_copper</label>
                                     <div class="col-9">
                                        <input type="number" class="form-control r_copper"  name="r_copper" placeholder="r copper" value="" readonly step="any"/>
                                     </div>
                              </div>
                              <div class="form-group row">
                                 <label for="t_fine" class="col-3 col-form-label">copper_t</label>
                                     <div class="col-9">
                                        <input type="number" class="form-control t_copper"  name="copper_t" placeholder="copper_t" value="2.5" readonly step="any"/>
                                     </div>
                              </div>
                              <div class="form-group row">
                                 <label for="t_fine" class="col-3 col-form-label">copper_f1</label>
                                     <div class="col-9">
                                        <input type="number" class="form-control f_copper"  name="copper_f1" placeholder="copper_f1" value="" readonly step="any"/>
                                     </div>
                              </div>
                          </div><div class="col-md-4  m-b-30">
                              <div class="form-group row">
                                 <label for="t_fine" class="col-3 col-form-label">copper_f2</label>
                                     <div class="col-9">
                                        <input type="number" class="form-control f_copper"  name="copper_f2" placeholder="copper_f2" value="" readonly step="any"/>
                                     </div>
                              </div>
                        
                              <div class="form-group row">
                                 <label for="t_fine" class="col-3 col-form-label">fine2</label>
                                     <div class="col-9">
                                        <input type="number" class="form-control tweight"  name="fine2" placeholder="fine2" value="" readonly step="any"/>
                                     </div>
                              </div>
                              <div class="form-group row">
                                 <label for="t_fine" class="col-3 col-form-label">total_f</label>
                                     <div class="col-9">
                                        <input type="number" class="form-control fweight"  name="total_f" placeholder="total_f" value="" readonly step="any"/>
                                     </div>
                              </div>
                              <div class="form-group row">
                                 <label for="t_fine" class="col-3 col-form-label">m_touch2</label>
                                     <div class="col-9">
                                        <input type="number" class="form-control s_Touch1"  name="m_touch2" placeholder="m_touch2" value=""  step="any"/>
                                     </div>
                              </div>
                              <div class="form-group row">
                                 <label for="t_labour" class="col-3 col-form-label">Garanu</label>
                                     <div class="col-9">
                                        <input type="number" class="form-control rc_garanu"  name="garanu" placeholder="garanu" value="" readonly step="any"/ >
                                     </div>
                              </div>
                              <div class="form-group row">
                                 <label for="t_fine" class="col-3 col-form-label">f_baad2</label>
                                     <div class="col-9">
                                        <input type="number" class="form-control t_gweight"  name="f_baad2" placeholder=" f_baad2" value="" readonly step="any"/>
                                     </div>
                              </div>
                              <div class="form-group row">
                                 <label for="t_fine" class="col-3 col-form-label">Final Copper</label>
                                     <div class="col-9">
                                        <input type="number" class="form-control finalfine"  name="final_copper" placeholder="final_copper" value="" readonly step="any"/>
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
<script src="<?php echo base_url('assets/admin/custom/garanu.js');?>"></script>