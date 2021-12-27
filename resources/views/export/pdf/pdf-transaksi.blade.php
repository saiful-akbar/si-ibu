<!DOCTYPE html>
<html lang="id">

<head>
    <meta
        http-equiv="Content-Type"
        content="text/html; charset=utf-8"
    />
    <title>Laporan Transaksi</title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }

        body {
            width: 100%;
        }

        .container {
            padding: 30px 25px;
        }

        .table {
            border-collapse: collapse;
        }

        .table tr th,
        .table tr td {
            text-align: left;
            padding: 5px 5px 5px 0;
            white-space: nowrap;
        }

        .table tr td {
            font-size: 13px;
        }

        .table tr th {
            font-size: 14px;
        }

        .text-center {
            text-align: center !important;
        }

        .table-padding tr th,
        .table-padding tr td {
            padding: 5px 5px;
        }

        .table-border tr th,
        .table-border tr td {
            border: 2px solid black;
        }

        .header {
            max-width: 100%;
            border-bottom: 2px solid black;
            margin-bottom: 30px;
            padding-bottom: 10px;
            position: relative;
        }

        .logo img {
            height: 25px;
        }

        .header-title {
            margin-bottom: 15px;
            line-height: 100%;
            font-size: 1.4em;
            font-weight: 700;
            position: absolute;
            right: 0;
            top: 0;
        }

    </style>
</head>

<body>
    <div class="container">
        <header class="header">
            <div>
                <table class="table">
                    <tr>
                        <th>Periode</th>
                        <td>:</td>
                        <td>{{ request('periodeAwal') }} ~ {{ request('periodeAkhir') }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Cetak</th>
                        <td>:</td>
                        <td>{{ date('Y-m-d H:i') }}</td>
                    </tr>
                </table>
            </div>
            <h2 class="header-title">Laporan Transaksi</h2>
        </header>
        <table
            class="table table-border table-padding"
            width="100%"
        >
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Bagian</th>
                    <th class="text-center">Seksi</th>
                    <th class="text-center">Submitter</th>
                    <th class="text-center">Jenis Belanja</th>
                    <th class="text-center">Kegiatan</th>
                    <th class="text-center">No. Dokumen</th>
                    <th class="text-center">Approval</th>
                    <th class="text-center">Jml Nominal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporanTransaksi as $laporan)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $laporan->tanggal }}</td>
                        <td>{{ $laporan->divisi->nama_divisi }}</td>
                        <td>{{ $laporan->user->seksi }}</td>
                        <td>{{ $laporan->user->profil->nama_lengkap }}</td>
                        <td>{{ $laporan->jenisBelanja->kategori_belanja }}</td>
                        <td>{{ $laporan->kegiatan }}</td>
                        <td>{{ $laporan->no_dokumen }}</td>
                        <td>{{ $laporan->approval }}</td>
                        <td>Rp. {{ number_format($laporan->jumlah_nominal) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="9">Grand Total</th>
                    <th>Rp. {{ number_format($totalTransaksi) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
