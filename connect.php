<?php

require "db.php";

$surnameErr = $numErr = $dateErr = $nameErr = $pwdErr = $mailErr = $pwdWeak = $confErr = $script = "";
$firstBool = $secondBool = $thirdBool = false;
$strPwd = true;
$a = 0;

if (isset($_POST['submit']) && !empty(($_POST['submit']))) {
    if (empty($_POST['mail']) || empty($_POST['password'])) {
        $script = '<script>';

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
        $script .= '</script>';
    } else {
        $sign = $pdo->prepare('SELECT Email, password FROM employes WHERE Email = :mail', [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sign->execute([
            "mail" => $_POST["mail"],
        ]);

        $dataCon = $sign->fetchAll();
        if (password_verify($_POST["password"], $dataCon[0]["password"])) {
            session_start();
            echo '<script>
            window.location.replace("http://localhost/Biblothéque/index.php");
            </script>';
        }
    }
}

?>

<?php include "./template/header.php" ?>
<main class="bg-[url(../img/FondBoisVernis.jpg)] bg-center">
    <section class="w-full flex justify-center">
        <div class="bg-[url(../img/VieuxPapier.jpg)] bg-center my-3 p-2 w-3/4 flex flex-col place-content-center">
            <h2 class="text-xl text-center">Inscription</h2>
            <form class="flex flex-col space-y-2 w-full p-2" action="connect.php" method="POST">
                <span id="weakDiv" class="hidden text-red-700 bg-amber-400 p-1 rounded-md">
                    <?php echo $pwdWeak; ?>
                </span>
                <input id="mail" class="border-2 placeholder:text-zinc-600 border-zinc-500 bg-orange-300 p-1" type="email" name="mail" placeholder="email" value="<?php echo @$_POST["mail"] ?>">
                <span class="text-red-600">
                    <?php echo $mailErr; ?>
                </span>

                <input id="password" class="border-2 placeholder:text-zinc-600 border-zinc-500 bg-orange-300 p-1" name="password" type="password" placeholder="password">
                <span class="text-red-600">
                    <?php echo $pwdErr; ?>
                </span>
                <input type="submit" value="envoyer" name="submit" class="p-1 rounded-md cursor-pointer bg-orange-300 text-amber-900 disabled:text-black disabled:bg-slate-400 disabled:cursor-default">
            </form>
        </div>
    </section>
    <?php echo $script ?>
</main>
<?php include "./template/footer.php" ?>