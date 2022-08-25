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
	<div class="col-md-3 mb-5 me-4 bg-body rounded card-dashboard position-relative border-start border-warning border-5" id="card">
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
</script>