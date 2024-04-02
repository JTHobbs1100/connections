<?php

class CategoryGameController
{

    private $categories = [];

    /**
     * Constructor, $input is $_GET
     */
    public function __construct($input)
    {
        $this->input = $input;
        $this->loadCategories();
        session_start();
    }

    /**
     * Run the server
     *
     * Given the input (usually $_GET), then it will determine
     * which command to execute based on the given "command"
     * parameter.  Default is the welcome page.
     */
    public function run()
    {
        $command = "";
        if (isset($this->input["command"])) {
            $command = $this->input["command"];
        }

        switch ($command) {
            case "game":
                $this->playGame();
                break;
            case "guess":
                if(!isset($_SESSION["username"])){
                    $this->showWelcome();
                }else{
                    $this->handleGuess();
                }
                
                break;
            case "endGame":
                if(!isset($_SESSION["username"])){
                    $this->showWelcome();
                }else{
                    $this->showEndGame();
                }
                
                break;
            case "playAgain":
                if(!isset($_SESSION["username"])){
                    $this->showWelcome();
                }else{
                    $this->playAgain();
                }
                
                break;
            case "exit":
                $this->showWelcome();
                break;
            default:
                $this->showWelcome();
                break;
        }
    }

    /**
     * Load categories from a file, store them as an array
     * in the current object.
     */
    public function loadCategories()
    {
        $this->categories = json_decode(
            file_get_contents("/opt/src/CategoryGame/data/connections.json"), true);

        if (empty($this->categories)) {
            die("Something went wrong loading categories");
        }
        if (count($this->categories) < 4) {
            die("NOT ENOUGH CATEGORIES FOR FULL GAME");
        }
        ?>
<?php
}

    public function getNewCategories()
    {
        $id = array_rand($this->categories, 4);
        $words = array();
        foreach ($id as $cat) {
            $wordIndexes = array_rand($this->categories[$cat], 4);
            foreach ($wordIndexes as $word) {
                $words[$cat][] = $this->categories[$cat][$word];
            }
        }
        return ["id" => $id, "categories" => $words];

    }


    public function playGame($message = "")
    {
        if(isset($_POST["fullname"])) $_SESSION["username"] = $_POST["fullname"];
        if(!isset($_SESSION["foundCategories"])){
            $_SESSION["foundCategories"] = array();
        }
        if(count($_SESSION["foundCategories"]) == 4){
            $this->showEndGame();
        }else if (isset($_SESSION["username"])) {
            $firstLoadIn = false;
            if(!isset($_SESSION["currentCategories"])) {
                $_SESSION["currentCategories"] = $this->getNewCategories()["categories"];
                $_SESSION["unfoundCategories"] = $_SESSION["currentCategories"];
                $firstLoadIn = true;
                $_SESSION["correctGuess"] = false;
                $_SESSION["guesses"] = array();
                $_SESSION["numGuesses"] = 0;
            }
            
            if($_SESSION["correctGuess"] == true || $firstLoadIn){
       
                    $_SESSION["randomizedWords"] = array();
                    foreach($_SESSION["unfoundCategories"] as $categoryKey => $words){
                        foreach($words as $word){
                            $_SESSION["randomizedWords"][] = array($word, $categoryKey);
                        }
                    }
                    shuffle($_SESSION["randomizedWords"]);
                
            }else{
                // echo "incorrect guess";
            }
            //$numUnfoundCategories = count($_SESSION["unfoundCategories"]);
            
            include "/opt/src/CategoryGame/templates/game.php";
        } else {
            $this->showWelcome();
        }
    }


    public function showWelcome()
    {
        session_destroy();
        session_start();
        include "/opt/src/CategoryGame/templates/welcome.php";
    }

   
    public function handleGuess() 
    {
        $message = "";
        if (isset($_POST["guess"])) {

            // echo "YOU GUESSED " . $_POST["guess"] . " ";
            $_SESSION["correctGuess"] = false;

            if(!preg_match("/^[0-9]+\s[0-9]+\s[0-9]+\s[0-9]+$/",$_POST["guess"])){
                $message = "<div class=\"alert alert-danger\" role=\"alert\" style=\"display: inline-block;\">
                    Please enter four space-seperated numbers!
                    </div>";
            }else{
                $guessArr = explode(" ", $_POST["guess"]);
                $withinBounds = true;

                foreach($guessArr as $num){
                    if($num < 1 || $num > count($_SESSION["randomizedWords"])){
                        $withinBounds = false;
                    }
                }

                if(!$withinBounds){
                    $message = "<div class=\"alert alert-danger\" role=\"alert\" style=\"display: inline-block;\">
                    Please enter a numbers that are displayed above!
                    </div>";
                }else if(count($guessArr) != count(array_unique($guessArr))){
                    $message = "<div class=\"alert alert-danger\" role=\"alert\" style=\"display: inline-block;\">
                    Please don't enter duplicate numbers!
                    </div>";
                }else{
                    $catCounter = array();
                    foreach($_SESSION["currentCategories"] as $cat => $val){ //initialize category counter
                        $catCounter[$cat] = 0;
                    }
                    foreach($guessArr as $guessNum){
                        $catCounter[$_SESSION["randomizedWords"][$guessNum-1][1]] += 1;
                    }
                    $guessWords = array();
                    foreach($guessArr as $num){
                        $guessWords[] = $_SESSION["randomizedWords"][$num-1][0];
                    }

                    arsort($catCounter);

                    switch ($catCounter[array_keys($catCounter)[0]]) {
                        case 4:
                            // $message = "<div class=\"alert alert-success\" role=\"alert\" style=\"display: inline-block;\">
                            //     Correct guess!
                            // </div>";
                            $_SESSION["correctGuess"] = true;
                            $foundCategory = $_SESSION["randomizedWords"][$guessNum-1][1];
                            unset($_SESSION["unfoundCategories"][$foundCategory]);
                            $_SESSION["foundCategories"][$foundCategory] = $_SESSION["currentCategories"][$foundCategory];
                            $_SESSION["guesses"][$_SESSION["numGuesses"]] = array(true, "$foundCategory: ", $guessWords);
                            break;
                        case 3:
                            $message = "<div class=\"alert alert-warning\" role=\"alert\" style=\"display: inline-block;\">
                                So close! Only one off!
                            </div>";
                            $_SESSION["guesses"][$_SESSION["numGuesses"]] = array(false, "Off by 1: ", $guessWords);
                            break;
                        case 2:
                            $message = "<div class=\"alert alert-warning\" role=\"alert\" style=\"display: inline-block;\">
                                Not quite! But you're half right...
                            </div>";
                            $_SESSION["guesses"][$_SESSION["numGuesses"]] = array(false, "Off by 2: ", $guessWords);
                            break;
                        case 1:
                            $message = "<div class=\"alert alert-warning\" role=\"alert\" style=\"display: inline-block;\">
                                Incorrect! None of those share the same category!
                            </div>";
                            $_SESSION["guesses"][$_SESSION["numGuesses"]] = array(false, "None in common: ", $guessWords);
                            break;
                        default:
                            $message = "<div class=\"alert alert-danger\" role=\"alert\" style=\"display: inline-block;\">
                            Something went wrong...
                            </div>";
                            break;
                    }
                    $_SESSION["numGuesses"] += 1;
                    
                }
                
            }

        } else{
            $this->showWelcome();
        }

        $this->playGame($message); 
    }

    public function showEndGame(){
        include "/opt/src/CategoryGame/templates/endGame.php";
    }

    public function playAgain(){
        unset($_SESSION["currentCategories"]);
        unset($_SESSION["foundCategories"]);
        $this->playGame();
    }

}