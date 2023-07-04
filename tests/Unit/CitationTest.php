<?php

namespace App\Tests\Unit;

use App\Entity\Citations;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CitationTest extends KernelTestCase
{

    public function getEntity(): Citations
    {
        return (new Citations())
            ->setCitation('test')
            ->setExplication('test')
            ->setAuteurs(null);
    }


    public function testEntityIsValid(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $citation = $this->getEntity();

        $error = $container->get('validator')->validate($citation);

        $this->assertCount(0, $error);
    }

    public function testInvalidName(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $citation = $this->getEntity()->setCitation('');

        $error = $container->get('validator')->validate($citation);

        $this->assertCount(1, $error);
    }
}
