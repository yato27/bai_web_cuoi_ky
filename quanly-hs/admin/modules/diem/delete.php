<?php 
    if (!defined('IN_SITE')) die ('The request not found');
    
    // Thiết lập font chữ UTF8 để khỏi bị lõi font
    header('Content-Type: text/html; charset=utf-8');
    
    // Kiểm tra quyền, nếu không có quyền thì chuyển nó về trang logout
    if (!is_admin()){
        redirect(base_url('admin'), array('m' => 'common', 'a' => 'logout'));
    }
    
    // Nếu người dùng submit delete user
    if (is_submit('delete_diem'))
    {
        // Lấy mahs
        $id = input_post('diem_id');
        

        if ($id)
        {
            $sql = db_create_sql('DELETE FROM hs_diem {where}', array(
                'id' => $id
            ));

            if (db_execute($sql)){
                ?>
                <script language="javascript">
                    alert('Xóa thành công!');
                    window.location = '<?php echo input_post('redirect'); ?>';
                </script>
                <?php
            }
            else{
                ?>
                <script language="javascript">
                    alert('Xóa thất bại!');
                    window.location = '<?php echo input_post('redirect'); ?>';
                </script>
                <?php
            }
        }
    }
    else{
        // Nếu không phải submit delete user thì chuyển về trang chủ
        redirect(base_url('admin'));
    }

?>