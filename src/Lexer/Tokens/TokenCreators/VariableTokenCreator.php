<?php

namespace Gidl\Lexer\Tokens\TokenCreators;

use Gidl\Lexer\Tokens\Position;
use Gidl\Lexer\Tokens\Token;
use Gidl\Lexer\Tokens\TokenRegexes;
use Gidl\Lexer\Tokens\TokenTypes;

class VariableTokenCreator extends AbstractTokenCreator {

    public function create(Position $begin_position) {
        $variable = '';
        while(($character = $this->reader->next()) !== false && preg_match(TokenRegexes::TOK_CHAR_REG, $character)) {
            $variable .= $character;
        }

        $this->reader->previous();
        return new Token($begin_position, TokenTypes::TYPE_VAR, $variable);
    }
}