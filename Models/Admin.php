<?php 
require_once 'User.php';

class Admin extends User 
{
  private $categories;

  public function __construct() {
      $this->categories = [];
  }

  public function addCategory($name) {
      // $this->categories = new Category($name);
  }

  public function modifyCategory($name) {
  }

  public function deleteCategory($id) {
  }

  public function blockUser($userId) {
  }

}

?>