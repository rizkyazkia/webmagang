<?php
function GetMonth($Dates)
{
    $Month = substr($Dates, 5);
    switch ($Month) {
        case "1":
            $Bulan = "Januari";
            break;
        case "2":
            $Bulan = "Februari";
            break;
        case "3":
            $Bulan = "Maret";
            break;
        case "4":
            $Bulan = "April";
            break;
        case "5":
            $Bulan = "Mei";
            break;
        case "6":
            $Bulan = "Juni";
            break;
        case "7":
            $Bulan = "Juli";
            break;
        case "8":
            $Bulan = "Agustus";
            break;
        case "9":
            $Bulan = "September";
            break;
        case "10":
            $Bulan = "Oktober";
            break;
        case "11":
            $Bulan = "November";
            break;
        case "12":
            $Bulan = "Desember";
            break;
    }
    return $Bulan;
}

function getListMonth($MonthData)
{
    $MonthData = explode("-", $MonthData);
    $StartMonth = $MonthData[0];
    $EndMonth = $MonthData[1];
    $Month = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $RangedMonth = array();
    $count = 0;
    foreach ($Month as $data) {
        if ($data == $StartMonth) {
            $numberStart = $count;
        } elseif ($data == $EndMonth) {
            $numberEnd = $count;
        }
        $count = $count + 1;
    }

    $counter = 0;
    foreach ($Month as $data) {
        if ($counter >= $numberStart and $counter <= $numberEnd) {
            array_push($RangedMonth, $Month[$counter]);
        }
        $counter = $counter + 1;
    }
    return $RangedMonth;
}