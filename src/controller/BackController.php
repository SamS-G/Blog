<?php

    namespace App\src\controller;

    use App\config\Parameter;


    class BackController extends Controller
    {
        private $errors = 0;

        /**
         * Affiche du profil de l'utilisateur
         */
        public function profile()
        {
            if ($this->checkLoggedIn()) {
                $this->view->render('profil');
            }
        }

        /**
         * Vérifie que l'utilisateur soit logué
         * @return bool
         */
        public function checkLoggedIn()
        {
            if ($this->session->get('username')) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Affiche les articles
         */
        public function articlesManagement()
        {
            if ($this->checkLoggedIn()) {
                $this->view->render('articlesManagement');
            }
        }

        /**
         * Permet de mettre à jour le mot de passe du compte
         * @param Parameter $superGlobalData
         */
        public function updatePassword(Parameter $superGlobalData)
        {
            if ($superGlobalData->getParameter('submit')) {
                if ($this->checkLoggedIn()) {
                    $this->validatePassword($superGlobalData);

                    if ($this->errors === 0) {
                        $this->userDAO->updatePassword($superGlobalData, $this->session->get('username'));

                        header('Location:../public/index.php?route=logout');
                        exit();
                    }
                }
            }
            $this->view->render('updatePassword');
        }

        /**
         * Permet de s'assurer que le mot de passe respecte les contraintes définies
         * @param Parameter $superGlobalData
         */
        private function validatePassword(Parameter $superGlobalData)
        {
            $validationData = $this->validation->validate('updatepassword', $superGlobalData, 'password');

            if (!empty($validationData['regex'])) {
                $this->session->set('passwordError', "Le mots de passe ne respect pas les contraintes");
                $this->errors++;

            } elseif ($superGlobalData->getParameter('password') != $superGlobalData->getParameter('confirm_pass')) {
                $this->session->set('passwordDuplicate', "Les deux mots de passe ne sont pas identiques");
                $this->errors++;
            }
        }

        /**
         * Permet de mettre à jour l'adresse mail du compte utilisateur
         * @param Parameter $superGlobalData
         */
        public function updateEmail(Parameter $superGlobalData)
        {
            if ($superGlobalData->getParameter('submit')) {
                if ($this->checkLoggedIn()) {
                    $this->validateEmail($superGlobalData);
                    if ($this->errors === 0) {
                        $email = $superGlobalData->getParameter('email');
                        $this->userDAO->updateEmail($this->session->get('username'), $email);
                        header('Location:../public/index.php?route=logout');
                        exit();

                    } else {
                        header('Location:../public/index.php?route=updateEmail');
                        exit();
                    }
                }
            } else {
                $this->view->render('updateEmail');
            }
        }

        /**
         * Permet de valider la mise à jour de l'adresse mail du compte utilisateur
         * @param Parameter $superGlobalData
         */
        private function validateEmail(Parameter $superGlobalData)
        {
            $validated = $this->validation->validate('updatemail', $superGlobalData, 'email');

            if ($validated['email']['max'] + $validated['email']['min'] > 0) {
                $this->session->set('mailConstraint', "L'adresse mail ne respect pas les contraintes de longueur");
                $this->errors++;

            } elseif ($validated['emailDuplicate']['email'] === $superGlobalData->getParameter('email')) {
                $this->session->set('mailDuplicate', "Cette adresse mail est déjà utilisé !");
                $this->errors++;

            } elseif ($superGlobalData->getParameter('email') != $superGlobalData->getParameter('confirm_email')) {
                $this->session->set('mailDuplicate', "Les deux adresses email ne correspondent pas");
                $this->errors++;
            }
        }

        /**
         * Permet de supprimer le compte d'un utilisateur (admin uniquement)
         * @param Parameter $postData
         */
        public function deleteAccount(Parameter $postData)
        {
            if ($postData->getParameter('submit')) {
                if ($this->checkLoggedIn() && $this->session->get('role') === 1) {
                    $this->userDAO->deleteAccount($postData->getParameter('id'));
                    $this->session->set('deletedAccount', "Le compte a bien été supprimé");
                    header('Location:../public/index.php?route=usersList');
                    exit();

                } elseif ($this->checkLoggedIn() && $this->session->get('role') === 0) {
                    $this->userDAO->deleteAccount($this->session->get('id'));
                    $this->logout();
                    header('Location:../public/index.php');
                    exit();
                }
            }
            $this->view->render('deleteAccount');
        }

        /**
         * Permet de se déconnecter
         */
        public function logout()
        {
            $this->session->stop();
            $this->session->start();
            $this->session->set('logout', 'A bientôt !');
            header('Location:../public/index.php');
            exit();
        }

        /**
         * Permet d'afficher la liste des utilisateurs inscrits
         */
        public function getUsersList()
        {
            $users = $this->userDAO->getUsersList();
            $this->view->render('usersList', [
                'users' => $users
            ]);
        }

        /**
         * Permet d'activer ou désactiver le compte d'un utilisateur (admin uniquement, 0 = compte désactivé, 1 = compte désactivé)
         * @param Parameter $postData
         */
        public function banOrActiveUser(Parameter $postData)
        {
            if ($this->checkLoggedIn() && $this->session->get('role') === 1) {
                if ($postData->getParameter('status') === '1') {
                    $this->userDAO->banOrActiveUser($postData->getParameter('id'), 0);
                    $this->session->set('banOrAct', "L'utilisateur à été bloqué.");
                } else {
                    $this->userDAO->banOrActiveUser($postData->getParameter('id'), 1);
                    $this->session->set('banOrAct', "L'utilisateur à été débloqué.");
                }
                header('Location:../public/index.php?route=usersList');
                exit();
            } else {
                $this->session->set('banOrAct', "Vous n'avez pas les droits d'effectuer cette action.");
                header('Location:../public/index.php?route=usersList');
                exit();
            }
        }

        /**
         * Permet d'ajouter un nouvel article
         * @param Parameter $postData
         */
        public function addArticle(Parameter $postData)
        {
            if ($postData->getParameter('submit')) {
                $this->validateArticle($postData);
                if ($this->errors === 0) {
                    $time = new \DateTime();
                    $created_at = $time->format('Y-m-d H:i');
                    $user_id = $this->session->get('id');
                    $this->articleDAO->addArticle($postData, $created_at, $user_id);
                    if ($postData->getParameter('published') === '1') {
                        $this->session->set('article', "Votre article a bien été publié");
                        header('Location:../public/index.php?route=articlesList');
                        exit();
                    } else {
                        $this->session->set('article', "Votre article à bien été sauvegardé");
                        header('Location:../public/index.php?route=articlesList');
                        exit();
                    }
                }
            }
            $this->view->render('addArticle');
        }

        /**
         * Permet de valider les contraintes appliquées sur le l'article
         * @param Parameter $postData
         */
        private function validateArticle(Parameter $postData)
        {
            $titleValidation = $this->validation->validate('title', $postData, 'title');
            $contentValidation = $this->validation->validate('content', $postData, 'contents');

            if (!empty($titleValidation['title']['min'] + $titleValidation['title']['max'])) {
                $this->session->set('articleValid', "Le titre ne respect pas les contraintes, minimum 6 caractères, max 255.");
                $this->errors++;
            } elseif (!empty($contentValidation['contents']['blank'])) {
                $this->session->set('articleValid', "Le contenu ne peut être vide, minimum 6 caractères.");
                $this->errors++;
            }
        }

        /**
         * Permet d'afficher la liste des articles
         */
        public function getArticlesList()
        {
            $articles = $this->articleDAO->getArticlesList();
            $this->view->render('articlesList', [
                'articles' => $articles
            ]);
        }

        /**
         * Permet d'éditer le contenu d'un article
         * @param Parameter $postData
         * @param Parameter $getData
         */
        public function editArticle(Parameter $postData, Parameter $getData)
        {
            if ($postData->getParameter('submit')) {
                if ($this->checkLoggedIn() && $this->session->get('role') === 1) {
                    $this->validateArticle($postData);
                    if ($this->errors === 0) {
                        $time = new \DateTime();
                        $updated_at = $time->format('Y-m-d H:i');
                        $article_id = $postData->getParameter('id');
                        $this->articleDAO->updateArticle($postData, $updated_at, $article_id);

                        if ($postData->getParameter('published') === '1') {
                            $this->session->set('article', "Votre article à bien été mis à jour et publié");
                        } else {
                            $this->session->set('article', "Votre article a bien été mis à jour et sauvegardé");
                        }
                        header('Location:../public/index.php?route=articlesList');
                        exit();
                    }

                } else {
                    $this->session->set('article', "Vous n'avez pas les droits d'effectuer cette action.");
                    header('Location:../public/index.php');
                    exit();

                }
            } else {
                $id = $getData->getParameter('id');
                $articleObject = $this->articleDAO->getArticle($id);
                $postData->setParameter('id', $articleObject->getId());
                $postData->setParameter('title', $articleObject->getTitle());
                $postData->setParameter('contents', $articleObject->getContent());
                $postData->setParameter('created_at', $articleObject->getCreatedAt());
                $postData->setParameter('updated_at', $articleObject->getUpdatedAt());
                $postData->setParameter('published', $articleObject->getPublished());
                $this->view->render('editArticle', ['postData' => $postData]);
            }
        }

        /**
         * Permet de supprimer un article
         * @param Parameter $postData
         */
        public function deleteArticle(Parameter $postData)
        {
            if ($postData->getParameter('submit')) {
                if ($this->checkLoggedIn() && $this->session->get('role') === 1) {
                    $this->articleDAO->deleteArticle($postData->getParameter('id'));
                    $this->session->set('article', 'Votre article à bien été supprimé');
                    header('Location:../public/index.php?route=articlesList');
                    exit();
                } else {
                    $this->session->set('article', "Vous n'avez pas les droits pour effectuer cette action");
                    header('Location:../public/index.php?route=articlesList');
                    exit();
                }
            }
            $this->view->render('deleteArticle');
        }

        /**
         * Permet de récupérer la liste des articles signalés
         */
        public function getFlaggedComment()
        {
            $this->view->render('flagList', [
                'flags' => $this->commentDAO->getFlaggedComments()
            ]);
        }

        /**
         * Permet de bloquer ou débloquer l'affichage d'un commentaire (admin)
         * @param Parameter $postData
         */
        public function moderatedComment(Parameter $postData)
        {
            if ($this->checkLoggedIn() && $this->session->get('role') === 1) {
                $commentId = $postData->getParameter('id');
                $this->commentDAO->flagOrAllowComment($commentId, 0);
                $this->session->set('moderated', 'Le commentaire est débloqué');
                header('Location:../public/index.php?route=flaggedComment');
                exit();
            } else {
                $this->session->set('moderated', "Vous n'avez pas les droits pour effectuer cette action");
                header('Location:../public/index.php?route=flaggedComment');
                exit();
            }
        }

        /**
         * Permet de supprimer un commentaire(admin)
         * @param Parameter $postData
         */
        public function deleteComment(Parameter $postData)
        {
            if ($postData->getParameter('submit')) {
                if ($this->checkLoggedIn() && $this->session->get('role') === 1) {
                    $this->commentDAO->deleteComment($postData->getParameter('id'));
                    $this->session->set('deletedComment', 'Le commentaire à bien été supprimé');
                    header('Location:../public/index.php?route=flaggedComment');
                    exit();
                } else {
                    $this->session->set('deletedComment', "Vous n'avez pas les droits pour effectuer cette action");
                    header('Location:../public/index.php?route=flaggedComment');
                    exit();
                }
            }
            $this->view->render('deleteComment');
        }
    }