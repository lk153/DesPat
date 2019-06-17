<?php
namespace AF;

//Abstract Factory
abstract class AbstractVehicleFactory
{
    abstract function createCar() : AbstractCar;
    abstract function createBike() : AbstractBike;
}

//Concrete Factory
class MazdaFactory extends AbstractVehicleFactory
{
    public function createCar() : AbstractCar
    {
        return new MazdaCar();
    }

    public function createBike(): AbstractBike
    {
        return new MazdaBike();
    }
}

class ToyotaFactory extends AbstractVehicleFactory
{
    public function createCar() : AbstractCar
    {
        return new ToyotaCar();
    }

    public function createBike(): AbstractBike
    {
        return new ToyotaBike();
    }
}

//Abstract Products
interface VehicleInterface
{
    public function setName(string $name) : VehicleInterface;
    public function run();
}

abstract class AbstractCar implements VehicleInterface
{
    protected $name;
    protected $wheels;

    function __construct()
    {
        $this->wheels = 4;
    }

    public function setName(string $name): VehicleInterface
    {
        $this->name = $name;

        return $this;
    }

    public function run()
    {
        printf("%s car is driven \n", $this->name);
    }
}

abstract class AbstractBike implements VehicleInterface
{
    protected $name;
    protected $wheels;

    function __construct()
    {
        $this->wheels = 2;
    }

    public function setName(string $name): VehicleInterface
    {
        $this->name = $name;

        return $this;
    }

    public function run()
    {
        printf("%s bike is ridden \n", $this->name);
    }
}

//Concrete Products
class MazdaCar extends AbstractCar
{
    function __construct()
    {
        parent::__construct();
        $this->name = 'Mazda_Car';
    }
}

class MazdaBike extends AbstractBike
{
    function __construct()
    {
        parent::__construct();
        $this->name = 'Mazda_Bike';
    }
}

class ToyotaCar extends AbstractCar
{
    function __construct()
    {
        parent::__construct();
        $this->name = 'Toyota_Car';
    }
}

class ToyotaBike extends AbstractBike
{
    function __construct()
    {
        parent::__construct();
        $this->name = 'Toyota_Bike';
    }
}

//Client
class ClientFM
{

    /**
     * @param AbstractVehicleFactory $factory
     */
    protected $factory;
    function __construct(AbstractVehicleFactory $factory)
    {
        $this->factory = $factory;
    }

    public function setVehicleFactory(AbstractVehicleFactory $factory) {
        $this->factory = $factory;
    }

    public function getBike() {
        return $this->factory->createBike();
    }

    public function getCar() {
        return $this->factory->createCar();
    }
}

//test
$mazdaFactory = new MazdaFactory();
$client = new ClientFM($mazdaFactory);
$client->getBike()->run();
$client->getCar()->run();

$toyotaFactory = new ToyotaFactory();
$client->setVehicleFactory($toyotaFactory);
$client->getBike()->run();
$client->getCar()->run();


