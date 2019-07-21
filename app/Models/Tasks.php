<?php

namespace App\Models;


class Tasks extends Model
{
    /**
     * Количество елементов для вывода на страницу
     */
    const SHOW_BY_DEFAULT = 3;


    /**
     * Получение списка задачна странице
     * @param $page
     * @param $sort
     * @param int $limit
     * @return array
     */
    public function getTaskByPage($page, $sort, $limit = self::SHOW_BY_DEFAULT)
    {
        $offset = ($page - 1) * $limit;
        $order = $this->getOrder($sort);
        $sql = "SELECT * FROM tasks ORDER BY $order LIMIT ? OFFSET ?";
        $query = $this->query($sql, [$limit, $offset]);
        $result = $query->fetchall();
        return $result;
    }

    /**
     * Получение задания по id
     * @param $id
     * @return mixed
     */
    public function getTaskById($id)
    {
        $sql = "SELECT * FROM tasks WHERE id = ?";

        $query = $this->query($sql, [$id]);
        $result = $query->fetch();

        return $result;
    }

    /**
     * Получение количества задач
     * @return mixed
     */
    public function getCountTasks()
    {
        $sql = "SELECT COUNT(*) as count FROM tasks";

        $query = $this->query($sql);
        $result = $query->fetchObject();

        return $result->count;
    }

    /**
     * Получение поля для портировки по ключу
     * @param $sort
     * @return string
     */
    private function getOrder($sort)
    {
        switch ($sort) {
            case 2:
                return 'username';
            case 3:
                return 'email';
            case 4:
                return 'status';
            default :
                return 'id';
        }
    }

    /**
     * Загрузка изображения
     * @param int $w_o - максимальная ширина изображения
     * @param int $h_o - максимальная высота изображения
     * @return string - ссылка на изображение
     */
    public function loadPhoto($w_o = 320, $h_o = 240)
    {

        $filePath = $_FILES['image']['tmp_name'];
        $errorCode = $_FILES['image']['error'];
        if ($errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($filePath)) {
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
                UPLOAD_ERR_FORM_SIZE => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
                UPLOAD_ERR_PARTIAL => 'Загружаемый файл был получен только частично.',
                UPLOAD_ERR_NO_FILE => 'Файл не был загружен.',
                UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
                UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
                UPLOAD_ERR_EXTENSION => 'PHP-расширение остановило загрузку файла.',
            ];
            $url = array_key_exists('image', $_POST) ? filter_input(INPUT_POST, 'image', FILTER_SANITIZE_STRING) ?: false : false;
            return strlen($url) > 0 ? $url : false;
        }

        $fi = finfo_open(FILEINFO_MIME_TYPE);
        $mime = (string)finfo_file($fi, $filePath);
        finfo_close($fi);

        list($w_i, $h_i, $type) = getimagesize($filePath); // Получаем размеры и тип изображения (число)
        $types = array("", "gif", "jpeg", "png"); // Массив с типами изображений
        $ext = $types[$type]; // Зная "числовой" тип изображения, узнаём название типа
        if ($ext) {
            $func = 'imagecreatefrom' . $ext; // Получаем название функции, соответствующую типу, для создания изображения
            $img_i = $func($filePath); // Создаём дескриптор для работы с исходным изображением
        } else {
            echo 'Некорректное изображение'; // Выводим ошибку, если формат изображения недопустимый
            return false;
        }

        if (($h_i / $h_o) > ($w_i / $w_o)) {
            $w_o = $h_o / ($h_i / $w_i);
        }
        if (($h_i / $h_o) < ($w_i / $w_o)) {
            $h_o = $w_o / ($w_i / $h_i);
        }

        $img_o = imagecreatetruecolor($w_o, $h_o); // Создаём дескриптор для выходного изображения
        imagecopyresampled($img_o, $img_i, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i); // Переносим изображение из исходного в выходное, масштабируя его
        $func = 'image' . $ext; // Получаем функция для сохранения результата


        $format = str_replace('jpeg', 'jpg', $ext);
        $name = basename($_FILES['image']['name'], $format);
        $name .= date("H:i:s");
        $name = md5($name);

        if ($func($img_o, ROOT . '/public/img/' . $name .'.'. $format)) {

            $host = array_key_exists('HTTPS', $_SERVER) ?
                $_SERVER['HTTPS'] == 'on' ? "https://{$_SERVER['HTTP_HOST']}" : "http://{$_SERVER['HTTP_HOST']}" : "http://{$_SERVER['HTTP_HOST']}";

            return $host . '/img/' . $name .'.'. $format;
        } else {
            return '';
        }
    }

    /**
     * Создание ногово задания
     * @param $data
     * @return bool
     */
    public function createTask($data)
    {
        try {
            $sql = "INSERT INTO tasks ( username, email, text, img ) VALUES ( ?, ?, ?, ?)";
            $this->query($sql, [$data['username'], $data['email'], $data['text'], $data['img']]);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Обновление задания
     * @param $data
     * @return bool
     */
    public function updateTask($data)
    {
        try {
            $sql = "UPDATE tasks SET username = ?, email = ?, text = ?, img = ?, status = ? WHERE id = ?";
            $this->query($sql, [$data['username'], $data['email'], $data['text'], $data['img'], $data['status'], $data['id']]);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }


}