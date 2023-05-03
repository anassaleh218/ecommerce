<?php
require_once '../Models/User.php';
require_once '../Controller/DBController.php';

class Authcontroller 
{
    public $db ; 
    //1.open connection 
    //2.run query 
    //3. close connection 

    public function login(User $user)
    {
        $this->db=new DBController;
        if($this->db->openConnection())
        {
            
            $query="select * from user where username='$user->username' and password ='$user->password'";
            $result=$this->db->select($query);
            
            if($result===false)
            {
                echo "Error in Query";
                return false;
            }
            else
            {
                if(count($result)==0)
                {
                  
                    session_start();
                    $_SESSION["errMsg"]="You have entered wrong email or password";
                    $this->db->closeConnection();
                    return false;
                }
                else
                {
                   
                    session_start();
                    $_SESSION["id"]=$result[0]["id"];
                    $_SESSION["userName"]=$result[0]["username"];
                    $_SESSION["role_id"]=$result[0]["role_id"];
                    if($_SESSION["role_id"]=='1')
                    {
                       
                        $_SESSION[0]["userRole"]="Admin";
                        
                    }
                    else
                    {
                        $_SESSION[0]["userRole"]="Client";
                    }
                    $this->db->closeConnection();
                    return true;
                }
            }
        }
        else
        {
            echo "Error in Database Connection";
            return false;
        }
    }
    public function register(User $user)
    {
        $this->db=new DBController;
        if($this->db->openConnection())
        {
            $query="insert into user values ('','$user->fullname','$user->username','$user->email','$user->password','$user->phone','$user->address','2')";
            $result=$this->db->insert($query);
            if($result!=false)
            {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                  }
            
                $_SESSION["id"]=$result;
                $_SESSION["userName"]=$user->username;
                $_SESSION["userRole"]="Client";
                $this->db->closeConnection();
                return true;
            }
            else
            {
                $_SESSION["errMsg"]="Somthing went wrong... try again later";
                $this->db->closeConnection();
                return false;
            }
        }
        else
        {
            echo "Error in Database Connection";
            return false;
        }
    }
    
}
?>