<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('login');
    }

    public function processLogin()
    {
        $session = session();
        $userModel = new UserModel();

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $userModel->where('username', $username)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Uživatel neexistuje.');
        }

        if (!password_verify($password, $user['password_hash'])) {
            return redirect()->back()->with('error', 'Špatné heslo.');
        }

        // Uložíme do session
        $session->set([
            'user_id'  => $user['id'],
            'username' => $user['username'],
            'logged_in' => true
        ]);

        return redirect()->to('/tasks');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
