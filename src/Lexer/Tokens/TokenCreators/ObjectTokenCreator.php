<?php

namespace Gidl\Lexer\Tokens\TokenCreators;

use Gidl\Lexer\Tokens\Position;
use Gidl\Lexer\Tokens\Token;
use Gidl\Lexer\Tokens\TokenTypes;

class ObjectTokenCreator extends AbstractTokenCreator {

    public function create(Position $begin_position) {
        $objectName = $this->readCharacters();
        return new Token($begin_position, TokenTypes::TYPE_OBJ, $objectName);
    }
}