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
                <th style="font-weight: bold; border: 1px solid #000;">Submitter</th>
                <th style="font-weight: bold; border: 1px solid #000;">Jenis Belanja</th>
                <th style="font-weight: bold; border: 1px solid #000;">Kegiatan</th>
                <th style="font-weight: bold; border: 1px solid #000;">Jumlah Nominal</th>
                <th style="font-weight: bold; border: 1px solid #000;">No. Dokumen</th>
                <th style="font-weight: bold; border: 1px solid #000;">Approval</th>
                <th style="font-weight: bold; border: 1px solid #000;">Dibuat</th>
                <th style="font-weight: bold; border: 1px solid #000;">Diperbarui</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($laporanTransaksi as $laporan)
                <tr>
                    <td style="border: 1px solid #000;">{{ $loop->iteration }}</td>
                    <td style="border: 1px solid #000;">{{ $laporan->tanggal }}</td>
                    <td style="border: 1px solid #000;">{{ $laporan->divisi->nama_divisi }}</td>
                    <td style="border: 1px solid #000;">{{ $laporan->user->profil->nama_lengkap }}</td>
                    <td style="border: 1px solid #000;">{{ $laporan->jenisBelanja->kategori_belanja }}</td>
                    <td style="border: 1px solid #000;">{{ $laporan->kegiatan }}</td>
                    <td style="border: 1px solid #000;">{{ $laporan->jumlah_nominal }}</td>
                    <td style="border: 1px solid #000;">{{ $laporan->no_dokumen }}</td>
                    <td style="border: 1px solid #000;">{{ $laporan->approval }}</td>
                    <td style="border: 1px solid #000;">{{ $laporan->created_at }}</td>
                    <td style="border: 1px solid #000;">{{ $laporan->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>