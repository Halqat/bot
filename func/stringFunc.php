<?php

/** دالة اختبار البدأ بقيمة معينة */
function startsWith ($string, $startString)
{
    $len = strlen($startString);
    return (substr($string, 0, $len) === $startString);
}