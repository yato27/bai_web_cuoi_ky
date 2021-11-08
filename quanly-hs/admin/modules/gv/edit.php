<?php 
    if (!defined('IN_SITE')) die ('The request not found'); 

    // Thiết lập font chữ UTF8 để khỏi bị lõi font
    header('Content-Type: text/html; charset=utf-8');

    // Kiểm tra xem có quyền super admin?, nếu không có quyền thì chuyển nó về trang logout
    if (!is_supper_admin()){
        redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
    }
?>

<?php

$magv = input_get('magv');

 // Lấy thông tin gv
    $sql = db_create_sql("SELECT magv, hoten_gv, ngaysinh, gioitinh, chucvu, malop, namhoc, chuyennganh, sdt, diachi FROM gv_thongtin {where}", array('magv' => $magv));
    $gv = db_get_row($sql);
    
    $hoten_gv = $gv['hoten_gv'];
    $ngaysinh = $gv['ngaysinh'];
    $gioitinh = $gv['gioitinh'];
    $chucvu = $gv['chucvu'];
    $malop = $gv['malop'];
    $namhoc = $gv['namhoc'];
    $chuyennganh = $gv['chuyennganh'];
    $sdt = $gv['sdt'];
    $diachi = $gv['diachi'];
    
    
    $error = array();

    // Điều khiển lấy ra thông tin
    $show='show';

    // VI TRI 1: CODE SUBMIT FORM
// Nếu người dùng submit form
if (is_submit('edit_gv'))
{
    // Lấy danh sách dữ liệu từ form
    $magv = input_post('magv');
    $where = array('magv'  => input_post('magv'));
    
    $data = array(
        'hoten_gv'  =>input_post('hoten_gv'),
        'ngaysinh'  =>input_post('ngaysinh'),
        'gioitinh'  =>input_post('gioitinh'),
        'chucvu'    =>input_post('chucvu'),
        'malop'     =>input_post('malop'),
        'namhoc'     =>input_post('namhoc'),
        'chuyennganh'=>input_post('chuyennganh'),
        'sdt'       =>input_post('sdt'),
        'diachi'    =>input_post('diachi')
    );
    
    // require file xử lý database cho user
    require_once('database/user.php');
    
    // Thực hiện validate
    $error = db_gv_validate($data);

    // Nếu validate không có lỗi
    if (!$error)
    {       
        // Nếu update thành công thì thông báo
        // và chuyển hướng về trang danh sách gv
        if (db_update('gv_thongtin', $data, $where)){
            // $sqlreturn = db_update('gv_thongtin', $data, $where);
            // echo '<script language="javascript"> alert("'.$sqlreturn.'" ); </script>';
            ?>
            <script language="javascript">
                alert('Cập nhật thành công!');
                window.location = '<?php echo create_link(base_url('admin'), array('m' => 'gv', 'a' => 'list')); ?>';
            </script>
            <?php
            die();
        }
    } else {
        $show = '';
    }
}

?>


<?php include_once('widgets/header.php'); ?>

<h1>Cập nhật thông tin giáo viên</h1>

<div class="controls">
    <a class="button" onclick="$('#main-form-edit').submit()" href="#">Lưu</a>
    <a class="button" href="<?php echo create_link(base_url('admin'), array('m' => 'gv', 'a' => 'list')); ?>">Trở về</a>
</div>

<form id="main-form-edit" method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'gv', 'a' => 'edit')); ?>">
    <input type="hidden" name="request_name" value="edit_gv"/>

    <table cellspacing="0" cellpadding="0" class="form tb_update">
        
        <tr>
            <td>Mã giáo viên</td>
            <td>
                <input readonly type="text" name="magv" value="<?php if($show) {echo $magv;} ?>" />
                <?php show_error($error, 'magv'); ?>
            </td>
        </tr>
        <tr>
            <td>Họ tên giáo viên</td>
            <td>
                <input type="text" name="hoten_gv" value="<?php if($show) {echo $hoten_gv;} ?>" />
                <?php show_error($error, 'hoten_gv'); ?>
            </td>
        </tr>
        <tr>
            <td>Ngày sinh</td>
            <td>
                <input type="date" name="ngaysinh" value="<?php if($show) {echo $ngaysinh;} ?>" />

                <?php show_error($error, 'ngaysinh'); ?>
            </td>
        </tr>

        <tr>
            <td>Giới tính</td>
            <td>
                <select name="gioitinh">
                    <option value="">-- Chọn Giới tính --</option>
                    <option selected value="Nam" <?php echo ($gioitinh == "Nam") ? 'selected' : ''; ?>>Nam</option>
                    <option value="Nữ" <?php echo ($gioitinh == "Nữ") ? 'selected' : ''; ?>>Nữ</option>
                </select>
                <?php show_error($error, 'gioitinh'); ?>
            </td>
        </tr>

        <tr>
            <td>Chức vụ</td>
            <td>
                <input type="text" name="chucvu" value="<?php if($show) {echo $chucvu;} ?>" />
                <?php show_error($error, 'chucvu'); ?>
            </td>
        </tr>

        <tr>
            <td>Chủ nhiệm lớp</td>
            <td>
                <input type="text" name="malop" value="<?php if($show) {echo $malop;} ?>" />
                <?php show_error($error, 'malop'); ?>
            </td>
        </tr>

        <tr>
            <td>Năm học</td>
            <td>
                <input type="text" name="namhoc" value="<?php if($show) {echo $namhoc;} ?>" />
                <?php show_error($error, 'namhoc'); ?>
            </td>
        </tr>

        <tr>
            <td>Chuyên ngành</td>
            <td>
                <input type="text" name="chuyennganh" value="<?php if($show) {echo $chuyennganh;} ?>" />
                <?php show_error($error, 'chuyennganh'); ?>
            </td>
        </tr>

        <tr>
            <td>Số điện thoại</td>
            <td>
                <input type="text" name="sdt" value="<?php if($show) {echo $sdt;} ?>" />
                <?php show_error($error, 'sdt'); ?>
            </td>
        </tr>

        <tr>
            <td>Địa chỉ</td>
            <td>
                <input type="text" name="diachi" value="<?php if($show) {echo $diachi;} ?>" />
                <?php show_error($error, 'diachi'); ?>
            </td>
        </tr>

    </table>
</form>

<?php include_once('widgets/footer.php'); ?>