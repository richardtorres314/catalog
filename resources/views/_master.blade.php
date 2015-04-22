<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<link rel="stylesheet" type="text/css" href="/css/style.css"/>
	@yield('head')
</head>
<body>
	<div id="wrapper">
	<header><h1><a href="/">Lorem Ipsum University <br/>Course Catalog</a></h1></header>
		@yield('content')
		<footer>
		Course Catalog &copy; 2015. All rights reserved.
		</footer>
	</div>
</body>
</html>