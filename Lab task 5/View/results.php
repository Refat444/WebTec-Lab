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
            if(isset($_GET['search']))
            {
                $search_query = $_GET['user_query'];
                
                $run_query_by_pro_id = mysqli_query($con,"select * from products where product_keywords like '%$search_query%'");
                // $run_query_by_pro_cat = mysqli_query($con,"select ")

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
                                <img src='../images/product_images/$pro_image' width='180' height='180'/>
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
            <?php               
                get_pro_by_cat_id();               
            ?>

            <?php 
                get_pro_by_brand_id();
            ?>

            </div> <!-- # Products _ box End # -->
        </div>
    </div>
    <!-- End Content_Wrapper -->
 <?php include('../includes/footer.php'); ?>