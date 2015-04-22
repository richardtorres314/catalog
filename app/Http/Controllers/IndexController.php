<?php namespace App\Http\Controllers;

use Request;
use Cache;
use Response;
use App\Custom\Query\Query;
use App\Custom\CourseList\CourseList;
use Anouar\Fpdf\Fpdf;
use SimpleXMLElement;

class IndexController extends Controller {
	
	public function index() {
		return view('index');
	}
	
	public function post() {
		$department = Request::input('departments');
		$group = Request::input('groups');
		$term = Request::input('terms');
		$faculty = Request::input('faculty');
		isset($_POST['day']) ? $day = $_POST['day'] : $day = array();
		$q = new Query();
		$q = $q->query($department, $group, $term, $day, $faculty);
		$course_list['courses'] = $q;
		$c = new CourseList();
		$c = $c->makeCourseList($q['course']);
		Cache::forever('results', $c);
		Cache::forever('results_array', $q['course']);
		return redirect('/page/1');
	}
	
	public function jsonifr() {
		$results = Cache::get('results');
		return response(json_encode($results, JSON_PRETTY_PRINT))->header('Content-Type', 'application/json');
	}

	public function xmlr() {
		$results = Cache::get('results_array');
		
		$courses = new SimpleXMLElement('<courses/>');
		foreach($results as $course) {
			$course_index = $courses->addChild('course');
			$course_index->addAttribute('cat-id', $course['-cat-id']);
			$course_index->addAttribute('fall-term', $course['-fall-term']);
			$course_index->addAttribute('spring-term', $course['-spring-term']);
			$course_index->addChild('course-num', $course['course-num']);
			$course_index->addChild('title', $course['title']);
			$department = $course_index->addChild('department');
			$department->addChild('name', $course['department']['name']);
			$department->addChild('code', $course['department']['code']);
			$course_index->addChild('group', $course['group']);
			$schedule = $course_index->addChild('schedule');
			foreach($course['schedule']['meeting'] as $meeting) {
				$meeting_list = $schedule->addChild('meeting');
				$meeting_list->addAttribute('term', $meeting['-term']);
				$meeting_list->addAttribute('day', $meeting['-day']);
				$meeting_list->addAttribute('begin_time', $meeting['-begin_time']);
				$meeting_list->addAttribute('end_time', $meeting['-end_time']);
			}
			$course_index->addChild('description', $course['description']);
		}
		return response($courses->asXML())->header('Content-type', 'application/xml');
	}
	
	public function pdfr() {
		$fpdf = new Fpdf();
		$course_list = Cache::get('results');
		$count = count($course_list);
		$fpdf->SetTitle('Search Results');
		$fpdf->AddPage();
        $fpdf->SetFont('Arial','B',18);
		$fpdf->Cell(190, 10, $count." Courses Found", 0, 1, "C");
		
		foreach($course_list as $course) {
			$fpdf->SetFont('Arial','B',11);
			$fpdf->Write(5, $course['title'] . "\n");
			$fpdf->SetFont('Arial','',10);
			$fpdf->Write(5, $course['department'] . "\n");
			$fpdf->Write(5, "Offered: " . $course['terms'] . " term\n");
			$fpdf->Write(5, "Meeting Time: " . $course['days'] . " " . $course['times'] . "\n");
			$fpdf->Write(5, "Faculty: " . $course['faculty'] . "\n");
			$fpdf->Write(5,$course['description']."\n\n");
		}
		$fpdf->Output('Search Results.pdf','I');
        exit;
	}
	
	public function page($page = 1) {
		$max = 5;
		$results = Cache::get('results');
		$results_count = count($results);
		$page_results = array();
		$pagecount = ceil(count($results)/$max);
		$last_page = $max*$page;
		if($last_page > $results_count)
			$last_page = $results_count;
		if($results) {
			for($index = $max*($page-1); $index < $last_page; $index++)
				array_push($page_results, $results[$index]);
		}
		return view('results')->with('results', $page_results)
							  ->with('results_count', $results_count)
							  ->with('pagecount', $pagecount)
							  ->with('pagenum', $page);
	}
	
	public function addCourse() {
		return view('add');
	}
	
	public function postCourse() {
		$cat_id = Request::input('-cat-id');
		if(!$cat_id) {
			$cat_id = 1;
		}
		Request::input('-fall-term') ? $fall_term = '"Y"' : $fall_term = '"N"';
		Request::input('-spring-term') ? $spring_term = '"Y"' : $spring_term = '"N"';
		$course_num = Request::input('course-num');
		if(!$course_num)
			$course_num = 1;
		$title = Request::input('title');
		$dept_name = Request::input('department');
		$group = Request::input('group');
		isset($_POST['days']) ? $days = $_POST['days'] : $days = array(1,2,3);
		$term = Request::input('term');
		$meetings = '';
		$faculty = '';
		$begin_time = Request::input('-begin_time');
		$end_time = Request::input('-end_time');
		$first = Request::input('first');
		$last = Request::input('last');
		$description = Request::input('description');
		if(!$first)
			$first = 1;
		if(!$last)
			$last = 1;
		if(!$begin_time)
			$begin_time = 1;
		if(!$end_time)
			$end_time = 1;
		foreach($days as $day) {
			$meetings .= '{"-term": "' . $term . '",';
			$meetings .= '"-day": "' . $day . '",';
			$meetings .= '"-begin_time": "' . $begin_time . '",';
			$meetings .= '"-end_time": "' . $end_time . '"},';
		}
		$meetings = substr($meetings, 0, strlen($meetings)-1);
		
			$faculty .= '{"-term": "' . $term . '",';
			$faculty .= '"name": {';
			$faculty .= '"first": "' . $first . '",';
			$faculty .= '"last": "' . $last . '"}}';
		
		if(!$dept_name)
			$dept_name = 1;
		if(!$title)
			$title = 1;
		if(!$group)
			$group = 1;
		if(!$description) {
			$description = 1;
		}
		$file = 'json/data.json';
		
		$file_contents_string = file_get_contents($file);
		$file_contents_size = strlen($file_contents_string);
		$added_course = '{"-cat-id":' . $cat_id . ',' .
						  '"-fall-term":' . $fall_term . ',' .
						  '"-spring-term":' . $spring_term . ',' .
						  '"course-num":' . $course_num . ',' .
						  '"title": "' . $title . '",' .
						  '"department": { "name": "' . $dept_name . '"},' .
						  '"group": "' . $group . '",' .
						  '"schedule": { "meeting": [' . $meetings . ']}' . ',' .
						  '"faculty_list": { "faculty": [' . $faculty . ']}' . ',' .
						  '"description": "' . $description . '"}';
		$courses = substr($file_contents_string, 0, $file_contents_size-12);
		file_put_contents($file, json_encode(json_decode($courses . ',' . $added_course . ']}}'),JSON_PRETTY_PRINT));
		return response(file_get_contents($file))->header('Content-Type', 'application/json');
	}
}