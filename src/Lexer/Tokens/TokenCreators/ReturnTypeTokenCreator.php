<?php

namespace Gidl\Lexer\Tokens\TokenCreators;

use Gidl\Lexer\Tokens\Position;
use Gidl\Lexer\Tokens\Token;
use Gidl\Lexer\Tokens\TokenTypes;

class ReturnTypeTokenCreator extends AbstractTokenCreator {

    public function create(Position $begin_position) {
        return new Token($begin_position, TokenTypes::TYPE_RETURN_TYPE, $this->readCharacters());
    }
}