<?php

namespace App\Controllers;

use App\Models\PublikasiModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Publikasi extends BaseController
{
    public function export()
    {
        // Ambil data publikasi dari database
        $publikasiModel = new PublikasiModel();
        $data = $publikasiModel->findAll();

        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Judul');
        $sheet->setCellValue('C1', 'Penulis');
        $sheet->setCellValue('D1', 'Tanggal Terbit');
        $sheet->setCellValue('E1', 'Kategori');
        $sheet->setCellValue('F1', 'Jenis');
        $sheet->setCellValue('G1', 'Penerbit');
        $sheet->setCellValue('H1', 'Jumlah Halaman');
        $sheet->setCellValue('I1', 'ISBN');

        // Isi data
        $row = 2;
        foreach ($data as $i => $pub) {
            // Ambil nama penulis (jika relasi, sesuaikan)
            $penulis = isset($pub['penulis']) ? $pub['penulis'] : '-';
            if (method_exists($publikasiModel, 'getPenulisNames')) {
                $penulis = $publikasiModel->getPenulisNames($pub['id']);
            }

            $sheet->setCellValue('A' . $row, $i + 1);
            $sheet->setCellValue('B' . $row, $pub['judul']);
            $sheet->setCellValue('C' . $row, $penulis);
            $sheet->setCellValue('D' . $row, $pub['tanggal_terbit']);
            $sheet->setCellValue('E' . $row, $pub['kategori']);
            $sheet->setCellValue('F' . $row, $pub['jenis']);
            $sheet->setCellValue('G' . $row, $pub['penerbit']);
            $sheet->setCellValue('H' . $row, $pub['jumlah_halaman']);
            $sheet->setCellValue('I' . $row, $pub['isbn']);
            $row++;
        }

        // Set header untuk download
        $filename = 'daftar_publikasi_' . date('Ymd_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}