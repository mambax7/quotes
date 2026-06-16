# Quotes — Improvement Tasks

Module path: `htdocs/modules/quotes/`
PHP files: 89, TPL files: 22, has composer.json: N, has phpstan: Y, has tests: Y, has preloads: Y, has sql/: Y

Alternate quote catalogue — quotes with categories and authors; smaller sibling of the `quote` module. Has handlers, form classes, and a complete unit-test suite for handlers.

Scope: actionable tasks to align Quotes with XOOPS 2.7 / PHP 8.2–8.5 / Smarty 4 conventions per `~/.claude/CLAUDE.md` and the project `CLAUDE.md`. Derived from `docs/_scan-data.md` and spot-checks.

## 1. Critical — security and correctness

- [ ] Language constants use the LEGACY order: `MI_QUOTES_NAME` / `MI_QUOTES_DESC` (no leading underscore, no `_MI_QUOTES_` prefix). Canonical XOOPS rule is `_MI_QUOTES_*`. Rename and run `bash scripts/check-mi-constants.sh htdocs/modules/quotes/language/`.
- [ ] CSRF validation BEFORE state change on every `admin/*.php`: `admin/author.php`, `admin/category.php`, `admin/quote.php`, `admin/blocksadmin.php`, `admin/feedback.php`, `admin/migrate.php`, `admin/permissions.php`. Save/delete/send/block-edit/migration writes now validate tokens with POST-pinned fields; clone actions still need a confirm/token flow before this can be marked complete.
- [x] `min_php` in manifest is `8.0` — raise to `8.2` to match project minimum.
- [x] **`admin/00/blockform.php`**, **`admin/00/blocksadmin.php`** — archived duplicates; remove.
- [x] **`testdata/index0.php`** — archived duplicate index; remove.

## 2. Database & SQL

- [x] Replace `->queryF(...)` with `->exec()` / `->query()`. Sites:
  - `include/oninstall.php`, `include/onupdate.php`
- [ ] Two-part fetch guard on every `fetchArray/fetchRow` call in `class/AuthorHandler.php`, `CategoryHandler.php`, `QuoteHandler.php`.
- [ ] Replace `quoteString()` → `quote()` if any remain.
- [ ] Type-hint DB params as `XoopsMySQLDatabase`.
- [ ] Rename query variables to `$result`.
- [x] `sql/*.sql`: `InnoDB`, `utf8mb4`, explicit INSERT columns.

## 3. PHP 8.2–8.5 compatibility

- [ ] Implicit-nullable → `?Type` across handlers.
- [ ] Return types on public methods.
- [ ] Wrap bare undefined constants in `defined(...)`-ternary.
- [ ] `strlen()` → `mb_strlen()` for quote body / author name validation.

## 4. Security hardening

- [ ] Raw `$_GET/$_POST` → `Xmf\Request::getXxx()` across `quote.php`, `author.php`, `category.php`, `comment_*.php`. Respect Elvis-drops-zero for numeric IDs (`docs/tasks-codex.md` flagged 17 raw-superglobal lines in a past audit). Active request reads in public quote/category/author/comment_new and the main admin controllers are now source-pinned; remaining grep hits are comments or lower-priority admin follow-up.
- [ ] All `unserialize()` → `['allowed_classes' => false]`.
- [ ] No `extract()` on superglobals.
- [ ] Templates: `|escape` on quote body, author name, category title. If quote body allows HTML, use `getVar('quote', 'n')` and skip `|escape`.

## 5. XOOPS conventions

- [ ] **Rename language constants**: `MI_QUOTES_*` → `_MI_QUOTES_*` (add missing underscore).
- [ ] Admin pages: `xoops_cp_header()`, `xoops_cp_footer()`, `$xoBreadCrumb`, `<{include file="db:system_header.tpl"}>`, `<{xoAdminIcons}>`.
- [ ] Preload registration — `preloads/core.php` exists; audit coverage.

## 6. Smarty templates

- [ ] 22 templates — systematic `|escape` audit.
- [ ] Delimiter scan clean.

## 7. Tests & quality gates

- [ ] Add `composer.json` with PHP ^8.2.
- [ ] PHPStan baseline exists — ratchet up.
- [ ] `tests/Unit/` already covers AuthorHandler, AuthorTest, CategoryHandler, CategoryTest, QuoteHandler, QuoteTest, HelperTest, preloads/core — good coverage for the module size. Extend to Form classes.
- [ ] PHPUnit 11 attribute syntax — verify existing tests use `#[Test]` / `#[CoversClass]`.

## 8. Module structure & modernisation

- [x] Remove `admin/00/` directory and `testdata/index0.php`.
- [ ] Namespace consistently under `XoopsModules\Quotes\*`.
- [ ] Adopt `Xmf\Module\Helper` throughout.
- [ ] `class/Form/AuthorForm.php`, `CategoryForm.php`, `QuoteForm.php` — good separation; ensure admin scripts instantiate them rather than building forms inline.
- [ ] Quote vs Quotes module overlap — document the intended split (or merge them).

## 9. Module-specific follow-ups

- [ ] Avatar upload for authors (if present): enforce MIME + size + `basename()`.
- [ ] Search endpoint (`include/search.inc.php`) — Criteria, not raw LIKE concat.
- [ ] Block caching: verify quote-of-the-day block does NOT cache per-user (it would leak).

## 10. Documentation

- [ ] README.md: clarify relationship to the sibling `quote` module.
- [ ] `docs/lang_diff.txt` — add when constant rename happens.
