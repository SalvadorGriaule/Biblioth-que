<?php

require "db.php";

$surnameErr = $numErr = $dateErr = $nameErr = $pwdErr = $mailErr = $pwdWeak = $confErr = $script = "";
$firstBool = $secondBool = $thirdBool = false;
$strPwd = true;
$a = 0;

function valideDate($date, $format = 'd/m/Y')
{
    $d = DateTime::createFromFormat($format, $date);
    if ($d && $d->format($format) == $date) {
        return true;
    } else {
        return false;
    }
}

if (isset($_POST['submit']) && !empty(($_POST['submit']))) {
    if (empty($_POST['name_user']) || empty($_POST['surname']) || empty($_POST['password']) || empty($_POST['mail']) || empty($_POST['confirm_password'])) {
        $script = '<script>';
        if (empty($_POST['name_user'])) {
            $nameErr = '<p class="mt-1">Champ obligatoire </p>';
            $script .= 'const nameUser = document.getElementById("nameUser");
            nameUser.classList.add("outline","outline-[rgb(220,38,38)]","outline-offset-2","outline-[3px]");';
        }

        if (empty($_POST['surname'])) {
            $surnameErr = '<p class="mt-1">Champ obligatoire </p>';
            $script .= 'const surname = document.getElementById("surnameUser");
            surname.classList.add("outline","outline-[rgb(220,38,38)]","outline-offset-2","outline-[3px]");';
        }

        if (empty($_POST['password'])) {
            $pwdErr = '<p class="mt-1">Champ obligatoire </p>';
            $script .= 'const password = document.getElementById("password");
            password.classList.add("outline","outline-[rgb(220,38,38)]","outline-offset-2","outline-[3px]");';
        }

        if (empty($_POST['mail'])) {
            $mailErr = '<p class="mt-1">Champ obligatoire </p>';
            $script .= 'const mail = document.getElementById("mail");
            mail.classList.add("outline","outline-[rgb(220,38,38)]","outline-offset-2","outline-[3px]");';
        }

        if (empty($_POST['confirm_password'])) {
            $confErr = '<p class="mt-1">Champ obligatoire </p>';
            $script .= 'const confWord = document.getElementById("confWord");
            confWord.classList.add("outline","outline-[rgb(220,38,38)]","outline-offset-2","outline-[3px]");';
        }

        $script .= '</script>';
    } elseif (preg_match('/^[^\W][a-zA-Z0-9]+(.[a-zA-Z0-9]+)@[a-zA-Z0-9]+(.[a-zA-Z0-9]+).[a-zA-Z]{2,4}$/', $_POST["mail"]) == 0) {
        $mailErr = '<p class="mt-1">Champ invalide</p>';
    } elseif (strlen($_POST['password']) < 8) {
        $pwdWeak = '<p>Mots de passe trop court </p>';
    } elseif (strstr($_POST['password'], chr(33)) == false && strstr($_POST['password'], chr(35)) == false && strstr($_POST['password'], chr(36)) == false && strstr($_POST['password'], chr(42)) == false && strstr($_POST['password'], chr(37)) == false && strstr($_POST['password'], chr(63)) == false) {
        $pwdWeak = '<p>Mots de passe ne contient pas au moins un !?#$*% </p>';
    } elseif (preg_match('/^[0-9]{10,10}$/', $_POST['num']) == 0) {
        $numErr = '<p class="mt-1">Numéro invalid</p>';
    } elseif (strcmp($_POST["confirm_password"], $_POST["password"]) != 0) {
        $pwdWeak = '<p>Les 2 mot de pass sont différent</p>';
    } elseif (valideDate($_POST["date"])){
        $dateErr = '<p class="mt-1">Date invalid</p>';
    } else {
        while ($a <= 9 && $firstBool == false) {
            if (strstr($_POST['password'], strval($a)) != false) {
                $firstBool = true;
            } else {
                $a++;
            }
        }
        if ($firstBool) {
            $a = 65;
            while ($a <= 90 && $secondBool == false) {
                if (strstr($_POST['password'], chr($a)) != false) {
                    $secondBool = true;
                } else {
                    $a++;
                }
            }
        }
        if ($secondBool) {
            $a = 97;
            while ($a <= 122 && !$thirdBool) {
                if (strstr($_POST['password'], chr($a)) != false) {
                    $thirdBool = true;
                } else {
                    $a++;
                }
            }
        }
        if (!$firstBool) {
            $pwdWeak = '<p>Mots de passe ne contient pas de chiffre</p>';
        } elseif (!$secondBool) {
            $pwdWeak = '<p>Mots de passe ne contient pas de Majuscule</p>';
        } elseif (!$thirdBool) {
            $pwdWeak = '<p>Mots de passe ne contient pas de minuscule</p>';
        } else {
            $pdo->query("INSERT INTO info_inscription(name_user, password, mail)
        VALUES ('" . $_POST['name_user'] . "','" . $_POST['password'] . "','" . $_POST['mail'] . "')");
        }
    }
}
if ($pwdWeak != "") {
    $script = '<script>
    const weakDiv = document.getElementById("weakDiv");
    weakDiv.style.display = "block";
    </script>';
}
?>

<?php include "./template/header.php" ?>
<main class="bg-[url(../img/FondBoisVernis.jpg)] bg-center">
    <section class="w-full flex justify-center">
        <div class="bg-[url(../img/VieuxPapier.jpg)] bg-center my-3 p-2 w-3/4 flex flex-col place-content-center">
            <h2 class="text-xl text-center">Inscription</h2>
            <form class="flex flex-col space-y-2 w-full p-2" action="" method="POST">
                <span id="weakDiv" class="hidden text-red-700 bg-amber-400 p-1 rounded-md">
                    <?php echo $pwdWeak; ?>
                </span>
                <input id="surnameUser" class="border-2 placeholder:text-zinc-600 border-zinc-500 bg-orange-300 p-1" type="text" name="surname" placeholder="prenom" value="<?php echo @$_POST["surname"] ?>">
                <span class="text-red-600">
                    <?php echo $surnameErr; ?>
                </span>
                <input id="nameUser" class="border-2 placeholder:text-zinc-600 border-zinc-500 bg-orange-300 p-1" type="text" name="name_user" placeholder="nom" value="<?php echo @$_POST["name_user"] ?>">
                <span class="text-red-600">
                    <?php echo $nameErr; ?>
                </span>
                <input id="mail" class="border-2 placeholder:text-zinc-600 border-zinc-500 bg-orange-300 p-1" type="email" name="mail" placeholder="email" value="<?php echo @$_POST["mail"] ?>">
                <span class="text-red-600">
                    <?php echo $mailErr; ?>
                </span>
                <input class="border-2 placeholder:text-zinc-600 border-zinc-500 bg-orange-300 p-1" type="date" name="date">
                <span>
                    <?php echo $dateErr; ?>
                </span>
                <input type="tel" class="border-2 placeholder:text-zinc-600 border-zinc-500 bg-orange-300 p-1" placeholder="numéro tél" name="num" value="<?php echo @$_POST["num"] ?>">
                <span>
                    <?php echo $numErr; ?>
                </span>
                <input id="password" class="border-2 placeholder:text-zinc-600 border-zinc-500 bg-orange-300 p-1" name="password" type="password" placeholder="password">
                <span class="text-red-600">
                    <?php echo $pwdErr; ?>
                </span>
                <input id="confWord" class="border-2 placeholder:text-zinc-500 border-zinc-500 bg-orange-300 p-1" name="confirm_password" type="password" placeholder="confirm password">
                <input type="submit" name="submit" class="p-1 rounded-md cursor-pointer bg-orange-300 text-amber-900 disabled:text-black disabled:bg-slate-400 disabled:cursor-default" value="Envoyer">
                <span class="text-red-600">
                    <?php echo $confErr; ?>
                </span>
            </form>
        </div>
    </section>
    <?php echo $script ?>
</main>
<?php include "./template/footer.php" ?>