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
    public function show(Report $report)
    {
        //AC-05
        if (auth()->user()->role === 'pelapor' && $report->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat laporan ini.');
        }

        $report->load(['user', 'area', 'reviews.user']);
        return view('reports.show', compact('report'));
    }

    public function review(Request $request, Report $report)
    {
        $user = auth()->user();

        if (!in_array($user->role, ['relawan', 'koordinator'])) {
            abort(403, 'Anda tidak memiliki hak akses peninjauan.');
        }

        $request->validate([
            'status_baru' => ['required', 'string'],
            'catatan'     => ['required', 'string', 'min:5'],
        ]);

        $statusLama = $report->status;
        $statusTujuan = $request->status_baru;

        //BR-03
        if ($user->role === 'relawan') {
            if (!in_array($statusTujuan, ['diverifikasi', 'ditolak'])) {
                return back()->with('error', 'Relawan hanya dapat memverifikasi atau menolak laporan.');
            }
        } elseif ($user->role === 'koordinator') {
            if ($statusTujuan === 'diteruskan' && $statusLama !== 'diverifikasi') {
                return back()->with('error', 'Laporan hanya dapat diteruskan jika sudah diverifikasi oleh relawan.');
            }
        }

        $report->status = $statusTujuan;
        $report->save();

        $report->reviews()->create([
            'user_id'           => $user->id,
            'status_sebelumnya' => $statusLama,
            'status_baru'       => $statusTujuan,
            'catatan'           => $request->catatan,
        ]);

        return back()->with('success', 'Status laporan berhasil diperbarui.');
    }
}