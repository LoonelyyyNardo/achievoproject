<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TaskModel;

class MainController extends BaseController
{
    public function dashboard()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $taskModel = new TaskModel();

        $userId = (string) session()->get('user_id');
        $role = session()->get('role');

        $allTasks = $taskModel->orderBy('deadline', 'ASC')->findAll();

        if ($role === 'admin') {
            $visibleTasks = $allTasks;
        } else {
            $visibleTasks = [];

            foreach ($allTasks as $task) {
                $isCreator = ((string) $task['user_id'] === $userId);

                if ($isCreator) {
                    $visibleTasks[] = $task;
                    continue;
                }

                if ($task['assign_type'] === 'all') {
                    $visibleTasks[] = $task;
                    continue;
                }

                if ($task['assign_type'] === 'single' && (string) $task['assigned_to'] === $userId) {
                    $visibleTasks[] = $task;
                    continue;
                }

                if ($task['assign_type'] === 'selected' && !empty($task['assigned_to'])) {
                    $ids = array_map('trim', explode(',', $task['assigned_to']));
                    if (in_array($userId, $ids, true)) {
                        $visibleTasks[] = $task;
                    }
                }
            }
        }

        $data['user'] = $userModel->find($userId);
        $data['tasks'] = $visibleTasks;
        $data['task_count'] = count($visibleTasks);

        $pendingCount = 0;
        foreach ($visibleTasks as $task) {
            if ($task['status'] === 'pending') {
                $pendingCount++;
            }
        }
        $data['pending_count'] = $pendingCount;

        $db = \Config\Database::connect();
        $row = $db->table('points')->where('user_id', $userId)->get()->getRowArray();
        $data['points'] = $row ? $row['points'] : 0;

        $data['title'] = 'Dashboard';

        return view('dashboard', $data);
    }

    public function about()
    {
        $data['title'] = 'O mně';
        return view('about', $data);
    }
}