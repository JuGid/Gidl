<?php

namespace Gidl\Lexer\Tokens\TokenCreators;

use Gidl\Lexer\Tokens\Position;
use Gidl\Lexer\Tokens\Token;
use Gidl\Lexer\Tokens\TokenDetector;

class PunctuationTokenCreator extends AbstractTokenCreator {

    public function create(Position $begin_position) {
        $character = $this->reader->current();
        $tokenDetector = new TokenDetector();
        return new Token($begin_position, $tokenDetector->detectPunctuationType($character, $begin_position), $character);
    }
}