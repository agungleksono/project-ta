@extends('dashboard.layouts.main')

@section('container')
<!-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
<h1 class="h2">Dashboard</h1>
</div> -->

<div class="card mt-4">
	<div class="card-header">
		<h3>Pengaturan Akun</h3>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-6 profile-container">
				
			</div>
			<div class="mt-2">
				<a class="btn btn-outline-success btn-sm btn-upload" href="#" onclick="getDataProfile()" role="button" data-bs-toggle="modal" data-bs-target="#editProfileModal"><i class="bi bi-upload"></i><span class="d-none d-lg-inline ms-1">Ubah Data Profil</span></a>
			</div>
    	</div>
	</div>
</div>
@endsection

<!-- Awal Modal Detail -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="editProfileModalLabel">Ubah Data Profil</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body px-3 edit-container">
				<!-- <div class="col mb-3">
					<label class="form-label" for="name">Nama</label>
					<input type="text" class="form-control" name="name" id="name" placeholder="Nama" required>
				</div>
				<div class="col mb-3">
					<label class="form-label" for="username">Username</label>
					<input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
				</div>
				<div class="col mb-3">
					<label class="form-label" for="address">Alamat</label>
					<input type="text" class="form-control" name="address" id="address" placeholder="Alamat" required>
				</div>
				<div class="col">
					<label class="form-label" for="phone">No. HP</label>
					<input type="text" class="form-control" name="phone" id="phone" placeholder="No. HP" required>
				</div> -->
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" onclick="editProfile()">Simpan</button>
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		</div>
		</div>
	</div>
</div>
<!-- Akhir Modal Detail -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="/js/script.js" type = "text/javascript"></script>
<script>
	const token = getCookie('token');
	console.log(token);

	showData();

	async function showData() {
		const admin = await getData(`{{ url('/api/v1/admin/profile') }}`, token);
		console.log(admin)
		const profileContainer = document.querySelector('.profile-container');

		profileContainer.innerHTML = `
			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label">Nama</label>
				<div class="col-sm-9">
					<input type="text" value="${admin.administrator.name}" class="form-control" readonly>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label">Username</label>
				<div class="col-sm-9">
					<input type="text" value="${admin.username}" class="form-control" readonly>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label">Email</label>
				<div class="col-sm-9">
					<input type="text" value="${admin.email}" class="form-control" readonly>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label">Alamat</label>
				<div class="col-sm-9">
					<input type="text" value="${admin.administrator.address}" class="form-control" readonly>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label">No. HP</label>
				<div class="col-sm-9">
					<input type="text" value="${admin.administrator.phone}" class="form-control" readonly>
				</div>
			</div>
		`
	}

	async function getDataProfile() {
		const admin = await getData(`{{ url('/api/v1/admin/profile') }}`, token);
		const editContainer = document.querySelector('.edit-container');

		editContainer.innerHTML = `
				<div class="col mb-3">
					<label class="form-label" for="name">Nama</label>
					<input type="text" class="form-control" value="${admin.administrator.name}" name="name" id="name" placeholder="Nama" required>
				</div>
				<div class="col mb-3">
					<label class="form-label" for="username">Username</label>
					<input type="text" class="form-control" value="${admin.username}" name="username" id="username" placeholder="Username" required>
				</div>
				<div class="col mb-3">
					<label class="form-label" for="address">Alamat</label>
					<input type="text" class="form-control" value="${admin.administrator.address}" name="address" id="address" placeholder="Alamat" required>
				</div>
				<div class="col">
					<label class="form-label" for="phone">No. HP</label>
					<input type="text" class="form-control" value="${admin.administrator.phone}" name="phone" id="phone" placeholder="No. HP" required>
				</div>
		`
	}

	function editProfile() {
		const formData = new FormData();

		formData.append('name', document.getElementById('name').value);
		formData.append('username', document.getElementById('username').value);
		formData.append('address', document.getElementById('address').value);
		formData.append('phone', document.getElementById('phone').value);

		fetch(`{{ url('/api/v1/admin/profile') }}`, {
			method: 'POST',
			body: formData,
			headers: {
				'Authorization' : `Bearer ${token}`,
			}
		})
		.then(response => response.json())
		.then(json => {
			if (json.meta.status == 'error') {
					return swal({
						title: "Gagal",
						text: `${json.meta.message}`,
						icon: "error",
					});
				}
				swal({
					title: "Sukses",
					text: "Profil berhasil diubah.",
					icon: "success",
					buttons: true,
				})
				.then((value) => window.location.href = `{{ url('/admin/profile') }}`);
		})
	}
</script>