<?php

namespace App\Controllers;

class CalendarController extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $data['title'] = 'Kalendář';
        return view('calendar');
    }
}
