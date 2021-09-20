<?php 

namespace Gidl\Lexer\Tokens;

class Token {

    const NUMBERS = '0123456789';
    const CHARACTERS = 'abcdefghijklmnopqrstuvwxyz';
    const NOT_USED = ['\n', '\t', ' '];
    const PLUS = 'PLUS'; // +
    const MINUS = 'MINUS'; // -
    const MULTIPLY = 'MULTIPLY'; // *
    const DIVIDE = 'DIVIDE'; // /

    private $position;

    private $type;

    private $value;

    public function __construct(Position $position, string $type, string $value)
    {
        $this->position = $position;
        $this->type = $type;
        $this->value = $value;
    }

    public function getPosition() : Position {
        return $this->position;
    }

    public function getType() : string {
        return $this->type;
    }

    public function getValue() : string {
        return $this->value;
    }

    public function __toString()
    {
        return '[' . $this->position->line . ':' . $this->position->index . '] ' . $this->type . ':' . $this->value;
    }
}