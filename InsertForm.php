<!DOCTYPE html>
<html lang="en">

<head>
    <?php //$datatable = true; ?>
    <?php //include_once 'config/base.php'; ?>
    <?php include_once 'layout/meta.php' ?>
    <?php include_once 'layout/css.php' ?>
    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" /> -->
    <title>เพิ่มเอกสาร</title>

</head>

<style>
    td {
        vertical-align: middle;
    }

    .select2-scrollable .select2-results__options {
        max-height: 200px;
        overflow-y: auto;
    }

    .select2-container .select2-selection--multiple {
        height: auto;
        max-height: 150px;
        overflow-y: auto;
    }
</style>

<body id="kt_body" data-kt-app-header-stacked="true" data-kt-app-header-primary-enabled="true" data-kt-app-header-secondary-enabled="false" data-kt-app-toolbar-enabled="true" class="app-default bg-light">
    <?php include_once 'layout/modechange.php'; ?>
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page  flex-column flex-column-fluid " id="kt_app_page">
            <?php include_once 'layout/navbar.php'; ?>
            <!--begin::Wrapper-->
            <div class="app-wrapper  flex-column flex-row-fluid " id="kt_app_wrapper">
                <!--begin::Wrapper container-->
                <div class="app-container  container-xxl d-flex flex-row flex-column-fluid ">
                    <!--begin::Main-->
                    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                        <!--begin::Content wrapper-->
                        <div class="d-flex flex-column flex-column-fluid">
                            <!--begin::Toolbar-->
                            <div id="kt_app_toolbar" class="app-toolbar  d-flex flex-stack py-4 py-lg-8 ">
                                <!--begin::Toolbar wrapper-->
                                <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10" id="kt_toolbar">
                                    <!--begin::Page title-->
                                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">
                                        <!--begin::Title-->
                                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                                            เพิ่มเอกสาร
                                        </h1>
                                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                            <li class="breadcrumb-item text-muted">
                                                <a href="index.phpDataE=<?php echo $_SESSION['DataE'] ?>" class="text-muted text-hover-primary">
                                                    หน้าแรก
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <span> - </span>
                                            </li>
                                            <li class="breadcrumb-item text-muted">
                                                <span>เพิ่ม/แก้ไขข้อมูล</span>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                            <div id="kt_app_content" class="app-content  flex-column-fluid ">
                                <div class="card mb-4">
                                    <div class="border border-dark border-2" style="padding: 15px;">
                                        <div class="col-md-12">
                                            <span class="fs-5 fw-bold text-decoration-underline">ส่วนการกรอกข้อมูล</span>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <div class="row py-3 justify-content-end">
                                                <div class="col-md-12 text-end">
                                                    <button class="btn btn-primary mt-4" type="button" id="submit"><i class="fa-solid fa-plus p-0 fs-6"></i> บันทึก</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php include_once 'layout/scoreup.php'; ?>
                        <?php include_once 'layout/footer.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once 'layout/js.php' ?>
    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
    <script>
        $(document).ready(function() {
            var token = '<?php echo $_SESSION['DataE']; ?>';

        });

    </script>
</body>

</html>