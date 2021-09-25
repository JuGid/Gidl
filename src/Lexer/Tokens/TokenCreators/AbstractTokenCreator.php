<?php

namespace Gidl\Lexer\Tokens\TokenCreators;

use Gidl\Lexer\CharacterReader;
use Gidl\Lexer\Tokens\TokenRegexes;

abstract class AbstractTokenCreator implements TokenCreatorInterface {

    protected $reader;

    public function __construct(CharacterReader $reader) {
        $this->reader = $reader;
    }

    protected function readCharacters() : string {
        $characters = '';

        while(($character = $this->reader->next()) !== false && preg_match(TokenRegexes::TOK_CHAR_REG, $character)) {
            $characters .= $character;
        }

        $this->reader->previous();
        return $characters;
    }

}