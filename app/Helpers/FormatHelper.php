<?php

if (!function_exists('formatRupiah')) {
    function formatRupiah($angka)
    {
        $rupiah = "Rp " . number_format($angka, 0, ',', '.');
        return $rupiah;
    }
}

if (!function_exists('formatAngka')) {
    function formatAngka($angka)
    {
        $rupiah = number_format($angka, 0, ',', '.');
        return $rupiah;
    }
}
