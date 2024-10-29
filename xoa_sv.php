<?php
include('connect.php');

if (isset($_GET['masv'])) {
    $masv = $_GET['masv'];
    $conn->begin_transaction(); // Bắt đầu transaction

    try {
        // Xóa sinh viên trong bảng sinh_vien
        $sqlDeleteSV = "DELETE FROM sinh_vien WHERE MaSV = ?";
        $stmtSV = $conn->prepare($sqlDeleteSV);
        $stmtSV->bind_param("s", $masv);
        $stmtSV->execute();
        
        // Commit transaction
        $conn->commit();

        // Thông báo thành công
        echo "<script>alert('Xóa sinh viên thành công!'); window.location.href='danh_sach_sv.php';</script>";
    } catch (mysqli_sql_exception $exception) {
        // Rollback nếu có lỗi xảy ra
        $conn->rollback();
        echo "<script>alert('Lỗi khi xóa sinh viên: " . $exception->getMessage() . "');</script>";
    } finally {
        // Đóng statement nếu nó đã được khởi tạo
        if ($stmtSV !== null) {
            $stmtSV->close();
        }
    }
} else {
    // Thông báo nếu mã sinh viên không hợp lệ
    echo "<script>alert('Mã sinh viên không hợp lệ.'); window.location.href='danh_sach_sv.php';</script>";
}

// Đóng kết nối
$conn->close();
?>
