<?php

require_once '../Models/product.php';
require_once 'DBController.php';
class ProductController
{

   protected $db;


   public function getCategories()
   {
      $this->db = new DBController;
      if ($this->db->openConnection()) {
         // $query="select * from category";
         $query = "SELECT 
            category.*, 
            COUNT(product.id) as categoryQuantity
          FROM 
            category 
          LEFT JOIN 
            product 
          ON 
            category.id = product.category_id 
          GROUP BY 
            category.id;";
         return $this->db->select($query);
      } else {
         echo "Error in Database Connection";
         return false;
      }
   }

   public function getCategoryProducts($id)
   {
      $this->db = new DBController;
      if ($this->db->openConnection()) {
         $query = "select product.id,product.name,start_price as price,quantity,product.image,category.name as 'category' 
            from product
            join category on product.category_id=category.id
            where product.category_id=category.id
            and category.id = $id
            order by product.id asc
            ";
         // $query = "select product.id,product.name,start_price as price,quantity,product.image,SUM(product.quantity) AS categoryQuantity,category.name as 'category' 
         // from product
         // join category on product.category_id=category.id
         // where product.category_id=category.id
         // and category.id = $id
         // order by product.id asc
         // ";
         return $this->db->select($query);
      } else {
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


   public function addProduct(User $user, Product $product)
   {
      $this->db = new DBController;
      if ($this->db->openConnection()) {
         if ($product->quantity == 0) {
            $product->status = 'Out Of Stock';
         } else {
            $product->status = 'Available';
         }
         // $product->sellerid=
         $query = "insert into product values ('','$product->name','$product->description','$product->quantity','$product->status','$product->color',$product->sizeid,'$product->price',$product->categoryid, $user->id,'$product->image')";
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


   public function search($name)
   {
      $this->db = new DBController;
      if ($this->db->openConnection()) {
         $query = "select product.id,product.name,start_price as price,quantity,product.image,category.name as 'category'  from product join category on product.category_id=category.id WHERE product.name LIKE '%$name%' order by product.id asc";
         return $this->db->select($query);
      } else {
         echo "Error in Database Connection";
         return false;
      }
   }


   public function getSellerProducts(User $user)
   {
      $this->db = new DBController;
      if ($this->db->openConnection()) {
         $query = "select product.id,product.name,start_price as price,quantity,product.image,category.name as 'category'  from product join category on product.category_id=category.id WHERE product.seller_id = $user->id order by product.id asc";
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
         $query = "select product.*,category.name as category,product_size.name as size FROM product
         INNER Join category on product.category_id=category.id
         Left Join product_size on product.size_id=product_size.id
         WHERE product.id = '$id'";
         return $this->db->select($query);
      } else {
         echo "Error in Database Connection";
         return false;
      }
   }


   public function updateProduct(User $user, Product $product, $id)
   {

      $this->db = new DBController;
      if ($this->db->openConnection()) {
         $query = "update product set name = '$product->name',color = '$product->color',description = '$product->description',quantity = '$product->quantity',status = '$product->status',start_price = '$product->price',category_id = '$product->categoryid',seller_id = '$user->id',image = '$product->image' WHERE product.id = '$id'";
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


   public function addToFav(User $user, $product_id)
   {
      $this->db = new DBController;
      if ($this->db->openConnection()) {
         $query = "insert INTO fav_products VALUES ('" . $user->id . "', '$product_id');";
         $result = $this->db->insert($query);
         if ($result != false) {
            if (session_status() === PHP_SESSION_NONE) {
               session_start();
            }
            $this->db->closeConnection();
            return true;
         } else {
            $_SESSION["errMsg"] = "Somthing went wrong... try again later";
            $this->db->closeConnection();
            return false;
         }
      } else {
         echo "Error in Database Connection";
         return false;
      }
   }

   public function getFav(User $user)
   {
      $this->db = new DBController;
      if ($this->db->openConnection()) {
         $query = "select product.*,category.name as category
         FROM product
         INNER JOIN fav_products ON product.id = fav_products.product_id 
         INNER JOIN category ON product.category_id = category.id
         WHERE fav_products.buyer_id ='" . $user->id . "'";
         return $this->db->select($query);
      } else {
         echo "Error in Database Connection";
         return false;
      }
   }

   public function isFav(User $user, $product_id)
   {
      $this->db = new DBController;
      if ($this->db->openConnection()) {
         $query = "select product.*,category.name as category
         FROM product
         INNER JOIN fav_products ON product.id = fav_products.product_id 
         INNER JOIN category ON product.category_id = category.id
         WHERE fav_products.buyer_id ='" . $user->id . "' AND fav_products.product_id ='" . $product_id . "'";
         return true;
      } else {
         echo "Error in Database Connection";
         return false;
      }
   }


   public function removeFav($id)
   {
      $this->db = new DBController;
      if ($this->db->openConnection()) {
         $query = "delete from fav_products where product_id ='$id'";
         return $this->db->delete($query);
      } else {
         echo "Error in Database Connection";
         return false;
      }
   }


   //
   public function addToWatchlist(User $user, $product_id)
   {
      $this->db = new DBController;
      if ($this->db->openConnection()) {
         $query = "insert INTO watch_list VALUES ('" . $user->id . "', '$product_id');";
         $result = $this->db->insert($query);
         if ($result != false) {
            if (session_status() === PHP_SESSION_NONE) {
               session_start();
            }
            $this->db->closeConnection();
            return true;
         } else {
            $_SESSION["errMsg"] = "Somthing went wrong... try again later";
            $this->db->closeConnection();
            return false;
         }
      } else {
         echo "Error in Database Connection";
         return false;
      }
   }

   public function getWatchlist(User $user)
   {
      $this->db = new DBController;
      if ($this->db->openConnection()) {
         $query = "select product.*,category.name as category
         FROM product
         INNER JOIN watch_list ON product.id = watch_list.product_id 
         INNER JOIN category ON product.category_id = category.id
         WHERE watch_list.buyer_id ='" . $user->id . "'";
         return $this->db->select($query);
      } else {
         echo "Error in Database Connection";
         return false;
      }
   }


   public function removeWatchlist($id)
   {
      $this->db = new DBController;
      if ($this->db->openConnection()) {
         $query = "delete from watch_list where product_id ='$id'";
         return $this->db->delete($query);
      } else {
         echo "Error in Database Connection";
         return false;
      }
   }


   //

   public function addFeedback(Feedback $feedback)
   {
      $this->db = new DBController;
      if ($this->db->openConnection()) {
         // $product->sellerid=
         $query = "insert into product_feedback values ('','" . $feedback->get_rate() . "','" . $feedback->get_feedback() . "','" . $feedback->get_buyerId() . "','" . $feedback->get_productId() . "')";
         return $this->db->insert($query);
      } else {
         echo "Error in Database Connection";
         return false;
      }
   }

   public function getFeedback($product_id)
   {
      $this->db = new DBController;
      if ($this->db->openConnection()) {
         // $product->sellerid=
         $query = "select product_feedback.*,user.fullname from product_feedback 
           INNER Join user on product_feedback.buyer_id=user.id
           INNER Join product on product_feedback.product_id=product.id
           where product_feedback.product_id='$product_id'";
         return $this->db->select($query);
      } else {
         echo "Error in Database Connection";
         return false;
      }
   }
}
