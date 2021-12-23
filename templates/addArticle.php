<form class="mt-3 d-flex flex-column" method="post" action="index.php?route=addArticle">

    <div class="container col-5 text-center">
        <label class="font-weight-bold" for="title">Titre</label><br>
        <?php $title = $this->request->getPost()->getParameter('title'); ?>
        <input id="title" class="form-control text-center" type="text" name="title" value="<?= isset($title) ? $title : '' ?>">
    </div>

    <div class="container-fluid text-center">
        <label class="font-weight-bold mt-3 mb-3" for="contents">Contenu</label><br>
        <textarea rows="30" id="contents" name="contents"></textarea>
    </div>

    <div class="form-group container col-10 text-center">
        <div class="d-flex justify-content-center">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="published" id="published" value="1">
                <label class="form-check-label" for="published">
                    Publier l'article
                </label>
            </div>

            <div class="form-check ml-4">
                <input class="form-check-input" type="radio" name="published" id="published" value="0" checked>
                <label class="form-check-label" for="published">
                    Ne pas publier et sauvegarder
                </label>
            </div>
        </div>
        <input type="submit" value="Valider" id="submit" name="submit" class="btn btn-primary mt-4">
    </div>
    <a class="text-center" href="../public/index.php?route=articlesList">Aller à la liste des articles</a>
</form>