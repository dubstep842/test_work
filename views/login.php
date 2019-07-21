<main class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="<?php echo $router->generate('auth'); ?>">
                            <?php if (isset($data['error'])): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $data['error']; ?>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Логин</label>
                                <input type="text" class="form-control" name="login" required
                                       placeholder="Введите логин">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Пароль</label>
                                <input type="password" class="form-control" name="pass" required
                                       placeholder="Введите пароль">
                            </div>
                            <button type="submit" class="btn btn-primary">Войти</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>



