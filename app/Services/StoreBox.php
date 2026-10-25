<?php

namespace App\Services;

use App\Enums\AuditAction;
use App\Enums\AuditTarget;
use App\Http\Requests\StoreBoxRequest;
use App\Models\Box;
use Illuminate\Support\Facades\DB;

class StoreBox
{
    public function __construct(private AuditLogger $logger) {}

    public function __invoke(StoreBoxRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $newBox = Box::create($request->validated());

            ($this->logger)(
                $request->user(),
                AuditAction::Add,
                AuditTarget::Box,
                $newBox->box_number
            );

            return $newBox;
        });
    }
}
