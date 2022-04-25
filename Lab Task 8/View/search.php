<?php 
    include("../Model/db.php");

    $sql = "select * from products where product_keywords LIKE '%".$_POST['name']."%'";
    $result = mysqli_query($con,$sql);

    if(mysqli_num_rows($result) > 0 ){
        while($row=mysqli_fetch_assoc($result))
        {
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
