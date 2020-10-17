<?php


namespace App\Domain\Model\Article;


interface ArticleFactory
{
    public function create(string $user_id, string $title, string $body, array $tags): Article;
}