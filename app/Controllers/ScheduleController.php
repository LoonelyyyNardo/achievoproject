<?php

namespace App\Controllers;

use App\Models\UserModel;

class ScheduleController extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $user_id = session()->get('user_id');

        $data['user'] = $userModel->find($user_id);
        $data['title'] = 'Rozvrh';

        return view('schedule', $data);
    }
}
