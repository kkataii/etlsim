<?php 
include '../PHPSpreadsheet/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

require('../config/connect_db.php');
require('../report/m_detail.php');

    if(isset($_POST["btsExcel"]))
    {

        $txtproduct_id = isset($_POST['txtproduct_id']) ? base64_decode(urldecode($_POST['txtproduct_id'])) :'';
        $startdate = isset($_POST['startdate']) ? base64_decode(urldecode($_POST['startdate'])) :'';
        $enddate = isset($_POST['enddate']) ? base64_decode(urldecode($_POST['enddate'])) :'';
        $txtstatus_id = isset($_POST['txtstatus_id']) ? base64_decode(urldecode($_POST['txtstatus_id'])) :'';
        $txtSearch = isset($_POST['txtSearch']) ? base64_decode(urldecode($_POST['txtSearch'])) :'';
        $chktype = isset($_POST['chktype']) ? base64_decode(urldecode($_POST['chktype'])) :'';
        $txtmonth_id = isset($_POST['txtmonth_id']) ? base64_decode(urldecode($_POST['txtmonth_id'])) :'';


    $whereclause = "";

    if ($dochktype=='ready') {
        $showChk = 'ເພີ່ມ';
        if ($txtstatus_id != "") $whereclause .= " status_order_id LIKE  '%".$txtstatus_id."%' AND";
        if ($startdate != "") $whereclause .= " date_add BETWEEN  ADDDATE('".$startdate."', INTERVAL 0 HOUR) AND ADDDATE('".$enddate."', INTERVAL '23:59' HOUR_MINUTE) AND";
        if ($whereclause != "") $whereclause = " WHERE " . substr($whereclause, 0, strlen($whereclause)-4);
    }elseif ($dochktype=='booked') {
        $showChk = 'ຈອງ';
        if ($txtstatus_id != "") $whereclause .= " status_order_id LIKE  '%".$txtstatus_id."%' AND";
        if ($startdate != "") $whereclause .= " date_book BETWEEN  ADDDATE('".$startdate."', INTERVAL 0 HOUR) AND ADDDATE('".$enddate."', INTERVAL '23:59' HOUR_MINUTE) AND";
        if ($whereclause != "") $whereclause = " WHERE " . substr($whereclause, 0, strlen($whereclause)-4);
    }elseif ($dochktype=='buy') {
        $showChk = 'ຊື່';
        if ($txtstatus_id != "") $whereclause .= " status_order_id LIKE  '%".$txtstatus_id."%' AND";
        if ($startdate != "") $whereclause .= " date_buy BETWEEN  ADDDATE('".$startdate."', INTERVAL 0 HOUR) AND ADDDATE('".$enddate."', INTERVAL '23:59' HOUR_MINUTE) AND";
        if ($whereclause != "") $whereclause = " WHERE " . substr($whereclause, 0, strlen($whereclause)-4);
    }elseif ($dochktype=='Success') {
        $showChk = 'ສໍາເລັດ';
        if ($txtstatus_id != "") $whereclause .= " status_order_id LIKE  '%".$txtstatus_id."%' AND";
        if ($startdate != "") $whereclause .= " date_success BETWEEN  ADDDATE('".$startdate."', INTERVAL 0 HOUR) AND ADDDATE('".$enddate."', INTERVAL '23:59' HOUR_MINUTE) AND";
        if ($whereclause != "") $whereclause = " WHERE " . substr($whereclause, 0, strlen($whereclause)-4);
    }
    else{
        $showChk = '';
        if ($txtSearch != "") $whereclause .= " product_name LIKE  '%".$txtSearch."%' AND";
        if ($txtstatus_id != "") $whereclause .= " status_order_id LIKE  '%".$txtstatus_id."%' AND";
        if ($startdate != "") $whereclause .= " date_add BETWEEN  ADDDATE('".$startdate."', INTERVAL 0 HOUR) AND ADDDATE('".$enddate."', INTERVAL '23:59' HOUR_MINUTE) AND";
        if ($whereclause != "") $whereclause = " WHERE " . substr($whereclause, 0, strlen($whereclause)-4);
    }

    $totalCount = totaldetail($dbh, $whereclause);
    $limitclause = " LIMIT 0, ".$perpage=$totalCount;
    $detailinfo = detailinfo($dbh, $whereclause, $limitclause); 

     //print_r($detailinfo);

    $file = new Spreadsheet();
    $active_sheet = $file->getActiveSheet();

//Specify the properties for this document
$file->getProperties()
    ->setTitle('Report Detail End User')
    ->setSubject('Detail End User')
    ->setDescription('Report Detail End User in sys E2pay')
    ->setCreator('Nailor Dev')
    ->setLastModifiedBy('Nailor Dev');
    $styleArray = array(
       'font'  => array(
            'bold'  => false,
            'color' => array('rgb' => '000000'),
            'size'  => 11,
            'name'  => 'Phetsarath OT'
        ));      
     $file->getDefaultStyle()
        ->applyFromArray($styleArray);
    $active_sheet->getStyle('A1:I1')->getAlignment()->setHorizontal('center');
    $file->getActiveSheet()->getStyle("A1:I1")->getFont()->setSize(14);
    $active_sheet->freezePane('A3');
    $file->setActiveSheetIndex(0)
        ->setCellValue('A1', 'ລາຍງານການຂາຍ')
        ->mergeCells('A1:I1')
        ->setCellValue('A2', 'ລຳດັບ')
        ->setCellValue('B2', 'ເບີ')
        ->setCellValue('C2', 'ປະເພດເບີ')
        ->setCellValue('D2', 'ລາຄາ')
        ->setCellValue('E2', 'ຊື່ສະຖານະ')
        ->setCellValue('F2', 'ວັນທີ ເພີ່ມ')
        ->setCellValue('G2', 'ວັນທີ ຈອງ')
        ->setCellValue('H2', 'ວັນທີ ຊື່')
        ->setCellValue('I2', 'ວັນທີ ສຳເລັດ');

    $count = 3;
    $i=0;
    foreach($detailinfo as $row)
    {
    $i++;    
    $file->getActiveSheet()
        ->setCellValue('A' . $count, $i)
        ->setCellValue('B' . $count, $row['product_name'])
        ->setCellValue('C' . $count, $row['type_name'])
        ->setCellValue('D' . $count, $row['price'])
        ->setCellValue('E' . $count, $row['status_name'])
        ->setCellValue('F' . $count, $row['date_add'])
        ->setCellValue('G' . $count, $row['date_book'])
        ->setCellValue('H' . $count, $row['date_buy'])
        ->setCellValue('I' . $count, $row['date_success']);

    $count = $count + 1;
    }

$file->getActiveSheet()->setTitle("Report Customer feedback");
$writer = IOFactory::createWriter($file, "Xlsx");
$file_name = "Detail.xlsx";
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf8mb4");
header("Content-Disposition: attachment; filename=". urlencode($file_name) ."");
$writer->save("php://output");

}
 ?>

    

    