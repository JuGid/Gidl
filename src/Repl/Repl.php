<?php

namespace Gidl\Repl;

use Gidl\Lexer\Lexer;

class Repl {

    public function run() {
        
        $lexer = new Lexer();
        while(true) {
            $input = readline('>>> ');

            if($input == 'exit') : die("Exit, Bye !\n");endif;

            try {
                $output = $lexer->tokenize($input);
                echo $output , "\n";
            } catch(\Exception $e) {
                echo $e->getMessage(), "\n";
            }
            
        }
    }

}