<?php 
    if (!defined('IN_SITE')) die ('The request not found'); 

    // Thiết lập font chữ UTF8 để khỏi bị lõi font
    header('Content-Type: text/html; charset=utf-8');

    // Kiểm tra xem có quyền admin?, nếu không có quyền thì chuyển nó về trang logout
    if (!is_admin()){
        redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
    }

    // Lấy username
    $username = is_logged()['username'];
?>

<?php

$diemid = input_get('id');

 // Lấy thông tin hs
    $sql = db_create_sql("SELECT hs_diem.id, hs_diem.mahs, hoten_hs, ngaysinh, gioitinh, malop, monhoc.mamh, namhoc, diem1, diem2, diem3, diem4, diem5, diem6 
    FROM  hs_diem INNER JOIN hs_thongtin on hs_thongtin.mahs = hs_diem.mahs INNER JOIN monhoc on monhoc.mamh = hs_diem.mamh {where} ", array('hs_diem.id' => $diemid));

// echo $sql;
    $diems = db_get_list($sql);
    $diem = $diems[0];

    // $id = $diem['id'];
    $mahs = $diem['mahs'];
    $hoten_hs = $diem['hoten_hs'];
    $ngaysinh = $diem['ngaysinh'];
    $gioitinh = $diem['gioitinh'];
    $malop = $diem['malop'];
    $mamh = $diem['mamh'];
    $namhoc = $diem['namhoc'];
    $diem1 = $diem['diem1'];
    $diem2 = $diem['diem2'];
    $diem3 = $diem['diem3'];
    $diem4 = $diem['diem4'];
    $diem5 = $diem['diem5'];
    $diem6 = $diem['diem6'];
    
    
    // Biến chứa lỗi
    $error = array();

    // Điều khiển lấy ra thông tin
    $show='show';

    // VI TRI 1: CODE SUBMIT FORM
// Nếu người dùng submit form
if (is_submit('edit_diem'))
{
    // Lấy id của điểm
    $id = $_POST['diem_id'];
    
    // $where = array('id'  => input_post('id'));
    $where = array('id'  => $id);
    
    $data = array(
        'mahs'      =>input_post('mahs'),
        'mamh'      =>input_post('mamh'),
        'diem1'     =>input_post('diem1'),
        'diem2'     =>input_post('diem2'),
        'diem3'     =>input_post('diem3'),
        'diem4'     =>input_post('diem4'),
        'diem5'     =>input_post('diem5'),
        'diem6'     =>input_post('diem6'),
        'update_by' =>$username
    );
    
    // require file xử lý database cho user
    require_once('database/user.php');
    
    // Thực hiện validate
    $error = db_diem_validate($data);
 
    // Nếu không có lỗi
    if (!$error)
    {       
        // Nếu update thành công thì thông báo
        // và chuyển hướng về trang danh sách hs
        if (db_update('hs_diem', $data, $where)){
            
            ?>
            <script language="javascript">
                alert('Cập nhật thành công!');
                window.location = '<?php echo create_link(base_url('admin'), array('m' => 'diem', 'a' => 'list')); ?>';
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

<h1>Cập nhật thông tin điểm của học sinh</h1>

<div class="controls">
    <a class="button" onclick="$('#main-form-edit').submit()" href="#">Lưu</a>
    <a class="button" href="<?php echo create_link(base_url('admin'), array('m' => 'diem', 'a' => 'list')); ?>">Trở về</a>
</div>

<form id="main-form-edit" method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'diem', 'a' => 'edit')); ?>">
    <input type="hidden" name="request_name" value="edit_diem"/>

    <table cellspacing="0" cellpadding="0" class="form tb_update">

        <input type="hidden" name="diem_id" value="<?php echo $diemid; ?>" />
    
        <tr>
            <td>Mã học sinh</td>
            <td>
                <input  type="text" name="mahs" value="<?php if($show) {echo $mahs;} ?>" />
                <?php show_error($error, 'mahs'); ?>
            </td>
        </tr>
        <tr>
            <td>Họ tên học sinh</td>
            <td>
                <input readonly type="text" name="hoten_hs" value="<?php if($show) {echo $hoten_hs;} ?>" />
                <?php show_error($error, 'hoten_hs'); ?>
            </td>
        </tr>
        <tr>
            <td>Ngày sinh</td>
            <td>
                <input readonly type="date" name="ngaysinh" value="<?php if($show) {echo $ngaysinh;} ?>" />

                <?php show_error($error, 'ngaysinh'); ?>
            </td>
        </tr>

        <tr>
            <td>Giới tính</td>
            <td>
                <select readonly name="gioitinh">
                    <option value="">-- Chọn Giới tính --</option>
                    <option selected value="Nam" <?php if($show) {echo ($gioitinh == 'Nam') ? 'selected' : ''; }?>>Nam</option>
                    <option value="Nữ" <?php if($show) {echo ($gioitinh == 'Nữ') ? 'selected' : ''; }?>>Nữ</option>
                </select>
                <?php show_error($error, 'gioitinh'); ?>
            </td>
        </tr>

        <tr>
            <td>Lớp</td>
            <td>
                <input readonly type="text" name="malop" value="<?php if($show) {echo $malop;}; ?>" />
                <?php show_error($error, 'malop'); ?>
            </td>
        </tr>

        <tr>
            <td>Môn học</td>
            <td>
                <input type="text" name="mamh" value="<?php if($show) {echo $mamh;}; ?>" />
                <?php show_error($error, 'mamh'); ?>
            </td>
        </tr>

        <tr>
            <td>Năm học</td>
            <td>
                <input readonly type="text" name="namhoc" value="<?php if($show) {echo $namhoc;}; ?>" />
                <?php show_error($error, 'namhoc'); ?>
            </td>
        </tr>

        <tr>
            <td>Điểm 15' HK1</td>
            <td>
                <input type="text" name="diem1" value="<?php if($show) {echo $diem1;}; ?>" />
                <?php show_error($error, 'diem1'); ?>
            </td>
        </tr>

        <tr>
            <td>Điểm 45' HK1</td>
            <td>
                <input type="text" name="diem2" value="<?php if($show) {echo $diem2;};  ?>" />
                <?php show_error($error, 'diem2'); ?>
            </td>
        </tr>

        <tr>
            <td>Điểm thi HK1</td>
            <td>
                <input type="text" name="diem3" value="<?php if($show) {echo $diem3;};  ?>" />
                <?php show_error($error, 'diem3'); ?>
            </td>
        </tr>

        <tr>
            <td>Điểm 15' HK2</td>
            <td>
                <input type="text" name="diem4" value="<?php if($show) {echo $diem4;}; ?>" />
                <?php show_error($error, 'diem4'); ?>
            </td>
        </tr>

        <tr>
            <td>Điểm 45' HK2</td>   
            <td>
                <input type="text" name="diem5" value="<?php if($show) {echo $diem5;} ?>" />
                <?php show_error($error, 'diem5'); ?>
            </td>
        </tr>

        <tr>
            <td>Điểm thi HK2</td>   
            <td>
                <input type="text" name="diem6" value="<?php if($show) {echo $diem6;} ?>" />
                <?php show_error($error, 'diem6'); ?>
            </td>
        </tr>

    </table>
</form>

<?php include_once('widgets/footer.php'); ?>