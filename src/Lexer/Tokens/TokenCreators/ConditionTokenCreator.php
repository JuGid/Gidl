<?php

namespace Gidl\Lexer\Tokens\TokenCreators;

use Gidl\Lexer\Tokens\Position;
use Gidl\Lexer\Tokens\Token;
use Gidl\Lexer\Tokens\TokenTypes;

class ConditionTokenCreator extends AbstractTokenCreator {

    public function create(Position $begin_position) {
        $character = $this->reader->current();
        $next_character = $this->reader->next();

        if($character == '&' && $next_character == '(') {
            $type = TokenTypes::TYPE_IF_ELSE;
        } elseif($character == '&') {
            $type = TokenTypes::TYPE_ELSE;
        } else {
            $type = TokenTypes::TYPE_IF;
        }

        $this->reader->previous();
        return new Token($begin_position, $type, $this->reader->current());
    }
}