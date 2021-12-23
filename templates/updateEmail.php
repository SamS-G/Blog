<div class="d-flex justify-content-center mt-lg-5">
    <form method="post" action="index.php?route=updateEmail">
        <p class="alert alert-light align-items-center font-italic mt-3 text-center">L'adresse Email de <span
                    class="font-weight-bold"><?= $this->session->get('username'); ?></span> sera modifiée.
        </p>
        <div class="form-group row justify-content-center">
            <label for="email" class="font-weight-bold">Email</label>
            <?php $newEmail = $this->request->getPost()->getParameter('email') ?>
            <input required type="email" id="email" name="email" class="form-control text-center"
                   placeholder="Votre nouvelle adresse email" value="<?= isset($newEmail) ? $newEmail : '' ?>">
        </div>
        <div class="form-group row justify-content-center">
            <label class="font-weight-bold" for="confirm_email">Confirmation</label>
            <input required type="email" id="confirm_email" name="confirm_email" class="form-control text-center"
                   placeholder="Tapez email une deuxième fois">
        </div>
        <div class="form-group row justify-content-center">
            <small class="text-center">Après validation vous serez automatiquement déconnecté.</small>
            <div class="container text-center">
                <input type="submit" value="Valider" id="submit" name="submit" class="btn btn-primary mb-3 mt-3">
            </div>
        </div>
    </form>
</div>


