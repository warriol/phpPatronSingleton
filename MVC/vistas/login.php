<div class="container">
    <div class="row justify-content-center sidebar-dark">
        <div class="col-lg-6" id="logo">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo htmlspecialchars($_SERVER ["PHP_SELF"]); ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-book-reader"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Biblio<sup>teca</sup></div>
            </a>
        </div>
        <div class="col-lg-12">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="d-grid gap-2 mx-auto col-lg-8">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Iniciar Sesion</h1>
                            </div>
                            <div id="error">
                                <?php
                                if(isset($_GET['error'])) echo $_GET['error'];
                                ?>
                            </div>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER ["PHP_SELF"]); ?>" class="user">
                                <div class="form-group p-1">
                                    <input class="form-control form-control-user"
                                           id="usuario" name="usuario"
                                           placeholder="Escriba su usuario...." required="required">
                                </div>
                                <div class="form-group p-1">
                                    <input type="password" class="form-control form-control-user"
                                           id="password" name="password"
                                           placeholder="Password..." required="required">
                                </div>
                                <div class="d-grid gap-2 col-6 mx-auto p-1">
                                    <input type="submit" class="form-control btn btn-primary" id="enviar" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>