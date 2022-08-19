@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
<h1 class="h2">Dashboard</h1>
</div>

<h2>Section title</h2>
<div class="table-responsive">
<table class="table table-striped table-sm">
	<thead>
	<tr>
		<th scope="col">#</th>
		<th scope="col">Header</th>
		<th scope="col">Header</th>
		<th scope="col">Header</th>
		<th scope="col">Header</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td>1,001</td>
		<td>random</td>
		<td>data</td>
		<td>placeholder</td>
		<td>text</td>
	</tr>
	<tr>
		<td>1,002</td>
		<td>placeholder</td>
		<td>irrelevant</td>
		<td>visual</td>
		<td>layout</td>
	</tr>
	<tr>
		<td>1,003</td>
		<td>data</td>
		<td>rich</td>
		<td>dashboard</td>
		<td>tabular</td>
	</tr>
	<tr>
		<td>1,003</td>
		<td>information</td>
		<td>placeholder</td>
		<td>illustrative</td>
		<td>data</td>
	</tr>
	<tr>
		<td>1,004</td>
		<td>text</td>
		<td>random</td>
		<td>layout</td>
		<td>dashboard</td>
	</tr>
	</tbody>
</table>
</div>
@endsection
<script src="/js/script.js" type = "text/javascript"></script>
<script>
	// function getCookie(name) {
  //   function escape(s) { return s.replace(/([.*+?\^$(){}|\[\]\/\\])/g, '\\$1'); }
  //   var match = document.cookie.match(RegExp('(?:^|;\\s*)' + escape(name) + '=([^;]*)'));
  //   return match ? match[1] : null;
	// }
	const token = getCookie('token');
	// let x = document.cookie
	console.log(token);

	fetch(`{{ url('/api/v1/trainings') }}`, {
	// fetch("https://sisurty.herokuapp.com/api/v1/trainings", {
		method: 'GET',
		headers: {
			"Content-type": "application/json",
			"Accept": "application/json",
			"Authorization" : `Bearer ${token}`
		}
	})
	.then(response => response.json())
	.then(response => console.log(response.data))
</script>