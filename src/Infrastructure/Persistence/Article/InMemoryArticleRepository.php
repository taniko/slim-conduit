<?php


namespace App\Infrastructure\Persistence\Article;


use App\Domain\DomainException\DomainRecordNotFoundException;
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
                break;
            }
        }
        if (!$found) {
            $article->setId($this->id);
            $this->articles[] = $article;
        }
        return $article;
    }

    /**
     * @param int $id
     * @return Article
     * @throws DomainRecordNotFoundException
     */
    public function findById(int $id): Article
    {
        $article = null;
        foreach ($this->articles as $i => $item) {
            if ($item->getId() === $id) {
                $article = $item;
                break;
            }
        }
        if ($article === null) {
            throw new DomainRecordNotFoundException();
        }
        return $article;
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        foreach ($this->articles as $i => $article) {
            if ($article->getId() === $id) {
                unset($this->articles[$i]);
                break;
            }
        }
        $this->articles = array_values($this->articles);
    }
}