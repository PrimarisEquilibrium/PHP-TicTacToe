<?php
require "vendor/autoload.php";

$loader = new \Twig\Loader\FilesystemLoader("views");
$twig = new \Twig\Environment($loader);

/**
 * A possible "mark" a grid/box on the tic-tac-toe board could have.
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
            [Mark::EMPTY, Mark::EMPTY, Mark::EMPTY]
        ];
    }

    /**
     * Returns an array containing the string array representation of the board (opposed to using Mark enums).
     * @return string[] The string array representation of the board
     */
    public function getValues() : array {
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
}

$board = new Board();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TicTacToe</title>
</head>
<body>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>TicTacToe</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php echo $twig->render('index.html.twig', ['board' => $board->getValues()]); ?>
    </body>
    </html>
</body>
</html>