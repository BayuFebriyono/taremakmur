<?php

namespace App\Livewire\Admin\Transaksi\Penjualan;

use App\Models\Barang;
use App\Models\Penjualan;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;


class ExcelAdd extends Component
{
    use WithFileUploads;
    public $excel;
    public function render()
    {
        return view('livewire.admin.transaksi.penjualan.excel-add');
    }

    public function store()
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
            DB::beginTransaction();
            try {
                foreach ($data as $row) {
                    $barang = Barang::where('kode_barang', $row[1])->first();
                    if (!$barang) throw new Exception("Kode Barang {$row[1]} tidak ditemukan");
                    if ($barang->balance < $row[2]) throw new Exception("Stok Barang {$row[1]} kurang");
                    Penjualan::create([
                        'no_nota' => $row[0],
                        'kode_barang' => $row[1],
                        'qty' => $row[2],
                        'aktual' => $row[2],
                        'harga' => $row[3],
                        'diskon' => $row[4],
                        'toko' => $row[5]
                    ]);
                }
                DB::commit();
                $this->cancelExcel(message: 'Data berhasil diimport', type: 'success');
            } catch (Exception $e) {
                DB::rollBack();
                $this->cancelExcel(message: $e->getMessage(), type: 'error');
            }
        } else {
            $this->cancelExcel(message: 'file tidak didukung', type: 'error');
        }
    }

    public function cancelExcel($message = '', $type = 'success')
    {
        $this->dispatch('cancel-excel', message: $message, type: $type)->to(AddPenjualan::class);
    }
}
