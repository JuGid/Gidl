<?php 

namespace Gidl\Lexer;

use Gidl\Lexer\Tokens\TokenContainer;

interface LexerInterface {

    /**
     * Transform a string to some tokens
     */
    public function tokenize(string $text) : TokenContainer;

}