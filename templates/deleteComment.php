<div class="col-4 container text-center">
    <p class="alert alert-light align-items-center font-italic mt-3">Ce commentaire sera
        définitivement supprimé, confirmez-vous ?</p>

    <form method="post" action="index.php?route=deleteComment" class="form-group">
        <input type="hidden" name="id" id="id"
               value="<?= $this->request->getPost()->getParameter('id') ?>">
        <div class="form-group row justify-content-center">
            <input type="submit" id="submit" name="submit" value="Confirmer" class="btn btn-warning mb-3 mt-3">
        </div>
    </form>

    <a href="index.php?route=flaggedComment">Retour à la liste des commentaires</a>
</div>
