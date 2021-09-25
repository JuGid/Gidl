<?php

namespace Gidl\Lexer\Tokens\TokenCreators;

use Gidl\Lexer\Tokens\Position;

interface TokenCreatorInterface {
    public function create(Position $begin_position);
}