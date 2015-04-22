<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model {
	protected $table = 'courses';
	protected $fillable = ['cat_id', 'course_num', 'title', 'department', 'description'];
	
	public function meetingTimes() {
		return $this->hasMany('MeetingTime');
	}
}