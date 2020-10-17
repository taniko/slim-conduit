<?php


namespace App\Application\Usecase\Article\Create;


use App\Domain\Model\Article\Article;
use App\Domain\Model\Tag\Tag;
use JsonSerializable;

class CreateArticleResult implements JsonSerializable
{
    /**
     * @var Article
     */
    private Article $article;
    private ?array $errors;

    /**
     * CreateArticleResult constructor.
     *
     * @param Article    $article
     * @param array|null $errors
     */
    public function __construct(Article $article, array $errors = null)
    {
        $this->article = $article;
        $this->errors  = $errors;
    }

    public function jsonSerialize()
    {
        return $this->errors === null
            ? [
                'id'    => $this->article->getId(),
                'title' => $this->article->getTitle()->getValue(),
                'body'  => $this->article->getBody()->getValue(),
                'tags'  => array_map(
                    fn(Tag $tag) => ['id' => $tag->getId(), 'name' => $tag->getName()],
                    $this->article->getTags(),
                ),
                'date'  => $this->article->getDatetime(),
            ] : ['errors' => $this->errors];
    }
}