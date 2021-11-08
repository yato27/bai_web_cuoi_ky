<?php 
    if (!defined('IN_SITE')) die ('The request not found'); 
    
    // Thiết lập font chữ UTF8 để khỏi bị lõi font
    header('Content-Type: text/html; charset=utf-8');
?>

<?php
// Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
if (!is_admin()){
    redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
}

// Lấy username
$username = is_logged()['username'];
?>

<?php 
// Biến chứa lỗi
$error = array();

// VI TRI 1: CODE SUBMIT FORM
// Nếu người dùng submit form
if (is_submit('add_hs'))
{
    // Lấy danh sách dữ liệu từ form
    $data = array(
        'hoten_hs'  =>input_post('hoten_hs'),
        'ngaysinh'  =>input_post('ngaysinh'),
        'gioitinh'  =>input_post('gioitinh'),
        'malop'     =>input_post('malop'),
        'namhoc'    =>input_post('namhoc'),
        'diachi'    =>input_post('diachi'),
        'hoten_bo'  =>input_post('hoten_bo'),
        'sdt_bo'    =>input_post('sdt_bo'),
        'hoten_me'  =>input_post('hoten_me'),
        'sdt_me'    =>input_post('sdt_me'),
        'update_by' =>$username
    );
    
    // require file xử lý database cho user
    require_once('database/user.php');
    
    // Thực hiện validate
    $error = db_hs_validate($data);
    
    // Nếu validate không có lỗi
    if (!$error)
    {
        // Nếu insert thành công thì thông báo
        // và chuyển hướng về trang danh sách hs
        if (db_insert('hs_thongtin', $data)){
            $sqlmahs = "UPDATE hs_thongtin SET `mahs` = CONCAT('HS', LPAD(id, 6, '0'))";
            db_execute($sqlmahs);
            $sqlmaph = "UPDATE hs_thongtin SET `maph` = CONCAT('PH', LPAD(id, 6, '0'))";
            db_execute($sqlmaph);

            ?>
            <script language="javascript">
                alert('Thêm học sinh thành công!');
                window.location = '<?php echo create_link(base_url('admin'), array('m' => 'hs', 'a' => 'list')); ?>';
            </script>
            <?php
            die();
        }
    }
}

?>

<?php include_once('widgets/header.php'); ?>

<h1>Thêm học sinh</h1>

<div class="controls">
    <a class="button" onclick="$('#main-form').submit()" href="#">Lưu</a>
    <a class="button" href="<?php echo create_link(base_url('admin'), array('m' => 'hs', 'a' => 'list')); ?>">Trở về</a>
</div>

<form id="main-form" method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'hs', 'a' => 'add')); ?>">
    <input type="hidden" name="request_name" value="add_hs"/>
    
    <table cellspacing="0" cellpadding="0" class="form tb_update">

        <tr>
            <td>Họ tên học sinh</td>
            <td>
                <input type="text" name="hoten_hs" value="<?php echo input_post('hoten_hs'); ?>" />
                <?php show_error($error, 'hoten_hs'); ?>
            </td>
        </tr>
        <tr>
            <td>Ngày sinh</td>
            <td>
                <input type="date" name="ngaysinh" value="<?php echo input_post('ngaysinh'); ?>" />

                <?php show_error($error, 'ngaysinh'); ?>
            </td>
        </tr>

        <tr>
            <td>Giới tính</td>
            <td>
                <select name="gioitinh">
                    <option value="">-- Chọn Giới tính --</option>
                    <option value="Nam" <?php echo (input_post('gioitinh') == "Nam") ? 'selected' : ''; ?>>Nam</option>
                    <option value="Nữ" <?php echo (input_post('gioitinh') == "Nữ") ? 'selected' : ''; ?>>Nữ</option>
                </select>
                <?php show_error($error, 'gioitinh'); ?>
            </td>
        </tr>

        <tr>
            <td>Lớp</td>
            <td>
                <input type="text" name="malop" value="<?php  echo input_post('malop'); ?>" />
                <?php show_error($error, 'malop'); ?>
            </td>
        </tr>

        <tr>
            <td>Năm học</td>
            <td>
                <input type="text" name="namhoc" value="<?php echo input_post('namhoc'); ?>" />
                <?php show_error($error, 'namhoc'); ?>
            </td>
        </tr>

        <tr>
            <td>Địa chỉ</td>
            <td>
                <input type="text" name="diachi" value="<?php echo input_post('diachi'); ?>" />
                <?php show_error($error, 'diachi'); ?>
            </td>
        </tr>

        <tr>
            <td>Họ tên bố</td>
            <td>
                <input type="text" name="hoten_bo" value="<?php echo input_post('hoten_bo'); ?>" />
                <?php show_error($error, 'hoten_bo'); ?>
            </td>
        </tr>

        <tr>
            <td>Số điện thoại bố</td>
            <td>
                <input type="text" name="sdt_bo" value="<?php echo input_post('sdt_bo'); ?>" />
                <?php show_error($error, 'sdt_bo'); ?>
            </td>
        </tr>

        <tr>
            <td>Họ tên mẹ</td>
            <td>
                <input type="text" name="hoten_me" value="<?php echo input_post('hoten_me'); ?>" />
                <?php show_error($error, 'hoten_me'); ?>
            </td>
        </tr>

        <tr>
            <td>Số điện thoại mẹ</td>
            <td>
                <input type="text" name="sdt_me" value="<?php echo input_post('sdt_me'); ?>" />
                <?php show_error($error, 'sdt_me'); ?>
            </td>
        </tr>


        
    
    </table>
</form>

<?php include_once('widgets/footer.php'); ?>