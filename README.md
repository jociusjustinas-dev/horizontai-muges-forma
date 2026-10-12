# Horizontai: būsto mugės registracijos forma

Atskiras puslapis, nepriklausomas nuo horizontai.com svetainės. Viskas, ko reikia, yra šiame aplanke:

```
index.html       forma
fonts/           Mars ir Mier A šriftai
img/hero.webp    nuotrauka kairėje
apps-script.gs   Google Sheets kodas (į serverį kelti nereikia)
```

## Paleidimas live (3 žingsniai, ~10 min.)

### 1. Google Sheet
1. Sukurti naują Google Sheet, pvz. „Horizontai mugė 2026".
2. **Extensions → Apps Script**, ištrinti esamą kodą, įklijuoti `apps-script.gs`, išsaugoti.
3. **Deploy → New deployment → Web app**: Execute as **Me**, Who has access **Anyone** → Deploy.
4. Patvirtinti leidimus ir nukopijuoti **Web app URL** (`https://script.google.com/macros/s/.../exec`).

### 2. Įrašyti URL į formą
`index.html` faile surasti eilutę ir įklijuoti URL:
```js
const ENDPOINT = "https://script.google.com/macros/s/.../exec";
```
Ten pat galima pakeisti `SOURCE` (tekstas stulpelyje „Šaltinis").

### 3. Įkelti į serverį
Įkelti `index.html`, `fonts/` ir `img/` į bet kurį serverį per FTP ar failų tvarkyklę,
pvz. į `horizontai.visualidentity.studio/`. Daugiau nieko nereikia: nėra PHP, duomenų bazės ar build'o.

Atsidarius puslapiui, dešiniame apatiniame kampe turi degti **žalias** taškas „Prisijungta".
Išsiųsti 1 bandomąjį įrašą ir patikrinti, ar jis atsirado lentelėje „Registracijos".

## Excel
Google Sheet → **File → Download → Microsoft Excel (.xlsx)**.
Stulpeliai: Laikas · Vardas Pavardė · El. paštas · Telefonas · Komentaras · Sutikimas · Šaltinis · ID.

## Mugės dieną
- Planšetėje atidaryti puslapį ir pridėti prie pradžios ekrano (iPad: Share → **Add to Home Screen**),
  tada forma atsidaro per visą ekraną be naršyklės juostos.
- Po pateikimo rodomas „Ačiū" ekranas, po 8 s forma išsivalo kitam lankytojui.
- **Dingus internetui** įrašai neprarandami: jie laukia planšetėje ir išsiunčiami, kai grįžta ryšys.
  Būsena kampe: žalia (viskas išsiųsta), geltona (laukia), raudona (nėra ryšio arba nenustatytas URL).
- **Atsarginė kopija**: 3 kartus greitai bakstelėti Horizontai logotipą, atsisiųs visų tos planšetės įrašų CSV.
