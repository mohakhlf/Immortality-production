<?php

namespace App\DataFixtures;

use App\Entity\Drug;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DrugFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $drugs = [
            'CIMETIDINE' => 'Comprimés pilule',
            'RANITIDINE' => 'Comprimés effervescent',
            'FAMOTIDINE' => 'Comprimés sécable',
            'OMEPRAZOLE' => 'Comprimés pilule',
            'SUCRALFATE' => 'Comprimés effervescent',
            'PHLOROGLUCINOL' => 'Comprimés sécable',
            'MEBEVERINE' => 'Comprimés pilule',
            'TRIMEBUTINE' => 'Comprimés effervescent',
            'METOCLOPRAMIDE' => 'Comprimés sécable',
            'DOMPERIDONE' => 'Comprimés pilule',
            'LACTULOSE' => 'Comprimés effervescent',
            'NIFUROXAZIDE' => 'Comprimés sécable',
            'LOPERAMIDE' => 'Comprimés pilule',
            'CROMOGLICATE' => 'Comprimés effervescent',
            'METFORMINE' => 'Comprimés sécable',
        ];

        foreach ($drugs as $drug => $type)
        {
            $medoc = new Drug();
            $medoc->setName($drug);
            $medoc->setType($type);
            $manager->persist($medoc);
        }
        $manager->flush();
    }
}
