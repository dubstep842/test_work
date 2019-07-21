<!doctype html>
<html lang="ru">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/main.css">
    <title>Hello, world!</title>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container"><a href="<?php echo $router->generate('home'); ?>" class="navbar-brand">
                Тестовое задание
            </a>
            <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
                    class="navbar-toggler"><span class="navbar-toggler-icon"></span></button>
            <div id="navbarSupportedContent" class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto"></ul>
                <ul class="navbar-nav ml-auto">
                    <?php
                    if ($this->auth()) {
                        echo "<li class=\"nav-item\"><a href=\"{$router->generate('logout')}\" class=\"nav-link\">Выход</a></li>";
                    } else {
                        echo "<li class=\"nav-item\"><a href=\"{$router->generate('login')}\" class=\"nav-link\">Панель управления</a></li>";
                    }
                    ?>

                </ul>
            </div>
        </div>
    </nav>