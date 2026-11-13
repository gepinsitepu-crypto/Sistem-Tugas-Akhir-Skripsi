<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Ruang Sidang</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>
    <div class="container">
        <h2 style="margin-top: 0;">Edit Data Ruang Sidang</h2>
        <form method="POST" action="{{ route('ruang-sidang.update', $data->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Kode Ruangan</label>
                <input type="text" name="kode_ruangan" value="{{ $data->kode_ruangan }}" required>
            </div>
            <div class="form-group">
                <label>Nomor / Nama Gedung</label>
                <input type="text" name="nama_gedung" value="{{ $data->nama_gedung }}" required>
            </div>
            <div class="form-group">
                <label>Kapasitas (Orang)</label>
                <input type="number" name="kapasitas" value="{{ $data->kapasitas }}" required>
            </div>
            <div class="form-group">
                <label>Fasilitas di dalam ruangan</label>
                <label style="font-weight: normal; display: inline-block; margin-right: 15px;">
                    <input type="checkbox" name="fasilitas[]" value="Proyektor" {{ in_array("Proyektor", $fasilitas_array) ? 'checked' : '' }}> Proyektor
                </label>
                <label style="font-weight: normal; display: inline-block; margin-right: 15px;">
                    <input type="checkbox" name="fasilitas[]" value="PC" {{ in_array("PC", $fasilitas_array) ? 'checked' : '' }}> PC / Komputer
                </label>
                <label style="font-weight: normal; display: inline-block;">
                    <input type="checkbox" name="fasilitas[]" value="AC" {{ in_array("AC", $fasilitas_array) ? 'checked' : '' }}> AC
                </label>
            </div>
            <div class="form-group">
                <label>Status Ruangan</label>
                <select name="status_ruangan" required>
                    <option value="Tersedia" {{ $data->status_ruangan == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="Digunakan" {{ $data->status_ruangan == 'Digunakan' ? 'selected' : '' }}>Digunakan
                    </option>
                    <option value="Dalam Perbaikan" {{ $data->status_ruangan == 'Dalam Perbaikan' ? 'selected' : '' }}>
                        Dalam Perbaikan</option>
                </select>
            </div>
            <button type="submit" class="btn btn-warning">Update Data</button>
            <a href="{{ route('ruang-sidang.index') }}" class="btn btn-secondary" style="margin-left: 10px;">Batal</a>
        </form>
    </div>
</body>

</html>