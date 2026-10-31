<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Area;
use App\Http\Requests\StoreReportRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Report::with(['user', 'area'])->latest();

        //AC-05
        if ($user->role === 'pelapor') {
            $query->where('user_id', $user->id);
        }

        //AC-10 + AC-11
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('area_id')) {
            $query->where('area_id', $request->area_id);
        }

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $reports = $query->paginate(5)->withQueryString();
        $areas = Area::all();

        return view('reports.index', compact('reports', 'areas'));
    }
    public function create()
    {
        if (auth()->user()->role !== 'pelapor') {
            abort(403, 'Hanya pelapor yang dapat membuat laporan baru.');
        }

        $areas = Area::all();
        return view('reports.create', compact('areas'));
    }

    public function store(StoreReportRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['status'] = 'menunggu_peninjauan'; // BR-01

        if ($request->hasFile('bukti')) {
            $data['bukti_path'] = $request->file('bukti')->store('bukti_karhutla', 'public');
        }

        Report::create($data);

        return redirect()->route('dashboard')->with('success', 'Laporan kebakaran berhasil dikirim dan menunggu peninjauan relawan.');
    }
}