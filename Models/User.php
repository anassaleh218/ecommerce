<?php 

class User {
  public $id;
  public $username;
  public $password;
  public $fullname;
  public $email;
  public $phone;
  public $address;
  public $roleid;




  public function addWithId($id, $fullname, $username ,$roleid) {
    $this->id = $id;
    $this->fullname = $fullname;
    $this->username = $username;
    $this->roleid = $roleid;
  }

  public function add($fullname, $username ,$email,$password, $phone,$address , $roleid) {
    $this->fullname = $fullname;
    $this->username = $username;
    $this->password = $password;
    $this->email = $email;
    $this->phone = $phone;
    $this->address = $address;
    $this->roleid = $roleid;
  }
  
  public function __construct(){

  }

  public function login($username, $password) {

  }


  // public function getUserRole() {
  //   $auth = new AuthController;
  //   return $auth->getRoleNameById($this->roleid)[0]['role_name'];
  // }

  public function logout() {
  }

  public function register($fullname, $username, $password, $phone, $email) {
  }

  public function getId() {
    return $this->id;
  }

  public function getUsername() {
    return $this->username;
  }

  public function getFullname() {
    return $this->fullname;
  }

  public function getEmail() {
    return $this->email;
  }

  public function getPhone() {
    return $this->phone;
  }
}
