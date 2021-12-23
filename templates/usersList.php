<div class="container mt-5">
    <h3 class="text-center mb-5">Liste des utilisateurs</h3>
    <table class="table table-responsive-sm">
        <thead>
        <tr class="text-center">
            <th scope="col">Pseudo</th>
            <th scope="col">Date</th>
            <th scope="col">Rôle</th>
            <th scope="col">Status</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>

        <tbody class="text-center">
        <?php
        foreach ($users as $user) {
            ?>
            <tr>
                <td><?= htmlspecialchars($user->getUsername()); ?></td>
                <?php $time = $user->getCreatedAt(); ?>
                <td><?= htmlspecialchars(date('d-m-Y H:i'), strtotime($time)); ?></td>

                <?php $role = $user->getRole();
                if ($role === '1') { ?>
                    <td>Administrateur</td>
                <?php } else { ?>
                    <td>Utilisateur</td>
                <?php } ?>

                <?php $status = $user->getStatus();
                if ($status === '1') { ?>
                    <td>Activé</td>
                <?php } else { ?>
                    <td>Bloqué</td>
                <?php } ?>

                <td>    <!--ACTIONS forms-->
                    <?php
                    if ((int)$user->getRole() === 0) {
                        ?>
                        <div class="row justify-content-center">

                            <form method="post" action="index.php?route=deleteAccount&username=<?=$user->getUsername()?>">
                                <input type="hidden" id="id" name="id" value="<?= $user->getId(); ?>">
                                <input type="submit" value="Supprimer" class="btn btn-primary mb-2">
                            </form>

                            <form method="post" action="index.php?route=banOrActiveUser">
                                <label for="ban"></label>
                                <input type="hidden" id="id" name="id" value="<?= $user->getId(); ?>">
                                <input type="hidden" id="status" name="status" value="<?= $user->getStatus(); ?>">
                                <button type="submit"
                                        class="btn btn-primary"><?= $user->getStatus() ? 'Bloquer' : 'Activer' ?></button>
                            </form>
                        </div>
                    <?php } else { ?>
                        <p>Suppression impossible</p>
                    <?php } ?>
                </td>   <!--END actions form-->
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<a class="row justify-content-center" href="../public/index.php?route=profile">Retour au profil</a>

