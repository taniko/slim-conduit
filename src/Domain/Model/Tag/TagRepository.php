<?php


namespace App\Domain\Model\Tag;

interface TagRepository
{
    /**
     * @param string[] $names
     * @return Tag[]
     */
    public function findByNames(array $names): array;

    public function save(Tag $tag): Tag;
}