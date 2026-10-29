<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Http\Requests\StoreAuditLogRequest;
use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AuditLogController extends Controller
{
    public function index(SearchRequest $request)
    {
        return inertia('auditlogs/index', [
            'auditLogs' => AuditLog::getResources($request, AuditLog::query()),
            'filters' => $this->getFilters($request),
        ]);
    }


    public function store(StoreAuditLogRequest $request)
    {
        Gate::authorize('create', AuditLog::class);
        AuditLog::create($request->validated());
        return response('ok', 201);
    }


    public function destroy(AuditLog $audit_log)
    {
        Gate::authorize('delete', AuditLog::class);
        DB::delete('truncate table audit_logs');
        return back();
    }


    private function getFilters(SearchRequest $request)
    {
        return $request->only(['name', 'number']);
    }
}
