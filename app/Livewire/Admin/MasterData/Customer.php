<?php

namespace App\Livewire\Admin\MasterData;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Customer as ModelsCustomer;

#[Layout('components.layouts.sidebar')]
#[Title('Master Data Customer')]
class Customer extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $dataExcel;

    public $active = 'customer';
    public $search = '';
    public $modalStatus = '';
    public $customerId = null;

    public $nama = '';
    public $alamat = '';
    public $password = '';
    public $excel = false;

    public function render()
    {
        $customers = ModelsCustomer::where('nama', 'like', '%' . $this->search . '%')
            ->orWhere('alamat', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage);
        $this->dataExcel = $customers->items();

        return view('livewire.admin.master-data.customer', [
            'customers' => $customers
        ]);
    }

    public function store()
    {
        $this->validate([
            'nama' => 'required',
            'alamat' => 'required'
        ]);

        ModelsCustomer::create([
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'password' => bcrypt($this->password)
        ]);

        session()->flash('success', 'Data berhasil ditambahkan');
        $this->resetFields();
    }

    public function delete($id)
    {
        ModelsCustomer::destroy($id);
        session()->flash('success', 'Data telah dihapus');
    }

    public function addData()
    {
        $this->modalStatus = 'add';
    }

    public function edit($id)
    {
        $data = ModelsCustomer::find($id);
        $this->nama = $data->nama;
        $this->alamat = $data->alamat;
        $this->customerId = $data->id;
        $this->modalStatus = 'edit';
    }

    public function update()
    {
        $data = [
            'nama' => $this->nama,
            'alamat' => $this->alamat,
        ];
        if($this->password) $data['password'] = bcrypt($this->password);
        ModelsCustomer::find($this->customerId)
            ->update($data);

        session()->flash('success', 'Data berhasil diubah');
        $this->resetFields();
    }

    public function resetFields()
    {


        $this->nama = '';
        $this->alamat = '';
        $this->modalStatus = '';
        $this->password = '';
        $this->customerId = null;
    }



    public function importExcel()
    {
        $this->excel = true;
    }

    #[On('cancelExcelCustomer')]
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
        $sheet->setCellValue('B3', 'ALAMAT');

        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);

        $row = 4;
        foreach ($this->dataExcel as $data) {
            $sheet->setCellValue('A' . $row, $data->nama);
            $sheet->setCellValue('B' . $row, $data->alamat);

            $sheet->getStyle('A' . $row)->applyFromArray($style_row);
            $sheet->getStyle('B' . $row)->applyFromArray($style_row);

            $row++;
        }

        $sheet->setTitle("Export Customer");
        $fileName = "Export_Customer.xlsx";

        $path = public_path($fileName);
        $writer = new Xlsx($spreadsheet);
        $writer->save($path);

        // Download Excel file using Livewire's download method
        return response()->streamDownload(function () use ($path) {
            echo file_get_contents($path);
        }, $fileName);
    }
}
