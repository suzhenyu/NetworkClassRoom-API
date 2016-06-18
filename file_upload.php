<?php  

    require_once('./response.php');
    require_once('./db.php');

    if (!isset($_POST['file_name'])) {
        echo "Please enter the file_name";
        exit;
    }
    if (!isset($_POST['course_id'])) {
        echo "Please enter the course_id";
        exit;
    }

    $file_name = $_POST['file_name'];
    $course_id = $_POST['course_id'];

    $base_path = "./upload/"; //存放目录 

    if(!is_dir($base_path)){  
        mkdir($base_path,0777,true);  
    } 

    $strArray = explode(".", $_FILES ['attach'] ['name']);
    $newfilename = $strArray[0].'-'.date('Ymdhis').'.'.$strArray[1];

    // $target_path = $base_path . basename ($_FILES ['attach'] ['name']); 
    $target_path = $base_path . $newfilename; 

    if (move_uploaded_file ( $_FILES ['attach'] ['tmp_name'], $target_path )) { 
        $filePath = 'http://121.42.162.159/upload/'.$newfilename;
        $dateString = date("Y-m-d h:i:s");
        //写入一条记录
        $sql = "INSERT INTO `studentnetworkingclass`.`file` (`file_name`, `course_id`, `file_url`, `addtime`) 
                VALUES ('$file_name', '$course_id', '$filePath', '$dateString');";
        try {
            $connect = Db::getInstance()->connect();
        } catch(Exception $e) {
            return Response::json(403, '数据库链接失败');
        }

        $result = mysql_query($sql, $connect); 
        if ($result) {
            $array = array (  
                "url" => $filePath
            );  

            return Response::json(200, '文件上传成功', $array);
        }else {
            $array = array (   
                "url" => "There was an error uploading the file, please try again!" . $_FILES ['attach'] ['error']   
            );  

            return Response::json(400, '文件上传失败', $array);
        }
    } else {
        $array = array (   
            "url" => "There was an error uploading the file, please try again!" . $_FILES ['attach'] ['error']   
        );  

        return Response::json(400, '文件上传失败', $array);
    }

    $array = explode(".", $_FILES['attach']['name']);
    $array[count($array)];

?> 