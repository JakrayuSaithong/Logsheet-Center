<?php
    // if ($_SESSION['UserSecurityID'] == '') {
    //     echo "<script>
    //         alert('คุณไม่มีสิทธิ์เข้าใช้งาน');
    //         window.history.back();
    //     </script>";
    //     exit();
    // }

    if($_SESSION['ChangeRequest_user_id'] == '2776'){
        $_SESSION['UserSecurityID'] = 2;
    }

    $Item_List = Item_List('All');
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

                                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3" data-bs-toggle="modal" data-bs-target="#insert">
                                        <a type="button" class="btn btn-primary">
                                            <i class="bi bi-clipboard-plus-fill fs-4"></i> เพิ่มรายการที่ต้องการนำออก
                                        </a>
                                    </div>

                                </div>
                            </div>

                            <div id="kt_app_content" class="app-content  flex-column-fluid ">
                                <div class="card">
                                    <!--begin::Body-->

                                    <!--begin::About-->
                                    <div class="mb-18" style="padding: 15px;">
                                        <!--begin::Wrapper-->
                                        <div class="mb-10">
                                            <!--begin::Top-->
                                            <div class="text-center mb-3">
                                                <h3 class="fs-2hx text-dark mb-5">รายการที่ต้องการนำออก</h3>
                                            </div>
                                        </div>
                                        <div class="fs-5 fw-semibold text-gray-600">
                                            <!-- <div class="table-responsive"> -->
                                                <table id="example" class="table table-striped display nowrap" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <td class="text-center">แก้ไข/ลบ</td>
                                                            <td>ชื่อรายการนำออก</td>
                                                            <td>สถานะ</td>
                                                            <td>ชื่อผู้แก้ไขล่าสุด</td>
                                                            <td>วันที่แก้ไขล่าสุด</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($Item_List as $key => $value) {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center d-flex">
                                                                <button class="btn btn-warning btn-sm m-2 edit-doc" data-id="<?php echo $value['id']; ?>" ><i class="fas fa-edit m-0 fs-4"></i>แก้ไข</button>
                                                                <?php 
                                                                if($value['active'] == '1'){
                                                                ?>
                                                                <button class="btn btn-danger m-2 btn-sm delete-doc" data-id="<?php echo $value['id']; ?>" data-status="0">ปิดใช้งาน</button>
                                                                <?php 
                                                                }
                                                                ?>
                                                                <?php 
                                                                if($value['active'] == '0'){
                                                                ?>
                                                                <button class="btn btn-success m-2 btn-sm delete-doc" data-id="<?php echo $value['id']; ?>" data-status="1">เปิดใช้งาน</button>
                                                                <?php 
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $value['itemname']; ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php 
                                                                if($value['active'] == '1'){
                                                                ?>
                                                                <span class="badge bg-success text-white">เปิดใช้งาน</span>
                                                                <?php 
                                                                }
                                                                ?>
                                                                <?php 
                                                                if($value['active'] == '0'){
                                                                ?>
                                                                <span class="badge bg-danger text-white">ปิดใช้งาน</span>
                                                                <?php 
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $value['updateuser']; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $value['updatedate']; ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            <!-- </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="insert" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel"><i class="fas fa-file-alt me-3 fs-4"></i> เพิ่มรายการที่ต้องการนำออก</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">ชื่อรายการนำออก</label>
                                            <input type="email" class="form-control" id="name" placeholder="กรุณากรอกชื่อรายการนำออก">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                        <button type="button" class="btn btn-primary" id="btnSave">บันทึก</button>
                                    </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="edit_type_doc" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel"><i class="fas fa-file-alt me-3 fs-4"></i> แก้ไขรายการนำออก</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" id="edit_id">
                                            <div class="mb-3">
                                                <label for="edit_doctype_name" class="form-label">ชื่อรายการนำออก</label>
                                                <input type="text" class="form-control" id="edit_name" placeholder="กรุณากรอกชื่อรายการนำออก">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                            <button type="button" class="btn btn-primary" id="btnUpdate">บันทึกการแก้ไข</button>
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
    <script>
        $(document).ready(function() {
            var token = "<?php echo $_GET['token']; ?>";


            $("#btnSave").click(function() {
                var name = $("#name").val();

                $.ajax({
                    url: "./insert_item?token=" + token,
                    type: "POST",
                    data: {
                        name: name
                    },
                    success: function(data) {
                        console.log(data);

                        if (data.status == "success") {
                            Swal.fire({
                                title: "เพิ่มข้อมูลสําเร็จ",
                                icon: "success",
                            }).then(() => {
                                location.reload();
                            });
                        }
                        else if (data.status == "error") {
                            Swal.fire({
                                title: "เกิดข้อผิดพลาด",
                                icon: "error",
                            }).then(() => {
                                location.reload();
                            });
                        }

                    }
                });
            });

            $(".edit-doc").click(function() {
                var id = $(this).data("id");

                $.ajax({
                    url: "./get_item?token=" + token,
                    type: "POST",
                    data: { id: id },
                    success: function(res) {
                        console.log(res);
                        if (res.status == "success") {
                            $("#edit_name").val(res['data'].itemname);
                            $("#edit_id").val(res['data'].id);

                            $("#edit_type_doc").modal("show");
                        } else {
                            Swal.fire({
                                title: "เกิดข้อผิดพลาดในการดึงข้อมูล",
                                icon: "error",
                            });
                        }
                    }
                });
            });

            $("#btnUpdate").click(function() {
                var id = $("#edit_id").val();
                var name = $("#edit_name").val();

                $.ajax({
                    url: "./update_item?token=" + token,
                    type: "POST",
                    data: {
                        id: id,
                        name: name
                    },
                    success: function(data) {
                        if (data.status == "success") {
                            Swal.fire({
                                title: "แก้ไขสำเร็จ",
                                icon: "success",
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: "เกิดข้อผิดพลาดในการบันทึก",
                                icon: "error",
                            });
                        }
                    }
                });
            });

            $(".delete-doc").click(function() {
                var id = $(this).data("id");
                var status = $(this).data("status");

                var status_text = status == 1 ? "เปิดใช้งาน" : "ปิดใช้งาน";

                Swal.fire({
                    title: "คุณแน่ใจหรือไม่ที่จะ"+ status_text,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: "ยกเลิก"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "./delete_item?token=" + token,
                            type: "POST",
                            data: {
                                id: id,
                                status: status
                            },
                            success: function(data) {
                                if (data.status == "success") {
                                    Swal.fire({
                                        title: "บันทึกสำเร็จ",
                                        icon: "success",
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else if (data.status == "error") {
                                    Swal.fire({
                                        title: "เกิดข้อผิดพลาด",
                                        icon: "error",
                                    });
                                }
                            }
                        });
                    }
                });
            });
        });

    </script>
</body>

</html>