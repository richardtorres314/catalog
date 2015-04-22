@extends('_master')

@section('title')
	Course Catalog
@stop

@section('head')
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.2.min.js"></script>-->
	<script type="text/javascript" src="/script/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="/script/script.js"></script>
@stop
	
@section('content')
		<div id="main-content">
		<h2>Course Catalog Search</h2>
		<form method="post" action="/">
			<label for="departments">Departments</label><br/>
			<select name="departments" id="departments">
				<option value="">Any</option>
			</select><br/>
			<label for="groups">Course Group</label><br/>
			<select name="groups" id="groups">
				<option value="" selected="selected">Any</option>
			</select><br/>
			<label for="terms">Term</label><br/>
			<select name="terms" id="terms">
				<option value="">Any</option>
				<option value="1">Fall</option>
				<option value="2">Spring</option>
			</select><br/>
			<label for="day">Day</label><br/><br/>
			<table name="day">
				<thead>
					<th>M</th>
					<th>T</th>
					<th>W</th>
					<th>Th</th>
					<th>F</th>
					<th>S</th>
				</thead>
				<tr>
					<td><input type="checkbox" name="day[]" value="1" class="days"></td>
					<td><input type="checkbox" name="day[]" value="2" class="days"></td>
					<td><input type="checkbox" name="day[]" value="3" class="days"></td>
					<td><input type="checkbox" name="day[]" value="4" class="days"></td>
					<td><input type="checkbox" name="day[]" value="5" class="days"></td>
					<td><input type="checkbox" name="day[]" value="6" class="days"></td>
				</tr>
			</table>
			<label for="faculty">Faculty</label><br/>
			<select name="faculty" id="faculty">
				<option value="" selected="selected">Any</option>
			</select>
				
			<br/><br/>
			<input type="submit" id="submit"/>
			<input type="hidden" name="_token" value="{{{csrf_token()}}}"/>
		</form>
		</div>
@stop