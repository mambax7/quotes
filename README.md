![alt XOOPS CMS](https://xoops.org/images/logoXoopsPhp81.png)
## quotes module for [XOOPS CMS 2.5.9+](https://xoops.org)
[![XOOPS CMS Module](https://img.shields.io/badge/XOOPS%20CMS-Module-blue.svg)](https://xoops.org)
[![Software License](https://img.shields.io/badge/license-GPL-brightgreen.svg?style=flat)](https://www.gnu.org/licenses/gpl-2.0.html)
 
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/mambax7/quotes.svg?style=flat)](https://scrutinizer-ci.com/g/mambax7/quotes/?branch=master)
[![Codacy Badge](https://api.codacy.com/project/badge/grade/2d27c0023ee54f0b9ba2b5d17a68b2a5)](https://www.codacy.com/app/mambax7/quotes)
[![Code Climate](https://img.shields.io/codeclimate/github/mambax7/quotes.svg?style=flat)](https://codeclimate.com/github/mambax7/quotes)
[![Latest Pre-Release](https://img.shields.io/github/tag/XoopsModules25x/quotes.svg?style=flat)](https://github.com/XoopsModules25x/quotes/tags/)
[![Latest Version](https://img.shields.io/github/release/XoopsModules25x/quotes.svg?style=flat)](https://github.com/XoopsModules25x/quotes/releases/)

**quotes** module for [XOOPS CMS](https://xoops.org) adds a block that show a random quote. The quotes are added/edited/deleted in the Admin section.

## Requirements

- XOOPS 2.7.0+
- PHP 8.2+
- mtools 1.1.0+ installed and active

Quotes is the reference consumer for the mTools shared-helper architecture. It
declares `min_modules => ['mtools' => '1.1.0']`, loads the public mTools
bootstrap, and keeps its own quote/category/author templates and handlers local
to the Quotes module.

Recent work has focused on making Quotes a practical example for other module
authors: dependency checks, shared mTools bootstrap usage, polished public
templates, improved blocks, category quote cards, author images, and
theme-aware styling are all kept visible in this module for reference.

See [CHANGELOG.md](CHANGELOG.md) and [docs/changelog.txt](docs/changelog.txt)
for current unreleased changes.

[![Tutorial Available](https://xoops.org/images/tutorial-available-blue.svg)](https://xoops.gitbook.io/quotes-tutorial/) Tutorial: see [GitBook](https://xoops.gitbook.io/quotes-tutorial/).
To contribute to the Tutorial, [fork it on GitHub](https://github.com/XoopsDocs/quotes-tutorial)

[![Translations on Transifex](https://xoops.org/images/translations-transifex-blue.svg)](https://www.transifex.com/xoops) 

Please visit us on  [https://xoops.org](https://xoops.org)

Current and upcoming "next generation" versions of XOOPS CMS are crafted on GitHub at: https://github.com/XOOPS
