<?php 
include '../PHPSpreadsheet/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

require('../config/connect_db.php');
require('../report/m_sum_product.php');

    if(isset($_POST["btnPD"]) && $_POST['btnPD'] !='')
    {  

    $file = new Spreadsheet();

    if (isset($_POST['search_order']) && $_POST['search_order'] !='') {
        $search_order = base64_decode(urldecode($_POST['search_order']));
    }elseif(isset($_GET['search_order']) && $_GET['search_order'] !=''){
        $search_order = base64_decode(urldecode($_GET['search_order']));
    }else{
        $search_order='';
    }

    if (isset($_POST['monthpicker']) && $_POST['monthpicker'] !='') {
        $monthpicker = base64_decode(urldecode($_POST['monthpicker']));
    }elseif(isset($_GET['monthpicker']) && $_GET['monthpicker'] !=''){
        $monthpicker = base64_decode(urldecode($_GET['monthpicker']));
    }else{
        $monthpicker='';
    }

    $product_DT=product_DT($dbh,$search_order,$monthpicker,$start, $perpage);
    $totalaProduct=totalaProduct($dbh,$search_order,$monthpicker);

    $active_sheet = $file->getActiveSheet();
    $file->getProperties()
        ->setTitle('Report Detail ')
        ->setSubject('Report')
        ->setDescription('Report Detail sum')
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
    $active_sheet->getStyle('A1:G1')->getAlignment()->setHorizontal('center');
    $file->getActiveSheet()->getStyle("A1:G1")->getFont()->setSize(14);
    $active_sheet->freezePane('A3');
    $file->setActiveSheetIndex(0)
        ->setCellValue('A1', 'ລາຍງານການຂາຍ')
        ->mergeCells('A1:G1')
        ->setCellValue('A2', 'ລຳດັບ')
        ->setCellValue('B2', 'ຊື່ສະຖານະ')
        ->setCellValue('C2', 'ປະເພດເບີ')
        ->setCellValue('D2', 'ພ້ອມຂາຍ')
        ->setCellValue('E2', 'ຈອງ')
        ->setCellValue('F2', 'ຊື້')
        ->setCellValue('G2', 'ສຳເລັດການຂາຍ');

    $count = 3;
    $i=0;
    foreach($product_DT as $row)
    {
    $i++;    
    $file->getActiveSheet()
        ->setCellValue('A' . $count, $i)
        ->setCellValue('B' . $count, $row['status_name'])
        ->setCellValue('C' . $count, $row['type_name'])
        ->setCellValue('D' . $count, $row['ready_to_sell'])
        ->setCellValue('E' . $count, $row['booked'])
        ->setCellValue('F' . $count, $row['saled'])
        ->setCellValue('G' . $count, $row['Success']);

    $count = $count + 1;
    }

$file->getActiveSheet()->setTitle("Report Customer feedback");
$writer = IOFactory::createWriter($file, "Xlsx");
$file_name = "report_order.xlsx";
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf8mb4");
header("Content-Disposition: attachment; filename=". urlencode($file_name) ."");
$writer->save("php://output");

}
 ?>

    

    