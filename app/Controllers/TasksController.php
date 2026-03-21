<?php

namespace App\Controllers;

use App\Models\TaskModel;
use App\Models\UserModel;

class TasksController extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $taskModel = new TaskModel();

        $role = session()->get('role');
        $currentUserId = (string) session()->get('user_id');

        $allTasks = $taskModel
    ->where('is_archived', 0)
    ->orderBy('deadline', 'ASC')
    ->findAll();

        if ($role === 'admin') {
            $data['tasks'] = $allTasks;
        } else {
            $visibleTasks = [];

            foreach ($allTasks as $task) {
                $isCreator = ((string) $task['user_id'] === $currentUserId);

                if ($isCreator) {
                    $visibleTasks[] = $task;
                    continue;
                }

                if ($task['assign_type'] === 'all') {
                    $visibleTasks[] = $task;
                    continue;
                }

                if ($task['assign_type'] === 'single' && (string) $task['assigned_to'] === $currentUserId) {
                    $visibleTasks[] = $task;
                    continue;
                }

                if ($task['assign_type'] === 'selected' && !empty($task['assigned_to'])) {
                    $ids = array_map('trim', explode(',', $task['assigned_to']));
                    if (in_array($currentUserId, $ids, true)) {
                        $visibleTasks[] = $task;
                    }
                }
            }

            $data['tasks'] = $visibleTasks;
        }

        $data['title'] = 'Úkoly';

        return view('tasks', $data);
    }

    public function add()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        if (!in_array(session()->get('role'), ['admin', 'teacher'], true)) {
            return redirect()->to('/tasks');
        }

        $userModel = new UserModel();

        $data['users'] = $userModel
            ->where('id !=', session()->get('user_id'))
            ->findAll();

        $data['title'] = 'Přidat úkol';

        return view('task_add', $data);
    }

    public function store()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        if (!in_array(session()->get('role'), ['admin', 'teacher'], true)) {
            return redirect()->to('/tasks');
        }

        $taskModel = new TaskModel();

        $assignType = $this->request->getPost('assign_type');
        $selectedUsers = $this->request->getPost('selected_users') ?? [];
        $maxPoints = (int) $this->request->getPost('max_points');

        if ($maxPoints < 1) {
            return redirect()->back()->withInput()->with('error', 'Maximální počet bodů musí být alespoň 1.');
        }

        $assignedTo = null;

        if ($assignType === 'single' && !empty($selectedUsers)) {
            $assignedTo = $selectedUsers[0];
        }

        if ($assignType === 'selected' && !empty($selectedUsers)) {
            $assignedTo = implode(',', $selectedUsers);
        }

        if ($assignType === 'all') {
            $assignedTo = null;
        }

        $taskModel->insert([
            'user_id' => session()->get('user_id'),
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'deadline' => $this->request->getPost('deadline'),
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
            'assign_type' => $assignType,
            'assigned_to' => $assignedTo,
            'max_points' => $maxPoints
        ]);

        return redirect()->to('/tasks')->with('success', 'Úkol byl vytvořen.');
    }

    public function archive($id)
{
    if (!session()->get('logged_in')) {
        return redirect()->to('/login');
    }

    $taskModel = new TaskModel();
    $task = $taskModel->find($id);

    if (!$task) {
        return redirect()->to('/tasks');
    }

    $role = session()->get('role');
    $currentUserId = (string) session()->get('user_id');

    if ($role !== 'admin' && (string) $task['user_id'] !== $currentUserId) {
        return redirect()->to('/tasks');
    }

    $taskModel->update($id, ['is_archived' => 1]);

    return redirect()->to('/tasks')->with('success', 'Úkol byl archivován.');
}

    public function done($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $taskModel = new TaskModel();
        $task = $taskModel->find($id);

        if (!$task) {
            return redirect()->to('/tasks');
        }

        $role = session()->get('role');
        $currentUserId = (string) session()->get('user_id');
        $canAccess = false;

        if ($role === 'admin') {
            $canAccess = true;
        }

        if ((string) $task['user_id'] === $currentUserId) {
            $canAccess = true;
        }

        if ($task['assign_type'] === 'all') {
            $canAccess = true;
        }

        if ($task['assign_type'] === 'single' && (string) $task['assigned_to'] === $currentUserId) {
            $canAccess = true;
        }

        if ($task['assign_type'] === 'selected' && !empty($task['assigned_to'])) {
            $ids = array_map('trim', explode(',', $task['assigned_to']));
            if (in_array($currentUserId, $ids, true)) {
                $canAccess = true;
            }
        }

        if (!$canAccess) {
            return redirect()->to('/tasks');
        }

        $taskModel->update($id, ['status' => 'done']);

        return redirect()->to('/tasks')->with('success', 'Úkol byl dokončen.');
    }
}