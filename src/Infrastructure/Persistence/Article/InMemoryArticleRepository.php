<?php


namespace App\Infrastructure\Persistence\Article;


use App\Domain\Model\Article\Article;
use App\Domain\Model\Article\ArticleRepository;

class InMemoryArticleRepository implements ArticleRepository
{
    private int $id = 1;
    /** @var Article[] */
    private array $articles = [];

    public function save(Article $article)
    {
        $found = false;
        foreach ($this->articles as $i => $item) {
            if ($article->getId() === $item->getId()) {
                $this->articles[$i] = $article;
                $found              = true;
                break;
            }
        }
        if (!$found) {
            $article->setId($this->id);
            $this->articles[] = $article;
        }
        return $article;
    }

    public function findById(int $id): ?Article
    {
        $article = null;
        foreach ($this->articles as $i => $item) {
            if ($item->getId() === $id) {
                $article = $item;
                break;
            }
        }
        return $article;
    }
}