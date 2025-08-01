# Laravel → i18next Lang Parser

This package parses your <a href="https://laravel.com/docs/12.x/localization" target="_blank" rel="noopener noreferrer">Laravel translation</a> files into <a href="https://www.i18next.com/" target="_blank" rel="noopener noreferrer">i18next</a>-compatible JSON, converting plural forms and placeholders into a format ready for dynamic translation usage in the frontend.

---

## 🎬 Features
```
- Reads every `lang/{locale}/*.php` file
- Parses Laravel’s `trans_choice` plural syntax (`{0}|{1}|[2,*]`)
- Converts `:placeholder`, `:Placeholder`, `:PLACEHOLDER` into i18next interpolations:
    - `:foo` → `{{foo}}`
    - `:Foo` → `{{foo, capitalize}}`
    - `:FOO` → `{{foo, uppercase}}`
- Writes to `public/locales/{locale}/*.json`
- Generates a `public/locales/versions.json` file with:
    - A unique hash for each locale’s translation files
    - A `last_updated` timestamp
    - Useful for cache invalidation and detecting translation updates
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

This will generate: \
• Translation files under: /public/locales/{locale}/*.json \
• A version tracking file under: /public/locales/versions.json

### Example versions.json file
```json
{
    "en": {
        "hash": "a1b2c3d4e5f6g7h8i9j0",
        "last_updated": "2023-10-01T12:00:00Z"
    },
    "es": {
        "hash": "0j9i8h7g6f5e4d3c2b1a",
        "last_updated": "2023-10-01T12:00:00Z"
    }
}
```

### Example Laravel Translations:
// resources/lang/en/messages.php
```php
return [
    'success' => [
        'created' => '{0} No :resources created.|{1} :Resource created successfully.|[2,*] :Resources created successfully.'
    ],
];
```
// resources/lang/en/models.php
```php
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
// resources/locales/en/messages.json
```json
{
    "success": {
        "created_zero": "No {{resources, capitalize}} created.",
        "created_one": "{{resource, capitalize}} created successfully.",
        "created_other": "{{resources, capitalize}} created successfully."
    }
}
```
// resources/lang/en/models.json
```json
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
/** 
 * We pass in the count and resource names to handle pluralization
 * We pass the singular and plural forms of the resource
 * to handle dynamic translations, i18next will automatically 
 * choose the correct form based on the count.
 */

// 0 items
let count = 0;
i18next.t('success.created', {
    count: count,
    resource: i18next.t('models.user_one'),
    resources: i18next.t('models.user_other')
});
// → "No users created."


// 1 item
count = 1
i18next.t('success.created', {
    count: count,
    resource: i18next.t('models.user_one'),
    resources: i18next.t('models.user_other')
});
// → "User created successfully."

// Multiple items
count = 5;
i18next.t('success.created', {
    count: count,
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
  • Adds versions.json for change detection and frontend cache management.
</pre>

---

## 📖 Changelog
<pre>
See <a href="https://github.com/LorenzoWynberg/laravel-to-i18next-lang-parser/blob/main/CHANGELOG.md" target="_blank" rel="noopener noreferrer">CHANGELOG.md</a> for release notes and breaking changes.
</pre>

## 🤝 Contributing
<pre>
Contributions, issues, and feature requests are welcome!

🔗 <a href="https://github.com/LorenzoWynberg/laravel-to-i18next-lang-parser/issues" target="_blank" rel="noopener noreferrer">Report Issues</a>
🔗 <a href="https://github.com/LorenzoWynberg/laravel-to-i18next-lang-parser/pulls" target="_blank" rel="noopener noreferrer">Submit Pull Requests</a>
</pre>

## 🔑 License
<pre>
🔑 <a href="https://raw.githubusercontent.com/LorenzoWynberg/laravel-to-i18next-lang-parser/main/LICENSE.md" target="_blank" rel="noopener noreferrer">MIT License</a> © Lorenzo Wynberg / Ozner Omali
</pre>

## 🎵 Like my code? You'll love my music!

<ul>
  <li><a href="https://music.apple.com/us/album/the-kitty-cat-crew/1796753922" target="_blank" rel="noopener noreferrer">Apple Music</a></li>
  <li><a href="https://open.spotify.com/album/0uTRS5Z5Qebgi7BavwGlpm" target="_blank" rel="noopener noreferrer">Spotify</a></li>
</ul>

