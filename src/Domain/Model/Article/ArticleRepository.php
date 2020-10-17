<?php


namespace App\Domain\Model\Article;


use App\Domain\DomainException\DomainRecordNotFoundException;

interface ArticleRepository
{
    public function save(Article $article);

    /**
     * @param int $id
     * @return Article
     * @throws DomainRecordNotFoundException
     */
    public function findById(int $id): Article;

    public function delete(int $id);
}