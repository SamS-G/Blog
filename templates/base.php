<!DOCTYPE html>
<html lang="fr">
<head>
    <script src="js/tinymce.min.js" referrerpolicy="origin"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: '#contents',
            language: 'fr',
        });
    </script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Blog">
    <meta name="author" content="Guichardon Samuel">
    <title>Blog de Jean Forteroche</title>

    <script defer src="https://use.fontawesome.com/releases/v5.7.1/js/all.js"
            integrity="sha384-eVEQC9zshBn0rFj4+TU78eNA19HMNigMviK/PU/FFjLXqa/GKPgX58rvt5Z8PLs7"
            crossorigin="anonymous"></script>
    <script src="js/jquery-3.4.1.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/bootstrap.js"></script>

    <link rel="stylesheet" href="css/theme-6.css">
</head>

<body>
<header class="header text-center">
    <h1 class="blog-name pt-lg-4 mb-0"><a href="../templates/home.php">Jean Forteroche</a></h1>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="navigation" class="collapse navbar-collapse flex-column">
            <div class="profile-section pt-3 pt-lg-0">
                <img class="profile-image mb-3 rounded-circle mx-auto" src="img/profile.png" alt="image">

                <div class="bio mb-3">Je suis un jeune écrivain et passionné de nouvelles technologies. J'ai publié mes
                    deux premiers romans en 2015 et 2016. Ecrivant régulièrement quelques nouvelles
                    pour des sites internets.
                    <br>
                    Pourquoi ne pas associer mes deux passions ? Ce blog est née, avec une idée, vous faire
                    partager l'écriture au fur et à mesure qu'elle prend forme dans mon esprit...
                </div>

                <ul class="social-list list-inline py-3 mx-auto">
                    <li class="list-inline-item"><a href="#"><i class="fab fa-twitter fa-fw"></i></a></li>
                    <li class="list-inline-item"><a href="#"><i class="fab fa-facebook"></i></a></li>
                </ul>
                <hr>
            </div>

            <ul class="navbar-nav flex-column text-sm-center text-lg-left text-sm-center">
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><i class="fas fa-home fa-fw mr-2"></i>Accueil du
                        blog<span class="sr-only">(current)</span></a>
                </li>
                <?php
                    if ($this->session->get('username') && $this->session->get('role') === 1) {
                    ?>
                    <li class="nav-item"><a class="nav-link" href="index.php?route=profil"><i
                                    class="far fa-address-card mr-2"></i>Profil</a></li>
                    <li>
                        <div class="btn-group dropup">
                            <button type="button" class="btn btn-primary dropdown-toggle"
                                    data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                Administration
                            </button>
                            <div class="dropdown-menu">
                                <a class=dropdown-item href="index.php?route=updatePassword">Modifier mon mot de
                                    passe</a>
                                <a class="dropdown-item" href="index.php?route=updateEmail">Modifier mon email</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="index.php?route=usersList">Liste des utilisateurs</a>
                                <a class="dropdown-item" href="index.php?route=flaggedComment">Commentaires à
                                    modérer</a>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="btn-group mt-2">
                            <button type="button" class="btn btn-primary dropdown-toggle "
                                    data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                Gestion des articles
                            </button>
                            <div class="dropdown-menu dropdown-menu-md-right">
                                <a class="dropdown-item" href="index.php?route=addArticle">Créer un nouvel article</a>
                                <a class="dropdown-item" href="index.php?route=articlesList">Liste des articles</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="index.php?route=logout"><i
                                    class="fas fa-sign-out-alt mr-2"></i>Déconnexion</a></li>

                    <?php
                } elseif ($this->session->get('role') === 0) {
                    ?>
                    <li class="nav-item"><a class="nav-link" href="index.php?route=profil"><i
                                    class="far fa-address-card mr-2"></i>Profil</a></li>
                    <li>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle "
                                    data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                Administration
                            </button>
                            <div class="dropdown-menu">
                                <a class=dropdown-item href="index.php?route=updatePassword">Modifier mon mot de
                                    passe</a>
                                <a class="dropdown-item" href="index.php?route=updateEmail">Modifier mon email</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="index.php?route=logout"><i
                                    class="fas fa-sign-out-alt mr-2"></i>Déconnexion</a></li>
                    <?php
                }
                    else {
                ?>
                <li class="nav-item"><a class="nav-link" href="index.php?route=login"><i
                                class="fas fa-sign-in-alt mr-2"></i>Connexion
                    </a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?route=register"><i
                                class="fas fa-user-plus mr-2"></i>Inscription</a>
                    <?php } ?>
                </li>
            </ul>
        </div>
    </nav>
</header>

<div class="main-wrapper">
    <section class="cta-section theme-bg-light py-5">
        <div class="container text-center">
            <h2 class="heading">Le blog de Jean Forteroche.</h2>
            <div class="intro font-italic"><q>Le premier livre publié au fur et à mesure de sa création !</q></div>
        </div>
    </section>
    <div class="container d-flex flex-column justify-content-center text-center mt-3">    <!--Start flash messages-->
        <?php $activation = $this->session->get('activate');
            if (isset($activation)) : ?>
                <p class="alert alert-info"><?= $this->session->show('activate'); ?></p>
            <?php endif; ?>

        <?php $errorUsername = $this->session->get('usernameDuplicate');
            if (isset($errorUsername)) : ?>
                <p class="alert alert-danger"><?= $this->session->show('usernameDuplicate'); ?></p>
            <?php endif; ?>

        <?php $errorUsername = $this->session->get('usernameConstraint');
            if (isset($errorUsername)) : ?>
                <p class="alert alert-danger"><?= $this->session->show('usernameConstraint'); ?></p>
            <?php endif; ?>

        <?php $errorContent = $this->session->get('articleValid');
            if (isset($errorContent)) : ?>
                <p class="alert alert-danger"><?= $this->session->show('articleValid'); ?></p>
            <?php endif; ?>

        <?php $account = $this->session->get('deletedAccount');
            if (isset($account)) : ?>
                <p class="alert alert-success"><?= $this->session->show('deletedAccount') ?></p>
            <?php endif; ?>

        <?php $welcome = $this->session->get('loginWelcome');
            if (isset($welcome)) : ?>
                <p class="alert alert-success"><i
                            class="far fa-laugh-beam fa-lg pr-2"></i><?= $this->session->show('loginWelcome'); ?></p>
            <?php endif; ?>

        <?php
            $login = $this->session->get('loginActive');
            if (isset($login)) : ?>
                <p class="alert alert-danger"><?= $this->session->show('loginActive'); ?></p>
            <?php endif; ?>

        <?php
            $login = $this->session->get('loginError');
            if (isset($login)) : ?>
                <p class="alert alert-danger"><?= $this->session->show('loginError'); ?></p>
            <?php endif; ?>

        <?php $status = $this->session->get('banOrAct');
            if (isset($status)) : ?>
                <p class="alert alert-success"><?= $this->session->show('banOrAct') ?></p>
            <?php endif; ?>

        <?php $article = $this->session->get('article');
            if (isset($article)) : ?>
                <p class="alert alert-success"><?= $this->session->show('article') ?></p>
            <?php endif; ?>

        <?php $logout = $this->session->get('logout');
            if (isset($logout)) : ?>
                <p class="alert alert-info"><?= $this->session->show('logout'); ?></p>
            <?php endif; ?>

        <?php $register = $this->session->get('register');
            if (isset($register)) : ?>
                <p class="container col-8 alert alert-success"><?= $this->session->show('register'); ?></p>
            <?php endif; ?>

        <?php $register = $this->session->get('register_error');
            if (isset($register)) : ?>
                <p class="alert alert-danger"><?= $this->session->show('register_error'); ?></p>
            <?php endif; ?>

        <?php $errorTitle = $this->session->get('titleLength');
            if (isset($errorTitle)) : ?>
                <p class="alert alert-danger"><?= $this->session->show('titleLength'); ?></p>
            <?php endif; ?>

        <?php $flag = $this->session->get('flagSuccess');
            if (isset($flag)) : ?>
                <p class="alert alert-success"><?= $this->session->show('flagSuccess'); ?></p>
            <?php endif; ?>

        <?php $comment = $this->session->get('flagConnect');
            if (isset($comment)) : ?>
                <p class="alert alert-danger"><?= $this->session->show('flagConnect'); ?></p>
            <?php endif; ?>

        <?php $flag = $this->session->get('flagConnectAdd');
            if (isset($flag)) : ?>
                <p class="alert alert-warning"><?= $this->session->show('flagConnectAdd'); ?></p>
            <?php endif; ?>

        <?php $moderated = $this->session->get('moderated');
            if (isset($moderated)) : ?>
                <p class="alert alert-success"><?= $this->session->show('moderated'); ?></p>
            <?php endif; ?>

        <?php $addComment = $this->session->get('addComment');
            if (isset($addComment)) : ?>
                <p class="alert alert-success"><?= $this->session->show('addComment'); ?></p>
            <?php endif; ?>

        <?php $addComment = $this->session->get('error_comment');
            if (isset($addComment)) : ?>
                <p class="alert alert-danger"><?= $this->session->show('error_comment'); ?></p>
            <?php endif; ?>

        <?php $deletedComment = $this->session->get('deletedComment');
            if (isset($deletedComment)) : ?>
                <p class="alert alert-success"><?= $this->session->show('deletedComment'); ?></p>
            <?php endif; ?>

        <?php $password = $this->session->get('passwordUpdate');
            if (isset($password)) : ?>
                <p class="alert alert-success"><?= $this->session->show('passwordUpdate'); ?></p>
            <?php endif; ?>

        <?php $password = $this->session->get('passwordRegex');
            if (isset($password)) : ?>
                <p class="alert alert-danger"><?= $this->session->show('passwordRegex'); ?></p>
            <?php endif; ?>

        <?php $password = $this->session->get('passwordDuplicate');
            if (isset($password)) : ?>
                <p class="alert alert-danger"><?= $this->session->show('passwordDuplicate'); ?></p>
            <?php endif; ?>

        <?php $errorPassword = $this->session->get('passwordError');
            if (isset($errorPassword)) : ?>
                <p class="alert alert-danger"><?= $this->session->show('passwordError'); ?></p>
            <?php endif; ?>

        <?php $errorEmail = $this->session->get('mailConstraint');
            if (isset($errorEmail)) : ?>
                <p class="alert alert-danger"><?= $this->session->show('mailConstraint'); ?></p>
            <?php endif; ?>

        <?php $email = $this->session->get('mailDuplicate');
            if (isset($email)) : ?>
                <p class="alert alert-danger"><?= $this->session->show('mailDuplicate'); ?></p>
            <?php endif; ?>

        <?php $email = $this->session->get('mailUpdate');
            if (isset($email)) : ?>
                <p class="alert alert-success"><?= $this->session->show('mailUpdate') ?></p>
            <?php endif; ?>

        <?php $email = $this->session->get('mailDuplicate');
            if (isset($email)) : ?>
                <p class="alert alert-danger"><?= $this->session->show('mailDuplicate'); ?></p>
            <?php endif; ?>
    </div>         <!--END flash messages-->

    <?= $content ?> <!--Templates-->


</body>
</html>

