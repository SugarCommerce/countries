<?php
/**
 * ISO 3166-1 country data.
 *
 * @package   SugarCommerce\Countries
 * @copyright Copyright (c) 2026, ArrayPress Limited
 * @license   GPL-2.0-or-later
 * @since     1.0.0
 */

declare( strict_types=1 );

namespace SugarCommerce\Countries;

/**
 * Class Country
 *
 * Country codes, names, flags, and the group memberships that commerce
 * actually asks about — EU (for VAT), sanctioned, and elevated-risk.
 *
 * Returns raw values. Escaping is the caller's job, because this data
 * reaches HTML, JSON, CSV and PDF, and a library that pre-escapes for
 * one of those corrupts it for the other three.
 *
 * @since 1.0.0
 */
final readonly class Country {

	/**
	 * ISO 3166-1 alpha-2 code => English short name.
	 */
	private const array COUNTRIES = array(
		'AF' => 'Afghanistan', 'AX' => 'Åland Islands', 'AL' => 'Albania',
		'DZ' => 'Algeria', 'AS' => 'American Samoa', 'AD' => 'Andorra',
		'AO' => 'Angola', 'AI' => 'Anguilla', 'AQ' => 'Antarctica',
		'AG' => 'Antigua and Barbuda', 'AR' => 'Argentina', 'AM' => 'Armenia',
		'AW' => 'Aruba', 'AU' => 'Australia', 'AT' => 'Austria',
		'AZ' => 'Azerbaijan', 'BS' => 'Bahamas', 'BH' => 'Bahrain',
		'BD' => 'Bangladesh', 'BB' => 'Barbados', 'BY' => 'Belarus',
		'BE' => 'Belgium', 'PW' => 'Belau', 'BZ' => 'Belize',
		'BJ' => 'Benin', 'BM' => 'Bermuda', 'BT' => 'Bhutan',
		'BO' => 'Bolivia', 'BQ' => 'Bonaire, Saint Eustatius and Saba', 'BA' => 'Bosnia and Herzegovina',
		'BW' => 'Botswana', 'BV' => 'Bouvet Island', 'BR' => 'Brazil',
		'IO' => 'British Indian Ocean Territory', 'BN' => 'Brunei', 'BG' => 'Bulgaria',
		'BF' => 'Burkina Faso', 'BI' => 'Burundi', 'KH' => 'Cambodia',
		'CM' => 'Cameroon', 'CA' => 'Canada', 'CV' => 'Cape Verde',
		'KY' => 'Cayman Islands', 'CF' => 'Central African Republic', 'TD' => 'Chad',
		'CL' => 'Chile', 'CN' => 'China', 'CX' => 'Christmas Island',
		'CC' => 'Cocos (Keeling) Islands', 'CO' => 'Colombia', 'KM' => 'Comoros',
		'CG' => 'Congo (Brazzaville)', 'CD' => 'Congo (Kinshasa)', 'CK' => 'Cook Islands',
		'CR' => 'Costa Rica', 'HR' => 'Croatia', 'CU' => 'Cuba',
		'CW' => 'Curaçao', 'CY' => 'Cyprus', 'CZ' => 'Czech Republic',
		'DK' => 'Denmark', 'DJ' => 'Djibouti', 'DM' => 'Dominica',
		'DO' => 'Dominican Republic', 'EC' => 'Ecuador', 'EG' => 'Egypt',
		'SV' => 'El Salvador', 'GQ' => 'Equatorial Guinea', 'ER' => 'Eritrea',
		'EE' => 'Estonia', 'SZ' => 'Eswatini', 'ET' => 'Ethiopia',
		'FK' => 'Falkland Islands', 'FO' => 'Faroe Islands', 'FJ' => 'Fiji',
		'FI' => 'Finland', 'FR' => 'France', 'GF' => 'French Guiana',
		'PF' => 'French Polynesia', 'TF' => 'French Southern Territories', 'GA' => 'Gabon',
		'GM' => 'Gambia', 'GE' => 'Georgia', 'DE' => 'Germany',
		'GH' => 'Ghana', 'GI' => 'Gibraltar', 'GR' => 'Greece',
		'GL' => 'Greenland', 'GD' => 'Grenada', 'GP' => 'Guadeloupe',
		'GU' => 'Guam', 'GT' => 'Guatemala', 'GG' => 'Guernsey',
		'GN' => 'Guinea', 'GW' => 'Guinea-Bissau', 'GY' => 'Guyana',
		'HT' => 'Haiti', 'HM' => 'Heard Island and McDonald Islands', 'HN' => 'Honduras',
		'HK' => 'Hong Kong', 'HU' => 'Hungary', 'IS' => 'Iceland',
		'IN' => 'India', 'ID' => 'Indonesia', 'IR' => 'Iran',
		'IQ' => 'Iraq', 'IE' => 'Ireland', 'IM' => 'Isle of Man',
		'IL' => 'Israel', 'IT' => 'Italy', 'CI' => 'Ivory Coast',
		'JM' => 'Jamaica', 'JP' => 'Japan', 'JE' => 'Jersey',
		'JO' => 'Jordan', 'KZ' => 'Kazakhstan', 'KE' => 'Kenya',
		'KI' => 'Kiribati', 'XK' => 'Kosovo', 'KW' => 'Kuwait',
		'KG' => 'Kyrgyzstan', 'LA' => 'Laos', 'LV' => 'Latvia',
		'LB' => 'Lebanon', 'LS' => 'Lesotho', 'LR' => 'Liberia',
		'LY' => 'Libya', 'LI' => 'Liechtenstein', 'LT' => 'Lithuania',
		'LU' => 'Luxembourg', 'MO' => 'Macao', 'MG' => 'Madagascar',
		'MW' => 'Malawi', 'MY' => 'Malaysia', 'MV' => 'Maldives',
		'ML' => 'Mali', 'MT' => 'Malta', 'MH' => 'Marshall Islands',
		'MQ' => 'Martinique', 'MR' => 'Mauritania', 'MU' => 'Mauritius',
		'YT' => 'Mayotte', 'MX' => 'Mexico', 'FM' => 'Micronesia',
		'MD' => 'Moldova', 'MC' => 'Monaco', 'MN' => 'Mongolia',
		'ME' => 'Montenegro', 'MS' => 'Montserrat', 'MA' => 'Morocco',
		'MZ' => 'Mozambique', 'MM' => 'Myanmar', 'NA' => 'Namibia',
		'NR' => 'Nauru', 'NP' => 'Nepal', 'NL' => 'Netherlands',
		'NC' => 'New Caledonia', 'NZ' => 'New Zealand', 'NI' => 'Nicaragua',
		'NE' => 'Niger', 'NG' => 'Nigeria', 'NU' => 'Niue',
		'NF' => 'Norfolk Island', 'MK' => 'North Macedonia', 'MP' => 'Northern Mariana Islands',
		'KP' => 'North Korea', 'NO' => 'Norway', 'OM' => 'Oman',
		'PK' => 'Pakistan', 'PS' => 'Palestinian Territory', 'PA' => 'Panama',
		'PG' => 'Papua New Guinea', 'PY' => 'Paraguay', 'PE' => 'Peru',
		'PH' => 'Philippines', 'PN' => 'Pitcairn', 'PL' => 'Poland',
		'PT' => 'Portugal', 'PR' => 'Puerto Rico', 'QA' => 'Qatar',
		'RE' => 'Reunion', 'RO' => 'Romania', 'RU' => 'Russia',
		'RW' => 'Rwanda', 'BL' => 'Saint Barthélemy', 'SH' => 'Saint Helena',
		'KN' => 'Saint Kitts and Nevis', 'LC' => 'Saint Lucia', 'MF' => 'Saint Martin (French part)',
		'SX' => 'Saint Martin (Dutch part)', 'PM' => 'Saint Pierre and Miquelon', 'VC' => 'Saint Vincent and the Grenadines',
		'WS' => 'Samoa', 'SM' => 'San Marino', 'ST' => 'São Tomé and Príncipe',
		'SA' => 'Saudi Arabia', 'SN' => 'Senegal', 'RS' => 'Serbia',
		'SC' => 'Seychelles', 'SL' => 'Sierra Leone', 'SG' => 'Singapore',
		'SK' => 'Slovakia', 'SI' => 'Slovenia', 'SB' => 'Solomon Islands',
		'SO' => 'Somalia', 'ZA' => 'South Africa', 'GS' => 'South Georgia/Sandwich Islands',
		'KR' => 'South Korea', 'SS' => 'South Sudan', 'ES' => 'Spain',
		'LK' => 'Sri Lanka', 'SD' => 'Sudan', 'SR' => 'Suriname',
		'SJ' => 'Svalbard and Jan Mayen', 'SE' => 'Sweden', 'CH' => 'Switzerland',
		'SY' => 'Syria', 'TW' => 'Taiwan', 'TJ' => 'Tajikistan',
		'TZ' => 'Tanzania', 'TH' => 'Thailand', 'TL' => 'Timor-Leste',
		'TG' => 'Togo', 'TK' => 'Tokelau', 'TO' => 'Tonga',
		'TT' => 'Trinidad and Tobago', 'TN' => 'Tunisia', 'TR' => 'Turkey',
		'TM' => 'Turkmenistan', 'TC' => 'Turks and Caicos Islands', 'TV' => 'Tuvalu',
		'UG' => 'Uganda', 'UA' => 'Ukraine', 'AE' => 'United Arab Emirates',
		'GB' => 'United Kingdom', 'US' => 'United States', 'UM' => 'United States Minor Outlying Islands',
		'UY' => 'Uruguay', 'UZ' => 'Uzbekistan', 'VU' => 'Vanuatu',
		'VA' => 'Vatican', 'VE' => 'Venezuela', 'VN' => 'Vietnam',
		'VG' => 'Virgin Islands (British)', 'VI' => 'Virgin Islands (US)', 'WF' => 'Wallis and Futuna',
		'EH' => 'Western Sahara', 'YE' => 'Yemen', 'ZM' => 'Zambia',
		'ZW' => 'Zimbabwe',
	);

	/**
	 * EU member states.
	 *
	 * The list that decides whether VAT rules apply, so it matters that
	 * GB is absent and the outermost regions are handled deliberately.
	 */
	private const array EU = array(
		'AT', 'BE', 'BG', 'HR', 'CY', 'CZ', 'DK', 'EE', 'FI', 'FR', 'DE', 'GR',
		'HU', 'IE', 'IT', 'LV', 'LT', 'LU', 'MT', 'NL', 'PL', 'PT', 'RO', 'SK',
		'SI', 'ES', 'SE',
	);

	/**
	 * Territories with elevated payment-fraud rates.
	 *
	 * A signal to weigh, never a reason to block on its own — plenty of
	 * legitimate customers live in every one of them.
	 */
	private const array HIGH_RISK = array(
		'BY', 'BD', 'BR', 'CN', 'CO', 'EG', 'GH', 'ID', 'IN', 'MX', 'MY', 'NG',
		'PH', 'PK', 'RO', 'RU', 'TH', 'UA', 'VE', 'VN',
	);

	/**
	 * Comprehensively sanctioned territories.
	 *
	 * Indicative only. Sanctions change without notice and vary by
	 * jurisdiction; if you are relying on this for compliance, verify it
	 * against your own legal advice rather than a constant in a library.
	 */
	private const array SANCTIONED = array(
		'CU', 'IR', 'KP', 'RU', 'SY', 'VE',
	);

	/**
	 * Colloquial and abbreviated names that people actually type.
	 *
	 * Nobody writes "United Kingdom of Great Britain and Northern
	 * Ireland" into a form. Keyed lowercase; the lookup lowercases the
	 * needle rather than the table.
	 */
	private const array ALIASES = array(
		'usa'                      => 'US',
		'u.s.a.'                   => 'US',
		'u.s.'                     => 'US',
		'us'                       => 'US',
		'america'                  => 'US',
		'united states of america' => 'US',
		'uk'                       => 'GB',
		'u.k.'                     => 'GB',
		'great britain'            => 'GB',
		'britain'                  => 'GB',
		'england'                  => 'GB',
		'scotland'                 => 'GB',
		'wales'                    => 'GB',
		'northern ireland'         => 'GB',
		'holland'                  => 'NL',
		'the netherlands'          => 'NL',
		'south korea'              => 'KR',
		'north korea'              => 'KP',
		'russia'                   => 'RU',
		'uae'                      => 'AE',
		'ivory coast'              => 'CI',
		'burma'                    => 'MM',
		'czechia'                  => 'CZ',
		'swaziland'                => 'SZ',
		'macedonia'                => 'MK',
		'turkey'                   => 'TR',
		'vatican'                  => 'VA',
		'palestine'                => 'PS',
	);

	/**
	 * ISO 3166-1 alpha-2 code => ISO 4217 currency.
	 *
	 * Only the countries with a currency of their own worth naming. The rest
	 * fall out of currency() as null, which a caller should read as "use your
	 * default" rather than as an error — a shop with no price in somebody's
	 * currency is not a broken shop.
	 *
	 * The euro area is deliberately absent: is_eu() already knows who is in
	 * it, and repeating twenty countries here is twenty chances to disagree
	 * with it. Bulgaria has paid in euro since 1 January 2026.
	 */
	private const array CURRENCIES = array(
		'AE' => 'AED', 'AR' => 'ARS', 'AU' => 'AUD', 'BD' => 'BDT',
		'BH' => 'BHD', 'BR' => 'BRL', 'CA' => 'CAD', 'CH' => 'CHF', 'CL' => 'CLP',
		'CN' => 'CNY', 'CO' => 'COP', 'CZ' => 'CZK', 'DK' => 'DKK', 'EG' => 'EGP',
		'GB' => 'GBP', 'GH' => 'GHS', 'HK' => 'HKD', 'HU' => 'HUF', 'ID' => 'IDR',
		'IL' => 'ILS', 'IN' => 'INR', 'IS' => 'ISK', 'JP' => 'JPY', 'KE' => 'KES',
		'KR' => 'KRW', 'KW' => 'KWD', 'MA' => 'MAD', 'MX' => 'MXN', 'MY' => 'MYR',
		'NG' => 'NGN', 'NO' => 'NOK', 'NZ' => 'NZD', 'PE' => 'PEN', 'PH' => 'PHP',
		'PK' => 'PKR', 'PL' => 'PLN', 'QA' => 'QAR', 'RO' => 'RON', 'RS' => 'RSD',
		'SA' => 'SAR', 'SE' => 'SEK', 'SG' => 'SGD', 'TH' => 'THB', 'TR' => 'TRY',
		'TW' => 'TWD', 'UA' => 'UAH', 'US' => 'USD', 'UY' => 'UYU', 'VN' => 'VND',
		'ZA' => 'ZAR',
	);

	/**
	 * The currency a country pays in.
	 *
	 * For deciding which of several prices to show somebody, not for
	 * accounting: a visitor in Ireland is quoted in euro because that is what
	 * they spend, and nothing here converts anything.
	 *
	 * Null for a country with no obvious answer, which a caller should read
	 * as "use your default".
	 *
	 * @since 1.1.0
	 *
	 * @param string $code ISO 3166-1 alpha-2 code.
	 *
	 * @return string|null ISO 4217 code, or null.
	 */
	public static function currency( string $code ): ?string {
		$code = strtoupper( trim( $code ) );

		if ( isset( self::CURRENCIES[ $code ] ) ) {
			return self::CURRENCIES[ $code ];
		}

		// The euro area, from the one list that already knows who is in it.
		return self::is_eu( $code ) ? 'EUR' : null;
	}

	/**
	 * Every country, code => name, sorted by name.
	 *
	 * @since 1.0.0
	 *
	 * @return array<string, string>
	 */
	public static function all(): array {
		$countries = self::COUNTRIES;
		asort( $countries );

		return $countries;
	}

	/**
	 * Every country code.
	 *
	 * @since 1.0.0
	 *
	 * @return list<string>
	 */
	public static function codes(): array {
		return array_keys( self::COUNTRIES );
	}

	/**
	 * The English name for a code.
	 *
	 * @since 1.0.0
	 *
	 * @param string $code ISO 3166-1 alpha-2 code.
	 *
	 * @return string|null Null when unknown.
	 */
	public static function name( string $code ): ?string {
		return self::COUNTRIES[ self::normalize( $code ) ] ?? null;
	}

	/**
	 * The code for a name.
	 *
	 * Case-insensitive, accented letters included ("åland islands"), and
	 * tolerant of the common alternatives — "USA", "UK", "Holland" and
	 * similar all resolve.
	 *
	 * @since 1.0.0
	 *
	 * @param string $name Country name.
	 *
	 * @return string|null Null when unrecognised.
	 */
	public static function code( string $name ): ?string {
		$needle = mb_strtolower( trim( $name ), 'UTF-8' );

		if ( isset( self::ALIASES[ $needle ] ) ) {
			return self::ALIASES[ $needle ];
		}

		foreach ( self::COUNTRIES as $code => $country ) {
			if ( mb_strtolower( $country, 'UTF-8' ) === $needle ) {
				return $code;
			}
		}

		return null;
	}

	/**
	 * Whether a code is a known country.
	 *
	 * @since 1.0.0
	 *
	 * @param string $code Candidate.
	 *
	 * @return bool
	 */
	public static function exists( string $code ): bool {
		return isset( self::COUNTRIES[ self::normalize( $code ) ] );
	}

	/**
	 * Validate and normalise a code.
	 *
	 * @since 1.0.0
	 *
	 * @param string $code Candidate.
	 *
	 * @return string|null Uppercase code, or null when unknown.
	 */
	public static function sanitize( string $code ): ?string {
		$code = self::normalize( $code );

		return isset( self::COUNTRIES[ $code ] ) ? $code : null;
	}

	/**
	 * The emoji flag for a code.
	 *
	 * Built from regional indicator symbols, so it needs no image assets
	 * and renders wherever the font has them. Windows is the notable
	 * exception — it shows the two letters instead.
	 *
	 * @since 1.0.0
	 *
	 * @param string $code ISO 3166-1 alpha-2 code.
	 *
	 * @return string Flag, or '' when the code is unknown.
	 */
	public static function flag( string $code ): string {
		$code = self::normalize( $code );

		if ( ! isset( self::COUNTRIES[ $code ] ) ) {
			return '';
		}

		// 'A' is U+1F1E6, so offset each letter from there.
		return mb_chr( 0x1F1E6 + ( ord( $code[0] ) - 65 ), 'UTF-8' )
			. mb_chr( 0x1F1E6 + ( ord( $code[1] ) - 65 ), 'UTF-8' );
	}

	/**
	 * Search countries by name.
	 *
	 * @since 1.0.0
	 *
	 * @param string $query Partial name.
	 * @param int    $limit Maximum results. 0 for all.
	 *
	 * @return array<string, string> Matching code => name.
	 */
	public static function search( string $query, int $limit = 0 ): array {
		// Multibyte-aware, or "åland" never finds "Åland Islands".
		$query = mb_strtolower( trim( $query ), 'UTF-8' );

		if ( '' === $query ) {
			return array();
		}

		$results = array();

		foreach ( self::all() as $code => $name ) {
			if ( str_contains( mb_strtolower( $name, 'UTF-8' ), $query ) ) {
				$results[ $code ] = $name;

				if ( $limit > 0 && count( $results ) >= $limit ) {
					break;
				}
			}
		}

		return $results;
	}

	/**
	 * Whether a country is in the EU.
	 *
	 * @since 1.0.0
	 *
	 * @param string $code ISO 3166-1 alpha-2 code.
	 *
	 * @return bool
	 */
	public static function is_eu( string $code ): bool {
		return in_array( self::normalize( $code ), self::EU, true );
	}

	/**
	 * The EU member states.
	 *
	 * @since 1.0.0
	 *
	 * @return array<string, string> Code => name.
	 */
	public static function eu(): array {
		return array_intersect_key( self::all(), array_flip( self::EU ) );
	}

	/**
	 * Whether a country has elevated payment-fraud rates.
	 *
	 * One signal among several. Blocking on this alone refuses a lot of
	 * genuine customers.
	 *
	 * @since 1.0.0
	 *
	 * @param string $code ISO 3166-1 alpha-2 code.
	 *
	 * @return bool
	 */
	public static function is_high_risk( string $code ): bool {
		return in_array( self::normalize( $code ), self::HIGH_RISK, true );
	}

	/**
	 * Whether a country is comprehensively sanctioned.
	 *
	 * Indicative only — verify against your own legal advice.
	 *
	 * @since 1.0.0
	 *
	 * @param string $code ISO 3166-1 alpha-2 code.
	 *
	 * @return bool
	 */
	public static function is_sanctioned( string $code ): bool {
		return in_array( self::normalize( $code ), self::SANCTIONED, true );
	}

	/**
	 * Uppercase and trim a code.
	 *
	 * @since 1.0.0
	 *
	 * @param string $code Raw code.
	 *
	 * @return string
	 */
	private static function normalize( string $code ): string {
		return strtoupper( trim( $code ) );
	}
}
