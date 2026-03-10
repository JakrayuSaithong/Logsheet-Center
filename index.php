<?php
session_start();
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
// session_destroy();

include_once    'route.php';
include_once    'config/base.php';

if (isset($_GET['DataE'])) {

    $JsonText = decryptIt($_GET['DataE']);
	$JSOnArr = json_decode($JsonText, true);
	$now = time();

    $dataTime = (is_array($JSOnArr) && isset($JSOnArr['date_U'])) ? (int)$JSOnArr['date_U'] : 0;
	if (($now - $dataTime) > 3600) {
		session_unset();
		session_destroy();

		echo "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <title>Session Expired</title>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'หมดเวลาการใช้งาน',
                text: 'Session หมดอายุแล้ว กรุณาเข้าสู่ระบบใหม่',
                confirmButtonText: 'ตกลง',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then(() => {
                window.close();
                window.location.href = 'about:blank';
            });
        </script>
        </body>
        </html>
        ";
		exit();
	}

    if ($JSOnArr['auth_user_name']) {
        $Users_Username = $JSOnArr['auth_user_name'];
        $get_emp_detail = "https://innovation.asefa.co.th/applications/ds/emp_list_code";
        $chs = curl_init();
        curl_setopt($chs, CURLOPT_URL, $get_emp_detail);
        curl_setopt($chs, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chs, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($chs, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($chs, CURLOPT_POST, 1);
        curl_setopt($chs, CURLOPT_POSTFIELDS, ["emp_code" => $Users_Username]);
        $emp = curl_exec($chs);
        curl_close($chs);

        $empdata   =   json_decode($emp);

        $_SESSION['ChangeRequest_login'] = "UserLogin";
        $_SESSION['ChangeRequest_user_id'] = $empdata[0]->id_ref;
        $_SESSION['ChangeRequest_code'] = $empdata[0]->emp_code;
        $_SESSION['ChangeRequest_name'] = $empdata[0]->emp_FirstName;
        $_SESSION['ChangeRequest_Fullname'] = $empdata[0]->emp_FirstName . ' ' . $empdata[0]->emp_LastName;
        $_SESSION['UserSecurityID'] = getUserSecurityID($_SESSION['ChangeRequest_Fullname'], $_SESSION['ChangeRequest_code']);
        $_SESSION['ChangeRequest_image'] = $empdata[0]->emp_Image;
        $_SESSION['ChangeRequest_mail'] = $empdata[0]->emp_Email;
        $_SESSION['DivisionHeadID1'] = $empdata[0]->DivisionHeadID1;
        $_SESSION['DivisionHead1'] = $empdata[0]->DivisionHead1;
        $_SESSION['DivisionHeadID2'] = $empdata[0]->DivisionHeadID2;
        $_SESSION['DivisionHead2'] = $empdata[0]->DivisionHead2;
        $_SESSION['DivisionCode'] = $empdata[0]->DivisionCode;
        $_SESSION['DivisionNameTH'] = $empdata[0]->DivisionNameTH;
        $_SESSION['DataE'] = $_GET['DataE'];
        $_SESSION['cutoffDate'] = '2025-05-01';
        $_SESSION['currentDate'] = date('Y-m-d');

        if($_SESSION['ChangeRequest_user_id'] == '2776'){
            // $_SESSION['UserSecurityID'] = null;
        }
    }
}

$route->add('/', function () { {
        $page = 1;
        include("home.php");
    }
});

$route->add('/test', function () { {
        $page = 1;
        include("test.php");
    }
});

$route->add('/insert', function () { {
        $page = 2;
        include("insertForm.php");
    }
});

$route->add('/editform', function () { {
        $page = 2;
        include("EditForm.php");
    }
});

$route->add('/doc_type', function () { {
    $page = 4;
    include("type_doc.php");
}
});

$route->add('/item_list', function () { {
    $page = 4;
    include("item_list.php");
}
});

$route->add('/doc_refer_list', function () { {
    $page = 4;
    include("doc_Refer_list.php");
}
});

$route->add('/sheet_status_list', function () { {
    $page = 4;
    include("sheet_status_list.php");
}
});

$route->add('/report', function () { {
    $page = 5;
    include("report.php");
}
});

$route->add('/permission', function () { {
    $page = 6;
    include("permission.php");
}
});

$route->add('/Print_PDF', function () { {
        include("Print_PDF.php");
    }
});

$route->add('/Print_PDF_New', function () { {
        include("Print_PDF_New.php");
    }
});

$route->add('/List_Logsheet', function () { {
        ob_clean();
        header_remove();
        header("Content-type: application/json; charset=utf-8");

        // echo $List_Logsheet = json_encode() List_Logsheet();
    }
});

$route->add('/getNextSheetNo', function () { {
        echo getNextSheetNo();
    }
});

$route->add('/open_file', function () { {
        global $connection_Logsheet;

        if (isset($_GET['id'])) {
            $fileId = $_GET['id'];
        
            $sql = "
            SELECT 
                [id]
                ,[sheet_no]
                ,[name]
                ,[contenttype]
                ,[datafile]
            FROM AttachFileLogSheet WHERE id = ?
            ";

            $params = array($fileId);
            $stmt = sqlsrv_query($connection_Logsheet, $sql, $params);
        
            if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $fileData = $row['datafile'];
                $fileType = $row['contenttype'];
                $base64pdf = base64_encode($fileData);
                $fileName = htmlspecialchars($row['name']);
                $pdfContent = 'data:'. $fileType .';base64,' . $base64pdf;
                echo '
                <style>
                    body, html {
                        margin: 0;
                        padding: 0;
                        height: 100%;
                        overflow: hidden;
                    }
                    embed {
                        width: 100vw;
                        height: 100vh;
                    }
                    pdf-viewer viewer-toolbar #title::after {
                        content: "'. $fileName .'";
                    }
                </style>
                <embed src="' . $pdfContent . '" type="' . $fileType . '" title="' . $fileName . '">
                ';
                
            } else {
                echo "ไม่พบไฟล์";
            }
        } else {
            echo "ไม่พบ ID ของไฟล์";
        }
    }
});

$route->add('/emp_list', function () { {
    ob_clean();
    header_remove();
    header("Content-type: application/json; charset=utf-8");

    global $konnext_lqsym;

    $divition_code = $_GET['divi_code_1'];

    if($divition_code != 'all'){
        $sql = "
            SELECT 
                w_10.site_f_365 AS Code,
                w_10.site_f_366 AS FullName,
                w_15_2.site_f_1144 AS DivisionCode
            FROM work_progress_010 w_10
            JOIN work_progress_015 w_15 
                ON w_10.site_f_1155 = w_15.site_id_15
            LEFT JOIN work_progress_015 w_15_2 
                ON w_15.site_f_1204 = w_15_2.site_id_15
            WHERE w_10.site_f_3005 = '600'
            AND (
                    w_10.site_f_398 = '0000-00-00' OR w_10.site_f_398 > CURRENT_DATE()
                )
        ";

        if($divition_code != null || $divition_code != "") {
            $sql .= " 
                AND w_15_2.site_f_1144 LIKE '%$divition_code%'
            ";
        }
    }
    else{
        $sql = "
            SELECT 
                w_10.site_f_365 AS Code,
                w_10.site_f_366 AS FullName,
                w_15_2.site_f_1144 AS DivisionCode
            FROM work_progress_010 w_10
            JOIN work_progress_015 w_15 
                ON w_10.site_f_1155 = w_15.site_id_15
            LEFT JOIN work_progress_015 w_15_2 
                ON w_15.site_f_1204 = w_15_2.site_id_15
            WHERE w_10.site_f_3005 = '600'
            AND (
                    w_10.site_f_398 = '0000-00-00' OR w_10.site_f_398 > CURRENT_DATE()
                )
            AND (
                    SUBSTRING(w_15_2.site_f_1144, 1, 2) = '61' OR SUBSTRING(w_15_2.site_f_1144, 1, 2) = '63'
                )
        ";
    }

    $query        =    mysqli_query($konnext_lqsym, $sql) or die(mysqli_error($konnext_lqsym));
    $num = mysqli_num_rows($query);
    if ($num > 0) {
        while ($row    =    mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            $data[] = $row;
        }

        if($divition_code == 'all' || $divition_code == '63'){
            $data[] = array(
                "Code" => "481211078",
                "FullName"=> "ศิวณัชฐกุล ไชยศร",
                "DivisionCode"=> "633"
            );
        }
    }
    echo json_encode($data);
}
});

$route->add('/insert_logsheet', function () { {
        ob_clean();
        header_remove();
        header("Content-type: application/json; charset=utf-8");

        global $connection_Logsheet;

        $username = !empty($_POST['username']) ? $_POST['username'] : NULL;
        $usercode = !empty($_POST['usercode']) ? $_POST['usercode'] : NULL;
        $body_txtSheetDate = !empty($_POST['body_txtSheetDate']) ? $_POST['body_txtSheetDate'] . " 00:00:00.000" : NULL;
        // $body_txtSheetNo = !empty($_POST['body_txtSheetNo']) ? $_POST['body_txtSheetNo'] : NULL;
        $body_txtSheetNo = getNextSheetNo();
        $body_dwDocType = !empty($_POST['body_dwDocType']) ? $_POST['body_dwDocType'] : NULL;
        $body_txtDocTypeOth = !empty($_POST['body_txtDocTypeOth']) ? $_POST['body_txtDocTypeOth'] : NULL;
        $body_txtDocNo = !empty($_POST['body_txtDocNo']) ? $_POST['body_txtDocNo'] : NULL;
        $body_txtLeadOutUsers = !empty($_POST['body_txtLeadOutUsers']) ? $_POST['body_txtLeadOutUsers'] : NULL;
        $body_txtLeadOutDate = !empty($_POST['body_txtLeadOutDate']) ? $_POST['body_txtLeadOutDate'] . " 00:00:00.000" : NULL;
        $body_dwDocRefer = !empty($_POST['body_dwDocRefer']) ? $_POST['body_dwDocRefer'] : NULL;
        $body_txtDocReferOth = !empty($_POST['body_txtDocReferOth']) ? $_POST['body_txtDocReferOth'] : NULL;
        $body_dwDivisionReturn = !empty($_POST['body_dwDivisionReturn']) ? $_POST['body_dwDivisionReturn'] : NULL;
        $body_txtReturnDate = !empty($_POST['body_txtReturnDate']) ? $_POST['body_txtReturnDate'] . " 00:00:00.000" : NULL;
        $body_txtReturnDateAct = !empty($_POST['body_txtReturnDateAct']) ? $_POST['body_txtReturnDateAct'] . " 00:00:00.000" : NULL;
        $body_txtremk = !empty($_POST['body_txtremk']) ? $_POST['body_txtremk'] : NULL;
        $body_txtOth = !empty($_POST['body_txtOth']) ? $_POST['body_txtOth'] : NULL;
        $selectedCheckboxes = !empty($_POST['selectedCheckboxes']) ? $_POST['selectedCheckboxes'] : NULL;

        $DepID = SelectDepID($username, $usercode);

        if($body_dwDocRefer == '4'){
            $sheet_status = 1;
        }
        else{
            $sheet_status = 2;
        }

        $sql = "
            INSERT INTO LeadOutSheetDB
            (
                [Sheet_Date],
                [Sheet_No],
                [DocTypeID],
                [Doc_No],
                [InformID],
                [DepID],
                [ItemID],
                [LeadOut_Date],
                [Return_Date],
                [DocReferID],
                [Status],
                [LastUpdate_TimeStamp],
                [UserIDCreate],
                [Create_Date],
                [UserIDEdit],
                [Edit_Date],
                [SheetStatusID],
                [DepReturnID],
                [Return_DateAct],
                [ItemOth],
                [DocTypeOth],
                [DocReferOth],
                [Remark],
                [LeadOutUsers]
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";

        $params = array(
            $body_txtSheetDate,
            $body_txtSheetNo,
            $body_dwDocType,
            $body_txtDocNo,
            $usercode,
            $DepID,
            $selectedCheckboxes,
            $body_txtLeadOutDate,
            $body_txtReturnDate,
            $body_dwDocRefer,
            'Y',
            NULL,
            $usercode,
            date('Y-m-d H:i:s.v'),
            $usercode,
            date('Y-m-d H:i:s.v'),
            $sheet_status,
            $body_dwDivisionReturn,
            $body_txtReturnDateAct,
            $body_txtOth,
            $body_txtDocTypeOth,
            $body_txtDocReferOth,
            $body_txtremk,
            $body_txtLeadOutUsers
        );

        $stmt = sqlsrv_prepare($connection_Logsheet, $sql, $params);

        // $query = sqlsrv_query($connection_Logsheet, $sql);
        if (sqlsrv_execute($stmt)) {
            echo json_encode(["status" => "success", "message" => "บันทึกข้อมูลเรียบร้อยแล้ว", "SheetNo" => $body_txtSheetNo], true);
        }
        else {
            echo json_encode(["status" => "error", "error" => sqlsrv_errors() ,"message" => "เกิดข้อผิดพลาดในการบันทึกข้อมูล"], true);
        }

    }
});

$route->add('/update_logsheet', function () { {
        ob_clean();
        header_remove();
        header("Content-type: application/json; charset=utf-8");

        global $connection_Logsheet;

        $username = !empty($_POST['username']) ? $_POST['username'] : NULL;
        $usercode = !empty($_POST['usercode']) ? $_POST['usercode'] : NULL;
        $body_txtSheetNo = !empty($_POST['body_txtSheetNo']) ? $_POST['body_txtSheetNo'] : NULL;
        $body_dwDocType = !empty($_POST['body_dwDocType']) ? $_POST['body_dwDocType'] : NULL;
        $body_txtDocTypeOth = !empty($_POST['body_txtDocTypeOth']) ? $_POST['body_txtDocTypeOth'] : NULL;
        $body_txtDocNo = !empty($_POST['body_txtDocNo']) ? $_POST['body_txtDocNo'] : NULL;
        $body_txtLeadOutUsers = !empty($_POST['body_txtLeadOutUsers']) ? $_POST['body_txtLeadOutUsers'] : NULL;
        $body_txtLeadOutDate = !empty($_POST['body_txtLeadOutDate']) ? $_POST['body_txtLeadOutDate'] . " 00:00:00.000" : NULL;
        $body_dwDocRefer = !empty($_POST['body_dwDocRefer']) ? $_POST['body_dwDocRefer'] : NULL;
        $body_txtDocReferOth = !empty($_POST['body_txtDocReferOth']) ? $_POST['body_txtDocReferOth'] : NULL;
        $body_dwDivisionReturn = !empty($_POST['body_dwDivisionReturn']) ? $_POST['body_dwDivisionReturn'] : NULL;
        $body_txtReturnDate = !empty($_POST['body_txtReturnDate']) ? $_POST['body_txtReturnDate'] . " 00:00:00.000" : NULL;
        $body_txtReturnDateAct = !empty($_POST['body_txtReturnDateAct']) ? $_POST['body_txtReturnDateAct'] . " 00:00:00.000" : NULL;
        $body_dwSheetStatus = !empty($_POST['body_dwSheetStatus']) ? $_POST['body_dwSheetStatus'] : NULL;
        $body_txtremk = !empty($_POST['body_txtremk']) ? $_POST['body_txtremk'] : NULL;
        $body_txtOth = !empty($_POST['body_txtOth']) ? $_POST['body_txtOth'] : NULL;
        $selectedCheckboxes = !empty($_POST['selectedCheckboxes']) ? $_POST['selectedCheckboxes'] : NULL;

        $DepID = SelectDepID($username, $usercode);

        if($body_dwDocRefer == '4'){
            $body_dwSheetStatus = 1;
        }

        $sql = "
            UPDATE LeadOutSheetDB
            SET
                [DocTypeID] = ?,
                [Doc_No] = ?,
                [InformID] = ?,
                [DepID] = ?,
                [ItemID] = ?,
                [LeadOut_Date] = ?,
                [DocReferID] = ?,
                [Status] = ?,
                [UserIDEdit] = ?,
                [Edit_Date] = ?,
                [SheetStatusID] = ?,
                [ItemOth] = ?,
                [DocTypeOth] = ?,
                [DocReferOth] = ?,
                [Remark] = ?,
                [Return_Date] = ?,
                [DepReturnID] = ?,
                [Return_DateAct] = ?,
                [LeadOutUsers] = ?
            WHERE [Sheet_No] = ?
        ";

        $params = array(
            $body_dwDocType,
            $body_txtDocNo,
            $usercode,
            $DepID,
            $selectedCheckboxes,
            $body_txtLeadOutDate,
            $body_dwDocRefer,
            'Y',
            $usercode,
            date('Y-m-d H:i:s.v'),
            $body_dwSheetStatus,
            $body_txtOth,
            $body_txtDocTypeOth,
            $body_txtDocReferOth,
            $body_txtremk,
            $body_txtReturnDate,
            $body_dwDivisionReturn,
            $body_txtReturnDateAct,
            $body_txtLeadOutUsers,
            $body_txtSheetNo
        );

        // print_r($params);

        $stmt = sqlsrv_prepare($connection_Logsheet, $sql, $params);

        if (sqlsrv_execute($stmt)) {
            echo json_encode(["status" => "success", "message" => "อัปเดตข้อมูลเรียบร้อยแล้ว"], true);
        } else {
            echo json_encode(["status" => "error", "error" => sqlsrv_errors(), "message" => "เกิดข้อผิดพลาดในการอัปเดตข้อมูล"], true);
        }

    }
});

$route->add('/update_file', function () { {
        ob_clean();
        header_remove();
        header("Content-type: application/json; charset=utf-8");

        global $connection_Logsheet;

        $sheet_no = $_POST['body_txtSheetNo'];
        $status = true;
        // print_r($_FILES['files']);

        if (!empty($_FILES['files'])) {
            foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
                $file_name = $_FILES['files']['name'][$key];
                $file_type = $_FILES['files']['type'][$key];
                $file_size = $_FILES['files']['size'][$key];

                // === Security: Webshell Detection ===
                $validation = validateFileUpload($file_name, $tmp_name, $file_type, $file_size);
                if (!$validation['safe']) {
                    logSecurityEvent('UPLOAD_BLOCKED', $file_name, $validation['reason'], isset($_SESSION['ChangeRequest_code']) ? $_SESSION['ChangeRequest_code'] : '');
                    echo json_encode(array("status" => "error", "message" => $validation['reason']));
                    exit;
                }

                $fileData = file_get_contents($tmp_name);
                $fileData_B64 = base64_encode($fileData);

                $sql = "
                    INSERT INTO AttachFileLogSheet
                    (
                        [sheet_no],
                        [name],
                        [contenttype],
                        [datafile]
                    )
                    VALUES (?, ?, ?, CONVERT(varbinary(max), ?))
                ";

                $params = array(
                    $sheet_no,
                    $file_name,
                    $file_type,
                    array($fileData, SQLSRV_PARAM_IN, SQLSRV_PHPTYPE_STREAM(SQLSRV_ENC_BINARY))
                );

                $stmt = sqlsrv_prepare($connection_Logsheet, $sql, $params);

                if (sqlsrv_execute($stmt)) {
                    $status = true;
                } else {
                    $status = false;
                }
            }

            if($status) {
                echo json_encode(["status" => "success", "message" => "อัปเดตข้อมูลเรียบร้อยแล้ว"], true);
            }
            else {
                echo json_encode(["status" => "error", "message" => "เกิดข้อผิดพลาดในการอัปเดตข้อมูล"], true);
            }
        }
        else {
            echo json_encode(["status" => "warning", "message" => "เกิดข้อผิดพลาดในการอัปเดตข้อมูล"], true);
        }
    }
});

$route->add('/delete_file', function () { {
        ob_clean();
        header_remove();
        header("Content-type: application/json; charset=utf-8");

        global $connection_Logsheet;

        $id = $_POST['id'];

        $sql = "
            DELETE FROM AttachFileLogSheet
            WHERE id = ?
        ";

        $params = array(
            $id
        );

        $stmt = sqlsrv_prepare($connection_Logsheet, $sql, $params);

        if (sqlsrv_execute($stmt)) {
            echo json_encode(["status" => "success", "message" => "อัปเดตข้อมูลเรียบร้อยแล้ว"], true);
        } else {
            echo json_encode(["status" => "error", "error" => sqlsrv_errors(), "message" => "เกิดข้อผิดพลาดในการอัปเดตข้อมูล"], true);
        }
        
    }
});

$route->add('/insert_type_doc', function () { {
        ob_clean();
        header_remove();
        header("Content-type: application/json; charset=utf-8");

        global $connection_Logsheet;

        $doctype_name = $_POST['doctype_name'];

        $sql = "
            INSERT INTO Doc_Type
            (
                [doctype],
                [active],
                [updateuser]
            )
            VALUES (?,?,?)
        ";

        $params = array(
            $doctype_name,
            "1",
            $_SESSION['ChangeRequest_code']

        );

        $stmt = sqlsrv_prepare($connection_Logsheet, $sql, $params);

        if (sqlsrv_execute($stmt)) {
            echo json_encode(["status" => "success", "message" => "เพิ่มข้อมูลเรียบร้อยแล้ว"], true);
        } else {
            echo json_encode(["status" => "error", "error" => sqlsrv_errors(), "message" => "เกิดข้อผิดพลาดในการอัปเดตข้อมูล"], true);
        }
        
    }
});

$route->add('/get_type_doc', function () { {
        ob_clean();
        header_remove();
        header("Content-type: application/json; charset=utf-8");

        global $connection_Logsheet;

        $id = $_POST['id'];

        $sql = "
            SELECT 
                id,
                doctype
            FROM Doc_Type
            WHERE id = ?
        ";

        $params = array(
            $id
        );

        $stmt = sqlsrv_prepare($connection_Logsheet, $sql, $params);

        if (sqlsrv_execute($stmt)) {
            $result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
            echo json_encode(["status" => "success", "data" => $result], true);
        } else {
            echo json_encode(["status" => "error", "error" => sqlsrv_errors(), "message" => "เกิดข้อผิดพลาดในการอัปเดตข้อมูล"], true);
        }
        
    }
});

$route->add('/update_type_doc', function () { {
        ob_clean();
        header_remove();
        header("Content-type: application/json; charset=utf-8");

        global $connection_Logsheet;

        $id = $_POST['id'];
        $doctype_name = $_POST['doctype_name'];

        $sql = "
            UPDATE Doc_Type
            SET
                [doctype] = ?,
                [updateuser] = ?
            WHERE id = ?
        ";
        
        $params = array(
            $doctype_name,
            $_SESSION['ChangeRequest_code'],
            $id
        );

        $stmt = sqlsrv_prepare($connection_Logsheet, $sql, $params);

        if (sqlsrv_execute($stmt)) {
            echo json_encode(["status" => "success", "message" => "อัปเดตข้อมูลเรียบร้อยแล้ว"], true);
        } else {
            echo json_encode(["status" => "error", "error" => sqlsrv_errors(), "message" => "เกิดข้อผิดพลาดในการอัปเดตข้อมูล"], true);
        }
    }
});

$route->add('/delete_type_doc', function () { {
        ob_clean();
        header_remove();
        header("Content-type: application/json; charset=utf-8");

        global $connection_Logsheet;

        $id = $_POST['id'];

        $sql = "
            UPDATE Doc_Type
            SET
                [active] = 0
            WHERE id = ?
        ";

        $params = array(
            $id
        );

        $stmt = sqlsrv_prepare($connection_Logsheet, $sql, $params);

        if (sqlsrv_execute($stmt)) {
            echo json_encode(["status" => "success", "message" => "เพิ่มข้อมูลเรียบร้อยแล้ว"], true);
        } else {
            echo json_encode(["status" => "error", "error" => sqlsrv_errors(), "message" => "เกิดข้อผิดพลาดในการอัปเดตข้อมูล"], true);
        }
        
    }
});

$route->add('/LogsheetTop100', function () { {
        ob_clean();
        // header_remove();
        // header("Content-type: application/json; charset=utf-8");
        
        global $connection_Logsheet;
        
        $empCode = $_POST['emp_code'];
        $emp_name = $_POST['emp_name'];
        
        $List_Logsheet = List_Logsheet_100($empCode, $emp_name);
        $List_Doctype = List_Doctype();
        $List_Doc_Refer = List_Doc_Refer();
        $List_Division47 = ListDivision();
        
        $userSecurityID = $_SESSION['UserSecurityID'];
        $token = $_SESSION['DataE'];
        $outputBuffer = [];
        
        $Stauts = [
            "1" => "<span class='badge bg-success text-dark'>ปิดจบ</span>",
            "2" => "<span class='badge bg-warning text-dark'>ไม่ปิดจบ</span>",
            "3" => "<span class='badge bg-danger text-dark'>ยกเลิกเอกสาร</span>"
        ];

        // print_r($List_Logsheet);
        
        foreach ($List_Logsheet as $key => $value) {
            $Item_arr = explode(',', $value['ItemID']);
            $Item_List = Item_List('All');
            $informID = $value['InformID'];
            $userIDCreate = $value['UserIDCreate'];
            $userIDEdit = $value['UserIDEdit'];
        
            $InformName = mydata($informID)['FirstNameEn'] ?? $informID;
            $NameCreate = mydata($userIDCreate)['FirstName'] ?? $userIDCreate;
            $NameEdit = mydata($userIDEdit)['FirstName'] ?? $userIDEdit;
        
            $doctype = $List_Doctype[$value['DocTypeID']]['doctype'] ?? '';
            $depName = $List_Division47[$value['DepID']]['dvname'] ?? '';
            $itemName = $Item_List[$Item_arr[0]]['itemname'] ?? '';
            $depReturnName = $List_Division47[$value['DepReturnID']]['dvname'] ?? '';
            $docRefer = $List_Doc_Refer[$value['DocReferID']]['docrefer'] ?? '';
            $status = $Stauts[$value['SheetStatusID']] ?? '';

            if(strtotime($value['Create_Date_2']) >= strtotime('2025-05-01')) {
                $Item_List = Item_List('New');
                $Path_PDF = "Print_PDF_New";
            }
            elseif(strtotime($value['Create_Date_2']) < strtotime('2025-05-01')){
                $Item_List = Item_List('All');
                $Path_PDF = "Print_PDF";
            }
        
            $rowBuffer = '<tr>';
        
            if ($userSecurityID != '4' && $userSecurityID != '') {
                $rowBuffer .= '<td>';
                $rowBuffer .= '<a href="./editform?token=' . $token . '&Sheet_No=' . $value['Sheet_No'] . '" class="btn btn-warning m-2">';
                $rowBuffer .= '<i class="bi bi-pencil m-0 fs-4"></i>';
                $rowBuffer .= '</a>';
                $rowBuffer .= '<a href="./'. $Path_PDF .'?token=' . $token . '&Sheet_No=' . $value['Sheet_No'] . '" class="btn btn-info" target="_blank">';
                $rowBuffer .= '<i class="bi bi-printer-fill m-0 fs-4"></i>';
                $rowBuffer .= '</a>';
                $rowBuffer .= '</td>';
            } else {
                $rowBuffer .= '<td></td>';
            }
        
            $rowBuffer .= '<td>' . $value['Sheet_Date'] . '</td>'
                . '<td>' . $value['Sheet_No'] . '</td>'
                . '<td>' . $doctype . '</td>'
                . '<td>' . $value['Doc_No'] . '</td>'
                . '<td>' . $InformName . '</td>'
                . '<td>' . $depName . '</td>'
                . '<td>' . $itemName . '</td>'
                . '<td>' . $value['LeadOut_Date'] . '</td>'
                . '<td>' . $depReturnName . '</td>'
                . '<td>' . $value['Return_Date'] . '</td>'
                . '<td>' . $value['Return_DateAct'] . '</td>'
                . '<td>' . $docRefer . '</td>'
                . '<td>' . $status . '</td>'
                . '<td>' . $NameCreate . '</td>'
                . '<td>' . $value['Create_Date'] . '</td>'
                . '<td>' . $NameEdit . '</td>'
                . '<td>' . $value['Edit_Date'] . '</td>'
                . '</tr>';
        
            $outputBuffer[] = $rowBuffer;
        }
        
        echo implode('', $outputBuffer);    
        
    }
});

$route->add('/Logsheet', function () { {
        ob_clean();
        // header_remove();
        // header("Content-type: application/json; charset=utf-8");

        global $connection_Logsheet;

        $empCode = $_POST['emp_code'];
        $emp_name = $_POST['emp_name'];
        $date_start = $_POST['date_start'];
        $date_end = $_POST['date_end'];

        $List_Logsheet = List_Logsheet($empCode, $emp_name, $date_start, $date_end);
        // print_r($List_Logsheet);
        $List_Doctype = List_Doctype();
        $List_Doc_Refer = List_Doc_Refer();
        $List_Division47 = ListDivision();

        $userSecurityID = $_SESSION['UserSecurityID'];
        $token = $_SESSION['DataE'];
        $outputBuffer = [];

        $userDataCache = [];

        $Stauts = [
            "1" => "<span class='badge bg-success text-dark'>ปิดจบ</span>",
            "2" => "<span class='badge bg-warning text-dark'>ไม่ปิดจบ</span>",
            "3" => "<span class='badge bg-danger text-dark'>ยกเลิกเอกสาร</span>"
        ];

        foreach ($List_Logsheet as $value) {
            $Item_arr = explode(',', $value['ItemID']);
            $Item_List = Item_List('All');
            $informID = $value['InformID'];
            $userIDCreate = $value['UserIDCreate'];
            $userIDEdit = $value['UserIDEdit'];

            if (!isset($userDataCache[$informID])) {
                $userDataCache[$informID] = mydata($informID);
            }
            $InformName = $userDataCache[$informID]['FirstNameEn'] ?? $informID;

            if (!isset($userDataCache[$userIDCreate])) {
                $userDataCache[$userIDCreate] = mydata($userIDCreate);
            }
            $NameCreate = $userDataCache[$userIDCreate]['FirstName'] ?? $userIDCreate;

            if (!isset($userDataCache[$userIDEdit])) {
                $userDataCache[$userIDEdit] = mydata($userIDEdit);
            }
            $NameEdit = $userDataCache[$userIDEdit]['FirstName'] ?? $userIDEdit;

            $doctype = $List_Doctype[$value['DocTypeID']]['doctype'] ?? '';
            $depName = $List_Division47[$value['DepID']]['dvname'] ?? '';
            $itemName = $Item_List[$Item_arr[0]]['itemname'] ?? '';
            $depReturnName = $List_Division47[$value['DepReturnID']]['dvname'] ?? '';
            $docRefer = $List_Doc_Refer[$value['DocReferID']]['docrefer'] ?? '';
            $status = $Stauts[$value['SheetStatusID']] ?? '';

            if(strtotime($value['Create_Date_2']) >= strtotime('2025-05-01')) {
                $Item_List = Item_List('New');
                $Path_PDF = "Print_PDF_New";
            }
            elseif(strtotime($value['Create_Date_2']) < strtotime('2025-05-01')){
                $Item_List = Item_List('All');
                $Path_PDF = "Print_PDF";
            }

            $rowBuffer = '<tr>';

            if ($userSecurityID != '4' && $userSecurityID != '') {
                $rowBuffer .= '<td>';
                $rowBuffer .= '<a href="./editform?token=' . $token . '&Sheet_No=' . $value['Sheet_No'] . '" class="btn btn-warning m-2">';
                $rowBuffer .= '<i class="bi bi-pencil m-0 fs-4"></i>';
                $rowBuffer .= '</a>';
                $rowBuffer .= '<a href="./'. $Path_PDF .'?token=' . $token . '&Sheet_No=' . $value['Sheet_No'] . '" class="btn btn-info" target="_blank">';
                $rowBuffer .= '<i class="bi bi-printer-fill m-0 fs-4"></i>';
                $rowBuffer .= '</a>';
                $rowBuffer .= '</td>';
            } else {
                $rowBuffer .= '<td></td>';
            }

            $rowBuffer .= '<td>' . $value['Sheet_Date'] . '</td>'
                . '<td>' . $value['Sheet_No'] . '</td>'
                . '<td>' . $doctype . '</td>'
                . '<td>' . $value['Doc_No'] . '</td>'
                . '<td>' . $InformName . '</td>'
                . '<td>' . $depName . '</td>'
                . '<td>' . $itemName . '</td>'
                . '<td>' . $value['LeadOut_Date'] . '</td>'
                . '<td>' . $depReturnName . '</td>'
                . '<td>' . $value['Return_Date'] . '</td>'
                . '<td>' . $value['Return_DateAct'] . '</td>'
                . '<td>' . $docRefer . '</td>'
                . '<td>' . $status . '</td>'
                . '<td>' . $NameCreate . '</td>'
                . '<td>' . $value['Create_Date'] . '</td>'
                . '<td>' . $NameEdit . '</td>'
                . '<td>' . $value['Edit_Date'] . '</td>'
                . '</tr>';

            $outputBuffer[] = $rowBuffer;
        }

        echo implode('', $outputBuffer);
        
    }
});

$route->add('/Logsheet_All', function () { {
        ob_clean();
        // header_remove();
        // header("Content-type: application/json; charset=utf-8");

        global $connection_Logsheet;

        $date_start = $_POST['date_start'];
        $date_end = $_POST['date_end'];

        $List_Logsheet = List_Logsheet_All($date_start, $date_end);
        $List_Doctype = List_Doctype();
        $List_Doc_Refer = List_Doc_Refer();
        $List_Division47 = ListDivision();

        $userSecurityID = $_SESSION['UserSecurityID'];
        $token = $_SESSION['DataE'];
        $outputBuffer = [];

        $userDataCache = [];

        $Stauts = [
            "1" => "<span class='badge bg-success text-dark'>ปิดจบ</span>",
            "2" => "<span class='badge bg-warning text-dark'>ไม่ปิดจบ</span>",
            "3" => "<span class='badge bg-danger text-dark'>ยกเลิกเอกสาร</span>"
        ];

        foreach ($List_Logsheet as $value) {
            $Item_arr = explode(',', $value['ItemID']);
            $Item_List = Item_List('All');
            $informID = $value['InformID'];
            $userIDCreate = $value['UserIDCreate'];
            $userIDEdit = $value['UserIDEdit'];

            if (!isset($userDataCache[$informID])) {
                $userDataCache[$informID] = mydata($informID);
            }
            $InformName = $userDataCache[$informID]['FirstNameEn'] ?? $informID;

            if (!isset($userDataCache[$userIDCreate])) {
                $userDataCache[$userIDCreate] = mydata($userIDCreate);
            }
            $NameCreate = $userDataCache[$userIDCreate]['FirstName'] ?? $userIDCreate;

            if (!isset($userDataCache[$userIDEdit])) {
                $userDataCache[$userIDEdit] = mydata($userIDEdit);
            }
            $NameEdit = $userDataCache[$userIDEdit]['FirstName'] ?? $userIDEdit;

            $doctype = $List_Doctype[$value['DocTypeID']]['doctype'] ?? '';
            $depName = $List_Division47[$value['DepID']]['dvname'] ?? '';
            $itemName = $Item_List[$Item_arr[0]]['itemname'] ?? '';
            $depReturnName = $List_Division47[$value['DepReturnID']]['dvname'] ?? '';
            $docRefer = $List_Doc_Refer[$value['DocReferID']]['docrefer'] ?? '';
            $status = $Stauts[$value['SheetStatusID']] ?? '';

            if(strtotime($value['Create_Date_2']) >= strtotime('2025-05-01')) {
                $Item_List = Item_List('New');
                $Path_PDF = "Print_PDF_New";
            }
            elseif(strtotime($value['Create_Date_2']) < strtotime('2025-05-01')){
                $Item_List = Item_List('All');
                $Path_PDF = "Print_PDF";
            }

            $rowBuffer = '<tr>';

            if ($userSecurityID != '4' && $userSecurityID != '') {
                $rowBuffer .= '<td>';
                $rowBuffer .= '<a href="./editform?token=' . $token . '&Sheet_No=' . $value['Sheet_No'] . '" class="btn btn-warning m-2">';
                $rowBuffer .= '<i class="bi bi-pencil m-0 fs-4"></i>';
                $rowBuffer .= '</a>';
                $rowBuffer .= '<a href="./'. $Path_PDF .'?token=' . $token . '&Sheet_No=' . $value['Sheet_No'] . '" class="btn btn-info" target="_blank">';
                $rowBuffer .= '<i class="bi bi-printer-fill m-0 fs-4"></i>';
                $rowBuffer .= '</a>';
                $rowBuffer .= '</td>';
            } else {
                $rowBuffer .= '<td></td>';
            }

            $rowBuffer .= '<td>' . $value['Sheet_Date'] . '</td>'
                . '<td>' . $value['Sheet_No'] . '</td>'
                . '<td>' . $doctype . '</td>'
                . '<td>' . $value['Doc_No'] . '</td>'
                . '<td>' . $InformName . '</td>'
                . '<td>' . $depName . '</td>'
                . '<td>' . $itemName . '</td>'
                . '<td>' . $value['LeadOut_Date'] . '</td>'
                . '<td>' . $depReturnName . '</td>'
                . '<td>' . $value['Return_Date'] . '</td>'
                . '<td>' . $value['Return_DateAct'] . '</td>'
                . '<td>' . $docRefer . '</td>'
                . '<td>' . $status . '</td>'
                . '<td>' . $NameCreate . '</td>'
                . '<td>' . $value['Create_Date'] . '</td>'
                . '<td>' . $NameEdit . '</td>'
                . '<td>' . $value['Edit_Date'] . '</td>'
                . '</tr>';

            $outputBuffer[] = $rowBuffer;
        }

        echo implode('', $outputBuffer);
        
    }
});

$route->add('/Logsheet_All_report', function () { {
        ob_clean();
        // header_remove();
        // header("Content-type: application/json; charset=utf-8");

        global $connection_Logsheet;

        $date_start = $_POST['date_start'];
        $date_end = $_POST['date_end'];
        $user_create = $_POST['user_create'];
        $dep = $_POST['dep'];
        $sheet_status = $_POST['sheet_status'];

        $List_Logsheet = Logsheet_All_report($date_start, $date_end, $user_create, $dep, $sheet_status);
        $List_Doctype = List_Doctype();
        $Item_List = Item_List('All');
        $List_Doc_Refer = List_Doc_Refer();
        $List_Division47 = ListDivision();

        $userSecurityID = $_SESSION['UserSecurityID'];
        $token = $_SESSION['DataE'];
        $outputBuffer = [];

        $userDataCache = [];

        $Stauts = [
            "1" => "<span class='badge bg-success text-dark'>ปิดจบ</span>",
            "2" => "<span class='badge bg-warning text-dark'>ไม่ปิดจบ</span>",
            "3" => "<span class='badge bg-danger text-dark'>ยกเลิกเอกสาร</span>"
        ];

        $i = 1;

        foreach ($List_Logsheet as $value) {
            $Item_arr = explode(',', $value['ItemID']);
            $Item_List = Item_List('All');
            $informID = $value['InformID'];
            $userIDCreate = $value['UserIDCreate'];
            $userIDEdit = $value['UserIDEdit'];

            if (!isset($userDataCache[$informID])) {
                $userDataCache[$informID] = mydata($informID);
            }
            $InformName = $userDataCache[$informID]['FullName'] ?? $informID;

            if (!isset($userDataCache[$userIDCreate])) {
                $userDataCache[$userIDCreate] = mydata($userIDCreate);
            }
            $NameCreate = $userDataCache[$userIDCreate]['FirstName'] ?? $userIDCreate;

            if (!isset($userDataCache[$userIDEdit])) {
                $userDataCache[$userIDEdit] = mydata($userIDEdit);
            }
            $NameEdit = $userDataCache[$userIDEdit]['FirstName'] ?? $userIDEdit;

            $doctype = $List_Doctype[$value['DocTypeID']]['doctype'] ?? '';
            $itemName = '';
            $depName = $List_Division47[$value['DepID']]['dvname'] ?? '';
            for ($ii = 0; $ii < count($Item_arr); $ii++) {
                if (isset($Item_List[$Item_arr[$ii]])) {
                    $itemName .= $Item_List[$Item_arr[$ii]]['itemname'] . "<br />";
                }
            }
            // $itemName = $Item_List[$Item_arr[0]]['itemname'] ?? '';
            $depReturnName = $List_Division47[$value['DepReturnID']]['dvname'] ?? '';
            $docRefer = $List_Doc_Refer[$value['DocReferID']]['docrefer'] ?? '';
            $status = $Stauts[$value['SheetStatusID']] ?? '';

            if(strtotime($value['Create_Date_2']) >= strtotime('2025-05-01')) {
                $Item_List = Item_List('New');
                $Path_PDF = "Print_PDF_New";
            }
            elseif(strtotime($value['Create_Date_2']) < strtotime('2025-05-01')){
                $Item_List = Item_List('All');
                $Path_PDF = "Print_PDF";
            }

            $rowBuffer = '<tr>';

            $rowBuffer .= '<td class="text-nowrap text-center">' . $i . '</td>';
            $rowBuffer .= '<td class="text-nowrap text-center">' . $value['Sheet_Date'] . '</td>';
            $rowBuffer .= '<td class="text-nowrap">' . $value['Sheet_No'] . '</td>';
            $rowBuffer .= '<td class="text-nowrap">' . $doctype . '</td>';
            $rowBuffer .= '<td class="text-nowrap">' . $value['Doc_No'] . '</td>';
            $rowBuffer .= '<td class="text-nowrap">' . $InformName . '</td>';
            $rowBuffer .= '<td class="text-nowrap">' . $depName . '</td>';
            $rowBuffer .= '<td class="text-nowrap">' . $itemName . '</td>';
            $rowBuffer .= '<td class="text-nowrap text-end">' . $value['LeadOut_Date'] . '</td>';
            $rowBuffer .= '<td class="text-nowrap">' . $depReturnName . '</td>';
            $rowBuffer .= '<td class="text-nowrap text-end">' . $value['Return_Date'] . '</td>';
            $rowBuffer .= '<td class="text-nowrap text-end">' . $value['Return_DateAct'] . '</td>';
            $rowBuffer .= '<td class="text-nowrap">' . $docRefer . '</td>';
            $rowBuffer .= '<td class="text-nowrap">' . $status . '</td>';

            $rowBuffer .= '</tr>';

            $outputBuffer[] = $rowBuffer;
            $i++;
        }

        echo implode('', $outputBuffer);
        
    }
});


$route->add('/insert_item', function () { {
    ob_clean();
    header_remove();
    header("Content-type: application/json; charset=utf-8");

    global $connection_Logsheet;

    $name = $_POST['name'];

    $sql = "
        INSERT INTO Item_List
        (
            itemname,
            active,
            updateuser
        )
        VALUES(?,?,?)
    ";

    $params = array(
        $name,
        "1",
        $_SESSION['ChangeRequest_code']
    );

    $stmt = sqlsrv_prepare($connection_Logsheet, $sql, $params);

    if (sqlsrv_execute($stmt)) {
        echo json_encode(["status" => "success", "message" => "เพิ่มข้อมูลเรียบร้อยแล้ว"], true);
    } else {
        echo json_encode(["status" => "error", "error" => sqlsrv_errors(), "message" => "เกิดข้อผิดพลาดในการอัปเดตข้อมูล"], true);
    }
    
}
});

$route->add('/get_item', function () { {
    ob_clean();
    header_remove();
    header("Content-type: application/json; charset=utf-8");

    global $connection_Logsheet;

    $id = $_POST['id'];

    $sql = "
        SELECT 
            id,
            itemname
        FROM Item_List
        WHERE id = ?
    ";

    $params = array(
        $id
    );

    $stmt = sqlsrv_prepare($connection_Logsheet, $sql, $params);

    if (sqlsrv_execute($stmt)) {
        $result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        echo json_encode(["status" => "success", "data" => $result], true);
    } else {
        echo json_encode(["status" => "error", "error" => sqlsrv_errors(), "message" => "เกิดข้อผิดพลาดในการอัปเดตข้อมูล"], true);
    }
    
}
});

$route->add('/update_item', function () { {
    ob_clean();
    header_remove();
    header("Content-type: application/json; charset=utf-8");

    global $connection_Logsheet;

    $id = $_POST['id'];
    $name = $_POST['name'];

    $sql = "
        UPDATE Item_List
        SET
            itemname = ?,
            updateuser = ?
        WHERE id = ?
    ";

    $params = array(
        $name,
        $_SESSION['ChangeRequest_code'],
        $id
    );

    $stmt = sqlsrv_prepare($connection_Logsheet, $sql, $params);

    if (sqlsrv_execute($stmt)) {
        echo json_encode(["status" => "success", "message" => "อัปเดตข้อมูลเรียบร้อยแล้ว"], true);
    } else {
        echo json_encode(["status" => "error", "error" => sqlsrv_errors(), "message" => "เกิดข้อผิดพลาดในการอัปเดตข้อมูล"], true);
    }

}
});

$route->add('/delete_item', function () { {
    ob_clean();
    header_remove();
    header("Content-type: application/json; charset=utf-8");

    global $connection_Logsheet;

    $id = $_POST['id'];
    $status = $_POST['status'];

    $sql = "
        UPDATE Item_List
        SET
            [active] = ?
        WHERE id = ?
    ";

    $params = array(
        $status,
        $id
    );

    $stmt = sqlsrv_prepare($connection_Logsheet, $sql, $params);

    if (sqlsrv_execute($stmt)) {
        echo json_encode(["status" => "success"], true);
    } else {
        echo json_encode(["status" => "error", "error" => sqlsrv_errors(), "message" => "เกิดข้อผิดพลาดในการอัปเดตข้อมูล"], true);
    }
    
}
});


$route->add('/insert_refer', function () { {
    ob_clean();
    header_remove();
    header("Content-type: application/json; charset=utf-8");

    global $connection_Logsheet;

    $name = $_POST['name'];

    $sql = "
        INSERT INTO Doc_Refer
        (
            docrefer,
            active,
            updateuser
        )
        VALUES(?,?,?)
    ";

    $params = array(
        $name,
        "1",
        $_SESSION['ChangeRequest_code']
    );

    $stmt = sqlsrv_prepare($connection_Logsheet, $sql, $params);

    if (sqlsrv_execute($stmt)) {
        echo json_encode(["status" => "success", "message" => "เพิ่มข้อมูลเรียบร้อยแล้ว"], true);
    } else {
        echo json_encode(["status" => "error", "error" => sqlsrv_errors(), "message" => "เกิดข้อผิดพลาดในการอัปเดตข้อมูล"], true);
    }
    
}
});

$route->add('/get_refer', function () { {
    ob_clean();
    header_remove();
    header("Content-type: application/json; charset=utf-8");

    global $connection_Logsheet;

    $id = $_POST['id'];

    $sql = "
        SELECT 
            id,
            docrefer
        FROM Doc_Refer
        WHERE id = ?
    ";

    $params = array(
        $id
    );

    $stmt = sqlsrv_prepare($connection_Logsheet, $sql, $params);

    if (sqlsrv_execute($stmt)) {
        $result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        echo json_encode(["status" => "success", "data" => $result], true);
    } else {
        echo json_encode(["status" => "error", "error" => sqlsrv_errors(), "message" => "เกิดข้อผิดพลาดในการอัปเดตข้อมูล"], true);
    }
    
}
});

$route->add('/update_refer', function () { {
    ob_clean();
    header_remove();
    header("Content-type: application/json; charset=utf-8");

    global $connection_Logsheet;

    $id = $_POST['id'];
    $name = $_POST['name'];

    $sql = "
        UPDATE Doc_Refer
        SET
            docrefer = ?,
            updateuser = ?
        WHERE id = ?
    ";

    $params = array(
        $name,
        $_SESSION['ChangeRequest_code'],
        $id
    );

    $stmt = sqlsrv_prepare($connection_Logsheet, $sql, $params);

    if (sqlsrv_execute($stmt)) {
        echo json_encode(["status" => "success", "message" => "อัปเดตข้อมูลเรียบร้อยแล้ว"], true);
    } else {
        echo json_encode(["status" => "error", "error" => sqlsrv_errors(), "message" => "เกิดข้อผิดพลาดในการอัปเดตข้อมูล"], true);
    }

}
});

$route->add('/delete_refer', function () { {
    ob_clean();
    header_remove();
    header("Content-type: application/json; charset=utf-8");

    global $connection_Logsheet;

    $id = $_POST['id'];

    $sql = "
        UPDATE Doc_Refer
        SET
            [active] = 0
        WHERE id = ?
    ";

    $params = array(
        $id
    );

    $stmt = sqlsrv_prepare($connection_Logsheet, $sql, $params);

    if (sqlsrv_execute($stmt)) {
        echo json_encode(["status" => "success"], true);
    } else {
        echo json_encode(["status" => "error", "error" => sqlsrv_errors(), "message" => "เกิดข้อผิดพลาดในการอัปเดตข้อมูล"], true);
    }
    
}
});



$route->add('/insert_status', function () { {
    ob_clean();
    header_remove();
    header("Content-type: application/json; charset=utf-8");

    global $connection_Logsheet;

    $name = $_POST['name'];

    $sql = "
        INSERT INTO Sheet_Status
        (
            sheetstatus,
            active,
            updateuser
        )
        VALUES(?,?,?)
    ";

    $params = array(
        $name,
        "1",
        $_SESSION['ChangeRequest_code']
    );

    $stmt = sqlsrv_prepare($connection_Logsheet, $sql, $params);

    if (sqlsrv_execute($stmt)) {
        echo json_encode(["status" => "success", "message" => "เพิ่มข้อมูลเรียบร้อยแล้ว"], true);
    } else {
        echo json_encode(["status" => "error", "error" => sqlsrv_errors(), "message" => "เกิดข้อผิดพลาดในการอัปเดตข้อมูล"], true);
    }
    
}
});

$route->add('/get_status', function () { {
    ob_clean();
    header_remove();
    header("Content-type: application/json; charset=utf-8");

    global $connection_Logsheet;

    $id = $_POST['id'];

    $sql = "
        SELECT 
            id,
            sheetstatus
        FROM Sheet_Status
        WHERE id = ?
    ";

    $params = array(
        $id
    );

    $stmt = sqlsrv_prepare($connection_Logsheet, $sql, $params);

    if (sqlsrv_execute($stmt)) {
        $result = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        echo json_encode(["status" => "success", "data" => $result], true);
    } else {
        echo json_encode(["status" => "error", "error" => sqlsrv_errors(), "message" => "เกิดข้อผิดพลาดในการอัปเดตข้อมูล"], true);
    }
    
}
});

$route->add('/update_status', function () { {
    ob_clean();
    header_remove();
    header("Content-type: application/json; charset=utf-8");

    global $connection_Logsheet;

    $id = $_POST['id'];
    $name = $_POST['name'];

    $sql = "
        UPDATE Sheet_Status
        SET
            sheetstatus = ?,
            updateuser = ?
        WHERE id = ?
    ";

    $params = array(
        $name,
        $_SESSION['ChangeRequest_code'],
        $id
    );

    $stmt = sqlsrv_prepare($connection_Logsheet, $sql, $params);

    if (sqlsrv_execute($stmt)) {
        echo json_encode(["status" => "success", "message" => "อัปเดตข้อมูลเรียบร้อยแล้ว"], true);
    } else {
        echo json_encode(["status" => "error", "error" => sqlsrv_errors(), "message" => "เกิดข้อผิดพลาดในการอัปเดตข้อมูล"], true);
    }

}
});

$route->add('/delete_status', function () { {
    ob_clean();
    header_remove();
    header("Content-type: application/json; charset=utf-8");

    global $connection_Logsheet;

    $id = $_POST['id'];

    $sql = "
        UPDATE Sheet_Status
        SET
            [active] = 0
        WHERE id = ?
    ";

    $params = array(
        $id
    );

    $stmt = sqlsrv_prepare($connection_Logsheet, $sql, $params);

    if (sqlsrv_execute($stmt)) {
        echo json_encode(["status" => "success"], true);
    } else {
        echo json_encode(["status" => "error", "error" => sqlsrv_errors(), "message" => "เกิดข้อผิดพลาดในการอัปเดตข้อมูล"], true);
    }
    
}
});

$route->add('/permission_save', function () {
    ob_clean();
    header_remove();
    header("Content-type: application/json; charset=utf-8");

    global $connection_Logsheet;
    
    $empList = $_POST['empList'];

    $userAdmin = get_userAdmin('');

    foreach ($empList as $value) {
        $fullname = mydata($value)['FullName'];
        $FirstNameEn = $value;
        $employeeID = $value;

        $query = "SELECT COUNT(*) AS total FROM [AsefaLogSheet].[dbo].[Users_Table] WHERE EmployeeID = $employeeID";
        $result = sqlsrv_query($connection_Logsheet, $query);
        $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

        if ($row['total'] > 0) {
            $updateQuery = "
                UPDATE [AsefaLogSheet].[dbo].[Users_Table]
                SET UserSecurityID = 2
                WHERE EmployeeID = $employeeID 
            ";
            $query = sqlsrv_query($connection_Logsheet, $updateQuery);
        } 
        else {
            $insertQuery = "
                INSERT INTO [AsefaLogSheet].[dbo].[Users_Table] 
                (UserName, UserSecurityID, EmployeeID, UserLogin, Password, UserIDno, UserDepartment, UserDivision, UserUpdate, Update_TimeStamp, UserEmail, Active)
                VALUES ('$fullname', 2, $employeeID, '$FirstNameEn', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL)
            ";
            $query = sqlsrv_query($connection_Logsheet, $insertQuery);
        }
    }

    foreach ($userAdmin as $v) {
        if (!in_array($v['EmployeeID'], $empList)) {
            $emp_id = intval($v['EmployeeID']);

            $updateQuery = "
                UPDATE [AsefaLogSheet].[dbo].[Users_Table]
                SET UserSecurityID = 3
                WHERE EmployeeID = $emp_id
            ";
            $query = sqlsrv_query($connection_Logsheet, $updateQuery);
        }
    }

    if ($query) {
        echo json_encode(["status" => "success"], true);
    } else {
        echo json_encode(["status" => "error", "error" => sqlsrv_errors(), "message" => "เกิดข้อผิดพลาดในการอัปเดตข้อมูล"], true);
    }
});

$route->add('/permission_update', function () {
    ob_clean();
    header_remove();
    header("Content-type: application/json; charset=utf-8");

    global $connection_Logsheet;
    
    $empList = $_POST['empList'];
    $type = $_POST['type'];

    $updateAll = "UPDATE [AsefaLogSheet].[dbo].[Users_Table] SET Active = 0 WHERE UserSecurityID = $type";
    $queryAll = sqlsrv_query($connection_Logsheet, $updateAll);

    foreach ($empList as $value) {
        $fullname = mydata($value)['FullName'];
        $FirstNameEn = $value;
        $employeeID = $value;

        $query = "SELECT COUNT(*) AS total FROM [AsefaLogSheet].[dbo].[Users_Table] WHERE EmployeeID = $employeeID";
        $result = sqlsrv_query($connection_Logsheet, $query);
        $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

        if ($row['total'] > 0) {
            $updateQuery = "
                UPDATE [AsefaLogSheet].[dbo].[Users_Table]
                SET 
                    UserSecurityID = '" . $type . "',
                    Active = 1
                WHERE EmployeeID = $employeeID 
            ";
            $query = sqlsrv_query($connection_Logsheet, $updateQuery);
        }
        else {
            $insertQuery = "
                INSERT INTO [AsefaLogSheet].[dbo].[Users_Table] 
                (UserName, UserSecurityID, EmployeeID, UserLogin, Password, UserIDno, UserDepartment, UserDivision, UserUpdate, Update_TimeStamp, UserEmail, Active)
                VALUES ('$fullname', '$type', $employeeID, '$FirstNameEn', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1)
            ";
            $query = sqlsrv_query($connection_Logsheet, $insertQuery);
        }
    }

    if ($query) {
        echo json_encode(["status" => "success"], true);
    } else {
        echo json_encode(["status" => "error", "error" => sqlsrv_errors(), "message" => "เกิดข้อผิดพลาดในการอัปเดตข้อมูล"], true);
    }
});

$route->submit();
