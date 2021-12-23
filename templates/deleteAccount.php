<div class="col-4 container text-center">
    <p class="alert alert-light align-items-center font-italic mt-3">Le compte de <span
                class="font-weight-bold"><?= $_GET['username'] ?></span> sera
        définitivement supprimé, confirmez-vous ?</p>

    <form method="post" action="index.php?route=deleteAccount" class="form-group">
        <div class="form-group row justify-content-center">
            <input type="hidden" id="id" name="id" value="<?= $this->request->getPost()->getParameter('id'); ?>">
            <input type="submit" id="submit" name="submit" class="btn btn-warning mb-3 mt-3" value="Confirmer">
        </div>
    </form>
</div>





