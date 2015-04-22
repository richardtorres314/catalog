@extends('_master')

@section('title')
	Results
@stop

@section('head')
	
@stop

@section('content')
	<div id="content">
		<h3>{{$results_count}} courses found.</h3>
			
		<div id="outputs">
		@if(count($results))
			<a href="/pdfr">PDF</a> |
			<a href="/jsonifr">JSON</a> |
			<a href="/xmlr">XML</a>
		@endif
		</div>
		
		<div id="navbar">
			<a href="/">Search</a> &rarr; Results
		</div>
		
		@if($pagecount > 1)
			<div id="pagelinks">
				@if($pagenum == 1)
					<span><b>First Page</b></span>
				@else
					<a href="/page/1">First Page</a>
				@endif
				&bullet;
				@for($i = 1; $i <= $pagecount; $i++)
					@if($i == $pagenum)
						<span><b>{{$i}}</b></span>
					@else
						<a href="/page/{{$i}}">{{$i}}</a>
					@endif
					&bullet;
				@endfor
				@if($pagenum == $pagecount)
					<span><b>Last Page</b></span>
				@else
					<a href="/page/{{$pagecount}}">Last Page</a>
				@endif
			</div>
		@endif
		
		@if(count($results) > 0)
			<ul id="results-list">
				@foreach($results as $course)
					<li>
						<p><b>{{$course['title']}}</b></p>
						<p>{{$course['department']}}</p>
						<p>Offered: {{$course['terms']}} term</p>
						<p>Meeting: {{$course['days'] . ' ' . $course['times']}}</p>
						<p>Faculty: {{$course['faculty']}}</p>
						<p>{{$course['description']}}</p>
					</li>
				@endforeach
			</ul>
		@endif
	</div>
@stop