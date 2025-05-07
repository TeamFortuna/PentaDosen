<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penelitian - Penta Dosen</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                    },
                    colors: {
                        'primary': '#6366F1',
                        'primary-dark': '#4F46E5',
                        'secondary': '#8B5CF6',
                        'danger': '#EF4444',
                        'success': '#10B981',
                        'warning': '#F59E0B',
                        'info': '#3B82F6',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.3s ease-in',
                        'slide-up': 'slideUp 0.3s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': {
                                opacity: '0'
                            },
                            '100%': {
                                opacity: '1'
                            },
                        },
                        slideUp: {
                            '0%': {
                                transform: 'translateY(20px)',
                                opacity: '0'
                            },
                            '100%': {
                                transform: 'translateY(0)',
                                opacity: '1'
                            },
                        },
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- XLSX Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c7d2fe;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a5b4fc;
        }

        /* Dropzone */
        .dropzone {
            border: 2px dashed #cbd5e1;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .dropzone.active {
            border-color: #6366f1;
            background-color: #eef2ff;
        }

        .dropzone.accept {
            border-color: #10b981;
            background-color: #ecfdf5;
        }

        .dropzone.reject {
            border-color: #ef4444;
            background-color: #fef2f2;
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }

        /* Table styling */
        .research-table th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .research-table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        .research-table tr:hover td {
            background-color: #f8fafc;
        }

        /* Custom checkbox */
        .custom-checkbox {
            position: relative;
            padding-left: 28px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
        }

        .custom-checkbox input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .checkmark {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 0;
            height: 20px;
            width: 20px;
            background-color: #fff;
            border: 2px solid #cbd5e1;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .custom-checkbox:hover .checkmark {
            border-color: #a5b4fc;
        }

        .custom-checkbox input:checked~.checkmark {
            background-color: #6366f1;
            border-color: #6366f1;
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        .custom-checkbox input:checked~.checkmark:after {
            display: block;
        }

        .custom-checkbox .checkmark:after {
            left: 6px;
            top: 2px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        /* Sidebar Animation */
        .sidebar {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Modal Animation */
        .modal {
            animation: slide-up 0.3s ease-out;
        }

        /* Custom styles for fixes */
        .main-content {
            margin-left: 0;
        }

        @media (min-width: 768px) {
            .main-content {
                margin-left: 16rem;
            }
        }

        .rupiah-input {
            padding-left: 2.5rem !important;
        }

        .rupiah-symbol {
            left: 1rem;
        }
    </style>
</head>

<body class="flex h-screen overflow-hidden bg-gray-50 font-montserrat">
    <!-- Overlay -->
    <div class="overlay fixed inset-0 bg-black bg-opacity-50 z-40 hidden" id="overlay"></div>

    <!-- Modal Tambah Penelitian -->
    <div class="modal fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-4xl hidden" id="addResearchModal">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden mx-4 max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-primary sticky top-0">
                <h3 class="text-lg font-semibold text-white">Tambah Penelitian Baru</h3>
                <button id="closeAddResearchModal" class="text-white hover:text-gray-200 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <form id="researchForm" class="space-y-6" enctype="multipart/form-data">
                    <!-- Section 1.1 - Identitas Ketua (readonly) -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">1.1 Identitas Ketua Peneliti</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" value="<?= session()->get('nama') ?>" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">NIDN</label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" value="<?= session()->get('nidn') ?>" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" value="<?= session()->get('nip') ?>" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan Akademik</label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" value="<?= session()->get('jabatan') ?>" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Perguruan Tinggi</label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" value="<?= session()->get('universitas') ?>" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fakultas</label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" value="<?= session()->get('fakultas') ?>" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" value="<?= session()->get('jurusan') ?>" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" value="<?= session()->get('email') ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Section 1.2 - Proposal Penelitian -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">1.2 Proposal Penelitian</h4>

                        <!-- Judul Penelitian -->
                        <div class="mb-4">
                            <label for="researchTitle" class="block text-sm font-medium text-gray-700 mb-1">Judul Penelitian</label>
                            <input type="text" id="researchTitle" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition" required>
                        </div>

                        <!-- Skema dan Sumber Dana -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="researchScheme" class="block text-sm font-medium text-gray-700 mb-1">Skema</label>
                                <select id="researchScheme" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                                    <option value="" disabled selected>Pilih Skema</option>
                                    <option value="hibah_internal">Hibah Internal</option>
                                    <option value="hibah_eksternal">Hibah Eksternal</option>
                                    <option value="mandiri">Mandiri</option>
                                </select>
                            </div>
                            <div>
                                <label for="researchFundingSource" class="block text-sm font-medium text-gray-700 mb-1">Sumber Dana</label>
                                <div id="fundingSourceContainer">
                                    <select id="researchFundingSource" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                                        <option value="" disabled selected>Pilih Sumber Dana</option>
                                        <option value="yayasan_yarsi">Yayasan YARSI</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div id="otherFundingSourceContainer" class="mt-2 hidden">
                                    <input type="text" id="otherFundingSource" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition" placeholder="Masukkan sumber dana">
                                </div>
                            </div>
                        </div>

                        <!-- Biaya -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="proposedBudget" class="block text-sm font-medium text-gray-700 mb-1">Biaya yang Diusulkan</label>
                                <div class="relative">
                                    <span class="absolute rupiah-symbol left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                    <input type="text" id="proposedBudget" class="w-full rupiah-input px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition" placeholder="0">
                                </div>
                            </div>
                            <div>
                                <label for="approvedBudget" class="block text-sm font-medium text-gray-700 mb-1">Biaya yang Didanai</label>
                                <div class="relative">
                                    <span class="absolute rupiah-symbol left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                                    <input type="text" id="approvedBudget" class="w-full rupiah-input px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition" placeholder="0">
                                </div>
                            </div>
                        </div>

                        <!-- Anggota Dosen Internal -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-sm font-medium text-gray-700">Anggota Kegiatan (Dosen Internal)</label>
                                <button type="button" id="addInternalMember" class="text-sm text-primary hover:underline flex items-center">
                                    <i class="fas fa-plus mr-1"></i> Tambah Anggota
                                </button>
                            </div>

                            <div id="internalMembersContainer">
                                <!-- Anggota akan ditambahkan di sini -->
                            </div>

                            <!-- Template untuk anggota internal -->
                            <template id="internalMemberTemplate">
                                <div class="internal-member flex items-center gap-2 mb-2">
                                    <select class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent member-select">
                                        <option value="">Pilih Dosen</option>
                                        <?php if (isset($users) && !empty($users)): ?>
                                            <?php foreach ($users as $dosen): ?>
                                                <option value="<?= $dosen['id'] ?>"><?= $dosen['nama'] ?> - <?= $dosen['nidn'] ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <button type="button" class="remove-internal-member px-3 py-2 bg-danger text-white rounded-lg hover:bg-red-700 transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </template>
                        </div>

                        <!-- Anggota Dosen Eksternal -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-sm font-medium text-gray-700">Anggota Kegiatan (Dosen Eksternal)</label>
                                <button type="button" id="toggleExternalForm" class="text-sm text-primary hover:underline flex items-center">
                                    <i class="fas fa-plus mr-1"></i> Tambah Anggota
                                </button>
                            </div>

                            <!-- Form tambah anggota eksternal (awalnya tersembunyi) -->
                            <div id="externalMemberForm" class="hidden bg-gray-50 p-4 rounded-lg mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Anggota</label>
                                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent external-name">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">NIDN Anggota</label>
                                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent external-nidn">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan Akademik</label>
                                        <!-- <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent external-position"> -->
                                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition external-position">
                                            <option value="" disabled selected>Pilih Jabatan Akademik</option>
                                            <option value="guru_besar">Guru Besar</option>
                                            <option value="lektor_kepala">Lektor Kepala</option>
                                            <option value="lektor">Lektor</option>
                                            <option value="asisten_ahli">Asisten Ahli</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Perguruan Tinggi</label>
                                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition external-university">
                                            <option value="" disabled selected>Pilih Universitas</option>
                                            <option value="universitas_yarsi">Universitas YARSI</option>
                                            <option value="other">Lainnya</option>
                                        </select>
                                    </div>
                                    <div id="otherUniversityContainer" class="hidden">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perguruan Tinggi</label>
                                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition external-other-university">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Fakultas</label>
                                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition external-faculty">
                                            <option value="" disabled selected>Pilih Fakultas</option>
                                            <option value="kedokteran">Fakultas Kedokteran</option>
                                            <option value="kedokteran_gigi">Fakultas Kedokteran Gigi</option>
                                            <option value="teknologi_informasi">Fakultas Teknologi Informasi</option>
                                            <option value="ekonomi_bisnis">Fakultas Ekonomi Bisnis</option>
                                            <option value="hukum">Fakultas Hukum</option>
                                            <option value="psikologi">Fakultas Psikologi</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition external-study-program" disabled>
                                            <option value="">Pilih Program Studi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <button type="button" id="addExternalMemberBtn" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition">
                                        Tambah Anggota
                                    </button>
                                </div>
                            </div>

                            <div id="externalMembersContainer">
                                <!-- Anggota eksternal akan ditambahkan di sini -->
                            </div>
                        </div>

                        <!-- Upload Proposal -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Proposal Penelitian</label>
                            <div class="dropzone p-8 text-center cursor-pointer" id="proposalDropzone">
                                <input type="file" id="proposalFile" class="hidden" accept=".pdf">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                    <p class="text-sm text-gray-600">Drag & drop file proposal di sini atau klik untuk memilih</p>
                                    <p class="text-xs text-gray-500 mt-1">Format PDF (maks. 10MB)</p>
                                </div>
                            </div>
                            <div id="proposalPreview" class="hidden mt-2 p-3 bg-gray-50 rounded-lg">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                                        <span id="proposalFileName" class="text-sm font-medium"></span>
                                    </div>
                                    <button type="button" id="removeProposal" class="text-danger hover:text-red-700">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                                    <div id="proposalUploadProgress" class="bg-primary h-1.5 rounded-full" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" id="cancelResearch" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                            Batal
                        </button>
                        <button type="submit" id="saveResearch" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition flex items-center">
                            <i class="fas fa-save mr-2"></i> Simpan Penelitian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail Penelitian -->
    <div class="modal fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-4xl hidden" id="detailResearchModal">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden mx-4 max-h-[90vh] overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-primary sticky top-0">
                <h3 class="text-lg font-semibold text-white">Detail Penelitian</h3>
                <button id="closeDetailResearchModal" class="text-white hover:text-gray-200 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-2" id="detailResearchTitle"></h4>
                    <div class="flex items-center space-x-2 mb-4">
                        <span class="px-2 py-1 rounded-md text-xs" id="detailResearchStatus"></span>
                        <span class="text-sm text-gray-600" id="detailResearchDate"></span>
                    </div>
                </div>

                <!-- Section 1.1 - Identitas Ketua -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">1.1 Identitas Ketua Peneliti</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Nama</p>
                            <p class="font-medium" id="detailLeaderName"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">NIDN</p>
                            <p class="font-medium" id="detailLeaderNidn"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Jabatan</p>
                            <p class="font-medium" id="detailLeaderPosition"></p>
                        </div>
                    </div>
                </div>

                <!-- Section 1.2 - Detail Penelitian -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">1.2 Detail Penelitian</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Skema</p>
                            <p class="font-medium" id="detailResearchScheme"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Sumber Dana</p>
                            <p class="font-medium" id="detailResearchFunding"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Biaya Diusulkan</p>
                            <p class="font-medium" id="detailProposedBudget"></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Biaya Didanai</p>
                            <p class="font-medium" id="detailApprovedBudget"></p>
                        </div>
                    </div>
                </div>

                <!-- Section 1.3 - Anggota Penelitian -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">1.3 Anggota Penelitian</h4>
                    <div id="detailAnggotaContainer" class="space-y-4">
                        <!-- Anggota akan ditambahkan secara dinamis -->
                    </div>
                </div>

                <!-- Section 1.4 - File Penelitian -->
                <div class="mb-8">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">1.4 File Penelitian</h4>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-2">Proposal</p>
                            <a href="#" id="detailProposalLink" class="text-primary hover:underline hidden" target="_blank">
                                <i class="fas fa-file-pdf mr-1"></i> Lihat Proposal
                            </a>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-2">Laporan Kemajuan</p>
                            <a href="#" id="detailLaporanKemajuanLink" class="text-primary hover:underline hidden" target="_blank">
                                <i class="fas fa-file-pdf mr-1"></i> Lihat Laporan Kemajuan
                            </a>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-2">Laporan Akhir</p>
                            <a href="#" id="detailLaporanAkhirLink" class="text-primary hover:underline hidden" target="_blank">
                                <i class="fas fa-file-pdf mr-1"></i> Lihat Laporan Akhir
                            </a>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" id="closeDetailResearch" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Upload Laporan -->
    <div class="modal fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-md hidden" id="uploadReportModal">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden mx-4">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-primary">
                <h3 class="text-lg font-semibold text-white" id="uploadReportTitle">Upload Laporan</h3>
                <button id="closeUploadReportModal" class="text-white hover:text-gray-200 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <form id="uploadReportForm" enctype="multipart/form-data">
                    <input type="hidden" id="uploadReportResearchId">
                    <input type="hidden" id="uploadReportType">

                    <div class="mb-4">
                        <div class="dropzone p-8 text-center cursor-pointer" id="reportDropzone">
                            <input type="file" id="reportFile" class="hidden" accept=".pdf">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-600">Drag & drop file laporan di sini atau klik untuk memilih</p>
                                <p class="text-xs text-gray-500 mt-1">Format PDF (maks. 10MB)</p>
                            </div>
                        </div>
                        <div id="reportPreview" class="hidden mt-2 p-3 bg-gray-50 rounded-lg">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                                    <span id="reportFileName" class="text-sm font-medium"></span>
                                </div>
                                <button type="button" id="removeReport" class="text-danger hover:text-red-700">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                                <div id="reportUploadProgress" class="bg-primary h-1.5 rounded-full" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" id="cancelUploadReport" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                            Batal
                        </button>
                        <button type="submit" id="confirmUploadReport" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition flex items-center">
                            <i class="fas fa-upload mr-2"></i> Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Delete -->
    <div id="deleteConfirmModal" class="fixed inset-0 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black opacity-50"></div>
            <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="flex items-center justify-between p-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Hapus</h3>
                    <button id="closeDeleteConfirmModal" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="p-4">
                    <p id="deleteConfirmMessage" class="text-gray-600 mb-4"></p>
                    <div class="flex justify-end space-x-2">
                        <button id="cancelDelete" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                            Batal
                        </button>
                        <button id="confirmDelete" class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar w-64 bg-white shadow-lg flex flex-col h-full fixed z-50 -translate-x-full md:translate-x-0" id="sidebar">
        <!-- Logo and Toggle -->
        <div class="p-4 flex items-center justify-between border-b border-gray-200">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center text-white mr-3">
                    <i class="fas fa-flask text-xl"></i>
                </div>
                <h1 class="text-xl font-bold text-primary">Penta Dosen</h1>
            </div>
            <button class="menu-toggle md:hidden text-gray-500 hover:text-gray-700 transition" id="closeSidebar">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Menu -->
        <div class="flex-1 overflow-y-auto py-4">
            <ul class="space-y-1 px-4">
                <li>
                    <a href="<?= site_url('dashboard') ?>" class="sidebar-item flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-primary hover:bg-gray-100 font-medium transition">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('kalender') ?>" class="sidebar-item flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-primary hover:bg-gray-100 font-medium transition">
                        <i class="far fa-calendar-alt mr-3"></i>
                        Kalender
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('penelitian') ?>" class="sidebar-item flex items-center px-4 py-3 rounded-lg text-white bg-primary font-medium transition">
                        <i class="fas fa-microscope mr-3"></i>
                        Penelitian
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('publikasi') ?>" class="sidebar-item flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-primary hover:bg-gray-100 font-medium transition">
                        <i class="fas fa-book-open mr-3"></i>
                        Publikasi
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('hki') ?>" class="sidebar-item flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-indigo-600 font-medium">
                        <i class="fas fa-lightbulb mr-3"></i>
                        HKI
                    </a>
                </li>
            </ul>
        </div>

        <!-- User Profile -->
        <div class="p-4 border-t">
            <div class="flex items-center">
                <a href="<?= site_url('profile') ?>" class="flex items-center">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User" class="w-10 h-10 rounded-full mr-3">
                    <div>
                        <p class="font-medium text-gray-800"><?= $user['nama'] ?></p>
                        <p class="text-xs text-gray-500"><?= $user['jabatan'] ?></p>
                    </div>
                </a>
            </div>
            <button class="mt-3 w-full py-2 px-4 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700 transition duration-200 flex items-center justify-center">
                <a href="<?= site_url('auth/logout') ?>">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </a>
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden main-content">
        <!-- Top Bar -->
        <header class="bg-white shadow-sm z-10">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center">
                    <button class="menu-toggle mr-4 text-gray-600 hover:text-gray-800 md:hidden transition" id="openSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-xl font-semibold text-gray-800">Penelitian</h2>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button id="notificationBtn" class="p-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition relative">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 w-2 h-2 bg-danger rounded-full"></span>
                        </button>
                        <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-md shadow-lg z-20 py-1 border border-gray-200">
                            <div class="px-4 py-2 border-b border-gray-200">
                                <p class="text-sm font-medium text-gray-700">Notifikasi</p>
                            </div>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-200">
                                <p class="font-medium">Pengingat: Seminar Penelitian</p>
                                <p class="text-xs text-gray-500">Besok, 10:00 WIB</p>
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 border-b border-gray-200">
                                <p class="font-medium">Jurnal Anda telah diterima</p>
                                <p class="text-xs text-gray-500">Journal of Medical Sciences</p>
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <p class="font-medium">3 tugas baru ditambahkan</p>
                                <p class="text-xs text-gray-500">Lihat detail</p>
                            </a>
                            <div class="px-4 py-2 border-t border-gray-200">
                                <a href="#" class="text-xs text-primary hover:underline">Lihat semua notifikasi</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
            <!-- Filter dan Pencarian -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <!-- Button Tambah Penelitian dipindah ke kiri -->
                <div class="flex items-center w-full md:w-auto">
                    <button id="addResearchBtn" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition flex items-center">
                        <i class="fas fa-plus mr-2"></i> Tambah Penelitian
                    </button>
                    <!-- Search Bar dipindah ke kanan -->
                    <div class="relative ml-2 w-full md:w-64">
                        <input type="text" placeholder="Cari penelitian..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2 w-full md:w-auto">
                    <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                        <option value="">Semua Status</option>
                        <option value="draft">Draft</option>
                        <option value="submitted">Terkirim</option>
                        <option value="approved">Disetujui</option>
                        <option value="rejected">Ditolak</option>
                        <option value="in_progress">Dalam Proses</option>
                        <option value="completed">Selesai</option>
                    </select>
                    <select class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                        <option value="">Semua Tahun</option>
                        <option value="2023">2023</option>
                        <option value="2022">2022</option>
                        <option value="2021">2021</option>
                    </select>
                    <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition flex items-center">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                    <button id="exportExcelBtn" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center">
                        <i class="fas fa-file-excel mr-2"></i> Export Excel
                    </button>
                </div>
            </div>

            <!-- Tabel Penelitian -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden fade-in">
                <div class="overflow-x-auto">
                    <table class="w-full research-table">
                        <thead>
                            <tr>
                                <th class="text-left">No</th>
                                <th class="text-left">Judul Penelitian</th>
                                <th class="text-left">Ketua Peneliti</th>
                                <th class="text-left">Anggota</th>
                                <th class="text-left">Dana Disetujui</th>
                                <th class="text-left">Tanggal</th>
                                <th class="text-left">Proposal</th>
                                <th class="text-left">Laporan Kemajuan</th>
                                <th class="text-left">Laporan Akhir</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($penelitian) && !empty($penelitian)): ?>
                                <?php foreach ($penelitian as $index => $p): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td class="font-medium">
                                            <a href="#" class="text-primary hover:underline view-research" data-id="<?= $p['id'] ?>"><?= $p['judul'] ?></a>
                                        </td>
                                        <td><?= $p['ketua_nama'] ?></td>
                                        <td><?= $p['jumlah_anggota'] ?> Anggota</td>
                                        <td>Rp<?= number_format($p['biaya_didanai'], 0, ',', '.') ?></td>
                                        <td><?= date('d M Y', strtotime($p['tanggal'])) ?></td>
                                        <td>
                                            <?php if ($p['file_proposal']): ?>
                                                <a href="<?= base_url('uploads/proposal/' . $p['file_proposal']) ?>" class="text-primary hover:underline" target="_blank">
                                                    <i class="fas fa-file-pdf mr-1"></i> Lihat
                                                </a>
                                            <?php else: ?>
                                                <span class="text-gray-500">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($p['file_laporan_kemajuan']): ?>
                                                <a href="<?= base_url('uploads/laporan/' . $p['file_laporan_kemajuan']) ?>" class="text-primary hover:underline" target="_blank">
                                                    <i class="fas fa-file-pdf mr-1"></i> Lihat
                                                </a>
                                            <?php else: ?>
                                                <button class="text-primary hover:underline upload-report" data-type="progress" data-id="<?= $p['id'] ?>">
                                                    <i class="fas fa-upload mr-1"></i> Upload
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($p['file_laporan_akhir']): ?>
                                                <a href="<?= base_url('uploads/laporan/' . $p['file_laporan_akhir']) ?>" class="text-primary hover:underline" target="_blank">
                                                    <i class="fas fa-file-pdf mr-1"></i> Lihat
                                                </a>
                                            <?php else: ?>
                                                <button class="text-primary hover:underline upload-report" data-type="final" data-id="<?= $p['id'] ?>">
                                                    <i class="fas fa-upload mr-1"></i> Upload
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="flex justify-center space-x-2">
                                                <button class="text-primary hover:text-primary-dark edit-research" data-id="<?= $p['id'] ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="text-danger hover:text-red-700 delete-research" data-id="<?= $p['id'] ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center py-4 text-gray-500">
                                        Belum ada data penelitian
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- JavaScript -->
    <script>
        // Data penelitian dari database
        let researches = <?= json_encode($penelitian) ?>;

        // --- FUNGSI FORM TAMBAH PENELITIAN ---
        const addResearchBtn = document.getElementById('addResearchBtn');
        const addResearchModal = document.getElementById('addResearchModal');
        const overlay = document.getElementById('overlay');
        const closeAddResearchModal = document.getElementById('closeAddResearchModal');
        const cancelResearch = document.getElementById('cancelResearch');
        const researchForm = document.getElementById('researchForm');
        const researchScheme = document.getElementById('researchScheme');
        const fundingSourceContainer = document.getElementById('fundingSourceContainer');
        const otherFundingSourceContainer = document.getElementById('otherFundingSourceContainer');
        const researchFundingSource = document.getElementById('researchFundingSource');
        const addInternalMember = document.getElementById('addInternalMember');
        const internalMembersContainer = document.getElementById('internalMembersContainer');
        const internalMemberTemplate = document.getElementById('internalMemberTemplate');
        const toggleExternalForm = document.getElementById('toggleExternalForm');
        const externalMemberForm = document.getElementById('externalMemberForm');
        const externalUniversity = document.querySelector('.external-university');
        const otherUniversityContainer = document.getElementById('otherUniversityContainer');
        const addExternalMemberBtn = document.getElementById('addExternalMemberBtn');
        const externalMembersContainer = document.getElementById('externalMembersContainer');
        const proposalDropzone = document.getElementById('proposalDropzone');
        const proposalFile = document.getElementById('proposalFile');
        const proposalPreview = document.getElementById('proposalPreview');
        const proposalFileName = document.getElementById('proposalFileName');
        const removeProposal = document.getElementById('removeProposal');
        const proposedBudget = document.getElementById('proposedBudget');
        const approvedBudget = document.getElementById('approvedBudget');

        // Modal tambah penelitian
        addResearchBtn.addEventListener('click', function() {
            overlay.classList.remove('hidden');
            addResearchModal.classList.remove('hidden');
        });
        closeAddResearchModal.addEventListener('click', function() {
            overlay.classList.add('hidden');
            addResearchModal.classList.add('hidden');
            resetResearchForm();
        });
        cancelResearch.addEventListener('click', function() {
            overlay.classList.add('hidden');
            addResearchModal.classList.add('hidden');
            resetResearchForm();
        });

        function resetResearchForm() {
            researchForm.reset();
            internalMembersContainer.innerHTML = '';
            externalMembersContainer.innerHTML = '';
            externalMemberForm.classList.add('hidden');
            proposalFile.value = '';
            proposalPreview.classList.add('hidden');
            document.getElementById('proposalUploadProgress').style.width = '0%';
            otherFundingSourceContainer.classList.add('hidden');
        }
        // Tambah anggota internal
        defaultAddInternalMember();
        addInternalMember.addEventListener('click', function() {
            const template = internalMemberTemplate.content.cloneNode(true);
            internalMembersContainer.appendChild(template);
            updateRemoveInternalMemberListeners();
        });

        function updateRemoveInternalMemberListeners() {
            document.querySelectorAll('.remove-internal-member').forEach(button => {
                button.onclick = function() {
                    this.closest('.internal-member').remove();
                };
            });
        }

        function defaultAddInternalMember() {
            // Tambahkan satu anggota internal secara default jika kosong
            if (internalMembersContainer.children.length === 0) {
                const template = internalMemberTemplate.content.cloneNode(true);
                internalMembersContainer.appendChild(template);
                updateRemoveInternalMemberListeners();
            }
        }
        // Toggle form anggota eksternal
        toggleExternalForm.addEventListener('click', function() {
            externalMemberForm.classList.toggle('hidden');
        });
        // Handle perguruan tinggi eksternal
        externalUniversity.addEventListener('change', function() {
            if (this.value === 'other') {
                otherUniversityContainer.classList.remove('hidden');
            } else {
                otherUniversityContainer.classList.add('hidden');
            }
        });
        // Tambah anggota eksternal
        addExternalMemberBtn.addEventListener('click', function() {
            const name = document.querySelector('.external-name').value;
            const nidn = document.querySelector('.external-nidn').value;
            const position = document.querySelector('.external-position').value;
            const university = document.querySelector('.external-university').value;
            const otherUniversity = document.querySelector('.external-other-university').value;
            const faculty = document.querySelector('.external-faculty').value;
            const studyProgram = document.querySelector('.external-study-program').value;
            if (!name) {
                alert('Nama anggota harus diisi');
                return;
            }
            if (!nidn) {
                alert('NIDN anggota harus diisi');
                return;
            }
            let universityText = university === 'other' ? otherUniversity : 'Universitas YARSI';
            let facultyText = '';
            switch (faculty) {
                case 'kedokteran':
                    facultyText = 'Fakultas Kedokteran';
                    break;
                case 'kedokteran_gigi':
                    facultyText = 'Fakultas Kedokteran Gigi';
                    break;
                case 'teknologi_informasi':
                    facultyText = 'Fakultas Teknologi Informasi';
                    break;
                case 'ekonomi_bisnis':
                    facultyText = 'Fakultas Ekonomi Bisnis';
                    break;
                case 'hukum':
                    facultyText = 'Fakultas Hukum';
                    break;
                case 'psikologi':
                    facultyText = 'Fakultas Psikologi';
                    break;
            }
            let studyProgramText = '';
            switch (studyProgram) {
                case 'kedokteran':
                    studyProgramText = 'Kedokteran';
                    break;
                case 'kedokteran_gigi':
                    studyProgramText = 'Kedokteran Gigi';
                    break;
                case 'teknik_informatika':
                    studyProgramText = 'Teknik Informatika';
                    break;
                case 'perpustakaan_dan_sains_informasi':
                    studyProgramText = 'Perpustakaan dan Sains Informasi';
                    break;
                case 'manajemen':
                    studyProgramText = 'Manajemen';
                    break;
                case 'akuntansi':
                    studyProgramText = 'Akuntansi';
                    break;
                case 'hukum':
                    studyProgramText = 'Hukum';
                    break;
                case 'psikologi':
                    studyProgramText = 'Psikologi';
                    break;
            }
            const memberDiv = document.createElement('div');
            memberDiv.className = 'external-member-item bg-gray-50 p-3 rounded-lg mb-2 flex justify-between items-center';
            memberDiv.innerHTML = `
                <div>
                    <p class="text-sm font-medium">${name} - ${nidn} (${universityText})</p>
                    <p class="text-xs text-gray-600">${position} - ${facultyText} - ${studyProgramText}</p>
                </div>
                <button type="button" class="remove-external-member text-danger hover:text-red-700">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            externalMembersContainer.appendChild(memberDiv);
            // Reset form
            document.querySelector('.external-name').value = '';
            document.querySelector('.external-nidn').value = '';
            document.querySelector('.external-position').value = '';
            document.querySelector('.external-university').value = 'universitas_yarsi';
            document.querySelector('.external-other-university').value = '';
            document.querySelector('.external-faculty').value = '';
            document.querySelector('.external-study-program').value = '';
            document.querySelector('.external-study-program').disabled = true;
            otherUniversityContainer.classList.add('hidden');
            externalMemberForm.classList.add('hidden');
            // Handle penghapusan anggota
            memberDiv.querySelector('.remove-external-member').addEventListener('click', function() {
                memberDiv.remove();
            });
        });
        // Handle dropzone proposal
        proposalDropzone.addEventListener('click', function() {
            proposalFile.click();
        });
        proposalFile.addEventListener('change', function() {
            if (this.files.length > 0) {
                const file = this.files[0];
                if (file.size > 10 * 1024 * 1024) {
                    alert('Ukuran file maksimal 10MB');
                    return;
                }
                if (file.type !== 'application/pdf') {
                    alert('Hanya file PDF yang diizinkan');
                    return;
                }
                proposalFileName.textContent = file.name;
                proposalPreview.classList.remove('hidden');
                // Simulasi upload
                let progress = 0;
                const interval = setInterval(() => {
                    progress += 5;
                    document.getElementById('proposalUploadProgress').style.width = `${progress}%`;
                    if (progress >= 100) {
                        clearInterval(interval);
                    }
                }, 100);
            }
        });
        proposalDropzone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('active');
        });
        proposalDropzone.addEventListener('dragleave', function() {
            this.classList.remove('active');
        });
        proposalDropzone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('active');
            if (e.dataTransfer.files.length > 0) {
                const file = e.dataTransfer.files[0];
                if (file.size > 10 * 1024 * 1024) {
                    alert('Ukuran file maksimal 10MB');
                    return;
                }
                if (file.type !== 'application/pdf') {
                    alert('Hanya file PDF yang diizinkan');
                    return;
                }
                proposalFile.files = e.dataTransfer.files;
                proposalFileName.textContent = file.name;
                proposalPreview.classList.remove('hidden');
            }
        });
        removeProposal.addEventListener('click', function() {
            proposalFile.value = '';
            proposalPreview.classList.add('hidden');
            document.getElementById('proposalUploadProgress').style.width = '0%';
        });
        // Format input biaya
        function formatCurrencyInput(input) {
            input.addEventListener('input', function(e) {
                let value = this.value.replace(/[^0-9]/g, '');
                if (value === '') {
                    this.value = '';
                    return;
                }
                const formatted = new Intl.NumberFormat('id-ID').format(parseInt(value));
                this.value = formatted;
            });
        }
        formatCurrencyInput(proposedBudget);
        formatCurrencyInput(approvedBudget);
        // Sumber dana lainnya
        researchFundingSource.addEventListener('change', function() {
            if (this.value === 'lainnya') {
                otherFundingSourceContainer.classList.remove('hidden');
            } else {
                otherFundingSourceContainer.classList.add('hidden');
            }
        });
        // Event listener submit form tambah penelitian
        researchForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData();
            formData.append('judul', document.getElementById('researchTitle').value);
            formData.append('skema', document.getElementById('researchScheme').value);
            formData.append('sumber_dana', document.getElementById('researchFundingSource').value);
            formData.append('biaya_diusulkan', document.getElementById('proposedBudget').value.replace(/[^0-9]/g, ''));
            formData.append('biaya_didanai', document.getElementById('approvedBudget').value.replace(/[^0-9]/g, ''));
            // File proposal
            const proposalFile = document.getElementById('proposalFile').files[0];
            if (proposalFile) {
                formData.append('file_proposal', proposalFile);
            }
            // Anggota internal
            const internalMembers = [];
            document.querySelectorAll('.internal-member select').forEach(select => {
                if (select.value) {
                    internalMembers.push(select.value);
                }
            });
            formData.append('anggota_internal', JSON.stringify(internalMembers));
            // Anggota eksternal
            const externalMembers = [];
            document.querySelectorAll('.external-member-item').forEach(item => {
                const memberData = {
                    nama: item.querySelector('.text-sm.font-medium').textContent.split(' - ')[0],
                    nidn: item.querySelector('.text-sm.font-medium').textContent.split(' - ')[1].split(' ')[0],
                    jabatan: item.querySelector('.text-xs.text-gray-600').textContent.split(' - ')[0],
                    universitas: item.querySelector('.text-sm.font-medium').textContent.split('(')[1].replace(')', ''),
                    fakultas: item.querySelector('.text-xs.text-gray-600').textContent.split(' - ')[1],
                    jurusan: item.querySelector('.text-xs.text-gray-600').textContent.split(' - ')[2]
                };
                externalMembers.push(memberData);
            });
            formData.append('anggota_eksternal', JSON.stringify(externalMembers));
            // Kirim ke backend
            fetch('<?= base_url('penelitian/save') ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan data');
                });
        });

        // Event listener untuk klik judul penelitian
        document.querySelectorAll('.view-research').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const researchId = this.dataset.id;

                // Tampilkan modal dan overlay
                overlay.classList.remove('hidden');
                document.getElementById('detailResearchModal').classList.remove('hidden');

                // Ambil data penelitian
                fetch(`/penelitian/detail/${researchId}`)
                    .then(response => response.json())
                    .then(result => {
                        if (result.status === 'success') {
                            const data = result.data;

                            // Isi data ke dalam modal
                            document.getElementById('detailResearchTitle').textContent = data.judul;
                            document.getElementById('detailResearchStatus').textContent = data.status;
                            document.getElementById('detailResearchDate').textContent = new Date(data.tanggal).toLocaleDateString('id-ID', {
                                day: 'numeric',
                                month: 'long',
                                year: 'numeric'
                            });

                            // Isi data ketua penelitian
                            document.getElementById('detailLeaderName').textContent = data.ketua.nama;
                            document.getElementById('detailLeaderNidn').textContent = data.ketua.nidn;
                            document.getElementById('detailLeaderPosition').textContent = data.ketua.jabatan;

                            // Isi data penelitian
                            document.getElementById('detailResearchScheme').textContent = data.skema;
                            document.getElementById('detailResearchFunding').textContent = data.sumber_dana;
                            document.getElementById('detailProposedBudget').textContent = `Rp${Number(data.biaya_diusulkan).toLocaleString('id-ID')}`;
                            document.getElementById('detailApprovedBudget').textContent = `Rp${Number(data.biaya_didanai).toLocaleString('id-ID')}`;

                            // Isi data anggota
                            const anggotaContainer = document.getElementById('detailAnggotaContainer');
                            anggotaContainer.innerHTML = '';

                            data.anggota.forEach(anggota => {
                                const anggotaDiv = document.createElement('div');
                                anggotaDiv.className = 'mb-4 p-4 bg-gray-50 rounded-lg';
                                anggotaDiv.innerHTML = `
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm text-gray-600">Nama</p>
                                            <p class="font-medium">${anggota.nama}</p>
                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">NIDN</p>
                                            <p class="font-medium">${anggota.nidn}</p>
                    </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Jabatan</p>
                                            <p class="font-medium">${anggota.jabatan}</p>
                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Universitas</p>
                                            <p class="font-medium">${anggota.universitas}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Fakultas</p>
                                            <p class="font-medium">${anggota.fakultas}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600">Jurusan</p>
                                            <p class="font-medium">${anggota.jurusan}</p>
                                        </div>
                    </div>
                `;
                                anggotaContainer.appendChild(anggotaDiv);
                            });

                            // Isi data file
                            if (data.file_proposal) {
                                document.getElementById('detailProposalLink').href = `/uploads/proposal/${data.file_proposal}`;
                                document.getElementById('detailProposalLink').classList.remove('hidden');
                            } else {
                                document.getElementById('detailProposalLink').classList.add('hidden');
                            }

                            if (data.file_laporan_kemajuan) {
                                document.getElementById('detailLaporanKemajuanLink').href = `/uploads/laporan/${data.file_laporan_kemajuan}`;
                                document.getElementById('detailLaporanKemajuanLink').classList.remove('hidden');
                            } else {
                                document.getElementById('detailLaporanKemajuanLink').classList.add('hidden');
                            }

                            if (data.file_laporan_akhir) {
                                document.getElementById('detailLaporanAkhirLink').href = `/uploads/laporan/${data.file_laporan_akhir}`;
                                document.getElementById('detailLaporanAkhirLink').classList.remove('hidden');
                            } else {
                                document.getElementById('detailLaporanAkhirLink').classList.add('hidden');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengambil data penelitian');
                    });
            });
        });

        // Event listener untuk tombol tutup modal detail
        document.getElementById('closeDetailResearchModal').addEventListener('click', function() {
            overlay.classList.add('hidden');
            document.getElementById('detailResearchModal').classList.add('hidden');
        });

        document.getElementById('closeDetailResearch').addEventListener('click', function() {
            overlay.classList.add('hidden');
            document.getElementById('detailResearchModal').classList.add('hidden');
        });

        // Event listener untuk tombol upload laporan
        document.querySelectorAll('.upload-report').forEach(button => {
            button.addEventListener('click', function() {
                const researchId = this.dataset.id;
                const type = this.dataset.type;

                // Set nilai pada form
                document.getElementById('uploadReportResearchId').value = researchId;
                document.getElementById('uploadReportType').value = type;

                // Set judul modal
                const title = type === 'progress' ? 'Upload Laporan Kemajuan' : 'Upload Laporan Akhir';
                document.getElementById('uploadReportTitle').textContent = title;

                // Tampilkan modal
                overlay.classList.remove('hidden');
                document.getElementById('uploadReportModal').classList.remove('hidden');
            });
        });

        // Event listener untuk dropzone laporan
        const reportDropzone = document.getElementById('reportDropzone');
        const reportFile = document.getElementById('reportFile');
        const reportPreview = document.getElementById('reportPreview');
        const reportFileName = document.getElementById('reportFileName');
        const removeReport = document.getElementById('removeReport');

        reportDropzone.addEventListener('click', function() {
            reportFile.click();
        });

        reportFile.addEventListener('change', function() {
            if (this.files.length > 0) {
                const file = this.files[0];
                if (file.size > 10 * 1024 * 1024) {
                    alert('Ukuran file maksimal 10MB');
                    return;
                }
                if (file.type !== 'application/pdf') {
                    alert('Hanya file PDF yang diizinkan');
                    return;
                }
                reportFileName.textContent = file.name;
                reportPreview.classList.remove('hidden');
            }
        });

        reportDropzone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('active');
        });

        reportDropzone.addEventListener('dragleave', function() {
            this.classList.remove('active');
        });

        reportDropzone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('active');
            if (e.dataTransfer.files.length > 0) {
                const file = e.dataTransfer.files[0];
                if (file.size > 10 * 1024 * 1024) {
                    alert('Ukuran file maksimal 10MB');
                    return;
                }
                if (file.type !== 'application/pdf') {
                    alert('Hanya file PDF yang diizinkan');
                    return;
                }
                reportFile.files = e.dataTransfer.files;
                reportFileName.textContent = file.name;
                reportPreview.classList.remove('hidden');
            }
        });

        removeReport.addEventListener('click', function() {
            reportFile.value = '';
            reportPreview.classList.add('hidden');
            document.getElementById('reportUploadProgress').style.width = '0%';
        });

        // Event listener untuk form upload laporan
        document.getElementById('uploadReportForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData();
            formData.append('type', document.getElementById('uploadReportType').value);
            formData.append('file', reportFile.files[0]);

            const researchId = document.getElementById('uploadReportResearchId').value;

            fetch(`/penelitian/upload-laporan/${researchId}`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(result => {
                    if (result.status === 'success') {
                        alert(result.message);
                        location.reload();
                    } else {
                        alert(result.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengupload file');
                });
        });

        // Event listener untuk tombol tutup modal upload
        document.getElementById('closeUploadReportModal').addEventListener('click', function() {
            overlay.classList.add('hidden');
            document.getElementById('uploadReportModal').classList.add('hidden');
            resetUploadReportForm();
        });

        document.getElementById('cancelUploadReport').addEventListener('click', function() {
            overlay.classList.add('hidden');
            document.getElementById('uploadReportModal').classList.add('hidden');
            resetUploadReportForm();
        });

        function resetUploadReportForm() {
            document.getElementById('uploadReportForm').reset();
            reportPreview.classList.add('hidden');
            document.getElementById('reportUploadProgress').style.width = '0%';
        }

        // Event listener untuk tombol delete penelitian
        document.querySelectorAll('.delete-research').forEach(button => {
            button.addEventListener('click', function() {
                const researchId = this.dataset.id;

                // Tampilkan modal konfirmasi
                overlay.classList.remove('hidden');
                document.getElementById('deleteConfirmModal').classList.remove('hidden');

                // Set pesan konfirmasi
                document.getElementById('deleteConfirmMessage').textContent = 'Apakah Anda yakin ingin menghapus penelitian ini? Tindakan ini tidak dapat dibatalkan.';

                // Event listener untuk tombol konfirmasi delete
                document.getElementById('confirmDelete').onclick = function() {
                    fetch(`/penelitian/delete/${researchId}`, {
                            method: 'DELETE'
                        })
                        .then(response => response.json())
                        .then(result => {
                            if (result.status === 'success') {
                                alert(result.message);
                                location.reload();
                            } else {
                                alert(result.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan saat menghapus penelitian');
                        });
                };
            });
        });

        // Event listener untuk tombol tutup modal konfirmasi delete
        document.getElementById('closeDeleteConfirmModal').addEventListener('click', function() {
            overlay.classList.add('hidden');
            document.getElementById('deleteConfirmModal').classList.add('hidden');
        });

        document.getElementById('cancelDelete').addEventListener('click', function() {
            overlay.classList.add('hidden');
            document.getElementById('deleteConfirmModal').classList.add('hidden');
        });

        // Event listener untuk tombol export Excel
        document.getElementById('exportExcelBtn').addEventListener('click', function() {
            try {
                // Ambil data yang sedang ditampilkan di tabel
                const rows = [];
                const headers = [
                    "No", "Judul Penelitian", "Ketua Peneliti", "Anggota", "Dana Disetujui", "Tanggal", "Status"
                ];
                rows.push(headers);

                // Ambil data penelitian
                researches.forEach((p, index) => {
                    const date = new Date(p.tanggal);
                    const formattedDate = date.toLocaleDateString('id-ID', {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric'
                    });

                    rows.push([
                        index + 1,
                        p.judul,
                        p.ketua_nama,
                        p.jumlah_anggota + ' Anggota',
                        'Rp' + Number(p.biaya_didanai).toLocaleString('id-ID'),
                        formattedDate,
                        p.status
                    ]);
                });

                // Buat worksheet dan workbook
                const ws = XLSX.utils.aoa_to_sheet(rows);
                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Data Penelitian");

                // Download file
                XLSX.writeFile(wb, "data_penelitian.xlsx");
            } catch (error) {
                console.error('Error saat mengekspor data:', error);
                alert('Terjadi kesalahan saat mengekspor data ke Excel');
            }
        });
    </script>
</body>

</html>