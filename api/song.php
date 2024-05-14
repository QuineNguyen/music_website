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
    $query = "select * from songs order by id desc limit 20";
    $result = mysqli_query($conn,$query);
    $i = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row['title'];
        $image = $row['image'];
        $file = $row['file'];
        $date = $row['date'];
        $views = $row['views'];

        $response[$i] = array(
            "Tên bài hát" => $title,
            "Hình ảnh" => $image,
            "File" => $file,
            "Ngày tạo" => $date,
            "Lượt nghe" => $views,
        );

        $i++; 
    }

} 


else {
    $response = array("status" => "error", "message" => "Only POST Method");
   
}

header('Content-Type: application/json');
echo json_encode($response);