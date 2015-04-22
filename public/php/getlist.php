<?php

$file = file_get_contents("..//json/course_listing.json");
$file = iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($file));
$courses = json_decode($file, true);
$courses = $courses['courses']['course'];

$q = $_GET["q"];

if($q == 'departments')
	departments();
else if($q == 'groups')
	groups();
else if($q == 'faculty')
	faculty();
else if($q == 'terms')
	terms();

function departments() {
	global $courses;
	$departments = array();
	foreach($courses as $course) {
		$department = $course['department']['name'];
		if(!in_array($department, $departments))
			array_push($departments, $department);
	}
	echo json_encode($departments);
}

function groups() {
	global $courses;
	$dept = $_GET['dept'];
	$groups = array();
	$faculty = array();
	$terms = array();
	foreach($courses as $course) {
		$department = $course['department']['name'];
		$group = $course['group'];
		if($department == $dept) {
			foreach($course['faculty_list']['faculty'] as $fac) {
				$course_faculty = $fac['name']['first'] . " " . $fac['name']['last'];
				if(!in_array($course_faculty, $faculty))
					array_push($faculty, $course_faculty);
			}
			if($course['-fall-term'] == "Y" && !in_array('Fall', $terms))
				array_push($terms, 'Fall');
			if($course['-spring-term'] == "Y" && !in_array('Spring', $terms))
				array_push($terms, 'Spring');
			if(!in_array($group, $groups))
				array_push($groups, $group);
		}
	}
	sort($terms);
	$results = array('faculty' => $faculty, 'groups' => $groups, 'terms' => $terms);
	echo json_encode($results);
}

function faculty() {
	global $courses;
	$dept = $_GET['dept'];
	$grp = $_GET['group'];
	$faculty = array();
	$terms = array();
	foreach($courses as $course) {
		$department = $course['department']['name'];
		$group = $course['group'];
		if(($department == $dept && $group == $grp) || ($grp == 'Any')) {
			if($course['-fall-term'] == "Y" && !in_array('Fall', $terms))
				array_push($terms, 'Fall');
			if($course['-spring-term'] == "Y" && !in_array('Spring', $terms))
				array_push($terms, 'Spring');
			foreach($course['faculty_list']['faculty'] as $course_faculty) {
				$fac_name = $course_faculty['name']['first'] . " " . $course_faculty['name']['last'];
				if(!in_array($fac_name, $faculty))
					array_push($faculty, $fac_name);
			}
		}
	}
	sort($terms);
	$results = array('faculty' => $faculty, 'terms' => $terms);
	echo json_encode($results);
}

function terms() {
	global $courses;
	$dept = $_GET['dept'];
	$grp = $_GET['group'];
	$term = $_GET['term'];
	$faculty = array();
	foreach($courses as $course) {
		$department = $course['department']['name'];
		$group = $course['group'];
		if(($department == $dept && $group == $grp) || ($grp == 'Any')) {
			foreach($course['faculty_list']['faculty'] as $course_faculty) {
				$fac_name = $course_faculty['name']['first'] . " " . $course_faculty['name']['last'];
				if($course_faculty['-term'] == $term && !in_array($fac_name, $faculty))
					array_push($faculty, $fac_name);
			}
		}
	}
	$results = array('faculty' => $faculty);
	echo json_encode($results);
}