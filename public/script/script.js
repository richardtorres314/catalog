$(document).ready(function() {
	
	var department = $('#departments option:selected').text();
	var $url = "php/getlist.php?q=";
	$('select').empty();
	$('.days').removeAttr('checked');
	$('select').append('<option value="">Any</option>');
	soft_load_terms();
	
	$.ajax({
		url: $url,
		type: 'get',
		data: {'q' : 'departments'},
		success: function(departments, status) {
			for (var department in departments)
				$('#departments').append("<option>"+departments[department]+"</option");
		},
		dataType: 'json'
	});
	
	$('#departments').change(function() {
		var department = $('#departments option:selected').text();
		$.ajax({
			url: $url,
			type: 'get',
			context: this,
			data: {'q' : 'groups', 'dept' : department},
			dataType: "json"
		});
		
		$('#departments').ajaxSuccess(function(event, jqXHR, ajaxOptions, results) {
			reset_all();
			if (results != null && results && department != 'Any') {
				var groups = results['groups'];
				var faculty = results['faculty'];
				var terms = results['terms'];
				load_groups(groups);
				load_faculty(faculty);
				load_terms(terms);
			}
			else {
				soft_load_terms();
			}
		});
	});
	
	
	$('#groups').change(function() {
		var department = $('#departments option:selected').text();
		var group = $('#groups option:selected').text();
		var term = $('#terms option:selected').val();
		$.ajax({
			url: $url,
			type: 'get',
			context: this,
			data: {'q' : 'faculty', 'group' : group, 'dept' : department, 'term' : term},
			dataType: "json"
		});
		
		$('#groups').ajaxSuccess(function(event, jqXHR, ajaxOptions, results) {
			reset_terms();
			var terms = results['terms'];
			load_terms(terms);
			
			reset_faculty();
			var faculty = results['faculty'];
			load_faculty(faculty);
		});
	});
	
	$('#terms').change(function() {
		var department = $('#departments option:selected').text();
		var group = $('#groups option:selected').text();
		var term = $('#terms option:selected').val();
		$.ajax({
			url: $url,
			type: 'get',
			context: this,
			data: {'q' : 'terms', 'group' : group, 'dept' : department, 'term' : term},
			dataType: "json"
		});
			
		$('#terms').ajaxSuccess(function(event, jqXHR, ajaxOptions, results) {
			reset_faculty();
			var faculty = results['faculty'];
			load_faculty(faculty);
		});
	});
	
	function reset_faculty() {
		$('#faculty').empty();
		$('#faculty').append('<option value="">Any</option');
	}
	
	function reset_terms() {
		$('#terms').empty();
		$('#terms').append('<option value="">Any</option>');
	}
	
	function soft_load_terms() {
		$('#terms').append('<option value="1">Fall</option>');
		$('#terms').append('<option value="2">Spring</option>');
	}
	
	function reset_groups() {
		$('#groups').empty();
		$('#groups').append('<option value="">Any</option>');
	}
	
	function reset_all() {
		reset_faculty();
		reset_terms();
		reset_groups();
	}
	
	function load_groups(groups) {
		for(var group in groups)
			$('#groups').append('<option value="'+groups[group]+'">'+groups[group]+'</option>');
	}
	
	function load_faculty(faculty) {
		for(var fac in faculty)
			$('#faculty').append('<option>'+faculty[fac]+'</option>');
	}
	
	function load_terms(terms) {
		for(var term in terms)
			$('#terms').append('<option value="' + (terms.indexOf(terms[term])+1) + '">'+terms[term]+'</option>');
	}
});