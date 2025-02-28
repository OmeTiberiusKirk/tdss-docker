<?php
//On windows:
/*
$hdwinC = getSymbolByQuantity(disk_free_space("C:"));
$hdwinD = getSymbolByQuantity(disk_free_space("D:"));
*/
$hdwinC = number_format(disk_free_space("C:"), 2, ".", ",");
$hdwinD = disk_free_space("D:");

echo "Diskspace left on C: $hdwinC<br>";
echo "Diskspace left on D: $hdwinD";


function getSymbolByQuantity($bytes) {
    $symbols = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');
    $exp = floor(log($bytes)/log(1024));

    return sprintf('%.2f '.$symbol[$exp], ($bytes/pow(1024, floor($exp))));
}
?>