<?php

namespace Gidl\Lexer\Tokens;

use Gidl\Exceptions\InvalidCharacterException;

class TokenDetector {

    private $regexToType = [
        TokenRegexes::TOK_NUMBER_REG => TokenTypes::TYPE_NUMBER,
        TokenRegexes::TOK_OP_REG => TokenTypes::TYPE_OP,
        TokenRegexes::TOK_STR_REG =>  TokenTypes::TYPE_STRING,
        TokenRegexes::TOK_PONCT_REG =>  TokenTypes::TYPE_PONCTUATION,
        TokenRegexes::TOK_FUNC_REG =>  TokenTypes::TYPE_FUNC,
        TokenRegexes::TOK_VAR_REG =>  TokenTypes::TYPE_VAR,
        TokenRegexes::TOK_TYPE_REG =>  TokenTypes::TYPE_RETURN_TYPE,
        TokenRegexes::TOK_CHAR_REG =>  TokenTypes::TYPE_KEYWORD,
        TokenRegexes::TOK_NUSED_REG =>  TokenTypes::TYPE_NUSED,
    ];

    public function detect(string $character) : string {

        foreach($this->regexToType as $regex=>$type) {
            if(preg_match($regex, $character)) {
                return $type;
            }
        }

        throw new InvalidCharacterException(
            sprintf('Invalid character at position %s : \'%s\'', clone $this->reader->getPosition(), $character)
        );
    }
}