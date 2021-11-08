<?php 
    if (!defined('IN_SITE')) die ('The request not found'); 

    // Thiết lập font chữ UTF8 để khỏi bị lõi font
    header('Content-Type: text/html; charset=utf-8');

    // Kiểm tra xem có quyền, nếu không có quyền thì chuyển nó về trang logout
    if (!is_logged()){
        redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
    }
?>

<?php

$contact = input_get('contact');
$username = is_logged()['username'];

$newcontact = input_post('newcontact');
// echo $newcontact.'new-contact';
if (!$contact) {
    $contact = $newcontact;
};

if ($username == $contact) {
    redirect(create_link(base_url('admin'), array('m' => 'message', 'a' => 'error')));
}

// Update trạng thái tin nhắn từ unread->seen
$data = array('trangthai' => 'seen');
$where = array('nguoigui' => $contact, 'nguoinhan' => $username);
db_update('tb_message', $data, $where);

?>

<!-- Start: show 2 bảng tin nhắn mới và tin nhắn đã đọc -->
<?php include_once('widgets/header.php'); ?>
 
<?php 
    // Lấy ds tin nhắn
    $sql = db_create_sql("SELECT `id`, `nguoigui`, `nguoinhan`, `message`, `trangthai`, `sendtime` FROM `tb_message` 
    WHERE (nguoigui = '".$username."' AND nguoinhan = '".$contact."') OR (nguoigui = '".$contact."' AND nguoinhan = '".$username."')
    ORDER BY id DESC LIMIT 20");
                        
    $messages = db_get_list($sql);
    // echo 'contacts: '.$contacts;
    // echo '<pre>'; print_r($messages); echo '</pre>';
?>

<h1>Thao tác với tin nhắn:</h1>

<div class="message-options">
    <div class="all-message">
        <form method="post"  action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'message', 'a' => 'all')); ?>">
            <!-- <input type="text" name="newcontact" /> -->
            <input class="btn" type="submit" value="Xem tất cả các cuộc trò chuyện">                               
        </form>
    </div>

    <div class="new-message">
        <form method="post"  action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'message', 'a' => 'boxchat')); ?>">
            <input type="text" name="newcontact"  placeholder="Nhập mã của người liên hệ" />
            <input class="btn" type="submit" value="Trò chuyện">                               
        </form>
    </div>

    
    <div class="help-message">
        <form action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'message', 'a' => 'boxchat')); ?>">
        <p>Cần trợ giúp?   
            <a  href="<?php echo create_link(base_url('admin'), array('m' => 'message', 'a' => 'boxchat', 'contact' => 'admin')); ?>">Gửi tin nhắn cho admin</a>
        </p> 
        </form>
    </div>
</div>

<h1>Cuộc trò truyện với <?php echo $contact; ?>:</h1>

<table cellspacing="0" cellpadding="0" class="form">
    <thead>
        <tr>
            <td>Người gửi</td>
            <td>Tin nhắn</td>
            <td>Thời gian gửi</td>
        </tr>
    </thead>
    <tbody>
        <?php //Hiển thị tin nhắn ?>
        
        <?php #foreach ($messages as $item){ ?>
        <?php for ($index = count($messages)-1; $index >=0 ; $index--) {
            $item = $messages[$index];
        ?>
            <tr>
                <td><?php echo $item['nguoigui']; ?></td>
                <td><?php echo $item['message']; ?></td>
                <td><?php echo $item['sendtime']; ?></td>
            </tr>
        <?php } ?>

    </tbody>
</table>
 
<div class="send-message">
    <form method="post" class="form-send" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'message', 'a' => 'send')); ?>">
        <!-- <textarea name="message-content" id="" cols="30" rows="10"></textarea> -->
        <input class="new-message" type="text" name="newmessage" id="">
        <input type="hidden" name="username" value="<?php echo $username; ?>"/>
        <input type="hidden" name="contact" value="<?php echo $contact; ?>"/>

        <input class="btn" type="submit" value="Gửi tin nhắn">
    </form>
</div>

<?php include_once('widgets/footer.php'); ?>