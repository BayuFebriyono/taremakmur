<?php

namespace App\Livewire\Admin\MasterData;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use App\Models\Barang as ModelsBarang;
use App\Models\Suplier as ModelsSuplier;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

#[Layout('components.layouts.sidebar')]
#[Title('Master Data Barang')]
class Barang extends Component
{
    use WithPagination;


    public $supliers;
    public $searchSuplier = '';
    public $perPage;
    public $jumlahData;
    public $dataExcel;

    // Properti Model
    public $kodeBarang;
    public $namaBarang;
    public $suplierId;
    public $hargaBeliDus = 0;
    public $hargaBeliPack = 0;
    public $cashDus = 0;
    public $cashPack = 0;
    public $diskon = 0;
    public $kreditDus = 0;
    public $kreditPack = 0;
    public $jumlahRenteng = '';
    public $jenis = '';

    // utils property
    public $statusModal = '';
    public $barangId = null;
    public $search = '';
    public $excel = false;

    public function mount()
    {
        $this->supliers = ModelsSuplier::all();
        $this->kodeBarang = uniqid();
        $this->jumlahData = ModelsBarang::all()->count();
        $this->perPage = 10;
    }

    public function updateSelectedSuplier()
    {
        $this->supliers = ModelsSuplier::where('nama', 'like', '%' . $this->searchSuplier . '%')->get();
    }

    public function addData()
    {
        $this->statusModal = 'add';
    }

    public function edit($id)
    {
        $this->statusModal = 'edit';
        $barang = ModelsBarang::find($id);
        $this->kodeBarang = $barang->kode_barang;

        $this->namaBarang = $barang->nama_barang;
        $this->suplierId = $barang->suplier_id;
        $this->hargaBeliDus = $barang->kredit_dus;
        $this->hargaBeliPack = $barang->kredit_pack;
        $this->cashDus = $barang->cash_dus;
        $this->cashPack = $barang->cash_pack;
        $this->kreditDus = $barang->kredit_dus;
        $this->kreditPack = $barang->kredit_pack;
        $this->diskon = $barang->diskon;
        $this->barangId = $barang->id;
        $this->jumlahRenteng = $barang->jumlah_renteng;
        $this->jenis = $barang->jenis;
    }

    public function update()
    {
        $this->validate([
            'suplierId' => 'required',
            'kodeBarang' => ['required', Rule::unique('barangs', 'kode_barang')->where(function ($q) {
                return $q->where('kode_barang', '!=', $this->kodeBarang);
            })],
            'namaBarang' => 'required'
        ]);

        ModelsBarang::find($this->barangId)->update([
            'suplier_id' => $this->suplierId,
            'kode_barang' => $this->kodeBarang,
            'nama_barang' => $this->namaBarang,
            'harga_beli_dus' => $this->hargaBeliDus,
            'harga_beli_pack' => $this->hargaBeliPack,
            'cash_dus' => $this->cashDus,
            'cash_pack' => $this->cashPack,
            'kredit_dus' => $this->kreditDus,
            'kredit_pack' => $this->kreditPack,
            'diskon' => $this->diskon,
            'jumlah_renteng' => $this->jumlahRenteng,
            'jenis' => $this->jenis
        ]);
        $this->cancel();
        session()->flash('success', 'Data telah diubah');
    }

    public function store()
    {
        $this->validate([
            'suplierId' => 'required',
            'kodeBarang' => 'required|unique:barangs,kode_barang',
            'namaBarang' => 'required'
        ]);

        ModelsBarang::create([
            'suplier_id' => $this->suplierId,
            'kode_barang' => $this->kodeBarang,
            'nama_barang' => $this->namaBarang,
            'harga_beli_dus' => $this->hargaBeliDus,
            'harga_beli_pack' => $this->hargaBeliPack,
            'cash_dus' => $this->cashDus,
            'cash_pack' => $this->cashPack,
            'kredit_dus' => $this->kreditDus,
            'kredit_pack' => $this->kreditPack,
            'diskon' => $this->diskon,
            'jumlah_renteng' => $this->jumlahRenteng,
            'jenis' => $this->jenis
        ]);

        $this->cancel();
        session()->flash('success', 'Data telah ditambahkan');
    }

    public function delete($id)
    {
        ModelsBarang::find($id)->delete();
        session()->flash('success', 'Data berhasil dihapus');
    }

    public function render()
    {
        $barangs = ModelsBarang::where('nama_barang', 'like', '%' . $this->search . '%')
            ->with('suplier')
            ->paginate($this->perPage);
        $this->dataExcel = $barangs->items();
        return view('livewire.admin.master-data.barang', [
            'barangs' => $barangs,
        ]);
    }

    public function aktif($id)
    {
        ModelsBarang::find($id)->update(['aktif' => true]);
    }

    public function nonAktif($id)
    {
        ModelsBarang::find($id)->update(['aktif' => false]);
    }

    public function cancel()
    {
        $this->kodeBarang;
        $this->namaBarang;
        $this->suplierId;
        $this->hargaBeliDus = 0;
        $this->hargaBeliPack = 0;
        $this->cashDus = 0;
        $this->cashPack = 0;
        $this->diskon = 0;
        $this->statusModal = '';
        $this->jumlahRenteng = '';
        $this->barangId = null;
        $this->jenis = '';
    }

    public function importExcel()
    {
        $this->excel = true;
    }

    #[On('cancelExcelBarang')]
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

        $sheet->setCellValue('A3', 'SUPLIER');
        $sheet->setCellValue('B3', 'KODE BARANG');
        $sheet->setCellValue('C3', 'NAMA BARANG');
        $sheet->setCellValue('D3', 'MIN PACK');
        $sheet->setCellValue('E3', 'CASH DUS');
        $sheet->setCellValue('F3', 'CASH PACK');
        $sheet->setCellValue('G3', 'KREDIT DUS');
        $sheet->setCellValue('H3', 'KREDIT PACK');
        $sheet->setCellValue('I3', 'DISKON');
        $sheet->setCellValue('J3', 'HARGA BELI DUS');
        $sheet->setCellValue('K3', 'HARGA BELI PACK');

        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);
        $sheet->getStyle('H3')->applyFromArray($style_col);
        $sheet->getStyle('I3')->applyFromArray($style_col);
        $sheet->getStyle('J3')->applyFromArray($style_col);
        $sheet->getStyle('K3')->applyFromArray($style_col);


        $row = 4;
        foreach ($this->dataExcel as $data) {
            $sheet->setCellValue("A{$row}", $data->suplier->nama);
            $sheet->setCellValue("B{$row}", $data->kode_barang);
            $sheet->setCellValue("C{$row}", $data->nama_barang);
            $sheet->setCellValue("D{$row}", $data->jumlah_renteng);
            $sheet->setCellValue("E{$row}", $data->cash_dus);
            $sheet->setCellValue("F{$row}", $data->cash_pack);
            $sheet->setCellValue("G{$row}", $data->kredit_dus);
            $sheet->setCellValue("H{$row}", $data->kredit_pack);
            $sheet->setCellValue("I{$row}", $data->diskon);
            $sheet->setCellValue("J{$row}", $data->harga_beli_dus);
            $sheet->setCellValue("K{$row}", $data->harga_beli_pack);

            $sheet->getStyle("A{$row}")->applyFromArray($style_row);
            $sheet->getStyle("B{$row}")->applyFromArray($style_row);
            $sheet->getStyle("C{$row}")->applyFromArray($style_row);
            $sheet->getStyle("D{$row}")->applyFromArray($style_row);
            $sheet->getStyle("E{$row}")->applyFromArray($style_row);
            $sheet->getStyle("F{$row}")->applyFromArray($style_row);
            $sheet->getStyle("G{$row}")->applyFromArray($style_row);
            $sheet->getStyle("H{$row}")->applyFromArray($style_row);
            $sheet->getStyle("I{$row}")->applyFromArray($style_row);
            $sheet->getStyle("J{$row}")->applyFromArray($style_row);
            $sheet->getStyle("K{$row}")->applyFromArray($style_row);
            $row++;
        }

        $sheet->setTitle("Export Barang");
        $fileName = "Export_Barang.xlsx";

        $path = public_path($fileName);
        $writer = new Xlsx($spreadsheet);
        $writer->save($path);

        return response()->streamDownload(function () use ($path) {
            echo file_get_contents($path);
        }, $fileName);
    }
}
