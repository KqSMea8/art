<?php

namespace Custom\Helper;

abstract class Base
{
    /**
     * @param int $length
     * @param string $type number|mix
     * @return string $code
     */
    public static function generateRandomCode($length = 4, $type= 'number')
    {
        $code = '';
        if ($type === 'number') {
            $code = mt_rand(pow(10, $length - 1), pow(10, $length) - 1);
        } else {
            $list = [];
            for ($i = 0; $i <= 9; $i++) {
                $list[] = $i;
            }
            for ($j = ord('a'); $j <= ord('z'); $j++) {
                $list[] = chr($j);
            }
            for ($j = ord('A'); $j <= ord('Z'); $j++) {
                $list[] = chr($j);
            }
            $listLength = count($list);
            for ($i = 0; $i < $length; $i++) {
                $code .= $list[mt_rand(0, $listLength - 1)];
            }
        }
        return $code;
    }
}