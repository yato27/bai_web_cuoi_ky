<?php if (!defined('IN_SITE')) die ('The request not found');
 
// Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
if (!is_logged()){
    redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
}

$mamh_filter = $_POST['filter-monhoc'];
// echo $mamh;

?>
 
 <?php include_once('widgets/header.php'); ?>
 
 <?php // VỊ TRÍ 01: CODE XỬ LÝ PHÂN TRANG 
 // Tìm tổng số records
    $sql = db_create_sql('SELECT count(id) as counter from hs_diem {where}', array('hs_diem.mamh' => $mamh_filter));
    $result = db_get_row($sql);
    $total_records = $result['counter'];
    
    // Lấy trang hiện tại
    $current_page = input_get('page');
    
    // Lấy limit
    $limit = 10;
    
    // Lấy link
    $link = create_link(base_url('admin'), array(
        'm' => 'diem',
        'a' => 'list',
        'page' => '{page}'
    ));
    
    // Thực hiện phân trang
    $paging = paging($link, $total_records, $current_page, $limit);
    
    // Lấy danh sách điểm
    $sql = db_create_sql("SELECT hs_diem.id, hs_diem.mahs, hoten_hs, ngaysinh, gioitinh, malop, tenmh, namhoc, diem1, diem2, diem3, diem4, diem5, diem6, hs_diem.update_by, hs_diem.update_time 
    FROM  hs_diem INNER JOIN hs_thongtin on hs_thongtin.mahs = hs_diem.mahs INNER JOIN monhoc on monhoc.mamh = hs_diem.mamh  {where} ORDER BY malop ASC, monhoc.mamh ASC, mahs ASC  LIMIT {$paging['start']}, {$paging['limit']}"
    , array('hs_diem.mamh' => $mamh_filter));
    $diems = db_get_list($sql);

    // Lấy ds lớp
    $sql_lop = db_create_sql("SELECT DISTINCT malop FROM hs_thongtin WHERE malop <> ''");
    $lops = db_get_list($sql_lop);
    
    // Lấy ds môn học
    $sql_monhoc = db_create_sql("SELECT DISTINCT monhoc.mamh, monhoc.tenmh FROM hs_diem INNER JOIN monhoc ON monhoc.mamh = hs_diem.mamh
    WHERE monhoc.mamh <> '' ORDER BY monhoc.mamh ASC;");
    $monhocs = db_get_list($sql_monhoc);

 ?>
  
 <h1>Danh sách điểm của học sinh</h1>
 
 <!-- Start: Lọc hs -->
 <div class="filter">
     <div class="filter-part filter__01">
         <form class="form" method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'diem', 'a' => 'filter-malop')); ?>">
             <select name="filter-malop">
                 <option selected value="">-- Chọn Lớp --</option>
                 <?php foreach ($lops as $lop){ ?>
                 <option value="<?php echo $lop['malop'];?>" ><?php echo $lop['malop'];?></option>
                 <?php } ?>
             </select>
             <input class="btn" type="submit" value="Lọc theo lớp">
         </form>

         <form class="form" method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'diem', 'a' => 'filter-monhoc')); ?>">
            <select name="filter-monhoc">
                <option selected value="">-- Chọn Môn học --</option>
                <?php foreach ($monhocs as $monhoc){ ?>
                <option value="<?php echo $monhoc['mamh'];?>" <?php echo ($monhoc['mamh'] == $mamh_filter) ? 'selected' : ''; ?> ><?php echo $monhoc['tenmh'];?></option>
                <?php } ?>
            </select>
            <input class="btn" type="submit" value="Lọc theo môn">
        </form>
     </div>
 
     <div class="filter-part filter__02">
         <form method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'diem', 'a' => 'filter-mahs')); ?>">
             <input type="text" name="filter-mahs" placeholder="Tìm theo mã học sinh">
             <input class="btn" type="submit" value="Tìm kiếm">
         </form>
     </div>
     
     <div class="filter-part filter__03">
         <form method="post" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'diem', 'a' => 'filter-hotenhs')); ?>">
             <input type="text" name="filter-hotenhs" placeholder="Tìm theo tên học sinh">
             <input class="btn" type="submit" value="Tìm kiếm">
         </form>
     </div>
 
 </div>
 <!-- End: lọc hs -->
 
 <?php if (is_admin()){ ?>
 <div class="controls">
    <a class="button" href="<?php echo create_link(base_url('admin'), array('m' => 'diem', 'a' => 'list')); ?>">Hiện toàn bộ danh sách</a>

    <a class="button" href="<?php echo create_link(base_url('admin'), array('m' => 'diem', 'a' => 'add')); ?>">Thêm</a>
 </div>
 <?php } ?>
 
 <div class="table-wrap">
 <table cellspacing="0" cellpadding="0" class="form">
     <thead>
         <tr>
             
             <td>Mã học sinh</td>
             <td>Họ tên học sinh</td>
             <td>Ngày sinh</td>
             <td>Giới tính</td>
             <td>Lớp</td>
             <td>Môn học</td>
             <td>Năm học</td>
             <td>Điểm 15' HK1</td>
             <td>Điểm 45' HK1</td>
             <td>Điểm thi HK1</td>
             <td>TBM HK1</td>
             <td>Điểm 15' HK2</td>
             <td>Điểm 45' HK2</td>
             <td>Điểm thi HK2</td>
             <td>TBM HK2</td>
             <td>TBM cả năm</td>
             <td>Cập nhật bởi</td>
             <td>Thời gian cập nhật</td>
 
             <?php if (is_admin()){ ?>
             <td>Action</td>
             <?php } ?>
         </tr>
     </thead>
     <tbody>
         <?php // VỊ TRÍ 02: CODE HIỂN THỊ NGƯỜI DÙNG ?>
         
             <?php foreach ($diems as $item){ 
                 $tbm1 = round(($item['diem1'] + $item['diem2'] + $item['diem3'])/3, 1);
                 $tbm2 = round(($item['diem4'] + $item['diem5'] + $item['diem6'])/3, 1);
                 $tbmcn = round(($tbm1 + $tbm2)/2, 1);
             ?>
             <tr>
                 <td><?php echo $item['mahs']; ?></td>
                 <td><?php echo $item['hoten_hs']; ?></td>
                 <td><?php echo date("d/m/Y", strtotime($item['ngaysinh'])); ?></td>
                 <td><?php echo $item['gioitinh']; ?></td>
                 <td><?php echo $item['malop']; ?></td>
                 <td><?php echo $item['tenmh']; ?></td>
                 <td><?php echo $item['namhoc']; ?></td>
                 <td><?php echo $item['diem1']; ?></td>
                 <td><?php echo $item['diem2']; ?></td>
                 <td><?php echo $item['diem3']; ?></td>
                 <td><?php echo $tbm1; ?></td>
                 <td><?php echo $item['diem4']; ?></td>
                 <td><?php echo $item['diem5']; ?></td>
                 <td><?php echo $item['diem6']; ?></td>
                 <td><?php echo $tbm2; ?></td>
                 <td><?php echo $tbmcn; ?></td>
                 <td><?php echo $item['update_by']; ?></td>
                 <td><?php echo date("d/m/Y", strtotime($item['update_time'])); ?></td>

                 <?php if (is_admin()){ ?>
                 <td>
                     <form method="POST" class="form-delete" action="<?php echo create_link(base_url('admin/index.php'), array('m' => 'diem', 'a' => 'delete')); ?>">
                         <a href="<?php echo create_link(base_url('admin'), array('m' => 'diem', 'a' => 'edit', 'id' => $item['id'])); ?>">Edit</a>
                         <input type="hidden" name="diem_id" value="<?php echo $item['id']; ?>"/>
                         <input type="hidden" name="diem_mahs" value="<?php echo $item['mahs']; ?>"/>
                         <input type="hidden" name="request_name" value="delete_diem"/>
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