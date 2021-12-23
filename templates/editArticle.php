<?php $flag = $this->session->get('title');
if (isset($flag)) : ?>
    <p class="alert alert-success text-center mt-3"><?= $this->session->show('title'); ?></p>
<?php endif; ?>

<?php $flag = $this->session->get('content');
if (isset($flag)) : ?>
    <p class="alert alert-success text-center mt-3"><?= $this->session->show('content'); ?></p>
<?php endif; ?>

<form class="mt-3 d-flex flex-column" method="post" action="index.php?route=editArticle">
    <div class="container col-5 text-center">
        <label class="font-weight-bold" for="title">Titre</label>
        <?php $title = $postData->getParameter('title'); ?>
        <?php $titleEdited = $this->request->getPost()->getParameter('title'); ?>
        <input id="title" class="form-control text-center" type="text" name="title"
               value="<?= isset($title) ? $title : $titleEdited ?>">
    </div>

    <div class="container-fluid text-center mt-2">
        <label class="font-weight-bold" for="contents">Contenu</label>
        <?php $content = $postData->getParameter('contents'); ?>
        <textarea minlength="6" rows="20" id="contents"
                  name="contents"><?= isset($content) ? $content : '' ?></textarea>
    </div>

    <div class="form-group container col-10 text-center">
        <div class="d-flex justify-content-center">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="published" id="published" value="1">
                <label class="form-check-label" for="published">
                    Mettre à jour et publier
                </label>
            </div>

            <div class="form-check ml-4">
                <input class="form-check-input" type="radio" name="published" id="published" value="0" checked>
                <label class="form-check-label" for="published">
                    Mettre à jour et sauvegarder
                </label>
            </div>
        </div>
        <input type="hidden" name="id" id="id" value="<?= $postData->getParameter('id') ?>">
        <input type="submit" value="Valider" id="submit" name="submit" class="btn btn-primary mt-4">
    </div>
</form>
<div class="container text-center">
    <a class="text-center" href="../public/index.php?route=articlesList">Retour à la liste des articles</a>
</div>

