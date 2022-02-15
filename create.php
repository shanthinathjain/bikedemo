<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$model = $company = $color = "";
$model_err = $company_err = $color_err = "";
  
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	
    // Validate model
    $input_model = trim($_POST["model"]);
    if(empty($input_model)){
        $model_err = "Please enter a model.";
    }elseif(!ctype_digit($input_model)){
        $model_err = "Please enter a positive integer value.";
    }
	else{
        $model = $input_model;
    }
    
    // Validate company
    $input_company = trim($_POST["company"]);
    if(empty($input_company)){
        $company_err = "Please enter an Name of comapany.";     
    } else{
        $company = $input_company;
    }
    
    // Validate color
    $input_color = trim($_POST["color"]);
    if(empty($input_color)){
        $color_err = "Please enter the color.";     
    }  else{
        $color = $input_color;
    }
    
    // Check input errors before inserting in database
   
   if(empty($model_err) && empty($company_err) && empty($color_err)){

        // Prepare an insert statement    
    $sql = "INSERT into car(model, company, color) VALUES (?, ?, ?)";
         if($stmt = mysqli_prepare($link, $sql)){
         
		 // Bind variables to the prepared statement as parameters
		  
            mysqli_stmt_bind_param($stmt, "sss", $param_model, $param_company, $param_color);
            
            // Set parameters
            $param_model = $model;
            $param_company = $company;
            $param_color = $color;
		 }
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                 // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    
}
    // Close connection
    mysqli_close($link);

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add cars record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Model</label>
                            <input type="text" name="model" class="form-control <?php echo (!empty($model_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $model; ?>">
							
                            <span class="invalid-feedback"><?php echo $model_err;?></span>
                        </div>
						
                        <div class="form-group">
                            <label>Company</label>
                            <textarea name="company" class="form-control <?php echo (!empty($company_err)) ? 'is-invalid' : ''; ?>"><?php echo $company; ?></textarea>
                            <span class="invalid-feedback"><?php echo $company_err;?></span>
                        </div>
						
                        <div class="form-group">
                            <label>Color</label>
                            <input type="text" name="color" class="form-control <?php echo (!empty($color_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $color; ?>">
                            <span class="invalid-feedback"><?php echo $color_err;?></span>
                        </div>
						
                        <input type="submit" class="btn btn-primary" value="Submit">
                        
						<a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>