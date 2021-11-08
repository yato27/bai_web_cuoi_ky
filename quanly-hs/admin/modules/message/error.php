<?php 
    if (!defined('IN_SITE')) die ('The request not found'); 

    // Thiết lập font chữ UTF8 để khỏi bị lõi font
    header('Content-Type: text/html; charset=utf-8');

    // Kiểm tra xem có quyền, nếu không có quyền thì chuyển nó về trang logout
    if (!is_logged()){
        redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
    }

?>

<?php include_once('widgets/header.php'); ?>

<div class="error-wrap">
    <div class="message-error">
        Bạn không thể gửi tin nhắn cho chính mình! <br>
        Hãy thử một cuộc trò chuyện mới.
    </div>

    <div class="new-message error">
        <form method="post"  action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'message', 'a' => 'boxchat')); ?>">
            <input type="text" name="newcontact"  placeholder="Nhập mã của người liên hệ"/>
            <input type="submit" value="Trò chuyện">                               
        </form>
    </div>
</div>

<?php include_once('widgets/footer.php'); ?>