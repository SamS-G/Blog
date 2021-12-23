<div class="container d-flex flex-column mt-lg-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
            <p class="alert alert-light align-items-center font-italic mt-3 text-center">Le mot de passe de <span
                        class="font-weight-bold"><?= $this->session->get('username'); ?></span> sera modifié.</p>
        </div>
    </div>
    <form method="post" action="index.php?route=updatePassword">
        <div class="form-group row justify-content-center">
            <div class="col-lg-8 text-center">
                <label class="font-weight-bold" for="password">Nouveau mot de passe</label><br/>
                <input type="password" id="password" name="password" class="form-control text-center"
                       placeholder="8 caractères minimum, une majuscule, un nombre, un symbole">
            </div>
        </div>
        <div class="form-group row justify-content-center">
            <div class="col-lg-8 text-center">
                <label class="font-weight-bold" for="confirm_pass">Confirmation</label><br>
                <input type="password" id="confirm_pass" name="confirm_pass" class="form-control text-center"
                       placeholder="Tapez votre mot de passe une deuxième fois">
            </div>
        </div>


        <div class="form-group d-flex flex-column justify-content-center">
            <small class="text-center">Après validation vous serez automatiquement déconnecté.</small>
            <div class="container text-center">
                <input type="submit" value="Valider" id="submit" name="submit" class="btn btn-primary mb-3 mt-3">
            </div>
        </div>

        <a class=" row justify-content-center" href="../public/index.php?route=profil">Retour au profil</a>
    </form>
</div>


