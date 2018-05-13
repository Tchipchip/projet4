<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>
        <?php echo $title ?>
    </title>
    <meta name="description" content="Billet simple pour l'Alaska, blog de Jean Forteroche" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.11/css/all.css" integrity="sha384-p2jx59pefphTFIpeqCcISO9MdVfIm4pNnsL08A6v5vaQc4owkQqxMV8kg4Yvhaw/" crossorigin="anonymous">
    <link rel="stylesheet" href="public/css/style.css" type="text/css" />
    <meta name="viewport" content="initial-scale=1.0" />
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <a href="index.php?action=adminIndex">
                    <h1>Billet simple pour l'Alaska</h1>
                </a>
                <div class="my-5">
                    <p class="font-weight-bold">Administration</p>

                    <a href="index.php" method="post">Billets</a><br />
                    <a href="index.php?action=displayReportedCommentsAdmin" method="post">Commentaires signalés</a><br />
                    <a href="index.php?action=logout">Déconnexion</a>
                </div>
            </div>

            <div class="col-md">
                <?php echo $content ?>
            </div>
        </div>

        <footer>
            <p>Copyright 2018</p>
        </footer>
    </div>

    <!-- Scripts -->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea'
        });

    </script>

</body>

</html>
