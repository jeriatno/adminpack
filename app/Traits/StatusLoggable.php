<?php

namespace App\Traits;

use App\GlobalStatusLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait StatusLoggable
{
    public function statusLogs(): MorphMany
    {
        return $this->morphMany(GlobalStatusLog::class, 'loggable');
    }

    public function insertLog($module, $action, $isReverse = false, $params = []): Model
    {
        if ($isReverse) {
            $status = $action;
            $action = array_search($action, self::LOG_STATUS);
            $description = self::LOG_DESC[$action] ?? 'Status updated';
        } else {
            $status = self::LOG_STATUS[$action] ?? null;
            $description = self::LOG_DESC[$action] ?? 'Action logged';
        }

        return $this->statusLogs()->create([
            'module'      => $module,
            'action'      => $action,
            'status'      => $status,
            'description' => $description,
            'notes'       => $params['notes'] ?? null,
            'created_by'  => auth()->id(),
        ]);
    }
}
