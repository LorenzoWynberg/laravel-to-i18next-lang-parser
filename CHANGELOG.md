# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [2.0.0] - 2025-08-01
### Changed
- **Breaking:** Renamed Artisan command from `lang:parse-to-i18Next` to `lang:to-i18next` for improved consistency and readability.

### Migration Notes
Replace any usage of:
```bash
  php artisan lang:parse-to-i18Next
```
with:
```bash
  php artisan lang:to-i18next
```

## [1.1.0] - 2025-08-01
### Added
- **Version tracking system:**
    - Generates a `public/locales/versions.json` file containing a hash and last updated timestamp for each locale’s translation files.
    - Allows frontend applications to detect changes and handle cache invalidation automatically.
- Updated documentation to include `versions.json` feature.

## [1.0.0] - 2025-07-31
### Added
- Initial release of the package:
    - Parses Laravel translation files into i18next-compatible JSON.
    - Supports pluralization (`{0}|{1}|[2,*]`) and placeholder conversion (`:key` → `{{key}}`).
    - Outputs translation files to `public/locales/{locale}/{key}.json`.
    - Provides Artisan command `lang:parse-to-i18Next {locale?}` for exporting translations.
