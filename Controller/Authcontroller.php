<?php
require_once '../Models/User.php';
require_once 'DBController.php';
require_once 'CartController.php';

class Authcontroller
{
    public $db;


    public function login(User $user)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {

            $query = "select * from user where username='$user->username'";
            $result = $this->db->select($query);

            if ($result === false) {
                echo "Error in Query";
                return false;
            } else {
                if (count($result) == 0) {

                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    $_SESSION["errMsg"] = "You have entered wrong email or password";
                    $this->db->closeConnection();
                    return false;
                } else {
                    ////////////////
                    if ($result[0]["blocked"] == 0) {
                        $stored_password = $result[0]["password"];
                        $user_password = $user->password;
                        if (password_verify($user_password, $stored_password)) {
                            // Password is correct
                            $myUser = new User();
                            if (session_status() === PHP_SESSION_NONE) {
                                session_start();
                            }
                            $_SESSION["id"] = $result[0]["id"];
                            $_SESSION["userName"] = $result[0]["username"];
                            $_SESSION["roleId"] = $result[0]["role_id"];
                            $_SESSION["fullName"] = $result[0]["fullname"];

                            $myUser->roleid = $_SESSION["role_id"];
                            $this->db->closeConnection();
                            return true;
                        } else {
                            // Password is incorrect
                            $_SESSION["errMsg"] = "You have entered wrong email or password";
                            $this->db->closeConnection();
                            return false;
                        }
                    } else {
                        $_SESSION["errMsg"] = "You are blocked";
                        $this->db->closeConnection();
                        return false;
                    }
                    ////////////////


                }
            }
        } else {
            echo "Error in Database Connection";
            return false;
        }
    }


    public function register(User $user)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $hash_pass = password_hash($user->password, PASSWORD_DEFAULT);
            $query = "insert into user values ('','$user->fullname','$user->username','$user->email','$hash_pass','$user->phone','$user->address','','$user->roleid')";
            $result = $this->db->insert($query);
            if ($result != false) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION["id"] = $result;
                $_SESSION["userName"] = $user->username;
                $_SESSION["fullName"] = $user->fullname;
                $_SESSION["roleId"] = $user->roleid;
                // $_SESSION["userRole"] = "Client";

                $cart = new CartController();
                $cart->createCart($result); // create cart for the new user with id $result

                // $order = new OrderController();
                // $order->createOrder($result);// create order for the new user with id $result

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


    public function getRoles()
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "select * from role";
            return $this->db->select($query);
        } else {
            echo "Error in Database Connection";
            return false;
        }
    }


    public function getCurrentUser()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION["id"]) && isset($_SESSION["fullName"]) && isset($_SESSION["userName"]) && isset($_SESSION["roleId"])) {
            $currentUser = new User();
            $currentUser->addWithId($_SESSION["id"], $_SESSION["fullName"], $_SESSION["userName"], $_SESSION["roleId"]);
            return $currentUser;
        } else {
            return false;
        }
    }

    public function getUserRole(User $user)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {
            $query = "select role_name from role where id = '$user->roleid'";
            $result = $this->db->select($query);
            return $result[0]['role_name'];
        } else {
            echo "Error in Database Connection";
            return false;
        }
    }

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

    // public function createCart($user_id)
    // {
    //     $this->db = new DBController;
    //     if ($this->db->openConnection()) {
    //         $query = "insert INTO `cart` (`id`, `buyer_id`) VALUES ('', '$user_id')";
    //         $result = $this->db->insert($query);
    //         if ($result != false) {
    //             if (session_status() === PHP_SESSION_NONE) {
    //                 session_start();
    //             }
    //             return true;
    //         } else {
    //             $_SESSION["errMsg"] = "Somthing went wrong... try again later";
    //             return false;
    //         }
    //     } else {
    //         echo "Error in Database Connection";
    //         return false;
    //     }
    // }



    // public function addToCart(User $user, $product_id)
    // {
    //     $this->db = new DBController;
    //     if ($this->db->openConnection()) {
    //         $userCart = $this->getUserCart($user); // get user cart to add product to it
    //         $query = "insert INTO `cart_product` (`cart_id`, `product_id`) VALUES ('$userCart->id', '$product_id');";
    //         $result = $this->db->insert($query);
    //         if ($result != false) {
    //             if (session_status() === PHP_SESSION_NONE) {
    //                 session_start();
    //             }
    //             $this->db->closeConnection();
    //             return true;
    //         } else {
    //             $_SESSION["errMsg"] = "Somthing went wrong... try again later";
    //             $this->db->closeConnection();
    //             return false;
    //         }
    //     } else {
    //         echo "Error in Database Connection";
    //         return false;
    //     }
    // }



}
