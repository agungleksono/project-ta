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
</script>