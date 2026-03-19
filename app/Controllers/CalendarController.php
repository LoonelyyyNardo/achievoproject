<?php

namespace App\Controllers;

use App\Models\TaskModel;

class CalendarController extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        return view('calendar', [
            'title' => 'Kalendář'
        ]);
    }

    public function events()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON([]);
        }

        $taskModel = new TaskModel();

        $userId = (string) session()->get('user_id');
        $role = session()->get('role');

        $allTasks = $taskModel->findAll();
        $visibleTasks = [];

        if ($role === 'admin') {
            $visibleTasks = $allTasks;
        } else {
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

        $events = [];

        foreach ($visibleTasks as $task) {
            $color = '#dc3545';

            if ($task['status'] === 'done') {
                $color = '#198754';
            } elseif ($task['status'] === 'pending') {
                $color = '#fd7e14';
            }

            $events[] = [
                'title' => $task['title'],
                'start' => $task['deadline'],
                'color' => $color
            ];
        }

        return $this->response->setJSON($events);
    }
}