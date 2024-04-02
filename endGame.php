<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Jacob Hobbs">
    <meta name="description" content="End Game Screen">
    <title>End Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <div class="container" style="margin-top: 15px;">
        <div class="row ">
            <div class="col-xs-12">
                <h1 style="text-align:center;">
                    <?php
                        if(count($_SESSION["foundCategories"]) == 4){
                            ?>You got it! It took you <?= count($_SESSION["guesses"])?> guesses.<?php
                        }else{
                            ?>Nice Try!<?php
                        }
                    ?>

                </h1>
                <p style="text-align:center;">Here are the categories: </p>
                <table class="table table-bordered w-auto" style="margin:auto">
                    <tbody>
                        <?php 
                $counter = 0;
                            foreach($_SESSION["currentCategories"] as $cat => $words){
                                switch($counter){
                                    case 0:
                                        ?>
                        <tr>
                            <td style="background-color: rgb(242, 211, 50); text-align:center;"><b><?= $cat ?>
                                </b><br><?= $words[0]?>,
                                <?= $words[1]?>,
                                <?= $words[2]?>, <?= $words[3]?></td>
                        </tr>
                        <?php
                                        break;
                                    case 1:
                                        ?>
                        <tr>
                            <td style="background-color: rgb(172, 196, 103); text-align:center;"><b><?= $cat ?>
                                </b><br><?= $words[0]?>,
                                <?= $words[1]?>,
                                <?= $words[2]?>, <?= $words[3]?></td>
                        </tr>
                        <?php
                                        break;
                                    case 2:
                                        ?>
                        <tr>
                            <td style="background-color: rgb(183, 197, 238); text-align:center;"><b><?= $cat ?>
                                </b><br><?= $words[0]?>,
                                <?= $words[1]?>,
                                <?= $words[2]?>, <?= $words[3]?></td>
                        </tr>
                        <?php
                                        break;
                                    case 3:
                                        ?>
                        <tr>
                            <td style="background-color: rgb(173, 132, 196); text-align:center;"><b><?= $cat ?>
                                </b><br><?= $words[0]?>,
                                <?= $words[1]?>,
                                <?= $words[2]?>, <?= $words[3]?></td>
                        </tr>
                        <?php
                                        break;
                                }
                            $counter += 1;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-xs-6 mt-2">
                <form class="form-inline" action="?command=playAgain" method="post">
                    <div class="row justify-content-center">
                        <button style="width: auto" type="submit" class="btn btn-outline-primary">Play Again!</button>
                    </div>
                </form>

            </div>
            <div class="col-xs-6 mt-2">
                <form class="form-inline" action="?command=exit" method="post">
                    <div class="row justify-content-center">
                        <button style="width: auto" type="submit" class="btn btn-outline-danger">Exit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>