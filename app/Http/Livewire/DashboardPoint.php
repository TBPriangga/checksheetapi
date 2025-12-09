<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Laporan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;

class DashboardPoint extends Component
{
    public $timeStart, $timeEnd;
    public $timeStartPick, $timeEndPick;
    public $selectedOption = 1;
    public $chartData = [];
    public $totalReports = 0;
    public $topReporters = [];
    public $openReports = 0;
    public $closedReports = 0;

    protected $listeners = [
        'receiveOption' => 'receiveOption',
        'setTimeStart' => 'setTimeStart',
        'setTimeEnd' => 'setTimeEnd',
    ];

    public function userFilter($query)
    {
        $user = auth()->user();
        if (!$user) return $query;

        if ($user->hasRole('Departement Head EHS') || $user->hasRole('Departement Head PIC')) {
            return $query->whereNotNull('area_id');
        } elseif ($user->hasRole('PIC')) {
            return $query->where('PIC_id', $user->id);
        }
        return $query->whereNotNull('area_id');
    }

    public function mount()
    {
        $this->selectedOption = 1;
        $this->timeStart = Carbon::create(2025, 1, 1)->format('Y-m-d');
        $this->timeEnd = Carbon::today()->format('Y-m-d');
        $this->timeStartPick = Carbon::parse($this->timeStart)->format('d/m/Y');
        $this->timeEndPick = Carbon::parse($this->timeEnd)->format('d/m/Y');
        $this->updateData();
    }

    public function receiveOption($option)
    {
        $this->selectedOption = $option;
        
        if ($option == 1) {
            $this->timeStart = Carbon::create(2025, 1, 1)->format('Y-m-d');
            $this->timeEnd = Carbon::today()->format('Y-m-d');
        } elseif ($option == 2) {
            $this->timeStart = Carbon::create(2023, 1, 1)->format('Y-m-d');
            $this->timeEnd = Carbon::today()->format('Y-m-d');
        }

        $this->timeStartPick = Carbon::parse($this->timeStart)->format('d/m/Y');
        $this->timeEndPick = Carbon::parse($this->timeEnd)->format('d/m/Y');
        
        $this->updateData();
        
        // Dispatch event ke JS (Livewire v2)
        $this->dispatchBrowserEvent('chart-updated', [
            'data' => $this->chartData,
            'option' => $this->selectedOption
        ]);
    }

    public function setTimeStart($value)
    {
        try {
            $date = Carbon::createFromFormat('d/m/Y', $value);
            $this->timeStart = $date->format('Y-m-d');
            $this->timeStartPick = $value;
            $this->selectedOption = 3;
            $this->updateData();
            $this->dispatchBrowserEvent('chart-updated', [
                'data' => $this->chartData,
                'option' => $this->selectedOption
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert', ['message' => $e->getMessage()]);
        }
    }

    public function setTimeEnd($value)
    {
        try {
            $date = Carbon::createFromFormat('d/m/Y', $value);
            if ($date->lt(Carbon::parse($this->timeStart))) {
                throw new \Exception('Tanggal akhir harus lebih besar');
            }
            $this->timeEnd = $date->format('Y-m-d');
            $this->timeEndPick = $value;
            $this->selectedOption = 3;
            $this->updateData();
            $this->dispatchBrowserEvent('chart-updated', [
                'data' => $this->chartData,
                'option' => $this->selectedOption
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert', ['message' => $e->getMessage()]);
        }
    }

    public function updateData()
    {
        $baseQuery = Laporan::query()
            ->whereNotNull('npk')
            ->whereBetween('created_at', [
                $this->timeStart . ' 00:00:00', 
                $this->timeEnd . ' 23:59:59'
            ])
            ->whereNull('deleted_at');

        $this->totalReports = $baseQuery->count();

        // CHART DATA
        $startDate = Carbon::parse($this->timeStart);
        $endDate = Carbon::parse($this->timeEnd);
        
        $this->chartData = [];
        
        if ($this->selectedOption == 2) { // YEARS
            for ($year = $startDate->year; $year <= $endDate->year; $year++) {
                $yearStart = Carbon::create($year, 1, 1)->format('Y-m-d 00:00:00');
                $yearEnd = Carbon::create($year, 12, 31)->format('Y-m-d 23:59:59');

                $open = Laporan::whereNotNull('npk')
                    ->where('progress', '<=', 12)
                    ->whereBetween('created_at', [$yearStart, $yearEnd])
                    ->whereNull('deleted_at')
                    ->count();

                $closed = Laporan::whereNotNull('npk')
                    ->where('progress', '>=', 13)
                    ->whereBetween('created_at', [$yearStart, $yearEnd])
                    ->whereNull('deleted_at')
                    ->count();

                $this->chartData[] = [
                    'label' => (string)$year,
                    'open' => (int)$open,
                    'closed' => (int)$closed
                ];
            }
        } else { // MONTH
            $current = $startDate->copy()->startOfMonth();
            while ($current <= $endDate && count($this->chartData) < 12) {
                $monthStart = $current->copy()->startOfMonth()->format('Y-m-d 00:00:00');
                $monthEnd = $current->copy()->endOfMonth()->format('Y-m-d 23:59:59');

                $open = Laporan::whereNotNull('npk')
                    ->where('progress', '<=', 12)
                    ->whereBetween('created_at', [$monthStart, $monthEnd])
                    ->whereNull('deleted_at')
                    ->count();

                $closed = Laporan::whereNotNull('npk')
                    ->where('progress', '>=', 13)
                    ->whereBetween('created_at', [$monthStart, $monthEnd])
                    ->whereNull('deleted_at')
                    ->count();

                $this->chartData[] = [
                    'label' => $current->format('M'),
                    'open' => (int)$open,
                    'closed' => (int)$closed
                ];

                $current->addMonth();
            }
        }

        $this->openReports = collect($this->chartData)->sum('open');
        $this->closedReports = collect($this->chartData)->sum('closed');

        $this->topReporters = $baseQuery
            ->select('npk', 'nama_penemu', DB::raw('COUNT(*) as total'))
            ->groupBy('npk', 'nama_penemu')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(fn($item) => [
                'npk' => $item->npk,
                'nama' => $item->nama_penemu ?: 'Unknown',
                'total' => $item->total
            ])
            ->toArray();
    }

    public function exportDashboard(Request $request)
    {
        $request->validate([
            'imageData' => 'required|string',
            'filename' => 'required|string'
        ]);

        try {
            // Decode base64 image
            $imageData = $request->input('imageData');
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = str_replace(' ', '+', $imageData);
            $image = base64_decode($imageData);

            // Simpan di storage
            $path = 'dashboard-exports/' . $request->input('filename');
            Storage::disk('public')->put($path, $image);

            $downloadUrl = Storage::url($path);

            return response()->json([
                'success' => true,
                'downloadUrl' => $downloadUrl,
                'filename' => $request->input('filename')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan gambar: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.dashboard-point');
    }
}