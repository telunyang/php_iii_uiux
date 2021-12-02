<?php
//array_unique() : 去除陣列重複的值
$arr = [2, 2, 3, 6, 2, 7, 6];
echo "<pre>";
print_r( array_unique($arr) );
echo "</pre>";

//array_values() : 將陣列內容重新設定索引(從 0 開始)
$arr = [2, 2, 3, 6, 2, 7, 6];
$arrNotInOrder = array_unique($arr);

echo "<pre>";
print_r( $arrNotInOrder );
echo "</pre>";

echo "<pre>";
print_r( array_values($arrNotInOrder) );
echo "</pre>";