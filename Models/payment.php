<?php
class payment extends buyer
{

  private $buyerId;
  private $creditCardType;
  private $creditCardNum;
  private $creditCardHolderName;


  public function __construct($buyerId, $creditCardType, $creditCardNum, $creditCardHolderName)
  {

    $this->buyerId = $buyerId;
    $this->creditCardType = $creditCardType;
    $this->creditCardNum = $creditCardNum;
    $this->creditCardHolderName = $creditCardHolderName;
  }
  function get_buyerId()
  {
    return $this->buyerId;
  }

  function get_creditCardType()
  {
    return $this->creditCardType;
  }
  function get_creditCardNum()
  {
    return $this->creditCardNum;
  }
  function get_creditCardHolderName()
  {
    return $this->creditCardHolderName;
  }
  function set_buyerId($bId)
  {
    $this->buyerId = $bId;
  }
  function set_creditCardType($cct)
  {
    $this->creditCardType = $cct;
  }

  function set_creditCardNum($ccn)
  {
    $this->creditCardNum = $ccn;
  }
  function set_creditCardHolderName($cchn)
  {
    $this->creditCardHolderName = $cchn;
  }
  
  // function add()
  // {
  // }

  // function remove()
  // {
  // }
}

?>
