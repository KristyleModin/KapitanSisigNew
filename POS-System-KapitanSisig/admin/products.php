<?php include('includes/header.php'); ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Menu Products
                <a href="recipes-add.php" class="btn btn-outline-success float-end me-2">Manage Recipe</a> 
                <a href="products-create.php" class="btn btn-outline-primary float-end me-2">Add Menu Product</a> 
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <?php 
                $products = getAll('products'); 
                if (!$products) {
                    echo '<h4>Something went wrong.</h4>';
                } elseif (mysqli_num_rows($products) > 0) { 
            ?>
            <div class="table-responsive">
                <table class="table" style="width: 100%; margin-bottom: 1rem; color: #000; border: 1px solid #dee2e6;">
                    <thead>
                        <tr style="background-color: #f8f9fa; color: #000;">
                            <th>Image</th>
                            <th>Menu Product Name</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 0;
                        while ($productItem = mysqli_fetch_assoc($products)) : 
                            $i++;
                        ?>
                        <tr style="background-color: <?= $i % 2 == 0 ? '#fff' : '#f9f9f9'; ?>; border: 1px solid #dee2e6;">
                            <td><img src="../<?= htmlspecialchars($productItem['image']); ?>" style="width:70px;height:70px;" alt="product image" /></td>
                            <td><?= htmlspecialchars($productItem['productname']) ?></td>
                            <td>
                                <?php
                                $categoryId = $productItem['category_id'];
                                $categoryQuery = "SELECT name FROM categories WHERE id = '$categoryId'";
                                $categoryResult = mysqli_query($conn, $categoryQuery);
                                $categoryName = $categoryResult && mysqli_num_rows($categoryResult) > 0 
                                                ? htmlspecialchars(mysqli_fetch_assoc($categoryResult)['name']) 
                                                : "Unknown Category";
                                ?>
                                <?= $categoryName ?>
                            </td>
                            <td><?= htmlspecialchars($productItem['quantity']) ?></td>
                            <td><?= htmlspecialchars($productItem['price']) ?></td>
                            <td>
                                <a href="products-edit.php?id=<?= $productItem['id'];?>" class="btn btn-outline-success btn-sm">Edit</a>
                                <a 
                                    href="products-delete.php?id=<?= $productItem['id'];?>" 
                                    class="btn btn-outline-danger btn-sm" 
                                    onclick="return confirm('Are you sure you want to delete this product?')">
                                    Delete
                                </a>
                                <a 
                                    href="recipe-view.php?id=<?= $productItem['id'];?>" 
                                    class="btn btn-outline-info btn-sm">
                                    View Recipe
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <?php 
                } else {
                    echo '<h4 class="mb-0">No record found.</h4>';
                } 
            ?>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>