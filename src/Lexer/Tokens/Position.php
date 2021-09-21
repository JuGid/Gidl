<?php

namespace Gidl\Lexer\Tokens;

class Position {

    public $index;

    public $line;

    public function __construct(int $index, int $line)
    {
        $this->index = $index;
        $this->line = $line;
    }

    public function getIndex() : int {
        return $this->index;
    }

    public function getLine() : int {
        return $this->line;
    }

    public function next() : void {
        $this->index += 1;
    }

    public function previous() : void {
        $this->index -= 1;
    }

    public function __toString()
    {
        return '[' . $this->index . ',' . $this->line . ']';
    }
}