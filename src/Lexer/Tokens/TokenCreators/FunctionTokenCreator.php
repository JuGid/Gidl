<?php

namespace Gidl\Lexer\Tokens\TokenCreators;

use Gidl\Lexer\Tokens\Position;
use Gidl\Lexer\Tokens\Token;
use Gidl\Lexer\Tokens\TokenTypes;

class FunctionTokenCreator extends AbstractTokenCreator {

    public function create(Position $begin_position) {
        $character = $this->reader->current();
        $type = $character == '!' ? TokenTypes::TYPE_FUNC_DECL : TokenTypes::TYPE_FUNC_ASK;

        $function_name = $this->readCharacters();
        
        return new Token($begin_position, $type, $function_name);
    }
}