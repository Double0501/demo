<?php
require __DIR__.'/vendor/autoload.php';

$objPHPExcel = \PHPExcel_IOFactory::load(__DIR__."/suit2.xlsx");
$objWorksheet = $objPHPExcel->getActiveSheet();
$highestRow = $objWorksheet->getHighestRow(); 

$highestColumn = $objWorksheet->getHighestColumn();
$highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);  

$strs = [];
for ($col = 0;$col < $highestColumnIndex;$col++)
{
     $fieldTitle = $objWorksheet->getCellByColumnAndRow($col, 1)->getValue();
     if (trim($fieldTitle) == "") continue;

     $strs[$col] = $fieldTitle."";
}
$excelField = $strs;

$sizeTable = [];
for ($row = 2;$row <= $highestRow;$row++) 
{   
    $strs = array();
    for ($col = 0;$col < $highestColumnIndex;$col++)
    {
         $infoData = $objWorksheet->getCellByColumnAndRow($col, $row)->getFormattedValue();
         $strs[$col] = $infoData."";
         unset($infoData);
    }
    $sizeTable[$row] = $strs;
}

$indexs = [];
foreach ($excelField as $key => $val) {
    if ($val == "臀围无省") {
        $indexs['hipline'] = $key;
    } 
    if ($val == "臀围1省") {
        $indexs['hipline1'] = $key;
    }
    if ($val == "臀围2省") {
        $indexs['hipline2'] = $key;
    }
    if ($val == "腰围") {
        $indexs['waistline'] = $key;
    }
}

if ($_POST['inlineRadioOptions'] == "hipline1") {
    $indexs['hipline'] = $indexs['hipline1'];
}
if ($_POST['inlineRadioOptions'] == "hipline2") {
    $indexs['hipline'] = $indexs['hipline2'];
}
$rules = [
    'hipline' => [
        'up' => 1,
        'down' => 1,
    ],
    'waistline' => [
        'up' => 1,
        'down' => 1,
    ],
];

$parts = [
    'hipline' => '臀围',
    'waistline' => '腰围',
];
$inputs = $_POST;
foreach ($rules as $part => $rule) {
    $ret = [];
    foreach ($sizeTable as $one) {
        if (($one[$indexs[$part]] <= ($inputs[$part] + $rule['up'])) && ($one[$indexs[$part]] >= ($inputs[$part] - $rule['down']))) {
            $ret[] = $one;
        }
    }
    $sizeTable = $ret;
    if (empty($ret)) {
        echo jsonResponse(400, "请人工进行查找,".$parts[$part]."异常");
        exit;
    }
}

$result = convert($excelField, $sizeTable);
echo jsonResponse(200, "匹配成功", $result);
function convert($names, $table) {
    $ret = [];
    foreach ($table as $key => $val) {
        foreach ($val as $k => $value) {
            $ret[$key][$names[$k]] = $value;
        }
    }

    return $ret;
}









