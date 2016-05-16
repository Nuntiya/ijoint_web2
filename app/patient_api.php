<?php
require_once "../dbconnect.php";

/**
 * Created by PhpStorm.
 * User: niceinkeaw
 * Date: 15/5/2559
 * Time: 14:38
 */

$action = getIsset('action');
$result = array();
if($action == 'get_patient_overall_progress'){
    $pid = getIsset('pid');
    $sql_task = "select * from task where pid = $pid and status <> 'x' order by date desc, tid desc";
    $records = $conn->queryRaw($sql_task);
    $row_count = 0;
    $row_complete_count = 0;
    $progress = 0;
    foreach($records as $record){
        if($record['status'] == 'd')
            $row_complete_count+=1;
        $row_count +=1;
    }
    $progress = number_format($row_complete_count*100/$row_count);
    $result['progress'] = $progress;
}

echo json_encode($result);