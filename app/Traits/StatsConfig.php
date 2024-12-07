<?php

namespace App\Traits;

trait StatsConfig
{
    /**
     * Get the stats configuration.
     * @return array
     */
    public static function getStatsConfig(): array
    {
        return array_map(function ($status) {
            return [
                'theme' => self::STATUS_BADGE[$status] ?? 'bg-primary',
                'icon' => self::STATUS_ICONS[$status],
                'label' => $status,
                'number' => str_replace(' ', '_', strtolower($status)),
                'onClick' => true
            ];
        }, self::STATUS_STATS ?? self::STATUS_LIST);
    }
}
