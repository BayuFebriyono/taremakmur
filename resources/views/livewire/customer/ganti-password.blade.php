<div>
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session('success'))
        <div class="alert alert-primary alert-dismissible fade show mt-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <p class="fw-bold">Ganti password anda!</p>

            <form wire:submit='gantiPassword'>
                <div class="mt-3">
                    <label for="PasswordLama" class="form-label">Password Lama</label>
                    <input wire:model='passwordLama' type="password" class="form-control" required>
                </div>

                <div class="mt-3">
                    <label for="PasswordBaru" class="form-label">Password Baru</label>
                    <input wire:model='passwordBaru' type="password" class="form-control" required>
                </div>

                <button class="btn btn-primary mt-4" type="submit">Simpan</button>
            </form>
        </div>
    </div>
</div>
