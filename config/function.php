<?php
function get_idref($username)
{
    global $konnext_lqsym;
    $id = null;
    $sql            =    "
							SELECT		site_id_10  as 'id_ref'
							FROM		work_progress_010
							WHERE		site_f_365 = '" . $username . "'
                            AND site_f_3005 = '600'
						";
    $query        =    mysqli_query($konnext_lqsym, $sql) or die(mysqli_error($konnext_lqsym));
    $num = mysqli_num_rows($query);
    if ($num > 0) {
        while ($row    =    mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            $id = $row['id_ref'];
        }
    }
    return $id;
}

function mydata($idref)
{
    global $konnext_lqsym;
    $data = null;
    $sql            =    "
							SELECT		site_id_10  as 'id_ref',
                                        site_f_5824 as 'ApproveEmployeeText0',
                                        site_f_2363 as 'TokenMD5',
                                        site_f_366 as 'FullName',
                                        site_f_2327 as 'FirstName',
                                        site_f_367 as 'FullNameEn',
                                        site_f_2328 as 'FirstNameEn',
                                        site_f_365 as 'Code'
							FROM		work_progress_010
							WHERE		(site_id_10 = '" . $idref . "' OR site_f_365 = '" . $idref . "')
                            AND site_f_3005 = '600'
						";
    $query        =    mysqli_query($konnext_lqsym, $sql) or die(mysqli_error($konnext_lqsym));
    $num = mysqli_num_rows($query);
    if ($num > 0) {
        while ($row    =    mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            $data = $row;
        }
    }
    return $data;
}

function emplist()
{
	global $konnext_lqsym;
	$data = array();

	$sql = " 
		SELECT
				site_id_10  as 'id_ref',
				site_f_366 as 'FullName',
				site_f_367 as 'FullNameEn',
				site_f_365 as 'Code'
		FROM 	work_progress_010
		WHERE	site_f_3005 = '600'
		AND (
			site_f_398 = '0000-00-00' OR site_f_398 > CURRENT_DATE() 
		)
	";

	$query        =    mysqli_query($konnext_lqsym, $sql) or die(mysqli_error($konnext_lqsym));
	$num = mysqli_num_rows($query);
	if ($num > 0) {
		while ($row    =    mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			$data[$row['Code']] = $row;
		}
	}
	return $data;
}

function ListDivision()
{
    global $konnext_lqsym;
    $data = array();
    $sql            =    "
							SELECT
                                        site_f_1144 as 'id',
                                        site_f_1145 as 'dvname'
							FROM		work_progress_015
							WHERE		site_f_3560 = '2' OR site_f_3560 = '3'
                            AND site_f_3010 = '600'
                            AND site_f_2994 = '0'
							AND site_f_1145 <> '-'
						";
    $query        =    mysqli_query($konnext_lqsym, $sql) or die(mysqli_error($konnext_lqsym));
    $num = mysqli_num_rows($query);
    if ($num > 0) {
        while ($row    =    mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            $data[$row['id']] = $row;
        }
    }
    return $data;
}

function List_Doctype()
{
	global $connection_Logsheet;

	$sql = " 
		SELECT 
			[id]
			,[doctype]
			,[active]
			,[updateuser]
      		,[updatedate]
		FROM [AsefaLogSheet].[dbo].[Doc_Type]
		WHERE [active] = 1
	";

	$query = sqlsrv_query($connection_Logsheet, $sql);
	while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
		$data[$row['id']] = $row;
	}

	return $data;
}

function List_Doc_Refer()
{
	global $connection_Logsheet;

	$sql = " 
		SELECT 
			[id]
			,[docrefer]
			,[updateuser]
      		,[updatedate]
		FROM [AsefaLogSheet].[dbo].[Doc_Refer]
		WHERE [active] = 1
	";

	$query = sqlsrv_query($connection_Logsheet, $sql);
	while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
		$data[$row['id']] = $row;
	}

	return $data;
}

function List_Status()
{
	global $connection_Logsheet;

	$sql = "
		SELECT [id]
			,[sheetstatus]
			,[updateuser]
	  		,[updatedate]
		FROM [AsefaLogSheet].[dbo].[Sheet_Status]
		WHERE [active] = 1
	";

	$query = sqlsrv_query($connection_Logsheet, $sql);
	while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
		$data[$row['id']] = $row;
	}

	return $data;
}

function Item_List($active)
{
	global $connection_Logsheet;

	$sql = " 
		SELECT 
			[id]
			,[itemname]
			,[updateuser]
			,[updatedate]
			,[active]
		FROM [AsefaLogSheet].[dbo].[Item_List]
	";

	if($active == 'New'){
		$sql .= " WHERE [active] = 1 ";
	}
	elseif($active == 'Old'){
		$sql .= " WHERE [active] = 0 ";
	}
	elseif($active == 'All'){
		$sql .= " WHERE [active] = 1 OR [active] = 0 ";
	}

	$sql .= "ORDER BY 
      		CAST(SUBSTRING(itemname, 1, PATINDEX('%[^0-9]%', itemname + ' ') - 1) AS INT)
		";

	$query = sqlsrv_query($connection_Logsheet, $sql);
	while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
		$data[$row['id']] = $row;
	}

	return $data;
}

function List_Division47()
{
	global $connection_Logsheet;

	$sql = " 
		SELECT 
			[id]
			,[dvname]
			,[active]
		FROM [AsefaLogSheet].[dbo].[Division]
		WHERE [active] = 1
	";

	$query = sqlsrv_query($connection_Logsheet, $sql);
	while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
		$data[$row['id']] = $row;
	}

	return $data;
}

function SelectDepID($username, $usercode)
{
	global $connection_Logsheet;

	$sql = " 
		SELECT [UserLogin]
			,[UserDivision]
		FROM [AsefaLogSheet].[dbo].[Users_Table]
		WHERE [active] = 1 AND (([UserLogin] = '$username' OR [UserLogin] = '$usercode') AND [EmployeeID] = '$usercode')
	";

	$query = sqlsrv_query($connection_Logsheet, $sql);
	$row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

	if($row['UserDivision'] == '') {
		$DiviID = get_mydataAPI($usercode)[0]->DivisionHeadID2;
	}
	else {
		$DiviID = $row['UserDivision'];
	}

	return $DiviID;
}

function get_file(){
	global $connection_Logsheet;

	$sql = " 
		SELECT 
			[id]
			,[sheet_no]
			,[name]
			,[contenttype]
			,[datafile]
		FROM [AsefaLogSheet].[dbo].[AttachFileLogSheet]
		where sheet_no = 'HM-67-04854'
	";

	$query = sqlsrv_query($connection_Logsheet, $sql);
	$row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);
	$data = $row;

	return $data;
}

function List_File($Sheet_No){
	global $connection_Logsheet;

	$sql = " 
		SELECT 
			[id]
			,[sheet_no]
			,[name]
			,[contenttype]
			,[datafile]
		FROM [AsefaLogSheet].[dbo].[AttachFileLogSheet]
		where sheet_no = '$Sheet_No'
	";

	$query = sqlsrv_query($connection_Logsheet, $sql);
	while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
		$data[$row['id']] = $row;
	}

	return $data;
}

function getNextSheetNo() {
    global $connection_Logsheet;

    $year = substr(date('Y'), -2) + 43;
    $sql = "SELECT TOP 1 Sheet_No FROM LeadOutSheetDB WHERE Sheet_No LIKE 'HM-$year-%' ORDER BY Sheet_No DESC";
    $stmt = sqlsrv_query($connection_Logsheet, $sql);
    
    if ($stmt && sqlsrv_has_rows($stmt)) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $latestSheetNo = $row['Sheet_No'];
        $existingYearPart = substr($latestSheetNo, 3, 2);

        if ($existingYearPart == $year) {
            $numberPart = (int) substr($latestSheetNo, 6);
            $newNumberPart = str_pad($numberPart + 1, 5, '0', STR_PAD_LEFT);
        } else {
            $newNumberPart = '00001';
        }
        
        $nextSheetNo = "HM-$year-" . $newNumberPart;
    } else {
        $nextSheetNo = "HM-$year-00001";
    }
    
    return $nextSheetNo;
}

function get_mydataAPI($code){
	$get_emp_detail = "https://innovation.asefa.co.th/applications/ds/emp_list_code";
	$chs = curl_init();
	curl_setopt($chs, CURLOPT_URL, $get_emp_detail);
	curl_setopt($chs, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($chs, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($chs, CURLOPT_SSL_VERIFYPEER, false);

	curl_setopt($chs, CURLOPT_POST, 1);
	curl_setopt($chs, CURLOPT_POSTFIELDS, ["emp_code" => $code]);
	$emp = curl_exec($chs);
	curl_close($chs);

	$empdata   =   json_decode($emp);

	return $empdata;
}

function List_Logsheet($emp_code, $InformID, $date_start, $date_end){
    global $connection_Logsheet;

	$year = substr(date('Y'), -2) + 43;

    $sql = " 
        SELECT
			FORMAT([Sheet_Date], 'dd/MM/yyyy') AS [Sheet_Date],
		 	[Sheet_No],
			[DocTypeID],
			[Doc_No],
			[InformID], 
            [DepID], 
			[ItemID], 
			FORMAT([LeadOut_Date], 'dd/MM/yyyy') AS [LeadOut_Date], 
			FORMAT([Return_Date], 'dd/MM/yyyy') AS [Return_Date], 
			[DocReferID], 
			[UserIDCreate], 
			FORMAT([Create_Date], 'dd/MM/yyyy') AS [Create_Date], 
			FORMAT([Create_Date], 'yyyy-MM-dd') AS [Create_Date_2], 
            [UserIDEdit], 
			FORMAT([Edit_Date], 'dd/MM/yyyy') AS [Edit_Date], 
			[SheetStatusID], 
			[DepReturnID], 
            FORMAT([Return_DateAct], 'dd/MM/yyyy') AS [Return_DateAct], 
			[ItemOth], 
			[DocTypeOth], 
			[DocReferOth], 
			[Remark], 
            [LeadOutUsers]
        FROM [AsefaLogSheet].[dbo].[LeadOutSheetDB]
    ";

	if($date_start != '' && $date_end != ''){
		$sql .= "WHERE (([LeadOutSheetDB].[Sheet_Date] >= '$date_end 00:00:00.000' AND [LeadOutSheetDB].[Sheet_Date] <= '$date_start 23:59:59.999') 
				 OR ([LeadOutSheetDB].[Sheet_Date] <= '$date_end 23:59:59.999' AND [LeadOutSheetDB].[Sheet_Date] >= '$date_start 00:00:00.000'))";
		$sql .= "AND (InformID = '$emp_code')";
	}
	else{
		$sql .= "WHERE InformID = '$emp_code'";
	}

	$sql .= "ORDER BY [LeadOutSheetDB].[Create_Date] DESC";
    
    $query = sqlsrv_query($connection_Logsheet, $sql);
    $data = [];
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $data[] = $row;
    }

    // return $sql;
    return $data;
}

function List_Logsheet_All($date_start, $date_end){
    global $connection_Logsheet;

	$year = substr(date('Y'), -2) + 43;

    $sql = " 
        SELECT
			FORMAT([Sheet_Date], 'dd/MM/yyyy') AS [Sheet_Date],
		 	[Sheet_No],
			[DocTypeID],
			[Doc_No],
			[InformID], 
            [DepID], 
			[ItemID], 
			FORMAT([LeadOut_Date], 'dd/MM/yyyy') AS [LeadOut_Date], 
			FORMAT([Return_Date], 'dd/MM/yyyy') AS [Return_Date], 
			[DocReferID], 
			[UserIDCreate], 
			FORMAT([Create_Date], 'dd/MM/yyyy') AS [Create_Date], 
			FORMAT([Create_Date], 'yyyy-MM-dd') AS [Create_Date_2], 
            [UserIDEdit], 
			FORMAT([Edit_Date], 'dd/MM/yyyy') AS [Edit_Date], 
			[SheetStatusID], 
			[DepReturnID], 
            FORMAT([Return_DateAct], 'dd/MM/yyyy') AS [Return_DateAct], 
			[ItemOth], 
			[DocTypeOth], 
			[DocReferOth], 
			[Remark], 
            [LeadOutUsers]
        FROM [AsefaLogSheet].[dbo].[LeadOutSheetDB]
    ";

	if($date_start != '' && $date_end != ''){
		$sql .= "WHERE [LeadOutSheetDB].[Sheet_Date] >= '$date_start 00:00:00.000' AND [LeadOutSheetDB].[Sheet_Date] <= '$date_end 23:59:59.999'
		         OR [LeadOutSheetDB].[Sheet_Date] <= '$date_start 23:59:59.999' AND [LeadOutSheetDB].[Sheet_Date] >= '$date_end 00:00:00.000'";
	}

	$sql .= "ORDER BY [LeadOutSheetDB].[Create_Date] DESC";

	// if($date_start != '' && $date_end != ''){
	// 	$sql .= "OFFSET 0 ROWS FETCH NEXT 100 ROWS ONLY";
	// }
    
    $query = sqlsrv_query($connection_Logsheet, $sql);
    $data = [];
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $data[] = $row;
    }

    return $data;
}

function Logsheet_All_report($date_start, $date_end, $emp_code=null, $DepID=null, $Sheet_status=null){
    global $connection_Logsheet;

	$year = substr(date('Y'), -2) + 43;

    $sql = " 
        SELECT
			FORMAT([Sheet_Date], 'dd/MM/yyyy') AS [Sheet_Date],
		 	[Sheet_No],
			[DocTypeID],
			[Doc_No],
			[InformID], 
            [DepID], 
			[ItemID], 
			FORMAT([LeadOut_Date], 'dd/MM/yyyy') AS [LeadOut_Date], 
			FORMAT([Return_Date], 'dd/MM/yyyy') AS [Return_Date], 
			[DocReferID], 
			[UserIDCreate], 
			FORMAT([Create_Date], 'dd/MM/yyyy') AS [Create_Date], 
			FORMAT([Create_Date], 'yyyy-MM-dd') AS [Create_Date_2], 
            [UserIDEdit], 
			FORMAT([Edit_Date], 'dd/MM/yyyy') AS [Edit_Date], 
			[SheetStatusID], 
			[DepReturnID], 
            FORMAT([Return_DateAct], 'dd/MM/yyyy') AS [Return_DateAct], 
			[ItemOth], 
			[DocTypeOth], 
			[DocReferOth], 
			[Remark], 
            [LeadOutUsers]
        FROM [AsefaLogSheet].[dbo].[LeadOutSheetDB]
    ";

	if($date_start != '' && $date_end != ''){
		$sql .= "WHERE ([LeadOutSheetDB].[Sheet_Date] >= '$date_start 00:00:00.000' AND [LeadOutSheetDB].[Sheet_Date] <= '$date_end 23:59:59.999'
		         OR [LeadOutSheetDB].[Sheet_Date] <= '$date_start 23:59:59.999' AND [LeadOutSheetDB].[Sheet_Date] >= '$date_end 00:00:00.000')";
	}

	if($emp_code != '' || $emp_code != null){
		$sql .= " AND [LeadOutSheetDB].[InformID] = '$emp_code'";
	}

	if($DepID != '' || $emp_code != $DepID){
		$sql .= " AND [LeadOutSheetDB].[DepID] = '$DepID'";
	}

	if($Sheet_status != '' || $emp_code != $Sheet_status){
		$sql .= " AND [LeadOutSheetDB].[SheetStatusID] = '$Sheet_status'";
	}

	$sql .= " ORDER BY [LeadOutSheetDB].[Create_Date] DESC";

	// if($date_start != '' && $date_end != ''){
	// 	$sql .= "OFFSET 0 ROWS FETCH NEXT 100 ROWS ONLY";
	// }
    
    $query = sqlsrv_query($connection_Logsheet, $sql);
    $data = [];
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $data[] = $row;
    }

    return $data;
}

function List_Logsheet_100($emp_code, $InformID){
	global $connection_Logsheet;

    $sql = " 
        SELECT TOP 100
			FORMAT([Sheet_Date], 'dd/MM/yyyy') AS [Sheet_Date],
		 	[Sheet_No],
			[DocTypeID],
			[Doc_No],
			[InformID], 
            [DepID], 
			[ItemID], 
			FORMAT([LeadOut_Date], 'dd/MM/yyyy') AS [LeadOut_Date], 
			FORMAT([Return_Date], 'dd/MM/yyyy') AS [Return_Date], 
			[DocReferID], 
			[UserIDCreate], 
			FORMAT([Create_Date], 'dd/MM/yyyy') AS [Create_Date], 
			FORMAT([Create_Date], 'yyyy-MM-dd') AS [Create_Date_2], 
            [UserIDEdit], 
			FORMAT([Edit_Date], 'dd/MM/yyyy') AS [Edit_Date], 
			[SheetStatusID], 
			[DepReturnID], 
            FORMAT([Return_DateAct], 'dd/MM/yyyy') AS [Return_DateAct], 
			[ItemOth], 
			[DocTypeOth], 
			[DocReferOth], 
			[Remark], 
            [LeadOutUsers]
        FROM [AsefaLogSheet].[dbo].[LeadOutSheetDB]
    ";

	if($InformID != '' && $emp_code != ''){
		$sql .= "WHERE InformID = '$emp_code'";
	}

	$sql .= "ORDER BY [LeadOutSheetDB].[Create_Date] DESC";

    
    $query = sqlsrv_query($connection_Logsheet, $sql);
    $data = [];
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $data[] = $row;
    }

    return $data;
}


function Select_Logsheet($Logsheet_no){
	global $connection_Logsheet;

	$sql = " 
		SELECT 
			[Sheet_Date]
			,[Sheet_No]
			,[DocTypeID]
			,[Doc_No]
			,[InformID]
			,[DepID]
			,[ItemID]
			,[LeadOut_Date]
			,[Return_Date]
			,[DocReferID]
			,[Status]
			,[LastUpdate_TimeStamp]
			,[UserIDCreate]
			,[Create_Date]
			,[UserIDEdit]
			,[Edit_Date]
			,[SheetStatusID]
			,[DepReturnID]
			,[Return_DateAct]
			,[ItemOth]
			,[DocTypeOth]
			,[DocReferOth]
			,[Remark]
			,[LeadOutUsers]
		FROM [AsefaLogSheet].[dbo].[LeadOutSheetDB]
		WHERE Sheet_No = '$Logsheet_no'
	";
	$query = sqlsrv_query($connection_Logsheet, $sql);
	$row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

	return $row;
}

function getUserSecurityID($FullName, $Emp_Code){
	global $connection_Logsheet;

	$sql = " 
		SELECT 
			[UserLogin]
			,[Password]
			,[UserName]
			,[UserSecurityID]
		FROM [AsefaLogSheet].[dbo].[Users_Table]
		WHERE [UserName] = '$FullName' OR [EmployeeID] = '$Emp_Code'
		AND [Active] = 1
	";
	$query = sqlsrv_query($connection_Logsheet, $sql);
	$row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC);

	return $row['UserSecurityID'] ? $row['UserSecurityID'] : null;
}

function get_userAdmin($admin_status){
	global $connection_Logsheet;
	$data = array();

	$sql = " 
		SELECT 
			[UserLogin]
			,[EmployeeID]
			,[UserName]
			,[UserSecurityID]
		FROM [AsefaLogSheet].[dbo].[Users_Table]
		WHERE [UserSecurityID] = '". $admin_status ."'
		AND [Active] = 1
	";
	$query = sqlsrv_query($connection_Logsheet, $sql);
	while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)){
		$data[] = $row;
	}

	return $data;
}

function decryptIt($q)
{
	$cryptKey  = 'Iloveyouallpann';
	$qDecoded = rtrim(openssl_decrypt(base64_decode($q), "AES-256-CBC", md5($cryptKey), 0, substr(md5(md5($cryptKey)), 0, 16)), "\0");
	//write_file("temp.txt","=".date("H:i:s")."=qDecoded===$qDecoded=\r\n","a");
	return ($qDecoded);
}

?>
