<div>
    <section class="content-header">
        <h1>Manajemen Kategori</h1>
    </section>

    <section class="content">
        <div class="container-fluid">
            
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <div class="row">
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ $isEditing ? 'Edit Kategori' : 'Tambah Baru' }}
                            </h3>
                        </div>
                        
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama Kategori</label>
                                <input type="text" wire:model="name" class="form-control" placeholder="Misal: Kucing">
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="card-footer">
                            @if($isEditing)
                                <button wire:click="update" class="btn btn-warning">Simpan Perubahan</button>
                                <button wire:click="cancel" class="btn btn-secondary">Batal</button>
                            @else
                                <button wire:click="store" class="btn btn-primary">Simpan</button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List Kategori</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $index => $cat)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $cat->name }}</td>
                                        <td>
                                            <button wire:click="edit({{ $cat->id }})" class="btn btn-sm btn-warning">
                                                <i class="fas fa-pencil-alt"></i>
                                            </button>
                                            
                                            <button wire:confirm="Serius mau di hapus?" wire:click="delete({{ $cat->id }})" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>