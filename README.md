# Countries

ISO 3166-1 country data: codes, names, emoji flags, EU membership, and sanctioned or elevated-risk territories. Zero dependencies.

## Why

Every commerce application needs a country dropdown, a "is this the EU" check for VAT, and — sooner than most people expect — a sanctions check before taking money. That is usually three separate half-lists scattered across the codebase, each drifting out of date on its own schedule.

All 250 ISO 3166-1 entries live in one class constant, so lookups are array reads with no file I/O and no parsing.

## Features

- 🌍 **All 250 territories** — the full ISO 3166-1 alpha-2 list, not the 190-odd everyone remembers.
- 🇪🇺 **EU membership** — the 27, post-Brexit, for VAT and reverse-charge decisions.
- 🚫 **Sanctions and risk flags** — comprehensively-sanctioned territories, and FATF elevated-risk jurisdictions.
- 🏳️ **Emoji flags** — derived from the code via regional indicators, so no image assets.
- 🔎 **Search and reverse lookup** — name to code, and substring search for a picker.
- 🧼 **Input sanitising** — normalises casing and rejects anything that isn't a real code.

## Requirements

PHP 8.5+

## Installation

```bash
composer require sugarcommerce/countries
```

## Usage

```php
use SugarCommerce\Countries\Country;

Country::name( 'DE' );          // 'Germany'
Country::code( 'Germany' );     // 'DE'
Country::flag( 'DE' );          // 🇩🇪
Country::exists( 'ZZ' );        // false
Country::sanitize( ' de ' );    // 'DE', or null if not a country
```

### Building a picker

```php
foreach ( Country::all() as $code => $name ) {
    echo '<option value="' . $code . '">' . Country::flag( $code ) . ' ' . $name . '</option>';
}

Country::search( 'ital' );      // [ 'IT' => 'Italy' ]
Country::search( 'united', 3 ); // capped
```

### VAT and the EU

```php
if ( Country::is_eu( $customer_country ) ) {
    // Reverse charge applies when the customer has a VAT number and
    // isn't in your own country.
}

Country::eu();                  // the 27, as code => name
```

### Risk

```php
Country::is_sanctioned( 'KP' );   // comprehensively sanctioned
Country::is_high_risk( 'MM' );    // FATF elevated monitoring
```

`is_sanctioned()` covers the territories under comprehensive embargo. It is a coarse first gate for "should this checkout proceed at all", not a compliance product — it does not screen names, and it does not know about sectoral or entity-level restrictions. Where the money moves through Stripe, their own screening still applies on top.

`is_high_risk()` is the FATF grey and black lists — a signal for elevated fraud scrutiny, not a reason to refuse.

Both are point-in-time lists that change by political decision. Pin the version you have reviewed.

## Testing

```bash
composer install
composer test
```

26 tests, 321 assertions — including that every code maps to a name and back, every flag renders as two regional indicators, and the EU list holds exactly 27 members.

## License

GPL-2.0-or-later
