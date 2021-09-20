<?php 

namespace Gidl\Lexer;

interface LexerInterface {

    /**
     * Transform a string to some tokens
     */
    public function tokenize(string $text);

}