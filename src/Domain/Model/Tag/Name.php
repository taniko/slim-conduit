<?php


namespace App\Domain\Model\Tag;


use InvalidArgumentException;

class Name
{
    private string $value;

    /**
     * Name constructor.
     *
     * @param string $value
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        if (strlen($value) === 0) {
            throw new InvalidArgumentException();
        }
        $this->value = $value;
    }
}