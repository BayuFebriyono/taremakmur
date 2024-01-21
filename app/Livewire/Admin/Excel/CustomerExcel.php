<?php

namespace App\Livewire\Admin\Excel;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithFileUploads;

class CustomerExcel extends Component
{
    use WithFileUploads;

    public $excel;

    public function render()
    {
        return view('livewire.admin.excel.customer-excel');
    }

    public function cancelExcel($message='')
    {
        $this->dispatch('cancelExcelCustomer', message:$message);
    }

    public function store()
    {
        $this->validate([
            'excel' => 'required'
        ]);

        $fileName = $this->excel->getClientOriginalName();
        $fileExstension = $this->excel->getClientOriginalExtension();

        $allowedExt = ['xls', 'csv', 'xlsx'];

        if (in_array($fileExstension, $allowedExt)) {
            $inputFileNamePath = $this->excel->getPathname();
            $path = $this->excel->storeAs('temp', 'uploaded_file.xlsx', 'local');
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path("app/{$path}"));

            $data = $spreadsheet->getActiveSheet()->removeRow(1, 4)->toArray();
            foreach ($data as $row) {
                Customer::create([
                    'nama' => $row[0],
                    'alamat' => $row[1]
                ]);
            }

          
            $this->cancelExcel('Data berhasil diimport');
        } else {
           
            $this->cancelExcel('Format File tidak didukung');
        }
    }
}
