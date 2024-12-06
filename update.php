<?php

include "./template/header.php";

require "dbLivre.php";



$titreErr = $autErr = $catErr = $script = "";


if (isset($_POST['submit']) && !empty(($_POST['submit']))) {
    if (empty($_POST['auteur']) || empty($_POST['titre']) || empty($_POST['categorie'])) {
        $script = '<script>';

        if (empty($_POST['auteur'])) {
            $autErr = '<p class="mt-1">Champ obligatoire </p>';
            $script .= 'const auteur = document.getElementById("auteur");
            auteur.classList.add("outline","outline-[rgb(220,38,38)]","outline-offset-2","outline-[3px]");';
        }

        if (empty($_POST['titre'])) {
            $titreErr = '<p class="mt-1">Champ obligatoire </p>';
            $script .= 'const titre = document.getElementById("titre");
            titre.classList.add("outline","outline-[rgb(220,38,38)]","outline-offset-2","outline-[3px]");';
        }

        if (empty($_POST['categorie'])) {
            $catErr = '<p class="mt-1">Champ obligatoire </p>';
            $script .= 'const categorie = document.getElementById("categorie");
            categorie.classList.add("outline","outline-[rgb(220,38,38)]","outline-offset-2","outline-[3px]");';
        }

        $script .= '</script>';
    } else {
        $insert = "INSERT INTO livre(auteur, titre, Categorie)
        VALUES (:auteur, :titre, :Categorie)";
        $pre = $pdo->prepare($insert, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $pre->execute([
            'auteur' => $_POST["auteur"],
            'titre' => $_POST["titre"],
            'Categorie' => $_POST["categorie"],
        ]);

    }
}


$str = "";

$str .= '<table class="border-2 border-black border-solid">';
$col = array_keys((array)$result[0]);

$str .= '<tr>';
for ($th = 2, $sth = count($col); $th < $sth; $th += 2) {
    $str .= '<th>' . $col[$th] . '</th>';
}
$sth .= '</tr>';
for ($i = 0, $size = count($result); $i < $size; ++$i) {
    $str .= '<tr >';
    for ($j = 1; $j < 10; ++$j) {
        $str .= '<td class="mr-2"><a href="./modifLivre.php?id_livre=' . $result[$i][0] . '">' . $result[$i][$j] . "</a></td>";
    }
    $str .= '<td class="mr-2"></a><a class="bg-red-600 text-white p-1" href="./suppLivre.php?id_livre=' . $result[$i][0] . '">Supprimer</a></td></tr>';
}

$str .= '</table>';


?>

<main class="bg-[url(../img/FondBoisVernis.jpg)] bg-center">
    <section class="w-full flex items-center justify-center">
        <div class="my-2 bg-white">
            <?php echo $str ?>
        </div>
    </section>
    <section class="flex justify-center items-center">
        <div class="bg-[url(../img/VieuxPapier.jpg)] bg-center my-3 p-2 w-3/4 flex flex-col place-content-center">
            <form action="update.php" method="post" class="flex flex-col space-y-2 w-full p-2">
                <input id="titre" name="titre" class="border-2 placeholder:text-zinc-600 border-zinc-500 bg-orange-300 p-1" type="text" placeholder="nom du livres" value="<?php echo @$_POST["titre"] ?>">
                <span>
                    <?php echo $titreErr; ?>
                </span>
                <input id="auteur" name="auteur" class="border-2 placeholder:text-zinc-600 border-zinc-500 bg-orange-300 p-1" type="text" placeholder="auteur" value="<?php echo $_POST["auteur"] ?>">
                <span>
                    <?php echo $autErr; ?>
                </span>
                <input id="categorie" name="categorie" class="border-2 placeholder:text-zinc-600 border-zinc-500 bg-orange-300 p-1" type="text" placeholder="categorie" value="<?php echo $_POST["categorie"] ?>">
                <span>
                    <?php echo $catErr; ?>
                </span>
                <input name="submit" class="p-1 rounded-md cursor-pointer bg-orange-300 text-amber-900 disabled:text-black disabled:bg-slate-400 disabled:cursor-default" type="submit">
            </form>
        </div>
    </section>
</main>

<?php include "./template/footer.php"; ?>