<?php
namespace TicTacToe;

require_once "Mark.php";

use TicTacToe\Mark;

/**
 * A 3x3 tic-tac-toe board, individual cells can be marked as X or O.
 */
class Board
{
    public $board;
    public $is_empty = true;

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
    public function get_values(): array
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
    public function assign_mark(Mark $mark, int $row, int $col): void
    {
        $this->board[$row][$col] = $mark;
        $this->is_empty = false;
    }

    /**
     * Returns the mark from the given position on the board.
     * @param int $row The row of the mark.
     * @param int $col The column of the mark.
     * @return Mark The mark.
     */
    public function mark_from_position(int $row, int $col): Mark
    {
        return $this->board[$row][$col];
    }
}
?>
