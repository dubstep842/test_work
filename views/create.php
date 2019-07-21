<main class="py-2">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-md-12 my-2">
                <div class="row d-flex align-items-stretch">

                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <?php if (isset($data['errors'])): foreach ($data['errors'] as $error): ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $error; ?>
                                    </div>
                                <?php endforeach; endif; ?>
                                <form action="<?php echo $router->generate('store'); ?>" method="POST"
                                      enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Имя пользователя</label>
                                        <input type="text" class="form-control" id="name" name="username"
                                               placeholder="Username" required
                                               value="<?php if (isset($data['task']['username'])) echo $data['task']['username']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Email адрес</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                               placeholder="name@example.com" required
                                               value="<?php if (isset($data['task']['email'])) echo $data['task']['email']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Текст задания</label>
                                        <textarea class="form-control" id="text" required name="text"
                                                  rows="5"><?php if (isset($data['task']['text'])) echo $data['task']['text']; ?></textarea>

                                    </div>

                                    <div class="form-group">
                                        <label for="exampleFormControlFile1">Прикрепить картинку</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input"
                                                   accept="image/jpeg,image/png,image/gif" name="image" id="customFile"
                                                   onchange="readURL(this)">
                                            <label class="custom-file-label" for="customFile" id="val">Выберите
                                                файл</label>
                                        </div>
                                    </div>

                                    <div class="form-group d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary">Сохранить</button>
                                        <button type="button" onclick="show()" class="btn btn-primary">Предварительный
                                            просмотр
                                        </button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4" id="show"></div>
                </div>
            </div>
</main>