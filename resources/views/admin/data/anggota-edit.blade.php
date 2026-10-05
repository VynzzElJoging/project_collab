<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Anggota</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            color: #111827;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .header {
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0 0 8px;
            font-size: 32px;
        }

        .header p {
            margin: 0;
            color: #6b7280;
        }

        .form-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            display: block;
            width: 100%;
            padding: 12px 14px;
            border: 2px solid #d1d5db;
            border-radius: 8px;
            background: white;
            color: #111827;
            font-size: 15px;
            outline: none;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: #111827;
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            display: inline-block;
            padding: 12px 22px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-simpan {
            border: 2px solid #111827;
            background: #111827;
            color: white;
        }

        .btn-batal {
            border: 2px solid #d1d5db;
            background: #f3f4f6;
            color: #111827;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="header">
            <h1>Edit Anggota</h1>

            <p>
                Ubah data anggota yang sudah tersimpan.
            </p>
        </div>

        <div class="form-card">

            <form action="{{ route('admin.data.anggota.update', $anggota) }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nama">Nama</label>

                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        value="{{ old('nama', $anggota->nama) }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $anggota->email) }}"
                    >
                </div>

                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir</label>

                    <input
                        type="date"
                        id="tanggal_lahir"
                        name="tanggal_lahir"
                        value="{{ old('tanggal_lahir', $anggota->tanggal_lahir) }}"
                    >
                </div>

                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>

                    <select id="jenis_kelamin" name="jenis_kelamin">

                        <option value="">-- Pilih Jenis Kelamin --</option>

                        <option value="Laki-laki"
                            {{ old('jenis_kelamin', $anggota->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                            Laki-laki
                        </option>

                        <option value="Perempuan"
                            {{ old('jenis_kelamin', $anggota->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                            Perempuan
                        </option>

                    </select>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat</label>

                    <textarea
                        id="alamat"
                        name="alamat"
                    >{{ old('alamat', $anggota->alamat) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="no_hp">No. HP</label>

                    <input
                        type="text"
                        id="no_hp"
                        name="no_hp"
                        value="{{ old('no_hp', $anggota->no_hp) }}"
                    >
                </div>

               <div class="form-group">
                <label for="foto">Foto Anggota</label>
                <input
        type="file"
        id="foto"   
        name="foto"
        accept="image/*"
    >
               </div>
                <div class="buttons">

                    <button type="submit" class="btn btn-simpan">
                        SIMPAN PERUBAHAN
                    </button>

                    <a
                        href="{{ route('admin.data.anggota.index') }}"
                        class="btn btn-batal"
                    >
                        BATAL
                    </a>

                </div>

            </form>

        </div>

    </div>

</body>

</html>