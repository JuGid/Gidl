<?php 

namespace Gidl\Lexer;

use Gidl\Lexer\Tokens\TokenContainer;

interface LexerInterface {

    /**
     * Transform a string to tokens into a TokenContainer
     */
    public function tokenize(string $text) : TokenContainer;

}