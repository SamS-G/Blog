<?php

    namespace App\src\controller;

    use App\config\Parameter;
    use Swift_Mailer;
    use Swift_Message;
    use Swift_SmtpTransport;

    class FrontController extends Controller
    {
        private $errors = 0;

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
         * @param Parameter $superGlobPost
         */
        public function register(Parameter $superGlobPost)
        {
            if ($superGlobPost->getParameter('submit')) {
                $this->validateUsername($superGlobPost);
                $this->validateEmail($superGlobPost);
                $this->validatePassword($superGlobPost);
                if ($this->errors === 0) {
                    $token = $this->generateToken(60);
                    $createdAt = new \DateTime();
                    $this->userDAO->register($superGlobPost, $createdAt->format('Y-m-d H:i'), $token);

                    $this->session->set('register', "Votre inscription s'est bien déroulée, pensez à activer votre compte");
                    $email_recipient = $superGlobPost->getParameter('email');
                    $user_id = $this->userDAO->lastId();
                    $this->sendMail($token, $email_recipient, $user_id);
                    header("Location: ../public/index.php");
                    exit();
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
         * Vérifie que les contraintes de longueurs et d'unicité soient respectées pour le nom d'utilisateur
         * @param Parameter $superGlobPost
         */
        private function validateUsername(Parameter $superGlobPost)
        {
            $result = $this->validation->validate('username', $superGlobPost, 'username');

            if ($result['usernameDuplicate']) {
                $this->session->set('usernameDuplicate', "Nom d'utilisateur déjà utilisé");
                $this->errors++;
            } elseif ($result['username']['max'] + $result['username']['min'] > 0) {
                $this->session->set('usernameConstraint', "Le nom d'utilisateur ne respect pas les contraintes de longueur");
                $this->errors++;
            }
        }

        /**
         * Vérifie que les contraintes de longueurs et d'unicité soient respectées pour l'adresse mail
         * @param Parameter $superGlobPost
         */
        private function validateEmail(Parameter $superGlobPost)
        {
            $result = $this->validation->validate('email', $superGlobPost, 'email');

            if ($result['email']['max'] + $result['email']['min'] > 0) {
                $this->session->set('mailConstraint', "L'email ne respect pas les contraintes, min 5, max 255 caractères");
                $this->errors++;
            } elseif ($result['emailDuplicate']) {
                $this->session->set('mailDuplicate', "Cet email est déjà utilisé !");
                $this->errors++;
            }
        }

        /**
         * Vérifie que les contraintes de longueur et de format soient respectées pour le mot de passe
         * @param Parameter $superGlobPost
         */
        private function validatePassword(Parameter $superGlobPost)
        {
            $result = $this->validation->validate('password', $superGlobPost, 'password');
            if (!empty($result['password']['regex'])) {
                $this->session->set('passwordRegex', "Le mots de passe ne respect pas les contraintes");
                $this->errors++;
            } elseif ($superGlobPost->getParameter('password') != $superGlobPost->getParameter('confirm_pass')) {
                $this->session->set('passwordDuplicate', "Les deux mots de passe ne sont pas identiques");
                $this->errors++;
            }
        }

        /**
         * Génère le Token utilisé pour la validation de l'adresse mail
         * @param $length
         * @return false|string
         */
        private function generateToken($length)
        {
            $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
            return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
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
         * @param Parameter $getData
         */
        public function validateAccount(Parameter $getData)
        {
            $dbToken = $this->userDAO->getToken($getData->getParameter('id'));
            if ($getData->getParameter('token') === $dbToken['token']) {
                $this->userDAO->activateAccount($getData->getParameter('id'));
                $this->session->set('activate', 'Votre compte a bien été activé, vous pouvez vous connecter immédiatement');
            } else {
                $this->session->set('activate', "Erreur dans l'activation de votre compte, veuillez contacter l'administrateur");
            }
            header('Location:../public/index.php');
            exit();
        }

        /**
         * Permet à un utilisateur de se loguer
         * @param Parameter $superGlobalData
         */
        public function login(Parameter $superGlobalData)
        {
            if ($superGlobalData->getParameter('submit')) {
                $sqlResult = $this->userDAO->login($superGlobalData);
                $passwordEnter = $superGlobalData->getParameter('password');

                if (password_verify($passwordEnter, $sqlResult['password']) && $sqlResult['status'] === '1') {
                    $this->session->set('loginWelcome', 'Content de vous revoir !');
                    $this->session->set('id', $sqlResult['id']);
                    $this->session->set('email', $sqlResult['email']);
                    $this->session->set('status', (int)$sqlResult['status']);
                    $this->session->set('username', $superGlobalData->getParameter('username'));
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
         * @param Parameter $getData
         */
        public function flagComment(Parameter $getData)
        {
            if (!empty($this->session->get('username'))) {
                $commentId = $getData->getParameter('id');
                $this->commentDAO->flagOrAllowComment($commentId, 1);
                $this->session->set('flagSuccess', 'Le commentaire a bien été signalé');
            } else {
                $this->session->set('flagConnect', 'Vous devez être connecté pour signaler un commentaire.');
            }
            $this->singleArticle($getData);
        }

        /**
         * Gère l'affichage d'un article en particulier
         * @param Parameter $articleId
         */
        public function singleArticle(Parameter $articleId)
        {
            $id = $articleId->getParameter('ArticleId');
            $singleArticle = $this->articleDAO->getArticle($id);
            $comments = $this->commentDAO->getComments($id);
            $this->view->render('singleArticle', [
                'singleArticle' => $singleArticle,
                'comments' => $comments]);
        }

        /**
         * Permet d'ajouter un commentaire à un article
         * @param Parameter $postData
         */
        public function addComment(Parameter $postData)
        {
            if ($postData->getParameter('submit')) {
                if (!empty($this->session->get('username'))) {
                    $checkError = $this->validation->validate('comment', $postData, 'content');

                    if (array_sum($checkError['content']) === 0) {
                        $article_id = $postData->getParameter('ArticleId');
                        $user_id = $this->session->get('id');
                        $time = new \DateTime();
                        $created_at = $time->format('Y-m-d H:i');
                        $content = $postData->getParameter('content');
                        $this->commentDAO->addComment($article_id, $user_id, $created_at, $content);
                        $this->session->set('addComment', "Votre commentaire a bien été ajouté, merci !");
                        header('Location:../public/index.php');
                        exit();
                    } else {
                        $this->session->set('error_comment', "Vérifiez que le champ ne soit pas vide ou ne dépasse pas les 255 caractères");
                        header('Location:../public/index.php');
                        exit();
                    }
                } else {
                    $this->session->set('flagConnectAdd', "Vous devez être connecté pour ajouter un commentaire.");
                    header('Location:../public/index.php');
                    exit();
                }
            }
        }

        /**
         * Assure la validation des contraintes définies sur le contenu
         * @param Parameter $postData
         */
        private function validateContent(Parameter $postData)
        {
            $contentValidation = $this->validation->validate('content', $postData, 'content');
            if (!empty($contentValidation['content']['blank'])) {
                $this->session->set('contentBlank', "Le champ 'contenu' ne peut être vide !");
                $this->errors++;
            }
        }
    }





