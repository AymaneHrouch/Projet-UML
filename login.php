<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
// Include config file
require_once "config.php";
// Define variables and initialize with empty values
$cni = $mdp = "";
$cni_err = $mdp_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if cni is empty
    if(empty(trim($_POST["login"]))){
        $cni_err = "Please enter cni.";
    } else{
        $cni = trim($_POST["login"]);
    }
    
    // Check if mdp is empty
    if(empty(trim($_POST["mdp"]))){
        $mdp_err = "Please enter your mdp.";
    } else{
        $mdp = trim($_POST["mdp"]);
    }
    
    // Validate credentials
    if(empty($cni_err) && empty($mdp_err)){
        // Prepare a select statement
        $sql = "SELECT pwd, mode from users where `login`=:login";
        
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":login", $param_cni, PDO::PARAM_STR);
            
            // Set parameters
            $param_cni = trim($_POST["login"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if cni exists, if yes then verify mdp
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $mdp_corr = $row["pwd"];
                        if($mdp == $mdp_corr){
                            // mdp is correct, so start a new session
                            $_SESSION["loggedin"] = true;
                            $_SESSION["mode"] = $row["mode"];
                            if($_SESSION["mode"] == "etud") {
                                require_once __DIR__ . '/classes/Etudiant.php';  
                                $_SESSION["utilisateur"] = new Etudiant($_POST["login"]);
                                header("location: index.php");
                            }
                            else {
                                header("location: index.php");
                            }
                        } else{
                            // mdp is not valid, display a generic error message
                            $login_err = "Invalid cni or mdp.";
                        }
                    }
                } else{
                    // cni doesn't exist, display a generic error message
                    $login_err = "Invalid cni or mdp.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    // Close connection
    unset($pdo);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="image/jpg" href="./assets/common/img/logo.svg"/>
    <title>Login</title>
    <link rel="stylesheet" href="./assets/libs/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{width: 360px; padding: 20px; margin-left: auto; margin-right: auto; margin-top: 50px;}
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="login" class="form-control <?php echo (!empty($cni_err)) ? 'is-invalid' : ''; ?>" value="root">
                <span class="invalid-feedback"><?php echo $cni_err; ?></span>
            </div>    
            <div class="form-group">
                <label>mdp</label>
                <input type="password" name="mdp" class="form-control" value="toor" <?php echo (!empty($mdp_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $mdp_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
        </form>
    </div>
</body>
</html>