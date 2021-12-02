<?php
//讀取 composer 所下載的套件
require_once('vendor/autoload.php');

/**
 * 官方範例
 * URL: https://phpspreadsheet.readthedocs.io/en/latest/
 */

//你的 excel 檔案路徑 (含檔名)
$inputFileName = './轉檔.xlsx';

//透過套件功能來讀取 excel 檔
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);

//讀取當前工作表(sheet)的資料列數
$highestRow = $spreadsheet->getActiveSheet()->getHighestRow();

//依序讀取每一列，若是第一列為標題，建議 $i 從 2 開始
for($i = 2; $i <= $highestRow; $i++) {
    //若是某欄位值為空，代表那一列可能都沒資料，便跳出迴圈
    if( $spreadsheet->getActiveSheet()->getCell('A'.$i)->getValue() === '' || 
        $spreadsheet->getActiveSheet()->getCell('A'.$i)->getValue() === null ) break;
    
    //讀取 cell 值
    $id =        $spreadsheet->getActiveSheet()->getCell('A'.$i)->getValue();
    $cat_name =  $spreadsheet->getActiveSheet()->getCell('B'.$i)->getValue();
    $parent_id = $spreadsheet->getActiveSheet()->getCell('C'.$i)->getValue();

    //輸出結果
    echo "{$id}, {$cat_name}, {$parent_id}";
}