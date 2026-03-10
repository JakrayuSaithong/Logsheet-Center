<?php
    // if ($_SESSION['UserSecurityID'] == '') {
    //     echo "<script>
    //         alert('คุณไม่มีสิทธิ์เข้าใช้งาน');
    //         window.history.back();
    //     </script>";
    //     exit();
    // }

    $List_Doctype = List_Doctype();
    $List_Doc_Refer = List_Doc_Refer();
    $SheetNo = getNextSheetNo();
    $List_Division47 = ListDivision();
    $Item_List = Item_List('New');

    $username = explode(" ", mydata($_SESSION['ChangeRequest_code'])['FullNameEn']);

    $List_Status = List_Status();

    // echo "<pre>";
    // // print_r($username);
    // print_r($_SESSION);
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

                                    <?php
                                    if($_SESSION['UserSecurityID'] != '4' && ($_SESSION['UserSecurityID'] != '' || $_SESSION['UserSecurityID'] == '')) {
                                    ?>
                                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3" id="kt_app_toolbar_buttons">
                                        <a type="button" class="btn btn-primary">
                                            <i class="bi bi-clipboard-plus-fill fs-4"></i> เพิ่มเอกสาร
                                        </a>
                                    </div>
                                    <?php
                                    }
                                    ?>

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
                                                <h3 class="fs-2hx text-dark mb-5">รายการเอกสาร</h3>
                                            </div>
                                        </div>
                                        <div class="mb-10">
                                            <div class="row justify-content-end">
                                                <div class="col-5 col-md-3 mt-3">
                                                    <input name="date_start" class="form-control" id="date_start" placeholder="เลือกวันที่เริ่ม" value="<?php echo isset($_GET['date_start']) ? $_GET['date_start'] : date('Y-m-d'); ?>">
                                                </div>
                                                <div class="col-2 col-md-1 mt-3 row align-items-center">
                                                    <span class="text-center">ถึง</span>
                                                </div>
                                                <div class="col-5 col-md-3 mt-3">
                                                    <input name="date_end" class="form-control" id="date_end" placeholder="เลือกวันที่สิ้นสุด" value="<?php echo isset($_GET['date_end']) ? $_GET['date_end'] : date('Y-m-d'); ?>">
                                                </div>
                                                <div class="col-12 col-md-1 mt-3 text-center">
                                                    <button type="button" name="search" id="search" class="btn btn-primary">ค้นหา</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fs-5 fw-semibold text-gray-600">
                                            <!-- <div class="table-responsive"> -->
                                                <table id="example" class="table table-striped display nowrap" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <td class="text-center">แก้ไข/พิมพ์</td>
                                                            <td>วันที่ใบนำของออก</td>
                                                            <td>เลขที่ใบนำของออก</td>
                                                            <td>ประเภทเอกสาร</td>
                                                            <td>เลขที่เอกสาร</td>
                                                            <td>ชื่อผู้แจ้งนำของออก</td>
                                                            <td>แผนก/ฝ่าย</td>
                                                            <td>รายการที่ต้องนำออก</td>
                                                            <td>วันที่ออก</td>
                                                            <td>แผนก/ฝ่ายที่นำกลับ</td>
                                                            <td>วันที่คาดว่าจะนำกลับ</td>
                                                            <td>วันที่นำกลับ</td>
                                                            <td>เอกสารอ้างอิงการนำกลับ</td>
                                                            <td>สถานะเอกสาร</td>
                                                            <td>ชื่อผู้สร้าง</td>
                                                            <td>วันที่สร้าง</td>
                                                            <td>ชื่อผู้แก้ไขล่าสุด</td>
                                                            <td>วันที่แก้ไขล่าสุด</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbody">
                                                        
                                                    </tbody>
                                                </table>
                                            <!-- </div> -->
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

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen" style="margin: 0 auto !important; width: 90vw !important;">
            <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="widget-box widget-color-green ui-sortable-handle">
                            <div class="widget-header mb-4">
                                <h4 class="widget-title">เพิ่ม LOG SHEET ใบนำของออกนอกบริษัท                                              
                            </div>
                            <div class=" widget-body">
                                <div class=" widget-main ms-6">
                                    <div class="mb-3 row">
                                        <label for="staticEmail" class="col-4 col-form-label text-end">วันที่ใบนำของออก</label>
                                        <div class="col-6">
                                            <input class="form-control" placeholder="เลือกวันที่" id="body_txtSheetDate" name="body_txtSheetDate" value="<?php echo date('Y-m-d'); ?>" disabled />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="staticEmail" class="col-4 col-form-label text-end">เลขที่ใบนำของออก</label>
                                        <div class="col-6">
                                            <input class="form-control" id="body_txtSheetNo" name="body_txtSheetNo" disabled />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="staticEmail" class="col-4 col-form-label text-end">ประเภทเอกสาร</label>
                                        <div class="col-6">
                                            <select class="form-select" name="body_dwDocType" id="body_dwDocType">
                                                <option value=""></option>
                                                <?php  
                                                    foreach ($List_Doctype as $key => $value) {
                                                        echo '<option value="'.$value['id'].'">'.$value['doctype'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row" id="DocTypeOth" style="display: none;">
                                        <label for="staticEmail" class="col-4 col-form-label"></label>
                                        <div class="col-6">
                                            <input type="text" id="body_txtDocTypeOth" class="form-control" placeholder="ระบุประเภทเอกสารอื่นๆ">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="staticEmail" class="col-4 col-form-label text-end">เลขที่เอกสาร</label>
                                        <div class="col-6">
                                            <input type="text" id="body_txtDocNo" class="form-control" placeholder="เลขที่เอกสาร">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="staticEmail" class="col-4 col-form-label text-end">ชื่อผู้นำของออก</label>
                                        <div class="col-6">
                                            <input type="text" id="body_txtLeadOutUsers" class="form-control">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="staticEmail" class="col-4 col-form-label text-end">วันที่ออก</label>
                                        <div class="col-6">
                                            <input class="form-control" placeholder="เลือกวันที่" id="body_txtLeadOutDate" name="body_txtLeadOutDate" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="staticEmail" class="col-4 col-form-label text-end">เอกสารอ้างอิงการนำกลับ</label>
                                        <div class="col-6">
                                            <select class="form-select" name="body_dwDocRefer" id="body_dwDocRefer">
                                                <option value=""></option>
                                                <?php
                                                foreach ($List_Doc_Refer as $k => $value) {
                                                    echo '<option value="'.$k.'">'.$value['docrefer'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row" id="dwDocRefer" style="display: none;">
                                        <label for="staticEmail" class="col-4 col-form-label"></label>
                                        <div class="col-6">
                                            <input type="text" id="body_txtDocReferOth" class="form-control" placeholder="ระบุเอกสารอ้างอิงการนำกลับอื่นๆ">
                                        </div>
                                    </div>
                                    <div class="mb-3 row select_Doc_Refer_4">
                                        <label for="staticEmail" class="col-4 col-form-label text-end">แผนก/ฝ่ายที่นำกลับ</label>
                                        <div class="col-6">
                                            <select class="form-select" name="body_dwDivisionReturn" id="body_dwDivisionReturn" multiple>
                                                <!-- <option value=""></option> -->
                                                <?php
                                                // foreach ($List_Division47 as $key => $value) {
                                                //     echo '<option value="'.$value['id'].'">'.$value['dvname'].'</option>';
                                                // }
                                                foreach ($List_Division47 as $key => $value) {
                                                    echo '<option value="'.$value['id'].'">'.$value['dvname'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row select_Doc_Refer_4">
                                        <label for="staticEmail" class="col-4 col-form-label text-end">วันที่คาดว่าจะนำกลับ</label>
                                        <div class="col-6">
                                            <input class="form-control" placeholder="เลือกวันที่" id="body_txtReturnDate" name="body_txtReturnDate" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row select_Doc_Refer_4">
                                        <label for="staticEmail" class="col-4 col-form-label text-end">วันที่นำกลับ</label>
                                        <div class="col-6">
                                            <input class="form-control" placeholder="เลือกวันที่" id="body_txtReturnDateAct" name="body_txtReturnDateAct" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="staticEmail" class="col-4 col-form-label text-end">หมายเหตุ</label>
                                        <div class="col-6">
                                            <input type="text" id="body_txtremk" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-5">
                        <div class="widget-box widget-color-green ui-sortable-handle">
                            <div class="widget-header mb-4">
                                <h4 class="widget-title">รายการที่ต้องนำออก&nbsp;&nbsp;                                               
                                    <span id="body_ctl04" class="text-danger" style="visibility:hidden;">**ระบุรายการที่ต้องนำออก**</span></h4>
                            </div>
                            <div class=" widget-body">
                                <div class=" widget-main">
                                    <div class="form-horizontal ms-6" role="form">
                                        <?php
                                        foreach ($Item_List as $key => $value) {
                                        ?>
                                        <div class="form-group row mb-4">
                                            <div class="col-sm-12">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="body_chk" id="body_chk<?php echo $key; ?>" value="<?php echo $value['id']; ?>" class="ace mb-3 form-check-input ">
                                                        <span class="lbl">&nbsp;&nbsp;<?php echo $value['itemname']; ?></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                        <div class="col-sm-12">
                                                
                                                <textarea name="ctl00$body$txtOth" id="body_txtOth" class="form-control" rows="2" placeholder="ระบุ อื่น ๆ" style="display: none;"></textarea>
                                                
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="button" id="btnSave" class="btn btn-primary">บันทึก</button>
            </div>
            </div>
        </div>
    </div>

    <?php include_once 'layout/js.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script> -->
    <script>
        $(document).ready(function() {
            var token = "<?php echo $_GET['token']; ?>";

            var UserSecurityID = "<?php echo $_SESSION['UserSecurityID'] ?>";
            var date_start = '<?php echo $_GET['date_start'] ?>';
            var date_end = '<?php echo $_GET['date_end'] ?>';
            var emp_code = '<?php echo $_SESSION['ChangeRequest_code'] ?>';
            var emp_name = '<?php echo $username[0] ?>';

            let isConditionMet = false;

            if(UserSecurityID == '3'){
                if(date_start == '' && date_end == ''){
                    List_Logsheet_100(emp_code, emp_name);
                    isConditionMet = true;
                }

                if (!isConditionMet) {
                    List_Logsheet(emp_code, emp_name, date_start, date_end);
                }
            }
            else if(UserSecurityID == '4' || UserSecurityID == '2' || UserSecurityID == '1'){
                if(date_start == '' && date_end == ''){
                    List_Logsheet_100('', '');
                    isConditionMet = true;
                }

                if (!isConditionMet) {
                    List_Logsheet_All(date_start, date_end);
                }
            }

            $("#kt_app_toolbar_buttons").click(function() {
                $("#body_txtSheetNo").val('HM-XX-XXXXX');
                $("#staticBackdrop").modal("show");

                // $.ajax({
                //     url: "./getNextSheetNo/?token=" + token,
                //     success: function(data) {
                //         $("#body_txtSheetNo").val(data);
                //         $("#staticBackdrop").modal("show");
                //     }
                // })
            })

            $("#body_txtSheetDate").flatpickr({
                altInput: true,
                disableMobile: true,
                altFormat: "d-m-Y",
                dateFormat: "Y-m-d",
            });

            $("#body_txtLeadOutDate").flatpickr({
                altInput: true,
                disableMobile: true,
                altFormat: "d-m-Y",
                dateFormat: "Y-m-d",
            });

            $("#body_txtReturnDate").flatpickr({
                altInput: true,
                disableMobile: true,
                altFormat: "d-m-Y",
                dateFormat: "Y-m-d",
            });

            $("#body_txtReturnDateAct").flatpickr({
                altInput: true,
                disableMobile: true,
                altFormat: "d-m-Y",
                dateFormat: "Y-m-d",
            });

            $("#date_start, #date_end").flatpickr({
                altInput: true,
                disableMobile: true,
                altFormat: "d-m-Y",
                dateFormat: "Y-m-d",
            });

            $('#staticBackdrop').on('shown.bs.modal', function () {
                $('#body_dwDocType').select2({
                    placeholder: "---กรุณาเลือกประเภทเอกสาร---",
                    dropdownAutoWidth: true,
                    allowClear: true
                });
            });

            $('#body_dwDocRefer').select2({
                placeholder: "---เลือกเอกสารอ้างอิงการนำกลับ---"
            });

            $('#staticBackdrop').on('shown.bs.modal', function () {
                $('#body_dwDivisionReturn').select2({
                    // placeholder: "---เลือกแผนก/ฝ่ายที่ต้องการนำกลับ---",
                    // allowClear: true
                });
            });

            var table = $('#example').DataTable({
                fixedHeader: true,
                scrollX: true,
                buttons: [],
                pageLength: 10,
                "lengthMenu": [
                    [10, 25, 50, 100, 500, 1000, -1],
                    [10, 25, 50, 100, 500, 1000, "All"]
                ],
            });
            table.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');

            function List_Logsheet_100(emp_code, emp_name) {
                $.ajax({
                    url: './LogsheetTop100',
                    type: 'POST',
                    data: {
                        emp_code: emp_code,
                        emp_name: emp_name
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: 'กำลังโหลดข้อมูล...',
                            text: 'โปรดรอสักครู่',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(data) {
                        console.log('LogsheetTop100');
                        table.clear().draw();
                        $('#example tbody').html(data);
                        table.rows.add($('#example tbody tr')).draw();
                    },
                    complete: function() {
                        Swal.close();
                    }
                });
            }

            function List_Logsheet(emp_code, emp_name, date_start, date_end) {
                $.ajax({
                    url: './Logsheet',
                    type: 'POST',
                    data: {
                        emp_code: emp_code,
                        emp_name: emp_name,
                        date_start: date_start,
                        date_end: date_end
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: 'กำลังโหลดข้อมูล...',
                            text: 'โปรดรอสักครู่',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(data) {
                        console.log('List_Logsheet');
                        table.clear().draw();
                        $('#example tbody').html(data);
                        table.rows.add($('#example tbody tr')).draw();
                    },
                    complete: function() {
                        Swal.close();
                    }
                });
            }

            function List_Logsheet_All(date_start, date_end) {
                $.ajax({
                    url: './Logsheet_All',
                    type: 'POST',
                    data: {
                        date_start: date_start,
                        date_end: date_end
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: 'กำลังโหลดข้อมูล...',
                            text: 'โปรดรอสักครู่',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                    },
                    success: function(data) {
                        console.log('List_Logsheet_All');
                        table.clear().draw();
                        $('#example tbody').html(data);
                        table.rows.add($('#example tbody tr')).draw();
                    },
                    complete: function() {
                        Swal.close();
                    }
                    
                });
            }


            $('#search').click(function() {
                var date_start = $('#date_start').val();
                var date_end = $('#date_end').val();

                if (date_start == '' && date_end == '') {
                    Swal.fire({
                        title: 'กรุณากรอกวันที่เริ่มต้นและวันที่สิ้นสุด',
                        icon: 'warning',
                    });
                    return false;
                }

                window.location.href = "./?token=" + token + "&date_start=" + date_start + "&date_end=" + date_end;
            });

            
            $('#body_chk13').change(function() {
                if ($(this).is(':checked')) {
                    $('#body_txtOth').show();
                } else {
                    $('#body_txtOth').hide();
                }
            });

            $('#body_chk36').change(function() {
                if ($(this).is(':checked')) {
                    $('#body_txtOth').show();
                } else {
                    $('#body_txtOth').hide();
                }
            });

            $('#body_dwDocType').change(function() {
                if ($(this).val() === '5') {
                    $('#DocTypeOth').show();
                } else {
                    $('#DocTypeOth').hide();
                }
            });

            $('#body_dwDocRefer').change(function() {
                if ($(this).val() === '5') {
                    $('#dwDocRefer').show();
                    $(".select_Doc_Refer_4").show();
                } 
                else if ($(this).val() === '4') {
                    $('#dwDocRefer').hide();
                    $(".select_Doc_Refer_4").hide();
                }
                else {
                    $('#dwDocRefer').hide();
                    $(".select_Doc_Refer_4").show();
                }
            });


            $('#btnSave').click(function() {
                var username = '<?php echo $username[0]; ?>';
                var usercode = '<?php echo $_SESSION['ChangeRequest_code']; ?>';
                var body_txtSheetDate = $('#body_txtSheetDate').val();
                // var body_txtSheetNo = $('#body_txtSheetNo').val();
                var body_dwDocType = $('#body_dwDocType').val();
                var body_txtDocTypeOth = $('#body_txtDocTypeOth').val();
                var body_txtDocNo = $('#body_txtDocNo').val();
                var body_txtLeadOutUsers = $('#body_txtLeadOutUsers').val();
                var body_txtLeadOutDate = $('#body_txtLeadOutDate').val();
                var body_dwDocRefer = $('#body_dwDocRefer').val();
                var body_txtDocReferOth = $('#body_txtDocReferOth').val();
                var body_dwDivisionReturn = $('#body_dwDivisionReturn').val();
                var body_txtReturnDate = $('#body_txtReturnDate').val();
                var body_txtReturnDateAct = $('#body_txtReturnDateAct').val();
                var body_txtremk = $('#body_txtremk').val();
                var body_txtOth = $('#body_txtOth').val();

                let selectedCheckboxes = $('input[name="body_chk"]:checked').map(function() {
                    return this.value;
                }).get().join(',');

                if(body_txtReturnDate == '' && body_dwDocRefer != '4') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'กรุณากรอกวันที่คาดว่าจะนำกลับ',
                    });

                    return false;
                }

                if (selectedCheckboxes == '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'กรุณาเลือกรายการที่ต้องนำออก อย่างน้อย 1 รายการ',
                    });

                    return false;
                }


                // console.log('username:', username);
                // console.log('usercode:', usercode);
                // console.log('body_txtSheetDate:', body_txtSheetDate);
                // console.log('body_txtSheetNo:', body_txtSheetNo);
                // console.log('body_dwDocType:', body_dwDocType);
                // console.log('body_txtDocTypeOth:', body_txtDocTypeOth);
                // console.log('body_txtDocNo:', body_txtDocNo);
                // console.log('body_txtLeadOutUsers:', body_txtLeadOutUsers);
                // console.log('body_txtLeadOutDate:', body_txtLeadOutDate);
                // console.log('body_dwDocRefer:', body_dwDocRefer);
                // console.log('body_txtDocReferOth:', body_txtDocReferOth);
                // console.log('body_dwDivisionReturn:', body_dwDivisionReturn);
                // console.log('body_txtReturnDate:', body_txtReturnDate);
                // console.log('body_txtReturnDateAct:', body_txtReturnDateAct);
                // console.log('body_txtremk:', body_txtremk);
                // console.log('body_txtOth:', body_txtOth);
                // console.log('selectedCheckboxes:', selectedCheckboxes);

                $.ajax({
                    url: './insert_logsheet/?token=' + token,
                    type: 'POST',
                    data: {
                        username: username,
                        usercode: usercode,
                        body_txtSheetDate: body_txtSheetDate,
                        // body_txtSheetNo: body_txtSheetNo,
                        body_dwDocType: body_dwDocType,
                        body_txtDocTypeOth: body_txtDocTypeOth,
                        body_txtDocNo: body_txtDocNo,
                        body_txtLeadOutUsers: body_txtLeadOutUsers,
                        body_txtLeadOutDate: body_txtLeadOutDate,
                        body_dwDocRefer: body_dwDocRefer,
                        body_txtDocReferOth: body_txtDocReferOth,
                        body_dwDivisionReturn: body_dwDivisionReturn[0],
                        body_txtReturnDate: body_txtReturnDate,
                        body_txtReturnDateAct: body_txtReturnDateAct,
                        body_txtremk: body_txtremk,
                        body_txtOth: body_txtOth,
                        selectedCheckboxes: selectedCheckboxes
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.status === 'success') {
                            Swal.fire({
                                title: "เพิ่มข้อมูลสำเร็จ",
                                icon: "success",
                            }).then(() => {
                                window.location.href = 'https://innovation.asefa.co.th/it-apps/logsheetcenter/editform?token='+ token +'&Sheet_No=' + data.SheetNo;
                            });
                        } else if (data.status === 'error') {
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
        });

    </script>
</body>

</html>