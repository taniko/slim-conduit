<?php


namespace App\Domain\User;


class Username implements \JsonSerializable
{
    private string $value;

    /**
     * Username constructor.
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (preg_match('/[a-z][a-zA-Z0-9_]{3,}/', $value)!== 1) {
            throw new \InvalidArgumentException("Invalid username");
        }
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function jsonSerialize()
    {
        return $this->value;
    }
}