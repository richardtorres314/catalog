<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model {

	protected $fillable = ['course_id', 'title', 'department', 'group', 'description'];

}
