<?php
class Excel {
    
    protected $objWorksheet;

    public function __construct($excel)
    {
        $objPHPExcel = \PHPExcel_IOFactory::load($excel);
        $this->objWorksheet = $objPHPExcel->getActiveSheet();
    }

    public function getExcelField()
    {
        $highestRow = $this->objWorksheet->getHighestRow(); 
        $highestColumn = $this->objWorksheet->getHighestColumn();
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);  

        $strs = [];
        for ($col = 0;$col < $highestColumnIndex;$col++)
        {
            $fieldTitle = $this->objWorksheet->getCellByColumnAndRow($col, 1)->getValue();
            if (trim($fieldTitle) == "") continue;

            $strs[$col] = $fieldTitle."";
        }
        return $strs;
    }

    public function getSizeTable()
    {   
        $highestRow = $this->objWorksheet->getHighestRow();
        $highestColumn = $this->objWorksheet->getHighestColumn();
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);  
        
        $sizeTable = [];
        for ($row = 2;$row <= $highestRow;$row++) 
        {   
            $strs = array();
            for ($col = 0;$col < $highestColumnIndex;$col++)
            {
                $infoData = $this->objWorksheet->getCellByColumnAndRow($col, $row)->getFormattedValue();
                $strs[$col] = $infoData."";
                unset($infoData);
            }
            $sizeTable[$row] = $strs;
        }

        return $sizeTable;
    }
}
