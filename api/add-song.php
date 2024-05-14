<?php
// Kiểm tra xem yêu cầu đã được gửi bằng phương thức POST chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ payload của yêu cầu POST
    $postData = file_get_contents("php://input");
    $data = json_decode($postData, true);
    // Kiểm tra xem payload có dữ liệu không và có chứa username và password không
    if (isset($data['title'])) {
        $title = $data['title'];
        $category_id = $data['category_id'];
        $artist_id = $data['artist_id'];
        $image = $data['image'];
        $file = $data['file'];
        $user_id = $data['user_id'];
        $date = date("Y-m-d H:i:s");
        $views = 0;
        $slug = $data['slug'];
        
        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "music_website_db";
        
    
        $conn = new mysqli($host,$dbusername,$dbpassword,$dbname);
        if ($conn->connect_error) {
            die("Ket noi that bai: " . $conn->connect_error);
        }
        $insert_query = "insert into songs (title, image, file, user_id, category_id, artist_id, date, views, slug) values ('$title', '$image', '$file', '$user_id', '$category_id', '$artist_id', '$date', '$views', '$slug')";
        if ($conn->query($insert_query) === TRUE) {
            $response = array("status" => "success", "message" => "Tạo thông tin bài hát thành công");
        } else {
            $response = array("status" => "error", "message" => "Lỗi khi tạo bài hát: " . $conn->error);
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