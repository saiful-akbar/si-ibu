@if (session('alert'))
    <div class="row">
        <div class="col-12 mb-3">
            <div
                class="alert alert-{{ session('alert')['type'] }} alert-dismissible fade show shadow-sm"
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

                @if (session('alert')['type'] == 'success')
                    <i class="dripicons-checkmark mr-2"></i>
                @elseif (session('alert')['type'] == 'danger')
                    <i class="dripicons-wrong mr-2"></i>
                @elseif (session('alert')['type'] == 'warning')
                    <i class="dripicons-wrong mr-2"></i>
                @else
                    <i class="dripicons-information mr-2"></i>
                @endif

                {{ session('alert')['message'] }}
            </div>
        </div>
    </div>
@endif
