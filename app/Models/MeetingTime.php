<?php namespace App\Models;

class MeetingTime extends Eloquent {
	protected $fillable = array('term', 'days', 'start_time', 'end_time');
	
	public function course() {
		return $this->belongsTo('Course');
	}
}