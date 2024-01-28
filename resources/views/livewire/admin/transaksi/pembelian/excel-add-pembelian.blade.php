<div>
   <div class="card my-3">
    <div class="card-body">
        <p>Untuk format import silahkan <a href="{{ asset('excel/import-pembelian.xlsx') }}">Download</a></p>
        <form>
                <div class="my-2">            
                    <label for="Excel" class="form-label">Upload File</label>
                    <input type="file" class="form-control">
                </div> 
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button wire:click='cancelExcel' type="button" class="btn btn-secondary">Cancel</button>
                </div>
        </form>
    </div>
   </div>
</div>
