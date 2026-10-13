<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuditLogRequest;
use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AuditLogController extends Controller
{
    public function index()
    {
        return inertia('auditlogs/index', [
            'auditLogs' => AuditLog::query()
                ->latest('id')
                ->paginate(50)
                ->toResourceCollection()
        ]);
    }


    public function store(StoreAuditLogRequest $request)
    {
        Gate::authorize('create', AuditLog::class);
        AuditLog::create($request->validated());
        return response('ok', 201);
    }


    public function destroy()
    {
        Gate::authorize('delete', AuditLog::class);
        DB::delete('truncate table audit_logs');
        return back();
    }
}
