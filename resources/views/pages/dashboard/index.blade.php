@extends('templates.main')

@section('title', 'Dashboard')

@section('content')

    {{-- chart global dvisi --}}
    <div class="row">
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-header pt-3">
                    <h4 class="header-title">Global Chart Budget</h4>
                </div>

                <div class="card-body">
                    <div class="row">

                        {{-- chart global --}}
                        <div class="col-lg-6 col-sm-12 mb-3">
                            <div
                                id="global-chart"
                                class="apex-charts"
                            ></div>
                        </div>
                        {{-- end chart global --}}

                        <div class="col-lg-6 col-sm-12 mb-3">

                            {{-- form select periode chart global --}}
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="periode-global">Periode Tahun</label>
                                        <select
                                            id="periode-global"
                                            class="form-control select2"
                                            data-toggle="select2"
                                        >
                                            @foreach ($years as $year)
                                                <option
                                                    value="{{ $year }}"
                                                    @if ($year == date('Y')) selected @endif
                                                >
                                                    {{ $year }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <hr class="mt-3 mb-3">
                                </div>
                            </div>
                            {{-- end form select periode chart global --}}

                            {{-- descripsi chart global --}}
                            <div class="row">
                                <div class="col-12 chart-widget-list">
                                    <p>
                                        Divisi
                                        <span
                                            class="float-right"
                                            id="global-divisi"
                                        ></span>
                                    </p>
                                    <p>
                                        Total Budget
                                        <span
                                            class="float-right"
                                            id="global-total-budget"
                                        ></span>
                                    </p>
                                    <p>
                                        <i class="mdi mdi-square text-success"></i> Total Transaksi
                                        <span
                                            class="float-right"
                                            id="global-total-transaksi"
                                        ></span>
                                    </p>
                                    <p>
                                        <i class="mdi mdi-square text-primary"></i> Sisa Budget
                                        <span
                                            class="float-right"
                                            id="global-sisa-budget"
                                        ></span>
                                    </p>
                                </div>
                            </div>
                            {{-- end deskripsi chart global --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- chart global divisi --}}

    {{-- chart per divisi --}}
    @if ($isAdmin)
        <div class="row">
            @foreach ($divisi as $data)
                <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                    <div class="card">
                        <div class="card-header pt-3">
                            <h4 class="header-title">{{ $data->nama_divisi }}</h4>
                        </div>

                        <div class="card-body">

                            {{-- chart per divisi --}}
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div
                                        class="apex-charts divisi-chart"
                                        data-divisi-id="{{ $data->id }}"
                                        id="divisi-{{ $data->id }}"
                                    ></div>
                                </div>
                            </div>
                            {{-- end chart per divisi --}}

                            {{-- form select periode per divisi --}}
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <select
                                            id="periode-divisi-{{ $data->id }}"
                                            class="form-control form-control-sm select2 periode-divisi"
                                            data-toggle="select2"
                                            data-divisi-id="{{ $data->id }}"
                                        >
                                            @foreach ($years as $year)
                                                <option
                                                    value="{{ $year }}"
                                                    @if ($year == date('Y')) selected @endif
                                                >
                                                    {{ $year }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- end form select periode per divisi --}}

                            {{-- deskripsi per divisi --}}
                            <div class="row">
                                <div class="col-12">
                                    <div class="chart-widget-list">
                                        <p>
                                            Total Budget
                                            <span
                                                class="float-right"
                                                id="total-budget-divisi-{{ $data->id }}"
                                            ></span>
                                        </p>
                                        <p class="mb-0">
                                            <i class="mdi mdi-square text-success"></i>
                                            Total Transaksi
                                            <span
                                                class="float-right"
                                                id="total-transaksi-divisi-{{ $data->id }}"
                                            ></span>
                                        </p>
                                        <p>
                                            <i class="mdi mdi-square text-danger"></i>
                                            Sisa Budget
                                            <span
                                                class="float-right"
                                                id="sisa-budget-divisi-{{ $data->id }}"
                                            ></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            {{-- end descripsi perdivisi --}}

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    {{-- end chart per divisi --}}

@endsection

@section('js')
    <script src="{{ asset('assets/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
@endsection
