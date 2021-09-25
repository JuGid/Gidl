<?php

namespace Gidl\Lexer;

use Gidl\Exceptions\CharacterReaderException;
use Gidl\Lexer\Tokens\Position;

class CharacterReader {

    /** @var string */
    private $text;

    /** @var Position */
    private $position;

    public function __construct(string $text)
    {
        $this->text = $text;
        $this->position = new Position(-1,0);
    }

    public function getPosition() : Position {
        return $this->position;
    }

    public function current() : string {
        return $this->text[$this->position->getIndex()];
    }

    public function next() {
        $this->position->next();

        if(!isset($this->text[$this->position->getIndex()])) {
            return false;
        }

        if($this->text[$this->position->getIndex()] == '\n') {
            $this->position->line += 1;
            $this->next();
        }

        return $this->current();
    }

    public function previous() {
        $this->position->previous();
    }

    public function updatePosition(Position $new_position) {
        if(!isset($this->text[$new_position->getIndex()])) {
            throw new CharacterReaderException('New position is not possible');
        }

        $this->position = $new_position;
    }

    public function __toString()
    {
        return "Reader at position : " . $this->position;
    }
}