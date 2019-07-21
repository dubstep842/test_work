<?php
/**
 * Created by PhpStorm.
 * User: MaLuTkA
 * Date: 20.07.2019
 * Time: 14:43
 */

namespace App\Models;


class Auth
{
    /**
     * Создания сессии
     * @param $userId
     */
    public function authorization($userId)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['userId'] = $userId;
    }

    /**
     * Удаление сессии
     */
    public function logout()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        unset($_SESSION['userId']);
        session_destroy();
    }


}