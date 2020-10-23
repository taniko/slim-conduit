<?php


namespace App\Application\Usecase\Article\Update;


class UpdateArticleCommand
{
    private string $user_id;
    private int $article_id;
    private string $title;
    private string $body;
    private array $tags;

    /**
     * UpdateArticleCommand constructor.
     *
     * @param string $user_id
     * @param int    $article_id
     * @param string $title
     * @param string $body
     * @param array  $tags
     */
    public function __construct(string $user_id, int $article_id, string $title, string $body, array $tags)
    {
        $this->user_id    = $user_id;
        $this->article_id = $article_id;
        $this->title      = $title;
        $this->body       = $body;
        $this->tags       = $tags;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->user_id;
    }

    /**
     * @return int
     */
    public function getArticleId(): int
    {
        return $this->article_id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return string[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }
}