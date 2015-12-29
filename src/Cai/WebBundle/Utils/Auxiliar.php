<?php
/**
 * Created by PhpStorm.
 * User: gsull
 * Date: 28-12-2015
 * Time: 11:17
 */

namespace Cai\WebBundle\Utils;


class Auxiliar
{
    public function slugGenerator($slug,$array){
        $i = 1;
        if(in_array($slug,$array)) {
            $i++;
            while (in_array($slug . "-" . $i, $array)) {
                $i++;
            }
            $slug = $slug . "-" . $i;
        }
        return $slug;
    }

    function toAscii($str, $replace=array(), $delimiter='-') {
        if( !empty($replace) ) {
            $str = str_replace((array)$replace, ' ', $str);
        }

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }
}