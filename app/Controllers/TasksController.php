<?php
namespace App\Controllers;

use App\Models\TaskModel;
use CodeIgniter\Controller;

class TasksController extends Controller
{
    public function index()
    {
        $taskModel = new TaskModel();
        $data['tasks'] = $taskModel->findAll();

        return view('tasks', $data);
    }

    public function add()
    {
        return view('task_add');
    }

    public function store()
    {
        $taskModel = new TaskModel();

        $taskModel->save([
            'user_id' => 1, // nebo přihlášený uživatel
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'deadline' => $this->request->getPost('deadline'),
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/tasks');
    }

    public function delete($id)
    {
        $taskModel = new TaskModel();
        $taskModel->delete($id);

        return redirect()->to('/tasks');
    }
}
