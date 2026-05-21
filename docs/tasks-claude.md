# Quote — Improvement Tasks

Module path: `htdocs/modules/quote/`
PHP files: 129, TPL files: 30, has composer.json: N, has phpstan: Y, has tests: Y, has preloads: Y, has sql/: Y

Quote catalogue module — authors, categories, quotes, search, blocks (random quote, category, author), admin UI with `Common/` scaffolding (Breadcrumb, FileChecker, LetterChoice, ObjectTree, SysUtility).

Scope: actionable tasks to align Quote with XOOPS 2.7 / PHP 8.2–8.5 / Smarty 4 conventions per `~/.claude/CLAUDE.md` and the project `CLAUDE.md`. Derived from `docs/_scan-data.md` and handler spot-checks.

## 1. Critical — security and correctness

- [ ] Language constants use the LEGACY order: `MI_QUOTE_NAME` / `MI_QUOTE_DESC` (no leading underscore, no `_MI_QUOTE_` prefix) — the canonical XOOPS rule is `_MI_QUOTE_NAME`. Audit `language/english/modinfo.php` and rename.
- [ ] CSRF validation BEFORE state change on every `admin/*.php`: `admin/author.php`, `admin/authors.php`, `admin/category.php`, `admin/quote.php`, `admin/quotes.php`, `admin/feedback.php`, `admin/permissions.php`, `admin/blocksadmin.php`, `admin/migrate.php`.
- [x] `min_php` in manifest is `7.4` — raise to `8.2`.
- [ ] Upload handling (`class/Common/FileChecker.php`, `admin/author.php` avatars): `basename()` before allowlist, MIME + size.

## 2. Database & SQL

- [x] Replace `->queryF(...)` with `->exec()` / `->query()`. Sites:
  - `class/Common/SysUtility.php` (`queryFAndCheck` helper at line 415)
  - `include/oninstall.php`, `include/onupdate.php`
- [ ] Two-part fetch guard on every `fetchArray/fetchRow` call across handlers (`class/AuthorHandler.php`, `AuthorsHandler.php`, `CategoryHandler.php`, `QuoteHandler.php`, `QuotesHandler.php`).
- [x] Replace `quoteString()` → `quote()` if any remain.
- [ ] Type-hint DB params as `XoopsMySQLDatabase`.
- [ ] Rename query variables to `$result`.
- [ ] `sql/*.sql`: `InnoDB`, `utf8mb4`, explicit INSERT columns.

## 3. PHP 8.2–8.5 compatibility

- [ ] Implicit-nullable → `?Type` across handlers and admin files.
- [ ] Return types on public methods.
- [ ] Wrap bare undefined constants in `defined(...)`-ternary.
- [ ] `strlen()` → `mb_strlen()` for quote body / author name validation.
- [ ] `switch` → `match` in letter-choice filter code.

## 4. Security hardening

- [ ] Raw `$_GET/$_POST` → `Xmf\Request::getXxx()` across `author.php`, `authors.php`, `category.php`, `quote.php`, `quotes.php`, `comment_*.php`. Respect Elvis-drops-zero for numeric IDs.
- [ ] All `unserialize()` → `['allowed_classes' => false]`.
- [ ] No `extract()` on superglobals.
- [ ] Templates: `|escape` on quote body, author name, category title. If quote body allows HTML formatting, use `getVar('quote', 'n')` at the handler and NEVER `|escape` at template.

## 5. XOOPS conventions

- [ ] **Rename language constants**: `MI_QUOTE_*` → `_MI_QUOTE_*` (add missing underscore). This is a visibility + consistency fix. Run `bash scripts/check-mi-constants.sh htdocs/modules/quote/language/` after.
- [ ] Admin pages: `xoops_cp_header()`, `xoops_cp_footer()`, `$xoBreadCrumb`, `<{include file="db:system_header.tpl"}>`, `<{xoAdminIcons}>`.
- [ ] Preload registration for comment / search hooks — `preloads/core.php` exists, audit coverage.

## 6. Smarty templates

- [ ] 30 templates — systematic `|escape` audit.
- [ ] Delimiter scan clean.
- [ ] Block templates (`templates/blocks/`) need `|escape` on every dynamic field.

## 7. Tests & quality gates

- [ ] Add `composer.json` with PHP ^8.2.
- [ ] PHPStan baseline exists — ratchet up.
- [ ] Expand `tests/` — no current unit tests visible under `tests/`.
- [ ] PHPUnit 11 attribute syntax.

## 8. Module structure & modernisation

- [ ] Namespace under `XoopsModules\Quote\*` consistently.
- [ ] Clarify naming: `Author` vs `Authors`, `Quote` vs `Quotes` — one of each pair is a handler and the other is a domain object; rename handlers to `AuthorHandler`, `QuoteHandler`, `CategoryHandler` and drop the pluralised class names.
- [ ] Adopt `Xmf\Module\Helper` (already imported) throughout public entry points.
- [ ] `include/common.php` — confirm it is included by every public entry point and not duplicating `header.php`.

## 9. Module-specific follow-ups

- [ ] Quote-of-the-day block: confirm the RNG uses `random_int` / `mt_rand` intentionally (no cryptographic need here).
- [ ] Letter-choice filter UI (`class/Common/LetterChoice.php`): confirm it handles non-ASCII author names gracefully.
- [ ] Duplicate author detection: on save, warn on near-duplicate author names (optional nice-to-have).

## 10. Documentation

- [ ] README.md: install, data model, block configuration.
- [ ] `docs/lang_diff.txt` — add if constant-rename migration happens.
