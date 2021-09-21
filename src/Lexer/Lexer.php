<?php

namespace Gidl\Lexer;

use Gidl\Lexer\CharacterReader;
use Gidl\Lexer\Tokens\TokenContainer;
use Gidl\Lexer\Tokens\TokenFactory;

class Lexer implements LexerInterface {

    public function tokenize(string $text) : TokenContainer
    {
        
        $reader = new CharacterReader($text);
        $tokenFactory = new TokenFactory($reader);
        $container = new TokenContainer();
        
        while($character = $reader->next()) {
            $token = $tokenFactory->create($character);
            $container->add($token);
        }

        echo strval($container);
        return $container;
    }

}