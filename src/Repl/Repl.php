<?php

namespace Gidl\Repl;

use Gidl\Lexer\Lexer;
use Gidl\Parser\Parser;

class Repl {

    public function run() {
        
        $lexer = new Lexer();
        $parser = new Parser();

        while(true) {
            $input = readline('>>> ');

            if($input == 'exit') : die("Exit, Bye !\n");endif;

            try {
                $lexerOutput = $lexer->tokenize($input);
                echo $lexerOutput , "\n";
                $parserOutput = $parser->parse($lexerOutput);
                //echo $parserOutput;
            } catch(\Exception $e) {
                echo $e->getMessage(), "\n";
            }
            
        }
    }

}