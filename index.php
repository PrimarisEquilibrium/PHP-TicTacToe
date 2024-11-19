<?php
enum Mark: string
{
    case X = "X";
    case O = "O";
}

class Board
{
    private $board;

    public function __construct()
    {
        $this->board = array_fill(0, 9, null);
    }

    /**
     * Echos (prints) the json representation of the board.
     */
    public function renderBoard(): void
    {
        echo json_encode($this->board);
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
     * Returns the mark (or null) from the given position on the board.
     * @param int $row The row of the mark.
     * @param int $col The column of the mark.
     * @return Mark|null The mark if found; otherwise null.
     */
    public function markFromPosition(int $row, int $col): Mark|null
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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="box"></div>
            <div class="box"></div>
            <div class="box"></div>
        </div>
        <div class="row">
            <div class="box"></div>
            <div class="box"></div>
            <div class="box"></div>
        </div>
        <div class="row">
            <div class="box"></div>
            <div class="box"></div>
            <div class="box"></div>
        </div>
    </div>
</body>
</html>