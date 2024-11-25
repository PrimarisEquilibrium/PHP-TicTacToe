<?php
namespace TicTacToe;

require_once "Mark.php";

use TicTacToe\Mark;

/**
 * A 3x3 tic-tac-toe board, individual cells can be marked as X or O.
 */
class Board
{
    /**
     * @var Mark[][]
     */
    public array $board;
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

    /**
     * Returns if the array (of length 3) is filled with only one type of mark, and therefore a win.
     * @param array $arr The array to check.
     * @return bool True if the array is considered a 'win'; otherwise false.
     */
    public function checkWinArray(array $arr): bool
    {
        return !(in_array(Mark::X, $arr) && in_array(Mark::O, $arr)) &&
            !in_array(Mark::EMPTY, $arr);
    }

    /**
     * Determines if there is a winner and return its mark; If one doesn't exist return null.
     * @return Mark|null The mark that won the game; otherwise null.
     */
    public function checkWin(): Mark|null
    {
        // Compare all rows and columns
        for ($x = 0; $x < 3; $x++) {
            // Get the current row and column
            $row_array = $this->board[$x];
            $col_array = array_column($this->board, $x);

            // Check for any winners
            if ($this->checkWinArray($row_array)) {
                return $row_array[0];
            }

            if ($this->checkWinArray($col_array)) {
                return $col_array[0];
            }
        }

        // Compare both diagonals
        $diagonal_array_left = [
            $this->board[0][0],
            $this->board[1][1],
            $this->board[2][2],
        ];
        $diagonal_array_right = [
            $this->board[0][2],
            $this->board[1][1],
            $this->board[2][0],
        ];

        // Check for any winners
        if ($this->checkWinArray($diagonal_array_left)) {
            return $diagonal_array_left[0];
        }
        if ($this->checkWinArray($diagonal_array_right)) {
            return $diagonal_array_right[0];
        }

        // No winner found
        return null;
    }

    /**
     * Determines if the tictactoe game is a tie.
     * Which means all cells are filled and no winner exists.
     * @return bool True if there is a tie; otherwise false.
     */
    public function checkTie(): bool
    {
        for ($row = 0; $row < 3; $row++) {
            for ($col = 0; $col < 3; $col++) {
                $cell = $this->board[$row][$col];
                if ($cell === Mark::EMPTY) {
                    return false;
                }
            }
        }
        if ($this->checkWin()) {
            return false;
        }
        return true;
    }
}
?>
