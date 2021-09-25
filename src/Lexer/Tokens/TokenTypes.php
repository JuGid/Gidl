<?php

namespace Gidl\Lexer\Tokens;

class TokenTypes {
    const TYPE_NUMBER = 'NUMBER';
    const TYPE_NUMBER_INT = 'INT';
    const TYPE_NUMBER_FLOAT = 'FLOAT';
    const TYPE_STRING = 'STRING';
    const TYPE_OP = 'OPERATOR';
    const TYPE_PONCTUATION = 'PONCT';
    const TYPE_NUSED = 'NUSED';
    const TYPE_FUNC = 'FUNC';
    const TYPE_OBJ = 'OBJ';
    const TYPE_FUNC_ASK = 'FUNC_ASK';
    const TYPE_FUNC_DECL = 'FUNC_DECL';
    const TYPE_DECL_TYPE = 'DECL_TYPE';
    const TYPE_VAR = 'VAR';
    const TYPE_LPARENT = 'LPARENT';
    const TYPE_RPARENT = 'RPARENT';
    const TYPE_LACC = 'LACC';
    const TYPE_RACC = 'RACC';
    const TYPE_DBL_PNT = 'DBL_PNT';
    const TYPE_COMMA = 'COMMA';
    const TYPE_CHEVRON = 'CHEVRON';
    const TYPE_ENDEXPR = 'ENDEXPR';
    const TYPE_RETURN_TYPE = 'RETURN_TYPE';
    const TYPE_KEYWORD = 'KEYWORD';
    const TYPE_UNKNOWN = 'UNKNOWN';
}