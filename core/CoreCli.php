<?php


namespace Core;


class CoreCli
{
    public function runCommand(array $argv)
    {
        $name = "World";
        if (isset($argv[1])) {
            $name = $argv[1];
            if($name === 'serve') {
                return exec('php -S 127.0.0.1:8001 public/index.php');
            }
        }

        echo "Hello $name!!!\n";
    }
}