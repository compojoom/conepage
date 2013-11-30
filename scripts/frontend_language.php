<?php
/**
 * @author Daniel Dimitrov
 * @date: 28.03.12
 *
 * @copyright  Copyright (C) 2008 - 2012 compojoom.com . All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

$fFile = '../source/language/de-DE/de-DE.com_matukio.ini';
$bFile = '../source/administrator/language/de-DE/de-DE.com_matukio.ini';

$lines = parse_ini_file($fFile);
$missingLines = array();

foreach($lines as $key => $value) {
//    echo $key . '=> ' . $value . '<br />';

    if($value == "") {
        $missingLines[] = $key;
    }
}

$bIni = parse_ini_file($bFile);

$addtoFile = array();
foreach($bIni as $key => $value) {
    foreach($missingLines as $line ) {
        if($key == $line) {
            $addtoFile[$key] = $value;
            unset($bIni[$key]);
        }
    }
}

//change backend file
echo 'new backend strings <br />';
foreach($bIni as $key => $value) {
    echo $key . '="' . $value . '"<br/>';
}


// add to frontend
echo 'missing frontend strings <br />';

foreach($addtoFile as $key => $value) {
    echo $key . '="' . $value . '"<br/>';
}

