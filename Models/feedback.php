<?php
class Feedback{
    
    private $name;
    private $rate;
    private $feedback;
    private $buyerId;
    private $productId;

    public function adding($name, $rate, $feedback, $buyerId, $productId)
    {
        $this->name = $name;
        $this->rate = $rate; 
        $this->feedback = $feedback;
        $this->buyerId = $buyerId;
        $this->productId = $productId;
    }

    function get_name()
    {
      return $this->name;
    }
    function get_rate()
    {
      return $this->rate;
    }
    function get_feedback()
    {
      return $this->feedback;
    }
    function get_buyerId()
    {
      return $this->buyerId;
    }
    function get_productId()
    {
      return $this->productId;
    }
    

}
?>