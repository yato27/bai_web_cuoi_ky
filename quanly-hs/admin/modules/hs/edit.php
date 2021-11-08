<?php 
    if (!defined('IN_SITE')) die ('The request not found'); 

    // Thiết lập font chữ UTF8 để khỏi bị lõi font
    header('Content-Type: text/html; charset=utf-8');

    // Kiểm tra xem có quyền super admin?, nếu không có quyền thì chuyển nó về trang logout
    if (!is_admin()){
        redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
    }

    // Lấy username
    $username = is_logged()['username'];
?>

<?php
    // Lấy mã hs
    $mahs = input_get('mahs');

    // Lấy thông tin hs
    $sql = db_create_sql("SELECT mahs,hoten_hs,ngaysinh,gioitinh,malop,namhoc,diachi,maph,hoten_bo,sdt_bo,hoten_me,sdt_me
    FROM hs_thongtin {where}", array('mahs' => $mahs));
    $hss = db_get_list($sql);
    $hs = $hss[0];

    $hoten_hs = $hs['hoten_hs'];
    $ngaysinh = $hs['ngaysinh'];
    $gioitinh = $hs['gioitinh'];
    $malop = $hs['malop'];
    $namhoc = $hs['namhoc'];
    $diachi = $hs['diachi'];
    $hoten_bo = $hs['hoten_bo'];
    $sdt_bo = $hs['sdt_bo'];
    $hoten_me = $hs['hoten_me'];
    $sdt_me = $hs['sdt_me'];
    $update_by = $username;
    
    // // show để test
    // // echo ($sql);
    // echo '<pre>'; print_r($hs); echo '</pre>';
    // echo '<pre>'; echo ($hoten_hs); echo '</pre>';
    // echo '<pre>'; echo ($ngaysinh); echo '</pre>';

    // Biến chứa lỗi
    $error = array();

    // Điều khiển lấy ra thông tin
    $show='show';

    // VI TRI 1: CODE SUBMIT FORM
// Nếu người dùng submit form
if (is_submit('edit_hs'))
{
    // Lấy danh sách dữ liệu từ form
    $mahs = input_post('mahs');
    $where = array('mahs'  => input_post('mahs'));
    
    $data = array(
        'hoten_hs'  =>input_post('hoten_hs'),
        'ngaysinh'  =>input_post('ngaysinh'),
        'gioitinh'  =>input_post('gioitinh'),
        'malop'     =>input_post('malop'),
        'diachi'    =>input_post('diachi'),
        'namhoc'    =>input_post('namhoc'),
        'hoten_bo'  =>input_post('hoten_bo'),
        'sdt_bo'    =>input_post('sdt_bo'),
        'hoten_me'  =>input_post('hoten_me'),
        'sdt_me'    =>input_post('sdt_me'),
        'update_by' =>$update_by
    );
    
    // require file xử lý database cho user
    require_once('database/user.php');
    
    // Thực hiện validate
    $error = db_hs_validate($data);

    // echo $error;
    // Nếu validate không có lỗi
    if (!$error)
    {       
        // Nếu update thành công thì thông báo
        // và chuyển hướng về trang danh sách hs
        if (db_update('hs_thongtin', $data, $where)){
            // $sqlreturn = db_update('hs_thongtin', $data, $where);
            // echo '<script language="javascript"> alert("'.$sqlreturn.'" ); </script>';
            ?>
            <script language="javascript">
                alert('Cập nhật thành công!');
                window.location = '<?php echo create_link(base_url('admin'), array('m' => 'hs', 'a' => 'list')); ?>';
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

<h1>Cập nhật thông tin học sinh</h1>

<div class="controls">
    <a class="button" onclick="$('#main-form-edit').submit()" href="#">Lưu</a>
    <a class="button" href="<?php echo create_link(base_url('admin'), array('m' => 'hs', 'a' => 'list')); ?>">Trở về</a>
</div>

<form id="main-form-edit" method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'hs', 'a' => 'edit')); ?>">
    <input type="hidden" name="request_name" value="edit_hs"/>

    <table cellspacing="0" cellpadding="0" class="form tb_update">
        
        <tr>
            <td>Mã học sinh</td>
            <td>
                <input readonly type="text" name="mahs" value="<?php if($show) {echo $mahs;} ?>" />
                <?php show_error($error, 'mahs'); ?>
            </td>
        </tr>
        <tr>
            <td>Họ tên học sinh</td>
            <td>
                <input type="text" name="hoten_hs" value="<?php if($show) {echo $hoten_hs;} ?>" />
                <?php show_error($error, 'hoten_hs'); ?>
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
            <td>Lớp</td>
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
            <td>Địa chỉ</td>
            <td>
                <input type="text" name="diachi" value="<?php if($show) {echo $diachi;} ?>" />
                <?php show_error($error, 'diachi'); ?>
            </td>
        </tr>

        <tr>
            <td>Họ tên bố</td>
            <td>
                <input type="text" name="hoten_bo" value="<?php if($show) {echo $hoten_bo;} ?>" />
                <?php show_error($error, 'hoten_bo'); ?>
            </td>
        </tr>

        <tr>
            <td>Số điện thoại bố</td>
            <td>
                <input type="text" name="sdt_bo" value="<?php if($show) {echo $sdt_bo;} ?>" />
                <?php show_error($error, 'sdt_bo'); ?>
            </td>
        </tr>

        <tr>
            <td>Họ tên mẹ</td>
            <td>
                <input type="text" name="hoten_me" value="<?php if($show) {echo $hoten_me;} ?>" />
                <?php show_error($error, 'hoten_me'); ?>
            </td>
        </tr>

        <tr>
            <td>Số điện thoại mẹ</td>
            <td>
                <input type="text" name="sdt_me" value="<?php if($show) {echo $sdt_me;} ?>" />
                <?php show_error($error, 'sdt_me'); ?>
            </td>
        </tr>

    </table>
</form>

<?php include_once('widgets/footer.php'); ?>