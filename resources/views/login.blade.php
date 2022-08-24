<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
		<meta name="generator" content="Hugo 0.101.0">
		<title>Sign In</title>

		<link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/sign-in/">

		

		
		<!-- <link href="/css/signin.css" rel="stylesheet"> -->
		<link href="/css/login.css" rel="stylesheet">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

	</head>

	<body>
		<!-- <div class="container text-center">
			<div class="row justify-content-center">
				<div class="col-4 bg-info div-col">asas</div>
			</div>
		</div> -->
		<div class="container text-center">
			<div class="col-4 p-4 rounded" id="card">
				<form method="POST" action="" class="loginForm">
					<div class="container">
						<img src="{{ url('image/logo_pt.PNG') }}" class="img-fluid mb-3" alt="logo">
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text"><i class="bi bi-at"></i></span>
						<input type="email" class="form-control" name="email" id="email" placeholder="Email" required autofocus>
					</div>
					<div class="input-group mb-3">
						<span class="input-group-text"><i class="bi bi-lock"></i></span>
						<input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
					</div>
					<div class="d-grid gap-2">
						<button type="submit" class="btn btn-block btn-login text-light">Masuk</button>					
					</div>
				</form>
			</div>
		</div>

		<!-- <script src="/js/script.js" type = "text/javascript"></script> -->
		<script>
			function login() {
				let data = {
					email : document.getElementById('email').value,
					password : document.getElementById('password').value,
				}

				fetch(`{{ url('/api/v1/auth/login') }}`, {
				// fetch("https://sisurty.herokuapp.com/api/v1/auth/login", {
					method: 'POST',
					body: JSON.stringify(data),
					headers: {
						"Content-type": "application/json; charset=UTF-8"
					}
				})
				.then(response => response.json())
				.then(response => {
					console.log(response);
					if (response.meta.status == 'success') {
						document.cookie = `token=${response.data.api_token}`;
						window.location.href = "{{ url('/admin/dashboard') }}";
					}
				})
			}

			const loginForm = document.querySelector('.loginForm');

			loginForm.addEventListener('submit', e => {
				e.preventDefault();
				login();
			});
		</script>
	</body>
</html>
