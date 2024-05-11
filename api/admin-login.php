<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $postData = file_get_contents("php://input");
    $data = json_decode($postData, true);
    if (isset($data['email']) && isset($data['password'])){
        $email = $data['email'];
        $password = $data['password'];
        
        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "music_website_db";

        $conn = new mysqli($host,$dbusername,$dbpassword,$dbname);
        $query = "select * from users where email = '$email' and password = '$password'";
        $row = mysqli_query($conn, $query);

        if(mysqli_num_rows($row) > 0)
        {
            $response = array("Trạng thái" => "Thành công", "Thông báo" => "Đăng nhập thành công", "Email" => $email, "Mật khẩu" => $password);
        }
        else
        {
            $response = array("Trạng thái" => "Thất bại", "Thông báo" => "Tài khoản hoặc mật khẩu sai", "Email" => $email, "Mật khẩu" => $password);
        }
        
    }
    
    else {
        $response = array("Trạng thái" => "Lỗi", "Thông báo" => "Payload không chứa đủ dữ liệu");
    }

}
else {
    $response = array("Trạng thái" => "Lỗi", "Thông báo" => "Chỉ được dùng phương thức POST");
}
header('Content-Type: application/json');
echo json_encode($response);