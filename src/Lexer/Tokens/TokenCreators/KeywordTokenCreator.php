<?php

namespace Gidl\Lexer\Tokens\TokenCreators;

use Gidl\Exceptions\KeywordException;
use Gidl\Lexer\Tokens\Position;
use Gidl\Lexer\Tokens\Token;
use Gidl\Lexer\Tokens\TokenTypes;

class KeywordTokenCreator extends AbstractTokenCreator {

    const KEYWORDS = [
        'expose',
        'reserve',
        'out',
        'for',
        'in',
        'to',
        'new',
        'while',
        'and', // logical and
        'or', // logical or
        'andb', // bit to bit and
        'orb', //bit to bit or
        'not',
        'mt', //more than
        'lt', // less then
        'meqt', //more equal than
        'leqt', // less equal than
        'eq', // equal
        'dif' // different
    ];

    public function create(Position $begin_position) {
        $this->reader->previous();
        $identifier = $this->readCharacters();
        if(!in_array($identifier, self::KEYWORDS)) {
            throw new KeywordException(
                sprintf('Keyword %s does not exist at %s', $identifier, $begin_position)
            );
        }

        return new Token($begin_position, TokenTypes::TYPE_KEYWORD, $identifier);
    }
}