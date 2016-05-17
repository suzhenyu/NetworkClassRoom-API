<?php
/**
*  这个接口是用来查询某个学生的课程。
*/
require_once('./response.php');
require_once('./db.php');

if (!isset($_GET['student_id'])) {
	echo "Please enter the student_id";
	exit;
}

$student_id = $_GET['student_id'];

try {
	$connect = Db::getInstance()->connect();
} catch(Exception $e) {
	return Response::json(403, '数据库链接失败');
}

$courseIDs = array();
$sql1 = "SELECT `course_id` FROM `selectcourse` 
   		 WHERE `selectcourse`.`major_id` = (SELECT `major_id` FROM `student` WHERE `student_id` = $student_id)";
$result1 = mysql_query($sql1, $connect);
while ($courseID = mysql_fetch_assoc($result1)) {
	$courseIDs[] = $courseID['course_id'];
}

$coures = array();
for ($i=0; $i < count($courseIDs); $i++) { 
	$courseID = $courseIDs[$i];
	
	$sql2 = "SELECT * FROM `course` WHERE `course`.`course_id` = $courseID";

	$result2 = mysql_query($sql2, $connect);
	while($course = mysql_fetch_assoc($result2)) {
		$coures[] = $course;
	}
}

if($coures) {
	return Response::json(200, '学生课程数据获取成功', $coures);
} else {
	return Response::json(400, '学生课程数据获取失败', $coures);
}