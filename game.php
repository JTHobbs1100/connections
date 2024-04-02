<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Jacob Hobbs">
    <meta name="description" content="Game Screen">
    <title>Category Game Screen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <div class="container" style="margin-top: 15px;">
        <div class="row ">
            <div class="col-xs-12">
                <h1 style="text-align:center;">Hello, <?=$_SESSION["username"]?>!</h1>
                <table class="table table-bordered w-auto" style="margin:auto">
                    <tbody>
                        <?php 
                            for($i = 0; $i<count($_SESSION["randomizedWords"]); $i += 4){
                                ?>
                        <tr>
                            <td><span style="color:grey">(<?= $i + 1;?>)
                                </span><?= $_SESSION["randomizedWords"][$i][0] ?>
                            </td>
                            <td><span style="color:grey">(<?= $i + 2;?>)
                                </span><?= $_SESSION["randomizedWords"][$i+1][0] ?></td>
                            <td><span style="color:grey">(<?= $i + 3;?>)
                                </span><?= $_SESSION["randomizedWords"][$i+2][0] ?></td>
                            <td><span style="color:grey">(<?= $i + 4;?>)
                                </span><?= $_SESSION["randomizedWords"][$i+3][0] ?></td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-xs-12 mt-2">
                <form class="form-inline" action="?command=guess" method="post">
                    <div class="row justify-content-center">
                        <label style="width: auto;" for="guess" class="col-form-label">Guess:
                        </label>
                        <input style="width: 16ch" type="text" class="form-group mx-2" id="category-guess" name="guess"
                            placeholder="enter 4 numbers...">
                        <button style="width: auto" type="submit" class="btn btn-primary">Submit Answer</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-xs-12 mt-2">
                <form class="form-inline" action="?command=endGame" method="post">
                    <div class="row justify-content-center">
                        <button style="width: auto" type="submit" class="btn btn-outline-danger">Exit</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12" style="text-align:center;">
                <?=$message?>
            </div>
        </div>
        <!-- <pre><?php print_r($_SESSION["foundCategories"]);?></pre> -->
        <table class="table table-bordered w-auto" style="margin:auto">
            <tbody>
                <?php 
                $counter = 0;
                            foreach($_SESSION["foundCategories"] as $cat => $words){
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
        <br>


        <h2 style="text-align:center"> Guess History </h2>
        <table class="table table-bordered w-auto" style="margin:auto">
            <tbody>
                <?php 
                if(count($_SESSION["guesses"]) == 0){ 
                    ?>
                <p style="text-align:center">No guesses yet!</p>
                <?php
                }else{
                    ?><p style="text-align:center;">Current number of guesses: <?= count($_SESSION["guesses"])?> </p> <?php
                            foreach(array_reverse($_SESSION["guesses"]) as $guess){
                                if($guess[0]){
                                        ?>
                <tr>
                    <td style="background-color: rgb(214, 230, 221); text-align:center;"><?= $guess[1] . $guess[2][0]?>,
                        <?= $guess[2][1]?>,
                        <?= $guess[2][2]?>, <?=$guess[2][3]?></td>
                </tr>
                <?php
                                    }else{
                                        ?>
                <tr>
                    <td style="background-color: rgb(239, 214, 218); text-align:center;"><?= $guess[1] . $guess[2][0]?>,
                        <?= $guess[2][1]?>,
                        <?= $guess[2][2]?>, <?=$guess[2][3]?></td>
                </tr>
                <?php
                                        
                                }
                            $counter += 1;
                        }
                    }
                        ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>