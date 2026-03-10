<?php
    // if ($_SESSION['UserSecurityID'] == '') {
    //     echo "<script>
    //         alert('คุณไม่มีสิทธิ์เข้าใช้งาน');
    //         window.history.back();
    //     </script>";
    //     exit();
    // }

    $empList = emplist();
    $userAdmin = get_userAdmin('1');
    $userNotify_All = get_userAdmin('2');
    $userNotify = get_userAdmin('3');
    $userView = get_userAdmin('4');

    // echo "<pre>";
    // // print_r($empList);
    // print_r($userAdmin);
    // exit();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php $datatable = true; ?>
    <?php //include_once 'config/base.php'; ?>
    <?php include_once 'layout/meta.php' ?>
    <?php include_once 'layout/css.php' ?>
    <title>หน้าแรก</title>

</head>

<style>
    td {
        vertical-align: middle;
    }

    .shadow:hover {
        transform: translateY(-5px);
        transition: 0.3s;
    }
</style>

<body id="kt_body" data-kt-app-header-stacked="true" data-kt-app-header-primary-enabled="true" data-kt-app-header-secondary-enabled="false" data-kt-app-toolbar-enabled="true" class="app-default">
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
                                            Log Sheet
                                        </h1>
                                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                                            <li class="breadcrumb-item text-muted">
                                                <a href="index.phpDataE=<?php echo $_SESSION['DataE'] ?>" class="text-muted text-hover-primary">
                                                    Log Sheet
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                            <div id="kt_app_content" class="app-content  flex-column-fluid ">
                                <!-- <div class="card"> -->
                                    <!--begin::Body-->

                                    <!--begin::About-->
                                    <div class="mb-6 shadow border border-primary border-2 rounded" style="padding: 15px;">
                                        <div class="fs-5 fw-semibold text-gray-600">
                                            <!-- <div class="table-responsive"> -->
                                                <label for="emp-list" class="form-label fs-4">รายชื่อสำหรับผู้ดูแล : </label>
                                                <select name="emp-list[]" id="emp-list-1" class="form-select" multiple>
                                                    <?php
                                                    foreach($empList as $key => $value) {
                                                        $employeeIDs = array_column($userAdmin, 'EmployeeID');
                                                        $selected = in_array($value['Code'], $employeeIDs) ? 'selected' : '';
                                                    ?>
                                                        <option value="<?php echo $value['Code']; ?>" <?php echo $selected; ?> ><?php echo $value['FullName']; ?></option>
                                                    <?php   
                                                    }
                                                    ?>
                                                </select>
                                            <!-- </div> -->
                                        </div>
                                        <!--end::Wrapper-->
                                        <div class="text-end mt-5">
                                            <button type="button" class="btn btn-primary" onclick="updateUser('1')">บันทึก</button>
                                        </div>
                                    </div>

                                    <div class="mb-6 shadow border border-info border-2 rounded" style="padding: 15px;">
                                        <div class="fs-5 fw-semibold text-gray-600">
                                            <!-- <div class="table-responsive"> -->
                                                <label for="emp-list" class="form-label fs-4">รายชื่อสำหรับผู้แจ้ง (เห็นของทุกคน) : </label>
                                                <select name="emp-list[]" id="emp-list-2" class="form-select" multiple>
                                                    <?php
                                                    foreach($empList as $key => $value) {
                                                        $employeeIDs = array_column($userNotify_All, 'EmployeeID');
                                                        $selected = in_array($value['Code'], $employeeIDs) ? 'selected' : '';
                                                    ?>
                                                        <option value="<?php echo $value['Code']; ?>" <?php echo $selected; ?> ><?php echo $value['FullName']; ?></option>
                                                    <?php   
                                                    }
                                                    ?>
                                                </select>
                                            <!-- </div> -->
                                        </div>
                                        <!--end::Wrapper-->
                                        <div class="text-end mt-5">
                                            <button type="button" class="btn btn-info" onclick="updateUser('2')">บันทึก</button>
                                        </div>
                                    </div>

                                    <div class="mb-6 shadow border border-warning border-2 rounded" style="padding: 15px;">
                                        <div class="fs-5 fw-semibold text-gray-600">
                                            <!-- <div class="table-responsive"> -->
                                                <label for="emp-list" class="form-label fs-4">รายชื่อสำหรับผู้แจ้ง (เห็นของตัวเอง) : </label>
                                                <select name="emp-list[]" id="emp-list-3" class="form-select" multiple>
                                                    <?php
                                                    foreach($empList as $key => $value) {
                                                        $employeeIDs = array_column($userNotify, 'EmployeeID');
                                                        $selected = in_array($value['Code'], $employeeIDs) ? 'selected' : '';
                                                    ?>
                                                        <option value="<?php echo $value['Code']; ?>" <?php echo $selected; ?> ><?php echo $value['FullName']; ?></option>
                                                    <?php   
                                                    }
                                                    ?>
                                                </select>
                                            <!-- </div> -->
                                        </div>
                                        <!--end::Wrapper-->
                                        <div class="text-end mt-5">
                                            <button type="button" class="btn btn-warning" onclick="updateUser('3')">บันทึก</button>
                                        </div>
                                    </div>

                                    <div class="mb-6 shadow border border-success border-2 rounded" style="padding: 15px;">
                                        <div class="fs-5 fw-semibold text-gray-600">
                                            <!-- <div class="table-responsive"> -->
                                                <label for="emp-list" class="form-label fs-4">รายชื่อสำหรับผู้ดูเท่านั้น : </label>
                                                <select name="emp-list[]" id="emp-list-4" class="form-select" multiple>
                                                    <?php
                                                    foreach($empList as $key => $value) {
                                                        $employeeIDs = array_column($userView, 'EmployeeID');
                                                        $selected = in_array($value['Code'], $employeeIDs) ? 'selected' : '';
                                                    ?>
                                                        <option value="<?php echo $value['Code']; ?>" <?php echo $selected; ?> ><?php echo $value['FullName']; ?></option>
                                                    <?php   
                                                    }
                                                    ?>
                                                </select>
                                            <!-- </div> -->
                                        </div>
                                        <!--end::Wrapper-->
                                        <div class="text-end mt-5">
                                            <button type="button" class="btn btn-success" onclick="updateUser('4')">บันทึก</button>
                                        </div>
                                    </div>
                                <!-- </div> -->
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
    <script>
        var token = "<?php echo $_GET['token']; ?>";

        $(document).ready(function() {
            
            $('.form-select').select2({
                placeholder: 'กรุณาเลือกผู้มีสิทธิ์',
            });

            $('#btnSave').click(function() {
                var empList = $('#emp-list').val();

                console.log(empList);

                // $.ajax({
                //     url: './permission_save?token='+token,
                //     method: 'POST',
                //     data: {
                //         empList: empList
                //     },
                //     success: function(response) {
                //         // console.log(response);

                //         if(response.status == 'success') {
                //             Swal.fire({
                //                 icon: 'success',
                //                 title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
                //             }).then(function() {
                //                 window.location.reload();
                //             });
                //         }
                //     }
                // });
            });
        });

        function updateUser(type) {
            var empList = $('#emp-list-'+ type).val();

            // console.log(empList);

            // if(empList.length == 0) {
            //     Swal.fire({
            //         icon: 'warning',
            //         title: 'กรุณาเลือกผู้มีสิทธิ์อย่างน้อย 1 คน',
            //     });
            //     return false;
            // }

            $.ajax({
                url: './permission_update?token='+token,
                method: 'POST',
                data: {
                    empList: empList,
                    type: type
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'กำลังบันทึกข้อมูล...',
                        text: 'โปรดรอสักครู่',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    // console.log(response);

                    if(response.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
                        }).then(function() {
                            window.location.reload();
                        });
                    }
                }
            });

        }

    </script>
</body>

</html>