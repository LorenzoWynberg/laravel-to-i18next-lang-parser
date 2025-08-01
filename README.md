# Laravel → i18next Lang Parser

This package parses your [Laravel translation](https://laravel.com/docs/12.x/localization) files into [i18next](https://www.i18next.com/)-compatible JSON, converting plural forms and placeholders into a format ready for dynamic translation usage in the frontend.

---

## 🎬 Features
```
- Reads every `lang/{locale}/*.php` file
- Parses Laravel’s `trans_choice` plural syntax (`{0}|{1}|[2,*]`)
- Converts `:placeholder`, `:Placeholder`, `:PLACEHOLDER` into i18next interpolations:
    - `:foo` → `{{foo}}`
    - `:Foo` → `{{foo, capitalize}}`
    - `:FOO` → `{{foo, uppercase}}`
- Writes to `public/locales/{locale}/{key}.json`
- Artisan command: `lang:parse-to-i18Next {locale?}`
```

---

## 📦 Installation

```
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

This will generate JSON files under:
<br>
/public/locales/{locale}/{key}.json

### Example Laravel Translations:
```php
// resources/lang/en/messages.php
return [
    'success' => [
        'created' => '{0} No :resources created.|{1} :Resource created successfully.|[2,*] :Resources created successfully.'
    ],
];

// resources/lang/en/models.php
return [
    'catalog' => 'catalog|catalogs',
    'element' => 'catalog element|catalog elements',
    'business' => 'business|businesses',
    'driver' => 'driver|drivers',
    'user' => 'user|users',
    'address' => 'address|addresses',
    'location' => 'location|locations',
    'currency' => 'currency|currencies',
    'order' => 'order|orders',
];
```
### Generated i18next JSON:
```php
// resources/locales/en/messages.json
{
    "success": {
        "created_zero": "No {{resources, capitalize}} created.",
        "created_one": "{{resource, capitalize}} created successfully.",
        "created_other": "{{resources, capitalize}} created successfully."
    }
}

// resources/lang/en/models.json
{
    "catalog_one": "catalog",
    "catalog_other": "catalogs",
    "element_one": "catalog element",
    "element_other": "catalog elements",
    "business_one": "business",
    "business_other": "businesses",
    "driver_one": "driver",
    "driver_other": "drivers",
    "user_one": "user",
    "user_other": "users",
    "address_one": "address",
    "address_other": "addresses",
    "location_one": "location",
    "location_other": "locations",
    "currency_one": "currency",
    "currency_other": "currencies",
    "order_one": "order",
    "order_other": "orders"
}
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
        ns: ['messages', 'models'],
        defaultNS: 'messages',
        backend: {
            loadPath: '/locales/{{lng}}/{{ns}}.json',
        },
        interpolation: {
            escapeValue: false,
        },
    });
```
Then in your code, you can use the translations like this:
```javascript 
// 0 items
i18next.t('success.created', {
    count: 0,
    resources: i18next.t('models.user_other')
});
// → "No users created."

// 1 item
i18next.t('success.created', {
    count: 1,
    resource: i18next.t('models.user_one'),
    resources: i18next.t('models.user_other')
});
// → "User created successfully."

// Multiple items
i18next.t('success.created', {
    count: 5,
    resource: i18next.t('models.user_one'),
    resources: i18next.t('models.user_other')
});
// → "Users created successfully."
```
---

## ✅ Notes
<pre>
The parser:
  • Converts Laravel’s pipe plural syntax ('user|users') into _one and _other keys.
  • Supports Laravel’s pluralization brackets ({0}, {1}, [2,*]) and converts them to *_zero, *_one, *_other.
  • Placeholders are automatically transformed:
     • :key → {{key}}
     • :Key → {{key, capitalize}}
     • :KEY → {{key, uppercase}}
</pre>

---

## 📖 Changelog
<pre>
See <a href="https://github.com/LorenzoWynberg/laravel-to-i18next-lang-parser/blob/main/CHANGELOG.md" target="_blank">CHANGELOG.md</a> for release notes and breaking changes.
</pre>

## 🤝 Contributing
<pre>
Contributions, issues, and feature requests are welcome!

🔗 <a href="https://github.com/LorenzoWynberg/laravel-to-i18next-lang-parser/issues" target="_blank">Report Issues</a>
🔗 <a href="https://github.com/LorenzoWynberg/laravel-to-i18next-lang-parser/pulls" target="_blank">Submit Pull Requests</a>
</pre>

## 🔑 License
<pre>
🔑 <a href="https://raw.githubusercontent.com/LorenzoWynberg/laravel-to-i18next-lang-parser/main/LICENSE.md" target="_blank">MIT License</a> © Lorenzo Wynberg / Ozner Omali
</pre>

