<?php
// PUBLISHED VERSION: https://cs4640.cs.virginia.edu/fdu5ff/hw5
// Sources Used: https://cs4640.cs.virginia.edu, https://getbootstrap.com/docs/4.0/, https://www.php.net/manual/

// DEBUGGING ONLY! Show all errors.
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Class autoloading by name.  All our classes will be in a directory
// that Apache does not serve publicly.  They will be in /opt/src/, which
// is our src/ directory in Docker.
spl_autoload_register(function ($classname) {
    include "/opt/src/CategoryGame/$classname.php";
});

// Other global things that we need to do
// (such as starting a session, coming soon!)

// Instantiate the front controller
$trivia = new CategoryGameController($_GET);

// Run the controller
$trivia->run();