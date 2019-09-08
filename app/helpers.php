<?php
if(! function_exists('strtodecimal')) {
    function strtodecimal($string)
    {
        $s = ltrim($string);
        $l = strlen($s);
        $x = substr($string, -1);
        $y = substr($string, 0, $l - 1);

//        echo '$l: '.$l."<br>";
//        echo '$x: '.$x."<br>";
//        echo '$y: '.$y."<br><br>";

        switch($x) {
            case 'A':
                $v = '1';
                break;
            case 'B':
                $v = '2';
                break;
            case 'C':
                $v = '3';
                break;
            case 'D':
                $v = '4';
                break;
            case 'E':
                $v = '5';
                break;
            case 'F':
                $v = '6';
                break;
            case 'G':
                $v = '7';
                break;
            case 'H':
                $v = '8';
                break;
            case 'I':
                $v = '9';
                break;
            default:
                $v = '0';
        }
        $ss = $y.$v;
//        echo 'ss: '.$ss.'<br>';
        $sd = (int)$ss * 0.01;

//        if (substr($string, 0, 1) === '{') {
//            $sd = $sd * -1;
//        }

//        echo '$sd: '.$sd."<br>";
        return $sd;

    }
}
