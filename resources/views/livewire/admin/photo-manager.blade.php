<div>
    <section class="content-header">
        <div class="container-fluid">
            <h1>Kelola Foto User</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session('message') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Semua Foto Masuk</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th>Foto</th>
                                <th>Judul & Info</th>
                                <th>Pengupload</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($photos as $index => $photo)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $photo->image_url) }}" 
                                         style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd;">
                                </td>
                                <td>
                                    <b>{{ $photo->title }}</b><br>
                                    <small class="text-muted">
                                        Kategori: {{ $photo->category->name ?? '-' }}
                                    </small><br>
                                    <small class="text-muted">
                                        <i>"{{ Str::limit($photo->caption, 30) }}"</i>
                                    </small>
                                </td>
                                <td>
                                    {{ $photo->user->name }}<br>
                                    <small>{{ $photo->created_at->diffForHumans() }}</small>
                                </td>
                                <td>
                                    <button wire:confirm="Yakin mau hapus foto ini? Gambar akan hilang selamanya." 
                                            wire:click="delete({{ $photo->id }})" 
                                            class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                            @endforeach

                            @if($photos->count() == 0)
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
                                    Belum ada foto yang diupload user.
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>