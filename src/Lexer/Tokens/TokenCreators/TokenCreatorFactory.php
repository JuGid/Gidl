<?php

namespace Gidl\Lexer\Tokens\TokenCreators;

use Gidl\Exceptions\InvalidCharacterException;
use Gidl\Lexer\CharacterReader;
use Gidl\Lexer\Tokens\TokenTypes;

class TokenCreatorFactory {

    public static function getCreator(CharacterReader $reader, string $tokenType) : TokenCreatorInterface {
        switch($tokenType) {
            case TokenTypes::TYPE_NUMBER:
                return new NumberTokenCreator($reader);
            case TokenTypes::TYPE_OP:
                return new OperatorTokenCreator($reader);
            case TokenTypes::TYPE_STRING:
                return new StringTokenCreator($reader);
            case TokenTypes::TYPE_PONCTUATION:
                return new PunctuationTokenCreator($reader);
            case TokenTypes::TYPE_VAR:
                return new VariableTokenCreator($reader);
            case TokenTypes::TYPE_OBJ:
                return new ObjectTokenCreator($reader);
            case TokenTypes::TYPE_FUNC:
                return new FunctionTokenCreator($reader);
            case TokenTypes::TYPE_RETURN_TYPE:
                return new ReturnTypeTokenCreator($reader);
            case TokenTypes::TYPE_KEYWORD:
                return new KeywordTokenCreator($reader);
            default :
                throw new InvalidCharacterException('Invalid character at position '. $reader->getPosition());
        }
    }
}