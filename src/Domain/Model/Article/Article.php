<?php

namespace App\Domain\Model\Article;


use App\Domain\Model\Tag\Tag;
use App\Domain\User\User;
use Cake\Chronos\Chronos;

class Article
{
    private ?int $id;
    private string $user_id;
    private Title $title;
    private Body $body;
    private array $tags;
    private Chronos $datetime;

    /**
     * Article constructor.
     *
     * @param int|null $id
     * @param string   $user_id
     * @param Title    $title
     * @param Body     $body
     * @param Tag[]    $tags
     * @param Chronos  $datetime
     */
    public function __construct(?int $id, string $user_id, Title $title, Body $body, array $tags, Chronos $datetime)
    {
        $this->id       = $id;
        $this->user_id  = $user_id;
        $this->title    = $title;
        $this->body     = $body;
        $this->tags     = $tags;
        $this->datetime = $datetime;
    }

    public function hasId(): bool
    {
        return $this->id !== null;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUserId(): string
    {
        return $this->user_id;
    }

    /**
     * @return Title
     */
    public function getTitle(): Title
    {
        return $this->title;
    }

    /**
     * @return Body
     */
    public function getBody(): Body
    {
        return $this->body;
    }

    /**
     * @return Tag[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @return Chronos
     */
    public function getDatetime(): Chronos
    {
        return $this->datetime;
    }

    /**
     * @param int $id
     * @return Article
     */
    public function setId(int $id): Article
    {
        $this->id = $id;
        return $this;
    }
}