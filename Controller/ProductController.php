<?php

require_once '../Models/product.php';
require_once 'DBController.php';
class ProductController
{

    protected $db;

    //1. Open connection.
    //2. Run query & logic.
    //3. Close connection

    public function getCategories()
    {
         $this->db=new DBController;
         if($this->db->openConnection())
         {
            // $query="select * from category";
            $query="SELECT 
            category.*, 
            SUM(product.quantity) as categoryQuantity
          FROM 
            category 
          LEFT JOIN 
            product 
          ON 
            category.id = product.category_id 
          GROUP BY 
            category.id;";
            return $this->db->select($query);
         }
         else
         {
            echo "Error in Database Connection";
            return false; 
         }
    }
 
    public function getCategoryProducts($id)
    {
         $this->db=new DBController;
         if($this->db->openConnection())
         {
            $query="select product.id,product.name,start_price as price,quantity,product.image,SUM(product.quantity) AS categoryQuantity,category.name as 'category' 
            from product
            join category on product.category_id=category.id
            where product.category_id=category.id
            and category.id = $id
            order by product.id asc
            ";
            return $this->db->select($query);
         }
         else
         {
            echo "Error in Database Connection";
            return false; 
         }
    }


   public function getSizes()
   {
      $this->db = new DBController;
      if ($this->db->openConnection()) {
         $query = "select * from product_size";
         return $this->db->select($query);
      } else {
         echo "Error in Database Connection";
         return false;
      }
   }


   public function addProduct(Product $product)
   {
      $this->db = new DBController;
      if ($this->db->openConnection()) {
         if ($product->quantity == 0) {
            $product->status = 'Out Of Stock';
         } else {
            $product->status = 'Available';

         }
         // $product->sellerid=
         $query = "insert into product values ('','$product->name','$product->description','$product->quantity','$product->status','$product->color',$product->sizeid,'$product->price',$product->categoryid,'2','$product->image')";
         return $this->db->insert($query);
      } else {
         echo "Error in Database Connection";
         return false;
      }
   }


   public function getAllProducts()
   {
      $this->db = new DBController;
      if ($this->db->openConnection()) {
         $query = "select product.id,product.name,start_price as price,quantity,product.image,category.name as 'category' from product join category on product.category_id=category.id order by product.id asc;";
         return $this->db->select($query);
      } else {
         echo "Error in Database Connection";
         return false;
      }
   }
   
   public function deleteProduct($id)
   {
      $this->db = new DBController;
      if ($this->db->openConnection()) {
         $query = "delete from product where id = $id";
         return $this->db->delete($query);
      } else {
         echo "Error in Database Connection";
         return false;
      }
   }



   public function getProductById($id)
   {
      $this->db = new DBController;
      if ($this->db->openConnection()) {
         $query = "select * FROM product WHERE product.id = '$id'";
         return $this->db->select($query);
      } else {
         echo "Error in Database Connection";
         return false;
      }
   }


   public function updateProduct(Product $product, $id)
   {

      $this->db = new DBController;
      if ($this->db->openConnection()) {
         $query = "update product set name = '$product->name',color = '$product->color',description = '$product->description',quantity = '$product->quantity',status = '$product->status',start_price = '$product->price',category_id = '$product->categoryid',seller_id = '2',image = '$product->image' WHERE product.id = '$id'";
         //  $query="update user set `blocked` = '1' WHERE user.email = \"".$email."\"";
         $result = $this->db->update($query);
         if ($result != false) {
            $this->db->closeConnection();
            return true;
         } else {
            $_SESSION["errMsg"] = "Email is wrong or User already blocked";
            $this->db->closeConnection();
            return false;
         }
      } else {
         echo "Error in Database Connection";
         return false;
      }


      // $this->db=new DBController;
      // if($this->db->openConnection())
      // {
      //    if($product->quantity==0){
      //        $product->status='Out Of Stock';
      //    }
      //    else{
      //        $product->status='Available';
      //    }
      //    // $product->sellerid=
      //    // ription','$product->quantity','$product->status','$product->color',$product->sizeid,'$product->price',$product->categoryid,'2','$product->image')";
      //    return $this->db->insert($query);
      // }
      // else
      // {
      //    echo "Error in Database Connection";
      //    return false; 
      // }
   }

   //  public function getAllProductsWithImages()
   //  {
   //       $this->db=new DBController;
   //       if($this->db->openConnection())
   //       {
   //          $query="select products.id,products.name,price,quantity,categories.name as 'category',image from products,categories where products.categoryid=categories.id;";
   //          return $this->db->select($query);
   //       }
   //       else
   //       {
   //          echo "Error in Database Connection";
   //          return false; 
   //       }
   //  }





}
