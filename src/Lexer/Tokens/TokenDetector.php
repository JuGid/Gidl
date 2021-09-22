<?php

namespace Gidl\Lexer\Tokens;

use Gidl\Exceptions\InvalidCharacterException;

class TokenDetector {

    /** @var array */
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

    private $ponctuationTypes = [
        '(' => TokenTypes::TYPE_LPARENT,
        ')' => TokenTypes::TYPE_RPARENT,
        '{' => TokenTypes::TYPE_LACC,
        '}' => TokenTypes::TYPE_RACC,
        ':' => TokenTypes::TYPE_DBL_PNT,
        ',' => TokenTypes::TYPE_COMMA,
        '>' => TokenTypes::TYPE_CHEVRON,
        ';' => TokenTypes::TYPE_ENDEXPR
        ];

    public function detect(string $character, Position $position) : string {

        foreach($this->regexToType as $regex=>$type) {
            if(preg_match($regex, $character)) {
                return $type;
            }
        }

        throw new InvalidCharacterException(
            sprintf('Invalid character at position %s : \'%s\'', $position, $character)
        );
    }

    public function detectPonctuationType(string $character, Position $position) {
        foreach($this->ponctuationTypes as $ponctuation=>$type) {
            if($ponctuation === $character) {
                return $type;
            }
        }

        throw new InvalidCharacterException(
            sprintf('Invalid ponctuation at position %s : \'%s\'', $position, $character)
        );
    }
}