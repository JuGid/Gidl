<?php

namespace Gidl\Parser;

interface ParserInterface {

    /**
     * Parse a Token container into a tree
     */
    public function parse();
}