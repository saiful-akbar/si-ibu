<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Laporan Realisasi</title>

    <style>
        * {
            padding: 0;
            margin: 0;
        }

        .header {
            border: 5px double #000;
            padding: 10px;
        }

        .footer {
            border: 2px solid #000;
            padding: 10px;
        }

        .w-100 {
            width: 100%;
        }

        .table {
            border-collapse: collapse;
        }

        .table-bordered tr th,
        .table-bordered tr td {
            border: 2px solid #000;
        }

        .table tr th,
        .table tr td {
            padding: 7px;

        }

        .table tr th {
            font-size: 14px;
        }

        .table tr td {
            font-size: 12px;
        }

        .logo {
            background-image: url("/assets/images/logo/logo-dark.webp");
            background-repeat: no-repeat;
            background-size: 100%;
            width: 120px;
            height: 50px;
        }

        .text-bold {
            font-weight: bold;
        }

        @page {
            header: page-header;
            footer: page-footer;
        }

    </style>
</head>

<body>
    <htmlpageheader name="page-header">
        <header class="header">
            <table class="table w-100" border="0">
                <tr>
                    <th align="left" colspan="3">
                        <h3>Laporan Realisasi</h3>
                    </th>
                    <th align="right" rowspan="2">
                        <img src="assets/images/logo/logo-light.jpg" alt="logo" width="120" />
                    </th>
                </tr>
                <tr>
                    <td align="left">
                        <span class="text-bold">Periode</span> : {{ $periodeAwal }} ~ {{ $periodeAkhir }}
                    </td>
                </tr>
            </table>
        </header>
    </htmlpageheader>

    <div class="container">
        <table class="table table-bordered w-100" width="100%">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center" colspan="3">
                        Akun Belanja
                    </th>
                    <th class="text-center">Submitter</th>
                    <th class="text-center">Kegiatan</th>
                    <th class="text-center">No. Dokumen</th>
                    <th class="text-center">Approval</th>
                    <th align="right">Jml Nominal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporanTransaksi as $laporan)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $laporan->tanggal }}</td>
                        <td>{{ $laporan->budget->divisi->nama_divisi }}</td>
                        <td>{{ $laporan->budget->jenisBelanja->akunBelanja->nama_akun_belanja }}</td>
                        <td>{{ $laporan->budget->jenisBelanja->kategori_belanja }}</td>
                        <td>{{ $laporan->user->profil->nama_lengkap }}</td>
                        <td>{{ $laporan->kegiatan }}</td>
                        <td>{{ $laporan->no_dokumen }}</td>
                        <td>{{ $laporan->approval }}</td>
                        <td align="right">Rp. {{ number_format($laporan->jumlah_nominal) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="9">Total</th>
                    <th align="right">Rp. {{ number_format($totalTransaksi) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <htmlpagefooter name="page-footer">
        <footer class="footer">
            <table class="table w-100">
                <tr>
                    <td align="left">
                        <span class="text-bold">Tanggal / Jam</span> : {{ date('Y-m-d / H:i:s') }}
                    </td>
                    <td align="right">
                        <span class="text-bold">Hal</span> : {PAGENO}/{nbpg}
                    </td>
                </tr>
            </table>
        </footer>
    </htmlpagefooter>
</body>

</html>
