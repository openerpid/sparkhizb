<?php

namespace Sparkhizb\Helpers;

/**
* =============================================
* Author: Ummu
* Website: https://ummukhairiyahyusna.com/
* App: DORBITT LIB
* Description: 
* =============================================
*/

class DateTimeHelper 
{
    public function __construct()
    {
        $this->request = \Config\Services::request();
    }

    public function dtFormatter($data)
    {
        return date('Y-m-d H:i:s', strtotime(str_replace('.', '/', $data)));
    }

    public function dateFromFormatter($data)
    {
        return date('Y-m-d', strtotime(str_replace('.', '/', $data)));
    }

    public function timeFromFormatter($data)
    {
        return date('H:i:s', strtotime(str_replace('.', '/', $data)));
    }

    public function dateToFormatter($data)
    {
        return date('Y-m-d', strtotime(str_replace('.', '/', $data)));
    }

    public function timeToFormatter($data)
    {
        return date('H:i:s', strtotime(str_replace('.', '/', $data)));
    }

    public function dtfFormatter($data)
    {
        if ($data) {
            $strtotime = strtotime(str_replace('.', '/', $data));
            // $date = date('Y-m-d', $strtotime);
            // $time = date('H:i:s', $strtotime);

            return date('Y-m-d H:i:s', $strtotime);
        }
    }

    public function dttFormatter($data)
    {
        if ($data) {
            $strtotime = strtotime(str_replace('.', '/', $data));
            $date = date('Y-m-d', $strtotime);
            $time = date('H:i:s', $strtotime);
            if ($time == '00:00:00') {
                $time = '23:59:59';
                $dtt = $date.' '.$time;
            }else{
                $dtt = date('Y-m-d H:i:s', $strtotime);
            }


            return $dtt;
        }
    }

    //date_start_end_default
    public function dse_default($a)
    {
        /*$week_start = strtotime('last Sunday', time());
        $week_end = strtotime('next Sunday', time());*/

        $month_start = strtotime('first day of this month', time());
        $month_end = strtotime('last day of this month', time());

        /*$year_start = strtotime('first day of January', time());
        $year_end = strtotime('last day of December', time());*/

        /*echo date('D, M jS Y', $week_start).'<br/>';
        echo date('D, M jS Y', $week_end).'<br/>';

        echo date('D, M jS Y', $month_start).'<br/>';
        echo date('D, M jS Y', $month_end).'<br/>';

        echo date('D, M jS Y', $year_start).'<br/>';
        echo date('D, M jS Y', $year_end).'<br/>';*/

        if ($a == 'start') {
            return date('Y-m-d', $month_start);
        }
        elseif($a == 'end'){
            return date('Y-m-d', $month_end);
        }
    }

    //datetime_start_end_default
    public function dtse_default($date = null, $a)
    {
        /*$week_start = strtotime('last Sunday', time());
        $week_end = strtotime('next Sunday', time());*/

        if ($date) {
            $month_start = strtotime($date);
            $month_end = strtotime($date);
        }else{
            $month_start = strtotime('first day of this month', time());
            $month_end = strtotime('last day of this month', time());
        }

        /*$year_start = strtotime('first day of January', time());
        $year_end = strtotime('last day of December', time());*/

        /*echo date('D, M jS Y', $week_start).'<br/>';
        echo date('D, M jS Y', $week_end).'<br/>';

        echo date('D, M jS Y', $month_start).'<br/>';
        echo date('D, M jS Y', $month_end).'<br/>';

        echo date('D, M jS Y', $year_start).'<br/>';
        echo date('D, M jS Y', $year_end).'<br/>';*/

        if ($a == 'start') {
            return date('Y-m-d', $month_start) . ' 00:00:01';
        }
        elseif($a == 'end'){
            return date('Y-m-d', $month_end) . ' 23:59:59';
        }
    }

    public function xsd_to_time($a)
    {
        $b = str_replace("T",",",$a);
        
        $c = explode(",",$b);
        $d = $c[1];

        $e = str_replace("H",":",$d);
        $f = str_replace("M",":",$e);
        $g = str_replace("M",":",$f);

        $h = str_replace("S","",$g);

        return $h;
    }

    public function calc_age($tgl_lahir)
    {
        $tanggal_lahir = new \DateTime($tgl_lahir);
        $sekarang = new \DateTime("today");
        if ($tanggal_lahir > $sekarang) { 
            $thn = "0";
            $bln = "0";
            $tgl = "0";
        }
        $thn = $sekarang->diff($tanggal_lahir)->y;
        $bln = $sekarang->diff($tanggal_lahir)->m;
        $tgl = $sekarang->diff($tanggal_lahir)->d;
        $jml_bulan = ($thn*12)+$bln;
        //echo $thn." tahun ".$bln." bulan ".$tgl." hari";
        // echo ($thn*12)+$bln." bulan ".$tgl." hari";
        return [
            "tahun" => $thn,
            "bulan" => $bln,
            "hari"  => $tgl,
            "jml_bulan" => $jml_bulan,
            "text"  => $thn." tahun ".$bln." bulan ".$tgl." hari",
            "text2" => $jml_bulan." bulan ".$tgl." hari"
        ];
        // return new \DateTime('today');
    }
}