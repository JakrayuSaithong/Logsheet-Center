<?php
    // if ($_SESSION['UserSecurityID'] == '') {
    //     echo "<script>
    //         alert('คุณไม่มีสิทธิ์เข้าใช้งาน');
    //         window.history.back();
    //     </script>";
    //     exit();
    // }

    $List_Status = List_Status();
    $emplist = emplist();
    $List_Division47 = ListDivision();
    $List_Status = List_Status();
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
                <div class="d-flex flex-row flex-column-fluid ">
                    <!--begin::Main-->
                    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                        <!--begin::Content wrapper-->
                        <div class="d-flex flex-column flex-column-fluid">
                            <!--begin::Toolbar-->
                            <div id="kt_app_toolbar" class="app-toolbar  d-flex flex-stack py-4 py-lg-8 ">
                                <!--begin::Toolbar wrapper-->
                                <div class="d-flex flex-grow-1 flex-stack flex-wrap gap-2 mb-n10 mx-6" id="kt_toolbar">
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

                                    <!-- <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3" data-bs-toggle="modal" data-bs-target="#insert">
                                        <a type="button" class="btn btn-primary">
                                            <i class="fas fa-search fs-6"></i> ค้นหา
                                        </a>
                                    </div> -->

                                </div>
                            </div>

                            <div id="kt_app_content" class="app-content  flex-column-fluid ">
                                <div class="card">
                                    
                                    <div class="mb-18" style="padding: 15px;">
                                        <div class="mb-10">
                                            <div class="text-center mb-3">
                                                <h3 class="fs-2hx text-dark mb-5">รายการเอกสาร</h3>
                                            </div>
                                        </div>
                                        <div class="mb-10">
                                            <div class="row justify-content-center">
                                                <div class="col-5 col-md-3 mt-3">
                                                    <input name="date_start" class="form-control" id="date_start" placeholder="เลือกวันที่เริ่ม" value="<?php echo isset($_GET['date_start']) ? $_GET['date_start'] : date('Y-m-d'); ?>">
                                                </div>
                                                <div class="col-2 col-md-1 mt-3 row align-items-center">
                                                    <span class="text-center">ถึง</span>
                                                </div>
                                                <div class="col-5 col-md-3 mt-3">
                                                    <input name="date_end" class="form-control" id="date_end" placeholder="เลือกวันที่สิ้นสุด" value="<?php echo isset($_GET['date_end']) ? $_GET['date_end'] : date('Y-m-d'); ?>">
                                                </div>
                                            </div>
                                            <div class="row justify-content-center">
                                                <div class="col-12 col-md-3 mt-3">
                                                    <select id="user_create" class="form-select">
                                                        <option value="" selected>---- เลือกผู้สร้าง ----</option>
                                                        <?php
                                                        foreach($emplist as $key => $value){
                                                            $select = isset($_GET['user_create']) && $_GET['user_create'] == $value['Code'] ? 'selected' : '';
                                                        ?>
                                                        <option value="<?php echo $value['Code']; ?>" <?php echo $select; ?>><?php echo $value['FullName']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-md-3 mt-3">
                                                    <select id="dep" class="form-select">
                                                        <option value="" selected>---- เลือกแผนก/ฝ่าย ----</option>
                                                        <?php
                                                        foreach($List_Division47 as $key => $value){
                                                            $select = isset($_GET['dep']) && $_GET['dep'] == $value['id'] ? 'selected' : '';
                                                        ?>
                                                        <option value="<?php echo $value['id']; ?>" <?php echo $select; ?>><?php echo $value['dvname']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-md-3 mt-3">
                                                    <select id="sheet_status" class="form-select">
                                                        <option value="" selected>---- เลือกสถานะเอกสาร ----</option>
                                                        <?php
                                                        foreach($List_Status as $key => $value){
                                                            $select = isset($_GET['sheet_status']) && $_GET['sheet_status'] == $value['id'] ? 'selected' : '';
                                                        ?>
                                                        <option value="<?php echo $value['id']; ?>" <?php echo $select; ?>><?php echo $value['sheetstatus']; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-md-1 mt-3 text-center">
                                                    <button type="button" name="search" id="search" class="btn btn-primary">ค้นหา</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fs-5 fw-semibold text-gray-600">
                                            <button id="export" class="btn btn-success mb-5"><i class="fa-solid fa-file-excel fs-4"></i> Excel</button>
                                            <div class="table-responsive">
                                                <table class="table table-bordered border-dark border-2" id="table-id">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th colspan="14">บริษัท อาซีฟา จำกัด (มหาชน)</th>
                                                        </tr>
                                                        <tr class="text-center">
                                                            <th colspan="14">รายงาน Log Sheet ใบนำของออกนอกบริษัท</th>
                                                        </tr>
                                                        <tr class="text-center">
                                                            <th colspan="14">แจ้งเตือน LOG SHEET ใบนำของออกนอกบริษัท (<?php echo $_GET['date_start']; ?> ถึง <?php echo $_GET['date_end']; ?>)</th>
                                                        </tr>
                                                        <!-- <tr class="text-center">
                                                            <th colspan="14">เฉพาะ แผนกบริหารทรัพยากรมนุษย์ เท่านั้น</th>
                                                        </tr> -->
                                                        <tr>
                                                            <th class="text-nowrap">ที่</th>
                                                            <th class="text-nowrap">วันที่</th>
                                                            <th class="text-nowrap">ใบนำของออก</th>
                                                            <th class="text-nowrap">ประเภทเอกสาร</th>
                                                            <th class="text-nowrap">เลขที่เอกสาร</th>
                                                            <th class="text-nowrap">ผู้แจ้งนำของออก</th>
                                                            <th class="text-nowrap">แผนก/ฝ่าย</th>
                                                            <th class="text-nowrap">รายการที่ต้องการนำออก</th>
                                                            <th class="text-nowrap">วันที่ออก</th>
                                                            <th class="text-nowrap">แผนก/ฝ่ายที่นำกลับ</th>
                                                            <th class="text-nowrap">วันที่คาดว่าจะนำกลับ</th>
                                                            <th class="text-nowrap">วันที่นำกลับ</th>
                                                            <th class="text-nowrap">เอกสารอ้างอิงการนำกลับ</th>
                                                            <th class="text-nowrap">สถานะ</th>
                                                        </tr>
                                                        <!-- <tr>
                                                            <th rowspan="2">ที่</th>
                                                            <th rowspan="2">วันที่</th>
                                                            <th colspan="3">เลขที่เอกสารนำของออก</th>
                                                            <th rowspan="2">ผู้แจ้งนำของออก</th>
                                                            <th rowspan="2">แผนก/ฝ่าย</th>
                                                            <th rowspan="2">รายการที่ต้องการนำออก</th>
                                                            <th rowspan="2">วันที่ออก</th>
                                                            <th rowspan="2">แผนก/ฝ่ายที่นำกลับ</th>
                                                            <th rowspan="2">วันที่คาดว่าจะนำกลับ</th>
                                                            <th colspan="3">ส่วนของการนำกลับ</th>
                                                        </tr>
                                                        <tr>
                                                            <th>ใบนำของออก</th>
                                                            <th>ประเภทเอกสาร</th>
                                                            <th>เลขที่เอกสาร</th>
                                                            <th>วันที่นำกลับ</th>
                                                            <th>เอกสารอ้างอิงการนำกลับ</th>
                                                            <th>สถานะ</th>
                                                        </tr> -->
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>

    <!-- use xlsx.full.min.js from version 0.20.3 -->
    <!-- <script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.3/package/dist/xlsx.full.min.js"></script> -->

    <script>
        $(document).ready(function() {
            var token = "<?php echo $_GET['token']; ?>";
            var date_start = '<?php echo $_GET['date_start'] ?>';
            var date_end = '<?php echo $_GET['date_end'] ?>';
            var user_create = '<?php echo $_GET['user_create'] ?>';
            var dep = '<?php echo $_GET['dep'] ?>';
            var sheet_status = '<?php echo $_GET['sheet_status'] ?>';

            if(date_start != '' && date_end != ''){
                List_Logsheet_All(date_start, date_end, user_create, dep, sheet_status);
            }

            $("#date_start, #date_end").flatpickr({
                altInput: true,
                disableMobile: true,
                altFormat: "d-m-Y",
                dateFormat: "Y-m-d",
            });

            $('#user_create, #dep, #sheet_status').select2();

            $('#search').click(function() {
                var date_start = $('#date_start').val();
                var date_end = $('#date_end').val();
                var user_create = $('#user_create').val();
                var dep = $('#dep').val();
                var sheet_status = $('#sheet_status').val();

                if (date_start == '' && date_end == '') {
                    Swal.fire({
                        title: 'กรุณากรอกวันที่เริ่มต้นและวันที่สิ้นสุด',
                        icon: 'warning',
                    });
                    return false;
                }

                window.location.href = "./report?token=" + token + "&date_start=" + date_start + "&date_end=" + date_end + "&user_create=" + user_create + "&dep=" + dep + "&sheet_status=" + sheet_status;
            });

            function List_Logsheet_All(date_start, date_end, user_create, dep, sheet_status) {
                $.ajax({
                    url: './Logsheet_All_report',
                    type: 'POST',
                    data: {
                        date_start: date_start,
                        date_end: date_end,
                        user_create: user_create,
                        dep: dep,
                        sheet_status: sheet_status
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
                        // console.log(data);
                        $('#table-id tbody').empty();
                        $('#table-id tbody').html(data);
                    },
                    complete: function() {
                        Swal.close();
                    }
                    
                });
            }

            $("#export").click(function () {
                var workbook = new ExcelJS.Workbook();
                var worksheet = workbook.addWorksheet('Log Sheet');


                worksheet.columns = [
                    { width: 5 },
                    { width: 9.5 },
                    { width: 17 },
                    { width: 20 },
                    { width: 11 },
                    { width: 17.5 },
                    { width: 21.5 },
                    { width: 45.5 },
                    { width: 10 },
                    { width: 11.5 },
                    { width: 11.5 },
                    { width: 9 },
                    { width: 18 },
                    { width: 8 },
                ];
                
                var table = document.getElementById('table-id');
                var rows = table.rows;

                // เก็บข้อมูลที่เซลล์ไหนได้ถูกรวมไปแล้ว
                var mergedCells = [];

                for (var i = 0; i < rows.length; i++) {
                    var row = worksheet.addRow();
                    for (var j = 0; j < rows[i].cells.length; j++) {
                        var cell = rows[i].cells[j];

                        var cellValue = cell.innerText;
                        var colspan = cell.colSpan || 1;
                        var rowspan = cell.rowSpan || 1;

                        // ตั้งค่าเซลล์ปกติ
                        row.getCell(j + 1).value = cellValue;
                        row.getCell(j + 1).alignment = { horizontal: 'center', vertical: 'middle', wrapText: true };

                        row.getCell(j + 1).font = {
                            name: 'Angsana New', // ชื่อฟอนต์
                            size: 16,      // ขนาด
                        };

                        row.getCell(j + 1).border = {
                            top: { style: 'thin' },
                            left: { style: 'thin' },
                            bottom: { style: 'thin' },
                            right: { style: 'thin' }
                        };

                        // ถ้ามี colspan (รวมเซลล์ในแถวเดียวกัน)
                        if (colspan > 1) {
                            var mergeStartCol = j + 1;
                            var mergeEndCol = j + colspan;
                            var isMerged = false;

                            // ตรวจสอบว่าเซลล์นั้นถูกรวมไปแล้วหรือยัง
                            for (var k = mergeStartCol; k <= mergeEndCol; k++) {
                                if (mergedCells.includes(`${i + 1},${k}`)) {
                                    isMerged = true;
                                    break;
                                }
                            }

                            // ถ้ายังไม่ถูกรวม, ทำการรวมเซลล์
                            if (!isMerged) {
                                worksheet.mergeCells(i + 1, mergeStartCol, i + 1, mergeEndCol);
                                for (var k = mergeStartCol; k <= mergeEndCol; k++) {
                                    mergedCells.push(`${i + 1},${k}`); // เพิ่มเซลล์ที่รวมแล้วใน mergedCells
                                }
                            }
                        }

                        // ถ้ามี rowspan (รวมเซลล์ในคอลัมน์เดียวกัน)
                        if (rowspan > 1) {
                            var mergeStartRow = i + 1;
                            var mergeEndRow = i + rowspan;
                            var isMerged = false;

                            // ตรวจสอบว่าเซลล์นั้นถูกรวมไปแล้วหรือยัง
                            for (var k = mergeStartRow; k <= mergeEndRow; k++) {
                                if (mergedCells.includes(`${k},${j + 1}`)) {
                                    isMerged = true;
                                    break;
                                }
                            }

                            // ถ้ายังไม่ถูกรวม, ทำการรวมเซลล์
                            if (!isMerged) {
                                worksheet.mergeCells(mergeStartRow, j + 1, mergeEndRow, j + 1);
                                for (var k = mergeStartRow; k <= mergeEndRow; k++) {
                                    mergedCells.push(`${k},${j + 1}`); // เพิ่มเซลล์ที่รวมแล้วใน mergedCells
                                }
                            }
                        }
                    }
                }

                // สร้างไฟล์ Excel
                workbook.xlsx.writeBuffer().then(function(buffer) {
                    var blob = new Blob([buffer], {type: "application/octet-stream"});
                    var link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = `รายงาน_Log_Sheet.xlsx`;
                    link.click();
                });
            });


        });

    </script>
</body>

</html>