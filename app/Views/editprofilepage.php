<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Penta Dosen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#6366f1',
                        secondary: '#8b5cf6',
                        dark: '#1e293b',
                        light: '#f8fafc',
                    }
                }
            }
        }
    </script>
    <style>
        .profile-bg {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .transition-all {
            transition: all 0.3s ease;
        }
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8fafc;
        }
    </style>
</head>
<body>
    <div class="min-h-screen">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg">
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="p-4 border-b">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center text-white mr-3">
                            <i class="fas fa-flask text-xl"></i>
                        </div>
                        <h1 class="text-xl font-bold text-primary">Penta Dosen</h1>
                    </div>
                </div>

                <!-- Menu -->
                <div class="flex-1 overflow-y-auto py-4">
                    <ul class="space-y-1 px-4">
                        <li>
                            <a href="<?= site_url('dashboard') ?>" class="flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-primary hover:bg-gray-50 font-medium transition-all">
                                <i class="fas fa-tachometer-alt mr-3"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('kalender') ?>" class="flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-primary hover:bg-gray-50 font-medium transition-all">
                                <i class="far fa-calendar-alt mr-3"></i>
                                Kalender
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('penelitian') ?>" class="flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-primary hover:bg-gray-50 font-medium transition-all">
                                <i class="fas fa-microscope mr-3"></i>
                                Penelitian
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('publikasi') ?>" class="flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-primary hover:bg-gray-50 font-medium transition-all">
                                <i class="fas fa-book-open mr-3"></i>
                                Publikasi
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('hki') ?>" class="flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-primary hover:bg-gray-50 font-medium transition-all">
                                <i class="fas fa-lightbulb mr-3"></i>
                                HKI
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- User Profile -->
                <div class="p-4 border-t">
                    <div class="flex items-center">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User" class="w-10 h-10 rounded-full mr-3">
                        <div>
                            <p class="font-medium text-gray-800"><?= $user['nama'] ?></p>
                            <p class="text-xs text-gray-500"><?= $user['jabatan'] ?></p>
                        </div>
                    </div>
                    <a href="<?= site_url('auth/logout') ?>" class="mt-3 w-full py-2 px-4 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700 transition-all flex items-center justify-center">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="ml-64">
            <!-- Profile Header -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all card-hover mx-6 mt-6">
                <div class="profile-bg h-32 md:h-40 w-full"></div>
                <div class="px-6 py-4 relative">
                    <div class="absolute -top-16 left-6">
                        <div class="h-32 w-32 rounded-full border-4 border-white bg-white shadow-lg overflow-hidden">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Profile" class="h-full w-full object-cover">
                        </div>
                    </div>
                    <div class="ml-40 md:ml-44 pt-2">
                        <h1 class="text-2xl md:text-3xl font-bold text-dark">Edit Profile</h1>
                        <p class="text-gray-600">Update informasi profil Anda</p>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="bg-white rounded-xl shadow-md p-6 mx-6 mt-6 transition-all card-hover">
                <?php if (session()->getFlashdata('errors')) : ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <ul>
                            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= site_url('profile/update') ?>" method="post">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                                <input type="text" id="nama" name="nama" value="<?= old('nama', $user['nama']) ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" required>
                            </div>
                            <div>
                                <label for="nidn" class="block text-sm font-medium text-gray-700">NIDN</label>
                                <input type="text" id="nidn" name="nidn" value="<?= old('nidn', $user['nidn']) ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary bg-gray-100" readonly>
                            </div>
                            <div>
                                <label for="nip" class="block text-sm font-medium text-gray-700">NIP</label>
                                <input type="text" id="nip" name="nip" value="<?= old('nip', $user['nip']) ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary bg-gray-100" readonly>
                            </div>
                            <div>
                                <label for="inisial" class="block text-sm font-medium text-gray-700">Inisial</label>
                                <input type="text" id="inisial" name="inisial" value="<?= old('inisial', $user['inisial']) ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary bg-gray-100" readonly>
                            </div>
                            <div>
                                <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
                                <select id="jabatan" name="jabatan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" required>
                                    <option value="Asisten Ahli" <?= old('jabatan', $user['jabatan']) == 'Asisten Ahli' ? 'selected' : '' ?>>Asisten Ahli</option>
                                    <option value="Lektor" <?= old('jabatan', $user['jabatan']) == 'Lektor' ? 'selected' : '' ?>>Lektor</option>
                                    <option value="Lektor Kepala" <?= old('jabatan', $user['jabatan']) == 'Lektor Kepala' ? 'selected' : '' ?>>Lektor Kepala</option>
                                    <option value="Guru Besar" <?= old('jabatan', $user['jabatan']) == 'Guru Besar' ? 'selected' : '' ?>>Guru Besar</option>
                                </select>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label for="universitas" class="block text-sm font-medium text-gray-700">Universitas</label>
                                <select id="universitas" name="universitas" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" required>
                                    <option value="" disabled selected>Pilih Universitas</option>
                                    <option value="Universitas Yarsi" <?= old('universitas', $user['universitas']) == 'Universitas Yarsi' ? 'selected' : '' ?>>Universitas Yarsi</option>
                                    <option value="Other">Lainnya (isi sendiri)</option>
                                </select>
                            </div>
                            <div id="otherUnivContainer" class="hidden">
                                <label for="otherUniv" class="block text-sm font-medium text-gray-700">Masukkan Universitas Anda</label>
                                <input type="text" id="otherUniv" name="otherUniv" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                            </div>
                            <div>
                                <label for="fakultas" class="block text-sm font-medium text-gray-700">Fakultas</label>
                                <select id="fakultas" name="fakultas" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" required>
                                    <option value="" disabled selected>Pilih Fakultas</option>
                                    <option value="Fakultas Kedokteran" <?= old('fakultas', $user['fakultas']) == 'Fakultas Kedokteran' ? 'selected' : '' ?>>Fakultas Kedokteran</option>
                                    <option value="Fakultas Kedokteran Gigi" <?= old('fakultas', $user['fakultas']) == 'Fakultas Kedokteran Gigi' ? 'selected' : '' ?>>Fakultas Kedokteran Gigi</option>
                                    <option value="Fakultas Teknologi Informasi" <?= old('fakultas', $user['fakultas']) == 'Fakultas Teknologi Informasi' ? 'selected' : '' ?>>Fakultas Teknologi Informasi</option>
                                    <option value="Fakultas Ekonomi Bisnis" <?= old('fakultas', $user['fakultas']) == 'Fakultas Ekonomi Bisnis' ? 'selected' : '' ?>>Fakultas Ekonomi Bisnis</option>
                                    <option value="Fakultas Hukum" <?= old('fakultas', $user['fakultas']) == 'Fakultas Hukum' ? 'selected' : '' ?>>Fakultas Hukum</option>
                                    <option value="Fakultas Psikologi" <?= old('fakultas', $user['fakultas']) == 'Fakultas Psikologi' ? 'selected' : '' ?>>Fakultas Psikologi</option>
                                </select>
                            </div>
                            <div>
                                <label for="jurusan" class="block text-sm font-medium text-gray-700">Jurusan</label>
                                <select id="jurusan" name="jurusan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" required disabled>
                                    <option value="" disabled selected>Pilih Jurusan</option>
                                </select>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" name="email" value="<?= old('email', $user['email']) ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" required>
                            </div>
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                                <input type="text" id="username" name="username" value="<?= old('username', $user['username']) ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary" required>
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password (Kosongkan jika tidak ingin mengubah)</label>
                                <input type="password" id="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary">
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="<?= site_url('profile') ?>" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition-all">
                            Batal
                        </a>
                        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-secondary transition-all">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // University selection handler
        document.getElementById('universitas').addEventListener('change', function() {
            const otherUnivContainer = document.getElementById('otherUnivContainer');
            if (this.value === 'Other') {
                otherUnivContainer.classList.remove('hidden');
                document.getElementById('otherUniv').required = true;
            } else {
                otherUnivContainer.classList.add('hidden');
                document.getElementById('otherUniv').required = false;
            }
        });

        // Faculty selection handler
        document.getElementById('fakultas').addEventListener('change', function() {
            const jurusanSelect = document.getElementById('jurusan');
            jurusanSelect.innerHTML = '<option value="" disabled selected>Pilih Jurusan</option>';
            jurusanSelect.disabled = false;

            // Populate departments based on faculty
            switch (this.value) {
                case 'Fakultas Kedokteran':
                    jurusanSelect.innerHTML += '<option value="Kedokteran" <?= old('jurusan', $user['jurusan']) == 'Kedokteran' ? 'selected' : '' ?>>Kedokteran</option>';
                    break;
                case 'Fakultas Kedokteran Gigi':
                    jurusanSelect.innerHTML += '<option value="Kedokteran Gigi" <?= old('jurusan', $user['jurusan']) == 'Kedokteran Gigi' ? 'selected' : '' ?>>Kedokteran Gigi</option>';
                    break;
                case 'Fakultas Teknologi Informasi':
                    jurusanSelect.innerHTML += '<option value="Teknik Informatika" <?= old('jurusan', $user['jurusan']) == 'Teknik Informatika' ? 'selected' : '' ?>>Teknik Informatika</option>';
                    jurusanSelect.innerHTML += '<option value="Perpustakaan dan Sains Informasi" <?= old('jurusan', $user['jurusan']) == 'Perpustakaan dan Sains Informasi' ? 'selected' : '' ?>>Perpustakaan dan Sains Informasi</option>';
                    break;
                case 'Fakultas Ekonomi Bisnis':
                    jurusanSelect.innerHTML += '<option value="Manajemen" <?= old('jurusan', $user['jurusan']) == 'Manajemen' ? 'selected' : '' ?>>Manajemen</option>';
                    jurusanSelect.innerHTML += '<option value="Akuntansi" <?= old('jurusan', $user['jurusan']) == 'Akuntansi' ? 'selected' : '' ?>>Akuntansi</option>';
                    break;
                case 'Fakultas Hukum':
                    jurusanSelect.innerHTML += '<option value="Hukum" <?= old('jurusan', $user['jurusan']) == 'Hukum' ? 'selected' : '' ?>>Hukum</option>';
                    break;
                case 'Fakultas Psikologi':
                    jurusanSelect.innerHTML += '<option value="Psikologi" <?= old('jurusan', $user['jurusan']) == 'Psikologi' ? 'selected' : '' ?>>Psikologi</option>';
                    break;
                default:
                    jurusanSelect.disabled = true;
            }
        });
    </script>
</body>
</html> 