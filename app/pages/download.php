<?php

    $slug = $URL[1] ?? null;
    $query = "select * from songs where slug = :slug limit 1";
    $row = db_query_one($query, ['slug'=>$slug]);

    if($row)
    {

        header('Content-Description: File Transfer');
        header('Content-Type: '. mime_content_type($row['file']));
        header('Content-Disposition: attachment; filename="'.basename($row['file']).'"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($row['file']));
        ob_clean();
        flush();
        readfile($row['file']);
        exit();

    }

echo "Không tìm thấy bài hát";