<?php

namespace App\Custom\Query;

class Query {
	
	public function query($department, $group, $term, $day, $faculty) {
		$file = file_get_contents("json/course_listing.json");
		$file = iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($file));
		$courses = json_decode($file, true);
		$courses = $courses['courses']['course'];
		$results = array();
		$course_list = array();
		if($term == '1')
			$term = 'Fall';
		else if($term == '2')
			$term = 'Spring';
		if(!$department && !$group && !$term && !$day && !$faculty)
			$results = $courses;
		else {
			foreach($courses as $course) {
				$course_terms = $this->getTerms($course);
				$course_faculty = $this->getFaculty($course);
				$course_days = $this->getDays($course);
				$day_intersect = array_intersect($day, $course_days);
				sort($day);
				sort($day_intersect);
				if(($department == $course['department']['name'] || !$department) &&
				   ($group == $course['group'] || !$group) &&
				   (in_array($term, $course_terms) || !$term) &&
				   (in_array($faculty, $course_faculty) || !$faculty) &&
				   ($day == $day_intersect || !$day))
					array_push($results, $course);
			}
		}
		$course_list["course"] = $results;
		return $course_list;
	}
	
	public function getTerms($course) {
		$terms = array();
		if($course["-fall-term"] == "Y")
			array_push($terms, 'Fall');
		if($course["-spring-term"] == "Y")
			array_push($terms, 'Spring');
		return $terms;
	}
	
	public function getFaculty($course) {
		$faculty = array();
		foreach($course['faculty_list']['faculty'] as $course_faculty) {
			$fac_name = $course_faculty['name']['first'] . " " . $course_faculty['name']['last'];
			if(!in_array($fac_name, $faculty))
				array_push($faculty, $fac_name);
		}
		return $faculty;
	}
	
	public function getDays($course) {
		$days = array();
		foreach($course['schedule']['meeting'] as $meeting) {
			$day = $meeting['-day'];
			if(!in_array($day, $days))
				array_push($days, $day);
		}
		return $days;
	}
}