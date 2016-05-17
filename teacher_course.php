<?php
/**
* 这个接口是用来获取某位老师所有需要教授的课程
*/
require_once('./response.php');
require_once('./db.php');

if (!isset($_GET['teacher_id'])) {
	echo "Please enter the teacher_id";
	exit;
}

$teacher_id = $_GET['teacher_id'];

try {
	$connect = Db::getInstance()->connect();
} catch(Exception $e) {
	return Response::json(403, '数据库链接失败');
}

$sql = "SELECT * FROM `course` WHERE `teacher_id` = $teacher_id";

$result = mysql_query($sql, $connect);
$courses = array();
while ($course = mysql_fetch_assoc($result)) {	
	$courses[] = $course;
}

if ($courses) {
	return Response::json(200, "教师课程数据获取成功", $courses);
}else {
	return Response::json(400, "教师课程数据获取失败", $courses);
}