<?php

namespace Gidl\Lexer\Tokens;

use Gidl\Exceptions\InvalidCharacterException;
use Gidl\Exceptions\KeywordException;
use Gidl\Lexer\CharacterReader;

class TokenFactory {

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
        'and', // logical and
        'or', // logical or
        'andb', // bit to bit and
        'orb', //bit to bit or
        'not',
        'mt', //more than
        'lt', // less then
        'meqt', //more equal than
        'leqt', // less equal than
        'eq', // equal
        'dif' // different
    ];

    /** @var CharacterReader */
    private $reader;

    /** @var TokenDetector */
    private $tokenDetector;

    public function __construct(CharacterReader $reader)
    {
        $this->reader = $reader;
        $this->tokenDetector = new TokenDetector();
    }

    public function create($character) : Token {

        $tokenType = $this->tokenDetector->detect($character, $this->reader->getPosition());

        if($tokenType == TokenTypes::TYPE_NUSED) {
            return new Token(clone $this->reader->getPosition(), TokenTypes::TYPE_NUSED, '');
        }

        $token = $this->createTokenFromType($tokenType);

        return $token;
    }

    private function createTokenFromType(string $tokenType) : Token {
        $beginPosition = clone $this->reader->getPosition();

        switch($tokenType) {
            case TokenTypes::TYPE_NUMBER:
                return $this->readNumber($beginPosition);
            case TokenTypes::TYPE_OP:
                return $this->readOperator($beginPosition);
            case TokenTypes::TYPE_STRING:
                return $this->readString($beginPosition);
            case TokenTypes::TYPE_PONCTUATION:
                return $this->readPonctuation($beginPosition);
            case TokenTypes::TYPE_VAR:
                return $this->readVariable($beginPosition);
            case TokenTypes::TYPE_FUNC:
                return $this->readFunction($beginPosition);
            case TokenTypes::TYPE_RETURN_TYPE:
                return $this->readReturnType($beginPosition);
            case TokenTypes::TYPE_KEYWORD:
                return$this->readKeyword($beginPosition);
            default :
                return new Token($beginPosition, TokenTypes::TYPE_UNKNOWN, $this->reader->current());
        }
    }

    private function readNumber(Position $begin_position) : Token {
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

    private function readOperator(Position $begin_position) : Token {
        return new Token($begin_position, TokenTypes::TYPE_OP, $this->reader->current());
    }

    private function readString(Position $begin_position) : Token {
        $string = '';
        
        while(($character = $this->reader->next()) !== "\"") {
            if(preg_match(TokenRegexes::TOK_CHAR_REG, $character) !== false) {
                $string .= $character;
            } else {
                throw new InvalidCharacterException('Invalid character in string at position ' . $this->reader->getPosition()->getIndex());
            }
        }

        return new Token($begin_position, 'STRING', $string);
    }

    private function readPonctuation(Position $begin_position) : Token {
        $character = $this->reader->current();
        return new Token($begin_position, TokenTypes::TYPE_PONCTUATION, $character);
    }

    private function readVariable(Position $begin_position) : Token {
        $variable = '';
        while(($character = $this->reader->next()) !== false && preg_match(TokenRegexes::TOK_CHAR_REG, $character)) {
            $variable .= $character;
        }

        $this->reader->previous();
        return new Token($begin_position, TokenTypes::TYPE_VAR, $variable);
    }

    private function readFunction(Position $begin_position) : Token {
        $character = $this->reader->current();
        $type = $character == '!' ? TokenTypes::TYPE_FUNC_DECL : TokenTypes::TYPE_FUNC_ASK;

        $function_name = $this->readCharacters();
        
        return new Token($begin_position, $type, $function_name);
    }

    private function readReturnType(Position $begin_position) : Token {
        return new Token($begin_position, TokenTypes::TYPE_RETURN_TYPE, $this->readCharacters());
    }

    private function readKeyword(Position $begin_position) : Token {
        $this->reader->previous();
        $identifier = $this->readCharacters();
        if(!in_array($identifier, self::KEYWORDS)) {
            throw new KeywordException(
                sprintf('Keyword %s does not exist at %s', $identifier, $begin_position)
            );
        }

        return new Token($begin_position, TokenTypes::TYPE_KEYWORD, $identifier);
    }

    private function readCharacters() : string {
        $characters = '';

        while(($character = $this->reader->next()) !== false && preg_match(TokenRegexes::TOK_CHAR_REG, $character)) {
            $characters .= $character;
        }

        $this->reader->previous();
        return $characters;
    }

    
}