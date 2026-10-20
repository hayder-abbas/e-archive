<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuditLogRequest;
use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AuditLogController extends Controller
{
    private int $page;

    public function __construct()
    {
        $this->page = max(1, request()->integer('page', 1));
    }


    public function index()
    {
        return inertia('auditlogs/index', [
            'auditLogs' => AuditLog::cached(
                fn() => AuditLog::latest('id')
                    ->paginate(20, page: $this->page)
                    ->toResourceCollection(),
                "auditLogs:page:{$this->page}"  // [table]:[page]:[number or all]
            )
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
