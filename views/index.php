<main class="py-2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-toggleable-md navbar-light bg-faded justify-content-between">
                    <a href="<?php echo $router->generate('create'); ?>" class="btn btn-primary">Создать новое
                        задание</a>
                    <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Сортировка по: <?php
                            switch ($data['sort']) {
                                case 2:
                                    echo 'Имени';
                                    break;
                                case 3:
                                    echo 'Почте';
                                    break;
                                case 4:
                                    echo 'Статусу';
                                    break;
                                default:
                                    echo 'Дате';
                            } ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="?sort=1">Дате</a>
                            <a class="dropdown-item" href="?sort=2">Имени</a>
                            <a class="dropdown-item" href="?sort=3">Почте</a>
                            <a class="dropdown-item" href="?sort=4">Статусу</a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col-md-12 my-2">
                <div class="row d-flex align-items-stretch">
                    <?php foreach ($data['tasks'] as $task): ?>
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <img src="<?php echo $task['img']; ?>" class="my_img">
                                    <h5 class="card-title"><?php echo $task['username']; ?></h5>


                                    <h6 class="card-subtitle mb-2 text-muted"><?php echo $task['email']; ?></h6>
                                    <?php echo $task['status'] ? "<span class=\"badge badge-success\">Выполненая задача</span>" : "<span class=\"badge badge-info\">Новая задача</span>" ?>
                                    <p class="card-text"><?php echo $task['text']; ?></p>
                                    <?php
                                    if ($this->auth()) echo " <a href=\"{$router->generate('edit', ['id' => $task['id']])}\" class=\"card-link\">Редактировать</a>"; ?>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="row my-2 justify-content-center">

            <div class="col-md-12">
                <nav>
                    <ul role="navigation" class="pagination justify-content-center">
                        <?php echo $data['paginator']->get(); ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</main>