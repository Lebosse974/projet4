<?php
include './fonction.php';
//connection base de donnée
$mysqli = connect();
session_start();
$errorLoginPass = '';
$errorLogin = '';
$errorMotDePasse = '';

// vérifcation de la methode
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // test si login vide
    if (isset($_POST['login']) && $_POST['login'] == '') {
        $errorLogin = 'Le champs login est vide.<br/>';
    }

    // test si mot de passe vide
    if (isset($_POST['password']) && $_POST['password'] == '') {
        $errorMotDePasse = 'Le champs mot de passe est vide.<br/>';
    }


    if ($errorLogin == '' && $errorMotDePasse == '') { //si je n'ai pas d'erreur je test le login et le mdp

        $passwordHash = hash("sha512", $_POST['password']); // hash le mot de passe
        $login = $_POST['login'];
        //requete qui recupere le user avec le login et mot de passe
        $sql = "SELECT * from utilisateur where login = '$login' and password='$passwordHash';";

        $result = $mysqli->query($sql); // execution de la requete

        if ($mysqli->errno) { // si erreur dans la requete
            var_dump($sql);
            printf("<p class='error'>Un problème est survenue  %s </p><br />", $mysqli->error);
            $mysqli->close();
            return false;
        }

        $user = $result->fetch_assoc(); // je récupère le resultat
        //si le login et mdp incorrect

        // $res = mysqli_num_rows( $result ); // renvoi le nombre de resultat

        if ($user == null) { // verifie si login ou mdp incorrect
            $errorLoginPass = " Login et/ou mot de passe incorrect !";
        } else {
            $_SESSION['user_id'] =  $user['id'];
            header("Location: index.php");
            die();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="login.php" method="POST">
        <div class="formulaire">
        <?php if ($errorLoginPass != '') { ?>
                    <div class="row-error">
                        <?php
                        echo $errorLoginPass;
                        ?>
                <h1> connection </h1>    
                <?php } ?>
            
            <label for=""> login </label>
            <input type="text" name="login" value="<?php if (isset($_POST['login'])) echo $_POST['login']; ?>">

            <label for=""> Mot De Passe </label>
            <input type="password" name="password">

            <input type="submit" class="" value="Valider">
        </div>
        
    </form>
</body>
</html>