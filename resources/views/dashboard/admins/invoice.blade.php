@extends('dashboard.layouts.main')

@section('container')
<!-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
<h1 class="h2">Dashboard</h1>
</div> -->

<div class="card mt-4">
	<div class="card-header">
		<h3>Tabel Transaksi Pembayaran</h3>
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
					<th>Kode Pembayaran</th>
					<th class="text-center">Total</th>
					<th class="text-center">Tanggal Pembayaran</th>
					<th class="text-center">Nama Customer</th>
					<th class="text-center">Pelatihan</th>
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

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="/js/script.js" type = "text/javascript"></script>
<script>
	const token = getCookie('token');
	console.log(token);

	showData();

	async function showData() {
		const invoices = await getData(`{{ url('/api/v1/invoices') }}`, token);
		console.log(invoices)
		const tableContainer = document.querySelector('.table-container');
		let rowTable = '';
		let number = 0;
		const currentDate = new Date();

		invoices.forEach(invoice => {
			number++;
			rowTable += `
				<tr>
					<th class="text-center">${number}</th>
					<td>${invoice.invoice_number}</td>
					<td class="text-center">${invoice.invoice_total}</td>
					<td class="text-center">${dateFormatter(invoice.invoice_payment_date)}</td>
					<td class="text-center">${invoice.customer.name}</td>
					<td class="text-center">${invoice.training.training_name}</td>
					
					<td class="td-last"><a class="btn btn-outline-primary btn-sm btn-detail" href="#" onclick="showDetailData(${invoice.id})" role="button" data-bs-toggle="modal" data-bs-target="#detailModal"><i class="bi bi-info-square"></i><span class="d-none d-lg-inline ms-1">Detail</span></a></td>
					<td class="td-last"><a class="btn btn-outline-danger btn-sm" href="#" onclick="deleteConfirmation(${invoice.id}, '${invoice.invoice_number}')" role="button"><i class="bi bi-trash"></i><span class="d-none d-lg-inline ms-1">Hapus</span></a></td>
					
				</tr>
			`
		})

		tableContainer.innerHTML = rowTable;
	}

	async function showDetailData(id) {
		const invoice = await getDetailData(`{{ url('/api/v1/invoice/${id}') }}`, token);
		console.log(invoice);
		const currentDate = new Date();

		const detailContainer = document.querySelector('.detail-container');
		detailContainer.innerHTML = `
			<div class="mb-3 row">
				<label class="col-sm-4 col-form-label">Kode Pembayaran</label>
				<div class="col-sm-8">
					<input type="text" value="${invoice.invoice_number}" class="form-control" readonly>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-4 col-form-label">Nama Customer</label>
				<div class="col-sm-8">
					<input type="text" value="${invoice.customer.name}" class="form-control" readonly>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-4 col-form-label">Nama Pelatihan</label>
				<div class="col-sm-8">
					<input type="text" value="${invoice.training.training_name}" class="form-control" readonly>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-4 col-form-label">Total</label>
				<div class="col-sm-8">
					<input type="text" value="${invoice.invoice_total}" class="form-control" readonly>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-4 col-form-label">Tanggal Pembayaran</label>
				<div class="col-sm-8">
					<input type="text" value="${dateFormatter(invoice.invoice_payment_date)}" class="form-control" readonly>
				</div>
			</div>
			<div class="mb-3 row">
				<label class="col-sm-4 col-form-label">Bukti Pembayaran</label>
				<div class="col-sm-8">
				<a href="${invoice.invoice_proof}" target="_blank">
					<img src="${invoice.invoice_proof}" class="img-fluid col-md-3 mb-2 d-block">
				</a>
				</div>
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
					deleteData(`{{ url('/api/v1/invoice/${id}') }}`, token);
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