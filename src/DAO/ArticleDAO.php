<?php


namespace App\src\DAO;

use App\config\Parameter;
use App\src\model\Article;

class ArticleDAO extends DAO
{
    /**
     * Assure la mise à jour d'un article dans la DB
     * @param Parameter $data
     * @param $date
     * @param $article_id
     */
    public function updateArticle(Parameter $data, $date, $article_id)
    {
        $sql = 'UPDATE projet4.article SET title=:title, content=:contents, updated_at=:updated_at, published=:published WHERE id =:article_id';
        $this->creatQuery($sql, [

            'title' => $data->getParameter('title'),
            'contents' => $data->getParameter('contents'),
            'updated_at' => $date,
            'article_id' => $article_id,
            'published' => $data->getParameter('published')
        ]);
    }

    /**
     * Assure l'ajout d'un article dans la DB
     * @param Parameter $data
     * @param $date
     * @param $user_id
     */
    public function addArticle(Parameter $data, $date, $user_id)
    {
        $sql = 'INSERT INTO projet4.article(title, content, created_at, user_id, published) VALUES(:title, :contents, :created_at, :user_id, :published)';
        $this->creatQuery($sql, [
            'title' => $data->getParameter('title'),
            'contents' => $data->getParameter('contents'),
            'created_at' => $date,
            'user_id' => $user_id,
            'published' => $data->getParameter('published')
        ]);
    }

    /**
     * Récupère la liste des articles dans la DB et la renvoie sous forme d'objet
     * @return array
     */
    public function getArticlesList()
    {
        $sql = 'SELECT id, title, content, created_at, updated_at, published FROM article ORDER BY created_at DESC';
        $result = $this->creatQuery($sql);
        $articles = [];
        foreach ($result as $article) {
            $articleId = $article['id'];
            $articles[$articleId] = $this->buildObject($article);
        }
        $result->closeCursor();
        return $articles;
    }

    /**
     * Génère des articles sous forme d'objet
     * @param $row
     * @return Article
     */
    private function buildObject($row)
    {
        $article = new Article();
        $article->setId($row['id']);
        $article->setTitle($row['title']);
        $article->setContent($row['content']);
        $article->setCreatedAt($row['created_at']);
        $article->setUpdatedAt($row['updated_at']);
        $article->setPublished($row['published']);
        return $article;
    }

    /**
     * Génère un article précis sous forme d'objet
     * @param $id
     * @return Article
     */
    public function getArticle($id)
    {
        $sql = 'SELECT id, title, content, created_at, updated_at, published FROM article WHERE id=:id';
        $result = $this->creatQuery($sql, [
            'id' => $id
        ]);
        $article = $result->fetch();

        $result->closeCursor();
        return $this->buildObject($article);
    }

    /**
     * Assure la suppression d'un article
     * @param $id
     */
    public function deleteArticle($id)
    {
        $sql = 'DELETE FROM article WHERE id=:id';
        $this->creatQuery($sql, [
            'id' => $id
        ]);
    }
}