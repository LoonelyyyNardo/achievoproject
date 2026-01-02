<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TaskModel;

class MainController extends BaseController
{
    public function dashboard()
    {
        // kontrola přihlášení
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $taskModel = new TaskModel();

        // ID přihlášeného uživatele
        $user_id = session()->get('user_id');

        // data uživatele
        $data['user'] = $userModel->find($user_id);

        // úkoly uživatele
        $data['tasks'] = $taskModel
            ->where('user_id', $user_id)
            ->findAll();

        // body z tabulky points
        $builder = $taskModel->db->table('points');
        $row = $builder->where('user_id', $user_id)->get()->getRowArray();
        $data['points'] = $row ? $row['points'] : 0;

        $data['title'] = 'Dashboard';

        return view('dashboard', $data);
    }

    public function tasks()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $taskModel = new TaskModel();
        $user_id = session()->get('user_id');

        $data['tasks'] = $taskModel
            ->where('user_id', $user_id)
            ->findAll();

        $data['title'] = 'Seznam úkolů';

        return view('tasks', $data);
    }
}
