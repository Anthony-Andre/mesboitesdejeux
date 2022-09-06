<?php

use App\Entity\Adress;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AdressTest extends TestCase
{
  public function testAdress()
  {
    $adress = new Adress; 
    $name = "adressName";

    $adress->setName($name);
    $this->assertEquals("adressName", $adress->getName());
  }
}