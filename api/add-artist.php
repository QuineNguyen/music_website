<?php
// Kiểm tra xem yêu cầu đã được gửi bằng phương thức POST chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ payload của yêu cầu POST
    $postData = file_get_contents("php://input");
    $data = json_decode($postData, true);
    // Kiểm tra xem payload có dữ liệu không và có chứa username và password không
    if (isset($data['name'])) {
        $name = trim($data['name']);
        $bio = trim($data['bio']);
        $image = $data['image'];
        $user_id = 1;
        
        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "music_website_db";
        
    
        $conn = new mysqli($host,$dbusername,$dbpassword,$dbname);
        if ($conn->connect_error) {
            die("Ket noi that bai: " . $conn->connect_error);
        }
        $insert_query = "insert into artists (name, image, user_id, bio) values ('$name', '$image', '$user_id', '$bio')";
        if ($conn->query($insert_query) === TRUE) {
            $response = array("status" => "success", "message" => "Tạo thông tin nghệ sĩ thành công");
        } else {
            $response = array("status" => "error", "message" => "Lỗi khi thêm nghệ sĩ: " . $conn->error);
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