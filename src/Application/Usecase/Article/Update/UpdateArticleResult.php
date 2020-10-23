<?php


namespace App\Application\Usecase\Article\Update;


use App\Domain\Model\Article\Article;
use App\Domain\Model\Tag\Tag;
use JsonSerializable;

class UpdateArticleResult implements JsonSerializable
{
    /**
     * @var Article
     */
    private Article $article;

    /**
     * UpdateArticleResult constructor.
     *
     * @param Article $article
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function jsonSerialize()
    {
        return [
            'id'       => $this->article->getId(),
            'title'    => $this->article->getTitle(),
            'body'     => $this->article->getBody(),
            'tags'     => array_map(
                fn(Tag $tag) => ['id' => $tag->getId(), 'name' => $tag->getName()],
                $this->article->getTags()
            ),
            'datetime' => $this->article->getDatetime(),
        ];
    }
}