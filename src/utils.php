<?php
namespace Utils;

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
?>
