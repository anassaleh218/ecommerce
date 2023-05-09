<?php

class Billing
{
  private $id;
  private $flatNo;
  private $buildingNo;
  private $street;
  private $city;
  private $country;
  private $phone;
  private $email;
  private $creditCardHolderName;
  private $creditCardType;
  private $creditCardNum;
  private $expMonth;
  private $expYear;
  private $cvv;
  private $orderId;
  private $buyerId;

  function set_flatNo($fno)
  {
    $this->flatNo = $fno;
  }
  function set_buildingNo($bno)
  {
    $this->buildingNo = $bno;
  }
  function set_street($street)
  {
    $this->street = $street;
  }
  function set_city($city)
  {
    $this->city = $city;
  }
  function set_country($country)
  {
    $this->country = $country;
  }
  function set_phone($phone)
  {
    $this->phone = $phone;
  }
  function set_email($email)
  {
    $this->email = $email;
  }
  function set_creditCardHolderName($cchn)
  {
    $this->creditCardHolderName = $cchn;
  }
  function set_creditCardType($cct)
  {
    $this->creditCardType = $cct;
  }
  function set_creditCardNum($ccn)
  {
    $this->creditCardNum = $ccn;
  }

  function set_expMonth($expMonth)
  {
    $this->expMonth = $expMonth;
  }


  function set_expYear($expYear)
  {
    $this->expYear = $expYear;
  }

  function set_cvv($cvv)
  {
    $this->cvv = $cvv;
  }
  
  function set_orderId($orderId)
  {
    $this->orderId = $orderId;
  }
  
  function set_buyerId($bId)
  {
    $this->buyerId = $bId;
  }


//
function get_flatNo()
  {
    return $this->flatNo;
  }
  function get_buildingNo()
  {
    return $this->buildingNo;
  }

  function get_street()
  {
    return $this->street;
  }
  function get_city()
  {
    return $this->city;
  }
  function get_country()
  {
    return $this->country;
  }
  function get_phone()
  {
    return $this->phone;
  }
  function get_email()
  {
    return $this->email;
  }


  function get_creditCardHolderName()
  {
    return $this->creditCardHolderName;
  }
  function get_creditCardType()
  {
    return $this->creditCardType;
  }
  function get_creditCardNum()
  {
    return $this->creditCardNum;
  }

  function get_expMonth()
  {
    return $this->expMonth;
  }


  function get_expYear()
  {
    return $this->expYear;
  }

  function get_cvv()
  {
    return $this->cvv;
  }
  
  function get_orderId()
  {
    return $this->orderId;
  }

  function get_buyerId()
  {
    return $this->buyerId;
  }



  public function adding($flatNo, $buildingNo, $street, $city, $country, $phone, $email, $creditCardHolderName,$creditCardType,$creditCardNum,$expMonth,$expYear,$cvv,$orderId,$buyerId)
  {
    $this->flatNo = $flatNo;
    $this->buildingNo = $buildingNo;
    $this->street = $street;
    $this->city = $city;
    $this->country = $country;
    $this->phone = $phone;
    $this->email = $email;
    $this->creditCardHolderName = $creditCardHolderName;
    $this->creditCardType = $creditCardType;
    $this->creditCardNum = $creditCardNum;
    $this->expMonth = $expMonth;
    $this->expYear = $expYear;
    $this->cvv = $cvv;
    $this->orderId = $orderId;
    $this->buyerId = $buyerId;
}

}
?>