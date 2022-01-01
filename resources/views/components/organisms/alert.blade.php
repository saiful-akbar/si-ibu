@if (session('alert'))
    <div class="row">
        <div class="col-12 mb-3">
            <div
                class="alert alert-{{ session('alert')['type'] }} alert-dismissible fade show"
                role="alert"
            >
                <button
                    type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>

                <h4 class="alert-heading">
                    @if (session('alert')['type'] == 'success')
                        <i class="dripicons-checkmark mr-1"></i>
                    @elseif (session('alert')['type'] == 'danger')
                        <i class="dripicons-wrong mr-1"></i>
                    @elseif (session('alert')['type'] == 'warning')
                        <i class="dripicons-warning mr-1"></i>
                    @else
                        <i class="dripicons-information mr-1"></i>
                    @endif

                    {{ session('alert')['type'] == 'danger' ? 'Error' : ucwords(session('alert')['type']) }}
                </h4>

                <p>{!! session('alert')['message'] !!}</p>
            </div>
        </div>
    </div>
@endif
