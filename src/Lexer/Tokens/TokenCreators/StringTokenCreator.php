<?php

namespace Gidl\Lexer\Tokens\TokenCreators;

use Gidl\Exceptions\InvalidCharacterException;
use Gidl\Lexer\Tokens\Position;
use Gidl\Lexer\Tokens\Token;
use Gidl\Lexer\Tokens\TokenRegexes;
use Gidl\Lexer\Tokens\TokenTypes;

class StringTokenCreator extends AbstractTokenCreator {

    public function create(Position $begin_position) {
        $string = '';
        
        while(($character = $this->reader->next()) !== "\"") {
            if(preg_match(TokenRegexes::TOK_CHAR_REG, $character) !== false) {
                $string .= $character;
            } else {
                throw new InvalidCharacterException('Invalid character in string at position ' . $this->reader->getPosition()->getIndex());
            }
        }

        return new Token($begin_position, TokenTypes::TYPE_STRING, $string);
    }
}