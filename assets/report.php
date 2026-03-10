<?php
include_once 'config/base.php';
function list_usersERP()
{
    global $connections;
    $data = array();
    $sql="SELECT distinct erp.[erp_code] as codepro
                         ,erp.[erp_username] as username
                         ,erp.[rw_programname]
                         ,erp.[erp_sendmail] as sendmaildate
                         ,erp.[erp_loginname] as loginname
                         ,remk.erp_status as statusname
                         ,remk.erp_itchecked as itchecked
                         ,remk.erp_itcheck_date as itcheck_date
                 FROM [ASEFA_ITPERMISSION].[dbo].[Review_ERP_USERS] erp
                 left join Review_ERP_Remark remk ON remk.erp_code = erp.erp_code
  ";
  $query = sqlsrv_query($connections, $sql) or die("<pre>" . print_r( sqlsrv_errors(), true) . "</pre>");
  while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
      $data[] = $row;
  }
  return $data;
}