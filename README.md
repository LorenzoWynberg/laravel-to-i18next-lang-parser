# Laravel → i18next Lang Parser

Transform your Laravel PHP language files into JSON files ready for [i18next](https://www.i18next.com/) consumption.

---

## 🎬 Features

- Reads every `lang/{locale}/*.php` file
- Parses Laravel’s `trans_choice` plural syntax (`{0}|{1}|[2,*]`)
- Converts `:placeholder`, `:Placeholder`, `:PLACEHOLDER` into i18next interpolations:
    - `:foo` → `{{foo}}`
    - `:Foo` → `{{foo, capitalize}}`
    - `:FOO` → `{{foo, uppercase}}`
- Writes to `public/locales/{locale}/{group}.json`
- Artisan command: `lang:parse-to-i18Next {locale?}`

---

## 📦 Installation

```bash
composer require ozner-omali/laravel-to-i18next-lang-parser
```
---

## 🔧 Usage
```
1. Export all locales
    php artisan lang:parse-to-i18Next 
2. Export a specific locale
    php artisan lang:parse-to-i18Next es
```
---

## ⚙️ Front-end Integration
```javascript 
import i18next from 'i18next';
import HttpBackend from 'i18next-http-backend';

i18next
  .use(HttpBackend)
  .init({
    fallbackLng: 'en',
    ns: ['auth', 'validation', 'resource'],
    defaultNS: 'validation',
    backend: {
      loadPath: '{backendPath}/locales/{{lng}}/{{ns}}.json',
    },
    interpolation: {
      escapeValue: false,
    },
  });
```
Then in your code, you can use the translations like this:
```javascript 
//“The user field is required.”
i18next.t('validation.required', {
  attribute: i18next.t('models.user.one')
});
```
---

## 📖 Changelog
```
See CHANGELOG.md for release notes and breaking changes.
```

---

## 🤝 Contributing
```
Contributions, issues and feature requests are welcome.
Feel free to check issues page.
```

## 🔑 License
```
The MIT License (MIT). See LICENSE for details.
```
