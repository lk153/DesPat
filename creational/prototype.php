<?php
 namespace P;

 class Product {

     /**
      * @var string
      */
     private $name;

     /**
      * @var int
      */
     private $price;

     /**
      * Product constructor.
      * @param string $name
      * @param int $price
      */
     function __construct(string $name, int $price)
     {
         $this->name = $name;
         $this->price = $price;
     }

     /**
      * @param int $price
      */
     public function changePrice(int $price)
     {
         $this->price = $price;
     }
 }

 class Cart {
     /**
      * @var Product[]
      */
     private $item = [];

     /**
      * @param Product $product
      */
     public function addToCart(Product $product): void
     {
         $this->item[] = $product;
     }

     public function getCart()
     {
         return $this->item;
     }

     public function __clone()
     {
         $this->item = [];
     }
 }

 //test
$product1 = new Product('Product1', 100);
$product2 = new Product('Product2', 200);

$cart1 = new Cart();
$cart1->addToCart($product1);
$cart1->addToCart($product2);

$product1New = clone $product1;
$product2New = clone $product2;

$product1New->changePrice(500);
$product2New->changePrice(700);

$cart2 = clone $cart1;
$cart2->addToCart($product1New);
$cart2->addToCart($product2New);
$cart2->addToCart($product1);
$cart2->addToCart($product2);

var_dump($cart1->getCart());
var_dump("=========================");
var_dump($cart2->getCart());