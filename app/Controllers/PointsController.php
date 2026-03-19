<?php

namespace App\Controllers;

use App\Models\PointsModel;
use App\Models\TaskModel;
use App\Models\UserModel;

class PointsController extends BaseController
{
    public function form($taskId, $studentId)
    {
        $role = session()->get('role');

        if (!in_array($role, ['admin', 'teacher'])) {
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
            'task' => $task,
            'student' => $student,
            'existingPoints' => $existingPoints,
        ]);
    }

    public function save()
    {
        $role = session()->get('role');

        if (!in_array($role, ['admin', 'teacher'])) {
            return redirect()->back()->with('error', 'Nemáte oprávnění.');
        }

        $pointsModel = new PointsModel();
        $taskModel = new TaskModel();

        $userId = (int) $this->request->getPost('user_id');
        $taskId = (int) $this->request->getPost('task_id');
        $points = (int) $this->request->getPost('points');
        $note = trim((string) $this->request->getPost('note'));

        $task = $taskModel->find($taskId);

        if (!$task) {
            return redirect()->back()->with('error', 'Úkol nebyl nalezen.');
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
        $role = session()->get('role');

        if (!in_array($role, ['admin', 'teacher'])) {
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
            $student = $userModel->find($task['assigned_to']);
            if ($student) {
                $students[] = $student;
            }
        } elseif ($task['assign_type'] === 'selected') {
            $assignedIds = array_filter(array_map('trim', explode(',', $task['assigned_to'])));
            if (!empty($assignedIds)) {
                $students = $userModel->whereIn('id', $assignedIds)->findAll();
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
            'task' => $task,
            'students' => $students,
        ]);
    }

    public function leaderboard()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('users');
        $builder->select('
            users.id,
            users.name,
            users.email,
            COALESCE(SUM(points.points), 0) AS total_points,
            COUNT(points.id) AS scored_tasks
        ');
        $builder->join('points', 'points.user_id = users.id', 'left');
        $builder->where('users.role', 'student');
        $builder->groupBy('users.id, users.name, users.email');
        $builder->orderBy('total_points', 'DESC');
        $builder->orderBy('users.name', 'ASC');

        $students = $builder->get()->getResultArray();

        return view('leaderboard', [
            'students' => $students,
        ]);
    }
}