<div class="container mt-3">
    <h3 class="text-center mb-5">Commentaires signalés</h3>
    <table class="table table-responsive-sm">
        <thead>
        <tr class="text-center">
            <th scope="col">Pseudo</th>
            <th class="w-25" scope="col">Date</th>
            <th scope="col">Commentaire</th>
            <th class="w-25" scope="col">Actions</th>
        </tr>
        </thead>

        <tbody class="text-center">
        <?php
        foreach ($flags as $flag) {
            ?>
            <tr>
                <td class="align-middle"><?= htmlspecialchars($flag->getUsername()); ?></td>
                <?php $time = $flag->getCreatedAt(); ?>
                <td class="align-middle"><?= htmlspecialchars(date('d-m-Y H:i'), strtotime($time)); ?></td>
                <td class="align-middle"><?= htmlspecialchars($flag->getContent()); ?></td>
                <td>
                    <div class="d-lg-flex justify-content-center align-items-center">
                        <form class="mb-lg-4 mb-2 mr-lg-2 mr-1" method="post" action="index.php?route=moderatedComment">
                            <label for="moderated"></label>
                            <input type="hidden" id="id" name="id" value="<?= $flag->getId(); ?>">
                            <input type="hidden" id="flagged" name="flagged" value="<?= $flag->getFlagged(); ?>">
                            <input type="submit" value="Autoriser" class="btn btn-primary">
                        </form>

                        <form method="post" action="index.php?route=deleteComment">
                            <input type="hidden" id="id" name="id" value="<?= $flag->getId(); ?>">

                            <input type="submit" value="Supprimer" class="btn btn-primary ">
                        </form>
                    </div>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>