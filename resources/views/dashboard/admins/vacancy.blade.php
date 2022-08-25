@extends('dashboard.layouts.main')

@section('container')
<!-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
<h1 class="h2">Dashboard</h1>
</div> -->

<div class="card mt-4">
	<div class="card-header">
		<h3>Tabel Lowongan Pekerjaan</h3>
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
					<th>Nama Perusahaan</th>
					<th class="text-center">Posisi</th>
					<th class="text-center">Batas Pendaftaran</th>
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
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="detailModalLabel">Data Peserta</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body px-4 detail-container">
			
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
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="addModalLabel">Tambah Data</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body px-4 add-container">
			<div class="form-floating mb-3">
				<input type="text" class="form-control" name="company_name" id="company_name" placeholder="Nama Perusahaan">
				<label for="company_name">Nama Perusahaan</label>
			</div>
			<div class="form-floating mb-3">
				<input type="text" class="form-control" name="job_position" id="job_position" placeholder="Posisi">
				<label for="job_position">Posisi</label>
			</div>
			<div class="form-floating mb-3">
				<textarea class="form-control" name="job_description" id="job_description" placeholder="Deskripsi" style="height: 100px"></textarea>
				<label for="job_description">Deskripsi</label>
			</div>
			<div class="form-floating mb-3">
				<textarea class="form-control" name="job_requirements" id="job_requirements" placeholder="Persyaratan" style="height: 100px"></textarea>
				<label for="job_requirements">Persyaratan</label>
			</div>
			<div class="form-floating">
				<input type="date" class="form-control" name="deadline" id="deadline" placeholder="Batas Pendaftaran">
				<label for="deadline">Batas Pendaftaran</label>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
			<button type="button" class="btn btn-primary" onclick="addData()" data-bs-dismiss="modal">Tambah</button>
		</div>
		</div>
	</div>
</div>
<!-- Akhir Modal Add -->

<!-- Awal Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="editModalLabel">Edit Data</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="edit-container">

		</div>
		<!-- <div class="modal-body px-4">
			
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
			<button type="button" class="btn btn-primary" onclick="addData()" data-bs-dismiss="modal">Simpan</button>
		</div> -->
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

	async function showData() {
		const vacancies = await getData(`{{ url('/api/v1/vacancies_admin') }}`, token);
		console.log(vacancies);
		const tableContainer = document.querySelector('.table-container');
		let rowTable = '';
		let number = 0;
		const currentDate = new Date();

		vacancies.forEach(vacancy => {
			number++;
			rowTable += `
				<tr>
					<th class="text-center">${number}</th>
					<td>${vacancy.company_name}</td>
					<td class="text-center">${vacancy.job_position}</td>
					<td class="text-center">${dateFormatter(vacancy.deadline)}</td>
					<td class="text-center">${dateFormatCompare(vacancy.deadline) >= dateFormatCompare(currentDate) ? '<span class="badge text-bg-success">Dibuka</span>' : '<span class="badge text-bg-danger">Ditutup</span>'}</td>
					
					<td class="td-last"><a class="btn btn-outline-primary btn-sm btn-detail" href="#" onclick="showDetailData(${vacancy.id})" role="button" data-bs-toggle="modal" data-bs-target="#detailModal"><i class="bi bi-info-square"></i><span class="d-none d-lg-inline ms-1">Detail</span></a></td>
					<td class="td-last"><a class="btn btn-outline-success btn-sm" href="#" onclick="showEditData(${vacancy.id})" role="button" data-bs-toggle="modal" data-bs-target="#editModal"><i class="bi bi-pencil-square"></i><span class="d-none d-lg-inline ms-1">Ubah</span></a></td>
					<td class="td-last"><a class="btn btn-outline-danger btn-sm" href="#" onclick="deleteConfirmation(${vacancy.id}, '${vacancy.company_name}')" role="button"><i class="bi bi-trash"></i><span class="d-none d-lg-inline ms-1">Hapus</span></a></td>
					
				</tr>
			`
		})

		tableContainer.innerHTML = rowTable;
	}

	async function showDetailData(id) {
		const vacancy = await getDetailData(`{{ url('/api/v1/vacancy/${id}') }}`, token);
		const currentDate = new Date();

		const detailContainer = document.querySelector('.detail-container');
		detailContainer.innerHTML = `
			<div class="input-group mb-2">
				<span class="input-group-text col-4">Nama Perusahaan</span>
				<input type="text" value="${vacancy.company_name}" readonly class="form-control">
			</div>
			<div class="input-group mb-2">
				<span class="input-group-text col-4">Posisi</span>
				<input type="text" value="${vacancy.job_position}" readonly class="form-control">
			</div>
			<div class="input-group mb-2">
				<span class="input-group-text col-4">Deskripsi</span>
				<textarea class="form-control" rows="4" readonly>${vacancy.job_description}</textarea>
			</div>
			<div class="input-group mb-2">
				<span class="input-group-text col-4">Persyaratan</span>
				<textarea class="form-control" rows="4" readonly>${vacancy.job_requirements}</textarea>
			</div>
			<div class="input-group mb-2">
				<span class="input-group-text col-4">Batas Pendaftaran</span>
				<input type="text" value="${dateFormatter(vacancy.deadline)}" readonly class="form-control">
			</div>
			<div class="input-group">
				<span class="input-group-text col-4">Status</span>
				<input type="text" value="${dateFormatter(vacancy.deadline) >= dateFormatter(currentDate) ? 'Dibuka' : 'Ditutup'}" readonly class="form-control">
			</div>
		`
	}

	function addData() {
		let data = {
			company_name : document.getElementById('company_name').value,
			job_position : document.getElementById('job_position').value,
			job_description : document.getElementById('job_description').value,
			job_requirements : document.getElementById('job_requirements').value,
			deadline : document.getElementById('deadline').value,
		}

		fetch(`{{ url('/api/v1/vacancy') }}`, {
			method: 'POST',
			body: JSON.stringify(data),
			headers: {
				"Content-type": "application/json; charset=UTF-8",
				'Authorization' : `Bearer ${token}`,
			}
		})
		.then(response => response.json())
		.then(json => {
			console.log(json);
			swal({
				title: "Good job!",
				text: "You clicked the button!",
				icon: "success",
			});
			showData();
		})
		.catch(err => console.log(err))
	}

	async function showEditData(id) {
		const vacancy = await getDetailData(`{{ url('/api/v1/vacancy/${id}') }}`, token);
		const editContainer = document.querySelector('.edit-container');

		editContainer.innerHTML = `
			<div class="modal-body px-4">
			<div class="form-floating mb-3">
				<input type="text" value="${vacancy.company_name}" class="form-control" name="company_name" id="company_name_edit" placeholder="Nama Perusahaan">
				<label for="company_name">Nama Perusahaan</label>
			</div>
			<div class="form-floating mb-3">
				<input type="text" value="${vacancy.job_position}" class="form-control" name="job_position" id="job_position_edit" placeholder="Posisi">
				<label for="job_position">Posisi</label>
			</div>
			<div class="form-floating mb-3">
				<textarea class="form-control" name="job_description" id="job_description_edit" placeholder="Deskripsi" style="height: 100px">${vacancy.job_description}</textarea>
				<label for="job_description">Deskripsi</label>
			</div>
			<div class="form-floating mb-3">
				<textarea class="form-control" name="job_requirements" id="job_requirements_edit" placeholder="Persyaratan" style="height: 100px">${vacancy.job_requirements}</textarea>
				<label for="job_requirements">Persyaratan</label>
			</div>
			<div class="form-floating">
				<input type="date" value="${vacancy.deadline}" class="form-control" name="deadline" id="deadline_edit" placeholder="Batas Pendaftaran">
				<label for="deadline">Batas Pendaftaran</label>
			</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
				<button type="button" class="btn btn-primary" onclick="editData(${vacancy.id})" data-bs-dismiss="modal">Simpan</button>
			</div>
		`
	}

	function editData(id) {
		let data = {
			company_name : document.getElementById('company_name_edit').value,
			job_position : document.getElementById('job_position_edit').value,
			job_description : document.getElementById('job_description_edit').value,
			job_requirements : document.getElementById('job_requirements_edit').value,
			deadline : document.getElementById('deadline_edit').value,
		}

		fetch(`{{ url('/api/v1/vacancy/${id}') }}`, {
			method: 'PUT',
			body: JSON.stringify(data),
			headers: {
				'Content-type': 'application/json; charset=UTF-8',
				'Authorization' : `Bearer ${token}`,
			}
		})
		.then(response => response.json())
		.then(json => {
			console.log(json);
			swal({
				title: "Sukses",
				text: "Data berhasil diubah.",
				icon: "success",
			});
			showData();
		})
		.catch(err => console.log(err))
	}

	function deleteConfirmation(id, name) {
		swal({
			title: `Apakah anda yakin ingin menghapus data ${name}?`,
			icon: "warning",
			buttons: true,
			dangerMode: true,
			})
			.then((willDelete) => {
			if (willDelete) {
				try {
					deleteData(`{{ url('/api/v1/vacancy/${id}') }}`, token);
					swal("Data berhasil dihapus", {
						icon: "success",
					});
					showData()
				} catch (error) {
					
					swal("Data gagal dihapus", {
						icon: "error",
					});
				}
			}
		});
	}
</script>