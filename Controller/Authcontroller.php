<?php
require_once '../Models/User.php';
require_once '../Controller/DBController.php';

class Authcontroller
{
    public $db;


    public function login(User $user)
    {
        $this->db = new DBController;
        if ($this->db->openConnection()) {

            $query = "select * from user where username='$user->username' and password ='$user->password'";
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
            $query = "insert into user values ('','$user->fullname','$user->username','$user->email','$user->password','$user->phone','$user->address','','$user->roleid')";
            $result = $this->db->insert($query);
            if ($result != false) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                $_SESSION["id"] = $result;
                $_SESSION["userName"] = $user->username;
                $_SESSION["fullName"] = $user->fullname;
                $_SESSION["roleId"] = $user->roleid;
                $_SESSION["userRole"] = "Client";

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


    // public function getRoles()
    // {
    //     $this->db = new DBController;
    //     if ($this->db->openConnection()) {
    //         $query = "select * from role";
    //         return $this->db->select($query);
    //     } else {
    //         echo "Error in Database Connection";
    //         return false;
    //     }
    // }


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


}
