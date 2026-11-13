<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Form Input Ruang Sidang</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>
    <div class="container">
        <h2 style="margin-top: 0;">Form Input Ruang Sidang</h2>
        <form method="POST" action="{{ route('ruang-sidang.store') }}">
            @csrf
            <div class="form-group">
                <label>Kode Ruangan</label>
                <input type="text" name="kode_ruangan" placeholder="Contoh: KU#02" required>
            </div>
            <div class="form-group">
                <label>Nomor / Nama Gedung</label>
                <input type="text" name="nama_gedung" placeholder="Contoh: Gedung TULT" required>
            </div>
            <div class="form-group">
                <label>Kapasitas (Orang)</label>
                <input type="number" name="kapasitas" placeholder="Contoh: 45" required>
            </div>
            <div class="form-group">
                <label>Fasilitas di dalam ruangan</label>
                <label style="font-weight: normal; display: inline-block; margin-right: 15px;">
                    <input type="checkbox" name="fasilitas[]" value="Proyektor"> Proyektor
                </label>
                <label style="font-weight: normal; display: inline-block; margin-right: 15px;">
                    <input type="checkbox" name="fasilitas[]" value="PC"> PC / Komputer
                </label>
                <label style="font-weight: normal; display: inline-block;">
                    <input type="checkbox" name="fasilitas[]" value="AC"> AC
                </label>
            </div>
            <div class="form-group">
                <label>Status Ruangan</label>
                <select name="status_ruangan" required>
                    <option value="Tersedia">Tersedia</option>
                    <option value="Digunakan">Digunakan</option>
                    <option value="Dalam Perbaikan">Dalam Perbaikan</option>
                </select>
            </div>
            <button type="submit" class="btn btn-submit" style="background-color:#3498db; color:white;">Simpan Data
                Ruangan</button>
            <a href="{{ route('ruang-sidang.index') }}" class="btn btn-secondary" style="margin-left: 10px;">Lihat Data
                Ruangan</a>
        </form>
    </div>
</body>

</html>