<?php
    $List_Doctype = List_Doctype();
    $List_Doc_Refer = List_Doc_Refer();
    $SheetNo = getNextSheetNo();
    $List_Division47 = ListDivision();
    $Item_List = Item_List('New');
    $Item_List_Old = Item_List('Old');

    $username = explode(" ", mydata($_SESSION['ChangeRequest_code'])['FullNameEn']);

    $LogSheet = Select_Logsheet($_GET['Sheet_No']);
    $List_Status = List_Status();

    $List_File = List_File($_GET['Sheet_No']);
    $token = $_GET['token'];

    // echo "<pre>";
    // print_r($LogSheet['Create_Date']);
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

<style>
        .drop-zone {
            border: 2px dashed #007bff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
            cursor: pointer;
        }
        .file-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
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
                                            แก้ไขเอกสาร
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
                                <div class="card">
                                    <!--begin::Body-->

                                    <!--begin::About-->
                                    <div class="mb-18" style="padding: 15px;">
                                        <!--begin::Wrapper-->
                                        <div class="mb-10">
                                            <!--begin::Top-->
                                            <div class="text-center mb-3">
                                                <h3 class="fs-2hx text-dark mb-5">แก้ไขเอกสาร</h3>
                                            </div>
                                        </div>
                                        <div class="fs-5 fw-semibold text-gray-600">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="widget-box widget-color-green ui-sortable-handle">
                                                        <div class="widget-header mb-4">
                                                            <h4 class="widget-title">เพิ่ม LOG SHEET ใบนำของออกนอกบริษัท                                              
                                                        </div>
                                                        <div class=" widget-body">
                                                            <div class=" widget-main ms-6">
                                                                <div class="mb-3 row">
                                                                    <label for="staticEmail" class="col-4 col-form-label text-end">วันที่ใบนำของออก</label>
                                                                    <div class="col-6">
                                                                        <input class="form-control" placeholder="เลือกวันที่" id="body_txtSheetDate" name="body_txtSheetDate" value="<?php echo $LogSheet['Sheet_Date'] ?>" disabled />
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 row">
                                                                    <label for="staticEmail" class="col-4 col-form-label text-end">เลขที่ใบนำของออก</label>
                                                                    <div class="col-6">
                                                                        <input class="form-control" id="body_txtSheetNo" name="body_txtSheetNo" value="<?php echo $LogSheet['Sheet_No'] ?>" disabled />
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 row">
                                                                    <label for="staticEmail" class="col-4 col-form-label text-end">ประเภทเอกสาร</label>
                                                                    <div class="col-6">
                                                                        <select class="form-select" name="body_dwDocType" id="body_dwDocType">
                                                                            <option value=""></option>
                                                                            <?php  
                                                                                foreach ($List_Doctype as $key => $value) {
                                                                                    $selected = ($LogSheet['DocTypeID'] == $value['id']) ? 'selected' : '';
                                                                                    echo '<option value="'.$value['id'].'" '.$selected.'>'.$value['doctype'].'</option>';
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 row" id="DocTypeOth" <?php echo ($LogSheet['DocTypeID'] == 5) ? '' : 'style="display: none;"' ?>>
                                                                    <label for="staticEmail" class="col-4 col-form-label"></label>
                                                                    <div class="col-6">
                                                                        <input type="text" id="body_txtDocTypeOth" class="form-control" placeholder="ระบุประเภทเอกสารอื่นๆ" value="<?php echo $LogSheet['DocTypeOth'] ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 row">
                                                                    <label for="staticEmail" class="col-4 col-form-label text-end">เลขที่เอกสาร</label>
                                                                    <div class="col-6">
                                                                        <input type="text" id="body_txtDocNo" class="form-control" placeholder="เลขที่เอกสาร" value="<?php echo $LogSheet['Doc_No'] ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 row">
                                                                    <label for="staticEmail" class="col-4 col-form-label text-end">ชื่อผู้นำของออก</label>
                                                                    <div class="col-6">
                                                                        <input type="text" id="body_txtLeadOutUsers" class="form-control" value="<?php echo $LogSheet['LeadOutUsers'] ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 row">
                                                                    <label for="staticEmail" class="col-4 col-form-label text-end">วันที่ออก</label>
                                                                    <div class="col-6">
                                                                        <input class="form-control" placeholder="เลือกวันที่" id="body_txtLeadOutDate" name="body_txtLeadOutDate" value="<?php echo $LogSheet['LeadOut_Date'] ?>" />
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 row">
                                                                    <label for="staticEmail" class="col-4 col-form-label text-end">เอกสารอ้างอิงการนำกลับ</label>
                                                                    <div class="col-6">
                                                                        <select class="form-select" name="body_dwDocRefer" id="body_dwDocRefer">
                                                                            <option value=""></option>
                                                                            <?php
                                                                            foreach ($List_Doc_Refer as $k => $value) {
                                                                                $selectedd = ($LogSheet['DocReferID'] == $k) ? 'selected' : '';
                                                                                echo '<option value="'.$k.'" '.$selectedd.'>'.$value['docrefer'].'</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 row" id="dwDocRefer" <?php echo ($LogSheet['DocReferID'] == 5) ? '' : 'style="display: none;"' ?> >
                                                                    <label for="staticEmail" class="col-4 col-form-label"></label>
                                                                    <div class="col-6">
                                                                        <input type="text" id="body_txtDocReferOth" class="form-control" placeholder="ระบุเอกสารอ้างอิงการนำกลับอื่นๆ" value="<?php echo $LogSheet['DocReferOth'] ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 row select_Doc_Refer_4" <?php echo ($LogSheet['DocReferID'] == 4) ? 'style="display: none;"' : '' ?>>
                                                                    <label for="staticEmail" class="col-4 col-form-label text-end">แผนก/ฝ่ายที่นำกลับ</label>
                                                                    <div class="col-6">
                                                                        <select class="form-select" name="body_dwDivisionReturn" id="body_dwDivisionReturn">
                                                                            <option value=""></option>
                                                                            <?php
                                                                            foreach ($List_Division47 as $key => $value) {
                                                                                $selectedds = ($LogSheet['DepReturnID'] == $value['id']) ? 'selected' : '';
                                                                                echo '<option value="'.$value['id'].'" '.$selectedds.'>'.$value['dvname'].'</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 row select_Doc_Refer_4" <?php echo ($LogSheet['DocReferID'] == 4) ? 'style="display: none;"' : '' ?>>
                                                                    <label for="staticEmail" class="col-4 col-form-label text-end">วันที่คาดว่าจะนำกลับ</label>
                                                                    <div class="col-6">
                                                                        <input class="form-control" placeholder="เลือกวันที่" id="body_txtReturnDate" name="body_txtReturnDate" value="<?php echo $LogSheet['Return_Date'] ?>" />
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 row select_Doc_Refer_4" <?php echo ($LogSheet['DocReferID'] == 4) ? 'style="display: none;"' : '' ?>>
                                                                    <label for="staticEmail" class="col-4 col-form-label text-end">วันที่นำกลับ</label>
                                                                    <div class="col-6">
                                                                        <input class="form-control" placeholder="เลือกวันที่" id="body_txtReturnDateAct" name="body_txtReturnDateAct" value="<?php echo $LogSheet['Return_DateAct'] ?>" />
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 row">
                                                                    <label for="staticEmail" class="col-4 col-form-label text-end">หมายเหตุ</label>
                                                                    <div class="col-6">
                                                                        <input type="text" id="body_txtremk" class="form-control" value="<?php echo $LogSheet['Remark'] ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 row">
                                                                    <label for="staticEmail" class="col-4 col-form-label text-end">สถานะเอกสาร</label>
                                                                    <div class="col-6">
                                                                        <select class="form-select" name="body_dwSheetStatus" id="body_dwSheetStatus">
                                                                            <option value=""></option>
                                                                            <?php
                                                                            foreach ($List_Status as $k => $value) {
                                                                                $selectedss = ($LogSheet['SheetStatusID'] == $k) ? 'selected' : '';
                                                                                echo '<option value="'.$k.'" '.$selectedss.'>'.$value['sheetstatus'].'</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-5">
                                                    <div class="widget-box widget-color-green ui-sortable-handle">
                                                        <div class="widget-header mb-4">
                                                            <h4 class="widget-title">รายการที่ต้องนำออก&nbsp;&nbsp;                                               
                                                                <span id="body_ctl04" class="text-danger" style="visibility:hidden;">**ระบุรายการที่ต้องนำออก**</span></h4>
                                                        </div>
                                                        <div class=" widget-body">
                                                            <div class=" widget-main">
                                                                <div class="form-horizontal ms-6" role="form">
                                                                    <?php
                                                                    $item_arr = explode(',', $LogSheet['ItemID']);
                                                                    if(explode(' ', $LogSheet['Create_Date'])[0] < $_SESSION['cutoffDate']){
                                                                        foreach ($Item_List as $key => $value) {
                                                                        ?>
                                                                        <div class="form-group row mb-4">
                                                                            <div class="col-sm-12">
                                                                                <div class="checkbox">
                                                                                    <label>
                                                                                        <input type="checkbox" name="body_chk" id="body_chk<?php echo $key; ?>" value="<?php echo $value['id']; ?>" class="ace mb-3 form-check-input " <?php echo (in_array($value['id'], $item_arr)) ? 'checked' : '' ?>>
                                                                                        <span class="lbl">&nbsp;&nbsp;<?php echo $value['itemname']; ?></span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                        }
                                                                    }
                                                                    ?>

                                                                    <?php
                                                                    if(explode(' ', $LogSheet['Create_Date'])[0] > $_SESSION['cutoffDate']){
                                                                        foreach ($Item_List_Old as $key => $value) {
                                                                        ?>
                                                                        <div class="form-group row mb-4">
                                                                            <div class="col-sm-12">
                                                                                <div class="checkbox">
                                                                                    <label>
                                                                                        <input type="checkbox" name="body_chk" id="body_chk<?php echo $key; ?>" value="<?php echo $value['id']; ?>" class="ace mb-3 form-check-input " <?php echo (in_array($value['id'], $item_arr)) ? 'checked' : '' ?>>
                                                                                        <span class="lbl">&nbsp;&nbsp;<?php echo $value['itemname']; ?></span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                    
                                                                    <div class="col-sm-12">
                                                                            
                                                                            <textarea name="ctl00$body$txtOth" id="body_txtOth" class="form-control" rows="2" placeholder="ระบุ อื่น ๆ" <?php echo (in_array('13', $item_arr) || in_array('36', $item_arr)) ? '' : 'style="display: none;"' ?>><?php echo $LogSheet['ItemOth'] ?></textarea>
                                                                            
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                strtotime('2025-05-01');
                                                $date1 = strtotime($LogSheet['Create_Date']);
                                                if($_SESSION['UserSecurityID'] != '4' && ($_SESSION['UserSecurityID'] != '' || $_SESSION['UserSecurityID'] == '')) {
                                                ?>
                                                <div class="col-12 mb-3">
                                                    <div class="modal-footer my-3">
                                                        <button type="button" id="btnSave" class="btn btn-primary mx-2">บันทึกการแก้ไข</button>

                                                        <?php
                                                        if($date1 <= strtotime('2025-05-01')) {
                                                        ?>
                                                        <a href="./Print_PDF?token=<?= $token ?>&Sheet_No=<?= $LogSheet['Sheet_No'] ?>" class="btn btn-info m-0" target="_blank">
                                                            <i class="bi bi-printer-fill m-0 fs-4"></i> Print
                                                        </a>
                                                        <?php
                                                        }
                                                        elseif($date1 >= strtotime('2025-05-01')) {
                                                        ?>
                                                        <a href="./Print_PDF_New?token=<?= $token ?>&Sheet_No=<?= $LogSheet['Sheet_No'] ?>" class="btn btn-info m-0" target="_blank">
                                                            <i class="bi bi-printer-fill m-0 fs-4"></i> Print
                                                        </a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php
                                                }
                                                ?>

                                                <div class="col-4">
                                                    <div class="container mt-5 text-center">
                                                        <h2>อัปโหลดไฟล์ด้วย Drag and Drop</h2>
                                                        <button type="button" id="btnUpload" class="btn btn-info mb-3">อัปโหลด</button>
                                                        <div class="drop-zone" id="drop-zone">
                                                            ลากและวางไฟล์ที่นี่ หรือ <strong>คลิกเพื่อเลือกไฟล์</strong>
                                                        </div>
                                                        <div id="file-list"></div>
                                                    </div>
                                                </div>
                                                <div class="col-8">
                                                    <table class="table">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <td>ชื่อไฟล์</td>
                                                                <td>ดาวน์โหลด</td>
                                                                <td>ลบ</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($List_File as $key => $value) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $value['name']; ?></td>
                                                                <td><a href="./open_file?id=<?php echo $value['id']; ?>" target="_blank">เปิดไฟล์</a></td>
                                                                <td><a href="javascript:void(0)" onclick="deleteFile('<?php echo $value['id']; ?>')">ลบ</a></td>
                                                            </tr>
                                                            <?php
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
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
    <script>
        var token = "<?php echo $_GET['token']; ?>";

        $(document).ready(function() {
            var token = "<?php echo $_GET['token']; ?>";

            $("#kt_app_toolbar_buttons").click(function() {
                $("#staticBackdrop").modal("show");

                var SheetNo = '<?php echo getNextSheetNo(); ?>';
                $("#body_txtSheetNo").val(SheetNo);
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

            $('#body_dwDocType').select2({
                placeholder: "---กรุณาเลือกประเภทเอกสาร---"
            });

            $('#body_dwDocRefer').select2({
                placeholder: "---เลือกเอกสารอ้างอิงการนำกลับ---"
            });

            $('#body_dwDivisionReturn').select2({
                placeholder: "---เลือกแผนก/ฝ่ายที่ต้องการนำกลับ---"
            });

            $('#body_dwSheetStatus').select2({
                placeholder: "---เลือกสถานะเอกสาร---"
            });

            var table = $('#example').DataTable({

                lengthChange: false,
                buttons: [],
                pageLength: 10,
                sort: false,
                " lengthMenu": [
                    [10, 25, 50, 100, 500, 1000, -1],
                    [10, 25, 50, 100, 500, 1000, "All"]
                ],
            });
            table.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');

            
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
                var body_txtSheetNo = $('#body_txtSheetNo').val();
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
                var body_dwSheetStatus = $('#body_dwSheetStatus').val();
                var body_txtOth = $('#body_txtOth').val();

                // console.log(body_txtLeadOutUsers);
                

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
                // console.log('body_txtremk:', body_txtremk);
                // console.log('body_dwSheetStatus:', body_dwSheetStatus);
                // console.log('body_txtOth:', body_txtOth);
                // console.log('selectedCheckboxes:', selectedCheckboxes);

                $.ajax({
                    url: './update_logsheet/?token=' + token,
                    type: 'POST',
                    data: {
                        username: username,
                        usercode: usercode,
                        body_txtSheetNo: body_txtSheetNo,
                        body_dwDocType: body_dwDocType,
                        body_txtDocTypeOth: body_txtDocTypeOth,
                        body_txtDocNo: body_txtDocNo,
                        body_txtLeadOutUsers: body_txtLeadOutUsers,
                        body_txtLeadOutDate: body_txtLeadOutDate,
                        body_dwDocRefer: body_dwDocRefer,
                        body_txtDocReferOth: body_txtDocReferOth,
                        body_dwDivisionReturn: body_dwDivisionReturn,
                        body_txtReturnDate: body_txtReturnDate,
                        body_txtReturnDateAct: body_txtReturnDateAct,
                        body_txtremk: body_txtremk,
                        body_dwSheetStatus: body_dwSheetStatus,
                        body_txtOth: body_txtOth,
                        selectedCheckboxes: selectedCheckboxes
                    },
                    success: function(data) {
                        console.log(data);

                        if (data.status === 'success') {
                            Swal.fire({
                                title: "แก้ไขสำเร็จ",
                                icon: "success",
                            }).then(() => {
                                location.reload();
                            });
                        } else if (data.status === 'error') {
                            console.log(data);
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


            const dropZone = $('#drop-zone');
            const fileList = $('#file-list');
            let filesToUpload = [];

            dropZone.on('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropZone.addClass('bg-light');
            });

            dropZone.on('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropZone.removeClass('bg-light');
            });

            dropZone.on('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropZone.removeClass('bg-light');

                const files = e.originalEvent.dataTransfer.files;
                handleFiles(files);
            });

            dropZone.on('click', function() {
                $('<input type="file" multiple>').on('change', function() {
                    const files = this.files;
                    handleFiles(files);
                }).click();
            });

            function handleFiles(files) {
                const allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'xlsx', 'xls', 'doc', 'docx', 'ppt', 'pptx', 'zip', 'txt', 'csv'];
                const dangerousExtensions = ['php', 'phtml', 'php3', 'php4', 'php5', 'php7', 'phps', 'pht', 'phar', 'cgi', 'pl', 'py', 'rb', 'sh', 'bat', 'cmd', 'com', 'exe', 'asp', 'aspx', 'jsp', 'htaccess'];
                const maxFileSize = 10 * 1024 * 1024; // 10MB

                for (const file of files) {
                    const fileName = file.name;
                    const fileExt = fileName.split('.').pop().toLowerCase();

                    // ตรวจขนาดไฟล์
                    if (file.size > maxFileSize) {
                        Swal.fire({ icon: 'error', title: 'ไฟล์ "' + fileName + '" มีขนาดเกิน 10MB' });
                        continue;
                    }

                    // ตรวจ extension whitelist
                    if (!allowedExtensions.includes(fileExt)) {
                        Swal.fire({ icon: 'error', title: 'ไฟล์ "' + fileName + '" มีนามสกุลไม่อนุญาต', text: 'อนุญาตเฉพาะ: ' + allowedExtensions.join(', ') });
                        continue;
                    }

                    // ตรวจ double extension (เช่น test.php.pdf)
                    const nameParts = fileName.split('.');
                    let hasDangerousExt = false;
                    for (let i = 0; i < nameParts.length - 1; i++) {
                        if (dangerousExtensions.includes(nameParts[i].toLowerCase())) {
                            hasDangerousExt = true;
                            break;
                        }
                    }
                    if (hasDangerousExt) {
                        Swal.fire({ icon: 'error', title: 'ตรวจพบนามสกุลไฟล์อันตรายซ่อนอยู่', text: 'ไฟล์ "' + fileName + '" ไม่อนุญาตให้อัปโหลด' });
                        continue;
                    }

                    filesToUpload.push(file);
                    const fileItem = $('<div class="file-item"></div>').text(file.name);
                    const deleteButton = $('<button class="btn btn-danger btn-sm">ลบ</button>').on('click', function() {
                        fileItem.remove();
                        filesToUpload = filesToUpload.filter(f => f.name !== file.name);
                    });
                    fileItem.append(deleteButton);
                    fileList.append(fileItem);
                }
            }

            $('#btnUpload').on('click', function() {
                var body_txtSheetNo = $('#body_txtSheetNo').val();
                const formData = new FormData();

                formData.append('body_txtSheetNo', body_txtSheetNo);
                filesToUpload.forEach(file => {
                    formData.append('files[]', file);
                });
                // console.log(formData);

                $.ajax({
                    url: './update_file?token=' + token,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // console.log(response);
                        // var data_arr = JSON.parse(response);
                        if (response.status == 'success') {
                            Swal.fire({
                                title: "อัปโหลดไฟล์สําเร็จ",
                                icon: "success",
                            }).then(() => {
                                location.reload();
                            });
                        }
                        else if (response.status == 'warning') {
                            Swal.fire({
                                title: "กรุณาแนบไฟล์อย่างน้อย 1 ไฟล์",
                                icon: "warning",
                            })
                        }
                        else {
                            console.log(response);
                            Swal.fire({
                                title: "เกิดข้อผิดพลาด",
                                icon: "error",
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function() {
                        alert('เกิดข้อผิดพลาดในการอัปโหลด');
                    }
                });
            });
        });

        function deleteFile(id) {
            Swal.fire({
                title: "คุณแน่ใจหรือไม่ว่าจะลบไฟล์นี้?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: 'ใช่, ลบไฟล์!',
                cancelButtonText: 'ไม่, ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: './delete_file/?token=' + token,
                        type: 'POST',
                        data: {
                            id: id
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                Swal.fire({
                                    title: "ลบไฟล์สำเร็จ",
                                    icon: "success",
                                }).then(() => {
                                    location.reload();
                                });
                            } else if (data.status === 'error') {
                                console.log(data);
                                Swal.fire({
                                    title: "เกิดข้อผิดพลาด",
                                    icon: "error",
                                }).then(() => {
                                    location.reload();
                                });
                            }
                        }
                    });
                }
            });
        }
        
    </script>
</body>

</html>