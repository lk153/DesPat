<?php
namespace B;

//Abstract Product
interface VehicleInterface
{
    public function showDetails() : void;
}

abstract class AbstractVehicle implements VehicleInterface
{
    protected $wheels;
    protected $name;
    protected $engine;
}

//Concrete Product
class Car extends AbstractVehicle
{
    public function showDetails(): void
    {
        printf("%s car with %s wheels and %s engine \n", $this->name, $this->wheels, $this->engine);
    }

    public function setWheel(int $wheels)
    {
        $this->wheels = $wheels;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setEngine(string $engine)
    {
        $this->engine = $engine;
    }
}

class Bike extends AbstractVehicle
{
    public function showDetails(): void
    {
        printf("%s bike with %s wheels \n", $this->name, $this->wheels);
    }

    public function setWheel(int $wheels)
    {
        $this->wheels = $wheels;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }
}

//Abstract Builder
interface VehicleWithEngineInterface extends VehicleWithoutBuilderInterface
{
    public function setEngine(string $engine) : VehicleInterface;
}

interface VehicleWithoutBuilderInterface
{
    public function setWheel(int $wheels) : VehicleInterface;
    public function setName(string $name) : VehicleInterface;
    public function getProduct() : VehicleInterface;
}

//Concrete Builder
class CarBuilder implements VehicleWithEngineInterface
{
    /**
     * @var Car
     */
    protected $car;

    public function __construct()
    {
        $this->car = new Car();
    }

    public function setWheel(int $wheels): VehicleInterface
    {
        $this->car->setWheel($wheels);

        return $this->car;
    }

    public function setName(string $name): VehicleInterface
    {
        $this->car->setName($name);

        return $this->car;
    }

    public function setEngine(string $engine): VehicleInterface
    {
        $this->car->setEngine($engine);

        return $this->car;
    }

    public function getProduct() : VehicleInterface
    {
        return $this->car;
    }
}

class BikeBuilder implements VehicleWithoutBuilderInterface
{
    /**
     * @var Bike
     */
    protected $bike;

    public function __construct()
    {
        $this->bike = new Bike();
    }

    public function setWheel(int $wheels): VehicleInterface
    {
        $this->bike->setWheel($wheels);

        return $this->bike;
    }

    public function setName(string $name): VehicleInterface
    {
        $this->bike->setName($name);

        return $this->bike;
    }

    public function getProduct() : VehicleInterface
    {
        return $this->bike;
    }
}

//Director (optional)
class Director {
    /**
     * @var VehicleWithoutBuilderInterface | VehicleWithoutBuilderInterface
     */
    private $builder;

    /**
     * @param string $engine
     * @param string $name
     * @param int $wheels
     * @return VehicleInterface
     */
    public function createCar(string $engine, string $name, int $wheels) : VehicleInterface
    {
        $this->builder = new CarBuilder();
        $this->builder->setEngine($engine);
        $this->builder->setName($name);
        $this->builder->setWheel($wheels);

        return $this->builder->getProduct();
    }

    /**
     * @param string $name
     * @param int $wheels
     * @return VehicleInterface
     */
    public function createBike(string $name, int $wheels) : VehicleInterface
    {
        $this->builder = new BikeBuilder();
        $this->builder->setName($name);
        $this->builder->setWheel($wheels);

        return $this->builder->getProduct();
    }
}

//test
$director = new Director();
$car1 = $director->createCar('W16', 'Bugatti Veyron', 4);
$car1->showDetails();

$car2 = $director->createCar('700 PS', 'Lamborghini Aventador', 4);
$car2->showDetails();

$bike = $director->createBike('Martin', 2);
$bike->showDetails();