# Codex Tasks

Audit snapshot: low risk in this quick pass; files scanned: 102; raw superglobals: 17; unsafe unserialize: 0; eval: 0; create_function: 0; each: 0.

1. [ ] No single critical blocker surfaced in the quick scan; work through the modernization and verification tasks below in order.
2. [ ] Replace raw `$_GET`/`$_POST`/`$_REQUEST`/`$_FILES` access with `Xmf\Request`, pin the source hash (`GET` vs `POST`), and ensure every state-changing path validates the XOOPS security token before any work is done.
3. [ ] Reduce dynamic `include`/`require` usage by introducing explicit bootstrap paths, helper loaders, or service registration so file loading is auditable and easier to test.
4. [ ] Review templates and controller output for Smarty 4 and XSS safety: keep XOOPS `<{ }>` delimiters, add `|escape` for user-controlled output, and remove inline PHP/JS execution patterns where they still exist.
5. [ ] Split oversized page controllers into request validation, service, repository/handler, and rendering steps so the module is easier to modernize without breaking behavior.
6. [ ] Bring the codebase to a clean PHP 8.2-8.5 baseline: typed properties/returns, no dynamic properties, no removed legacy APIs, and explicit null/false handling around IO, database, and form values.
7. [ ] Add or tighten automated verification for this module: PHPStan, PHPCS/PSR-12, PHPUnit smoke tests, install/update regression checks, and at least one template/render smoke test on Smarty 4.