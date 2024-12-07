<?php

namespace App\Http\Controllers;

use App\Http\Responses\ResponseBase;
use App\Models\GlobalNotifications;
use App\Services\NotificationService;

class NotificationController extends Controller
{
    protected $service;

    public function __construct()
    {
        $this->service = new NotificationService();
    }

    public function getNotifBadges(): \Illuminate\Http\JsonResponse
    {
        $response = [];
        foreach (GlobalNotifications::$repo as $index => $module) {
            $repo = new GlobalNotifications::$repo[$index];
            $response[$index] = $repo->notify()['notif_count'];
        }

        return ResponseBase::json($response);
    }
}
