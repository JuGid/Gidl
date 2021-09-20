<?php

namespace Gidl\Lexer;

use Gidl\Exceptions\InvalidCharacterException;
use Gidl\Exceptions\NotUsedException;
use Gidl\Lexer\Tokens\Position;
use Gidl\Lexer\Tokens\Token;
use Gidl\Lexer\Tokens\TokenContainer;
use Gidl\Lexer\Tokens\TokenFactory;

class Lexer implements LexerInterface {

    private $position;

    public function tokenize(string $text)
    {
        $this->position = new Position(0,0);
        $container = new TokenContainer();
        $characters = str_split($text, 1);

        foreach($characters as $character) {
            try {
                $token = TokenFactory::create($this->position, $character, $text);
                $container->add($token);
            }catch(NotUsedException $e) {
                continue;
            }
            $this->position->next();
        }

        return strval($container);
    }

}