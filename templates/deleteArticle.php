<div class="col-6 container">
    <form method="post" action="index.php?route=deleteArticle" class="form-group">

        <p class="alert alert-light align-items-center font-italic mt-3 text-center">L'article nommé <span
                    class="font-weight-bold"><?= $this->request->getPost()->getParameter('title'); ?></span> sera
            définitivement supprimé, action irréversible, confirmez-vous?</p>

        <div class="form-group row justify-content-center">
            <input type="hidden" id="id" name="id" value="<?= $this->request->getPost()->getParameter('id'); ?>">
            <input type="submit" id="submit" name="submit" class="btn btn-warning mb-3 mt-3" value="Confirmer">
        </div>
    </form>
</div>