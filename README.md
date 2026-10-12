# Horizontai: būsto mugės registracijos forma

Failai:
- `index.html`: pati forma (Horizontų dizainas, pritaikyta planšetei ir telefonui)
- `apps-script.gs`: Google Sheets priėmimo skriptas

## 1. Google Sheet paruošimas (~5 min.)

1. Sukurkite naują Google Sheet, pvz. „Horizontai mugė 2026".
2. **Extensions → Apps Script**. Ištrinkite esamą kodą ir įklijuokite `apps-script.gs` turinį. Išsaugokite.
3. **Deploy → New deployment → Web app**:
   - Execute as: **Me**
   - Who has access: **Anyone**
4. Patvirtinkite leidimus ir nukopijuokite **Web app URL** (`https://script.google.com/macros/s/.../exec`).
5. `index.html` faile įrašykite jį į `const ENDPOINT = "";`.

Lentelė „Registracijos" su antraštėmis susikurs automatiškai po pirmo įrašo.
Excel failas: **File → Download → Microsoft Excel (.xlsx)**.

## 2. Talpinimas

Įkelkite `index.html` kartu su `fonts/` aplanku į serverį (pvz. `horizontai.visualidentity.studio/muge.html`, kaip Sangūškų parko atveju).
Šriftai Mars ir Mier A yra `fonts/` aplanke (paimti iš horizontai.com temos).

## 3. Mugės dieną

- Atidarykite formą planšetėje, įjunkite pilno ekrano režimą (iPad: „Add to Home Screen").
- Po pateikimo rodomas „Ačiū" ekranas, po 8 s forma išsivalo kitam lankytojui.
- **Dingus internetui** įrašai nesiprarda: jie laukia eilėje ir išsiunčiami atsiradus ryšiui.
  Apatiniame dešiniame kampe matyti būsena (žalia: viskas išsiųsta, geltona: laukia, raudona: nėra ryšio).
- **Atsarginė kopija**: 3 kartus greitai bakstelėkite Horizontų logotipą, atsisiųs visų tos planšetės įrašų CSV.

Prieš mugę: pateikite 1 bandomąjį įrašą ir patikrinkite, ar atsirado lentelėje.
