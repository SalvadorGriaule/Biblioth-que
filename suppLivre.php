<?php

include "./template/header.php";

require "dbLivre.php";

parse_str($_SERVER['QUERY_STRING'], $output);
$id = (int)$output["id_livre"];

$read_id = $pdo->query('SELECT * FROM livre WHERE id_livre=' . $id);
$info = $read_id->fetchAll();

$current = $info[0];


if (isset($_POST['submit']) && !empty(($_POST['submit']))) {
    $insert = "DELETE FROM livre WHERE id_livre= :id";
    $pre = $pdo->prepare($insert, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    $pre->execute([
        'id' => $id
    ]);
    echo '<script>
            window.location.replace("http://localhost/Biblothéque/pdo.php");
            </script>';
}

$script = "";

?>
<main class="bg-[url(../img/FondBoisVernis.jpg)] bg-center">
    <section class="w-full flex justify-center">
        <div class="bg-[url(../img/VieuxPapier.jpg)] bg-center my-3 p-2 w-3/4 flex flex-col place-content-center">
            <h2 class="text-xl text-center">Supprimer</h2>
            <p class="text-lg text-center">étes vous sûr ?</p>
            <form action="" method="post" class="flex justify-center">
                <input class="bg-red-600 text-white py-2 rounded-md px-4" type="submit" name="submit" value="OUI">
            </form>
        </div>
    </section>
    <?php echo $script ?>
</main>
<?php include "./template/footer.php"; ?>