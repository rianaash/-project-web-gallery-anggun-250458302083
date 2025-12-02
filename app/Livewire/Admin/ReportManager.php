<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Report;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]
class ReportManager extends Component
{
    public function render()
    {
        // Ambil semua laporan, urutkan yang terbaru di atas
        $reports = Report::with(['reporter', 'photo'])->latest()->get();

        return view('livewire.admin.report-manager', [
            'reports' => $reports
        ]);
    }

    // 1. Fungsi HAPUS FOTO (Terima Laporan)
    public function deletePhoto($reportId)
    {
        $report = Report::find($reportId);

        if ($report && $report->photo) {
            // Hapus File Fisik di Storage
            if (Storage::disk('public')->exists($report->photo->image_url)) {
                Storage::disk('public')->delete($report->photo->image_url);
            }

            // Hapus Data Foto di Database
            $report->photo->delete();

            // Update status laporan jadi 'resolved' (selesai)
            $report->update(['status' => 'resolved']);

            session()->flash('message', 'Foto berhasil dihapus dan laporan ditutup.');
        } else {
            session()->flash('error', 'Foto sudah tidak ada.');
        }
    }

    // 2. Fungsi ABAIKAN (Tolak Laporan)
    public function dismissReport($reportId)
    {
        $report = Report::find($reportId);
        
        if ($report) {
            // Cuma update status jadi 'dismissed', foto JANGAN dihapus
            $report->update(['status' => 'dismissed']);
            
            session()->flash('message', 'Laporan diabaikan. Foto tetap aman.');
        }
    }
}