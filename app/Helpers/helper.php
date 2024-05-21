<?php

use Illuminate\Support\Str;

function generate_slug($string, $separator = '-')
{
    $slug = $string . $separator . Str::random(16);
    return $slug;
}

function format_rupiah($nominal)
{
    return 'Rp ' . number_format($nominal, 0, ',', '.');
}

function format_date($date)
{
    return $date->translatedFormat('d, F Y');
}

function ternary_3($condition1, $condition2, $result1,  $result2, $elseResult)
{
    // $item->is_verify != false ? ($item->is_verify == true ? 'Diterima' : 'Ditolak') : 'Menunggu Persetujuan';
    // return $condition1 ? $result1 : ($condition2 ? $result2 : $elseResult);
    return $condition1 ? ($condition2 ? $result1 : $result2) : $elseResult;
}
