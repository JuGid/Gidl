<?php

namespace Gidl\Parser;

use Gidl\Lexer\Tokens\TokenContainer;

class Parser implements ParserInterface {

    /** @var TokenContainer */
    private $tokens;

    public function __construct(TokenContainer $tokens)
    {
        $this->tokens = $tokens;
    }

    public function parse() {

    }
}