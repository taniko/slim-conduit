<?php


namespace App\Application\Usecase\Article\Get;


class GetArticleQuery
{
    private int $id;

    /**
     * GetArticleQuery constructor.
     *
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}