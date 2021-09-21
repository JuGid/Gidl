<?php

namespace Gidl\Lexer\Tokens;

use Gidl\Exceptions\InvalidCharacterException;
use Gidl\Exceptions\NotUsedException;
use Gidl\Lexer\CharacterReader;

class TokenFactory {

    const TOK_NUMBER_REG = '/[0-9]/';
    const TOK_STR_REG = '/"/';
    const TOK_CHAR_REG = '/[0-9a-zA-Z]/';
    const TOK_OP_REG = '/[\+\-\*\/\=]/';
    const TOK_NUSED_REG = '/[\t\n]/';
    const TOK_FUNC_REG = '/[\!\?]/';
    const TOK_TYPE_REG = '/[\@]/';
    const TOK_PONCT_REG = '/[(){};]/';
    const TOK_VAR_REG = '/[\%]/';
    const TOK_WHITESPACE_REG = '/[\s]/';

    const TYPE_NUMBER = 'NUMBER';
    const TYPE_STRING = 'STRING';
    const TYPE_OP = 'OPERATOR';
    const TYPE_PONCTUATION = 'PONCT';
    const TYPE_NUSED = 'NUSED';
    const TYPE_FUNC = 'FUNC';
    const TYPE_DECL_TYPE = 'DECL_TYPE';
    const TYPE_VAR = 'VAR';
    const TYPE_WHITESPACE = 'WHITESPACE';
    const TYPE_LPARENT = 'LPARENT';
    const TYPE_RPARENT = 'RPARENT';
    const TYPE_LACC = 'LACC';
    const TYPE_RACC = 'RACC';
    const TYPE_ENDEXPR = 'ENDEXPR';
    const TYPE_UNKNOWN = 'UNKNOWN';

    private $reader;

    public function __construct(CharacterReader $reader)
    {
        $this->reader = $reader;
    }

    public function create($character) : Token {

        $tokenType = $this->detectType($character);
        
        if($tokenType == self::TYPE_NUSED) {
            throw new NotUsedException();
        }

        $token = $this->createTokenFromType($tokenType);

        return $token;
    }

    private function detectType(string $character) : string {
        if(preg_match(self::TOK_NUMBER_REG, $character)) {return self::TYPE_NUMBER;}
        elseif (preg_match(self::TOK_OP_REG, $character)) {return self::TYPE_OP;}
        elseif (preg_match(self::TOK_STR_REG, $character)) {return self::TYPE_STRING;}
        elseif (preg_match(self::TOK_PONCT_REG, $character)) {return self::TYPE_PONCTUATION;}
        elseif (preg_match(self::TOK_NUSED_REG, $character)) {return self::TYPE_NUSED;}
        elseif (preg_match(self::TOK_FUNC_REG, $character)) {return self::TYPE_FUNC;}
        elseif (preg_match(self::TOK_VAR_REG, $character)) {return self::TYPE_VAR;}
        elseif (preg_match(self::TOK_WHITESPACE_REG, $character)) {return self::TYPE_WHITESPACE;}
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
            case self::TYPE_WHITESPACE:
                return new Token($beginPosition, $tokenType, $this->reader->current()); 
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
            return 'FLOAT';
        }

        return 'INT';
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
        else {$type = self::TYPE_UNKNOWN;}

        return $type;
    }

    private function readVariable(Position $begin_position) : Token {
        $variable = '';
        while(($character = $this->reader->next()) && preg_match(self::TOK_CHAR_REG, $character)) {
            $variable .= $character;
        }

        return new Token($begin_position, self::TYPE_VAR, $variable);
    }
}