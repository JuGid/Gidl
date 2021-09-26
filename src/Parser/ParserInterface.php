<?php

namespace Gidl\Parser;

use Gidl\Lexer\Tokens\TokenContainer;

interface ParserInterface {

    /**
     * Parse a Token container into a tree
     */
    public function parse(TokenContainer $tokenContainer);
}