# Changelog

## 9.1 — 2026-11-07

- Enforces some verification before registering module

## 9.0 — 2026-08-03

- Avoid using magic methods for user preferences and blog settings (2.39+)
- Use dotclear.ToolBar rather than old jsToolBar, DC 2.39+

## 8.1 — 2026-02-23

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 8.0 — 2026-02-13

- No more need of shortkey (2.37)

## 7.5 — 2025-12-12

- Add key attribute for toolbar button in order to ignore keyboard layout (2.37+) Keep shortkey in order to keep 2.36 compliance

## 7.4 — 2025-11-16

- Add missing breadcrumb in syntax selector popup

## 7.3 — 2025-09-22

- Use backend services rather than static calls

## 7.2 — 2025-09-15

- Use legacyEditor groups management

## 7.1 — 2025-09-15

- Remove spacer separator in toolbar

## 7.0.1 — 2025-09-09

- Fix context checking for popup

## 7.0 — 2025-09-07

- DC 2.36 compliance

## 6.0 — 2025-05-19

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 5.5 — 2025-03-05

- Plugins adding buttons on legacyEditor/CKEditor should have at least 1010 priority 1005 is reserved for additional syntaxes to legacyEditor (as legacyMarkdown)

## 5.4 — 2025-02-09

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 5.3.1 — 2024-11-11

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 5.3 — 2024-08-21

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 5.2.1 — 2024-03-15

- Fix enter key for submit

## 5.2 — 2023-10-27

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 5.1 — 2023-10-24

- Use instanced item constants rather than interface ones

## 5.0 — 2023-10-23

- Use &amp; when giving urls to JS
- 2.28 compliance

## 4.0 — 2023-08-26

- Dotclear 2.27 compliance, PHP 8.1+

## 3.3.1 — 2023-06-27

- Add local static $init variable

## 3.3 — 2023-06-20

- Use dcCore::app()-&gt;adminurl-&gt;redirect() rather than Http::redirect()

## 3.2 — 2023-06-19

- Use admin URLs

## 3.1 — 2023-06-18

- Popup layout reviewed

## 3.0.6 — 2023-06-18

- Fix popup actions

## 3.0.5 — 2023-06-12

- Don't do things in frontend if plugin disabled

## 3.0.4 — 2023-06-06

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 3.0.3 — 2023-06-06

- Wrong field label

## 3.0.2 — 2023-06-06

- And forgot this one too

## 3.0.1 — 2023-06-06

- Version de maintenance, sans changement fonctionnel notable relevé dans l’historique.

## 3.0 — 2023-06-06

- Switch to namespace
- Prepare 2.26
- Minified versions

## 2.1 — 2022-12-18

- 2.24 compliance

## 2.0 — 2022-11-30

- Dotclear 2.24 compliance

## 1.12.1 — 2022-08-07

- Usual oups :-)

## 1.12 — 2022-08-07

- Update default branch in _define.php for alternative repository
- Add alternative repository

## 1.11 — 2021-08-07

- Dotclear 2.19 compliance

## 1.10 — 2020-09-10

- Use dotclear methods rather than obsolete functions

## 1.9 — 2020-04-06

- No more inline JS

## 1.8 — 2020-03-15

- Fix js minor issue (fn.arguments is deprecated)
- jQuery 3+ compliance
- ES6 is coming
- short notation for array (array() → [])
- Factor post release URL
- minor updates in mkdocs
- Dotclear minimum version info
- Add links to versions release posts on https://open-time.net/
- Autres correctifs et améliorations.

## 1.7 — 2017-03-04

- Add SyntaxeHL macro syntax (partial) support and a new options to hide line numbers column

## 1.6.3 — 2016-10-04

- Add some CSS/Sass units and flexbox set

## 1.6.2 — 2016-04-06

- Add Material theme, remove toolbar from display.

## 1.6.1 — 2016-03-25

- 3 new themes, remove some unecessary css files

## 1.6 — 2016-03-25

- Using dcUtils::cssLoad, dcUtils::jsLoad and $core-&gt;blog-&gt;getPF() is a better way to load plugin resources (public context)
- Using dcPage::cssLoad, dcPage::jsLoad and dcPage::getPF is a better way to load plugin resources

## 1.5 — 2015-10-08

- Updates SyntxaHighlight script from 3.0.83 to 3.0.9

## 1.4 — 2015-06-30

- Add syntax parameter for adminPostEditor behaviour for Dotclear 2.8
- Remove !important; from css files
- Split behaviors registration, will be compatible with Dotclear 2.8 min, next release will be 1.4

## 1.3 — 2015-01-13

- Set lower priority than dcLegacyEditor in order to register macro function
- Cope with the new behaviour adminPostEditor, next release will be 1.3

## 1.2 — 2013-10-15

- Now using shAutoloader.js in order to reduce js loads
- Various
- Update highlighter to version 3.0.83 and add theme rendering option
- Organize files
- New icons
- new _define.php
- New notices system
- Cope with new breadcrumb
- Autres correctifs et améliorations.
