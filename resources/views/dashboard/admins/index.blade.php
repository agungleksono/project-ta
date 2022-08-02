@extends('dashboard.layouts.main')

@section('container')
<!-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
<h1 class="h2">Dashboard</h1>
</div> -->

<div class="card mt-4">
	<div class="card-header">
		<h2>Admin</h2>
	</div>
	<div class="card-body">
		<h5 class="card-title">Tabel Admin</h5>
		<div>
			<a class="btn btn-primary btn-sm my-2" href="#"><i class="bi bi-plus-square me-2"></i>Tambah Data</a>
		</div>
		<div class="table-responsive-sm">
			<table class="table table-hover text-center">
			<thead>
				<tr>
					<th scope="col">No.</th>
					<th scope="col">Nama</th>
					<th scope="col">Alamat</th>
					<th scope="col">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th>1</th>
					<td>Mark Zuckeberg</td>
					<td>Semarang</td>
					<td>
						<a class="btn btn-outline-primary btn-sm" href="#" role="button" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-info-square"></i><span class="d-none d-lg-inline ms-1">Detail</span></a>
						<a class="btn btn-outline-success btn-sm" href="#" role="button"><i class="bi bi-pencil-square"></i><span class="d-none d-lg-inline ms-1">Ubah</span></a>
						<a class="btn btn-outline-danger btn-sm" href="#" role="button"><i class="bi bi-trash"></i><span class="d-none d-lg-inline ms-1">Hapus</span></a>
					</td>
				</tr>
				<tr>
					<th>2</th>
					<td>Jacob</td>
					<td>Semarang</td>
					<td>
						<a class="btn btn-outline-primary btn-sm" href="#" role="button"><i class="bi bi-info-square"></i><span class="d-none d-lg-inline ms-1">Detail</span></a>
						<a class="btn btn-outline-success btn-sm" href="#" role="button"><i class="bi bi-pencil-square"></i><span class="d-none d-lg-inline ms-1">Ubah</span></a>
						<a class="btn btn-outline-danger btn-sm" href="#" role="button"><i class="bi bi-trash"></i><span class="d-none d-lg-inline ms-1">Hapus</span></a>
					</td>
				</tr>
				<tr>
					<th>3</th>
					<td>Larry the Bird</td>
					<td>Semarang</td>
					<td>
						<a class="btn btn-outline-primary btn-sm" href="#" role="button"><i class="bi bi-info-square"></i><span class="d-none d-lg-inline ms-1">Detail</span></a>
						<a class="btn btn-outline-success btn-sm" href="#" role="button"><i class="bi bi-pencil-square"></i><span class="d-none d-lg-inline ms-1">Ubah</span></a>
						<a class="btn btn-outline-danger btn-sm" href="#" role="button"><i class="bi bi-trash"></i><span class="d-none d-lg-inline ms-1">Hapus</span></a>
					</td>
				</tr>
			</tbody>
			</table>
		</div>
	</div>
</div>
@endsection

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>