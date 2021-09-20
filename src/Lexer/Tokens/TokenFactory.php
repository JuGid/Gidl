<?php

namespace Gidl\Lexer\Tokens;

use Gidl\Exceptions\InvalidCharacterException;
use Gidl\Exceptions\NotUsedException;

class TokenFactory {

    public static function create(Position $begin_position, $character, $text) : Token {

        if(strpos(Token::NUMBERS, $character) !== false) {
            $token = new Token(clone $begin_position, 'INT', $character);
        }
        elseif($character == '*') {
            $token = new Token(clone $begin_position, Token::MULTIPLY, $character);
        }
        elseif($character == '/') {
            $token = new Token(clone $begin_position, Token::DIVIDE, $character);
        }
        elseif($character == '+') {
            $token = new Token(clone $begin_position, Token::PLUS, $character);
        }
        elseif($character == '-') {
            $token = new Token(clone $begin_position, Token::MINUS, $character);
        }
        elseif(in_array($character, Token::NOT_USED)) {
            throw new NotUsedException();
        } 
        else {
            throw new InvalidCharacterException(
                sprintf('Invalid character at position %s : \'%s\'', $begin_position, $character)
            );
        }

        return $token;
    }
}