<div>
    <div class="card mt-4">
        <div class="card-body">
            <form wire:submit='store'>
                <p>Download Format berikut untuk import data <a
                        href="{{ asset('excel/import-barang.xlsx') }}">Download</a></p>


                <label for="Excel" class="form-label mt-3">Upload file anda</label>
                <input wire:model='excel' type="file" class="form-control my-3">
                <button wire:loading.attr='disabled' wire:target='store' type="submit" class="btn btn-primary"><span wire:target='store' wire:loading class="spinner-grow spinner-grow-sm"></span>Import</button>
                <button wire:click='cancelExcel' type="button" class="btn btn-secondary">Cancel</button>
            </form>
        </div>
    </div>
</div>
