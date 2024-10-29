<?php
include('connect.php');
$search = '';
$resultKhoa = [];
$resultSinhVien = [];

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $search = $conn->real_escape_string($search);
    $sqlKhoa = "SELECT * FROM khoa_dao_tao WHERE TenKhoa LIKE '%$search%'";
    $resultKhoa = $conn->query($sqlKhoa);
    $sqlSinhVien = "SELECT * FROM sinh_vien WHERE HoTen LIKE '%$search%'";
    $resultSinhVien = $conn->query($sqlSinhVien);
}
?>
