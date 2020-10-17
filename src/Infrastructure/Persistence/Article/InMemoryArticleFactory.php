<?php


namespace App\Infrastructure\Persistence\Article;


use App\Domain\Model\Article\Article;
use App\Domain\Model\Article\ArticleFactory;
use App\Domain\Model\Article\Body;
use App\Domain\Model\Article\Title;
use Cake\Chronos\Chronos;

class InMemoryArticleFactory implements ArticleFactory
{
    /**
     * @param string $user_id
     * @param string $title
     * @param string $body
     * @param array  $tags
     * @return Article
     * @throws \Exception
     */
    public function create(string $user_id, string $title, string $body, array $tags): Article
    {
        return new Article(null, $user_id, new Title($title), new Body($body), $tags, Chronos::now());
    }
}