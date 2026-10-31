<?php

namespace App\Observers;

use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReportObserver
{
    public function updated(Report $report): void
    {
        if (! $report->wasChanged('status')) {
            return;
        }

        Log::info('report.status.changed', [
            'report_id'   => $report->id,
            'judul'       => $report->judul,
            'old_status'  => $report->getRawOriginal('status'),
            'new_status'  => $report->status,
            'actor_id'    => Auth::id(),
            'actor_role'  => Auth::user()?->role ?? 'system',
            'timestamp'   => now()->toDateTimeString(),
        ]);
    }
}