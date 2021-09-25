<?php

namespace Gidl\Lexer\Tokens\TokenCreators;

use Gidl\Lexer\Tokens\Position;
use Gidl\Lexer\Tokens\Token;
use Gidl\Lexer\Tokens\TokenRegexes;
use Gidl\Lexer\Tokens\TokenTypes;

class NumberTokenCreator extends AbstractTokenCreator {

    public function create(Position $begin_position) {
        $number = $this->reader->current();
        $isNumber = true;
        
        while($isNumber && ($character = $this->reader->next()) !== false) {
            if($character == '.' || preg_match(TokenRegexes::TOK_NUMBER_REG, $character)) {
                $number .= $character;
            } else {
                $isNumber = false;
            }
        }

        $this->reader->previous();
        $type = $this->getTypeOfNumber($number);
        return new Token($begin_position, $type, $number);
    }

    private function getTypeOfNumber(string $number) : string {
        if(strpos($number, '.') !== false) {
            return TokenTypes::TYPE_NUMBER_FLOAT;
        }

        return TokenTypes::TYPE_NUMBER_INT;
    }
}