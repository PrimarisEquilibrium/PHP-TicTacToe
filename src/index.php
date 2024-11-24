<?php
require "../vendor/autoload.php";

require "./classes/Board.php";
require_once "./classes/Mark.php";
require_once "utils.php";

use TicTacToe\Board;
use TicTacToe\Mark;
use function Utils\get_or_init_session_data;
use function Utils\reset_session_on_refresh;

$loader = new \Twig\Loader\FilesystemLoader("views");
$twig = new \Twig\Environment($loader);

session_start();

// Reset session data when the page is reloaded
reset_session_on_refresh();

// Keep the board & current player state persistant across requests
$board = get_or_init_session_data("board", new Board());
$cur_player = get_or_init_session_data("cur_player", Mark::X);

$next_player = $cur_player === Mark::X ? Mark::O : Mark::X;
$valid_move = false; // Stores if the most recent move was valid

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get pos POST argument (the clicked cell row and column data values)
    $posData = $_REQUEST["pos"];
    $posData = json_decode($posData, true); // Decode as an associative array

    $row = intval($posData[0]);
    $col = intval($posData[1]);

    if ($board->mark_from_position($row, $col) === Mark::EMPTY) {
        // Update the board with the new mark
        $board->assign_mark($cur_player, $row, $col);

        $valid_move = true;
        $_SESSION["cur_player"] = $next_player;
    }
}

// Determine which player's turn to display
// Only display the next players move if the previous move was valid
if ($valid_move) {
    // On the first move always display `X` to move
    $player_to_display = !$board->is_empty ? $next_player : $cur_player;
} else {
    $player_to_display = $cur_player;
}
echo "Player: `" . $player_to_display->value . "` turn! <br>";

// Display winner
if ($board->checkWin()) {
    echo "Winner: " . $board->checkWin()->value;
}

echo $twig->render("index.html.twig", ["board" => $board->get_values()]);
?>
