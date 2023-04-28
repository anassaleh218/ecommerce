<?php  

class buyer extends user{
private $address;
private $watchList;
private $purchase;

public function __construct($address,$watchList,$purchase){
    $this->address=$address;
    $this->watchList=$watchList;
    $this->purchase=$purchase;

}
function get_address(){
    return $this->address;
}


function get_watchlist(){
    return $this->watchList;
}

function get_purchase(){
    return $this->purchase;
}
 function set_address($ad){
    $this->address=$ad;
 }

 function set_watchList($wl){
    $this->address=$wl;
 }
 function set_purchase($p){
    $this->address=$p;
 }
 function getPurchaseHistory(){

 }

 function addToCart($productid){

}
function removeFromCart(){

}
function addTowatchList(){

}
function getPurchase(){

}

function followSeller($userid){

}
function likeProduct($productid){

}
function unlikeProduct($productid){

}

function rateProduct($productid){

}
function givingFeedback($productid){

}
}
?>