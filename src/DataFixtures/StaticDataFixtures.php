<?php

namespace App\DataFixtures;

use App\Entity\Country;
use App\Entity\Currency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class StaticDataFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array {
        return ['seeders'];
    }

    public function seedCountries($manager, $filename)
    {
        $file = fopen($filename, 'r');
        $header = fgetcsv($file);
        while (($data = fgetcsv($file)))
        {
            $manager->persist(new Country($data[1]));
        }
        fclose($file);
    }

    public function seedCurrencies($manager, $filename)
    {
        $file = fopen($filename, 'r');
        $header = fgetcsv($file);
        while (($data = fgetcsv($file)))
        {
            $manager->persist(new Currency($data[1]));
        }
        fclose($file);
    }

    public function load(ObjectManager $manager)
    {
        $datadir = dirname(__DIR__, 2) . '/data/';
        $this->seedCountries($manager, $datadir . 'countries.csv');
        $this->seedCurrencies($manager, $datadir . 'currencies.csv');

        $manager->flush();
    }
}
