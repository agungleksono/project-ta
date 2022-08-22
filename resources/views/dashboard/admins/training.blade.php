@extends('dashboard.layouts.main')

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
		<div>
			<a class="btn btn-primary btn-sm my-2" href="#" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-plus-square me-2"></i>Tambah Data</a>
		</div>
		<div class="table-responsive-sm">
			<table class="table table-hover">
			<thead>
				<tr>
					<th class="text-center">No.</th>
					<th>Nama Pelatihan</th>
					<th class="text-center">Tanggal Pelatihan</th>
					<th class="text-center">Status</th>
					<th colspan="3" class="text-center">Aksi</th>
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

<!-- Awal Modal Add -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="addModalLabel">Tambah Data</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body px-4 add-container">
			<form action="" id="addForm">	
			<div class="row g-3">
				<div class="col-md-7">
					<label class="form-label" for="training_name">Nama Pelatihan</label>
					<input type="text" class="form-control" name="training_name" id="training_name" placeholder="Nama Pelatihan" required>
				</div>
				<div class="col-md-5">
					<label class="form-label" for="trainer_id">Trainer</label>
					<select id="trainer_id" name="trainer_id" class="form-select trainer-select">
						<option selected>Pilih Trainer</option>
					</select>
				</div>
				<div class="col-12">
					<label class="form-label" for="training_desc">Deskripsi</label>
					<textarea class="form-control" name="training_desc" id="training_desc" placeholder="Deskripsi"></textarea>
				</div>
				<div class="col-md-4">
					<label class="form-label" for="training_price">Harga</label>
					<input type="number" class="form-control" name="training_price" id="training_price" placeholder="Harga">
				</div>
				<div class="col-md-8">
					<label class="form-label" for="training_start">Tanggal Pelatihan</label>
					<div class="row">
						<div class="col">
							<input type="date" class="form-control" name="training_start" id="training_start">
						</div>
						<div class="col-md-auto text-center mt-1">
							<b>-</b>
						</div>
						<div class="col">
							<input type="date" class="form-control" name="training_end" id="training_end">
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<label class="form-label" for="training_img">Pilih Pamflet</label>
					<input type="file" class="form-control" name="training_img" id="training_img">
				</div>
				<div class="col-md-6">
					<label class="form-label" for="whatsapp_group">Link Grup Whatsapp</label>
					<input type="text" class="form-control" name="whatsapp_group" id="whatsapp_group" placeholder="Link Grup Whatsapp">
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
			<button type="submit" class="btn btn-primary">Tambah</button>
		</div>
	</form>
		</div>
	</div>
</div>
<!-- Akhir Modal Add -->

<!-- Awal Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg  modal-dialog-centered">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="editModalLabel">Edit Data</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<!-- <div class="edit-container">

		</div> -->
		<div class="modal-body px-4">
		<form action="" id="addForm">
			<div class="row g-3 edit-container">

			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
			<button type="button" class="btn btn-primary" onclick="addData()" data-bs-dismiss="modal">Simpan</button>
		</div>
		</form>
		</div>
	</div>
</div>
<!-- Akhir Modal Edit -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="/js/script.js" type = "text/javascript"></script>
<script>
	const token = getCookie('token');
	console.log(token);

	showData();
	showTrainer();
	performAddData();

	async function showData() {
		const trainings = await getData(`{{ url('/api/v1/admin/trainings') }}`, token);
		console.log(trainings)
		const tableContainer = document.querySelector('.table-container');
		let rowTable = '';
		let number = 0;
		const currentDate = new Date();

		trainings.forEach(training => {
			number++;
			rowTable += `
				<tr>
					<th class="text-center">${number}</th>
					<td>${training.training_name}</td>
					<td class="text-center">${dateFormatter(training.training_start)} - ${dateFormatter(training.training_end)}</td>
					<td class="text-center">${dateFormatCompare(training.training_start) <= dateFormatCompare(currentDate) ? '<span class="badge text-bg-warning">Sedang Berjalan</span>' : '<span class="badge text-bg-info">Pendaftaran</span>'}</td>
					
					<td class="td-last"><a class="btn btn-outline-primary btn-sm btn-detail" href="#" onclick="showDetailData(${training.id})" role="button" data-bs-toggle="modal" data-bs-target="#detailModal"><i class="bi bi-info-square"></i><span class="d-none d-lg-inline ms-1">Detail</span></a></td>
					<td class="td-last"><a class="btn btn-outline-success btn-sm" href="#" onclick="showEditData(${training.id})" role="button" data-bs-toggle="modal" data-bs-target="#editModal"><i class="bi bi-pencil-square"></i><span class="d-none d-lg-inline ms-1">Ubah</span></a></td>
					<td class="td-last"><a class="btn btn-outline-danger btn-sm" href="#" onclick="deleteConfirmation(${training.id}, '${training.name}')" role="button"><i class="bi bi-trash"></i><span class="d-none d-lg-inline ms-1">Hapus</span></a></td>
					
				</tr>
			`
		})

		tableContainer.innerHTML = rowTable;
	}

	async function showTrainer() {
		const trainers = await getData(`{{ url('/api/v1/trainers') }}`, token);
		const trainerSelect = document.querySelector('.trainer-select');
		trainerSelect.innerHTML = '<option selected disabled>Pilih Trainer...</option>';
		trainers.forEach(trainer => {
			trainerSelect.innerHTML += `<option value="${trainer.trainer_id}">${trainer.name}</option>`;
		})
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

	function performAddData() {
		// let data = {
		// 		training_name: document.getElementById('training_name').value,
		// 		training_desc: document.getElementById('training_desc').value,
		// 		training_price: document.getElementById('training_price').value,
		// 		training_start: document.getElementById('training_start').value,
		// 		training_end: document.getElementById('training_end').value,
		// 		whatsapp_group: document.getElementById('whatsapp_group').value,
		// 		trainer_id: document.getElementById('trainer_id').value,
		// 		training_img: document.getElementById('training_img').files[0],
		// 	}
		// return console.log(data);
		const addForm = document.getElementById('addForm');
		const trainingName = document.getElementById('training_name');
		const trainingDesc = document.getElementById('training_desc');
		const trainingPrice = document.getElementById('training_price');
		const trainingStart = document.getElementById('training_start');
		const trainingEnd = document.getElementById('training_end');
		const whatsappGroup = document.getElementById('whatsapp_group');
		const trainerId = document.getElementById('trainer_id');
		const trainingImg = document.getElementById('training_img');

		addForm.addEventListener('submit', e => {
			e.preventDefault();			

			const formData = new FormData();

			formData.append('training_name', trainingName.value);
			formData.append('training_desc', trainingDesc.value);
			formData.append('training_price', trainingPrice.value);
			formData.append('training_start', trainingStart.value);
			formData.append('training_end', trainingEnd.value);
			formData.append('whatsapp_group', whatsappGroup.value);
			formData.append('trainer_id', trainerId.value);
			formData.append('training_img', trainingImg.files[0]);

			fetch(`{{ url('/api/v1/training') }}`, {
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
				.then((value) => window.location.href = `{{ url('/admin/pelatihan') }}`);
			})
			.catch(err => console.log(err))
		})
	}

	async function showEditData(id) {
		const training = await getDetailData(`{{ url('/api/v1/admin/training/${id}') }}`, token);
		const editContainer = document.querySelector('.edit-container');

		editContainer.innerHTML = `
			<div class="col-md-7">
				<label class="form-label" for="training_name">Nama Pelatihan</label>
				<input type="text" value="${training.training_name}" class="form-control" name="training_name" id="training_name" placeholder="Nama Pelatihan" required>
			</div>
			<div class="col-md-5">
				<label class="form-label" for="trainer_id">Trainer</label>
				<select id="trainer_id" name="trainer_id" class="form-select trainer-select">
					<option value="${training.trainer.id}" selected>${training.trainer.name}</option>
				</select>
			</div>
			<div class="col-12">
				<label class="form-label" for="training_desc">Deskripsi</label>
				<textarea class="form-control" name="training_desc" id="training_desc" placeholder="Deskripsi">${training.training_desc}</textarea>
			</div>
			<div class="col-md-4">
				<label class="form-label" for="training_price">Harga</label>
				<input type="number" value="${training.training_price}" class="form-control" name="training_price" id="training_price" placeholder="Harga">
			</div>
			<div class="col-md-8">
				<label class="form-label" for="training_start">Tanggal Pelatihan</label>
				<div class="row">
					<div class="col">
						<input type="date" value="${training.training_start}" class="form-control" name="training_start" id="training_start">
					</div>
					<div class="col-md-auto text-center mt-1">
						<b>-</b>
					</div>
					<div class="col">
						<input type="date" value="${training.training_end}" class="form-control" name="training_end" id="training_end">
					</div>
				</div>
			</div>
			<div class="col-12">
				<label class="form-label" for="whatsapp_group">Link Grup Whatsapp</label>
				<input type="text" value="${training.whatsapp_group}" class="form-control" name="whatsapp_group" id="whatsapp_group" placeholder="Link Grup Whatsapp">
			</div>
			<div class="col-12">
				<label class="form-label" for="training_img">Pilih Pamflet</label>
				<img src="${training.training_img ? training.training_img : ''}" class="img-fluid col-md-3 mb-2 d-block">
				<input type="file" class="form-control" name="training_img" id="training_img">
			</div>
		`
	}
</script>