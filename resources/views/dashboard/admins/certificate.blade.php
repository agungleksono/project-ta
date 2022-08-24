@extends('dashboard.layouts.main')

@section('container')
<!-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
<h1 class="h2">Dashboard</h1>
</div> -->

<div class="card mt-4">
	<div class="card-header">
		<h3>Upload Sertifikat</h3>
	</div>
	<div class="card-body">
		<div class="table-responsive-sm col-md-8">
			<table class="table table-hover">
			<thead>
				<tr>
					<th class="text-center">No.</th>
					<th>Nama Customer</th>
					<th colspan="2" class="text-center">Aksi</th>
				</tr>
			</thead>
			<tbody class="table-container">
				
			</tbody>
			</table>
		</div>
	</div>
</div>
@endsection

<!-- Awal Modal Sertifikat Kompetensi -->
<div class="modal fade" id="uploadCompetenceModal" tabindex="-1" aria-labelledby="uploadCompetenceLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="uploadCompetenceModalLabel">Upload Sertifikat Kompetensi</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body px-4 detail-container">
			<!-- <form action="" id="uploadForm"> -->
				<div class="row">
					<label class="form-label" for="competence_certificate">Sertifikat Kompetensi</label>
					<input type="file" class="form-control" name="competence_certificate" id="competence_certificate" required>
				</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary" onclick="uploadCertificate()">Tambah</button>
		</div>
		<!-- </form> -->
		</div>
	</div>
</div>
<!-- Akhir Modal Sertifikat Kompetensi -->

<!-- Awal Modal Sertifikat Kompetensi -->
<div class="modal fade" id="uploadTrainingModal" tabindex="-1" aria-labelledby="uploadTrainingLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="uploadTrainingModalLabel">Upload Sertifikat Training</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body px-4 detail-container">
			<!-- <form action="" id="uploadForm"> -->
				<div class="row">
					<label class="form-label" for="training_certificate">Sertifikat Training</label>
					<input type="file" class="form-control" name="training_certificate" id="training_certificate" required>
				</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary" onclick="uploadTrainingCertificate()">Tambah</button>
		</div>
		<!-- </form> -->
		</div>
	</div>
</div>
<!-- Akhir Modal Sertifikat Kompetensi -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="/js/script.js" type = "text/javascript"></script>
<script>
	const url = document.URL;
	const url_id = url.substring(url.lastIndexOf('/') + 1);
	const token = getCookie('token');
	console.log(token);

	showData();

	async function showData() {
		const customers = await getData(`{{ url('/api/v1/training_record/customers/${url_id}') }}`, token);
		console.log(customers)
		const tableContainer = document.querySelector('.table-container');
		let rowTable = '';
		let number = 0;
		let trainingRecordId = '';

		customers.forEach(customer => {
			number++;
			rowTable += `
				<tr>
					<th class="text-center">${number}</th>
					<td>${customer.customer.name} ${customer.training_certificate || customer.competence_certificate ? '<i class="bi bi-check2-all"></i>' : ''}</td>
					
					<td class="td-last"><a class="btn btn-outline-success btn-sm btn-upload" href="#" onclick="updateTrainingRecordId(${customer.id})" role="button" data-bs-toggle="modal" data-bs-target="#uploadCompetenceModal"><i class="bi bi-upload"></i><span class="d-none d-lg-inline ms-1">Sertifikat Kompetensi</span></a></td>					
					<td class="td-last"><a class="btn btn-outline-success btn-sm btn-upload" href="#" onclick="updateTrainingRecordId(${customer.id})" role="button" data-bs-toggle="modal" data-bs-target="#uploadTrainingModal"><i class="bi bi-upload"></i><span class="d-none d-lg-inline ms-1">Sertifikat Training</span></a></td>					
				</tr>
			`
		})
		
		tableContainer.innerHTML = rowTable;
	}

	// function changeTrainingRecordValue(trainingRecordId) {
	// 	const trainingRecordIdCont = document.querySelector('.trainingRecordId');
	// 	trainingRecordIdCont.innerHTML = `
	// 		<input type="text" name="trainingRecordId" id="trainingRecordId" value="${trainingRecordId}">
	// 	`
	// }

	function updateTrainingRecordId(id) {
		trainingRecordId = id;
	}

	function uploadCertificate() {
		// const uploadForm = document.getElementById('uploadForm');
		// const competenceCertificate = document.getElementById('competence_certificate');

		// uploadForm.addEventListener('submit', e => {
		// 	e.preventDefault();

			const formData = new FormData();

			formData.append('competence_certificate', document.getElementById('competence_certificate').files[0]);

			fetch(`{{ url('/api/v1/training_record/competence_certificate/${trainingRecordId}') }}`, {
				method: 'POST',
				body: formData,
				headers: {
					'Authorization' : `Bearer ${token}`,
				}
			})
			.then(response => response.json())
			.then(json => {
				console.log(json);
				if (json.meta.status == 'error') {
					return swal({
						title: "Gagal",
						text: `${json.meta.message}`,
						icon: "error",
					});
				}
				swal({
					title: "Sukses",
					text: "Berhasil menambahkan data.",
					icon: "success",
					buttons: true,
				})
				.then((value) => window.location.href = `{{ url('/admin/upload-sertifikat/${url_id}') }}`);
			})
			.catch(err => console.log(err))
		// })
	}

	function uploadTrainingCertificate() {
			const formData = new FormData();

			formData.append('training_certificate', document.getElementById('training_certificate').files[0]);

			fetch(`{{ url('/api/v1/training_record/training_certificate/${trainingRecordId}') }}`, {
				method: 'POST',
				body: formData,
				headers: {
					'Authorization' : `Bearer ${token}`,
				}
			})
			.then(response => response.json())
			.then(json => {
				console.log(json);
				if (json.meta.status == 'error') {
					return swal({
						title: "Gagal",
						text: `${json.meta.message}`,
						icon: "error",
					});
				}
				swal({
					title: "Sukses",
					text: "Berhasil menambahkan data.",
					icon: "success",
					buttons: true,
				})
				.then((value) => window.location.href = `{{ url('/admin/upload-sertifikat/${url_id}') }}`);
			})
			.catch(err => console.log(err))
	}
</script>