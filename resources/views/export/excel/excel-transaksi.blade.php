<!DOCTYPE html>
<html lang="id">

<head>
    <title>Laporan Transaksi</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th style="font-weight: bold; border: 1px solid #000;">No</th>
                <th style="font-weight: bold; border: 1px solid #000;">Tanggal</th>
                <th style="font-weight: bold; border: 1px solid #000;">Bagian</th>
                <th style="font-weight: bold; border: 1px solid #000;">Akun Belanja</th>
                <th style="font-weight: bold; border: 1px solid #000;">Jenis Belanja</th>
                <th style="font-weight: bold; border: 1px solid #000;">Submitter</th>
                <th style="font-weight: bold; border: 1px solid #000;">Kegiatan</th>
                <th style="font-weight: bold; border: 1px solid #000;">No. Dokumen</th>
                <th style="font-weight: bold; border: 1px solid #000;">Approval</th>
                <th style="font-weight: bold; border: 1px solid #000;">Jumlah Nominal</th>
                <th style="font-weight: bold; border: 1px solid #000;">Uraian</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($laporanTransaksi as $laporan)
                <tr>
                    <td style="border: 1px solid #000; width: 15em;">
                        {{ $loop->iteration }}
                    </td>
                    <td style="border: 1px solid #000; width: 15em;">
                        {{ $laporan->tanggal }}
                    </td>
                    <td style="border: 1px solid #000; width: 15em;">
                        {{ $laporan->budget->divisi->nama_divisi }}
                    </td>
                    <td style="border: 1px solid #000; width: 15em;">
                        {{ $laporan->budget->jenisBelanja->akunBelanja->nama_akun_belanja }}
                    </td>
                    <td style="border: 1px solid #000; width: 15em;">
                        {{ $laporan->budget->jenisBelanja->kategori_belanja }}
                    </td>
                    <td style="border: 1px solid #000; width: 15em;">
                        {{ $laporan->user->profil->nama_lengkap }}
                    </td>
                    <td style="border: 1px solid #000; width: 15em;">
                        {{ $laporan->kegiatan }}
                    </td>
                    <td style="border: 1px solid #000; width: 15em;">
                        {{ $laporan->no_dokumen }}
                    </td>
                    <td style="border: 1px solid #000; width: 15em;">
                        {{ $laporan->approval }}
                    </td>
                    <td style="border: 1px solid #000; width: 15em;">
                        {{ $laporan->jumlah_nominal }}
                    </td>
                    <td style="border: 1px solid #000; width: 15em;">
                        {!! $laporan->uraian !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
