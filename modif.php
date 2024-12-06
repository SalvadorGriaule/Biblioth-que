<?php
include "./template/header.php";

require "db.php";

parse_str($_SERVER['QUERY_STRING'], $output);
$id = (int)$output["id_employer"];

$read_id = $pdo->query('SELECT * FROM employes WHERE id_employes=' . $id);
$info = $read_id->fetchAll();

$current = $info[0];

$surnameErr = $numErr = $genreErr = $salaireErr = $serviceErr = $nameErr = $mailErr = $script = "";

$a = 0;

if (isset($_POST['submit']) && !empty(($_POST['submit']))) {
    if (empty($_POST['name_user']) || empty($_POST['surname']) || empty($_POST['mail'])  || empty($_POST['service']) || empty($_POST['salaire']) ||  empty($_POST["sexe"])) {
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


        if (empty($_POST['mail'])) {
            $mailErr = '<p class="mt-1">Champ obligatoire </p>';
            $script .= 'const mail = document.getElementById("mail");
            mail.classList.add("outline","outline-[rgb(220,38,38)]","outline-offset-2","outline-[3px]");';
        }

        if (empty($_POST['service'])) {
            $serviceErr = '<p class="mt-1">Champ obligatoire </p>';
            $script .= 'const service = document.getElementById("service");
            service.classList.add("outline","outline-[rgb(220,38,38)]","outline-offset-2","outline-[3px]");';
        }

        if (empty($_POST['salaire'])) {
            $salaireErr = '<p class="mt-1">Champ obligatoire </p>';
            $script .= 'const salaire = document.getElementById("salaire");
            salaire.classList.add("outline","outline-[rgb(220,38,38)]","outline-offset-2","outline-[3px]");';
        }
        $script .= '</script>';
    } elseif (preg_match('/^[^\W][a-zA-Z0-9]+(.[a-zA-Z0-9]+)@[a-zA-Z0-9]+(.[a-zA-Z0-9]+).[a-zA-Z]{2,4}$/', $_POST["mail"]) == 0) {
        $mailErr = '<p class="mt-1">Champ invalide</p>';
    } elseif (preg_match('/^[0-9]{10,10}$/', $_POST['num']) == 0) {
        $numErr = '<p class="mt-1">Numéro invalid</p>';
    } else {
        $insert = "UPDATE employes
            SET  prenom = :surname , nom = :name_user , sexe = :sexe , service = :service, salaire = :salaire , Email = :mail , numero = :num  WHERE id_employes= :id";
        $pre = $pdo->prepare($insert, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $pre->execute([
            'id' => $id,
            'surname' => $_POST["surname"],
            'name_user' => $_POST["name_user"],
            'sexe' => $_POST["sexe"],
            'service' => $_POST['service'],
            'salaire' => $_POST['salaire'],
            'mail' => $_POST['mail'],
            'num' => $_POST['num'],
        ]);
    }
}

?>


<main class="bg-[url(../img/FondBoisVernis.jpg)] bg-center">
    <section class="w-full flex justify-center">
        <div class="bg-[url(../img/VieuxPapier.jpg)] bg-center my-3 p-2 w-3/4 flex flex-col place-content-center">
            <h2 class="text-xl text-center">Modification</h2>
            <form class="flex flex-col space-y-2 w-full p-2" action="" method="POST">
                <span id="weakDiv" class="hidden text-red-700 bg-amber-400 p-1 rounded-md">
                    <?php echo $pwdWeak; ?>
                </span>
                <input id="surnameUser" class="border-2 placeholder:text-zinc-600 border-zinc-500 bg-orange-300 p-1" type="text" name="surname" placeholder="prenom" value="<?php echo $current["nom"] ?>">
                <span class="text-red-600">
                    <?php echo $surnameErr; ?>
                </span>
                <input id="nameUser" class="border-2 placeholder:text-zinc-600 border-zinc-500 bg-orange-300 p-1" type="text" name="name_user" placeholder="nom" value="<?php echo @$current["prenom"] ?>">
                <span class="text-red-600">
                    <?php echo $nameErr; ?>
                </span>
                <input id="service" class="border-2 placeholder:text-zinc-600 border-zinc-500 bg-orange-300 p-1" type="text" name="service" placeholder="profession" value="<?php echo @$current["service"] ?>">
                <span class="text-red-600">
                    <?php echo $serviceErr; ?>
                </span>
                <input id="salaire" class="border-2 placeholder:text-zinc-600 border-zinc-500 bg-orange-300 p-1" type="number" name="salaire" placeholder="salaire" value="<?php echo @$current["salaire"] ?>">
                <span class="text-red-600">
                    <?php echo $salaireErr; ?>
                </span>
                <input id="mail" class="border-2 placeholder:text-zinc-600 border-zinc-500 bg-orange-300 p-1" type="email" name="mail" placeholder="email" value="<?php echo @$current["Email"] ?>">
                <span class="text-red-600">
                    <?php echo $mailErr; ?>
                </span>
                <fieldset id="genre" class="border-2 bg-orange-300 p-1">
                    <legend>votre genre</legend>
                    <input type="radio" name="sexe" id="" value="m" <?php if($current["sexe"] == "m") echo "checked" ?> /><label for="">homme</label>
                    <input type="radio" name="sexe" id="" value="f" <?php if($current["sexe"] == "f") echo "checked" ?> /><label for="">femme</label>
                </fieldset>
                <?php echo $genreErr; ?>
                <input type="tel" class="border-2 placeholder:text-zinc-600 border-zinc-500 bg-orange-300 p-1" placeholder="numéro tél" name="num" value="<?php echo @$current["numero"] ?>">
                <span class="text-red-600">
                    <?php echo $numErr; ?>
                </span>
                <input type="submit" name="submit" class="p-1 rounded-md cursor-pointer bg-orange-300 text-amber-900 disabled:text-black disabled:bg-slate-400 disabled:cursor-default" value="Envoyer">
            </form>
        </div>
    </section>
    <?php echo $script ?>
</main>

<?php include "./template/footer.php" ?>