<?php
ob_start(); // Start output buffering
require 'includes/header.php'; // Include header and database connection

// Check if the 'id' parameter is passed via GET
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $recipe_id = $_GET['id'];

    // Fetch the recipe to ensure it exists
    $recipeCheck = getById('recipes', $recipe_id);

    if ($recipeCheck['status'] == 200) {
        // Recipe exists, proceed to delete it

        // Delete the associated ingredients first from the `recipe_ingredients` table
        $deleteIngredientsQuery = "DELETE FROM recipe_ingredients WHERE recipe_id = '$recipe_id'";
        $ingredientsDeleted = mysqli_query($conn, $deleteIngredientsQuery);

        if ($ingredientsDeleted) {
            // Now delete the recipe from the `recipes` table
            $deleteRecipeQuery = "DELETE FROM recipes WHERE id = '$recipe_id'";
            $recipeDeleted = mysqli_query($conn, $deleteRecipeQuery);

            if ($recipeDeleted) {
                // Redirect to the recipe view page with success message
                $_SESSION['status'] = "Recipe deleted successfully!";
                redirect('recipes-view.php', 'Recipe deleted successfully');
            } else {
                // Error deleting recipe
                $_SESSION['status'] = "Error deleting recipe.";
                redirect('recipes-view.php', 'error');
            }
        } else {
            // Error deleting associated ingredients
            $_SESSION['status'] = "Error deleting recipe ingredients.";
            redirect('recipes-view.php', 'error');
        }
    } else {
        // Recipe not found
        $_SESSION['status'] = "Recipe not found!";
        redirect('recipes-view.php', 'error');
    }
} else {
    // No recipe ID provided
    $_SESSION['status'] = "No recipe ID provided.";
    redirect('recipes-view.php', 'error');
}

ob_end_flush(); // Flush output buffer
