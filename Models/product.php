<?php

class Product
{
  public $id;
  public $name;
  public $description;
  public $quantity;
  public $status;
  public $color;
  public $sizeid;
  public $price;
  public $categoryid;
  public $sellerid;
  public $image;



  // public function __construct($name,$description,$quantity,$color,$sizeid,$price,$categoryid,$sellerid,$image){

  //     $this->name = $name;
  //     $this->description = $description;
  //     $this->quantity = $quantity;
  //     $this->color= $color;
  //     $this->sizeid=$sizeid;
  //     $this->price = $price;
  //     $this->categoryid = $categoryid;
  //     $this->sellerid=$sellerid;
  //     $this->image = $image;

  // }

  public function adding($name, $categoryid, $sizeid, $color, $description, $quantity, $price)
  {
    $this->name = $name;
    $this->categoryid = $categoryid;
    $this->sizeid = $sizeid;
    $this->color = $color;
    $this->description = $description;
    $this->quantity = $quantity;
    $this->price = $price;
    
    //     $this->sellerid=$sellerid;
    //     $this->image = $image;


  }
}

?>



<!-- 

class Product {
  private $name;
  private $description;
  private $price;
  private $quantity;
  private $categoryid;
  private $image;

  public function __construct($name, $description, $price, $quantity, $categoryid, $image) {
    $this->name = $name;
    $this->description = $description;
    $this->price = $price;
    $this->quantity = $quantity;
    $this->categoryid = $categoryid;
    $this->image = $image;
  }

  public function save() {
    // code to save the product to the database
  }

  // getters and setters for each property
  public function setName($name) {
    $this->name = $name;
  }

  public function getName() {
    return $this->name;
  }

  // repeat for the other properties

}

if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price']) && isset($_POST['quantity']) && isset($_FILES["image"])) {
  if (!empty($_POST['name']) && !empty($_POST['description']) && !empty($_POST['price']) && !empty($_POST['quantity'])) {
    $product = new Product($_POST['name'], $_POST['description'], $_POST['price'], $_POST['quantity'], $_POST['category'], $_FILES["image"]);
    $product->save();
  }
}


 -->