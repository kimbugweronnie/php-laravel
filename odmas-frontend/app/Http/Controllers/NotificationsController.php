<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NotificationsController extends Controller
{
    public function index()
    {
        $notifications = $this->getNotifications();
        //dd($approvals);
        if ($notifications) {
            if ($notifications == 'Error') {
                return redirect()->route('error');
            } elseif ($notifications == null) {
                return redirect()->route('login');
            } elseif ($notifications == 'No notifications') {
                $notifications = [];
                return view('notifications.index', compact('notifications'));
            } else {
                return view('notifications.index', compact('notifications'));
            }
        } else {
        }
    }
    public function count()
    {
        $notifications = $this->getNotifications();
        return count($notifications);
    }

    public function getNotifications()
    {
        $url = 'https://api.odms.savannah.ug/api/v1/notifications';
        $accessToken = $this->getToken();
        if ($accessToken) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                ])->get($url);
                $jsonData = $response->json();
                if ($jsonData['status'] == 404) {
                    return 'No notifications';
                }
                if ($jsonData['status'] == 200) {
                    if (!empty($jsonData['data'])) {
                        return $jsonData['data'];
                    } else {
                        return 'No notifications';
                    }
                }
            } catch (\Throwable $error) {
                return redirect()->route('error');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function read()
    {
        return view('notifications.read');
    }

    public function unread()
    {
        return view('notifications.unread');
    }

    public function getToken()
    {
        return Session::get('token');
    }
}
