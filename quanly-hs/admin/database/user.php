<!-- chứa hàm xử lý dữ liệu trong db -->
<?php if (!defined('IN_SITE')) die ('The request not found');
 
function db_user_get_by_username($username){
    $username = addslashes($username);
    $sql = "SELECT * FROM tb_user where username = '{$username}'";
    return db_get_row($sql);
}

// Hàm validate dữ liệu bảng User
function db_user_validate($data)
{
    // Biến chứa lỗi
    $error = array();
    
    /* VALIDATE CĂN BẢN */
    // Username
    if (isset($data['username']) && $data['username'] == ''){
        $error['username'] = 'Bạn chưa nhập tên đăng nhập';
    }
    
    // Email
    if (isset($data['email']) && $data['email'] == ''){
        $error['email'] = 'Bạn chưa nhập email';
    }
    if (isset($data['email']) && filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false){
        $error['email'] = 'Email không hợp lệ';
    }
    
    // Password
    if (isset($data['password']) && $data['password'] == ''){
        $error['password'] = 'Bạn chưa nhập mật khẩu';
    }
    
    // Re-password
    if (isset($data['password']) && isset($data['re-password']) && $data['password'] != $data['re-password']){
        $error['re-password'] = 'Mật khẩu nhập lại không đúng';
    }
    
    // Level
    if (isset($data['level']) && !in_array($data['level'], array('1', '2'))){
        $error['level'] = 'Level bạn chọn không tồn tại';
    }
    
    /* VALIDATE LIÊN QUAN CSDL */
    // Chúng ta nên kiểm tra các thao tác trước có bị lỗi không, nếu không bị lỗi thì mới
    // tiếp tục kiểm tra bằng truy vấn CSDL
    // Username
    if (!($error) && isset($data['username']) && $data['username']){
        $sql = "SELECT count(id) as counter FROM tb_user WHERE username='".addslashes($data['username'])."'";
        $row = db_get_row($sql);
        if ($row['counter'] > 0){
            $error['username'] = 'Tên đăng nhập này đã tồn tại';
        }
    }
    
    // Email
    if (!($error) && isset($data['email']) && $data['email']){
        $sql = "SELECT count(id) as counter FROM tb_user WHERE email='".addslashes($data['email'])."'";
        $row = db_get_row($sql);
        if ($row['counter'] > 0){
            $error['email'] = 'Email này đã tồn tại';
        }
    }
    
    return $error;
}

function db_user_update_validate($data)
{
    // Biến chứa lỗi
    $error = array();
    
    /* VALIDATE CĂN BẢN */
    // Username
    if (isset($data['username']) && $data['username'] == ''){
        $error['username'] = 'Bạn chưa nhập tên đăng nhập';
    }
    
    // Email
    if (isset($data['email']) && $data['email'] == ''){
        $error['email'] = 'Bạn chưa nhập email';
    }
    if (isset($data['email']) && filter_var($data['email'], FILTER_VALIDATE_EMAIL) === false){
        $error['email'] = 'Email không hợp lệ';
    }
    
    // Password
    if (isset($data['password']) && $data['password'] == ''){
        $error['password'] = 'Bạn chưa nhập mật khẩu';
    }
    
    // Re-password
    if (isset($data['password']) && isset($data['re-password']) && $data['password'] != $data['re-password']){
        $error['re-password'] = 'Mật khẩu nhập lại không đúng';
    }
    
    // Level
    if (isset($data['level']) && !in_array($data['level'], array('1', '2'))){
        $error['level'] = 'Level bạn chọn không tồn tại';
    }
    
    /* VALIDATE LIÊN QUAN CSDL */
    // Chúng ta nên kiểm tra các thao tác trước có bị lỗi không, nếu không bị lỗi thì mới
    // tiếp tục kiểm tra bằng truy vấn CSDL
    // Username
    if (!($error) && isset($data['username']) && $data['username']){
        $sql = "SELECT count(id) as counter FROM tb_user WHERE username='".addslashes($data['username'])."'";
        $row = db_get_row($sql);
        if ($row['counter'] > 0){
            $error['username'] = 'Tên đăng nhập này đã tồn tại';
        }
    }
    
    return $error;
}


// Hàm validate dữ liệu form update, add hs
function db_hs_validate($data) {
    // Biến chứa lỗi
    $error = array();

    // Họ tên 
    if (isset($data['hoten_hs']) && $data['hoten_hs'] == ''){
        $error['hoten_hs'] = 'Chưa nhập họ tên';
    }
    
    // Ngày sinh
    if (isset($data['ngaysinh']) && $data['ngaysinh'] == ''){
        $error['ngaysinh'] = 'Chưa nhập ngày sinh';
    }
    
    // Giới tính
    if (isset($data['gioitinh']) && $data['gioitinh'] == ''){
        $error['gioitinh'] = 'Chưa nhập giới tính';
    }
    
    // Lớp
    if (isset($data['malop']) && $data['malop'] == ''){
        $error['malop'] = 'Chưa nhập mã lớp';
    }
    
    // Năm học
    if (isset($data['namhoc']) && $data['namhoc'] == ''){
        $error['namhoc'] = 'Chưa nhập năm học';
    }
    
    // Địa chỉ
    if (isset($data['diachi']) && $data['diachi'] == ''){
        $error['diachi'] = 'Chưa nhập địa chỉ';
    }
    
    // Sđt bố
    $check_sdt_bo = db_sdt_validate($data['sdt_bo']);
    if ($check_sdt_bo != '') {
        $error['sdt_bo'] = $check_sdt_bo;
    }
    
    // sdt mẹ
    $check_sdt_me = db_sdt_validate($data['sdt_me']);
    if ($check_sdt_me != '') {
        $error['sdt_me'] = $check_sdt_me;
    }

    return $error;
}

// Hàm validate sdt
function db_sdt_validate($data) {
    // Biến chứa kết quả
    if ($data == '') return $result = '';

    // Validate độ dài, là số
    
        if ((strlen($data)<10 || strlen($data)>12) || (is_numeric($data) != 1) || ($data[0] == '-')){
            $result = 'Số điện thoại không hợp lệ';
        }

    return $result;
}

// Hàm validate dữ liệu form update, add điểm
function db_diem_validate($data) {
    // Biến chứa lỗi
    $error = array();

    // Mã hs
    if (isset($data['mahs']) && $data['mahs'] == ''){
        $error['mahs'] = 'Chưa nhập mã học sinh';
    }
    
    // Môn học
    if (isset($data['mamh']) && $data['mamh'] == ''){
        $error['mamh'] = 'Chưa nhập mã môn học';
    }

    // Điểm 1
    if (($data['diem1'] != '') && (!(($data['diem1'] > 0) && ($data['diem1'] < 10)))){
        $error['diem1'] = 'Điểm không hợp lệ';
    }

    // Điểm 2
    if (($data['diem2'] != '') && (!(($data['diem2'] > 0) && ($data['diem2'] < 10)))){
        $error['diem2'] = 'Điểm không hợp lệ';
    }
    // Điểm 3
    if (($data['diem3'] != '') && (!(($data['diem3'] > 0) && ($data['diem3'] < 10)))){
        $error['diem3'] = 'Điểm không hợp lệ';
    }
    // Điểm 4
    if (($data['diem4'] != '') && (!(($data['diem4'] > 0) && ($data['diem4'] < 10)))){
        $error['diem4'] = 'Điểm không hợp lệ';
    }
    // Điểm 5
    if (($data['diem5'] != '') && (!(($data['diem5'] > 0) && ($data['diem5'] < 10)))){
        $error['diem5'] = 'Điểm không hợp lệ';
    }
    // Điểm 6
    if (($data['diem6'] != '') && (!(($data['diem6'] > 0) && ($data['diem6'] < 10)))){
        $error['diem6'] = 'Điểm không hợp lệ';
    }
    return $error;
}

// Hàm validate dữ liệu form update, add giáo viên
function db_gv_validate($data) {
    // Biến chứa lỗi
    $error = array();

    // Họ tên
    if (isset($data['hoten_gv']) && $data['hoten_gv'] == ''){
        $error['hoten_gv'] = 'Chưa nhập họ tên';
    }
    
    // Ngày sinh
    if (isset($data['ngaysinh']) && $data['ngaysinh'] == ''){
        $error['ngaysinh'] = 'Chưa nhập ngày sinh';
    } 
    
    // Giới tính
    if (isset($data['gioitinh']) && $data['gioitinh'] == ''){
        $error['gioitinh'] = 'Chưa nhập giới tính';
    }

    // Chức vụ
    if (isset($data['chucvu']) && $data['chucvu'] == ''){
        $error['chucvu'] = 'Chưa nhập chức vụ';
    }
    
    // Năm học
    if (isset($data['namhoc']) && $data['namhoc'] == ''){
        $error['namhoc'] = 'Chưa nhập năm học';
    }
    
    // Chuyên ngành
    if (isset($data['chuyennganh']) && $data['chuyennganh'] == ''){
        $error['chuyennganh'] = 'Chưa nhập chuyên ngành';
    }

    // Số điện thoại
    if (isset($data['sdt']) && $data['sdt'] == ''){
        $error['sdt'] = 'Chưa nhập số điện thoại';
    }

    $check_sdt = db_sdt_validate($data['sdt']);
    if ($check_sdt != '') {
        $error['sdt'] = $check_sdt;
    }
    
    // Địa chỉ
    if (isset($data['diachi']) && $data['diachi'] == ''){
        $error['diachi'] = 'Chưa nhập địa chỉ';
    }
    
    return $error;
}

  


