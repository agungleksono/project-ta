@extends('dashboard.layouts.main_trainer')

@section('container')
<!-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
<h1 class="h2">Dashboard</h1>
</div> -->

<div class="card mt-4">
	<div class="card-header">
		<h3>Tabel Pelatihan</h3>
	</div>
	<div class="card-body">
		<!-- <h5 class="card-title">Tabel Admin</h5> -->
		<!-- <div>
			<a class="btn btn-primary btn-sm my-2" href="#" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-plus-square me-2"></i>Tambah Data</a>
		</div> -->
		<div class="table-responsive-sm">
			<table class="table table-hover">
			<thead>
				<tr>
					<th class="text-center">No.</th>
					<th>Nama Pelatihan</th>
					<th class="text-center">Tanggal Pelatihan</th>
					<th class="text-center">Status</th>
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

<!-- Awal Modal Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="detailModalLabel">Detail Pelatihan</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body px-3 detail-container">
			
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		</div>
		</div>
	</div>
</div>
<!-- Akhir Modal Detail -->

<!-- Awal Modal Upload CV -->
<div class="modal fade" id="uploadCvModal" tabindex="-1" aria-labelledby="uploadCvLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="uploadCvModalLabel">Upload CV</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body px-4 upload-cv-container">
			<!-- <form action="" id="uploadForm"> -->
				<div class="row">
					<label class="form-label" for="cv">Pilih CV</label>
					<input type="file" class="form-control" name="cv" id="cv" required>
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
<!-- Akhir Modal Upload CV -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="/js/script.js" type = "text/javascript"></script>
<script>
	const token = getCookie('token');
	console.log(token);

	showData();

	async function showData() {
		const trainings = await getData(`{{ url('/api/v1/trainer/trainings') }}`, token);
		console.log(trainings)
		const tableContainer = document.querySelector('.table-container');
		let rowTable = '';
		// let isMaterialsNull = '';
		let number = 0;
		const currentDate = new Date();

		trainings.forEach(training => {
			number++;
			rowTable += `
				<tr>
					<th class="text-center">${number}</th>
					<td>${training.training_name} ${!training.training_materials ? '<span class="badge bg-danger ms-2"><i class="bi bi-bell me-1" style="font-size: 0.75rem;"></i>Upload materi</span>' : ''}</td>
					<td class="text-center">${dateFormatter(training.training_start)} - ${dateFormatter(training.training_end)}</td>
					<td class="text-center">${dateFormatCompare(currentDate) > dateFormatter(training.training_end) ? '<span class="badge bg-secondary text-light px-4">Selesai</span>' : dateFormatCompare(training.training_start) <= dateFormatCompare(currentDate) ? '<span class="badge bg-warning text-light">Sedang Berjalan</span>' : '<span class="badge bg-info text-light">Pendaftaran</span>'}</td>
					
					<td class="td-last"><a class="btn btn-outline-primary btn-sm btn-detail" href="#" onclick="showDetailData(${training.id})" role="button" data-bs-toggle="modal" data-bs-target="#detailModal"><i class="bi bi-info-square"></i><span class="d-none d-lg-inline ms-1">Detail</span></a></td>
					<td class="td-last"><a class="btn btn-outline-success btn-sm" href="#" role="button" data-bs-toggle="modal" data-bs-target="#uploadCvModal"><i class="bi bi-upload"></i><span class="d-none d-lg-inline ms-1">Upload</span></a></td>
					
				</tr>
			`

		})
		
		// const isMaterialsNull = Object.values(trainings[0]).every(value => {
		// 	if (value == null) {
		// 		return true;
		// 	}
		// 	return false;
		// });

		// if (Object.values(trainings[0]).includes(null)) {
		// 	return console.log('null')
		// } else {
		// 	return console.log('no null')
		// }

		tableContainer.innerHTML = rowTable;
		// console.log(isMaterialsNull);
	}

	async function showDetailData(id) {
		const training = await getDetailData(`{{ url('/api/v1/admin/training/${id}') }}`, token);
		console.log(training);
		const currentDate = new Date();

		const detailContainer = document.querySelector('.detail-container');
		detailContainer.innerHTML = `
			<div class="mb-3">
				<img src="${training.training_img}" class="img-fluid rounded" alt="">
			</div>
			<div class="mb-3 row">
				<label class="col-sm-4 col-form-label">Nama Pelatihan</label>
				<div class="col-sm-8">
					<input type="text" value="${training.training_name}" class="form-control" readonly>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-4 col-form-label">Trainer</label>
				<div class="col-sm-8">
					<input type="text" value="${training.trainer.name}" class="form-control" readonly>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-4 col-form-label">Deskripsi</label>
				<div class="col-sm-8">
					<textarea class="form-control" rows="4" readonly>${training.training_desc}</textarea>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-4 col-form-label">Harga</label>
				<div class="col-sm-8">
					<input type="text" value="${training.training_price}" class="form-control" readonly>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-4 col-form-label">Jadwal</label>
				<div class="col-sm-8">
					<input type="text" value="${dateFormatter(training.training_start)} - ${dateFormatter(training.training_end)}" class="form-control" readonly>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-4 col-form-label">Jumlah Peserta</label>
				<div class="col-sm-8">
					<input type="text" value="${training.total_participants}" class="form-control" readonly>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-4 col-form-label">Status</label>
				<div class="col-sm-8">
					<input type="text" value="${dateFormatCompare(training.training_start) <= dateFormatCompare(currentDate) ? 'Sedang Berjalan' : 'Pendaftaran'}" class="form-control" readonly>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-4 col-form-label">Grup Whatsapp</label>
				<div class="col-sm-8">
					<a href="${training.whatsapp_group}" class="btn btn-warning btn-sm" target="_blank" role="button"><i class="bi bi-link-45deg me-1"></i>Link Grup</a>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-4 col-form-label">Materi</label>
				<div class="col-sm-8">
				<div class="d-grid gap-2 col-7">
					<a class="btn btn-warning btn-sm" href="${training.training_materials}" role="button"><i class="bi bi-file-earmark-arrow-down me-1"></i>Lihat Materi Pelatihan</a>
				</div>
				</div>
			</div>
		`
	}
</script>