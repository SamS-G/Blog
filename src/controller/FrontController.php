<?php

    namespace App\src\controller;

    use App\config\Post;
    use App\src\model\Comment;
    use App\src\model\User;
    use DateTime;
    use Swift_Mailer;
    use Swift_Message;
    use Swift_SmtpTransport;

    class FrontController extends Controller
    {
        /**
         * Affiche les articles publiés par ordre chronologique
         */
        public function home()
        {
            $articles = $this->articleDAO->getArticlesList();
            $this->view->render('home', [
                'articles' => $articles
            ]);
        }

        /**
         * Permet à un nouvel utilisateur de s'enregistrer et laisser des commentaires
         * @param Post $post
         * @param User $user
         */
        public function register(Post $post, User $user)
        {
            if ($post->getPostParam('submit')) {
                $user->validateUsername($post);
                $user->validateEmail($post);
                $user->validatePassword($post);

                if (isset($errors) && $errors === 0) {
                    $token = $this->generateToken();
                    $createdAt = new DateTime();
                    $this->userDAO->register($post, $createdAt->format('Y-m-d H:i'), $token);
                    $this->session->set('register', "Votre inscription s'est bien déroulée, pensez à activer votre compte");
                    $email_recipient = $post->getPostParam('email');
                    $user_id = $this->userDAO->lastId();
                    $this->sendMail($token, $email_recipient, $user_id);
                    header("Location: ../public/index.php");
                } else {
                    $this->session->set('register_error', "Une erreur est survenu dans votre inscription, veuillez recommencer");
                    header("Location: ../public/index.php?route=register");
                    exit();
                }
            } else {
                $this->view->render('register');
            }
        }

        /**
         * Génère le Token utilisé pour la validation de l'adresse mail
         * @return false|string
         */
        private function generateToken()
        {
            $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
            return substr(str_shuffle(str_repeat($alphabet, 60)), 0, 60);
        }

        /**
         * Envoi le courrier électronique validant l'adresse mail
         * @param $value
         * @param $email
         * @param $user_id
         */
        private function sendMail($value, $email, $user_id)
        {
            $subject = 'Activation de votre compte';
            $fromEmail = 'jeanforteroche@gmail.com';
            $fromUser = 'Jean Forteroche';
            $token = $value;
            $recipient = $email;
            $userId = $user_id['id'];
            $url = "blog/public/index.php?route=confirm&token=$token&id=$userId";
            $body = '<!DOCTYPE html>
<html lang="FR">
<head>
	<title>Mon premier mail</title>
</head>
<body>
    <h1>Bienvenu !</h1>
    <p>Bonjour,<br>
Vous venez de vous inscrire sur le blog de Jean Forteroche, le premier livre publié pendant sa création ! <br>

Validez votre inscription en cliquant sur ce lien ou en le copiant/collant dans la barre de votre navigateur :<br>
  <a href="' . $url . '">Activer mon compte</a><br>

A bientôt pour suivre l\'histoire de mon dernier roman : Hiver Arctique
</p>
</body>
</html>';
            $transport = (new Swift_SmtpTransport(EMAIL_HOST, EMAIL_PORT))
                ->setUsername(EMAIL_USERNAME)
                ->setPassword(EMAIL_PASSWORD)
                ->setEncryption(EMAIL_ENCRYPTION);
            $mailer = new Swift_Mailer($transport);
            $message = (new Swift_Message($subject))
                ->setFrom([$fromEmail => $fromUser])
                ->setTo([$recipient])
                ->setBody($body, 'text/html');
            $mailer->send($message);
        }

        /**
         * Valide l'email de l'utilisateur
         * @param Post $getData
         */
        public function validateAccount(Post $getData)
        {
            $dbToken = $this->userDAO->getToken($getData->getPostParam('id'));
            if ($getData->getPostParam('token') === $dbToken['token']) {
                $this->userDAO->activateAccount($getData->getPostParam('id'));
                $this->session->set('activate', 'Votre compte a bien été activé, vous pouvez vous connecter immédiatement');
            } else {
                $this->session->set('activate', "Erreur dans l'activation de votre compte, veuillez contacter l'administrateur");
            }
            header('Location:../public/index.php');
            exit();
        }

        /**
         * Permet à un utilisateur de se loguer
         * @param Post $postData
         */
        public function login(Post $postData)
        {
            if ($postData->getPostParam('submit')) {
                $sqlResult = $this->userDAO->login($postData);
                $passwordEnter = $postData->getPostParam('password');

                if (password_verify($passwordEnter, $sqlResult['password']) && $sqlResult['status'] === '1') {
                    $this->session->set('loginWelcome', 'Content de vous revoir !');
                    $this->session->set('id', $sqlResult['id']);
                    $this->session->set('email', $sqlResult['email']);
                    $this->session->set('status', (int)$sqlResult['status']);
                    $this->session->set('username', $postData->getPostParam('username'));
                    $this->session->set('role', (int)$sqlResult['role']);
                    header('Location:../public/index.php');
                    exit();
                } elseif (!$sqlResult['status']) {
                    $this->session->set('loginActive', "Votre compte n'est pas activé ou vous avez été banni. Contactez l'administrateur");
                } else {
                    $this->session->set('loginError', "Le pseudo ou le mot de passe sont incorrects");
                }
            }
            $this->view->render('login');
        }

        /**
         * Permet de signaler un commentaire jugé inapproprié
         * @param Post $postData
         */
        public function flagComment(Post $postData)
        {
            if (!empty($this->session->get('username'))) {
                $commentId = $postData->getPostParam('id');
                $this->commentDAO->flagOrAllowComment($commentId, 1);
                $this->session->set('flagSuccess', 'Le commentaire a bien été signalé');
            } else {
                $this->session->set('flagConnect', 'Vous devez être connecté pour signaler un commentaire.');
            }
            $this->singleArticle($postData);
        }

        /**
         * Gère l'affichage d'un article en particulier
         * @param Post $postData
         */
        public function singleArticle(Post $postData)
        {
            $id = $postData->getPostParam('ArticleId');
            $singleArticle = $this->articleDAO->getArticle($id);
            $comments = $this->commentDAO->getComments($id);
            $this->view->render('singleArticle', [
                'singleArticle' => $singleArticle,
                'comments' => $comments]);
        }

        /**
         * Permet d'ajouter un commentaire à un article
         * @param Post $postData
         */
        public function addComment(Post $postData, Comment $comment)
        {
            if ($postData->getPostParam('submit')) {
                if (!empty($this->session->get('username'))) {
                    $checkError = $comment->$comment->validate('comment', $postData, 'content');

                    if (array_sum($checkError['content']) === 0) {
                        $article_id = $postData->getPostParam('ArticleId');
                        $user_id = $this->session->get('id');
                        $time = new DateTime();
                        $created_at = $time->format('Y-m-d H:i');
                        $content = $postData->getPostParam('content');
                        $this->commentDAO->addComment($article_id, $user_id, $created_at, $content);
                        $this->session->set('addComment', "Votre commentaire a bien été ajouté, merci !");

                    } else {
                        $this->session->set('error_comment', "Vérifiez que le champ ne soit pas vide ou ne dépasse pas les 255 caractères");
                    }
                } else {
                    $this->session->set('flagConnectAdd', "Vous devez être connecté pour ajouter un commentaire.");
                }
                header('Location:../public/index.php');
                exit();
            }
        }
    }





