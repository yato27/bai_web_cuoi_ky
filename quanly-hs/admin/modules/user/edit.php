<?php 
    if (!defined('IN_SITE')) die ('The request not found'); 

    // Thiết lập font chữ UTF8 để khỏi bị lõi font
    header('Content-Type: text/html; charset=utf-8');

    // Kiểm tra xem có quyền admin?, nếu không có quyền thì chuyển nó về trang logout
    if (!is_supper_admin()){
        redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
    }
?>

<?php

$username = input_get('username');

 // Lấy thông tin user
$sql = db_create_sql("SELECT `username`, `email`, `level` FROM tb_user {where}", array('username' => $username));
$user = db_get_row($sql);

$email = $user['email'];
$level = $user['level'];

echo $level;
    // Biến chứa lỗi
    $error = array();

    //Biến điều khiển lấy ra thông tin
    $show='show';

    // VI TRI 1: CODE SUBMIT FORM
// Nếu người dùng submit form
if (is_submit('edit_user'))
{
    // Lấy danh sách dữ liệu từ form
    $username = input_post('username');
    $where = array('username'  => input_post('username'));
    
    $data = array(
        'password'  => md5(input_post('password')),
        're-password'  => md5(input_post('re-password')),
        'email'     => input_post('email'),
        // 'fullname'  => input_post('fullname'),
        'level'     => input_post('level'),
    );
    
    // require file xử lý database cho user
    require_once('database/user.php');
    
    // Thực hiện validate
    $error = db_user_update_validate($data);
    
    // Nếu validate không có lỗi
    if (!$error)
    {
        // Xóa key re-password ra khỏi $data
        unset($data['re-password']);
        
        // Nếu insert thành công thì thông báo
        // và chuyển hướng về trang danh sách user
        if (db_update('tb_user', $data, $where)){
            // echo '<script language="javascript"> alert("'.$sqlreturn.'" ); </script>';
            ?>
            <script language="javascript">
                alert('Cập nhật người dùng thành công!');
                window.location = '<?php echo create_link(base_url('admin'), array('m' => 'user', 'a' => 'list')); ?>';
            </script>
            <?php
            die();
        }
    } 
    else {
        $show = '';
    }
}
?>


<?php include_once('widgets/header.php'); ?>

<h1>Cập nhật thành viên</h1>

<div class="controls">
    <a class="button" onclick="$('#main-form-edit').submit()" href="#">Lưu</a>
    <a class="button" href="<?php echo create_link(base_url('admin'), array('m' => 'user', 'a' => 'list')); ?>">Trở về</a>
</div>

<form id="main-form-edit" method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'user', 'a' => 'edit')); ?>">
    <input type="hidden" name="request_name" value="edit_user"/>


    <table cellspacing="0" cellpadding="0" class="form tb_update">
        <tr>
            <td width="200px">Tên đăng nhập</td>
            <td>
                <input readonly type="text" name="username" value="<?php if ($show) {echo $username;} ?>" />
                <?php show_error($error, 'username'); ?>
            </td>
        </tr>
        <tr>
            <td>Mật khẩu</td>
            <td>
                <input type="password" name="password" value="<?php #echo input_post('password'); ?>" />
                <?php show_error($error, 'password'); ?>
            </td>
        </tr>
        <tr>
            <td>Nhập lại mật khẩu</td>
            <td>
                <input type="password" name="re-password" value="<?php #echo input_post('re-password'); ?>" />
                <?php show_error($error, 're-password'); ?>
            </td>
        </tr>
        <tr>
            <td>Email</td>
            <td>
                <input type="text" name="email" value="<?php if ($show) {echo $email;} ?>" class="long" />
                <?php show_error($error, 'email'); ?>
            </td>
        </tr>
        <tr>
            <td>Level</td>
            <td>
                <select name="level">
                    <option value="">-- Chọn Level --</option>
                    <option value="1" <?php echo ($level == 1) ? 'selected' : ''; ?>>Admin</option>
                    <option value="2" <?php echo ($level == 2) ? 'selected' : ''; ?>>Member</option>
                </select>
                <?php show_error($error, 'level'); ?>
            </td>
        </tr>
    </table>
</form>

<?php include_once('widgets/footer.php'); ?>