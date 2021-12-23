<section class="blog-list px-3 py-5 p-md-5">
    <div class="container text-center">
        <div class="item">
            <?php foreach ($articles as $article) {
                ?>
                <?php if ($article->getPublished() === '1') { ?>
                    <h3 class="mt-5"><?= htmlspecialchars($article->getTitle()); ?></a></h3>
                    <p><?= substr($article->getContent(), 0, 500); ?></p>
                    <div class="d-flex flex-column">
                        <a href="index.php?route=singleArticle&ArticleId=<?= htmlspecialchars($article->getId()); ?>"
                           class="pb-1 mt-2">Lire
                            la suite <i class="fas fa-arrow-right"></i>
                        </a>
                        <?php $createdDate = $article->getCreatedAt(); ?>
                        <p><small>Créer
                                le: <?= htmlspecialchars(isset($createdDate) ? date('d-m-Y H:i', strtotime($createdDate)) : ''); ?>
                                <span class="font-italic mt-2"> par Jean Forteroche</span></small>
                        </p>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</section>



