# Būsto mugės forma: WordPress (tema `wam`)

Forma naudoja **esamą** `releven-form` komponentą: tą pačią HTML struktūrą, stilius
(`.page-contacts .news .wrapper .left ...`), `releven-form.js` ir `releven_contact` AJAX handler'į.
Naujo CSS ar JS nėra, esamas temos kodas nekeičiamas.

## Failai

| Failas | Kur dėti | Kas tai |
|---|---|---|
| `templates/page-busto-muge.php` | `wp-content/themes/wam/templates/` | Puslapio šablonas (kopija iš `page-contacts.php` struktūros) |
| `inc/busto-muge-sheets.php` | `wp-content/themes/wam/inc/` | Sėkmingus įrašus persiunčia į Google Sheets |
| `../apps-script.gs` | Google Sheet → Extensions → Apps Script | Įrašo eilutes į lentelę |

## Diegimas (~10 min.)

1. Įkelti abu PHP failus į temą (žr. lentelę).
2. `functions.php` pabaigoje pridėti:
   ```php
   require_once get_template_directory() . '/inc/busto-muge-sheets.php';
   ```
3. Google Sheet: Extensions → Apps Script → įklijuoti `apps-script.gs` →
   Deploy → New deployment → **Web app**, Execute as: **Me**, Who has access: **Anyone** → nukopijuoti URL.
4. `wp-config.php` pridėti:
   ```php
   define( 'HZ_MUGE_SHEETS_URL', 'https://script.google.com/macros/s/XXXX/exec' );
   ```
5. WP admin: Puslapiai → Naujas, pavadinimas pvz. **REGISTRACIJA**, šablonas
   **„Būsto mugė (registracijos forma)"**, adresas pvz. `/muge/`. Publikuoti.
6. Išsiųsti bandomąjį įrašą ir patikrinti, ar atsirado lentelėje „Registracijos".

## Kaip veikia

- Forma siunčiama per esamą `releven_contact` handler'į, todėl veikia ta pati validacija,
  reCAPTCHA, nonce ir tas pats laiškas pardavimų komandai kaip iš /kontaktai/.
- Paslėptas laukas `form_id=busto-muge` pažymi mugės užklausas. `busto-muge-sheets.php`
  prisikabina prieš handler'į (prioritetas 1), perskaito jo JSON atsakymą ir **tik sėkmingus**
  įrašus nusiunčia į Sheets (po to, kai atsakymas jau išsiųstas naršyklei).
- Kitos formos (/kontaktai/, modalas) neliečiamos: be `form_id=busto-muge` kodas nieko nedaro.
- Planšetės režimas: po „Ačiū" puslapis po 8 s persikrauna kitam lankytojui (naujas nonce).
- Puslapis pažymėtas `noindex`.
- Jei Sheets nepasiekiamas, įrašas vis tiek ateina laišku, o klaida su duomenimis rašoma į `error_log`.

## Stulpeliai Google Sheet

Laikas · Vardas Pavardė · El. paštas · Telefonas · Komentaras · Sutikimas · Šaltinis · ID

Excel: File → Download → Microsoft Excel (.xlsx). Šaltinio tekstą galima keisti per
`define( 'HZ_MUGE_SOURCE', '...' )` `wp-config.php` faile.

## Pastabos programuotojui

- Jei `releven_contact` handler'is atsako ne per `wp_send_json*()`, Sheets dalis neveiks.
  Tada pakanka handler'io sėkmės šakoje iškviesti `hz_muge_forward()` logiką tiesiogiai.
- Konsultančių blokas dešinėje įrašytas šablone. Jei /kontaktai/ jie ateina iš ACF,
  galima perkelti tą patį ciklą iš `page-contacts.php`.
- Mugėje veiks tik su internetu (Wi-Fi ar mobilus ryšys planšetėje).
