<!-- Navbar Start -->
<div class="navbar-custom">
    <div class="container">
        <div id="navigation">
            <!-- Navigation Menu-->

          <?php if($_SESSION['usertypeid']=="2" || $_SESSION['usertypeid']=="1"){ ?>
                <ul class="navigation-menu">
                    <li class="has-submenu active">
                        <a href="dashboard"><i class="md md-dashboard"></i>Dashboard</a>
                    </li>
                    <li class="has-submenu">
                        <a href="#"><i class="md md-pages"></i>Users </a>
                        <ul class="submenu">
                            <?php if($_SESSION['usertypeid']=="1"){ ?>
                            <li><a href="<?php echo base_url();?>Frontend/adminMaster">Admin </a></li>
                            <?php } ?>
                            <li><a href="<?php echo base_url();?>Frontend/retailerShowRoomMaster">Retailer Show Room </a></li>
                            <li><a href="<?php echo base_url();?>Frontend/salesHeadMaster">Sales Head </a></li>
                            <li><a href="<?php echo base_url();?>Frontend/salesExecutiveMaster">Sales Executive </a></li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="#"><i class="md md-pages"></i>Masters </a>
                        <ul class="submenu">
                            <li><a href="<?php echo base_url();?>Product/CategoryTypeMaster">Category Type </a></li>
                            <li><a href="<?php echo base_url();?>Product/ProductList">Product </a></li>
<!--                            <li><a href="--><?php //echo base_url();?><!--Product/AddProduct">Product </a></li>-->
                            <li><a href="<?php echo base_url();?>Product/BrandMaster">Brand </a></li>
                            <li><a href="<?php echo base_url();?>Product/SizeMaster">Size </a></li>
                            <li><a href="<?php echo base_url();?>Product/MapProduct">Map Product </a></li>
                    </ul>
                    </li>

                 <li class="has-submenu">
                         <a href="#"><i class="md md-folder-special"></i>Sales </a>
                         <ul class="submenu">
                             <li><a href="<?php echo base_url();?>sales/adminMaster"> Toady Report</a></li>
                             <li><a href="<?php echo base_url();?>sales/sellerMaster">Month Report </a></li>
                                                        
                </ul>
                </li>
                </ul>
           <?php } if($_SESSION['usertypeid']=="5") { ?>
		
                <ul class="navigation-menu">
                    <li class="has-submenu active">
                        <a href="<?php echo base_url();?>dashboard"><i class="md md-dashboard"></i>Dashboard</a>
                    </li>
 			<li class="has-submenu">
                        <a href="<?php echo base_url();?>sales/pos"><i class="md md-pages"></i>Point of Sales </a>
                       
                    </li>
                    <li class="has-submenu">
                        <a href="#"><i class="md md-pages"></i>Return </a>
                        <ul class="submenu">
                            <li><a href="<?php echo base_url();?>returnpos">Return Product </a></li>
                            <li><a href="<?php echo base_url();?>retailerShowRoomMaster">Return List </a></li>
                          </ul>
                    </li>
                 
                </ul>
          <?php } ?>
            <!-- End navigation menu -->
        </div>
    </div>
</div>
</header>
<!-- End Navigation Bar-->


