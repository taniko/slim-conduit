<?php
namespace App\Application\Usecase\Article\Create;

class CreateArticleCommand
{
    private string $user_id;
    private string $title;
    private string $body;
    private array $tags;

    /**
     * CreateArticleCommand constructor.
     *
     * @param string $user_id
     * @param string $title
     * @param string $body
     * @param array  $tags
     */
    public function __construct(string $user_id, string $title, string $body, array $tags)
    {
        $this->user_id = $user_id;
        $this->title   = $title;
        $this->body    = $body;
        $this->tags    = $tags;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->user_id;
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