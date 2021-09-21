<?php 

namespace Gidl\Lexer\Tokens;

use Gidl\Exceptions\ContainerException;

class TokenContainer {

    private $container;

    private $size;

    public function __construct()
    {
        $this->container = [];
        $this->size = 0;
    }

    public function add(Token $token) {
        $this->container[] = $token;
        $this->size += 1;
    }

    public function pop() : Token {
        return array_shift($this->container);
    }

    public function get(int $index) {
        $maxIndexOfContainer = $this->size - 1;

        if($index > $maxIndexOfContainer) {
            throw new ContainerException(
                sprintf('Given index is out of bounds in get : %d -> max is %d', $index, $maxIndexOfContainer)
            );
        }

        return $this->container[$index];
    }

    public function __toString()
    {
        $tokenStringValue = [];

        foreach($this->container as $token) {
            $tokenStringValue[] = strval($token) . "\n";
        }

        return implode('', $tokenStringValue);
    }
}