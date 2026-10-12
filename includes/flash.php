<?php
/**
 * Helper flash message sederhana pakai session.
 * set_flash() dipanggil sebelum redirect, show_flash() dipanggil di halaman tujuan.
 */

function set_flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function show_flash(): void
{
    if (empty($_SESSION['flash'])) {
        return;
    }

    $flash = $_SESSION['flash'];
    $type = $flash['type'] === 'sukses' ? 'flash-sukses' : 'flash-gagal';

    echo '<div class="flash ' . $type . '">' . htmlspecialchars($flash['message']) . '</div>';

    unset($_SESSION['flash']);
}
