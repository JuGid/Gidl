<?php

namespace Gidl\Lexer;

use Gidl\Lexer\CharacterReader;
use Gidl\Lexer\Tokens\Token;
use Gidl\Lexer\Tokens\TokenContainer;
use Gidl\Lexer\Tokens\TokenCreators\TokenCreatorFactory;
use Gidl\Lexer\Tokens\TokenDetector;
use Gidl\Lexer\Tokens\TokenTypes;

class Lexer implements LexerInterface {

    public function tokenize(string $text) : TokenContainer
    {
        
        $reader = new CharacterReader($text);
        $container = new TokenContainer();
        $detector = new TokenDetector();

        while(($character = $reader->next()) !== false) {
            $tokenType = $detector->detect($character, $reader->getPosition());

            if($tokenType == TokenTypes::TYPE_NUSED) {
                continue;
            }

            $tokenCreator = TokenCreatorFactory::getCreator($reader, $tokenType);
            $token = $tokenCreator->create(clone $reader->getPosition());
            $container->add($token);
        }

        return $container;
    }

}