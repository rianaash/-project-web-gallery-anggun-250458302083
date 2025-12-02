<div>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Laporan Masuk 🚩</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card card-danger card-outline">
                <div class="card-header">
                    <h3 class="card-title">Daftar Laporan Pelanggaran</h3>
                </div>
                
                <div class="card-body p-0 table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pelapor</th>
                                <th width="15%">Foto</th>
                                <th>Alasan Laporan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reports as $index => $report)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span class="font-weight-bold">{{ $report->reporter->name ?? 'User Terhapus' }}</span>
                                        <br>
                                        <small class="text-muted">{{ $report->reporter->email ?? '-' }}</small>
                                    </td>
                                    <td>
                                        @if($report->photo)
                                            <a href="{{ asset('storage/' . $report->photo->image_url) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $report->photo->image_url) }}" class="img-thumbnail" style="height: 80px;">
                                            </a>
                                        @else
                                            <span class="badge badge-secondary">Foto Terhapus</span>
                                        @endif
                                    </td>
                                    <td>{{ $report->reason }}</td>
                                    <td>
                                        @if($report->status == 'pending')
                                            <span class="badge badge-warning">Menunggu</span>
                                        @elseif($report->status == 'resolved')
                                            <span class="badge badge-success">Disetujui (Foto Dihapus)</span>
                                        @else
                                            <span class="badge badge-secondary">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>{{ $report->created_at->format('d M Y') }}</td>
                                    <td class="text-center">
                                        @if($report->status == 'pending')
                                            <button wire:click="deletePhoto({{ $report->id }})" 
                                                    onclick="confirm('Yakin foto ini melanggar? Foto akan dihapus permanen.') || event.stopImmediatePropagation()"
                                                    class="btn btn-danger btn-sm" title="Hapus Foto & Terima Laporan">
                                                <i class="fas fa-trash"></i> Hapus Foto
                                            </button>
                                            
                                            <button wire:click="dismissReport({{ $report->id }})" 
                                                    class="btn btn-secondary btn-sm" title="Tolak Laporan">
                                                <i class="fas fa-times"></i> Abaikan
                                            </button>
                                        @else
                                            <span class="text-muted text-sm">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">
                                        <i class="fas fa-check-circle fa-3x mb-3 text-success"></i><br>
                                        Tidak ada laporan baru. Aman!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>