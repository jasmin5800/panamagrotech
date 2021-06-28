<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">
        <div id="sidebar-menu">
            <ul class="metismenu" id="side-menu">
                <li>
                    <a href="<?php echo base_url('Dashbord')?>"><i class="fi-air-play"></i><span class="badge badge-success pull-right"></span> <span> Dashbord </span></a>
                </li>
                <?php if($_SESSION['auth_role_id']=="1"):?>
                <li>
                    <a href="javascript: void(0);"><i class="mdi mdi-cloud-print"></i><span> Print </span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="<?php echo base_url('PrintAll/general_lot')?>">General Lot</a></li>
                        <li><a href="<?php echo base_url('PrintAll/party_lot')?>">Party Lot</a></li>
                        <li><a href="<?php echo base_url('PrintAll/patla_lot')?>">Patla Lot</a></li>
                        <li><a href="<?php echo base_url('PrintAll/cut_lot')?>">Cut</a></li>
                        <li><a href="<?php echo base_url('PrintAll/patla')?>">Patla</a></li>
                        <li><a href="<?php echo base_url('PrintAll/printing')?>">Printing</a></li>
                        <li><a href="<?php echo base_url('PrintAll/process')?>">Process</a></li>
                        <li><a href="<?php echo base_url('PrintAll/emdevide')?>">Em-Devide</a></li>
                        <li><a href="<?php echo base_url('PrintAll/embroidery')?>">Embroidery</a></li>
                        <li><a href="<?php echo base_url('PrintAll/stock')?>">Stock</a></li>
                    </ul>
                </li>
                <?php endif;?>
                <?php if($_SESSION['auth_role_id']=="1"):?>
                <li>
                    <a href="javascript: void(0);"><i class="fa fa-area-chart"></i><span>Manage</span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="<?php echo base_url('Manage/lot')?>">Lot</a></li>
                        <li><a href="<?php echo base_url('Manage/')?>">Lot Status</a></li>
                    </ul>
                </li>
                <?php endif;?>
                <?php if($_SESSION['auth_role_id']=="1"):?>
                <li>
                    <a href="javascript: void(0);"><i class="fa fa-sliders"></i><span>Company</span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="<?php echo base_url('Item')?>">Item</a></li>
                        <li><a href="<?php echo base_url('Party')?>">Party</a></li>
                        <li><a href="<?php echo base_url('Transport')?>">Transport</a></li>
                        <li><a href="<?php echo base_url('Patla')?>">Patla</a></li>
                        <li><a href="<?php echo base_url('EmUser')?>">Em User</a></li>
                    </ul>
                </li>
                <?php endif;?>
                <?php if($_SESSION['auth_role_id']=="1" || $_SESSION['auth_role_id']=="2"):?>
                <li>
                    <a href="javascript: void(0);"><i class="fa fa-cart-plus"></i><span> Stock </span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="<?php echo base_url('Stock/get_addfrm')?>">Create</a></li>
                        <li><a href="<?php echo base_url('Stock/index')?>">View</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);"><i class="fa fa-cut"></i><span> Cut </span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="<?php echo base_url('Cut/get_addfrm')?>">Create</a></li>
                        <li><a href="<?php echo base_url('Cut/index')?>">View</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);"><i class="fi-grid "></i><span> Devide </span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="<?php echo base_url('Devide/get_addfrm')?>">Create</a></li>
                        <li><a href="<?php echo base_url('Devide/index')?>">View</a></li>
                    </ul>
                </li>
                <?php endif;?>
                <?php if($_SESSION['auth_role_id']=="1" || $_SESSION['auth_role_id']=="3"):?>
                <li>
                    <a href="javascript: void(0);"><i class="mdi mdi-format-paint"></i><span> Printing </span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="<?php echo base_url('Printing/get_addfrm')?>">Create</a></li>
                        <li><a href="<?php echo base_url('Printing/index')?>">View</a></li>
                    </ul>
                </li>
                <?php endif;?>
                <?php if($_SESSION['auth_role_id']=="1" || $_SESSION['auth_role_id']=="5"):?>
                <li>
                    <a href="javascript: void(0);"><i class="fa fa-medium "></i><span> Ghadi </span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="<?php echo base_url('Ghadi/get_addfrm')?>">Create</a></li>
                        <li><a href="<?php echo base_url('Ghadi/index')?>">View</a></li>
                    </ul>
                </li>
                <?php endif;?>
                <?php if($_SESSION['auth_role_id']=="1" || $_SESSION['auth_role_id']=="6"):?>
                <li>
                    <a href="javascript: void(0);"><i class="mdi mdi-group"></i><span> Em Devide </span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="<?php echo base_url('Emdevide/get_addfrm')?>">Create</a></li>
                        <li><a href="<?php echo base_url('Emdevide/index')?>">View</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);"><i class="fa fa-first-order"></i><span> Embroidery </span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="<?php echo base_url('Embroidery/get_addfrm')?>">Create</a></li>
                        <li><a href="<?php echo base_url('Embroidery/index')?>">View</a></li>
                    </ul>
                </li>
                <?php endif;?>
                <?php if($_SESSION['auth_role_id']=="1" || $_SESSION['auth_role_id']=="7"):?>
                <li>
                    <a href="javascript: void(0);"><i class="mdi mdi-package-variant-closed"></i><span> Packing </span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="<?php echo base_url('Packing/get_addfrm')?>">Create</a></li>
                        <li><a href="<?php echo base_url('Packing/index')?>">View</a></li>
                    </ul>
                </li>
                <?php endif;?>
                <?php if($_SESSION['auth_role_id']=="1"):?>
                <li>
                    <a href="javascript: void(0);"><i class="fa fa-sort-amount-desc"></i><span> Balance </span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="<?php echo base_url('Balance')?>">Cloth</a></li>
                        <li><a href="<?php echo base_url('BalancePcs')?>">Pcs</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?php echo base_url('LogActivity')?>"><i class="fa fa-sort-amount-desc"></i><span class="badge badge-success pull-right"></span> <span> User's Activity </span></a>
                </li>
                <?php endif;?>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="content-page">
  