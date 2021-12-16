@extends('templates.main')

@section('title', 'User')

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">

					{{-- title & btn tambah --}}
          <div class="row">
              <div class="col-12 d-flex justify-content-between align-items-center mb-3">
                  <h4 class="header-title">Tabel Daftar User</h4>
                  <a href="{{ route('divisi.create') }}" class="btn btn-sm btn-primary" >
                      <i class="mdi mdi-plus"></i>
                      <span>Tambah User Baru</span>
                  </a>
              </div>
          </div>
          {{-- end title & btn tambah --}}

				</div>
			</div>
		</div>
	</div>
@endsection
