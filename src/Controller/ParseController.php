<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ParseController extends AbstractController
{
    /**
     * @Route("/parse", name="parse")
     */
    public function index()
    {
        $txt = file_get_contents('https://raw.githubusercontent.com/betagouv/api-medicaments/master/data/CIS_GENER_bdpm.txt');
        $rows = explode(PHP_EOL, $txt);
//        dump($rows);
        foreach ($rows as $row)
        {
            dump($row);
            $row0 = explode(',',$rows[0]);
            dump($row0);
            $medoc = substr(   $row[0], 2);
            dump($medoc);
            $type = ltrim($row[1]);
        }

//        if (preg_match_all('#\b(comprim)*(pellicul)\b#', strtolower($type), $matches)) {
//            print_r($matches);
//        } elseif (preg_match_all('#\b(comprim)*(effervescent)\b#', strtolower($type), $matches)) {
//            echo 'teste2';
//        } elseif (preg_match_all('#\b(pieces)\b#', strtolower($type), $matches)) {
//            echo 'teste3';
//        } else {
//            echo 'failed';
//        }





        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ParseController.php',

        ]);
    }
}
