<!--begin::Header-->
<?php
    if($_SESSION['UserSecurityID'] == null){
        echo "
        <script>
            alert('ท่านไม่มีสิทธิ์เข้าใช้งานโปรแกรม');
            window.close();
        </script>
        ";
        exit();
    }

    // $permision_admin = [
        // "344",
        // "345",
        // "346",
        // "347"
    // ];


?>
<div id="kt_app_header" class="app-header ">

    <!--begin::Header primary-->
    <div class="app-header-primary " data-kt-sticky="true" data-kt-sticky-name="app-header-primary-sticky" data-kt-sticky-offset="{default: 'false', lg: '300px'}">

        <!--begin::Header primary container-->
        <div class="app-container  container-xxl d-flex align-items-stretch justify-content-between ">
            <!--begin::Logo and search-->
            <div class="d-flex flex-grow-1 flex-lg-grow-0">
                <!--begin::Logo wrapper-->
                <div class="d-flex align-items-center me-7" id="kt_app_header_logo_wrapper">
                    <!--begin::Header toggle-->
                    <button class="d-lg-none btn btn-icon btn-flex btn-color-gray-600 btn-active-color-primary w-35px h-35px ms-n2 me-2" id="kt_app_header_menu_toggle">
                        <i class="ki-outline ki-abstract-14 fs-2"></i> </button>
                    <!--end::Header toggle-->

                    <!--begin::Logo-->
                    <a href="index.phpDataE=<?php echo $_SESSION['DataE'] ?>&pageH=1" class="d-flex align-items-center me-5">
                        <img alt="Logo" src="assets/media/logos/Left - Blue.png" class="d-sm-none d-inline" style="height: 30px;" />
                        <img alt="Logo" src="assets/media/logos/Left - Blue.png" class="h-lg-40px theme-light-show d-none d-sm-inline" />
                        <img alt="Logo" src="assets/media/logos/Left - Blue.png" class="h-lg-40px theme-dark-show d-none d-sm-inline" />
                    </a>
                    <!--end::Logo-->
                </div>
                <!--end::Logo wrapper-->
                <!--begin::Menu wrapper-->
                <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                    <!--begin::Menu-->
                    <div class=" menu  
                             menu-rounded 
                             menu-active-bg 
                             menu-state-primary 
                             menu-column 
                             menu-lg-row 
                             menu-title-gray-700 
                             menu-icon-gray-500 
                             menu-arrow-gray-500 
                             menu-bullet-gray-500 
                             my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0" id="kt_app_header_menu" data-kt-menu="true">
                        <a href="./?token=<?php echo $_SESSION['DataE'] ?>&pageH=1" data-kt-menu-placement="bottom-start" data-kt-menu-offset="-200,0" class="menu-item 
                        <?php if (@$page == 1) {
                            echo 'here show';
                        } ?>">
                            <span class="menu-link py-3">
                                <span class="menu-title fs-4"><i class="menu-title fas fa-home fs-3 me-2"></i> Log Sheet</span>
                                <span class="menu-arrow d-lg-none"></span>
                            </span>
                        </a>

                        <?php if ($_SESSION['UserSecurityID'] == '1') { ?>

                        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2 <?php echo @$page == 4 ? 'here' : '' ?>">
                            <span class="menu-link py-3"><span class="menu-title fs-4"><i class="menu-title fas fa-th-list fs-3 me-2"></i> ข้อมูลหลัก</span><span class="menu-arrow d-lg-none"></span></span>
                            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px">
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="./doc_type?token=<?php echo $_SESSION['DataE'] ?>" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="Check out over 200 in-house components, plugins and ready for use solutions" data-kt-initialized="1">
                                        <span class="menu-icon"><i class="fas fa-laptop-medical fa-fw fs-3"></i></span>
                                        <span class="menu-title fs-5">ประเภทเอกสาร</span>
                                    </a>
                                </div>
                                <!-- <div class="menu-item">
                                    <a class="menu-link py-3" href="#" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="Check out over 200 in-house components, plugins and ready for use solutions" data-kt-initialized="1">
                                        <span class="menu-icon"><i class="fas fa-wrench fa-fw fs-3"></i></span>
                                        <span class="menu-title fs-5">แผนก/ฝ่าย</span>
                                    </a>
                                </div> -->
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="./item_list?token=<?php echo $_SESSION['DataE'] ?>" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="Check out over 200 in-house components, plugins and ready for use solutions" data-kt-initialized="1">
                                        <span class="menu-icon"><i class="fas fa-file-signature fa-fw fs-3"></i></span>
                                        <span class="menu-title fs-5">รายการที่ต้องการนำออก</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="./doc_refer_list?token=<?php echo $_SESSION['DataE'] ?>" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="Check out over 200 in-house components, plugins and ready for use solutions" data-kt-initialized="1">
                                        <span class="menu-icon"><i class="fas fa-file-import fa-fw fs-3"></i></span>
                                        <span class="menu-title fs-5">เอกสารอ้างอิงการนำกลับ</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="./sheet_status_list?token=<?php echo $_SESSION['DataE'] ?>" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="Check out over 200 in-house components, plugins and ready for use solutions" data-kt-initialized="1">
                                        <span class="menu-icon"><i class="fas fa-check-circle fa-fw fs-3"></i></span>
                                        <span class="menu-title fs-5">สถานะเอกสาร</span>
                                    </a>
                                </div>
                                <!-- <div class="menu-item">
                                    <a class="menu-link py-3" href="#" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="Check out over 200 in-house components, plugins and ready for use solutions" data-kt-initialized="1">
                                        <span class="menu-icon"><i class="fas fa-envelope fa-fw fs-3"></i></span>
                                        <span class="menu-title fs-5">Email แจ้งเตือน จป/OHSE</span>
                                    </a>
                                </div> -->
                            </div>
                        </div>

                        <a href="./permission?token=<?php echo $_SESSION['DataE'] ?>" data-kt-menu-placement="bottom-start" data-kt-menu-offset="-200,0" class="menu-item 
                        <?php if (@$page == 6) {
                            echo 'here show';
                        } ?>">
                            <span class="menu-link py-3">
                                <span class="menu-title fs-4"><i class="menu-title fas fa-user-cog fs-3 me-2"></i> กำหนดสิทธิ์</span>
                                <span class="menu-arrow d-lg-none"></span>
                            </span>
                        </a>
                        <?php } ?>

                        <?php //if($_SESSION['UserSecurityID'] == '4'){ ?>
                        <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2 <?php echo @$page == 5 ? 'here' : '' ?>">
                            <span class="menu-link py-3"><span class="menu-title fs-4"><i class="menu-title fas fa-book fs-3 me-2"></i> รายงาน</span><span class="menu-arrow d-lg-none"></span></span>
                            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px">
                                <div class="menu-item">
                                    <a class="menu-link py-3" href="./report?token=<?php echo $_SESSION['DataE'] ?>&date_start=<?php echo date('Y-m-d'); ?>&date_end=<?php echo date('Y-m-d'); ?>" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" data-bs-original-title="Check out over 200 in-house components, plugins and ready for use solutions" data-kt-initialized="1">
                                        <span class="menu-icon"><i class="fas fa-laptop-medical fa-fw fs-3"></i></span>
                                        <span class="menu-title fs-5">รายงาน Logsheet</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php //} ?>

                    </div>
                    <!--end::Menu-->
                </div>
                <!--end::Menu wrapper-->
            </div>
            <!--end::Logo and search-->


            <!--begin::Navbar-->
            <div class="app-navbar flex-shrink-0">
                <!--begin::User menu-->
                <div class="app-navbar-item ms-3 ms-lg-9" id="kt_header_user_menu_toggle">
                    <!--begin::Menu wrapper-->
                    <div class="d-flex align-items-center" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <!--begin:Info-->
                        <div class="text-end d-none d-sm-flex flex-column justify-content-center me-3">
                            <span class="" class="text-gray-500 fs-8 fw-bold">สวัสดี</span>
                            <a href="#" class="text-gray-800 text-hover-primary fs-7 fw-bold d-block"><?php echo $_SESSION['ChangeRequest_name']; ?></a>
                        </div>
                        <!--end:Info-->

                        <!--begin::User-->
                        <div class="cursor-pointer symbol symbol symbol-circle symbol-35px symbol-md-40px">
                            <?php if (get_headers($_SESSION['ChangeRequest_image']) != "HTTP/1.1 404 Not Found") {
                            ?>
                                <img class src="<?php echo $_SESSION['ChangeRequest_image']; ?>" alt="user" />
                            <?php
                            } else {
                            ?>
                                <img class src="<?php echo $_SESSION['ChangeRequest_image']; ?>" alt="user" />
                            <?php
                            }
                            ?>
                            <div class="position-absolute translate-middle bottom-0 mb-1 start-100 ms-n1 bg-success rounded-circle h-8px w-8px"></div>
                        </div>
                        <!--end::User-->
                    </div>

                    <!--begin::User account menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <div class="menu-content d-flex align-items-center px-3">
                                <!--begin::Avatar-->
                                <?php if (get_headers($_SESSION['emp_Image'])[0] != "HTTP/1.1 404 Not Found") {
                                ?>
                                    <div class="symbol symbol-50px me-5">
                                        <img alt="Logo" src="<?php echo $_SESSION['ChangeRequest_image'] ?>" >
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="symbol symbol-50px me-5">
                                        <img alt="Logo" src="<?php echo $_SESSION['ChangeRequest_image'] ?>" >
                                    </div>
                                <?php
                                }
                                ?>

                                <div class="d-flex flex-column">
                                    <div class="fw-bold d-flex align-items-center fs-5">
                                        <?php echo $_SESSION['ChangeRequest_name']; ?>&nbsp;
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="separator my-2"></div>
                        <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                            <a href="#" class="menu-link px-5">
                                <span class="menu-title position-relative">
                                    Mode

                                    <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                                        <i class="ki-outline ki-night-day theme-light-show fs-2"></i> <i class="ki-outline ki-moon theme-dark-show fs-2"></i> </span>
                                </span>
                            </a>

                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3 my-0">
                                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                                        <span class="menu-icon" data-kt-element="icon">
                                            <i class="ki-outline ki-night-day fs-2"></i> </span>
                                        <span class="menu-title">
                                            Light
                                        </span>
                                    </a>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3 my-0">
                                    <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                                        <span class="menu-icon" data-kt-element="icon">
                                            <i class="ki-outline ki-moon fs-2"></i> </span>
                                        <span class="menu-title">
                                            Dark
                                        </span>
                                    </a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->

                        </div>
                        <!--end::Menu item-->


                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="https://innovation.asefa.co.th/authen/signout.php" class="menu-link px-5">
                                Sign Out
                            </a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                </div>
                <div class="app-navbar-item d-lg-none ms-2 me-n3" title="Show header menu">
                    <div class="btn btn-icon btn-color-gray-500 btn-active-color-primary w-35px h-35px" id="kt_app_header_menu_toggle">
                        <i class="ki-outline ki-text-align-left fs-1"></i>
                    </div>
                </div>
                <!--end::Header menu toggle-->
            </div>
            <!--end::Navbar-->
        </div>
    </div>

</div>
<!--end::Header-->