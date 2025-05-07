<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PublikasiModel;
use App\Models\DosenModel;

class PublikasiController extends Controller
{
    protected $publikasiModel;
    protected $dosenModel;

    public function __construct()
    {
        $this->publikasiModel = new PublikasiModel();
        $this->dosenModel = new DosenModel();
        helper(['form', 'filesystem', 'url']);
    }

    public function index()
    {
        // Cek role user
        $userId = session()->get('id');
        $role = session()->get('role');

        $data = [
            'title' => 'Manajemen Publikasi',
            'user' => [
                'id' => $userId,
                'nama' => session()->get('nama'),
                'nidn' => session()->get('nidn'),
                'nip' => session()->get('nip'),
                'inisial' => session()->get('inisial'),
                'jabatan' => session()->get('jabatan'),
                'universitas' => session()->get('universitas'),
                'fakultas' => session()->get('fakultas'),
                'jurusan' => session()->get('jurusan'),
                'email' => session()->get('email'),
                'username' => session()->get('username'),
                'role' => $role
            ],
            'dosen' => $this->dosenModel->getAllDosen()
        ];

        try {
            if ($role === 'admin') {
                $data['publikasi'] = $this->publikasiModel->getAllPublikasiWithPenulis();
            } else {
                $data['publikasi'] = $this->publikasiModel->getPublikasiByDosen($userId);
            }

            // For AJAX requests, return JSON
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'data' => $data['publikasi']
                ]);
            }

            return view('publikasi', $data);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());

            if ($this->request->isAJAX()) {
                return $this->response->setStatusCode(500)->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal memuat data publikasi'
                ]);
            }

            return view('publikasi', $data);
        }
    }

    public function getAllForAdmin()
    {
        if (session()->get('role') !== 'admin') {
            return $this->response->setStatusCode(403)->setJSON([
                'status' => 'error',
                'message' => 'Akses ditolak'
            ]);
        }

        try {
            $publikasi = $this->publikasiModel->getAllPublikasiWithPenulis();
            return $this->response->setJSON([
                'status' => 'success',
                'data' => $publikasi
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => 'Gagal memuat data publikasi'
            ]);
        }
    }

    public function store()
    {
        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'required|max_length[255]',
            'kategori' => 'required|in_list[karya-ilmiah,buku-ilmiah]',
            'jenis' => 'required|in_list[artikel,buku,majalah]',
            'tanggal_terbit' => 'required|valid_date',
            'jumlah_halaman' => 'required|numeric|greater_than[0]',
            'penerbit' => 'required|max_length[255]',
            'isbn' => 'permit_empty|max_length[20]',
            'penulis' => 'required',
            'file' => 'uploaded[file]|max_size[file,10240]|ext_in[file,pdf,doc,docx]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors()
            ]);
        }

        // Upload file
        $file = $this->request->getFile('file');

        // Generate filename: judulpublikasi_tanggaldibuat.ext
        $judul = $this->request->getPost('judul');
        $judulSlug = url_title($judul, '_', true);
        $tanggal = date('Ymd');
        $ext = $file->getExtension();
        $newName = $judulSlug . '_' . $tanggal . '.' . $ext;

        // Pindahkan file dengan nama baru
        $file->move(WRITEPATH . 'uploads/publikasi', $newName);

        // Data publikasi
        $dataPublikasi = [
            'judul' => $judul,
            'kategori' => $this->request->getPost('kategori'),
            'jenis' => $this->request->getPost('jenis'),
            'tanggal_terbit' => $this->request->getPost('tanggal_terbit'),
            'jumlah_halaman' => $this->request->getPost('jumlah_halaman'),
            'penerbit' => $this->request->getPost('penerbit'),
            'isbn' => $this->request->getPost('isbn'),
            'file_path' => $newName,
            'file_size' => $file->getSize(),
            'created_by' => session()->get('id')
        ];

        // Penulis
        $penulisIds = $this->request->getPost('penulis');

        // Simpan ke database
        if ($this->publikasiModel->addPublikasiWithPenulis($dataPublikasi, $penulisIds)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Publikasi berhasil ditambahkan'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Gagal menambahkan publikasi'
        ]);
    }

    public function update($id)
    {
        // Cek method override untuk PUT
        if ($this->request->getMethod() === 'post' && $this->request->getHeaderLine('X-HTTP-Method-Override') === 'PUT') {
            $this->request = $this->request->setMethod('PUT');
        }

        // Cek apakah publikasi ada
        $existingPublikasi = $this->publikasiModel->find($id);
        if (!$existingPublikasi) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Publikasi tidak ditemukan'
            ]);
        }

        // Cek hak akses
        if (session()->get('role') !== 'admin' && $existingPublikasi['created_by'] != session()->get('id')) {
            return $this->response->setStatusCode(403)->setJSON([
                'status' => 'error',
                'message' => 'Anda tidak memiliki izin untuk mengedit publikasi ini'
            ]);
        }

        // Validasi input (hanya untuk field yang diisi)
        $validation = \Config\Services::validation();
        $validation->setRules([
            'judul' => 'permit_empty|max_length[255]',
            'kategori' => 'permit_empty|in_list[karya-ilmiah,buku-ilmiah]',
            'jenis' => 'permit_empty|in_list[artikel,buku,majalah]',
            'tanggal_terbit' => 'permit_empty|valid_date',
            'jumlah_halaman' => 'permit_empty|numeric|greater_than[0]',
            'penerbit' => 'permit_empty|max_length[255]',
            'isbn' => 'permit_empty|max_length[20]',
            'penulis' => 'permit_empty',
            'file' => 'max_size[file,10240]|ext_in[file,pdf,doc,docx]'
        ]);

        // Jalankan validasi hanya jika ada file yang diupload
        $file = $this->request->getFile('file');
        if ($file && $file->isValid()) {
            if (!$validation->withRequest($this->request)->run()) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status' => 'error',
                    'errors' => $validation->getErrors(),
                    'message' => 'Validasi gagal, harap periksa kembali data yang diinput'
                ]);
            }
        }

        // Data publikasi - hanya update field yang diisi
        $dataPublikasi = [];

        if ($this->request->getPost('judul')) {
            $dataPublikasi['judul'] = $this->request->getPost('judul');
        }
        if ($this->request->getPost('kategori')) {
            $dataPublikasi['kategori'] = $this->request->getPost('kategori');
        }
        if ($this->request->getPost('jenis')) {
            $dataPublikasi['jenis'] = $this->request->getPost('jenis');
        }
        if ($this->request->getPost('tanggal_terbit')) {
            $dataPublikasi['tanggal_terbit'] = $this->request->getPost('tanggal_terbit');
        }
        if ($this->request->getPost('jumlah_halaman')) {
            $dataPublikasi['jumlah_halaman'] = $this->request->getPost('jumlah_halaman');
        }
        if ($this->request->getPost('penerbit')) {
            $dataPublikasi['penerbit'] = $this->request->getPost('penerbit');
        }
        if ($this->request->getPost('isbn')) {
            $dataPublikasi['isbn'] = $this->request->getPost('isbn');
        }

        // Handle file upload hanya jika ada file yang dipilih
        if ($file && $file->isValid()) {
            // Validasi ukuran file
            if ($file->getSize() > 10 * 1024 * 1024) { // 10MB
                return $this->response->setStatusCode(400)->setJSON([
                    'status' => 'error',
                    'message' => 'Ukuran file terlalu besar. Maksimal 10MB'
                ]);
            }

            // Hapus file lama
            if ($existingPublikasi['file_path'] && file_exists(WRITEPATH . 'uploads/publikasi/' . $existingPublikasi['file_path'])) {
                unlink(WRITEPATH . 'uploads/publikasi/' . $existingPublikasi['file_path']);
            }

            // Generate nama file baru
            $judul = $this->request->getPost('judul') ?: $existingPublikasi['judul'];
            $judulSlug = url_title($judul, '_', true);
            $tanggal = date('Ymd');
            $ext = $file->getExtension();
            $newName = $judulSlug . '_' . $tanggal . '.' . $ext;

            // Upload file baru
            $file->move(WRITEPATH . 'uploads/publikasi', $newName);

            $dataPublikasi['file_path'] = $newName;
            $dataPublikasi['file_size'] = $file->getSize();
        }

        // Penulis - jika diisi
        $penulisIds = $this->request->getPost('penulis') ?: null;

        // Update database
        try {
            $result = $this->publikasiModel->updatePublikasiWithPenulis($id, $dataPublikasi, $penulisIds);

            if ($result) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Publikasi berhasil diperbarui'
                ]);
            }

            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => 'Gagal memperbarui publikasi di database'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error updating publikasi: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan server saat memperbarui publikasi'
            ]);
        }
    }

    public function delete($id)
    {
        // Cek apakah publikasi ada
        $publikasi = $this->publikasiModel->find($id);
        if (!$publikasi) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Publikasi tidak ditemukan'
            ]);
        }

        // Cek hak akses (hanya pembuat atau admin yang bisa hapus)
        if (session()->get('role') !== 'admin' && $publikasi['created_by'] != session()->get('id')) {
            return $this->response->setStatusCode(403)->setJSON([
                'status' => 'error',
                'message' => 'Anda tidak memiliki izin untuk menghapus publikasi ini'
            ]);
        }

        // Hapus file
        if ($publikasi['file_path'] && file_exists(WRITEPATH . 'uploads/publikasi/' . $publikasi['file_path'])) {
            unlink(WRITEPATH . 'uploads/publikasi/' . $publikasi['file_path']);
        }

        // Hapus dari database
        if ($this->publikasiModel->deletePublikasiWithPenulis($id)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Publikasi berhasil dihapus'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Gagal menghapus publikasi'
        ]);
    }

    public function getPenulis($publikasiId)
    {
        $penulis = $this->publikasiModel->getPenulisByPublikasi($publikasiId);
        return $this->response->setJSON($penulis);
    }

    public function download($id)
    {
        $publikasi = $this->publikasiModel->find($id);

        if (!$publikasi) {
            return redirect()->back()->with('error', 'Publikasi tidak ditemukan');
        }

        // Cek apakah user adalah penulis atau admin
        $userId = session()->get('id');
        $isPenulis = $this->publikasiModel->isUserPenulis($id, $userId);
        $isAdmin = session()->get('role') === 'admin';

        if (!$isPenulis && !$isAdmin && $publikasi['created_by'] != $userId) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke file ini');
        }

        $filePath = WRITEPATH . 'uploads/publikasi/' . $publikasi['file_path'];

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        // Dapatkan ekstensi file asli
        $ext = pathinfo($publikasi['file_path'], PATHINFO_EXTENSION);

        // Generate nama file untuk download: judulpublikasi_tanggaldibuat.ext
        $judulSlug = url_title($publikasi['judul'], '_', true);
        $tanggal = date('Ymd', strtotime($publikasi['created_at']));
        $downloadName = $judulSlug . '_' . $tanggal . '.' . $ext;

        return $this->response->download($filePath, null)->setFileName($downloadName);
    }

    public function preview($id)
    {
        $publikasi = $this->publikasiModel->find($id);

        if (!$publikasi) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'Publikasi tidak ditemukan'
            ]);
        }

        // Cek hak akses
        $userId = session()->get('id');
        $isPenulis = $this->publikasiModel->isUserPenulis($id, $userId);
        $isAdmin = session()->get('role') === 'admin';

        if (!$isPenulis && !$isAdmin && $publikasi['created_by'] != $userId) {
            return $this->response->setStatusCode(403)->setJSON([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses ke file ini'
            ]);
        }

        $filePath = WRITEPATH . 'uploads/publikasi/' . $publikasi['file_path'];
        $fileExt = strtolower(pathinfo($publikasi['file_path'], PATHINFO_EXTENSION));

        if (!file_exists($filePath)) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 'error',
                'message' => 'File tidak ditemukan'
            ]);
        }

        // Untuk PDF, kembalikan sebagai base64 encoded
        if ($fileExt === 'pdf') {
            $fileContent = file_get_contents($filePath);
            return $this->response->setJSON([
                'status' => 'success',
                'type' => 'pdf',
                'data' => base64_encode($fileContent),
                'filename' => $publikasi['file_path']
            ]);
        }

        // Untuk Word, kembalikan informasi file
        if (in_array($fileExt, ['doc', 'docx'])) {
            return $this->response->setJSON([
                'status' => 'success',
                'type' => 'word',
                'filename' => $publikasi['file_path'],
                'size' => filesize($filePath)
            ]);
        }

        return $this->response->setStatusCode(400)->setJSON([
            'status' => 'error',
            'message' => 'Format file tidak didukung'
        ]);
    }

    public function export()
    {
        // Load data publikasi
        $userId = session()->get('id');
        $role = session()->get('role');

        if ($role === 'admin') {
            $publikasi = $this->publikasiModel->getAllPublikasiWithPenulis();
        } else {
            $publikasi = $this->publikasiModel->getPublikasiByDosen($userId);
        }

        // Buat spreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Judul Publikasi');
        $sheet->setCellValue('C1', 'Penulis');
        $sheet->setCellValue('D1', 'Tanggal Terbit');
        $sheet->setCellValue('E1', 'Kategori');
        $sheet->setCellValue('F1', 'Jenis');
        $sheet->setCellValue('G1', 'Penerbit');
        $sheet->setCellValue('H1', 'Jumlah Halaman');
        $sheet->setCellValue('I1', 'ISBN');

        // Style header
        $headerStyle = [
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD9D9D9']]
        ];
        $sheet->getStyle('A1:I1')->applyFromArray($headerStyle);

        // Isi data
        $row = 2;
        foreach ($publikasi as $index => $pub) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $pub['judul']);
            $sheet->setCellValue('C' . $row, $pub['penulis']);

            // Format tanggal
            $tanggal = date('d M Y', strtotime($pub['tanggal_terbit']));
            $sheet->setCellValue('D' . $row, $tanggal);

            // Kategori dan jenis
            $kategori = $pub['kategori'] === 'karya-ilmiah' ? 'Publikasi Karya Ilmiah' : 'Publikasi Buku Ilmiah';
            $jenis = $pub['jenis'] === 'artikel' ? 'Artikel' : ($pub['jenis'] === 'buku' ? 'Buku' : 'Majalah');

            $sheet->setCellValue('E' . $row, $kategori);
            $sheet->setCellValue('F' . $row, $jenis);
            $sheet->setCellValue('G' . $row, $pub['penerbit']);
            $sheet->setCellValue('H' . $row, $pub['jumlah_halaman']);
            $sheet->setCellValue('I' . $row, $pub['isbn'] ?? '-');

            $row++;
        }

        // Auto size columns
        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Border untuk data
        $dataStyle = [
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP]
        ];
        $sheet->getStyle('A2:I' . ($row - 1))->applyFromArray($dataStyle);

        // Buat nama file
        $currentDate = date('Y-m-d');
        $filename = "Data_Publikasi_{$currentDate}.xlsx";

        // Download file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
}
