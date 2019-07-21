<?php

namespace App\Controllers;


use App\Components\Validation;
use App\Models\Model;

abstract class BaseController
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Validation
     */
    protected $val;

    /**
     * @var array - массив для пост параметров
     */
    protected $post;

    /**
     * Базовый конструктор для класов
     * BaseController constructor.
     */
    public function __construct()
    {

    }

    /**
     * функция проверка "авторизации"
     * @return bool
     */
    public function auth()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        return isset($_SESSION['userId']) ? true : false;
    }


    /**
     * Генерация представления
     * @param string $path - файл представления
     * @param array $data - массив с данными для представления
     */
    public function show($path = 'index', $data = [])
    {
        global $router; //Глобальная переменая для генерации роута
        require_once ROOT . "/views/layout/header.php";
        require_once ROOT . "/views/$path.php";
        require_once ROOT . "/views/layout/footer.php";
    }

    /**
     * Функция для генерации переадресации
     * @param string $routeName - имя маршрута
     * @param array $params - параметры для генерации маршрута
     * @throws \Exception
     */
    public function redirect($routeName, array $params = array())
    {
        global $router;
        header("Location: {$router->generate($routeName,$params)}");
    }

    /**
     * Функция для получения пост параметров, использована для удобства
     */
    public function post()
    {
        $this->post = $_POST;
    }

}