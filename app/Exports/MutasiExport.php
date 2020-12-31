<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MutasiExport implements FromView, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;
    protected $userId;

    public function __construct($startDate, $endDate, $userId) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->userId = $userId;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('report.mutasi-download', [
            'data' => Transaction::whereBetween(\DB::raw('(DATE_FORMAT(created_at, "%Y-%m-%d"))'), [$this->startDate, $this->endDate])
                    ->where('reference_id', $this->userId)
                    ->orderBy('id', 'desc')
                    ->get(),
            ]);
    }
}
