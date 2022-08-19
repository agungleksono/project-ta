@extends('dashboard.layouts.main')

@section('container')
<!-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
<h1 class="h2">Dashboard</h1>
</div> -->

<div class="card mt-4">
	<div class="card-header">
		<h3>Tabel Trainer</h3>
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
					<th>Nama Trainer</th>
					<th class="text-center">Email</th>
					<th class="text-center">Domisili</th>
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
			<form action="" id="addForm">
			<div class="form-floating mb-3">
				<input type="text" class="form-control" name="name" id="name" placeholder="Nama Trainer" required>
				<label for="name">Nama Trainer</label>
			</div>
			<div class="form-floating mb-3">
				<input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
				<label for="username">Username</label>
			</div>
			<div class="form-floating mb-3">
				<input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
				<label for="email">Email</label>
			</div>
			<div class="form-floating mb-3">
				<input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
				<label for="password">Password</label>
			</div>
			<div class="form-floating mb-3">
				<input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password" required>
				<label for="password_confirmation">Konfirmasi Password</label>
			</div>
			<div class="form-floating mb-3">
				<input type="text" class="form-control" name="address" id="address" placeholder="Domisili" required>
				<label for="address">Domisili</label>
			</div>
			<div class="form-floating mb-3">
				<input type="text" class="form-control" name="phone" id="phone" placeholder="No. HP" required>
				<label for="phone">No. HP</label>
			</div>
			<div class="mb-3">
				<label for="formFile" class="form-label">CV</label>
				<input class="form-control" type="file" name="cv" id="cv" required>
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
		const trainers = await getData(`{{ url('/api/v1/trainers') }}`, token);
		console.log(trainers)
		const tableContainer = document.querySelector('.table-container');
		let rowTable = '';
		let number = 0;
		const currentDate = new Date();

		trainers.forEach(trainer => {
			number++;
			rowTable += `
				<tr>
					<th class="text-center">${number}</th>
					<td><img src="https://ui-avatars.com/api/?background=random&rounded=true&size=32&name=${trainer.name}" class="me-3">${trainer.name}</td>
					<td class="text-center">${trainer.email}</td>
					<td class="text-center">${trainer.address}</td>
					
					<td class="td-last"><a class="btn btn-outline-primary btn-sm btn-detail" href="#" onclick="showDetailData(${trainer.id})" role="button" data-bs-toggle="modal" data-bs-target="#detailModal"><i class="bi bi-info-square"></i><span class="d-none d-lg-inline ms-1">Detail</span></a></td>
					<td class="td-last"><a class="btn btn-outline-danger btn-sm" href="#" onclick="deleteConfirmation(${trainer.id}, '${trainer.name}')" role="button"><i class="bi bi-trash"></i><span class="d-none d-lg-inline ms-1">Hapus</span></a></td>
					
				</tr>
			`
		})

		tableContainer.innerHTML = rowTable;
	}

	async function showDetailData(id) {
		const trainer = await getDetailData(`{{ url('/api/v1/trainer/${id}') }}`, token);
		const detailContainer = document.querySelector('.detail-container');
		detailContainer.innerHTML = `
			<div class="input-group mb-2">
				<span class="input-group-text col-3">Nama</span>
				<input type="text" value="${trainer.trainer.name}" readonly class="form-control">
			</div>
			<div class="input-group mb-2">
				<span class="input-group-text col-3">Username</span>
				<input type="text" value="${trainer.username}" readonly class="form-control">
			</div>
			<div class="input-group mb-2">
				<span class="input-group-text col-3">Email</span>
				<input type="text" value="${trainer.email}" readonly class="form-control">
			</div>
			<div class="input-group mb-2">
				<span class="input-group-text col-3">Domisili</span>
				<input type="text" value="${trainer.trainer.address}" readonly class="form-control">
			</div>
			<div class="input-group mb-2">
				<span class="input-group-text col-3">No. HP</span>
				<input type="text" value="${trainer.trainer.phone}" readonly class="form-control">
			</div>
			<div class="d-grid gap-2 col-6 mx-auto">
				<a class="btn btn-info btn-sm" href="${trainer.trainer.cv}" role="button">Lihat CV</a>
			</div>
		`
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
					deleteData(`{{ url('/api/v1/trainer/${id}') }}`, token);
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

	// function performAddData() {
		// let data = {
		// 	name : document.getElementById('name').value,
		// 	username : document.getElementById('username').value,
		// 	email : document.getElementById('email').value,
		// 	password : document.getElementById('password').value,
		// 	password_confirmation : document.getElementById('password_confirmation').value,
		// 	address : document.getElementById('address').value,
		// 	phone : document.getElementById('phone').value,
		// 	cv : document.getElementById('cv'),
		// }
		// return console.log(data);
		// if (!Object.values(data).every(o => o === null)) {
		// 	return false
		// }

		const addForm = document.getElementById('addForm');
		const name = document.getElementById('name');
		const username = document.getElementById('username');
		const email = document.getElementById('email');
		const password = document.getElementById('password');
		const password_confirmation = document.getElementById('password_confirmation');
		const address = document.getElementById('address');
		const phone = document.getElementById('phone');
		const cv = document.getElementById('cv');

		addForm.addEventListener('submit', e => {
			e.preventDefault();

			const formData = new FormData();

			formData.append('name', name.value);
			formData.append('username', username.value);
			formData.append('email', email.value);
			formData.append('password', password.value);
			formData.append('password_confirmation', password_confirmation.value);
			formData.append('address', address.value);
			formData.append('phone', phone.value);
			formData.append('cv', cv.files[0]);

			fetch(`{{ url('/api/v1/auth/register/trainer') }}`, {
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
				.then((value) => window.location.href = `{{ url('/admin/trainer') }}`);
			})
			.catch(err => console.log(err))
		})


		// addData(`{{ url('/api/v1/auth/register/trainer') }}`, data, token);
	// }
</script>