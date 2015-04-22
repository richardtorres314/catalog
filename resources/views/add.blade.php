@extends('_master')

@section('title')
	Add A Course
@stop

@section('content')
	<form action="/add" method="post">
		<table>
			<tr>
				<td>Catalog ID</td>
				<td><input type="text" name="-cat-id"/></td>
			</tr>
			<tr>
				<td>Offered</td>
				<td>
					<table>
						<thead>
							<th>Fall</th>
							<th>Spring</th>
						</thead>
						<tr>
							<td align="center"><input type="checkbox" name="-fall-term"/></td>
							<td align="center"><input type="checkbox" name="-spring-term"/></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>Title</td>
				<td><input type="text" name="title"/></td>
			</tr>
			<tr>
				<td>Course Number</td>
				<td><input type="text" name="course-num"/></td>
			</tr>
			<tr>
				<td>Department Name</td>
				<td><input type="text" name="department"</td>
			</tr>
			<tr>
				<td>Group</td>
				<td><input type="text" name="group"</td>
			</tr>
			<tr>
				<td>Schedule</td>
				<td>
					<table>
						<thead>
							<th>M</th>
							<th>Tu</th>
							<th>W</th>
							<th>Th</th>
							<th>F</th>
							<th>S</th>
						</thead>
						<tr>
							<td align="center"><input type="checkbox" name="days[]" value="1"/></td>
							<td align="center"><input type="checkbox" name="days[]" value="2"/></td>
							<td align="center"><input type="checkbox" name="days[]" value="3"/></td>
							<td align="center"><input type="checkbox" name="days[]" value="4"/></td>
							<td align="center"><input type="checkbox" name="days[]" value="5"/></td>
							<td align="center"><input type="checkbox" name="days[]" value="6"/></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>Begin Time</td>
				<td><input type="text" name="-begin-time"/></td>
			</tr>
			<tr>
				<td>End Time</td>
				<td><input type="text" name="-end-time"/></td>
			</tr>
			<tr>
				<td>Term</td>
				<td><select name="term" style="width: 150px">
					<option value="1">Fall</option>
					<option value="2">Spring</option>
				</select></td>
			</tr>
			<tr>
				<td>Faculty First Name</td>
				<td><input type="text" name="first"/></td>
			</tr>
			<tr>
				<td>Faculty Last Name</td>
				<td><input type="text" name="last"/></td>
			</tr>
			<tr>
				<td>Description</td>
				<td><textarea name="description"></textarea></td>
			</tr>
			<tr>
				<td><input type="hidden" name="_token" value="{{{csrf_token()}}}"/></td>
				<td><input type="submit"/></td>
			</tr>
		</table>
	</form>
@stop