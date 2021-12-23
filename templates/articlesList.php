<div class="container-fluid mt-5">
    <h3 class="text-center mb-5">Liste des articles</h3>
    <table class="table table-responsive-sm">
        <thead>
        <tr class="text-center">
            <th scope="col">Titre</th>
            <th scope="col">Contenu</th>
            <th scope="col">Date de création</th>
            <th scope="col">Mis à jour le</th>
            <th scope="col">Publié</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>

        <tbody class="text-center">
        <?php
        foreach ($articles as $article) {
            ?>
            <tr>
                <td><?= substr(strip_tags($article->getTitle()), 0, 30); ?></td>
                <td><?= substr(strip_tags($article->getContent()), 0, 100); ?></td>
                <?php $createdTime = $article->getCreatedAt(); ?>
                <td><?= htmlspecialchars(date('d-m-Y H:i', strtotime($createdTime))); ?></td>
                <?php $updateTime = $article->getUpdatedAt() ?>
                <td><?= htmlspecialchars(isset($updateTime) ? date('d-m-Y H:i', strtotime($updateTime)) : ''); ?></td>
                <td><?php $published = $article->getPublished(); ?>
                    <?= $published === '1' ? htmlspecialchars('Oui') : htmlspecialchars('Non'); ?></td>

                <td>
                    <div class="d-lg-flex">
                        <a role="button" class="btn btn-primary mb-2 mr-lg-3"
                           href="index.php?route=editArticle&id=<?= $article->getId(); ?>">Editer</a>

                        <form method="post" action="index.php?route=deleteArticle">
                            <input type="hidden" id="title" name="title" value="<?= $article->getTitle(); ?>">
                            <input type="hidden" id="id" name="id" value="<?= $article->getId(); ?>">

                            <input type="submit" value="Supprimer" class="btn btn-primary">
                        </form>
                    </div>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
