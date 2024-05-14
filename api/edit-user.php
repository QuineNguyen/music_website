<?php
// Kiểm tra xem yêu cầu đã được gửi bằng phương thức POST chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ payload của yêu cầu POST
    $postData = file_get_contents("php://input");
    $data = json_decode($postData, true);
    // Kiểm tra xem payload có dữ liệu không và có chứa username và password không
    if (isset($data['id']) && isset($data['username']) && isset($data['email']) && isset($data['role']) && isset($data['password'])) {
        $id = $data['id'];
        $username = $data['username'];
        $email = $data['email'];
        $role = $data['role'];
        $password = $data['password'];
        
        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "music_website_db";
        
    
        $conn = new mysqli($host,$dbusername,$dbpassword,$dbname);
        if ($conn->connect_error) {
            die("Ket noi that bai: " . $conn->connect_error);
        }
        $insert_query = "update users set username = '$username', email = '$email', role = '$role', password = '$password' where id = '$id' limit 1";
        if ($conn->query($insert_query) === TRUE) {
            $response = array("status" => "success", "message" => "Cập nhật thông tin người dùng thành công");
        } else {
            $response = array("status" => "error", "message" => "Lỗi khi cập nhật đề thi: " . $conn->error);
        }

       
    } 
    
    else {
        // Nếu payload không chứa đủ dữ liệu, trả về thông báo lỗi
        $response = array("status" => "error", "message" => "Payload không chứa đủ dữ liệu");
    }
    // Trả về phản hồi JSON

} 


else {
    // Nếu yêu cầu không phải là phương thức POST, trả về thông báo lỗi
    $response = array("status" => "error", "message" => "Only POST Method");
    // Trả về phản hồi JSON
   
}



header('Content-Type: application/json');
echo json_encode($response);