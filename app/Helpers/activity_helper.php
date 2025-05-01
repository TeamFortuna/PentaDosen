<?php

use App\Models\ActivityLogModel;

if (!function_exists('log_activity')) {
    function log_activity($userId, $activity, $description)
    {
        $logModel = new ActivityLogModel();

        $data = [
            'user_id' => $userId,
            'activity' => $activity,
            'description' => $description,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ];

        $logModel->insert($data);
    }
}
