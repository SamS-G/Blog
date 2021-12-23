<div class="d-flex justify-content-center mt-lg-5">
    <form class="col-lg-3" method="post" action="index.php?route=register">
        <div class="form-group row justify-content-center">
            <label class="font-weight-bold" for="username">Pseudo</label>
            <?php $username = $this->request->getPost()->getParameter('username'); ?>
            <input type="text" class="form-control form-control-sm text-center" id="username" name="username"
                   value="<?= isset($username) ? $username : '' ?>"
                   placeholder="Min 6 caractères et max 48">
        </div><!--END form input-1-->
        <div class="form-group row justify-content-center">
            <label class="font-weight-bold" for="password">Mot de passe</label>
            <input type="password" id="password" name="password" class="form-control form-control-sm text-center"
                   placeholder="8 caractères mini, 1 majuscule, 1 nombre, 1 symbole">
        </div><!--END form input-2-->
        <div class="form-group row justify-content-center">
            <label class="font-weight-bold" for="confirm_pass">Confirmation</label>
            <input type="password" id="confirm_pass" name="confirm_pass"
                   class="form-control form-control-sm text-center"
                   placeholder="Tapez le une deuxième fois">
        </div><!--END form input-3-->
        <div class="form-group row justify-content-center">
            <label class="font-weight-bold" for="email">Email</label>
            <?php $email = $this->request->getPost()->getParameter('email'); ?>
            <input type="email" id="email" name="email" class="form-control form-control-sm text-center"
                   value="<?= isset($email) ? $email : '' ?>" placeholder="Votre adresse de courrier électronique">
        </div><!--END form input-4-->
        <div class="form-group row justify-content-center">
            <input type="submit" value="Inscription" id="submit" name="submit" class="btn btn-primary">
        </div><!--END form-button-->
    </form>
</div>




