# Changelog

All notable changes to `quotes` will be documented in this file.

## 1.2.0 Beta 1 [2026-06-18]

Requires mtools 1.2.0+. Adopts the mtools conversion-framework APIs, enables permission-gated
front-end editing, and brings the module's language constants in line with the XOOPS convention.

### Added
- Front-end "Add Author" and "Add Quote" sub-menu items. Add Quote lets the user pick an existing
  author or add a full new author inline (created with the submitter as owner).
- Front-end editing for authors, categories, and quotes — permission-gated and CSRF-protected —
  via a shared `saveFromRequest()` method on each handler (no copy-paste of the admin save block).
- Permission model for front-end submit/edit using XMF: authors and categories use the global
  "submit from user side" right (`quotes_ac`/8); quotes use the **per-category** `quotes_submit`
  right. Each list/view item carries a `can_edit` flag for the templates.
- Adopted the mtools 1.2.0 adoption APIs: `Configurator::forModule()`, `Module\Installer` in the
  install/update hooks, and `Module\ModuleContext::defineConstants()` (collapsing the `{UP}_*`
  constant block in `include/common.php`).
- "Can edit own posts" permission (global `quotes_ac` item 32) plus a `uid` owner column on
  quotes and authors, enabling owner-based front-end editing.

### Changed
- Language constants renamed to the XOOPS leading-underscore convention:
  `MI_`/`AM_`/`MD_`/`MB_QUOTES_*` → `_MI_`/`_AM_`/`_MD_`/`_MB_QUOTES_*` (574 occurrences, 43 files).
- Admin save paths (author/category/quote) refactored to call the shared `saveFromRequest()`
  (behavior-preserving).
- Test bootstrap now loads mtools' public `bootstrap.php` instead of reaching into
  `preloads/autoloader.php`.
- Fully-qualified the `Common\DirectoryChecker` import in `admin/index.php`.
- Runtime dependency shim now requires mtools **1.2.0** (matches `min_modules`).
- Front-end editing is now ownership-gated: a registered user can edit only their own quotes/authors
  (and only with the "Can edit own posts" right); admins edit everything. Categories are admin-only.
  Non-admins editing their own row cannot recategorise, (self-)publish, or backdate it.

### Fixed
- Front-end "Edit doesn't save" for all three entities: the front-end pages read `op` from GET
  only and had no `save` case, so the POSTed `op=save` was invisible and edits silently fell back
  to the list. They now read `op` from REQUEST and handle both `edit` and `save`.
- Clone action (admin) is now POST + CSRF token + confirmation (was a state change over GET with
  no token), matching delete.
- Fresh install fatal ("Missing config file: /modules/config/config.php"): the install/update hooks
  built the `Configurator` from the module Helper, which cannot resolve its path during install (the
  module is not registered yet). They now use `new Configurator(\dirname(__DIR__))`.
- Registered users with the submit right could edit quotes/authors they did not create.

### Removed
- Dead `include/config.php` (`Configurator` reads `config/config.php`).

## 1.1.0 Beta 1 [2026-04-30]

### Added
- Documented Quotes as the reference consumer for the mTools shared-helper architecture.
- added README requirements for XOOPS 2.7, PHP 8.2, and mtools 1.1.0+
- added runtime mTools dependency checks with clear install/update/admin failures
- streamlined test data buttons with mTools' TestdataButtons class (mamba)
- added usage of TestdataSample class from mTools (mamba)
- added usage of Blocksadmin class from mTools (mamba)

### Fixed
- Improved quote, category, author, and block presentation while keeping templates and CSS local to the Quotes module.
- Added runtime dependency checks so missing or incompatible mTools installations fail with clear messages instead of class-loading fatals.

## 1.0.0 Beta 1 [2020/09/05]
- Beta 1 release (mamba)
