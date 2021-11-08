<?php if (!defined('IN_SITE')) die ('The request not found');
 
// Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
if (!is_logged()){
    redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
}

$magv = $_POST['filter-magv'];

?>

<?php include_once('widgets/header.php'); ?>
 
<?php // VỊ TRÍ 01: CODE XỬ LÝ PHÂN TRANG 
// Tìm tổng số records
    $sql = db_create_sql('SELECT count(id) as counter from gv_thongtin {where}', array('magv' => $magv));
    $result = db_get_row($sql);
    $total_records = $result['counter'];
    
    // Lấy trang hiện tại
    $current_page = input_get('page');
    
    // Lấy limit
    $limit = 10;
    
    // Lấy link
    $link = create_link(base_url('admin'), array(
        'm' => 'gv',
        'a' => 'list',
        'page' => '{page}'
    ));
    
    // Thực hiện phân trang
    $paging = paging($link, $total_records, $current_page, $limit);
    
    // Lấy danh sách gv
    $sql = db_create_sql("SELECT magv, hoten_gv, ngaysinh, gioitinh, chucvu, malop, namhoc, chuyennganh, sdt, diachi FROM gv_thongtin {where} LIMIT {$paging['start']}, {$paging['limit']}"
    , array('magv' => $magv));
    $gvs = db_get_list($sql);
?>
 
<h1>Danh sách giáo viên</h1>

<!-- Start: Lọc gv -->
<div class="filter filter-gv">
    <div class="filter-part filter__02">
        <form method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'gv', 'a' => 'filter-magv')); ?>">
            <input type="text" name="filter-magv" placeholder="Tìm theo mã giáo viên">
            <input class="btn" type="submit" value="Tìm kiếm">
        </form>
    </div>
    
    <div class="filter-part filter__03">
        <form method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'gv', 'a' => 'filter-hotengv')); ?>">
            <input type="text" name="filter-hotengv" placeholder="Tìm theo tên giáo viên">
            <input class="btn" type="submit" value="Tìm kiếm">
        </form>
    </div>

</div>
<!-- End: lọc gv -->

<div class="controls">
    <a class="button" href="<?php echo create_link(base_url('admin'), array('m' => 'gv', 'a' => 'list')); ?>">Hiện toàn bộ danh sách</a>
    <?php if(is_supper_admin()) { ?>
    <a class="button" href="<?php echo create_link(base_url('admin'), array('m' => 'gv', 'a' => 'add')); ?>">Thêm</a>
    <?php }; ?>
</div>

<div class="table-wrap">
<table cellspacing="0" cellpadding="0" class="form">
    <thead>
        <tr>
            <td>Mã giáo viên</td>
            <td>Họ tên giáo viên</td>
            <td>Ngày sinh</td>
            <td>Giới tính</td>
            <td>Chức vụ</td>
            <td>Chủ nhiệm lớp</td>
            <td>Năm học</td>
            <td>Chuyên ngành</td>
            <td>Số điện thoại</td>
            <td>Địa chỉ</td>
            <?php #if (is_supper_admin()){ ?>
            <td>Action</td>
            <?php #} ?>
        </tr>
    </thead>
    <tbody>
        <?php // VỊ TRÍ 02: CODE HIỂN THỊ NGƯỜI DÙNG ?>
        
        <?php foreach ($gvs as $item){ ?>
            <tr>
                <td><?php echo $item['magv']; ?></td>
                <td><?php echo $item['hoten_gv']; ?></td>
                <td><?php echo date("d/m/Y", strtotime($item['ngaysinh'])); ?></td>
                <td><?php echo $item['gioitinh']; ?></td>
                <td><?php echo $item['chucvu']; ?></td>
                <td><?php echo $item['malop']; ?></td>
                <td><?php echo $item['namhoc']; ?></td>
                <td><?php echo $item['chuyennganh']; ?></td>
                <td><?php echo $item['sdt']; ?></td>
                <td><?php echo $item['diachi']; ?></td>
                
                <td>
                    <?php if (is_supper_admin()){ ?>
                    <form method="POST" class="form-delete" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'gv', 'a' => 'delete')); ?>">
                        <a href="<?php echo create_link(base_url('admin'), array('m' => 'gv', 'a' => 'edit', 'magv' => $item['magv'])); ?>">Edit</a>
                        <!-- <input type="hidden" name="gv_magv_edit" value="<?php #echo $item['magv']; ?>"/> -->
                        <input type="hidden" name="gv_magv" value="<?php echo $item['magv']; ?>"/>
                        <input type="hidden" name="request_name" value="delete_gv"/>
                        <a href="#" class="btn-submit">Delete</a>
                    </form>
                    <?php } ?>

                    <form action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'message', 'a' => 'boxchat')); ?>">
                        <a class="button" href="<?php echo create_link(base_url('admin'), array('m' => 'message', 'a' => 'boxchat', 'contact' => $item['magv'])); ?>">Nhắn tin</a>
                    </form>
                </td>
            </tr>
        <?php } ?>

    </tbody>
</table>
</div>
 
<div class="pagination">
    <?php // VỊ TRÍ 03: CODE HIỂN THỊ CÁC NÚT PHÂN TRANG 
        echo $paging['html'];
    ?>
</div>
 
<?php include_once('widgets/footer.php'); ?>

<script language="javascript">
    $(document).ready(function(){
        // Nếu người dùng click vào nút delete
        // Thì submit form
        $('.btn-submit').click(function(){
            $(this).parent().submit();
            return false;
        });
 
        // Nếu sự kiện submit form xảy ra thì hỏi người dùng có chắc không?
        $('.form-delete').submit(function(){
            if (!confirm('Bạn có chắc muốn xóa giáo viên này không?')){
                return false;
            }
             
            // Nếu người dùng chắc chắn muốn xóa thì ta thêm vào trong form delete
            // một input hidden có giá trị là URL hiện tại, mục đích là giúp ở 
            // trang delete sẽ lấy url này để chuyển hướng trở lại sau khi xóa xong
            $(this).append('<input type="hidden" name="redirect" value="'+window.location.href+'"/>');
             
            // Thực hiện xóa
            return true;
        });
    });
</script>