@extends('dashboard.layouts.main')

@section('container')
<!-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
<h1 class="h2">Dashboard</h1>
</div> -->

<div class="card mt-4">
	<div class="card-header">
		<h3>Tabel Peserta</h3>
	</div>
	<div class="card-body">
		<!-- <h5 class="card-title">Tabel Admin</h5>
		<div>
			<a class="btn btn-primary btn-sm my-2" href="#"><i class="bi bi-plus-square me-2"></i>Tambah Data</a>
		</div> -->
		<div class="table-responsive-sm">
			<table class="table table-hover">
			<thead>
				<tr>
					<th class="text-center">No.</th>
					<th>Nama</th>
					<th>Email</th>
					<th>Alamat</th>
					<th colspan="2">Aksi</th>
				</tr>
			</thead>
			<tbody class="table-container">
				
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
			<h5 class="modal-title" id="exampleModalLabel">Data Peserta</h5>
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

<!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="/js/script.js" type = "text/javascript"></script>
<script>
	const token = getCookie('token');
	console.log(token);

	function getData() {
		return fetch(`{{ url('/api/v1/customers') }}`, {
					method: 'GET',
					headers: {
						"Content-type": "application/json",
						"Accept": "application/json",
						"Authorization" : `Bearer ${token}`
					}
				})
				.then(response => response.json())
				.then(response => response.data)
	}

	async function showData() {
		// const customers = await getData(`{{ url('/api/v1/customers') }}`, token);
		const customers = await getData();
		console.log(customers);
		const tableContainer = document.querySelector('.table-container');
		let rowTable = '';
		let number = 0;

		customers.forEach(customer => {
			number++;
			rowTable += `
				<tr>
					<th class="text-center">${number}</th>
					<td><img src="https://ui-avatars.com/api/?background=random&rounded=true&size=32&name=${customer.customer.name}" class="me-3">${customer.customer.name}</td>
					<td>${customer.email}</td>
					<td>${customer.customer.address}</td>
					
					<td class="td-last"><a class="btn btn-outline-primary btn-sm btn-detail" href="#" data-id="${customer.id}" onclick="showDetailData(${customer.id})" role="button" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-info-square"></i><span class="d-none d-lg-inline ms-1">Detail</span></a></td>
					<td class="td-last"><a class="btn btn-outline-danger btn-sm" href="#" onclick="deleteConfirmation(${customer.id}, '${customer.customer.name}')" role="button"><i class="bi bi-trash"></i><span class="d-none d-lg-inline ms-1">Hapus</span></a></td>
					
				</tr>
			`
		})

		tableContainer.innerHTML = rowTable;
	}

	showData();

	async function showDetailData(id) {
		const customer = await getDetailData(`{{ url('/api/v1/customer/${id}') }}`, token);
		console.log(customer)
		const detailContainer = document.querySelector('.detail-container');
		detailContainer.innerHTML = `
			<div class="input-group mb-2">
				<span class="input-group-text col-3">Nama</span>
				<input type="text" value="${customer.customer.name}" readonly class="form-control">
			</div>
			<div class="input-group mb-2">
				<span class="input-group-text col-3">Username</span>
				<input type="text" value="${customer.username}" readonly class="form-control">
			</div>
			<div class="input-group mb-2">
				<span class="input-group-text col-3">Email</span>
				<input type="text" value="${customer.email}" readonly class="form-control">
			</div>
			<div class="input-group mb-2">
				<span class="input-group-text col-3">Alamat</span>
				<input type="text" value="${customer.customer.address}" readonly class="form-control">
			</div>
			<div class="input-group">
				<span class="input-group-text col-3">No. HP</span>
				<input type="text" value="${customer.customer.phone}" readonly class="form-control">
			</div>
		`
	}

	function deleteConfirmation(id, name) {
		swal({
			title: `Apakah anda yakin ingin menghapus data ${name}?`,
			// text: "Anda yakin ingin menghapus data ini?",
			icon: "warning",
			buttons: true,
			dangerMode: true,
			})
			.then((willDelete) => {
			if (willDelete) {
				try {
					deleteData(id);
					swal("Data berhasil dihapus", {
					icon: "success",
					});
				} catch (error) {
					
					swal("Data gagal dihapus", {
					icon: "error",
					});
				}
			}
		});
	}

	function deleteData(id) {
		return fetch(`{{ url('/api/v1/customer/${id}') }}`, {
			method: 'DELETE',
			headers: {
				'Authorization' : `Bearer ${token}`
			}
		})
		.then(response => response.json())
		.then(json => {
			console.log(json)
			showData()
		})
		.catch(err => consolo.log(err))
	}
</script>