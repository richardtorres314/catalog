@extends('_master')

@section('head')
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
@stop


@section('content')
	<script>
		$(document).ready(function() {
			$.get('departments', function(data) {
			$('body').append(JSON.stringify(data));
			for (var x in data)
				$('#departments').append('<option>'+data[x]['department']+'</option>');
			}, 'json');
		});
	</script>
	<label for="departments">Departments</label>
	<select name="departments" id="departments">
		<option value="">Any</option>
	</select><br/>
	<label for="groups">Groups</label>
	<select name="groups" id="groups">
		<option value="">Any</option>
	</select>
@stop