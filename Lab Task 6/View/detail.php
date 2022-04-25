<?php 
include('../includes/header.php');
?>
    <!-- Content Wrapper -->
    <div class="content_wrapper">

          <!-- Start Catagories  -->
        <div id="sidebar">  
            <div id="sidebar_title">Categories</div>
            <ul id="cats">
            
            <?php 
            getCats();
            ?>
            </ul>

            <div id="sidebar_title">Brands</div>
            <ul id="cats">
                <?php 
                    getBrands();
                ?>  
            </ul>

        </div> 
         <!-- End Catagories -->

         <!-- Content Area  -->
        <div id="content_area">
            <div id="products_box">
            <?php 
                if(isset($_GET['pro_id']))
                {
                   $product_id = $_GET['pro_id'];
                    $run_query_by_pro_id = mysqli_query($con,"select * from products where product_id='$product_id'");

                    while($row_pro = mysqli_fetch_array($run_query_by_pro_id)){
                        $pro_id = $row_pro['product_id'];
                        $pro_cat = $row_pro['product_cat'];
                        $pro_brand = $row_pro['product_brand'];
                        $pro_title = $row_pro['product_title'];
                        $pro_price = $row_pro['product_price'];
                        $pro_image = $row_pro['product_image'];
        
                            echo "
                                <div id='single_product'>
                                    <h3>$pro_title</h3>
                                    <img src='../admin_area/product_images/$pro_image' width='180' height='180'/>
                                        <p><b>Price :$ $pro_price </b></p>
                                        <a href='detail.php?pro_id=$pro_id'>Details</a>
                                        <a href='index.php?add_cart=$pro_id'><br>
                                        <button style='float:right'>Add to Cart</button>
                                        </a>
                                </div>
                            ";   
                    }
                }
                
            ?>
           


            </div> <!-- # Products _ box End # -->
        </div>
    </div>
    <!-- End Content_Wrapper -->
 <?php include('../includes/footer.php'); ?>