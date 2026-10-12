// Horizontai: būsto mugės registracijos -> Google Sheets
// Įklijuokite į Extensions > Apps Script ir paskelbkite kaip Web app (žr. README.md)

const SHEET_NAME = "Registracijos";
const HEADERS = ["Laikas", "Vardas Pavardė", "El. paštas", "Telefonas", "Komentaras", "Sutikimas", "Šaltinis", "ID"];

function doPost(e) {
  const lock = LockService.getScriptLock();
  lock.waitLock(10000);
  try {
    const p = e.parameter || {};
    const sheet = getSheet_();

    // Apsauga nuo dublikatų, jei planšetė siunčia pakartotinai
    if (p.id) {
      const last = sheet.getLastRow();
      if (last > 1) {
        const ids = sheet.getRange(2, 8, last - 1, 1).getValues().flat();
        if (ids.indexOf(p.id) !== -1) return json_({ ok: true, duplicate: true });
      }
    }

    sheet.appendRow([
      p.time ? new Date(p.time) : new Date(),
      clean_(p.name),
      clean_(p.email),
      "'" + String(p.phone || "").slice(0, 50), // tekstas, kad Sheets nenuimtų "+" ar 0
      clean_(p.comment),
      clean_(p.consent),
      clean_(p.source),
      clean_(p.id)
    ]);
    return json_({ ok: true });
  } catch (err) {
    return json_({ ok: false, error: String(err) });
  } finally {
    lock.releaseLock();
  }
}

function doGet() {
  return json_({ ok: true, service: "horizontai-forma" });
}

function getSheet_() {
  const ss = SpreadsheetApp.getActiveSpreadsheet();
  let sheet = ss.getSheetByName(SHEET_NAME);
  if (!sheet) sheet = ss.insertSheet(SHEET_NAME);
  if (sheet.getLastRow() === 0) {
    sheet.appendRow(HEADERS);
    sheet.getRange(1, 1, 1, HEADERS.length).setFontWeight("bold");
    sheet.setFrozenRows(1);
    sheet.getRange("A:A").setNumberFormat("yyyy-mm-dd hh:mm");
  }
  return sheet;
}

// Neleidžia formulių injekcijos (=, +, -, @ pradžioje)
function clean_(v) {
  v = String(v || "").slice(0, 2000);
  return /^[=+\-@]/.test(v) ? "'" + v : v;
}

function json_(obj) {
  return ContentService.createTextOutput(JSON.stringify(obj)).setMimeType(ContentService.MimeType.JSON);
}
