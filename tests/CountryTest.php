<?php
/**
 * Country test suite.
 *
 * @package   SugarCommerce\Countries
 * @copyright Copyright (c) 2026, ArrayPress Limited
 * @license   GPL-2.0-or-later
 * @since     1.0.0
 */

declare( strict_types=1 );

namespace SugarCommerce\Countries\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SugarCommerce\Countries\Country;

final class CountryTest extends TestCase {

	/* ── what a country pays in ──────────────────────────────────────── */

	public function test_a_country_with_its_own_currency(): void {
		$this->assertSame( 'GBP', Country::currency( 'GB' ) );
		$this->assertSame( 'USD', Country::currency( 'US' ) );
		$this->assertSame( 'JPY', Country::currency( 'JP' ) );
	}

	/**
	 * Taken from is_eu() rather than listed again: twenty countries repeated
	 * is twenty chances to disagree with the list that already knows.
	 */
	public function test_the_euro_area_comes_from_the_eu_list(): void {
		$this->assertSame( 'EUR', Country::currency( 'DE' ) );
		$this->assertSame( 'EUR', Country::currency( 'IE' ) );
	}

	public function test_a_code_is_case_insensitive_and_trimmed(): void {
		$this->assertSame( 'AUD', Country::currency( ' au ' ) );
	}

	/**
	 * Null means "use your default", not "error". A shop with no price in
	 * somebody's currency is not a broken shop.
	 */
	public function test_a_country_with_no_obvious_answer_is_null(): void {
		$this->assertNull( Country::currency( 'AQ' ) );
		$this->assertNull( Country::currency( 'nonsense' ) );
		$this->assertNull( Country::currency( '' ) );
	}

	public function test_the_full_list_is_present(): void {
		$this->assertCount( 250, Country::all() );
		$this->assertCount( 250, Country::codes() );
	}

	public function test_the_list_is_sorted_by_name(): void {
		$names  = array_values( Country::all() );
		$sorted = $names;
		sort( $sorted, SORT_STRING );

		$this->assertSame( $sorted, $names );
	}

	public function test_names_resolve_from_codes(): void {
		$this->assertSame( 'United Kingdom', Country::name( 'GB' ) );
		$this->assertSame( 'Japan', Country::name( 'JP' ) );
		$this->assertNull( Country::name( 'ZZ' ) );
	}

	public function test_codes_are_case_and_space_insensitive(): void {
		$this->assertSame( 'United Kingdom', Country::name( 'gb' ) );
		$this->assertSame( 'United Kingdom', Country::name( ' Gb ' ) );
	}

	public function test_codes_resolve_from_names(): void {
		$this->assertSame( 'JP', Country::code( 'Japan' ) );
		$this->assertSame( 'JP', Country::code( 'japan' ) );
		$this->assertNull( Country::code( 'Atlantis' ) );
	}

	#[DataProvider( 'aliases' )]
	public function test_common_alternative_names_resolve( string $name, string $expected ): void {
		$this->assertSame( $expected, Country::code( $name ) );
	}

	/** @return array<string, array{0: string, 1: string}> */
	public static function aliases(): array {
		return array(
			'USA'         => array( 'USA', 'US' ),
			'America'     => array( 'America', 'US' ),
			'UK'          => array( 'UK', 'GB' ),
			'England'     => array( 'England', 'GB' ),
			'Britain'     => array( 'Great Britain', 'GB' ),
			'Holland'     => array( 'Holland', 'NL' ),
			'South Korea' => array( 'South Korea', 'KR' ),
			'UAE'         => array( 'UAE', 'AE' ),
		);
	}

	public function test_existence_and_sanitisation(): void {
		$this->assertTrue( Country::exists( 'gb' ) );
		$this->assertFalse( Country::exists( 'ZZ' ) );
		$this->assertSame( 'GB', Country::sanitize( ' gb ' ) );
		$this->assertNull( Country::sanitize( 'ZZ' ) );
	}

	public function test_a_list_is_trimmed_validated_unique_and_sorted(): void {
		$this->assertSame( array( 'DE', 'GB', 'IE' ), Country::sanitize_list( array( ' ie', 'gb', 'ZZ', 'GB ', 'de', '' ) ) );
		$this->assertSame( array( 'GB', 'IE', 'US' ), Country::sanitize_list( "us, gb\nie,,ie" ) );
	}

	public function test_a_list_ignores_what_is_not_a_code(): void {
		$this->assertSame( array( 'FR' ), Country::sanitize_list( array( 44, null, array( 'GB' ), true, 'fr', 'France' ) ) );
		$this->assertSame( array(), Country::sanitize_list( null ) );
		$this->assertSame( array(), Country::sanitize_list( 826 ) );
		$this->assertSame( array(), Country::sanitize_list( '  ' ) );
	}

	public function test_a_list_is_a_list_whatever_the_keys(): void {
		$this->assertSame( array( 'GB', 'NO' ), Country::sanitize_list( array( 'x' => 'no', 7 => 'gb' ) ) );
	}

	public function test_flags_are_regional_indicator_pairs(): void {
		$this->assertSame( '🇬🇧', Country::flag( 'GB' ) );
		$this->assertSame( '🇯🇵', Country::flag( 'jp' ) );
		$this->assertSame( '🇺🇸', Country::flag( 'US' ) );
		$this->assertSame( '', Country::flag( 'ZZ' ) );
	}

	public function test_every_country_has_a_flag(): void {
		foreach ( Country::codes() as $code ) {
			$this->assertSame( 2, mb_strlen( Country::flag( $code ) ), $code );
		}
	}

	public function test_search_matches_partial_names(): void {
		$results = Country::search( 'united' );

		$this->assertArrayHasKey( 'GB', $results );
		$this->assertArrayHasKey( 'US', $results );
		$this->assertArrayHasKey( 'AE', $results );
	}

	public function test_search_respects_a_limit(): void {
		$this->assertCount( 2, Country::search( 'a', 2 ) );
	}

	public function test_an_empty_search_returns_nothing(): void {
		$this->assertSame( array(), Country::search( '  ' ) );
	}

	/* ─── Groups ────────────────────────────────────────────────────── */

	public function test_eu_membership(): void {
		$this->assertTrue( Country::is_eu( 'DE' ) );
		$this->assertTrue( Country::is_eu( 'IE' ) );
		$this->assertFalse( Country::is_eu( 'US' ) );
	}

	/**
	 * The one that decides whether VAT rules apply, and the one most
	 * lists still get wrong.
	 */
	public function test_the_uk_is_not_in_the_eu(): void {
		$this->assertFalse( Country::is_eu( 'GB' ) );
	}

	public function test_the_eu_has_twenty_seven_members(): void {
		$this->assertCount( 27, Country::eu() );
	}

	public function test_eu_members_are_returned_with_names(): void {
		$this->assertSame( 'Germany', Country::eu()['DE'] ?? null );
	}

	public function test_risk_and_sanction_flags(): void {
		$this->assertTrue( Country::is_sanctioned( 'KP' ) );
		$this->assertFalse( Country::is_sanctioned( 'GB' ) );
		$this->assertFalse( Country::is_high_risk( 'GB' ) );
	}

	public function test_group_members_are_all_real_countries(): void {
		foreach ( array_merge( array_keys( Country::eu() ) ) as $code ) {
			$this->assertTrue( Country::exists( $code ), $code );
		}
	}

	public function test_unknown_codes_are_in_no_group(): void {
		$this->assertFalse( Country::is_eu( 'ZZ' ) );
		$this->assertFalse( Country::is_high_risk( 'ZZ' ) );
		$this->assertFalse( Country::is_sanctioned( 'ZZ' ) );
	}

	/**
	 * strtolower() leaves multibyte letters alone, so a name typed in
	 * lower case never matched one that starts with Å.
	 */
	public function test_accented_names_match_in_any_case(): void {
		$this->assertSame( 'AX', Country::code( 'åland islands' ) );
		$this->assertSame( 'AX', Country::code( 'ÅLAND ISLANDS' ) );
		$this->assertArrayHasKey( 'AX', Country::search( 'åland' ) );
		$this->assertArrayHasKey( 'ST', Country::search( 'SÃO TOMÉ' ) );
	}

	/**
	 * Bulgaria joined the euro area on 1 January 2026.
	 */
	public function test_bulgaria_pays_in_euro(): void {
		$this->assertSame( 'EUR', Country::currency( 'BG' ) );
		$this->assertSame( 'CZK', Country::currency( 'cz' ) );
	}
}
