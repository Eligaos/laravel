<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Dashboard Template for Bootstrap</title>
	<!-- Bootstrap core CSS -->
	<link href="css/bootstrap.css" rel="stylesheet">
	<!-- Custom styles for this template -->
	@yield('customStyles')
</head>
<body>
	@yield('content')
</body>
    <script src="js/jquery-2.1.4.js"></script>
    <script src="js/angular.js"></script>
    <script src="js/bootstrap.js"></script>
    @yield('customScripts')
</html>