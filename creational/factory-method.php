<?php
namespace FM;

//Abstract Product
interface CarInterface {
    public function getName() : string ;
}

//Creator
abstract class AbstractCarCreator {
    abstract public function createCar() : CarInterface; //factory method

    public function getCarName() : string {
        return $this->createCar()->getName();
    }
}

//Concrete Creator
class MazdaCreator extends AbstractCarCreator {
    public function createCar() : CarInterface
    {
        return new MazdaCar();
    }
}

class ToyotaCreator extends AbstractCarCreator {
    public function createCar() : CarInterface
    {
        return new ToyotaCar();
    }
}

//Concrete Product
class MazdaCar implements CarInterface {
    public function getName(): string
    {
        return 'Mazda';
    }
}

class ToyotaCar implements CarInterface {
    public function getName(): string
    {
        return 'Toyota';
    }
}

//Client
class Client {

    /**
     * @var AbstractCarCreator
     */
    protected $carCreator;

    /**
     * @var string
     */
    protected $name = 'N\A';

    function __construct(AbstractCarCreator $carCreator)
    {
        $this->carCreator = $carCreator;
    }

    public function drive() {
        printf("%s is driving %s car \n", $this->name, $this->carCreator->getCarName());
    }

    public function setName(string $name) : Client {
        $this->name = $name;

        return $this;
    }
}

//test
$client1 = new Client(new MazdaCreator());
$client1->setName('Lucas')->drive();

$client2 = new Client(new ToyotaCreator());
$client2->setName('Edward')->drive();