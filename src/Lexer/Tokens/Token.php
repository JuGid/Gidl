<?php 

namespace Gidl\Lexer\Tokens;

class Token {

    /** @var Position */
    private $startPosition;

    /** @var string */
    private $type;

    /** @var string */
    private $value;

    public function __construct(Position $position, string $type, string $value)
    {
        $this->startPosition = $position;
        $this->type = $type;
        $this->value = $value;
    }

    public function getStartPosition() : Position {
        return $this->startPosition;
    }

    public function getType() : string {
        return $this->type;
    }

    public function getValue() : string {
        return $this->value;
    }

    public function __toString()
    {
        return '[' . $this->startPosition->line . ':' . $this->startPosition->index . '] ' . $this->type . ':' . $this->value;
    }
}