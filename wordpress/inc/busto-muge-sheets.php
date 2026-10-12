<?php
/**
 * Būsto mugės forma -> Google Sheets.
 *
 * Įtraukti functions.php:  require_once get_template_directory() . '/inc/busto-muge-sheets.php';
 *
 * Kaip veikia: esamas releven_contact AJAX handler'is lieka nepakeistas
 * (validacija, reCAPTCHA, nonce, laiškas). Prieš jį (prioritetas 1) pažymime
 * užklausą, jei form_id=busto-muge. Kai handler'is atsako wp_send_json(),
 * shutdown metu perskaitome atsakymą ir TIK sėkmingus įrašus nusiunčiame į Sheets.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Google Apps Script Web app URL (žr. apps-script.gs). Galima perrašyti wp-config.php.
if ( ! defined( 'HZ_MUGE_SHEETS_URL' ) ) {
    define( 'HZ_MUGE_SHEETS_URL', '' );
}
if ( ! defined( 'HZ_MUGE_SOURCE' ) ) {
    define( 'HZ_MUGE_SOURCE', 'Būsto mugė 2026-10' );
}

add_action( 'wp_ajax_releven_contact', 'hz_muge_capture', 1 );
add_action( 'wp_ajax_nopriv_releven_contact', 'hz_muge_capture', 1 );

function hz_muge_capture() {
    if ( ! HZ_MUGE_SHEETS_URL || ( $_POST['form_id'] ?? '' ) !== 'busto-muge' ) {
        return;
    }
    ob_start();
    add_action( 'shutdown', 'hz_muge_forward', 0 );
}

function hz_muge_forward() {
    $output   = (string) ob_get_clean();
    $response = json_decode( $output, true );

    // Pirma atiduodame atsakymą naršyklei, kad lankytojas nelauktų Google
    echo $output;
    if ( function_exists( 'fastcgi_finish_request' ) ) {
        fastcgi_finish_request();
    }

    if ( empty( $response['success'] ) ) {
        return; // validacija ar reCAPTCHA nepraėjo: į Sheets nesiunčiame
    }

    $body = [
        'id'      => wp_generate_uuid4(),
        'time'    => gmdate( 'c' ),
        'name'    => sanitize_text_field( wp_unslash( $_POST['name'] ?? '' ) ),
        'email'   => sanitize_email( wp_unslash( $_POST['email'] ?? '' ) ),
        'phone'   => sanitize_text_field( wp_unslash( $_POST['phone'] ?? '' ) ),
        'comment' => sanitize_textarea_field( wp_unslash( $_POST['message'] ?? '' ) ),
        'consent' => ! empty( $_POST['privacy'] ) ? 'Taip' : 'Ne',
        'source'  => HZ_MUGE_SOURCE,
    ];

    $res = wp_remote_post( HZ_MUGE_SHEETS_URL, [
        'body'    => $body,
        'timeout' => 10,
    ] );

    if ( is_wp_error( $res ) ) {
        error_log( '[busto-muge] Sheets klaida: ' . $res->get_error_message() . ' | ' . wp_json_encode( $body ) );
    }
}

// Mugės puslapio nerodyti paieškose
add_filter( 'wp_robots', function ( $robots ) {
    if ( is_page_template( 'templates/page-busto-muge.php' ) ) {
        $robots['noindex']  = true;
        $robots['nofollow'] = true;
    }
    return $robots;
} );
