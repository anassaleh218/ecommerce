<?php
require_once '../Models/User.php';
require_once 'DBController.php';
require_once 'Authcontroller.php';

class OrderController
{
    public $db;

    // public function getUserCart(User $user)
    // {
    //     $this->db = new DBController;
    //     if ($this->db->openConnection()) {
    //         $query = "select * FROM `cart` WHERE buyer_id = '$user->id'";
    //         $result = $this->db->select($query);
    //         return $result[0];
    //     } else {
    //         echo "Error in Database Connection";
    //         return false;
    //     }
    // }

    public function createOrder($user_id)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "insert INTO `order` (`id`, `buyer_id`) VALUES ('', '$user_id')";
            $result = $this->db->insert($query);
            if ($result != false) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                // $_SESSION["cart_id"] = $result;
                return $result;
            } else {
                $_SESSION["errMsg"] = "Somthing went wrong... try again later";
                return false;
            }
        } else {
            echo "Error in Database Connection";
            return false;
        }
    }



    public function addToOrder($orderId, $cart_items)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {

            //
            
            foreach($cart_items as $item) {
                $product_id = $item['id'];
            }


            $query = "insert INTO order_product (`order_id`, `product_id`) VALUES ('$orderId', '$product_id');";
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

    public function getOrderItems($orderId)
    {
       $this->db = new DBController;
       if ($this->db->openConnection()) {
          $query = "select * ,quantity * start_price AS total_price FROM product INNER JOIN order_product ON product.id = order_product.product_id WHERE order_product.order_id ='$orderId'";
          return $this->db->select($query);
       } else {
          echo "Error in Database Connection";
          return false;
       }
    }

    public function getOrderProductsSubtotal($orderId)
    {
       $this->db = new DBController;
       if ($this->db->openConnection()) {
          $query = "select SUM(product.quantity * product.start_price) AS subtotal FROM product INNER JOIN order_product ON product.id = order_product.product_id WHERE order_product.order_id ='$orderId';";
          return $this->db->select($query);
       } else {
          echo "Error in Database Connection";
          return false;
       }
    }
 

    // public function removeFromCart($id)
    // {
    //    $this->db = new DBController;
    //    if ($this->db->openConnection()) {
    //       $query = "delete from cart_product where product_id ='$id'";
    //       return $this->db->delete($query);
    //    } else {
    //       echo "Error in Database Connection";
    //       return false;
    //    }
    // }

}