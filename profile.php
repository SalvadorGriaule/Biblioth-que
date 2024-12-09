<?php
include "./template/header.php";

require "db.php";

parse_str($_SERVER['QUERY_STRING'], $output);
$id = (int)$output["id_employer"];

$searchEmail = "SELECT id,prenom,nom,sexe,service,Email,numero,image  FROM employes WHERE id = :id";
$pre = $pdo->prepare($searchEmail, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
$pre->execute([
    "id" => $_SESSION["id"]
]);
$dataDB = $pre->fetchAll();
$profileData = $dataDB[0];
$numeroFormat = (string)$profileData["numero"];

for ($i = 0; $i < 15; ++$i) {
    if ($i % 3 == 0) {
        $numeroFormat = substr_replace($numeroFormat, " ", $i, 0);
    }
}

?>

<main class="bg-[url(../img/FondBoisVernis.jpg)] bg-center">
    <nav>
        <ul>
            <li><a href="./modif.php?id_employer=".id>modifier</a></li>
        </ul>
    </nav>
    <section class="w-full flex justify-center">
        <div class="bg-[url(../img/VieuxPapier.jpg)] bg-center my-3 p-2 w-3/4 flex place-content-center">
            <div class="<?php is_null($profileData["image"]) ? "flex place-content-center" : "w-1/2" ?>">
                <?php if (!is_null($profileData["image"])): ?>
                    <img src="<?php echo $profileData["image"] ?>" alt="">
                <?php else: ?>
                    <p>Pas d'image disponible</p>
                <?php endif ?>
            </div>
            <div>
                <p><?php echo $profileData["prenom"] . " " . $profileData["nom"] ?></p>
                <p>Poste: <?php echo $profileData["service"] ?></p>
                <p>Email: <?php echo $profileData["Email"] ?></p>
                <p>Numero: <?php echo $numeroFormat ?></p>
                <?php if ($profileData["sexe"] == "m"): ?>
                    <p>Homme</p>
                <?php else: ?>
                    <p>Femme</p>
                <?php endif ?>
            </div>
        </div>
    </section>
</main>