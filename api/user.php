<?php
// Kiểm tra xem yêu cầu đã được gửi bằng phương thức POST chưa
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Lấy dữ liệu từ payload của yêu cầu POST
    $postData = file_get_contents("php://input");
    $data = json_decode($postData, true);
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "music_website_db";
    

    $conn = new mysqli($host,$dbusername,$dbpassword,$dbname);
    if ($conn->connect_error) {
        die("Ket noi that bai: " . $conn->connect_error);
    }
    $query = "select * from users order by id desc limit 20";
    $result = mysqli_query($conn,$query);
    $i = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $username = $row['username'];
        $email = $row['email'];
        $role = $row['role'];
        $date = $row['date'];

        $response[$i] = array(
            "Tên" => $username,
            "Email" => $email,
            "Vai trò" => $role,
            "Ngày tạo" => $date
        );

        $i++; 
    }

} 


else {
    $response = array("status" => "error", "message" => "Only POST Method");
   
}

header('Content-Type: application/json');
echo json_encode($response);