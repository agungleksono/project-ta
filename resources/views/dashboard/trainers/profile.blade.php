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
		<div class="row d-flex justify-content-center">
			<div class="col-md-3 rounded me-3" id="card">
				<div class="row col-8 mt-5 mb-3 mx-auto img-container">
					<img src="..." class="rounded-circle" alt="...">
				</div>
				<div class="row d-grid gap-2 col-7 mx-auto mb-2">
					<a class="btn btn-warning btn-sm text-light fw-semibold btn-upload" href="#" onclick="" role="button" data-bs-toggle="modal" data-bs-target="#editImageModal"><span class="d-none d-lg-inline ms-1">Ubah Foto</span></a>
				</div>
				<div class="row d-grid gap-2 col-7 mx-auto">
					<a class="btn btn-warning btn-sm text-light fw-semibold btn-upload" href="#" onclick="" role="button" data-bs-toggle="modal" data-bs-target="#editCvModal"><span class="d-none d-lg-inline ms-1">Upload CV</span></a>
				</div>
			</div>
			<div class="col-md-6 p-4 rounded" id="card">
				<div class="col profile-container">
					<!-- <div class="mb-3 row">
						<label class="col-sm-3 col-form-label">Nama</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" readonly>
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-sm-3 col-form-label">Username</label>
						<div class="col-sm-9">
						<input type="text" class="form-control" readonly>
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-sm-3 col-form-label">Email</label>
						<div class="col-sm-9">
						<input type="text" class="form-control" readonly>
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-sm-3 col-form-label">Alamat</label>
						<div class="col-sm-9">
						<input type="text" class="form-control" readonly>
						</div>
					</div>
					<div class="mb-3 row">
						<label class="col-sm-3 col-form-label">No. HP</label>
						<div class="col-sm-9">
						<input type="text" class="form-control" readonly>
						</div>
					</div> -->
				</div>
				<div class="mt-2 d-flex justify-content-center">
					<a class="btn btn-success btn-sm text-light fw-semibold btn-upload" href="#" onclick="getDataProfile()" role="button" data-bs-toggle="modal" data-bs-target="#editProfileModal"></i><span class="d-none d-lg-inline ms-1">Ubah Data Profil</span></a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

<!-- Awal Modal Edit Profil -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="editProfileModalLabel">Ubah Data Profil</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body px-3 edit-profile-container">
			
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" onclick="editProfile()">Simpan</button>
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		</div>
		</div>
	</div>
</div>
<!-- Akhir Modal Edit Profil -->

<!-- Awal Modal Edit Image -->
<div class="modal fade" id="editImageModal" tabindex="-1" aria-labelledby="editImageModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="editImageModalLabel">Ubah Foto Profil</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body mx-4 edit-image-container">
			<div class="row">
				<label class="form-label" for="photo">Pilih Foto</label>
				<input type="file" class="form-control" name="photo" id="photo" required>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" onclick="editProfileImage()">Simpan</button>
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		</div>
		</div>
	</div>
</div>
<!-- Akhir Modal Edit Image -->

<!-- Awal Modal Edit Image -->
<div class="modal fade" id="editCvModal" tabindex="-1" aria-labelledby="editCvModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="editCvModalLabel">Ubah CV</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body mx-4 edit-image-container">
			<div class="row">
				<label class="form-label" for="cv">Pilih CV</label>
				<input type="file" class="form-control" name="cv" id="cv" required>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary" onclick="editCv()">Simpan</button>
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		</div>
		</div>
	</div>
</div>
<!-- Akhir Modal Edit Image -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="/js/script.js" type = "text/javascript"></script>
<script>
	const token = getCookie('token');
	console.log(token);

	showData();

	async function showData() {
		const trainer = await getData(`{{ url('/api/v1/trainer/profile') }}`, token);
		console.log(trainer);

		const imgContainer = document.querySelector('.img-container');
		const profileContainer = document.querySelector('.profile-container');

		imgContainer.innerHTML = `
			<img src="${trainer.photo ? trainer.photo : `https://ui-avatars.com/api/?background=random&rounded=true&size=32&name=${trainer.name}`}" class="rounded-circle" alt="...">
		`
		profileContainer.innerHTML = `
			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label">Nama</label>
				<div class="col-sm-9">
					<input type="text" value="${trainer.name}" class="form-control" readonly>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label">Username</label>
				<div class="col-sm-9">
					<input type="text" value="${trainer.username}" class="form-control" readonly>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label">Email</label>
				<div class="col-sm-9">
					<input type="text" value="${trainer.email}" class="form-control" readonly>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label">Alamat</label>
				<div class="col-sm-9">
					<input type="text" value="${trainer.address}" class="form-control" readonly>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-3 col-form-label">No. HP</label>
				<div class="col-sm-9">
					<input type="text" value="${trainer.phone}" class="form-control" readonly>
				</div>
			</div>
		`
	}

	async function getDataProfile() {
		const trainer = await getData(`{{ url('/api/v1/trainer/profile') }}`, token);
		const editProfileContainer = document.querySelector('.edit-profile-container');

		editProfileContainer.innerHTML = `
			<div class="col mb-3">
				<label class="form-label" for="name">Nama</label>
				<input type="text" value="${trainer.name}" class="form-control" name="name" id="name" placeholder="Nama" required>
			</div>
			<div class="col mb-3">
				<label class="form-label" for="username">Username</label>
				<input type="text" value="${trainer.username}" class="form-control" name="username" id="username" placeholder="Username" required>
			</div>
			<div class="col mb-3">
				<label class="form-label" for="address">Alamat</label>
				<input type="text" value="${trainer.address}" class="form-control" name="address" id="address" placeholder="Alamat" required>
			</div>
			<div class="col">
				<label class="form-label" for="phone">No. HP</label>
				<input type="text" value="${trainer.phone}" class="form-control" name="phone" id="phone" placeholder="No. HP" required>
			</div>
		`
	}

	function editProfile() {
		const formData = new FormData();

		formData.append('name', document.getElementById('name').value);
		formData.append('username', document.getElementById('username').value);
		formData.append('address', document.getElementById('address').value);
		formData.append('phone', document.getElementById('phone').value);

		fetch(`{{ url('/api/v1/trainer/profile') }}`, {
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
			.then((value) => window.location.href = `{{ url('/trainer/profile') }}`);
		})
	}

	function editProfileImage() {
		const formData = new FormData();

		formData.append('photo', document.getElementById('photo').files[0]);

		fetch(`{{ url('/api/v1/trainer/profile/image') }}`, {
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
			.then((value) => window.location.href = `{{ url('/trainer/profile') }}`);
		})
	}

	function editCv() {
		const formData = new FormData();

		formData.append('cv', document.getElementById('cv').files[0]);

		fetch(`{{ url('/api/v1/trainer/profile/cv') }}`, {
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
			.then((value) => window.location.href = `{{ url('/trainer/profile') }}`);
		})
	}
</script>