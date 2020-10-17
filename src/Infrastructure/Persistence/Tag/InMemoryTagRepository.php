<?php


namespace App\Infrastructure\Persistence\Tag;


use App\Domain\Model\Tag\Tag;
use App\Domain\Model\Tag\TagRepository;

class InMemoryTagRepository implements TagRepository
{
    /** @var Tag[]  */
    private array $tags = [];
    private int $id = 1;

    /**
     * @param string[] $names
     * @return Tag[]
     */
    public function findByNames(array $names): array
    {
        $tags = [];
        foreach ($names as $name) {
            foreach ($this->tags as $tag) {
                if ($name === $tag->getName()) {
                    $tag[] = new Tag($tag->getId(), $tag->getName());
                    break;
                }
            }
        }
        return $tags;
    }

    /**
     * @param Tag $tag
     * @return Tag
     */
    public function save(Tag $tag): Tag
    {
        $result = new Tag($this->id, $tag->getName());
        $this->tags[] = $result;
        return $result;
    }
}