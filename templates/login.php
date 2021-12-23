<div class="d-flex justify-content-center" sstyle="margin-left: 17%">
    <form class="mt-5" method="post" action="index.php?route=login">
        <div class="form-group row justify-content-center">
            <label class="font-weight-bold" for="username">Pseudonyme</label><br>
            <?php $username = $this->request->getPost()->getParameter('username'); ?>
            <input class="form-control" type="text" id="username" name="username"
                   value="<?= isset($username) ? $username : '' ?>">
        </div><!--END field-1-->

        <div class="form-group row justify-content-center">
            <label class="font-weight-bold" for="password">Mot de passe</label><br>
            <input class="form-control" type="password" id="password" name="password">
        </div><!--END field-2-->

        <div class="form-group row justify-content-center">
            <input class="btn btn-primary" type="submit" value="Connexion" id="submit" name="submit">
        </div><!--END form button-->
    </form>
</div>



