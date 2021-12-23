<div class="container-fluid text-center"><!--article display -->
    <h3 class="mt-4 mb-3"><?= htmlspecialchars($singleArticle->getTitle()); ?></a></h3>
    <p><?= $singleArticle->getContent(); ?></p>
    <p class="font-italic mt-2">Jean Forteroche</p>
    <?php $createdDate = $singleArticle->getCreatedAt(); ?>
    <p><small>Créer
            le: <?= htmlspecialchars(isset($createdDate) ? date('d-m-Y H:i', strtotime($createdDate)) : ''); ?></small>
    </p>
    <?php $updatedDate = $singleArticle->getUpdatedAt(); ?>
    <p><small>Mis à jour
            le: <?= htmlspecialchars(isset($updatedDate) ? date('d-m-Y H:i', strtotime($updatedDate)) : ''); ?></small>
    </p>

    <form class="mt-3 d-flex flex-column" method="post" action="index.php?route=addComment"> <!--NEW comment-->
        <div class="container col-8">
            <label class="font-weight-bold mt-5 mb-3" for="content">Ajouter un commentaire</label><br>
            <textarea class="col-10" rows="10" id="content" name="content"></textarea><br>
            <input type="hidden" name="ArticleId" id="ArticleId"
                   value="<?= $this->request->getGet()->getParameter('ArticleId') ?>">
            <input type="submit" value="Valider" id="submit" name="submit" class="btn btn-primary mt-4 mb-5">
        </div>
    </form>

    <h5 class="text-center mb-5 mt-5">Commentaires de l'article</h5>
    <?php foreach ($comments as $comment) { ?>  <!--START comments display -->
        <?php if ($comment->getFlagged() === '0') { ?>
            <?php $createdTime = $comment->getCreatedAt(); ?>
            <ul class="list-group list-group-flush">
                <?php $username = $comment->getUsername(); ?>
                <li class="list-group-item d-flex justify-content-around"><span><span
                                class="font-weight-bold"><?= isset($username) ? $username : 'Anonyme' ?></span><span
                                class="font-italic pr-5"> a écris le <?= htmlspecialchars(date('d-m-Y', strtotime($createdTime))); ?></span></span>
                    <a href="index.php?route=flagComment&id=<?= $comment->getId(); ?>&ArticleId=<?= $singleArticle->getId(); ?>">Signaler
                        ce commentaire</a></li>
                <li class="list-group-item"><?= $comment->getContent(); ?></li>
                <li class="list-group-item"><i class="far fa-comments fa-2x"></i></li>
            </ul>

        <?php }
    } ?>
    <?php if (empty($comment)) { ?>
        <p>Il n'y a pas encore de commentaire pour ce chapitre !</p>
    <?php } ?> <!--END comments display -->

    <a class="row justify-content-center mt-3 mb-3" href="index.php">Retour à la liste des articles</a>
</div>