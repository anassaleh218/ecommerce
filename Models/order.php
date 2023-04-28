<?php


class order
{

 private $id;
 private $buyer_id;


 public function __construct($id,$buyer_id){
         $this->id=$id;
         $this->buyer_id=$buyer_id;

 }

 function getId(){
       return $this->id;

 }

 function getBuyerId(){
    return $this->buyer_id;

}
 function add($product){

 }

  function getOrderDetails(){

 }
   function modify (){


 }
   function delete ($id){

 }
}
