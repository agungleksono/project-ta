<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- <meta name="description" content="">
		<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
		<meta name="generator" content="Hugo 0.101.0"> -->
		<title>Dashboard</title>

		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
		
		<!-- Custom styles for this template -->
		<link href="/css/dashboard.css" rel="stylesheet">
		<link href="/public/css/style.css" rel="stylesheet">

		<!-- Bootstrap icon -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
	</head>
	<body>
    
		@include('dashboard.layouts.header')

		<div class="container-fluid">
			<div class="row">
			@include('dashboard.layouts.sidebar_trainer')

			<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
				@yield('container')
			</main>
		</div>
		</div>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

		<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
		<script src="/js/dashboard.js"></script>
		<script>
			const btnLogout = document.getElementById('btnLogout');
			btnLogout.addEventListener('click', function() {
				fetch(`{{ url('/api/v1/logout') }}`, {
					method: 'POST',
					headers: {
						'Authorization' : `Bearer ${token}`,
					}
				})
				.then(response => response.json())
				.then(json => 
					location.reload()
				)
			})
		</script>
	</body>
</html>
