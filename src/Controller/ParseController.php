<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParseController extends AbstractController
{
    /**
     * @Route("/parse", name="parse")
     */
    public function index()
    {
        $txt = file_get_contents('/Volumes/Travail/WILD_CODE_SCHOOL/Hakathon_panda/public/assets/text/CIS_GENER_bdpm.txt');
        $txtArray = file('/Volumes/Travail/WILD_CODE_SCHOOL/Hakathon_panda/public/assets/text/CIS_GENER_bdpm.txt');
        dump($txt);
//        $rows = explode(PHP_EOL, $txt);
////        dump($rows);
//        foreach ($rows as $row)
//        {
//            dump($row);
//            $rowInfo = explode(',',$row);
//            dump($rowInfo);
//            $info1 = ltrim($rowInfo[0], "  \t\n\r\0\x0B");
//            $info2 = ltrim($rowInfo[1], "  \t\n\r\0\x0B \t.");
//
//            $drug = substr($info1, 2);
//            $type = trim($info2, " \t\n\r\0\x0B \t.");
//
////            dump($drug, $type);
//            dump($drug);
//
////            if (preg_match_all('#\b(comprim*|pellicul*)\b#', $info2, $matches0)) {
////                dump($matches0);
////            } elseif (preg_match_all('#\b(comprim*|effervescent*)\b#', $info2, $matches1)) {
////                dump($matches1);
////            } elseif (preg_match_all('#\b(gelule)\b#', $info2, $matches2)) {
////                dump($matches2);
////            } elseif (preg_match_all('#\b(pieces)\b#', $info2, $matches3)) {
////                dump($matches3);
////            } elseif (preg_match_all('#\b(pieces)\b#', $info2, $matches4)) {
////                dump($matches4);
////            } elseif (preg_match_all('#\b(pieces)\b#', $info2, $matches5)) {
////                dump($matches5);
////            } elseif (preg_match_all('#\b(pieces)\b#', $info2, $matches6)) {
////                dump($matches6);
////            } elseif (preg_match_all('#\b(pieces)\b#', $info2, $matches7)) {
////                dump($matches7);
////            } else {
////                echo 'failed';
////            }
//        }
//
//
//
//
//
//        return $this->render('Parse/index.html.twig', [

//        ]);
    }
}
