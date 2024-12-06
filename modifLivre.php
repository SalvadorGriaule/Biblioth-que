<?php

include "./template/header.php";

require "dbLivre.php";

parse_str($_SERVER['QUERY_STRING'], $output);
$id = (int)$output["id_livre"];

$read_id = $pdo->query('SELECT * FROM livre WHERE id_livre=' . $id);
$info = $read_id->fetchAll();

$current = $info[0];


$titreErr = $autErr = $catgErr = $script = "";


if (isset($_POST['submit']) && !empty(($_POST['submit']))) {
    if (empty($_POST['auteur']) || empty($_POST['titre']) || empty($_POST['categorie'])) {
        $script = '<script>';

        if (empty($_POST['auteur'])) {
            $titreErr = '<p class="mt-1">Champ obligatoire </p>';
            $script .= 'const auteur = document.getElementById("auteur");
            auteur.classList.add("outline","outline-[rgb(220,38,38)]","outline-offset-2","outline-[3px]");';
        }

        if (empty($_POST['titre'])) {
            $autErr = '<p class="mt-1">Champ obligatoire </p>';
            $script .= 'const titre = document.getElementById("titre");
            titre.classList.add("outline","outline-[rgb(220,38,38)]","outline-offset-2","outline-[3px]");';
        }

        if (empty($_POST['categorie'])) {
            $catgErr = '<p class="mt-1">Champ obligatoire </p>';
            $script .= 'const categorie = document.getElementById("categorie");
            categorie.classList.add("outline","outline-[rgb(220,38,38)]","outline-offset-2","outline-[3px]");';
        }

        $script .= '</script>';
    } else {
        $insert = "UPDATE livre
        SET  auteur = :auteur, titre = :titre, Categorie = :categorie  WHERE id_livre= :id";
        $pre = $pdo->prepare($insert, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $pre->execute([
            'id' => $id,
            'auteur' => $_POST["auteur"],
            'titre' => $_POST["titre"],
            'categorie' => $_POST["categorie"],
        ]);
        echo '<script>
            window.location.replace("http://localhost/Biblothéque/pdo.php");
            </script>';
    }
}


?>

<main class="bg-[url(../img/FondBoisVernis.jpg)] bg-center">
    <section>
        <div class="w-full flex items-center justify-center my-2">
            <?php echo $str ?>
        </div>
    </section>
    <section class="flex justify-center items-center">
        <div class="bg-[url(../img/VieuxPapier.jpg)] bg-center my-3 p-2 w-3/4 flex flex-col place-content-center">
            <form action="" method="post" class="flex flex-col space-y-2 w-full p-2">
                <input id="titre" name="titre" class="border-2 placeholder:text-zinc-600 border-zinc-500 bg-orange-300 p-1" type="text" placeholder="nom du livres" value="<?php echo @$current["titre"] ?>">
                <span>
                    <?php echo $titreErr; ?>
                </span>
                <input id="auteur" name="auteur" class="border-2 placeholder:text-zinc-600 border-zinc-500 bg-orange-300 p-1" type="text" placeholder="auteur" value="<?php echo $current["auteur"] ?>">
                <span>
                    <?php echo $autErr; ?>
                </span>
                <input id="categorie" name="categorie" class="border-2 placeholder:text-zinc-600 border-zinc-500 bg-orange-300 p-1" type="text" placeholder="categorie" value="<?php echo $current["Categorie"] ?>">
                <span>
                    <?php echo $catErr; ?>
                </span>
                <input name="submit" class="p-1 rounded-md cursor-pointer bg-orange-300 text-amber-900 disabled:text-black disabled:bg-slate-400 disabled:cursor-default" type="submit">
            </form>
        </div>
        <?php echo $script ?>
    </section>
</main>

<?php include "./template/footer.php"; ?>