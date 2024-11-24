<?php
require "vendor/autoload.php";

$loader = new \Twig\Loader\FilesystemLoader("views");
$twig = new \Twig\Environment($loader);

/**
 * A possible "mark" a grid/cell on the tic-tac-toe board could have.
 *  - X
 *  - O
 *  - EMPTY
 */
enum Mark: string
{
    case X = "X";
    case O = "O";
    case EMPTY = "";
}

/**
 * A 3x3 tic-tac-toe board, individual cells can be marked as X or O.
 */
class Board
{
    public $board;

    public function __construct()
    {
        $this->board = [
            [Mark::EMPTY, Mark::EMPTY, Mark::EMPTY],
            [Mark::EMPTY, Mark::EMPTY, Mark::EMPTY],
            [Mark::EMPTY, Mark::EMPTY, Mark::EMPTY],
        ];
    }

    /**
     * Returns an array containing the string array representation of the board (opposed to using Mark enums).
     * @return string[] The string array representation of the board
     */
    public function getValues(): array
    {
        return array_map(
            fn($row) => array_map(fn($mark) => $mark->value, $row),
            $this->board
        );
    }

    /**
     * Fills / Replaces a position on the board with the given mark.
     * @param Mark $mark The mark to fill / replace.
     * @param int $row The row to fill / replace.
     * @param int $col The column to fill / replace.
     */
    public function assignMark(Mark $mark, int $row, int $col): void
    {
        $this->board[$row][$col] = $mark;
    }

    /**
     * Returns the mark from the given position on the board.
     * @param int $row The row of the mark.
     * @param int $col The column of the mark.
     * @return Mark The mark.
     */
    public function markFromPosition(int $row, int $col): Mark
    {
        return $this->board[$row][$col];
    }

    public function onCellClick()
    {
        echo "<script>console.log('PHP:');</script>";
    }
}

session_start();

// Reset session data when the page is reloaded
$pageRefreshed =
    isset($_SERVER["HTTP_CACHE_CONTROL"]) &&
    ($_SERVER["HTTP_CACHE_CONTROL"] === "max-age=0" ||
        $_SERVER["HTTP_CACHE_CONTROL"] == "no-cache");
if ($pageRefreshed == 1) {
    session_destroy();
}

/**
 * Retrieves (and initializes if needed) the session state from the given id.
 * @param string $id The session value's id.
 * @param mixed $defaultValue The default value if the session state needs to be initialized.
 * @return mixed The retrieved value of the session id.
 */
function get_or_init_session_data(string $id, mixed $defaultValue): mixed
{
    if (!isset($_SESSION[$id])) {
        $_SESSION[$id] = $defaultValue;
    }
    return $_SESSION[$id];
}

// Keep the board & current player state persistant across requests
$board = get_or_init_session_data("board", new Board());
$cur_player = get_or_init_session_data("cur_player", Mark::X);

// Echo the player to play next
$next_player = $cur_player === Mark::X ? Mark::O : Mark::X;
echo "Player: `" . $next_player->value . "` turn!";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get pos POST argument (the clicked cell row and column data values)
    $posData = $_REQUEST["pos"];
    $posData = json_decode($posData, true); // Decode as an associative array

    $row = intval($posData[0]);
    $col = intval($posData[1]);

    // Update the board and send the new HTML state as the response
    $board->assignMark($cur_player, $row, $col);
    echo $twig->render("index.html", ["board" => $board->getValues()]);

    $_SESSION["cur_player"] = $next_player;
} else {
    echo $twig->render("index.html", ["board" => $board->getValues()]);
}

?>
