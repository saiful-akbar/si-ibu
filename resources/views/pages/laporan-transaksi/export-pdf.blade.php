<!DOCTYPE html>
<html lang="id">

<head>
    <meta
        http-equiv="Content-Type"
        content="text/html; charset=utf-8"
    />

    <title>Laporan Transaksi</title>

    <style>
        .table {
            width: 100%;
            border-collapse: collapse
        }

        .table tr th,
        .table tr td {
            text-align: left;
            padding: 7px 5px;
            white-space: nowrap;
        }

        .table tr td {
            font-size: 13px;
        }

        .table tr th {
            font-size: 14px;
        }

        .table tr th {
            border-bottom: 2px solid black;
        }

        .table tr td {
            border-bottom: 1px solid black;
        }

        .header-title {
            margin-bottom: 10px;
        }

        .periode {
            margin-bottom: 20px;
        }

    </style>
</head>

<body>
    <h2 class="header-title">Laporan Transaksi</h2>

    <table class="periode">
        <tr>
            <th>Periode</th>
            <td>:</td>
            <td>{{ request('periodeAwal') }} - {{ request('periodeAkhir') }}</td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Divisi</th>
                <th>Submitter</th>
                <th>Jenis Belanja</th>
                <th>Kegiatan</th>
                <th>No. Dokumen</th>
                <th>Approval</th>
                <th>Jumlah Nominal</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($laporanTransaksi as $laporan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $laporan->tanggal }}</td>
                    <td>{{ $laporan->divisi->nama_divisi }}</td>
                    <td>{{ $laporan->user->profil->nama_lengkap }}</td>
                    <td>{{ $laporan->jenisBelanja->kategori_belanja }}</td>
                    <td>{{ $laporan->kegiatan }}</td>
                    <td>{{ $laporan->no_dokumen }}</td>
                    <td>{{ $laporan->approval }}</td>
                    <td>Rp. {{ number_format($laporan->jumlah_nominal) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
