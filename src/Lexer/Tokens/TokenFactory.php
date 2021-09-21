<?php

namespace Gidl\Lexer\Tokens;

use Gidl\Exceptions\InvalidCharacterException;
use Gidl\Exceptions\KeywordException;
use Gidl\Exceptions\NotUsedException;
use Gidl\Lexer\CharacterReader;

class TokenFactory {

    const TOK_NUMBER_REG = '/[0-9]/';
    const TOK_STR_REG = '/"/';
    const TOK_CHAR_REG = '/[0-9a-zA-Z]/';
    const TOK_OP_REG = '/[\+\-\*\/\=]/';
    const TOK_NUSED_REG = '/[\t\n\s]/';
    const TOK_FUNC_REG = '/[\!\?]/';
    const TOK_TYPE_REG = '/[\@]/';
    const TOK_PONCT_REG = '/[(){}:;,]/';
    const TOK_VAR_REG = '/[\%]/';

    const TYPE_NUMBER = 'NUMBER';
    const TYPE_NUMBER_INT = 'INT';
    const TYPE_NUMBER_FLOAT = 'FLOAT';
    const TYPE_STRING = 'STRING';
    const TYPE_OP = 'OPERATOR';
    const TYPE_PONCTUATION = 'PONCT';
    const TYPE_NUSED = 'NUSED';
    const TYPE_FUNC = 'FUNC';
    const TYPE_FUNC_ASK = 'FUNC_ASK';
    const TYPE_FUNC_DECL = 'FUNC_DECL';
    const TYPE_DECL_TYPE = 'DECL_TYPE';
    const TYPE_VAR = 'VAR';
    const TYPE_LPARENT = 'LPARENT';
    const TYPE_RPARENT = 'RPARENT';
    const TYPE_LACC = 'LACC';
    const TYPE_RACC = 'RACC';
    const TYPE_DBL_PNT = 'DBL_PNT';
    const TYPE_COMMA = 'COMMA';
    const TYPE_ENDEXPR = 'ENDEXPR';
    const TYPE_RETURN_TYPE = 'RETURN_TYPE';
    const TYPE_KEYWORD = 'KEYWORD';
    const TYPE_UNKNOWN = 'UNKNOWN';

    const KEYWORDS = [
        'expose',
        'reserve',
        'out',
        'if',
        'elseif',
        'else',
        'for',
        'in',
        'to',
        'while',
        'and',
        'or',
        'not'
    ];

    private $reader;

    public function __construct(CharacterReader $reader)
    {
        $this->reader = $reader;
    }

    public function create($character) : Token {

        $tokenType = $this->detectType($character);

        if($tokenType == self::TYPE_NUSED) {
            return new Token(clone $this->reader->getPosition(), self::TYPE_NUSED, '');
        }

        $token = $this->createTokenFromType($tokenType);

        return $token;
    }

    private function detectType(string $character) : string {
        if(preg_match(self::TOK_NUMBER_REG, $character)) {return self::TYPE_NUMBER;}
        elseif (preg_match(self::TOK_OP_REG, $character)) {return self::TYPE_OP;}
        elseif (preg_match(self::TOK_STR_REG, $character)) {return self::TYPE_STRING;}
        elseif (preg_match(self::TOK_PONCT_REG, $character)) {return self::TYPE_PONCTUATION;}
        elseif (preg_match(self::TOK_FUNC_REG, $character)) {return self::TYPE_FUNC;}
        elseif (preg_match(self::TOK_VAR_REG, $character)) {return self::TYPE_VAR;}
        elseif (preg_match(self::TOK_TYPE_REG, $character)) {return self::TYPE_RETURN_TYPE;}
        elseif (preg_match(self::TOK_CHAR_REG, $character)) {return self::TYPE_KEYWORD;}
        elseif (preg_match(self::TOK_NUSED_REG, $character)) {return self::TYPE_NUSED;}
        else {
            throw new InvalidCharacterException(
                sprintf('Invalid character at position %s : \'%s\'', clone $this->reader->getPosition(), $character)
            );
        }
    }

    private function createTokenFromType(string $tokenType) : Token {
        $beginPosition = clone $this->reader->getPosition();

        switch($tokenType) {
            case self::TYPE_NUMBER:
                return $this->readNumber($beginPosition);
            case self::TYPE_OP:
                return $this->readOperator($beginPosition);
            case self::TYPE_STRING:
                return $this->readString($beginPosition);
            case self::TYPE_PONCTUATION:
                return $this->readPonctuation($beginPosition);
            case self::TYPE_VAR:
                return $this->readVariable($beginPosition);
            case self::TYPE_FUNC:
                return $this->readFunction($beginPosition);
            case self::TYPE_RETURN_TYPE:
                return $this->readReturnType($beginPosition);
            case self::TYPE_KEYWORD:
                return$this->readKeyword($beginPosition);
            default :
                return new Token($beginPosition, self::TYPE_UNKNOWN, $this->reader->current());
        }
    }

    private function readNumber(Position $begin_position) : Token {
        $number = $this->reader->current();
        $isNumber = true;

        while($isNumber && $character = $this->reader->next()) {
            if($character == '.' || preg_match(self::TOK_NUMBER_REG, $character)) {
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
            return self::TYPE_NUMBER_FLOAT;
        }

        return self::TYPE_NUMBER_INT;
    }

    private function readOperator(Position $begin_position) : Token {
        return new Token($begin_position, self::TYPE_OP, $this->reader->current());
    }

    private function readString(Position $begin_position) : Token {
        $string = '';
        
        while(($character = $this->reader->next()) !== "\"") {
            if(preg_match(self::TOK_CHAR_REG, $character) !== false) {
                $string .= $character;
            } else {
                throw new InvalidCharacterException('Invalid character in string at position ' . $this->reader->getPosition()->getIndex());
            }
        }

        return new Token($begin_position, 'STRING', $string);
    }

    private function readPonctuation(Position $begin_position) : Token {
        $character = $this->reader->current();
        return new Token($begin_position, $this->getTypeOfPunctuation($character), $character);
    }

    private function getTypeOfPunctuation(string $character) : string {
        if($character == '(') {$type = self::TYPE_LPARENT;}
        elseif($character == ')') {$type = self::TYPE_RPARENT;}
        elseif($character == '{') {$type = self::TYPE_LACC;}
        elseif($character == '}') {$type = self::TYPE_RACC;}
        elseif($character == ';') {$type = self::TYPE_ENDEXPR;}
        elseif($character == ':') {$type = self::TYPE_DBL_PNT;}
        elseif($character == ',') {$type = self::TYPE_COMMA;}
        else {$type = self::TYPE_UNKNOWN;}

        return $type;
    }

    private function readVariable(Position $begin_position) : Token {
        $variable = '';
        while(($character = $this->reader->next()) && preg_match(self::TOK_CHAR_REG, $character)) {
            $variable .= $character;
        }

        $this->reader->previous();
        return new Token($begin_position, self::TYPE_VAR, $variable);
    }

    private function readFunction(Position $begin_position) : Token {
        $character = $this->reader->current();
        $type = $character == '!' ? self::TYPE_FUNC_DECL : self::TYPE_FUNC_ASK;

        $function_name = $this->readCharacters();
        
        return new Token($begin_position, $type, $function_name);
    }

    private function readReturnType(Position $begin_position) : Token {
        return new Token($begin_position, self::TYPE_RETURN_TYPE, $this->readCharacters());
    }

    private function readKeyword(Position $begin_position) : Token {
        $this->reader->previous();
        $identifier = $this->readCharacters();
        if(!in_array($identifier, self::KEYWORDS)) {
            throw new KeywordException(
                sprintf('Keyword %s does not exist at %s', $identifier, $begin_position)
            );
        }

        return new Token($begin_position, self::TYPE_KEYWORD, $identifier);
    }

    private function readCharacters() : string {
        $characters = '';
        while(($character = $this->reader->next()) && preg_match(self::TOK_CHAR_REG, $character)) {
            $characters .= $character;
        }
        $this->reader->previous();
        return $characters;
    }

    
}