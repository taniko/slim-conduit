<?php


namespace App\Domain\Model\Article;


interface ArticleRepository
{
    public function save(Article $article);
    public function findById(int $id): ?Article;
}