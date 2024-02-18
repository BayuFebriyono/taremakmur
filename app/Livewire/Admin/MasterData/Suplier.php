<?php

namespace App\Livewire\Admin\MasterData;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Models\Suplier as ModelsSuplier;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

#[Layout('components.layouts.sidebar')]
#[Title('Master Data Suplier')]
class Suplier extends Component
{
    use WithPagination;
    public $search = '';
    public $dataExcel;
    public $perPage = 10;
    public $jumlahData;

    public $modalStatus = '';
    public $nama = '';
    public $nama_barang = '';
    public $suplier = '';
    public $satuan = '';
    public $unit = 0;
    public $suplierId = null;

    public $excel = false;

    public function mount()
    {
        $this->jumlahData = ModelsSuplier::all()->count();
    }

    public function render()
    {
        $supliers = ModelsSuplier::where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('nama_barang', 'like', '%' . $this->search . '%')
            ->orWhere('suplier', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage);
        $this->dataExcel = $supliers->items();

        return view('livewire.admin.master-data.suplier', [
            'supliers' => $supliers
        ]);
    }

    public function store()
    {
        $this->validate([
            'nama' => 'required',
            'nama_barang' => 'required',
            'suplier' => 'required',
            'satuan' => 'required',
            'unit' => 'required|numeric'
        ]);

        ModelsSuplier::create([
            'nama' => $this->nama,
            'nama_barang' => $this->nama_barang,
            'suplier' => $this->suplier,
            'satuan' => $this->satuan,
            'unit' => $this->unit
        ]);

        session()->flash('success', 'Data berhasil ditambahkan');
        $this->resetFields();
    }

    public function delete($id)
    {
        ModelsSuplier::find($id)->delete();
        session()->flash('success', 'Data telah dihapus');
    }

    public function edit($id)
    {
        $data = ModelsSuplier::find($id);
        $this->nama = $data->nama;
        $this->nama_barang = $data->nama_barang;
        $this->suplier = $data->suplier;
        $this->satuan = $data->satuan;
        $this->unit = $data->unit;
        $this->suplierId = $data->id;

        $this->modalStatus = 'edit';
    }

    public function update()
    {
        ModelsSuplier::find($this->suplierId)
            ->update([
                'nama' => $this->nama,
                'nama_barang' => $this->nama_barang,
                'suplier' => $this->suplier,
                'satuan' => $this->satuan,
                'unit' => $this->unit
            ]);

        session()->flash('success', 'Data berhasil di update');
        $this->resetFields();
    }

    public function addData()
    {
        $this->modalStatus = 'add';
    }

    public function resetFields()
    {
        $this->modalStatus = '';
        $this->nama = '';
        $this->nama_barang = '';
        $this->suplier = '';
        $this->satuan = '';
        $this->unit = 0;
        $this->suplierId = null;
    }

    public function importExcel()
    {
        $this->excel = true;
    }

    #[On('cancelExcelSuplier')]
    public function cancelExcel($message = '')
    {
        $this->excel = false;
        if ($message) {
            session()->flash('success', $message);
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

        $sheet->setCellValue('A3', 'NAMA');
        $sheet->setCellValue('B3', 'NAMA BARANG');
        $sheet->setCellValue('C3', 'SUPLIER');
        $sheet->setCellValue('D3', 'SATUAN');
        $sheet->setCellValue('E3', 'UNIT');

        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);

        $row = 4;
        foreach ($this->dataExcel as $data) {
            $sheet->setCellValue("A{$row}", $data->nama);
            $sheet->setCellValue("B{$row}", $data->nama_barang);
            $sheet->setCellValue("C{$row}", $data->suplier);
            $sheet->setCellValue("D{$row}", $data->satuan);
            $sheet->setCellValue("E{$row}", $data->unit);

            $sheet->getStyle("A{$row}")->applyFromArray($style_row);
            $sheet->getStyle("B{$row}")->applyFromArray($style_row);
            $sheet->getStyle("C{$row}")->applyFromArray($style_row);
            $sheet->getStyle("D{$row}")->applyFromArray($style_row);
            $sheet->getStyle("E{$row}")->applyFromArray($style_row);
            $row++;
        }

        $sheet->setTitle("Export Suplier");
        $fileName = "Export_Suplier.xlsx";

        $path = public_path($fileName);
        $writer = new Xlsx($spreadsheet);
        $writer->save($path);

        return response()->streamDownload(function () use ($path) {
            echo file_get_contents($path);
        }, $fileName);
    }
}
