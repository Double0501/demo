<?php
require __DIR__.'/vendor/autoload.php';
require __DIR__."/Excel.php";

$excel = new Excel(__DIR__."/suit.xlsx");
$excelField = $excel->getExcelField();
$sizeTable = $excel->getSizeTable();

$indexs = [];
foreach ($excelField as $key => $val) {
    if ($val == "肩宽") {
        $indexs['shoudler'] = $key;
    }
    if ($val == "胸围") {
        $indexs['chest'] = $key;
    }
    if ($val == "腰围") {
        $indexs['wasit'] = $key;
    }
}
$rules = [
    'chest' => [
        'up' => 1,
        'down' => 1,
    ],
    'wasit' => [
        'up' => 1,
        'down' => 1,
    ],
    'shoudler' => [
        'up' => 0.5,
        'down' => 0.5,
    ],
];

$parts = [
    'chest' => '胸围',
    'wasit' => '腰围',
    'shoudler' => '肩宽'
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









