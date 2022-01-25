<?php

namespace App\DataFixtures;

use App\Entity\Asset;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class AssetFixture extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['seeder'];
    }

    public function load(ObjectManager $manager)
    {
        $appl = new Asset();
        $appl->setName("Apple Inc.");
        $appl->setISIN("US0378331005");
        $appl->setSymbol("AAPL");
        $appl->setType(Asset::TYPE_STOCK);
        $appl->setCurrency("USD");
        $appl->setCountry("US");
        $manager->persist($appl);

        $msft = new Asset();
        $msft->setName("Microsoft Corp.");
        $msft->setISIN("US5949181045");
        $msft->setSymbol("MSFT");
        $msft->setType(Asset::TYPE_STOCK);
        $msft->setCurrency("USD");
        $msft->setCountry("US");
        $manager->persist($msft);

        $sie = new Asset();
        $sie->setName("Siemens AG");
        $sie->setISIN("DE0007236101");
        $sie->setSymbol("SIE");
        $sie->setType(Asset::TYPE_STOCK);
        $sie->setCurrency("EUR");
        $sie->setCountry("DE");
        $sie->setMarketWatch("xe:sie");
        $manager->persist($sie);

        $manager->flush();
    }
}
