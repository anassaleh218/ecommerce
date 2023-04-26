<?php 

class User {
  private $id;
  private $username;
  private $password;
  private $fullname;
  private $email;
  private $phone;

  public function __construct($id, $username, $password, $fullname, $email, $phone) {
    $this->id = $id;
    $this->username = $username;
    $this->password = $password;
    $this->fullname = $fullname;
    $this->email = $email;
    $this->phone = $phone;
  }

  public function login($username, $password) {

  }

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

?>