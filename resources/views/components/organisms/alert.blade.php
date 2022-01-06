@if (session('alert'))
    <div class="row">
        <div class="col-12 mb-3">
            <div class="alert alert-{{ session('alert')['type'] }} alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <div class="d-flex align-items-center justify-content-start">
                    @if (session('alert')['type'] == 'success')
                        <i class="dripicons-checkmark h5 mr-1"></i>
                    @elseif (session('alert')['type'] == 'danger')
                        <i class="dripicons-wrong h5 mr-1"></i>
                    @elseif (session('alert')['type'] == 'warning')
                        <i class="dripicons-warning h5 mr-1"></i>
                    @else
                        <i class="dripicons-information h5 mr-1"></i>
                    @endif

                    <h4 class="alert-heading align-middle">
                        {{ session('alert')['type'] == 'danger' ? 'Error' : ucwords(session('alert')['type']) }}
                    </h4>
                </div>

                <p>{!! session('alert')['message'] !!}</p>
            </div>
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="row">
        <div class="col-12 mb-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <div class="d-flex align-items-center justify-content-start">
                    <i class="dripicons-wrong h5 mr-1"></i>
                    <h4 class="alert-heading align-middle">
                        Error
                    </h4>
                </div>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
