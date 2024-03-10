<?php

namespace App\Livewire\Report;

use Carbon\Carbon;
use App\Models\Barang;
use App\Models\Report;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

#[Layout('components.layouts.sidebar')]
#[Title('Report Qty')]

class ReportQty extends Component
{
    use WithFileUploads;

    public $jenis = 'all';
    public $dari;
    public $sampai;
    public $report = [];
    public $excel;

    public function mount()
    {
        $this->dari = now()->format('m/d/Y');
        $this->sampai = now();
    }
    public function render()
    {
        return view('livewire.report.report-qty');
    }

    public function cari()
    {
        $dari = Carbon::parse($this->dari)->subDays(1)->isoFormat('Y-M-D');
        $sampai = Carbon::parse($this->sampai)->addDays(1)->isoFormat('Y-M-D');

        $barangs = Barang::all();
        $report = collect();
        foreach ($barangs as $barang) {
            $report->push([
                'id' => uniqid(),
                'kode_barang' => $barang->kode_barang,
                'stock' => $barang->stock_sto,
                'in' => DB::table('reports')
                    ->where('kode_barang', $barang->kode_barang)
                    ->whereBetween('created_at', [$dari, $sampai])
                    ->sum('in'),
                'out' =>  DB::table('reports')
                    ->where('kode_barang', $barang->kode_barang)
                    ->whereBetween('created_at', [$dari, $sampai])
                    ->sum('out'),
                'harga_beli' =>  DB::table('reports')
                    ->where('kode_barang', $barang->kode_barang)
                    ->whereBetween('created_at', [$dari, $sampai])
                    ->sum('harga_beli'),
                'harga' =>  DB::table('reports')
                    ->where('kode_barang', $barang->kode_barang)
                    ->whereBetween('created_at', [$dari, $sampai])
                    ->sum('harga'),
                'stock_barang' => $barang->stock_renteng,
            ]);
        }
        $this->report = $report;
    }

    public function importSto()
    {
        $this->validate([
            'excel' => 'required'
        ]);

        $fileExstension = $this->excel->getClientOriginalExtension();
        $allowedExt = ['xls', 'csv', 'xlsx'];

        if (in_array($fileExstension, $allowedExt)) {
            $path = $this->excel->storeAs('temp', 'uploaded_file.xlsx', 'local');
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path("app/{$path}"));

            $data = $spreadsheet->getActiveSheet()->removeRow(1, 4)->toArray();
            foreach ($data as $row) {
                Barang::where('kode_barang', $row[0])
                    ->update([
                        'stock_sto' => $row[1],
                        'stock_renteng' => $row[1],
                        'stock_bayangan' => $row[1],
                    ]);
            }

            session()->flash('success', "Berhasil STO");
        } else {
            session()->flash('error', 'format file tidak didukung');
        }
    }

    public function exportExcel()
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];

        $sheet->setCellValue('A3', 'Kode Barang');
        $sheet->setCellValue('B3', 'Stok');
        $sheet->setCellValue('C3', 'IN');
        $sheet->setCellValue('D3', 'OUT');
        $sheet->setCellValue('E3', 'Harga');
        $sheet->setCellValue('F3', 'Harga Beli');

        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);

        $row = 4;
        foreach ($this->report as $data) {
            $sheet->setCellValue('A' . $row, $data['kode_barang']);
            $sheet->setCellValue('B' . $row, $data['stock']);
            $sheet->setCellValue('C' . $row, $data['in'] ?? '-');
            $sheet->setCellValue('D' . $row, $data['out'] ?? '-');
            $sheet->setCellValue('E' . $row, $data['harga']);
            $sheet->setCellValue('F' . $row, $data['harga_beli']);

            $sheet->getStyle('A' . $row)->applyFromArray($style_row);
            $sheet->getStyle('B' . $row)->applyFromArray($style_row);
            $sheet->getStyle('C' . $row)->applyFromArray($style_row);
            $sheet->getStyle('D' . $row)->applyFromArray($style_row);
            $sheet->getStyle('E' . $row)->applyFromArray($style_row);
            $sheet->getStyle('F' . $row)->applyFromArray($style_row);

            $row++;
        }

        $sheet->setTitle("Export Report");
        $fileName = "Export_Report.xlsx";

        $path = public_path($fileName);
        $writer = new Xlsx($spreadsheet);
        $writer->save($path);

        // Download Excel file using Livewire's download method
        return response()->streamDownload(function () use ($path) {
            echo file_get_contents($path);
        }, $fileName);
    }
}
