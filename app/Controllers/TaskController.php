<?php

namespace App\Controllers;

use App\Models\Tasks;
use App\Components\Validation;
use App\Components\Pagination;

class TaskController extends BaseController
{

    /**
     * TaskController constructor.
     */
    function __construct()
    {
        parent::__construct();
        $this->model = new Tasks();
        $this->val = new Validation();
    }

    /**
     * Страница вывода всех заданий
     */
    public function index()
    {

        $page = 1;
        $sort = 1;
        if (array_key_exists('page', $_GET) && $_GET['page'] > 0) {
            $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        }
        if (array_key_exists('sort', $_GET) && $_GET['sort'] > 0 && $_GET['sort'] < 5) {
            $sort = filter_input(INPUT_GET, 'sort', FILTER_VALIDATE_INT);
        }

        $tasks = $this->model->getTaskByPage($page, $sort);
        $count = $this->model->getCountTasks();

        $paginator = new Pagination($count, $page, Tasks::SHOW_BY_DEFAULT, 'page');

        $data = [
            'tasks' => $tasks,
            'paginator' => $paginator,
            'sort' => $sort
        ];

        return $this->show('index', $data);
    }

    /**
     * Страница создания задания
     */
    public function create()
    {
        return $this->show('create');
    }

    /**
     * Валидация и сохранение создания задания
     */
    public function store()
    {
        $this->post();
        $this->val->value($this->post['username'])->message('Неверно указано имя')->pattern('words')->required();
        $this->val->value($this->post['email'])->message('Неверно указан Email')->required()->is_email($this->post['email']);
        $this->val->value($this->post['text'])->message('Неверно указан текст задания')->pattern('text')->required();

        if (!$this->val->isSuccess()) {
            return $this->show('create', [
                'task' => $this->post,
                'errors' => $this->val->getErrors()
            ]);
        }

        $this->post['text'] = nl2br($this->post['text']);
        $this->post['img'] = $this->model->loadPhoto();

        if (!$this->model->createTask($this->post)) {
            return $this->show('create', [
                'errors' => ['Произошла ошибка при сохранении'],
                'task' => $this->post
            ]);
        }

        return $this->redirect('home');
    }

    /**
     * Страница редактирования задания
     */
    public function edit($params)
    {
        // проверка авторизации
        if (!$this->auth()) {
            return $this->redirect('login');
        }

        $task = $this->model->getTaskById($params['id']);
        $data = [
            'task' => $task
        ];

        return $this->show('edit', $data);
    }


    /**
     * Обновления задания
     * @param $params
     * @throws \Exception
     */
    public function update($params)
    {
        // проверка авторизации
        if (!$this->auth()) {
            return $this->redirect('login');
        }

        $this->post();
        $this->val->value($this->post['username'])->message('Неверно указано имя')->pattern('words')->required();
        $this->val->value($this->post['email'])->message('Неверно указан Email')->required()->is_email($this->post['email']);
        $this->val->value($this->post['text'])->message('Неверно указан текст задания')->pattern('text')->required();
        $this->val->value($this->post['status'])->message('Попытка взлома чекбокса)')->is_bool($this->post['status']);

        if (!$this->val->isSuccess()) {
            return $this->show('edit', [
                'task' => $this->post,
                'errors' => $this->val->getErrors()
            ]);
        }

        $this->post['text'] = nl2br($this->post['text']);
        if ($_FILES['image']['size']) {
            $this->post['img'] = $this->model->loadPhoto();
        }

        $this->post['id'] = $params['id'];

        if (!$this->model->updateTask($this->post)) {
            return $this->show('edit', [
                'errors' => ['Произошла ошибка при сохранении'],
                'task' => $this->post
            ]);
        }

        return $this->redirect('home');
    }

}