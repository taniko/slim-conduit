<?php


namespace App\Domain\Model\Article;


use Exception;

class Title
{
    private string $value;

    /**
     * Title constructor.
     *
     * @param string $value
     * @throws Exception
     */
    public function __construct(string $value)
    {
        if (strlen($value) === 0) {
            throw new Exception("タイトルは１文字以上にしてください。");
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
}