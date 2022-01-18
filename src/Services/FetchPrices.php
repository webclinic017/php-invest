<?php

namespace App\Services;

use App\Services\DataSources\Marketwatch;
use App\Entity\Asset;
use App\Entity\AssetPrice;
use Doctrine\ORM\EntityManagerInterface;

class FetchPrices
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function updatePrices(Asset $asset, \DateTimeInterface $startdate, \DateTimeInterface $enddate = null)
    {
        if ($enddate == null)
        {
            $enddate = new \DateTime("yesterday");
        }

        if ($startdate > $enddate)
        {
            return 0;
        }

        $prices = Marketwatch::getPrices($asset->getSymbol(), $startdate, $enddate);

        $num_prices = count($prices);
        if ($num_prices == 0)
        {
            return 0;
        }
        else
        {
            //var_dump($prices);
            foreach ($prices as $price)
            {
                $ap = new AssetPrice();
                $ap->setAsset($asset);
                $ap->setDate($price['Date']);
                $ap->setOHLC($price['Open'], $price['High'], $price['Low'], $price['Close']);
                $ap->setVolume($price['Volume']);
                $this->entityManager->persist($ap);
            }
            $this->entityManager->flush();
            return $num_prices;
        }
    }
}
?>
