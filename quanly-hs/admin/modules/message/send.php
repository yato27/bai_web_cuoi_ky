<?php 
    if (!defined('IN_SITE')) die ('The request not found'); 

    // Thiết lập font chữ UTF8 để khỏi bị lõi font
    header('Content-Type: text/html; charset=utf-8');

    // Kiểm tra xem có quyền user?, nếu không có quyền thì chuyển nó về trang logout
    if (!is_logged()){
        redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
    }
?>

<?php
    // Lấy danh sách dữ liệu từ form
    $newmessage = input_post('newmessage');
    $content = input_post('message-content');
    $contact = input_post('contact');
    $username = is_logged()['username'];
    $content = input_post('message-content');

    $data = array(
        'nguoigui'  => $username,
        'nguoinhan' => $contact,
        'message'   => $newmessage,
    );

    // require file xử lý database cho user
    require_once('database/user.php');
    
    // Thực hiện validate
    // $error = db_message_validate($data);
    $error ='';

    // Nếu validate không có lỗi
    if (!$error)
    {       
        // Nếu insert thành công thì chuyển hướng về trang boxchat
        if (db_insert('tb_message', $data)){
            ?>
            <script language="javascript">
                // alert('Gửi tin nhắn thành công!');
                window.location = '<?php echo create_link(base_url('admin'), array('m' => 'message', 'a' => 'boxchat', 'contact' => $contact)); ?>';
            </script>
            <?php
            die();
        }
    }

?>



