<?php namespace App\Http\Controllers;

use App\Course;
use DB;
use Cache;

class QueryController extends Controller {
	
	private $courses;
	
	public function get_courses() {
		if(!Cache::has('courses'))
			Cache::add('courses', Course::all());
		return $this->courses = Cache::get('courses')->toJson();
	}
}
