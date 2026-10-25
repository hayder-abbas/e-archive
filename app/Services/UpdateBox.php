<?php

namespace App\Services;

use App\Enums\AuditAction;
use App\Enums\AuditTarget;
use App\Http\Requests\UpdateBoxRequest;
use App\Models\Box;
use Illuminate\Support\Facades\DB;

class UpdateBox
{
    public function __construct(private AuditLogger $logger) {}

    public function __invoke(UpdateBoxRequest $request, Box $box)
    {
        return DB::transaction(function () use ($request, $box) {
            $box->update($request->validated());

            ($this->logger)(
                $request->user(),
                AuditAction::Edit,
                AuditTarget::Box,
                $box->box_number
            );

            return $box;
        });
    }
}
