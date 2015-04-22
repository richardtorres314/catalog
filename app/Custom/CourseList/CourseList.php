<?php

namespace App\Custom\CourseList;

class CourseList {
	public function makeCourseList($courses) {
		$course_list = array();
		foreach($courses as $course) {
			$course_days = array();
			$times = array();
			$course_faculty = array();
			$course_title = $course['department']['code'] . " " . $course['course-num'] . ". " . $course['title'];
			$course_department = $course['department']['name'];
			if($course['-fall-term'] == "Y" && $course['-spring-term'] == "Y")
				$course_terms = 'Fall, Spring';
			elseif($course['-fall-term'] == "Y")
				$course_terms = 'Fall';
			elseif($course['-spring-term'] == "Y")
				$course_terms = 'Spring';
			foreach($course['schedule']['meeting'] as $meeting) {
				$day = $this->dayConverter($meeting['-day']);
				$time = 'from ' . $this->timeConverter($meeting['-begin_time']) . ' to ' . $this->timeConverter($meeting['-end_time']);
				if(!in_array($day, $course_days))
					array_push($course_days, $day);
				if(!in_array($time, $times))
					array_push($times, $time);
			}
			foreach($course['faculty_list']['faculty'] as $faculty) {
				$faculty_name = $faculty['name']['first'] . " " . $faculty['name']['last'];
				if(!in_array($faculty_name, $course_faculty))
					array_push($course_faculty, $faculty_name);
			}
			$course_description = $course['description'];
			
			$course = array();
			$course['title'] = $course_title;
			$course['department'] = $course_department;
			$course['terms'] = $course_terms;
			$course['days'] = implode(', ', $course_days);
			$course['faculty'] = implode(', ', $course_faculty);
			$course['times'] = implode(', ', $times);
			$course['description'] = $course_description;
			
			array_push($course_list, $course);
		}
		return $course_list;
	}
	
	public function dayConverter($day) {
		switch($day) {
			case 1: return 'M'; break;
			case 2: return 'Tu'; break;
			case 3: return 'W'; break;
			case 4: return 'Th'; break;
			case 5: return 'F'; break;
			case 6: return 'Sa'; break;
			case 7: return 'Su'; break;
			default: return '';
		}
	}
	
	public function timeConverter($time) {
		$hour = floor($time/100);
		if($hour == 12)
			return $hour . ":" . str_pad($time%100, 2, 00) . " " . ($time/1200 < 1 ? 'AM' : 'PM');
		else
			return ($hour%12) . ":" . str_pad($time%100, 2, 00) . " " . ($time/1200 < 1 ? 'AM' : 'PM');
	}
}