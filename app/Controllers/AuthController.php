<?php

namespace App\Controllers;

use App\Models\Auth;

class AuthController extends BaseController
{
    /**
     * AuthController constructor.
     */
    function __construct()
    {
        parent::__construct();
        $this->model = new Auth();
    }

    /**
     * Страница логина
     */
    public function index()
    {
        if ($this->auth()) {
            $this->redirect('home');
        }

        $this->show('login');
    }

    /**
     * Проверка входящих данных
     */
    public function store()
    {
        if (($_POST['login'] == 'admin') && ($_POST['pass'] == '123')) {
            $this->model->authorization('admin');
            $this->redirect('home');
        } else {
            $this->show('login', ['error' => 'Введен неверный логин или пароль']);
        }
    }

    /**
     * Выход
     */
    public function logout()
    {
        $this->model->logout();
        $this->redirect('home');
    }
}