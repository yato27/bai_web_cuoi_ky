<?php if (!defined('IN_SITE')) die ('The request not found');
 
// Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
if (!is_logged()){
    redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
}

$contact = input_get('contact');
$username = is_logged()['username'];

// echo $username;
// echo ' chat with '.$contact;

// echo '<pre>'; print_r(is_logged()); echo '</pre>';
?>

<!-- Start: show 2 bảng tin nhắn mới và tin nhắn đã đọc -->
<?php include_once('widgets/header.php'); ?>
 
<?php // VỊ TRÍ 01: CODE XỬ LÝ PHÂN TRANG 
// Tìm tổng số records
    $sql = "SELECT COUNT(c.nguoigui) as 'counter' FROM (
                SELECT DISTINCT `nguoigui` FROM `tb_message`  WHERE (nguoinhan = '".$username."') AND (trangthai = 'unread') 
            ) as c;";
    $result = db_get_row($sql);
    $total_records = $result['counter'];
    
    // Lấy trang hiện tại
    $current_page = input_get('page');
    
    // Lấy limit
    $limit = 10;
    
    // Lấy link
    $link = create_link(base_url('admin'), array(
        'm' => 'message',
        'a' => 'list',
        'page' => '{page}'
    ));
    
    // Thực hiện phân trang
    $paging = paging($link, $total_records, $current_page, $limit);
    
    // Lấy danh sách người gửi tin nhắn mới cho user
    $sql = db_create_sql("SELECT DISTINCT `nguoigui` FROM `tb_message` 
                        WHERE (nguoinhan = '".$username."') AND (trangthai = 'unread')
                        ORDER BY id DESC LIMIT {$paging['start']}, {$paging['limit']}");
    $nguoiguis = db_get_list($sql);

    // echo 'contacts: '.$contacts;
    // echo '<pre>'; print_r($nguoiguis); echo '</pre>';
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

<?php if (!$total_records) { ?>
    <h1>Bạn không có tin nhắn mới!</h1>
<?php } else { ?>
    <h1>Bạn có tin nhắn mới đến từ:</h1>
<table cellspacing="0" cellpadding="0" class="form">
    <thead>
        <tr>
            <td>Người gửi</td>
            <td>Action</td>
        </tr>
    </thead>
    <tbody>
        <?php // VỊ TRÍ 02: CODE HIỂN THỊ NGƯỜI DÙNG ?>
        
        <?php foreach ($nguoiguis as $item){ ?>
            <tr>
                <td><?php echo $item['nguoigui']; ?></td>

                <td>
                    <form action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'message', 'a' => 'boxchat')); ?>">
                        <a class="button" href="<?php echo create_link(base_url('admin'), array('m' => 'message', 'a' => 'boxchat', 'contact' => $item['nguoigui'])); ?>">Xem tin nhắn</a>
                    </form>
                </td>
            </tr>
        <?php } ?>

    </tbody>
</table>
 
<div class="pagination">
    <?php // VỊ TRÍ 03: CODE HIỂN THỊ CÁC NÚT PHÂN TRANG 
        echo $paging['html'];
    ?>
</div>

<?php }; ?>

<?php include_once('widgets/footer.php'); ?>


