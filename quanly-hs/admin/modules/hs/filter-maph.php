<?php 
    $maph = $_POST['filter-maph'];
?>

<?php if (!defined('IN_SITE')) die ('The request not found');
 
// Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
if (!is_logged()){
    redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
}
?>
 
<?php include_once('widgets/header.php'); ?>
 
<?php 
    // VỊ TRÍ 01: CODE XỬ LÝ PHÂN TRANG 
    // Tìm tổng số records
    $sql = db_create_sql('SELECT count(id) as counter from hs_thongtin {where}', array('maph' => $maph));
    $result = db_get_row($sql);
    $total_records = $result['counter'];

    // $total_records = $hss['counter'];

    
    // Lấy trang hiện tại
    $current_page = input_get('page');
    
    // Lấy limit
    $limit = 10;
    
    // Lấy link
    $link = create_link(base_url('admin'), array(
        'm' => 'hs',
        'a' => 'list',
        'page' => '{page}'
    ));
    
    // Thực hiện phân trang
    $paging = paging($link, $total_records, $current_page, $limit);

    // Lấy danh sách hs
    $sql = db_create_sql("SELECT mahs,hoten_hs,ngaysinh,gioitinh,malop,namhoc,diachi,maph,hoten_bo,sdt_bo,hoten_me,sdt_me, hs_thongtin.update_by, hs_thongtin.update_time
    FROM hs_thongtin {where} ORDER BY malop ASC, mahs ASC, namhoc ASC  LIMIT {$paging['start']}, {$paging['limit']}"
    , array('maph' => $maph ));
    $hss = db_get_list($sql);
    
    // Lấy ds lớp
    $sql_lop = db_create_sql("SELECT DISTINCT malop FROM hs_thongtin WHERE malop <> ''");
    $lops = db_get_list($sql_lop);

?>
 
<h1>Danh sách học sinh</h1>

<!-- Start: Lọc hs -->
<div class="filter">
    <div class="filter-part filter__01">
        <form class="form" method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'hs', 'a' => 'filter-malop')); ?>">
            <select name="filter-malop">
                <option selected value="">-- Chọn Lớp --</option>
                <?php foreach ($lops as $lop){ ?>
                <option value="<?php echo $lop['malop'];?>"><?php echo $lop['malop'];?></option>
                <?php } ?>
            </select>
            <input class="btn" type="submit" value="Lọc theo lớp">
        </form>
    </div>

    <div class="filter-part filter__02">
        <form method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'hs', 'a' => 'filter-mahs')); ?>">
            <input type="text" name="filter-mahs" placeholder="Tìm theo mã học sinh">
            <input class="btn" type="submit" value="Tìm kiếm">
        </form>
        
        <form method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'hs', 'a' => 'filter-hotenhs')); ?>">
            <input type="text" name="filter-hotenhs" placeholder="Tìm theo tên học sinh">
            <input class="btn" type="submit" value="Tìm kiếm">
        </form>
    </div>

    <div class="filter-part filter__03">
        <form method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'hs', 'a' => 'filter-maph')); ?>">
            <input type="text" name="filter-maph" placeholder="Tìm theo mã phụ huynh">
            <input class="btn" type="submit" value="Tìm kiếm">
        </form>
        
        <form method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'hs', 'a' => 'filter-hotenph')); ?>">
            <input type="text" name="filter-hotenph" placeholder="Tìm theo tên phụ huynh">
            <input class="btn" type="submit" value="Tìm kiếm">
        </form>
    </div>
</div>
<!-- End: lọc hs -->

<div class="controls">
    <a class="button" href="<?php echo create_link(base_url('admin'), array('m' => 'hs', 'a' => 'list')); ?>">Hiện toàn bộ danh sách</a>
    
    <?php if(is_admin()) { ?>
    <a class="button" href="<?php echo create_link(base_url('admin'), array('m' => 'hs', 'a' => 'add')); ?>">Thêm</a>
    <?php }; ?>

</div>
<div class="table-wrap">
<table cellspacing="0" cellpadding="0" class="form">
    <thead>
        <tr>
            <td>Mã học sinh</td>
            <td>Họ tên học sinh</td>
            <td>Ngày sinh</td>
            <td>Giới tính</td>
            <td>Lớp</td>
            <td>Năm học</td>
            <td>Địa chỉ</td>
            <td>Mã PH</td>
            <td>Họ tên bố</td>
            <td>Sđt bố</td>
            <td>Họ tên mẹ</td>
            <td>Sđt mẹ</td>
            <td>Cập nhật bởi</td>
            <td>Thời gian cập nhật</td>
            
            <?php if (is_admin()){ ?>
            <td>Action</td>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php // VỊ TRÍ 02: CODE HIỂN THỊ NGƯỜI DÙNG ?>
        
        <?php foreach ($hss as $item){ ?>
            <tr>
                <td><?php echo $item['mahs']; ?></td>
                <td><?php echo $item['hoten_hs']; ?></td>
                <td><?php echo date("d/m/Y", strtotime($item['ngaysinh'])); ?></td>
                <td><?php echo $item['gioitinh']; ?></td>
                <td><?php echo $item['malop']; ?></td>
                <td><?php echo $item['namhoc']; ?></td>
                <td><?php echo $item['diachi']; ?></td>
                <td><?php echo $item['maph']; ?></td>
                <td><?php echo $item['hoten_bo']; ?></td>
                <td><?php echo $item['sdt_bo']; ?></td>
                <td><?php echo $item['hoten_me']; ?></td>
                <td><?php echo $item['sdt_me']; ?></td>
                <td><?php echo $item['update_by']; ?></td>
                <td><?php echo date("d/m/Y", strtotime($item['update_time'])); ?></td>

                <?php if (is_supper_admin()){ ?>
                <td>
                    <form method="POST" class="form-delete" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'hs', 'a' => 'delete')); ?>">
                        <a href="<?php echo create_link(base_url('admin'), array('m' => 'hs', 'a' => 'edit', 'mahs' => $item['mahs'])); ?>">Edit</a>
                        <!-- <input type="hidden" name="hs_mahs_edit" value="<?php #echo $item['mahs']; ?>"/> -->
                        <input type="hidden" name="hs_mahs" value="<?php echo $item['mahs']; ?>"/>
                        <input type="hidden" name="request_name" value="delete_hs"/>
                        <a href="#" class="btn-submit">Delete</a>
                    </form>
                </td>
                <?php } ?>
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
            if (!confirm('Bạn có chắc muốn xóa học sinh này không?')){
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