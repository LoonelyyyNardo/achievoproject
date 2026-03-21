<?php

namespace App\Controllers;

use App\Models\PointsModel;
use App\Models\TaskModel;
use App\Models\UserModel;

class PointsController extends BaseController
{
    public function form($taskId, $studentId)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role');

        if (!in_array($role, ['admin', 'teacher'], true)) {
            return redirect()->to('/dashboard')->with('error', 'Nemáte oprávnění.');
        }

        $taskModel = new TaskModel();
        $pointsModel = new PointsModel();
        $userModel = new UserModel();

        $task = $taskModel->find($taskId);
        $student = $userModel->find($studentId);

        if (!$task || !$student) {
            return redirect()->back()->with('error', 'Úkol nebo student nebyl nalezen.');
        }

        $existingPoints = $pointsModel
            ->where('task_id', $taskId)
            ->where('user_id', $studentId)
            ->first();

        return view('points_form', [
            'title' => 'Udělení bodů',
            'task' => $task,
            'student' => $student,
            'existingPoints' => $existingPoints,
        ]);
    }

    public function save()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role');

        if (!in_array($role, ['admin', 'teacher'], true)) {
            return redirect()->back()->with('error', 'Nemáte oprávnění.');
        }

        $pointsModel = new PointsModel();
        $taskModel = new TaskModel();
        $userModel = new UserModel();

        $userId = (int) $this->request->getPost('user_id');
        $taskId = (int) $this->request->getPost('task_id');
        $points = (int) $this->request->getPost('points');
        $note = trim((string) $this->request->getPost('note'));

        $task = $taskModel->find($taskId);
        $user = $userModel->find($userId);

        if (!$task) {
            return redirect()->back()->with('error', 'Úkol nebyl nalezen.');
        }

        if (!$user) {
            return redirect()->back()->with('error', 'Uživatel nebyl nalezen.');
        }

        if ($user['role'] !== 'student') {
            return redirect()->back()->with('error', 'Body lze přidělit pouze studentovi.');
        }

        if ($points < 0 || $points > (int) $task['max_points']) {
            return redirect()->back()->with('error', 'Neplatný počet bodů.');
        }

        $existing = $pointsModel
            ->where('user_id', $userId)
            ->where('task_id', $taskId)
            ->first();

        $data = [
            'user_id' => $userId,
            'task_id' => $taskId,
            'points' => $points,
            'awarded_by' => session()->get('user_id'),
            'note' => $note,
        ];

        if ($existing) {
            $pointsModel->update($existing['id'], $data);
        } else {
            $pointsModel->insert($data);
        }

        return redirect()->to('/points/task/' . $taskId)->with('success', 'Body byly uloženy.');
    }

    public function taskStudents($taskId)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $role = session()->get('role');

        if (!in_array($role, ['admin', 'teacher'], true)) {
            return redirect()->to('/dashboard')->with('error', 'Nemáte oprávnění.');
        }

        $taskModel = new TaskModel();
        $userModel = new UserModel();
        $pointsModel = new PointsModel();

        $task = $taskModel->find($taskId);

        if (!$task) {
            return redirect()->back()->with('error', 'Úkol nebyl nalezen.');
        }

        $students = [];

        if ($task['assign_type'] === 'all') {
            $students = $userModel->where('role', 'student')->findAll();
        } elseif ($task['assign_type'] === 'single') {
            $student = $userModel
                ->where('id', $task['assigned_to'])
                ->where('role', 'student')
                ->first();

            if ($student) {
                $students[] = $student;
            }
        } elseif ($task['assign_type'] === 'selected' && !empty($task['assigned_to'])) {
            $assignedIds = array_filter(array_map('trim', explode(',', $task['assigned_to'])));

            if (!empty($assignedIds)) {
                $students = $userModel
                    ->where('role', 'student')
                    ->whereIn('id', $assignedIds)
                    ->findAll();
            }
        }

        foreach ($students as &$student) {
            $existingPoints = $pointsModel
                ->where('task_id', $taskId)
                ->where('user_id', $student['id'])
                ->first();

            $student['awarded_points'] = $existingPoints['points'] ?? null;
        }
        unset($student);

        return view('task_students_points', [
            'title' => 'Hodnocení studentů',
            'task' => $task,
            'students' => $students,
        ]);
    }

   public function leaderboard()
{
    if (!session()->get('logged_in')) {
        return redirect()->to('/login');
    }

    $userModel = new UserModel();
    $pointsModel = new PointsModel();

    $users = $userModel
        ->where('role', 'student')
        ->orderBy('username', 'ASC')
        ->findAll();

    foreach ($users as &$user) {
        $sumRow = $pointsModel
            ->selectSum('points')
            ->where('user_id', $user['id'])
            ->first();

        $user['total_points'] = (int) ($sumRow['points'] ?? 0);

        $user['scored_tasks'] = $pointsModel
            ->where('user_id', $user['id'])
            ->countAllResults();
    }
    unset($user);

    usort($users, function ($a, $b) {
        if ($a['total_points'] === $b['total_points']) {
            return strcmp($a['username'], $b['username']);
        }

        return $b['total_points'] <=> $a['total_points'];
    });
    return view('leaderboard', [
        'title' => 'Leaderboard',
        'users' => $users
    ]);
}
}