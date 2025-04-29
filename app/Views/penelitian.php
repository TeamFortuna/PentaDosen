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
                <form id="researchForm">
                    <!-- Section 1.1 - Identitas Ketua (readonly) -->
                    <div class="mb-8">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">1.1 Identitas Ketua Peneliti</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" value="Prof. Dr. Andi Wijaya" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">NIDN</label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" value="0023067101" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" value="197003101994021001" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan Akademik</label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" value="Guru Besar" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Perguruan Tinggi</label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" value="Universitas YARSI" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fakultas</label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" value="Fakultas Kedokteran" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Program Studi</label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" value="Kedokteran" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100" value="andi.wijaya@yarsi.ac.id" readonly>
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
                                        <option value="1">Dr. Budi Santoso - 0023067102</option>
                                        <option value="2">Dr. Siti Rahayu - 0023067103</option>
                                        <option value="3">Dr. Ahmad Fauzi - 0023067104</option>
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
                <div class="mb-6">
                    <h5 class="text-md font-semibold text-gray-800 mb-3 border-b pb-2">Identitas Ketua Peneliti</h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nama</label>
                            <p class="text-sm text-gray-800" id="detailLeaderName"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">NIDN</label>
                            <p class="text-sm text-gray-800" id="detailLeaderNidn"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">NIP</label>
                            <p class="text-sm text-gray-800" id="detailLeaderNip"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Jabatan Akademik</label>
                            <p class="text-sm text-gray-800" id="detailLeaderPosition"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Perguruan Tinggi</label>
                            <p class="text-sm text-gray-800" id="detailLeaderUniversity"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Fakultas</label>
                            <p class="text-sm text-gray-800" id="detailLeaderFaculty"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Program Studi</label>
                            <p class="text-sm text-gray-800" id="detailLeaderStudyProgram"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                            <p class="text-sm text-gray-800" id="detailLeaderEmail"></p>
                        </div>
                    </div>
                </div>

                <!-- Section 1.2 - Proposal Penelitian -->
                <div class="mb-6">
                    <h5 class="text-md font-semibold text-gray-800 mb-3 border-b pb-2">Proposal Penelitian</h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Skema</label>
                            <p class="text-sm text-gray-800" id="detailResearchScheme"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Sumber Dana</label>
                            <p class="text-sm text-gray-800" id="detailResearchFunding"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Biaya yang Diusulkan</label>
                            <p class="text-sm text-gray-800" id="detailProposedBudget"></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Biaya yang Didanai</label>
                            <p class="text-sm text-gray-800" id="detailApprovedBudget"></p>
                        </div>
                    </div>

                    <!-- Anggota Penelitian -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500 mb-2">Anggota Penelitian</label>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h6 class="text-sm font-medium text-gray-700 mb-2">Dosen Internal</h6>
                            <ul class="list-disc list-inside text-sm text-gray-800 mb-4" id="detailInternalMembers">
                                <!-- Anggota internal akan ditambahkan di sini -->
                            </ul>

                            <h6 class="text-sm font-medium text-gray-700 mb-2">Dosen Eksternal</h6>
                            <ul class="list-disc list-inside text-sm text-gray-800" id="detailExternalMembers">
                                <!-- Anggota eksternal akan ditambahkan di sini -->
                            </ul>
                        </div>
                    </div>

                    <!-- File Proposal -->
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-2">File Proposal</label>
                        <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                            <div class="flex items-center">
                                <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                                <span class="text-sm font-medium text-gray-800" id="detailProposalFile"></span>
                            </div>
                            <a href="#" class="text-sm text-primary hover:underline" id="detailProposalDownload">Unduh</a>
                        </div>
                    </div>
                </div>

                <!-- Laporan Kemajuan dan Akhir -->
                <div class="mb-6">
                    <h5 class="text-md font-semibold text-gray-800 mb-3 border-b pb-2">Laporan Penelitian</h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Laporan Kemajuan</label>
                            <div id="progressReportContainer" class="bg-gray-50 rounded-lg p-3">
                                <p class="text-sm text-gray-500 italic">Belum ada laporan kemajuan</p>
                            </div>
                            <button type="button" class="mt-2 px-3 py-1 bg-primary text-white rounded-lg hover:bg-primary-dark transition text-sm flex items-center" id="uploadProgressReport">
                                <i class="fas fa-upload mr-1"></i> Upload Laporan
                            </button>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-2">Laporan Akhir</label>
                            <div id="finalReportContainer" class="bg-gray-50 rounded-lg p-3">
                                <p class="text-sm text-gray-500 italic">Belum ada laporan akhir</p>
                            </div>
                            <button type="button" class="mt-2 px-3 py-1 bg-primary text-white rounded-lg hover:bg-primary-dark transition text-sm flex items-center" id="uploadFinalReport">
                                <i class="fas fa-upload mr-1"></i> Upload Laporan
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" id="editResearch" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition flex items-center">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </button>
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
                    <button type="button" id="confirmUploadReport" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition flex items-center">
                        <i class="fas fa-upload mr-2"></i> Upload
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-md hidden" id="deleteConfirmModal">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden mx-4">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-danger">
                <h3 class="text-lg font-semibold text-white">Konfirmasi Hapus</h3>
                <button id="closeDeleteConfirmModal" class="text-white hover:text-gray-200 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6">
                <div class="flex items-center justify-center mb-4">
                    <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-danger text-2xl"></i>
                    </div>
                </div>
                <p class="text-center text-gray-700 mb-6" id="deleteConfirmMessage">Apakah Anda yakin ingin menghapus penelitian ini? Tindakan ini tidak dapat dibatalkan.</p>
                <div class="flex justify-center space-x-4">
                    <button type="button" id="cancelDelete" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">
                        Batal
                    </button>
                    <button type="button" id="confirmDelete" class="px-6 py-2 bg-danger text-white rounded-lg hover:bg-red-700 transition">
                        Ya, Hapus
                    </button>
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
                    <a href="hki.html" class="sidebar-item flex items-center px-4 py-3 rounded-lg text-gray-600 hover:text-primary hover:bg-gray-100 font-medium transition">
                        <i class="fas fa-lightbulb mr-3"></i>
                        HKI
                    </a>
                </li>
            </ul>
        </div>

        <!-- User Profile -->
        <div class="p-4 border-t border-gray-200">
            <div class="flex items-center">
                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User" class="w-10 h-10 rounded-full mr-3 object-cover">
                <div>
                    <p class="font-medium text-gray-800">Muhammad Syafi'ul Umam S.Kom.</p>
                    <p class="text-xs text-gray-500">Dosen Fakultas Teknik Informatika</p>
                </div>
            </div>
            <button class="mt-3 w-full py-2 px-4 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700 transition duration-200 flex items-center justify-center">
                <a href="<?= site_url('homepage') ?>">
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
                            <!-- Baris 1 -->
                            <tr>
                                <td>1</td>
                                <td class="font-medium">
                                    <a href="#" class="text-primary hover:underline view-research" data-id="1">Studi tentang Pengaruh Obat X terhadap Penyakit Y</a>
                                </td>
                                <td>Prof. Dr. Andi Wijaya</td>
                                <td>3 Anggota</td>
                                <td>Rp15.000.000</td>
                                <td>15 Jul 2023</td>
                                <td>
                                    <a href="#" class="text-primary hover:underline">
                                        <i class="fas fa-file-pdf mr-1"></i> Lihat
                                    </a>
                                </td>
                                <td>
                                    <button class="text-primary hover:underline upload-report" data-type="progress" data-id="1">
                                        <i class="fas fa-upload mr-1"></i> Upload
                                    </button>
                                </td>
                                <td>
                                    <button class="text-primary hover:underline upload-report" data-type="final" data-id="1">
                                        <i class="fas fa-upload mr-1"></i> Upload
                                    </button>
                                </td>
                                <td class="text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button class="text-primary hover:text-primary-dark edit-research" data-id="1">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-danger hover:text-red-700 delete-research" data-id="1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Baris 2 -->
                            <tr>
                                <td>2</td>
                                <td class="font-medium">
                                    <a href="#" class="text-primary hover:underline view-research" data-id="2">Analisis Genomik Pasien COVID-19 di Indonesia</a>
                                </td>
                                <td>Prof. Dr. Andi Wijaya</td>
                                <td>2 Anggota</td>
                                <td>Rp25.000.000</td>
                                <td>10 Jun 2023</td>
                                <td>
                                    <a href="#" class="text-primary hover:underline">
                                        <i class="fas fa-file-pdf mr-1"></i> Lihat
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="text-primary hover:underline">
                                        <i class="fas fa-file-pdf mr-1"></i> Lihat
                                    </a>
                                </td>
                                <td>
                                    <button class="text-primary hover:underline upload-report" data-type="final" data-id="2">
                                        <i class="fas fa-upload mr-1"></i> Upload
                                    </button>
                                </td>
                                <td class="text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button class="text-primary hover:text-primary-dark edit-research" data-id="2">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-danger hover:text-red-700 delete-research" data-id="2">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Baris 3 -->
                            <tr>
                                <td>3</td>
                                <td class="font-medium">
                                    <a href="#" class="text-primary hover:underline view-research" data-id="3">Efektivitas Terapi Baru untuk Diabetes Melitus</a>
                                </td>
                                <td>Prof. Dr. Andi Wijaya</td>
                                <td>4 Anggota</td>
                                <td>Rp30.000.000</td>
                                <td>5 Mei 2023</td>
                                <td>
                                    <a href="#" class="text-primary hover:underline">
                                        <i class="fas fa-file-pdf mr-1"></i> Lihat
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="text-primary hover:underline">
                                        <i class="fas fa-file-pdf mr-1"></i> Lihat
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="text-primary hover:underline">
                                        <i class="fas fa-file-pdf mr-1"></i> Lihat
                                    </a>
                                </td>
                                <td class="text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button class="text-primary hover:text-primary-dark edit-research" data-id="3">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-danger hover:text-red-700 delete-research" data-id="3">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        <p class="text-sm text-gray-700">
                            Menampilkan <span class="font-medium">1</span> sampai <span class="font-medium">3</span> dari <span class="font-medium">3</span> penelitian
                        </p>
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 disabled" disabled>
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="px-3 py-1 border border-primary rounded-lg bg-primary text-white hover:bg-primary-dark">
                            1
                        </button>
                        <button class="px-3 py-1 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 disabled" disabled>
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- JavaScript -->
    <script>
        // Data penelitian (simulasi database)
        let researches = [{
                id: '1',
                title: 'Studi tentang Pengaruh Obat X terhadap Penyakit Y',
                leader: {
                    name: 'Prof. Dr. Andi Wijaya',
                    nidn: '0023067101',
                    nip: '197003101994021001',
                    position: 'Guru Besar',
                    university: 'Universitas YARSI',
                    faculty: 'Fakultas Kedokteran',
                    studyProgram: 'Kedokteran',
                    email: 'andi.wijaya@yarsi.ac.id'
                },
                scheme: 'Hibah Internal',
                fundingSource: 'Yayasan YARSI',
                proposedBudget: 20000000,
                approvedBudget: 15000000,
                status: 'approved',
                date: '2023-07-15',
                internalMembers: [
                    'Dr. Budi Santoso - 0023067102',
                    'Dr. Siti Rahayu - 0023067103'
                ],
                externalMembers: [
                    'Dr. Ahmad Fauzi - 0023067104 (Universitas Indonesia)'
                ],
                proposalFile: 'proposal_obat_x.pdf',
                progressReport: null,
                finalReport: null
            },
            {
                id: '2',
                title: 'Analisis Genomik Pasien COVID-19 di Indonesia',
                leader: {
                    name: 'Prof. Dr. Andi Wijaya',
                    nidn: '0023067101',
                    nip: '197003101994021001',
                    position: 'Guru Besar',
                    university: 'Universitas YARSI',
                    faculty: 'Fakultas Kedokteran',
                    studyProgram: 'Kedokteran',
                    email: 'andi.wijaya@yarsi.ac.id'
                },
                scheme: 'Hibah Eksternal',
                fundingSource: 'DIKTI',
                proposedBudget: 30000000,
                approvedBudget: 25000000,
                status: 'in_progress',
                date: '2023-06-10',
                internalMembers: [
                    'Dr. Budi Santoso - 0023067102'
                ],
                externalMembers: [],
                proposalFile: 'proposal_genomik_covid.pdf',
                progressReport: 'laporan_kemajuan_genomik.pdf',
                finalReport: null
            },
            {
                id: '3',
                title: 'Efektivitas Terapi Baru untuk Diabetes Melitus',
                leader: {
                    name: 'Prof. Dr. Andi Wijaya',
                    nidn: '0023067101',
                    nip: '197003101994021001',
                    position: 'Guru Besar',
                    university: 'Universitas YARSI',
                    faculty: 'Fakultas Kedokteran',
                    studyProgram: 'Kedokteran',
                    email: 'andi.wijaya@yarsi.ac.id'
                },
                scheme: 'Mandiri',
                fundingSource: 'Pribadi',
                proposedBudget: 15000000,
                approvedBudget: 15000000,
                status: 'completed',
                date: '2023-05-05',
                internalMembers: [
                    'Dr. Budi Santoso - 0023067102',
                    'Dr. Siti Rahayu - 0023067103',
                    'Dr. Ahmad Fauzi - 0023067104'
                ],
                externalMembers: [
                    'Dr. Rina Dewi - 0023067105 (Universitas Gadjah Mada)'
                ],
                proposalFile: 'proposal_terapi_diabetes.pdf',
                progressReport: 'laporan_kemajuan_diabetes.pdf',
                finalReport: 'laporan_akhir_diabetes.pdf'
            }
        ];

        // DOM Elements
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const openSidebar = document.getElementById('openSidebar');
        const closeSidebar = document.getElementById('closeSidebar');
        const notificationBtn = document.getElementById('notificationBtn');
        const notificationDropdown = document.getElementById('notificationDropdown');
        const addResearchBtn = document.getElementById('addResearchBtn');
        const addResearchModal = document.getElementById('addResearchModal');
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
        const detailResearchModal = document.getElementById('detailResearchModal');
        const closeDetailResearchModal = document.getElementById('closeDetailResearchModal');
        const closeDetailResearch = document.getElementById('closeDetailResearch');
        const editResearch = document.getElementById('editResearch');
        const viewResearchLinks = document.querySelectorAll('.view-research');
        const editResearchButtons = document.querySelectorAll('.edit-research');
        const deleteResearchButtons = document.querySelectorAll('.delete-research');
        const uploadReportButtons = document.querySelectorAll('.upload-report');
        const uploadReportModal = document.getElementById('uploadReportModal');
        const closeUploadReportModal = document.getElementById('closeUploadReportModal');
        const cancelUploadReport = document.getElementById('cancelUploadReport');
        const uploadReportTitle = document.getElementById('uploadReportTitle');
        const reportDropzone = document.getElementById('reportDropzone');
        const reportFile = document.getElementById('reportFile');
        const reportPreview = document.getElementById('reportPreview');
        const reportFileName = document.getElementById('reportFileName');
        const removeReport = document.getElementById('removeReport');
        const confirmUploadReport = document.getElementById('confirmUploadReport');
        const uploadProgressReport = document.getElementById('uploadProgressReport');
        const uploadFinalReport = document.getElementById('uploadFinalReport');
        const proposedBudget = document.getElementById('proposedBudget');
        const approvedBudget = document.getElementById('approvedBudget');

        // DOM Elements untuk modal delete
        const deleteConfirmModal = document.getElementById('deleteConfirmModal');
        const closeDeleteConfirmModal = document.getElementById('closeDeleteConfirmModal');
        const cancelDelete = document.getElementById('cancelDelete');
        const confirmDelete = document.getElementById('confirmDelete');
        const deleteConfirmMessage = document.getElementById('deleteConfirmMessage');

        // Variabel untuk menyimpan ID penelitian yang akan dihapus
        let researchToDelete = null;

        // Toggle sidebar on mobile
        openSidebar.addEventListener('click', () => {
            sidebar.classList.add('translate-x-0');
            overlay.classList.remove('hidden');
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.remove('translate-x-0');
            overlay.classList.add('hidden');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('translate-x-0');
            overlay.classList.add('hidden');
            addResearchModal.classList.add('hidden');
            detailResearchModal.classList.add('hidden');
            uploadReportModal.classList.add('hidden');
            deleteConfirmModal.classList.add('hidden');
        });

        // Notification dropdown
        notificationBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            notificationDropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', () => {
            notificationDropdown.classList.add('hidden');
        });

        // Format Rupiah
        function formatRupiah(angka) {
            if (!angka) return 'Rp0';
            const numberString = angka.toString().replace(/[^0-9]/g, '');
            const split = numberString.split('.');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            const ribuan = split[0].substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                const separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return 'Rp' + rupiah;
        }

        // Format tanggal
        function formatDate(dateString) {
            const options = {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        }

        // Format status
        function formatStatus(status) {
            const statusMap = {
                'draft': {
                    text: 'Draft',
                    color: 'bg-gray-100 text-gray-800'
                },
                'submitted': {
                    text: 'Terkirim',
                    color: 'bg-blue-100 text-blue-800'
                },
                'approved': {
                    text: 'Disetujui',
                    color: 'bg-green-100 text-green-800'
                },
                'rejected': {
                    text: 'Ditolak',
                    color: 'bg-red-100 text-red-800'
                },
                'in_progress': {
                    text: 'Dalam Proses',
                    color: 'bg-yellow-100 text-yellow-800'
                },
                'completed': {
                    text: 'Selesai',
                    color: 'bg-purple-100 text-purple-800'
                }
            };
            return statusMap[status] || {
                text: status,
                color: 'bg-gray-100 text-gray-800'
            };
        }

        // Handle skema perubahan
        researchScheme.addEventListener('change', function() {
            const scheme = this.value;
            let fundingOptions = '';

            if (scheme === 'hibah_internal') {
                fundingOptions = `
                    <select id="researchFundingSource" class="w-full px-4 py-2 border border-gray-300 rounded-lg focuaq:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                        <option value="yayasan_yarsi">Yayasan YARSI</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                `;
            } else if (scheme === 'hibah_eksternal') {
                fundingOptions = `
                    <select id="researchFundingSource" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                        <option value="dikti">DIKTI</option>
                        <option value="brin">BRIN</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                `;
            } else if (scheme === 'mandiri') {
                fundingOptions = `
                    <select id="researchFundingSource" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                        <option value="pribadi">Pribadi</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                `;
            }

            fundingSourceContainer.innerHTML = fundingOptions;

            // Tambahkan event listener untuk select yang baru dibuat
            document.getElementById('researchFundingSource').addEventListener('change', function() {
                if (this.value === 'lainnya') {
                    otherFundingSourceContainer.classList.remove('hidden');
                } else {
                    otherFundingSourceContainer.classList.add('hidden');
                }
            });
        });

        // Handle sumber dana lainnya
        researchFundingSource.addEventListener('change', function() {
            if (this.value === 'lainnya') {
                otherFundingSourceContainer.classList.remove('hidden');
            } else {
                otherFundingSourceContainer.classList.add('hidden');
            }
        });

        // Format input biaya
        function formatCurrencyInput(input) {
            input.addEventListener('input', function(e) {
                // Format nilai
                let value = this.value.replace(/[^0-9]/g, '');

                // Boleh kosong
                if (value === '') {
                    this.value = '';
                    return;
                }

                // Format ke Rupiah (tanpa 'Rp' karena kamu sudah pakai simbol terpisah di sebelah kiri)
                const formatted = new Intl.NumberFormat('id-ID').format(parseInt(value));
                this.value = formatted;
            });


        }

        // Terapkan format currency ke input biaya
        formatCurrencyInput(proposedBudget);
        formatCurrencyInput(approvedBudget);

        // Tambah anggota internal
        addInternalMember.addEventListener('click', function() {
            const template = internalMemberTemplate.content.cloneNode(true);
            internalMembersContainer.appendChild(template);

            // Handle penghapusan anggota
            const removeButtons = document.querySelectorAll('.remove-internal-member');
            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.internal-member').remove();
                });
            });
        });

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

        // Handle fakultas eksternal
        document.querySelector('.external-faculty').addEventListener('change', function() {
            const faculty = this.value;
            const studyProgramSelect = document.querySelector('.external-study-program');
            studyProgramSelect.innerHTML = '<option value="">Pilih Program Studi</option>';
            studyProgramSelect.disabled = !faculty;

            if (faculty) {
                let programs = [];

                switch (faculty) {
                    case 'kedokteran':
                        programs = ['Kedokteran'];
                        break;
                    case 'kedokteran_gigi':
                        programs = ['Kedokteran Gigi'];
                        break;
                    case 'teknologi_informasi':
                        programs = ['Teknik Informatika', 'Perpustakaan dan Sains Informasi'];
                        break;
                    case 'ekonomi_bisnis':
                        programs = ['Manajemen', 'Akuntansi'];
                        break;
                    case 'hukum':
                        programs = ['Hukum'];
                        break;
                    case 'psikologi':
                        programs = ['Psikologi'];
                        break;
                }

                programs.forEach(program => {
                    const option = document.createElement('option');
                    option.value = program.toLowerCase().replace(/ /g, '_');
                    option.textContent = program;
                    studyProgramSelect.appendChild(option);
                });
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

        removeProposal.addEventListener('click', function() {
            proposalFile.value = '';
            proposalPreview.classList.add('hidden');
            document.getElementById('proposalUploadProgress').style.width = '0%';
        });

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

        // Simpan penelitian
        researchForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const title = document.getElementById('researchTitle').value;
            if (!title) {
                alert('Judul penelitian harus diisi');
                return;
            }

            if (!proposalFile.files.length) {
                alert('File proposal harus diupload');
                return;
            }

            // Dapatkan sumber dana
            let fundingSource = document.getElementById('researchFundingSource').value;
            if (fundingSource === 'lainnya') {
                fundingSource = document.getElementById('otherFundingSource').value;
                if (!fundingSource) {
                    alert('Harap masukkan sumber dana');
                    return;
                }
            }

            // Simpan data penelitian
            const newResearch = {
                id: Date.now().toString(),
                title: title,
                leader: {
                    name: 'Prof. Dr. Andi Wijaya',
                    nidn: '0023067101',
                    nip: '197003101994021001',
                    position: 'Guru Besar',
                    university: 'Universitas YARSI',
                    faculty: 'Fakultas Kedokteran',
                    studyProgram: 'Kedokteran',
                    email: 'andi.wijaya@yarsi.ac.id'
                },
                scheme: document.getElementById('researchScheme').options[document.getElementById('researchScheme').selectedIndex].text,
                fundingSource: fundingSource,
                proposedBudget: parseInt(document.getElementById('proposedBudget').value.replace(/[^0-9]/g, '')),
                approvedBudget: parseInt(document.getElementById('approvedBudget').value.replace(/[^0-9]/g, '')),
                status: 'submitted',
                date: new Date().toISOString().split('T')[0],
                internalMembers: [],
                externalMembers: [],
                proposalFile: proposalFile.files[0].name,
                progressReport: null,
                finalReport: null
            };

            // Tambahkan anggota internal
            document.querySelectorAll('.member-select').forEach(select => {
                if (select.value) {
                    const selectedOption = select.options[select.selectedIndex];
                    newResearch.internalMembers.push(selectedOption.text);
                }
            });

            // Tambahkan anggota eksternal
            document.querySelectorAll('.external-member-item').forEach(item => {
                const name = item.querySelector('p').textContent;
                newResearch.externalMembers.push(name.split(' (')[0]); // Ambil nama dan NIDN saja
            });

            researches.unshift(newResearch);
            renderResearchTable();

            overlay.classList.add('hidden');
            addResearchModal.classList.add('hidden');
            resetResearchForm();

            alert('Penelitian berhasil disimpan');
        });

        // Tampilkan detail penelitian
        function showResearchDetail(id) {
            const research = researches.find(r => r.id === id);
            if (!research) return;

            document.getElementById('detailResearchTitle').textContent = research.title;

            const status = formatStatus(research.status);
            const statusElement = document.getElementById('detailResearchStatus');
            statusElement.textContent = status.text;
            statusElement.className = `px-2 py-1 rounded-md text-xs ${status.color}`;

            document.getElementById('detailResearchDate').textContent = formatDate(research.date);

            // Identitas ketua
            document.getElementById('detailLeaderName').textContent = research.leader.name;
            document.getElementById('detailLeaderNidn').textContent = research.leader.nidn;
            document.getElementById('detailLeaderNip').textContent = research.leader.nip;
            document.getElementById('detailLeaderPosition').textContent = research.leader.position;
            document.getElementById('detailLeaderUniversity').textContent = research.leader.university;
            document.getElementById('detailLeaderFaculty').textContent = research.leader.faculty;
            document.getElementById('detailLeaderStudyProgram').textContent = research.leader.studyProgram;
            document.getElementById('detailLeaderEmail').textContent = research.leader.email;

            // Proposal penelitian
            document.getElementById('detailResearchScheme').textContent = research.scheme;
            document.getElementById('detailResearchFunding').textContent = research.fundingSource;
            document.getElementById('detailProposedBudget').textContent = formatRupiah(research.proposedBudget);
            document.getElementById('detailApprovedBudget').textContent = formatRupiah(research.approvedBudget);

            // Anggota penelitian
            const internalMembersList = document.getElementById('detailInternalMembers');
            internalMembersList.innerHTML = '';
            research.internalMembers.forEach(member => {
                const li = document.createElement('li');
                li.textContent = member;
                internalMembersList.appendChild(li);
            });

            const externalMembersList = document.getElementById('detailExternalMembers');
            externalMembersList.innerHTML = '';
            research.externalMembers.forEach(member => {
                const li = document.createElement('li');
                li.textContent = member;
                externalMembersList.appendChild(li);
            });

            // File proposal
            document.getElementById('detailProposalFile').textContent = research.proposalFile;
            document.getElementById('detailProposalDownload').href = `#${research.id}`;

            // Laporan kemajuan
            const progressReportContainer = document.getElementById('progressReportContainer');
            if (research.progressReport) {
                progressReportContainer.innerHTML = `
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                            <span class="text-sm font-medium">${research.progressReport}</span>
                        </div>
                        <a href="#${research.id}" class="text-sm text-primary hover:underline">Unduh</a>
                    </div>
                `;
            } else {
                progressReportContainer.innerHTML = '<p class="text-sm text-gray-500 italic">Belum ada laporan kemajuan</p>';
            }

            // Laporan akhir
            const finalReportContainer = document.getElementById('finalReportContainer');
            if (research.finalReport) {
                finalReportContainer.innerHTML = `
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                            <span class="text-sm font-medium">${research.finalReport}</span>
                        </div>
                        <a href="#${research.id}" class="text-sm text-primary hover:underline">Unduh</a>
                    </div>
                `;
            } else {
                finalReportContainer.innerHTML = '<p class="text-sm text-gray-500 italic">Belum ada laporan akhir</p>';
            }

            // Set ID penelitian untuk edit
            detailResearchModal.dataset.researchId = research.id;

            // Tampilkan modal
            overlay.classList.remove('hidden');
            detailResearchModal.classList.remove('hidden');
        }

        // Render tabel penelitian
        function renderResearchTable() {
            const tableBody = document.querySelector('.research-table tbody');
            tableBody.innerHTML = '';

            researches.forEach((research, index) => {
                const status = formatStatus(research.status);

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td class="font-medium">
                        <a href="#" class="text-primary hover:underline view-research" data-id="${research.id}">${research.title}</a>
                    </td>
                    <td>${research.leader.name}</td>
                    <td>${research.internalMembers.length + research.externalMembers.length} Anggota</td>
                    <td>${formatRupiah(research.approvedBudget)}</td>
                    <td>${formatDate(research.date)}</td>
                    <td>
                        <a href="#" class="text-primary hover:underline">
                            <i class="fas fa-file-pdf mr-1"></i> Lihat
                        </a>
                    </td>
                    <td>
                        ${research.progressReport ? `
                            <a href="#" class="text-primary hover:underline">
                                <i class="fas fa-file-pdf mr-1"></i> Lihat
                            </a>
                        ` : `
                            <button class="text-primary hover:underline upload-report" data-type="progress" data-id="${research.id}">
                                <i class="fas fa-upload mr-1"></i> Upload
                            </button>
                        `}
                    </td>
                    <td>
                        ${research.finalReport ? `
                            <a href="#" class="text-primary hover:underline">
                                <i class="fas fa-file-pdf mr-1"></i> Lihat
                            </a>
                        ` : `
                            <button class="text-primary hover:underline upload-report" data-type="final" data-id="${research.id}">
                                <i class="fas fa-upload mr-1"></i> Upload
                            </button>
                        `}
                    </td>
                    <td class="text-center">
                        <div class="flex justify-center space-x-2">
                            <button class="text-primary hover:text-primary-dark edit-research" data-id="${research.id}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="text-danger hover:text-red-700 delete-research" data-id="${research.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                `;

                tableBody.appendChild(row);
            });

            // Tambahkan event listener untuk tombol view, edit, delete
            addResearchEventListeners();
        }

        // Tambahkan event listener untuk penelitian
        function addResearchEventListeners() {
            document.querySelectorAll('.view-research').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    showResearchDetail(this.dataset.id);
                });
            });

            document.querySelectorAll('.edit-research').forEach(button => {
                button.addEventListener('click', function() {
                    const researchId = this.dataset.id;
                    editResearchById(researchId);
                });
            });

            document.querySelectorAll('.delete-research').forEach(button => {
                button.addEventListener('click', function() {
                    const researchId = this.dataset.id;
                    const research = researches.find(r => r.id === researchId);
                    if (research) {
                        showDeleteConfirmModal(researchId, research.title);
                    }
                });
            });

            document.querySelectorAll('.upload-report').forEach(button => {
                button.addEventListener('click', function() {
                    const researchId = this.dataset.id;
                    const reportType = this.dataset.type;
                    openUploadReportModal(researchId, reportType);
                });
            });
        }

        // Fungsi untuk menampilkan modal konfirmasi hapus
        function showDeleteConfirmModal(researchId, researchTitle) {
            researchToDelete = researchId;
            deleteConfirmMessage.textContent = `Apakah Anda yakin ingin menghapus penelitian "${researchTitle}"? Tindakan ini tidak dapat dibatalkan.`;
            overlay.classList.remove('hidden');
            deleteConfirmModal.classList.remove('hidden');
        }

        // Fungsi untuk menutup modal konfirmasi hapus
        function closeDeleteConfirmModalFunc() {
            overlay.classList.add('hidden');
            deleteConfirmModal.classList.add('hidden');
            researchToDelete = null;
        }

        // Edit penelitian
        function editResearchById(id) {
            const research = researches.find(r => r.id === id);
            if (!research) return;

            document.getElementById('researchTitle').value = research.title;

            // Set skema
            const schemeSelect = document.getElementById('researchScheme');
            for (let i = 0; i < schemeSelect.options.length; i++) {
                if (schemeSelect.options[i].text === research.scheme) {
                    schemeSelect.selectedIndex = i;
                    break;
                }
            }

            // Trigger change event untuk update sumber dana
            const schemeEvent = new Event('change');
            schemeSelect.dispatchEvent(schemeEvent);

            // Set sumber dana
            const fundingSource = research.fundingSource;
            const fundingSelect = document.getElementById('researchFundingSource');
            let found = false;

            for (let i = 0; i < fundingSelect.options.length; i++) {
                if (fundingSelect.options[i].text === fundingSource) {
                    fundingSelect.selectedIndex = i;
                    found = true;
                    break;
                }
            }

            if (!found) {
                fundingSelect.value = 'lainnya';
                document.getElementById('otherFundingSource').value = fundingSource;
                otherFundingSourceContainer.classList.remove('hidden');
            }

            // Set biaya
            document.getElementById('proposedBudget').value = formatRupiah(research.proposedBudget).replace('Rp', '');
            document.getElementById('approvedBudget').value = formatRupiah(research.approvedBudget).replace('Rp', '');

            // Anggota internal
            internalMembersContainer.innerHTML = '';
            research.internalMembers.forEach(member => {
                const template = internalMemberTemplate.content.cloneNode(true);
                const select = template.querySelector('.member-select');

                // Temukan opsi yang sesuai dengan anggota
                const options = Array.from(select.options);
                const optionToSelect = options.find(opt => opt.text.includes(member.split(' - ')[0]));
                if (optionToSelect) {
                    optionToSelect.selected = true;
                }

                internalMembersContainer.appendChild(template);

                // Tambahkan event listener untuk tombol hapus
                template.querySelector('.remove-internal-member').addEventListener('click', function() {
                    this.closest('.internal-member').remove();
                });
            });

            // Anggota eksternal
            externalMembersContainer.innerHTML = '';
            research.externalMembers.forEach(member => {
                const memberDiv = document.createElement('div');
                memberDiv.className = 'external-member-item bg-gray-50 p-3 rounded-lg mb-2 flex justify-between items-center';
                memberDiv.innerHTML = `
                    <div>
                        <p class="text-sm font-medium">${member}</p>
                    </div>
                    <button type="button" class="remove-external-member text-danger hover:text-red-700">
                        <i class="fas fa-trash"></i>
                    </button>
                `;

                externalMembersContainer.appendChild(memberDiv);

                // Tambahkan event listener untuk tombol hapus
                memberDiv.querySelector('.remove-external-member').addEventListener('click', function() {
                    memberDiv.remove();
                });
            });

            // File proposal (simulasi)
            proposalFileName.textContent = research.proposalFile;
            proposalPreview.classList.remove('hidden');
            document.getElementById('proposalUploadProgress').style.width = '100%';

            // Set ID penelitian untuk form
            researchForm.dataset.researchId = id;

            // Tampilkan modal
            overlay.classList.remove('hidden');
            addResearchModal.classList.remove('hidden');
        }

        // Tombol edit di modal detail
        editResearch.addEventListener('click', function() {
            const researchId = detailResearchModal.dataset.researchId;
            closeDetailResearchModalFunc();
            editResearchById(researchId);
        });

        // Tutup modal detail
        closeDetailResearchModal.addEventListener('click', closeDetailResearchModalFunc);
        closeDetailResearch.addEventListener('click', closeDetailResearchModalFunc);

        function closeDetailResearchModalFunc() {
            overlay.classList.add('hidden');
            detailResearchModal.classList.add('hidden');
        }

        // Modal upload laporan
        function openUploadReportModal(researchId, reportType) {
            uploadReportModal.dataset.researchId = researchId;
            uploadReportModal.dataset.reportType = reportType;

            if (reportType === 'progress') {
                uploadReportTitle.textContent = 'Upload Laporan Kemajuan';
            } else {
                uploadReportTitle.textContent = 'Upload Laporan Akhir';
            }

            // Reset form
            reportFile.value = '';
            reportPreview.classList.add('hidden');
            document.getElementById('reportUploadProgress').style.width = '0%';

            overlay.classList.remove('hidden');
            uploadReportModal.classList.remove('hidden');
        }

        // Handle dropzone laporan
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

                // Simulasi upload
                let progress = 0;
                const interval = setInterval(() => {
                    progress += 5;
                    document.getElementById('reportUploadProgress').style.width = `${progress}%`;

                    if (progress >= 100) {
                        clearInterval(interval);
                    }
                }, 100);
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

                // Simulasi upload
                let progress = 0;
                const interval = setInterval(() => {
                    progress += 5;
                    document.getElementById('reportUploadProgress').style.width = `${progress}%`;

                    if (progress >= 100) {
                        clearInterval(interval);
                    }
                }, 100);
            }
        });

        removeReport.addEventListener('click', function() {
            reportFile.value = '';
            reportPreview.classList.add('hidden');
            document.getElementById('reportUploadProgress').style.width = '0%';
        });

        // Tombol upload laporan
        confirmUploadReport.addEventListener('click', function() {
            const researchId = uploadReportModal.dataset.researchId;
            const reportType = uploadReportModal.dataset.reportType;

            if (!reportFile.files.length) {
                alert('File laporan harus diupload');
                return;
            }

            const researchIndex = researches.findIndex(r => r.id === researchId);
            if (researchIndex !== -1) {
                const fileName = reportFile.files[0].name;

                if (reportType === 'progress') {
                    researches[researchIndex].progressReport = fileName;
                } else {
                    researches[researchIndex].finalReport = fileName;
                }

                renderResearchTable();
                closeUploadReportModalFunc();
                alert('Laporan berhasil diupload');
            }
        });

        // Tombol upload dari modal detail
        uploadProgressReport.addEventListener('click', function() {
            const researchId = detailResearchModal.dataset.researchId;
            closeDetailResearchModalFunc();
            openUploadReportModal(researchId, 'progress');
        });

        uploadFinalReport.addEventListener('click', function() {
            const researchId = detailResearchModal.dataset.researchId;
            closeDetailResearchModalFunc();
            openUploadReportModal(researchId, 'final');
        });

        // Tutup modal upload laporan
        closeUploadReportModal.addEventListener('click', closeUploadReportModalFunc);
        cancelUploadReport.addEventListener('click', closeUploadReportModalFunc);

        function closeUploadReportModalFunc() {
            overlay.classList.add('hidden');
            uploadReportModal.classList.add('hidden');
        }

        // Event listener untuk konfirmasi hapus
        confirmDelete.addEventListener('click', function() {
            if (researchToDelete) {
                researches = researches.filter(r => r.id !== researchToDelete);
                renderResearchTable();
                closeDeleteConfirmModalFunc();
                // Tampilkan notifikasi sukses
                alert('Penelitian berhasil dihapus');
            }
        });

        // Event listener untuk batal hapus
        cancelDelete.addEventListener('click', closeDeleteConfirmModalFunc);
        closeDeleteConfirmModal.addEventListener('click', closeDeleteConfirmModalFunc);

        // Inisialisasi
        document.addEventListener('DOMContentLoaded', function() {
            renderResearchTable();

            // Event listener untuk sidebar
            openSidebar.addEventListener('click', () => {
                sidebar.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
            });

            closeSidebar.addEventListener('click', () => {
                sidebar.classList.remove('translate-x-0');
                overlay.classList.add('hidden');
            });

            // Event listener untuk dropdown notifikasi
            notificationBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                notificationDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', () => {
                notificationDropdown.classList.add('hidden');
            });

            // Event listener untuk sumber dana
            researchFundingSource.addEventListener('change', function() {
                if (this.value === 'lainnya') {
                    otherFundingSourceContainer.classList.remove('hidden');
                } else {
                    otherFundingSourceContainer.classList.add('hidden');
                }
            });
        });
    </script>
</body>

</html>