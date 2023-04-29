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
            $query="select * from category";
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
         $this->db=new DBController;
         if($this->db->openConnection())
         {
            $query="select * from product_size";
            return $this->db->select($query);
         }
         else
         {
            echo "Error in Database Connection";
            return false; 
         }
    }

    
    public function addProduct(Product $product)
    {
         $this->db=new DBController;
         if($this->db->openConnection())
         {
            if($product->quantity==0){
                $product->status='Out Of Stock';
            }
            else{
                $product->status='Available';
            }
            // $product->sellerid=
            $query="insert into product values ('','$product->name','$product->description','$product->quantity','$product->status','$product->color',$product->sizeid,'$product->price',$product->categoryid,'1','$product->image')";
            return $this->db->insert($query);
         }
         else
         {
            echo "Error in Database Connection";
            return false; 
         }
    }


    public function getAllProducts()
    {
         $this->db=new DBController;
         if($this->db->openConnection())
         {
            $query="select product.id,product.name,start_price as price,quantity,product.image,category.name as 'category' from product join category on product.category_id=category.id order by product.id asc;";
            return $this->db->select($query);
         }
         else
         {
            echo "Error in Database Connection";
            return false; 
         }
    }
    public function deleteProduct($id)
    {
         $this->db=new DBController;
         if($this->db->openConnection())
         {
            $query="delete from product where id = $id";
            return $this->db->delete($query);
         }
         else
         {
            echo "Error in Database Connection";
            return false; 
         }
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
public function getCategoryProducts($id)
    {
         $this->db=new DBController;
         if($this->db->openConnection())
         {
            $query="select products.id,products.name,price,quantity,categories.name as 'category',image from products,categories where products.categoryid=categories.id and categories.id=$id;";
            return $this->db->select($query);
         }
         else
         {
            echo "Error in Database Connection";
            return false; 
         }
    }
    
    
}





}
    ?>




