<?php
/**
* 这个接口是用来获取某个课程的视频信息的。
*/

require_once('./response.php');
require_once('./db.php');

if (!isset($_GET['course_id'])) {
	echo "Please enter the course_id";
	exit;
}

$course_id = $_GET['course_id'];

try {
	$connect = Db::getInstance()->connect();
} catch(Exception $e) {
	return Response::json(403, '数据库链接失败');
}

$sql = "SELECT * FROM `file` WHERE `course_id` = $course_id";

$result = mysql_query($sql, $connect);

$files = array();		
while ($file = mysql_fetch_assoc($result)) {
	$files[] = $file;
}

if ($files) {
	return Response::json(200, "文件数据获取成功", $files);
}else {
	return Response::json(400, "文件数据获取失败", $files);
}