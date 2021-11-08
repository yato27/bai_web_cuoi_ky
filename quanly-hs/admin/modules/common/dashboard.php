<?php if (!defined('IN_SITE')) die ('The request not found'); 

// Ktra đã đăng nhập chưa? Nếu chưa thì chuyển về trang login
if (!is_logged()) {
    redirect(create_link(base_url('admin'), array('m' => 'common', 'a' => 'login')));
}



?>
<?php include_once('widgets/header.php'); ?>
<h1 class="welcome">Chào mừng bạn đến với hệ thống quản lý học sinh</h1>
<h1 class="welcome">của tập thể Black Flash Team</h1>
<img style="width: 100%;" src="<?php echo (base_url('assets/img/teamflash.png'))?>" alt="team flash icon" srcset="">
<?php include_once('widgets/footer.php'); ?>