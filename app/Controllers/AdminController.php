<?php

namespace App\Controllers;

use App\Models\UserModel;

class AdminController extends BaseController
{
    public function users()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard');
        }

        $userModel = new UserModel();

        $data['users'] = $userModel->findAll();
        $data['title'] = 'Správa uživatelů';

        return view('admin_users', $data);
    }

    public function createUser()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard');
        }

        $userModel = new UserModel();

        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $role = $this->request->getPost('role');

        $userModel->insert([
            'username' => $username,
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role
        ]);

        return redirect()->to('/admin/users')->with('success', 'Uživatel byl vytvořen.');
    }
}