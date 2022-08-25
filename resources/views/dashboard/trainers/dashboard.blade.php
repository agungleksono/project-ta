@extends('dashboard.layouts.main_trainer')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
<!-- <h1 class="h4">Informasi Pengguna</h1> -->
<h1 class="h4">Dashboard</h1>
</div>
<div class="row mb-2">
	<h5>Informasi Pengguna</h5>
</div>
<div class="container row">
	<!-- <div class="col-md-3 mb-5 me-4 bg-body rounded card-dashboard position-relative border-start border-warning border-5" id="card">
		<h6 class="position-absolute top-0 start-0 mt-2 ms-4">Customer</h6>
		<h1 class="position-absolute top-50 start-0 translate-middle-y ms-4">100</h1>
		<span class="position-absolute bottom-0 start-0 mb-2 text-success ms-4">Total customer aktif</span>
		<i class="bi bi-people position-absolute bottom-0 end-0 me-3 mb-3" style="font-size: 4rem; color: #F5941A;"></i>
	</div>
	<div class="col-md-3 mb-5 me-4 bg-body rounded card-dashboard position-relative border-start border-warning border-5" id="card">
		<h6 class="position-absolute top-0 start-0 mt-2 ms-4">Trainer</h6>
		<h1 class="position-absolute top-50 start-0 translate-middle-y ms-4">17</h1>
		<span class="position-absolute bottom-0 start-0 mb-2 text-success ms-4">Total trainer aktif</span>
		<i class="bi bi-person-video3 position-absolute bottom-0 end-0 me-3 mb-3" style="font-size: 4rem; color: #F5941A;"></i>
	</div> -->
	<div class="col-md-3 mb-5 me-4 bg-body rounded card-dashboard position-relative border-start border-success border-5" id="card">
		<h6 class="position-absolute top-0 start-0 mt-2 ms-4">Total Training</h6>
		<div class="total-training-container">
			<h1 class="position-absolute top-50 start-0 translate-middle-y ms-4"></h1>
		</div>
		<!-- <span class="position-absolute bottom-0 start-0 text-success mb-3 ms-4">Total customer aktif</span> -->
		<i class="bi bi-mortarboard position-absolute bottom-0 end-0 me-3 mb-3" style="font-size: 4rem; color: #90EE90;"></i>
	</div>
	<div class="col-md-3 mb-5 me-4 bg-body rounded card-dashboard position-relative border-start border-info border-5" id="card">
		<h6 class="position-absolute top-0 start-0 mt-2 ms-4">Training aktif</h6>
		<div class="training-active-container">
			<h1 class="position-absolute top-50 start-0 translate-middle-y ms-4"></h1>
		</div>
		<!-- <span class="position-absolute bottom-0 start-0 text-success mb-3 ms-4">Total trainer aktif</span> -->
		<i class="bi bi-calendar-week position-absolute bottom-0 end-0 me-3 mb-3" style="font-size: 4rem; color: #00CED1;"></i>
	</div>
	<div class="col-md-3 mb-5 me-4 bg-body rounded card-dashboard position-relative border-start border-secondary border-5" id="card">
		<h6 class="position-absolute top-0 start-0 mt-2 ms-4">Training Selesai</h6>
		<div class="training-end-container">
			<h1 class="position-absolute top-50 start-0 translate-middle-y ms-4"></h1>
		</div>
		<!-- <span class="position-absolute bottom-0 start-0 text-success mb-3 ms-4">Total customer aktif</span> -->
		<i class="bi bi-check-all position-absolute bottom-0 end-0 me-3 mb-3" style="font-size: 4rem; color: #D3D3D3;"></i>
	</div>
</div>
<!-- <div class="card mt-4">
	<div class="card-header">
		<h3>Tabel Lowongan Pekerjaan</h3>
	</div>
	<div class="card-body">
		
	</div>
</div> -->
@endsection

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="/js/script.js" type = "text/javascript"></script>
<script>
	const token = getCookie('token');
	console.log(token);

	showData();

	async function showData() {
		const data = await getData(`{{ url('/api/v1/dashboard_trainer') }}`, token);
		console.log(data);
		const trainingContainer = document.querySelector('.total-training-container');
		const trainingActiveContainer = document.querySelector('.training-active-container');
		const trainingEndContainer = document.querySelector('.training-end-container');

		trainingContainer.innerHTML = `
			<h1 class="position-absolute top-50 start-0 translate-middle-y ms-4">${data.total_trainings}</h1>
		`
		trainingActiveContainer.innerHTML = `
			<h1 class="position-absolute top-50 start-0 translate-middle-y ms-4">${data.total_training_active}</h1>
		`
		trainingEndContainer.innerHTML = `
			<h1 class="position-absolute top-50 start-0 translate-middle-y ms-4">${data.total_training_end}</h1>
		`
	}
</script>