<?php


namespace App\Domain\Model\Tag;


class Tag
{
    private ?int $id;
    private Name $name;

    /**
     * Tag constructor.
     *
     * @param int|null $id
     * @param Name     $name
     */
    public function __construct(?int $id, Name $name)
    {
        $this->id   = $id;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }
}