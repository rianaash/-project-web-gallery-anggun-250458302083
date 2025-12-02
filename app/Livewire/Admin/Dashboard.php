<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Photo;
use App\Models\Category;
use App\Models\Report;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public function render()
    {
        // === 1. Statistik Atas ===
        $totalUser   = User::count();
        $totalPhoto  = Photo::count();
        $totalReport = Report::where('status', 'pending')->count();

        // === 2. Grafik Foto per Kategori ===
        $categories  = Category::withCount('photos')->get();
        $chartLabels = $categories->pluck('name');
        $chartData   = $categories->pluck('photos_count');

        // === 3. Grafik Pengguna per Bulan ===
        // Ambil bulan & total user baru secara berurutan (Jan - Des)
        $userGrowth = User::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Buat label bulan (Jan, Feb, dst)
        $monthLabels = $userGrowth->map(function ($row) {
            return date('F', mktime(0, 0, 0, $row->month, 1)); // Convert angka ke nama bulan
        });

        // Total user per bulan
        $usersByMonth = $userGrowth->pluck('total');

        return view('livewire.admin.dashboard', [
            // Card
            'totalUser'     => $totalUser,
            'totalPhoto'    => $totalPhoto,
            'totalReport'   => $totalReport,

            // Chart Foto
            'chartLabels'   => $chartLabels,
            'chartData'     => $chartData,

            // Chart Pengguna
            'monthLabels'   => $monthLabels,
            'usersByMonth'  => $usersByMonth,
        ]);
    }
}
