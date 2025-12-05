<?php namespace App\Controllers;

use App\Models\NotificationModel;

class NotificationController extends BaseController
{
    public function getUnread()
    {
        $notificationModel = new NotificationModel();
        $notifications = $notificationModel
            ->where('user_id', session()->get('user_id'))
            ->where('is_read', 0)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return $this->response->setJSON($notifications);
    }

    public function markAsRead()
    {
        $notificationModel = new NotificationModel();
        $notificationModel
            ->where('user_id', session()->get('user_id'))
            ->set(['is_read' => 1])
            ->update();

        return $this->response->setJSON(['status' => 'success']);
    }
}