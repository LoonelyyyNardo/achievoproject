<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\TaskModel;

class MainController extends BaseController
{
    public function dashboard()
{
    $userModel = new UserModel();
    $taskModel = new TaskModel();

    $user_id = 1; // pro demo, můžeš nahradit dynamicky
    $data['user'] = $userModel->find($user_id);
    $data['tasks'] = $taskModel->where('user_id', $user_id)->findAll();

    // body z existující tabulky points
    $builder = $taskModel->db->table('points');
    $row = $builder->where('user_id', $user_id)->get()->getRowArray();
    $data['points'] = $row ? $row['points'] : 0;

    $data['title'] = 'Dashboard';
    return view('dashboard', $data);
}

    public function tasks()
    {
        $taskModel = new TaskModel();
        $user_id = 1; // pro demo
        $data['tasks'] = $taskModel->where('user_id', $user_id)->findAll();
        $data['title'] = 'Seznam úkolů';
        return view('tasks', $data);
    }
}
