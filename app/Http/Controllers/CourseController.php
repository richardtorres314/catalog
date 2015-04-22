<?php namespace App\HTTP\Controllers;

use App\Course;
use DB;

class CourseController extends Controller {
	public function add() {
		return view('add');
	}
	
	public function submit() {
		return view('index');
	}
	
	public function search() {
		return view('index');
	}
}