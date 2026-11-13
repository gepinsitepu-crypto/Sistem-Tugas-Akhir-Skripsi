<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Ruang Sidang</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <style>
        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }

        .action-links {
            display: flex;
            gap: 5px;
        }

        .header-tabel {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .user-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #2c3e50;
            color: white;
            padding: 12px 20px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .role-badge {
            background-color: #f39c12;
            color: #fff;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: bold;
            margin-left: 8px;
        }
    </style>
</head>

<body>
    <div class="container">
        {{-- Bar Informasi Akun & Tombol Switch Role --}}
        <div class="user-bar">
            <div>
                Login sebagai: <strong>{{ auth()->user()->name }}</strong>
                <span class="role-badge">{{ auth()->user()->role }}</span>
            </div>
            <div style="display: flex; gap: 8px; align-items: center;">
                <a href="{{ route('quick.login', 'dosen') }}" class="btn btn-sm"
                    style="background:#27ae60; color:white;">Switch ke Dosen</a>
                <a href="{{ route('quick.login', 'mahasiswa') }}" class="btn btn-sm"
                    style="background:#e67e22; color:white;">Switch ke Mahasiswa</a>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn btn-sm" style="background:#e74c3c; color:white;">Logout</button>
                </form>
            </div>
        </div>

        <div class="header-tabel">
            <h2 style="margin: 0;">Tabel Data Ruang & Fasilitas Sidang</h2>

            {{-- LAPIS 3: Tombol Tambah Data HANYA muncul untuk Dosen --}}
            @if(auth()->user()->role === 'dosen')
                <a href="{{ route('ruang-sidang.create') }}" class="btn" style="background-color:#2ecc71; color:white;">+
                    Tambah Data Baru</a>
            @endif
        </div>

        @if(session('success'))
            <div style="padding: 10px; background-color: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 15px;">
                {{ session('success') }}
            </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Ruangan</th>
                    <th>Gedung</th>
                    <th>Kapasitas</th>
                    <th>Fasilitas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ruangan as $key => $item)
                    @php
                        $badgeClass = match ($item->status_ruangan) {
                            'Tersedia' => 'badge-tersedia',
                            'Digunakan' => 'badge-digunakan',
                            default => 'badge-pemeliharaan'
                        };
                    @endphp
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->kode_ruangan }}</td>
                        <td>{{ $item->nama_gedung }}</td>
                        <td>{{ $item->kapasitas }} Orang</td>
                        <td>{{ $item->fasilitas }}</td>
                        <td><span class="badge {{ $badgeClass }}">{{ $item->status_ruangan }}</span></td>
                        <td class="action-links">
                            {{-- LAPIS 3: Tombol Edit & Hapus HANYA muncul untuk Dosen --}}
                            @if(auth()->user()->role === 'dosen')
                                <a href="{{ route('ruang-sidang.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('ruang-sidang.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            @else
                                <span style="color: #7f8c8d; font-size: 12px; font-style: italic;">Hanya Lihat
                                    (Read-Only)</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">Belum ada data ruang sidang.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>