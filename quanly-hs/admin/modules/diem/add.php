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
    
    // Nếu validate không có lỗi
    if (!$error)
    {        
        // Nếu add thành công thì thông báo
        // và chuyển hướng về trang danh sách user
        if (db_insert('hs_diem', $data)){
            ?>
            <script language="javascript">
                alert('Thêm điểm thành công!');
                window.location = '<?php echo create_link(base_url('admin'), array('m' => 'diem', 'a' => 'list')); ?>';
            </script>
            <?php
            die();
        }
    }
}

?>

<?php include_once('widgets/header.php'); ?>

<h1>Thêm điểm</h1>

<div class="controls">
    <a class="button" onclick="$('#main-form').submit()" href="#">Lưu</a>
    <a class="button" href="<?php echo create_link(base_url('admin'), array('m' => 'diem', 'a' => 'list')); ?>">Trở về</a>
</div>

<form id="main-form" method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'diem', 'a' => 'add')); ?>">
    <input type="hidden" name="request_name" value="add_hs"/>
    
    <table cellspacing="0" cellpadding="0" class="form tb_update">
        
        <tr>
            <td>Mã học sinh</td>
            <td>
                <input type="text" name="mahs" value="<?php echo input_post('mahs'); ?>" />
                <?php show_error($error, 'mahs'); ?>
            </td>
        </tr>
     
        <tr>
            <td>Môn học</td>
            <td>
                <input type="text" name="mamh" value="<?php echo input_post('mamh'); ?>" />
                <?php show_error($error, 'mamh'); ?>
            </td>
        </tr>

        <tr>
            <td>Điểm 15' HK1</td>
            <td>
                <input type="text" name="diem1" value="<?php echo input_post('diem1'); ?>" />
                <?php show_error($error, 'diem1'); ?>
            </td>
        </tr>

        <tr>
            <td>Điểm 45' HK1</td>
            <td>
                <input type="text" name="diem2" value="<?php echo input_post('diem2'); ?>" />
                <?php show_error($error, 'diem2'); ?>
            </td>
        </tr>

        <tr>
            <td>Điểm thi HK1</td>
            <td>
                <input type="text" name="diem3" value="<?php echo input_post('diem3'); ?>" />
                <?php show_error($error, 'diem3'); ?>
            </td>
        </tr>

        <tr>
            <td>Điểm 15' HK2</td>
            <td>
                <input type="text" name="diem4" value="<?php echo input_post('diem4'); ?>" />
                <?php show_error($error, 'diem4'); ?>
            </td>
        </tr>

        <tr>
            <td>Điểm 45' HK2</td>   
            <td>
                <input type="text" name="diem5" value="<?php echo input_post('diem5'); ?>" />
                <?php show_error($error, 'diem5'); ?>
            </td>
        </tr>

        <tr>
            <td>Điểm thi HK2</td>   
            <td>
                <input type="text" name="diem6" value="<?php echo input_post('diem6'); ?>" />
                <?php show_error($error, 'diem6'); ?>
            </td>
        </tr>

    </table>
</form>

<?php include_once('widgets/footer.php'); ?>