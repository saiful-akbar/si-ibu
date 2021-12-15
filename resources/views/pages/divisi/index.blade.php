@extends('templates.main')

@section('title', 'Divisi')

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header d-flex justify-content-between">
					<h4 class="h4">Tabel Divisi</h4>
					<button class="btn btn-sm btn-rounded btn-primary">Buat Divisi Baru</button>
				</div>

				<div class="card-body">

					{{-- form search --}}
					<div class="row justify-content-end">
						<div class="col-md-6 col-sm-12 mb-3">
							<form action="{{ route('divisi') }}" method="GET" autocomplete="off">
								<div class="input-group">
							        <input type="search" name="search" placeholder="Cari divisi..." class="form-control" value="{{ $search }}"/>
							        <div class="input-group-append">
							            <button class="btn btn-secondary" type="submit">Cari</button>
							        </div>
							    </div>
							</form>
						</div>
					</div>
					{{-- end form search --}}

					{{-- table --}}
					<div class="row">
						<div class="col-12 mb-3">
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>No</th>
											<th class="nowrap">Nama Divisi</th>
											<th class="text-center">Aksi</th>
										</tr>
									</thead>
									<tbody>
										@foreach($divisi as $data)
											<tr>
												<td class="align-middle">{{ $loop->iteration }}</td>
												<td class="align-middle">{{ ucwords($data->nama_divisi) }}</td>
												<td class="d-flex justify-content-center">
													<button class="btn btn-sm btn-success btn-rounded mr-1">
														Edit
													</button>
													<button class="btn btn-sm btn-danger btn-rounded">
														Hapus
													</button>
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>

						<div class="col-12 d-flex justify-content-center">
							{{ $divisi->links() }}
						</div>
					</div>
					{{-- end table --}}

				</div>
			</div>
		</div>
	</div>
@endsection