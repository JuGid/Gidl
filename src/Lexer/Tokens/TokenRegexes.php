<?php

namespace Gidl\Lexer\Tokens;

class TokenRegexes {
    const TOK_NUMBER_REG = '/[0-9]/';
    const TOK_STR_REG = '/"/';
    const TOK_CHAR_REG = '/[0-9a-zA-Z]/';
    const TOK_OP_REG = '/[\+\-\*\/\=]/';
    const TOK_NUSED_REG = '/[\t\n\s]/';
    const TOK_FUNC_REG = '/[\!\?]/';
    const TOK_TYPE_REG = '/[\@]/';
    const TOK_PONCT_REG = '/[(){}:;,>]/';
    const TOK_VAR_REG = '/[\%]/';
}