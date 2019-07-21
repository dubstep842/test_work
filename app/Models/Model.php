<?php
/**
 * Created by PhpStorm.
 * User: MaLuTkA
 * Date: 16.07.2019
 * Time: 20:12
 */

namespace App\Models;


abstract class Model
{
    private $db;

    function __construct()
    {
        $this->db = $this->getConnection();
    }

    /**
     * Подключение к БД по средствам PDO
     * @return \PDO - обьект подключения
     */
    private function getConnection()
    {
        $paramsPath = dirname(dirname(dirname(__FILE__))) . '/config/config.php';
        $params = include($paramsPath);

        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']};charset=utf8";
        $opt = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::ATTR_PERSISTENT => true,
        ];
        $db = new \PDO($dsn, $params['user'], $params['password'], $opt);

        return $db;
    }

    /**
     * Мини обертка для подготовленых запросов.
     * @param $prepare_request
     * @param array|null $prepare_query
     * @return bool|\PDOStatement
     */
    public function query($prepare_request, array $prepare_query = null)
    {
        $result = $this->db->prepare($prepare_request);
        $result->execute($prepare_query);

        return $result;
    }
}