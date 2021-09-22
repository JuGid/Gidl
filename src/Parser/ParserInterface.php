<?php

namespace Gidl\Parser;

use Gidl\Lexer\Tokens\TokenContainer;

interface ParserInterface {

    public function parse(TokenContainer $tokens);
}