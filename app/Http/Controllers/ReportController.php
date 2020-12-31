<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportMutasiRequest;
use App\Exports\MutasiExport;
use Auth;

class ReportController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'check_phone_number']);
    }

    public function mutasi() {
        return view('report.mutasi');
    }

    public function mutasiDownload(ReportMutasiRequest $request) {
        $startDate = date('Y-m-d', strtotime($request->start_date));
        $endDate = date('Y-m-d', strtotime($request->end_date));
        $userId = Auth::user()->id;

        $formatFile = 'Mutasi-'.date('YmdHis').'.xlsx';

        return \Excel::download(new MutasiExport($startDate, $endDate, $userId), $formatFile);
    }
}
