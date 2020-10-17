<?php


namespace App\Application\Usecase\Article\Delete;


class DeleteArticleCommand
{
    private string $user_id;
    private int $article_id;

    /**
     * DeleteArticleCommand constructor.
     *
     * @param string $user_id
     * @param int    $article_id
     */
    public function __construct(string $user_id, int $article_id)
    {
        $this->user_id    = $user_id;
        $this->article_id = $article_id;
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
}