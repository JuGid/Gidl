<?php

namespace Gidl\Repl;

use Gidl\Lexer\Lexer;

class Repl {

    public function run() {
        
        $lexer = new Lexer();
        while(true) {
            $input = readline('>>> ');

            try {
                $output = $lexer->tokenize($input);
                echo $output . "\n";
            } catch(\Exception $e) {
                die($e->getMessage() . "\n");
            }
            
        }
    }

}