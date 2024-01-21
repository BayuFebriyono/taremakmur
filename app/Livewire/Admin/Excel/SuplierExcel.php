<?php

namespace App\Livewire\Admin\Excel;

use App\Models\Suplier;
use Livewire\Component;
use Livewire\WithFileUploads;

class SuplierExcel extends Component
{
use WithFileUploads;
    public $excel;

    public function render()
    {
        return view('livewire.admin.excel.suplier-excel');
    }

    public function cancelExcel($message = '')
    {
        $this->dispatch('cancelExcelSuplier', message:$message);
    }

    public function store()
    {
        $this->validate([
            'excel' => 'required'
        ]);

        $fileExstension = $this->excel->getClientOriginalExtension();
        $allowedExt = ['xls', 'csv', 'xlsx'];

        if(in_array($fileExstension, $allowedExt)){
            $path = $this->excel->storeAs('temp', 'uploaded_file.xlsx', 'local');
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path("app/{$path}"));

            $data = $spreadsheet->getActiveSheet()->removeRow(1,4)->toArray();
            foreach($data as $row){
                Suplier::create([
                    'nama' => $row[0],
                    'nama_barang' => $row[1],
                    'suplier' => $row[2],
                    'satuan' => $row[3],
                    'unit' => $row[4]
                ]);
            }

            $this->cancelExcel('Data berhasil diimport');
        }else{
            $this->cancelExcel('Format file tidak didukung');
        }
    }
}
