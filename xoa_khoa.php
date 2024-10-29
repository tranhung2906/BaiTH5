<?php
include('connect.php');
$sqlCheck = "SELECT COUNT(*) as count FROM mon_hoc WHERE MaKhoa = ?";
$stmtCheck = $conn->prepare($sqlCheck);
$stmtCheck->bind_param("s", $makhoa);
$stmtCheck->execute();
$resultCheck = $stmtCheck->get_result();
$count = $resultCheck->fetch_assoc()['count'];

?>
<?php
include('connect.php');
if (isset($_GET['makhoa'])) {
    $makhoa = $_GET['makhoa'];
    $conn->begin_transaction();

    try {
        $sqlCheck = "SELECT COUNT(*) as count FROM mon_hoc WHERE MaKhoa = ?";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bind_param("s", $makhoa);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();
        $count = $resultCheck->fetch_assoc()['count'];

        if ($count > 0) {
            echo "<script>alert('Không thể xóa khoa vì có bản ghi liên quan trong môn học.'); window.location.href='danh_sach_khoa.php';</script>";
            exit;
        }
        $sqlDeleteKhoa = "DELETE FROM khoa_dao_tao WHERE MaKhoa = ?";
        $stmtKhoa = $conn->prepare($sqlDeleteKhoa);
        $stmtKhoa->bind_param("s", $makhoa);
        $stmtKhoa->execute();
        $conn->commit();

        echo "<script>alert('Xóa khoa thành công!'); window.location.href='danh_sach_khoa.php';</script>";
    } catch (mysqli_sql_exception $exception) {

        $conn->rollback();
        echo "<script>alert('Lỗi khi xóa khoa: " . $exception->getMessage() . "');</script>";
    } finally {
        $stmtCheck->close();
        $stmtKhoa->close();
    }
} else {
    echo "<script>alert('Mã khoa không hợp lệ.'); window.location.href='danh_sach_khoa.php';</script>";
}

$conn->close();
?>
