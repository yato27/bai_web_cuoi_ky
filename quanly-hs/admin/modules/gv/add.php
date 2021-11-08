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
?>

<?php 
// Biến chứa lỗi
$error = array();

// VI TRI 1: CODE SUBMIT FORM
// Nếu người dùng submit form
if (is_submit('add_gv'))
{
    // Lấy danh sách dữ liệu từ form
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
        // Nếu insert thành công thì thông báo
        // và chuyển hướng về trang danh sách user
        if (db_insert('gv_thongtin', $data)){
            $sqlmagv = "UPDATE gv_thongtin SET `magv` = CONCAT('GV', LPAD(id, 6, '0'))";
            db_execute($sqlmagv);

            ?>
            <script language="javascript">
                alert('Thêm giáo viên thành công!');
                window.location = '<?php echo create_link(base_url('admin'), array('m' => 'gv', 'a' => 'list')); ?>';
            </script>
            <?php
            die();
        }
    }
}

?>

<?php include_once('widgets/header.php'); ?>

<h1>Thêm giáo viên</h1>

<div class="controls">
    <a class="button" onclick="$('#main-form').submit()" href="#">Lưu</a>
    <a class="button" href="<?php echo create_link(base_url('admin'), array('m' => 'gv', 'a' => 'list')); ?>">Trở về</a>
</div>

<form id="main-form" method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'gv', 'a' => 'add')); ?>">
    <input type="hidden" name="request_name" value="add_gv"/>
    
    <table cellspacing="0" cellpadding="0" class="form tb_update">
    
        <tr>
            <td>Họ tên giáo viên</td>
            <td>
                <input type="text" name="hoten_gv" value="<?php echo input_post('hoten_gv'); ?>" />
                <?php show_error($error, 'hoten_gv'); ?>
            </td>
        </tr>
        <tr>
            <td>Ngày sinh</td>
            <td>
                <input type="date" name="ngaysinh" value="<?php ?>" />

                <?php show_error($error, 'ngaysinh'); ?>
            </td>
        </tr>

        <tr>
            <td>Giới tính</td>
            <td>
                <select name="gioitinh">
                    <option value="">-- Chọn Giới tính --</option>
                    <option value="Nam" >Nam</option>
                    <option value="Nữ" >Nữ</option>
                </select>
                <?php show_error($error, 'gioitinh'); ?>
            </td>
        </tr>

        <tr>
            <td>Chức vụ</td>
            <td>
                <input type="text" name="chucvu" value="<?php echo input_post('chucvu'); ?>" />
                <?php show_error($error, 'chucvu'); ?>
            </td>
        </tr>
        
        <tr>
            <td>Chủ nhiệm lớp</td>
            <td>
                <input type="text" name="malop" value="<?php echo input_post('malop'); ?>" />
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
            <td>Chuyên ngành</td>
            <td>
                <input type="text" name="chuyennganh" value="<?php echo input_post('chuyennganh'); ?>" />
                <?php show_error($error, 'chuyennganh'); ?>
            </td>
        </tr>

        <tr>
            <td>Số điện thoại</td>
            <td>
                <input type="text" name="sdt" value="<?php echo input_post('sdt'); ?>" />
                <?php show_error($error, 'sdt'); ?>
            </td>
        </tr>

        <tr>
            <td>Địa chỉ</td>
            <td>
                <input type="text" name="diachi" value="<?php echo input_post('diachi'); ?>" />
                <?php show_error($error, 'diachi'); ?>
            </td>
        </tr>

    </table>
</form>

<?php include_once('widgets/footer.php'); ?>