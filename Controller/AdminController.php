<?php 

require_once '../Models/category.php';
require_once 'DBController.php';
class AdminController
{
    protected $db;
    
    public function addCategory(Category $cat)
    {
        $this->db=new DBController;
        if($this->db->openConnection())
        {
            $query="insert into category values ('','".$cat->getName()."')";
            $result=$this->db->insert($query);
            if($result!=false)
            {
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

    public function deleteCategory($id)
    {
       $this->db = new DBController;
       if ($this->db->openConnection()) {
          $query = "delete from category where id = $id";
          return $this->db->delete($query);
       } else {
          echo "Error in Database Connection";
          return false;
       }
    }

    public function blockUser($email)
    {
        $this->db=new DBController;
        if($this->db->openConnection())
        {
            $query="update user set `blocked` = '1' WHERE user.email = \"".$email."\"";
            $result=$this->db->update($query);
            if($result!=false)
            {
                
                $this->db->closeConnection();
                return true;
            }
            else
            {
                $_SESSION["errMsg"]="Email is wrong or User already blocked";
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


    public function unblockUser($email)
    {
        $this->db=new DBController;
        if($this->db->openConnection())
        {
            $query="update user set `blocked` = '0' WHERE user.email = \"".$email."\"";
            $result=$this->db->update($query);
            if($result!=false)
            {
                
                $this->db->closeConnection();
                return true;
            }
            else
            {
                $_SESSION["errMsg"]="Email is wrong or User already unblockUser";
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
    public function getBlockUsers()
    {
       $this->db = new DBController;
       if ($this->db->openConnection()) {
          $query = "select * FROM user WHERE user.blocked = 1";
          return $this->db->select($query);
       } else {
          echo "Error in Database Connection";
          return false;
       }
    }


}
