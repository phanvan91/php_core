<?php

namespace Core;

class CoreCli
{
    public function runCommand(array $argv)
    {
        switch (count($argv)) {
            case 2:
                $name = $argv[1];
                if ($name === 'serve') {
                    return exec('php -S 127.0.0.1:8001 public/index.php');
                }
                break;
            case 3:
                $firstParameter = $argv[1];
                $firstParameterToArray = explode(":", $firstParameter);
                $secondParameter = $argv[2];

                if (count($firstParameterToArray) === 2) {
                    if ($firstParameterToArray[0] === 'make' && $firstParameterToArray[1] === 'controller') {
                        $dirController = Config::get('app.controller_dir');
                        $file = $dirController . '/' . $secondParameter . '.php';
                        if(file_exists($file)) {
                            echo "file exists\n";
                            return;
                        }
                        $pathControllerTxt = Config::get('app.public_dir') . '/general_file/controller.txt';

                        $controllerTxt = $this->readFile($pathControllerTxt);
                        $controllerTxt = str_replace('{CLASSNAME}', $secondParameter, $controllerTxt);
                        $controllerTxt = str_replace('{NAMESPACE}', "App\\Controllers", $controllerTxt);
                        $myFile = fopen($file, "w") or die("Unable to open file!");
                        fwrite($myFile, $controllerTxt);
                        fclose($myFile);
                        echo "success \n";
                        return;
                    }
                }


                break;
            default:
                throw new \Exception('Unexpected value');
        }
        echo "Failed \n";
    }

    public function readFile($path)
    {
        $handle = fopen($path, "r");
        $contents = fread($handle, filesize($path));
        fclose($handle);

        return $contents;
    }
}