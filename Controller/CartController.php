<?php
require_once '../Models/User.php';
require_once 'DBController.php';
require_once 'Authcontroller.php';

class CartController
{
    public $db;

    public function getUserCart(User $user)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "select * FROM `cart` WHERE buyer_id = '$user->id'";
            $result = $this->db->select($query);
            return $result[0];
        } else {
            echo "Error in Database Connection";
            return false;
        }
    }


    public function getCartId($currUser)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "select id FROM `cart` WHERE buyer_id = '$currUser'";
            $result = $this->db->select($query);
            return $result;
        } else {
            echo "Error in Database Connection";
            return false;
        }
    }

    public function createCart($user_id)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "insert INTO `cart` (`id`, `buyer_id`) VALUES ('', '$user_id')";
            $result = $this->db->insert($query);
            if ($result != false) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                return true;
            } else {
                // $_SESSION["errMsg"] = "Somthing went wrong... try again later";
                return false;
            }
        } else {
            echo "Error in Database Connection";
            return false;
        }
    }



    public function addToCart(User $user, $product_id, $quantity)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $userCart = $this->getUserCart($user); // get user cart to add product to it
            $query = "insert INTO cart_product VALUES ('".$userCart['id']."', '$product_id', '$quantity');";
            $result = $this->db->insert($query);
            if ($result != false) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $this->db->closeConnection();
                return true;
            } else {
                $_SESSION["errMsg"] = "Somthing went wrong... try again later";
                $this->db->closeConnection();
                return false;
            }
        } else {
            echo "Error in Database Connection";
            return false;
        }
    }

    public function getCartItems(User $user)
    {
       $this->db = new DBController;
       if ($this->db->openConnection()) {
          $userCart = $this->getUserCart($user); // get user cart to add product to it
          $query = "select * FROM product INNER JOIN cart_product ON product.id = cart_product.product_id WHERE cart_product.cart_id ='".$userCart['id']."'";
          return $this->db->select($query);
       } else {
          echo "Error in Database Connection";
          return false;
       }
    }
 

    public function removeFromCart($id)
    {
       $this->db = new DBController;
       if ($this->db->openConnection()) {
          $query = "delete from cart_product where product_id ='$id'";
          return $this->db->delete($query);
       } else {
          echo "Error in Database Connection";
          return false;
       }
    }

    // testing
    public function emptyingCart($cartId)
    {
       $this->db = new DBController;
       if ($this->db->openConnection()) {
          $query = "delete from cart_product where cart_id='$cartId'";
          return $this->db->delete($query);
       } else {
          echo "Error in Database Connection";
          return false;
       }
    }


}
