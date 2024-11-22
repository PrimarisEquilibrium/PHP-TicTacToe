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

$board = new Board();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get pos POST argument (the clicked cell row and column data values)
    $posData = $_REQUEST["pos"];
    $posData = json_decode($posData, true); // Decode as an associative array

    $row = intval($posData[0]);
    $col = intval($posData[1]);

    // Update the board and send the new HTML state as a response to the AJAX
    $board->assignMark(Mark::X, $row, $col);
    echo $twig->render("index.html", ["board" => $board->getValues()]);
} else {
    echo $twig->render("index.html", ["board" => $board->getValues()]);
}

?>
