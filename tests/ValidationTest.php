<?php

namespace Angle\Mexico\RFC\Tests;

use Angle\Mexico\RFC\RFC;
use PHPUnit\Framework\TestCase;

final class ValidationTest extends TestCase
{
    public function testRfcValidation(): void
    {
        $cases = [
            // input => expected output
            // valid strings
            'GUHR890715G54' => true,

            // invalid strings
            'invalid_rfc'           => false,
            ''                      => false,
            'HEGG560427MVZRRL04'    => false, // this is a valid CURP, but not a valid RFC
            'G83R890715G54'         => false, // inserting digits in the first part
            'GUHR890715G5'          => false, // missing the check digit
        ];

        foreach ($cases as $input => $expected) {
            $this->assertEquals($expected, RFC::isValid($input));
        }


        // Check that filters work OK
        $naturalPersonRFC = 'GUHR890715G54';

        $this->assertEquals(true, RFC::isValid($naturalPersonRFC));
        $this->assertEquals(true, RFC::isValid($naturalPersonRFC, RFC::TYPE_NATURAL_PERSON));
        $this->assertEquals(false, RFC::isValid($naturalPersonRFC, RFC::TYPE_LEGAL_ENTITY));


        $legalEntityRFC = 'GUH890715AA2';

        $this->assertEquals(true, RFC::isValid($legalEntityRFC));
        $this->assertEquals(true, RFC::isValid($legalEntityRFC, RFC::TYPE_LEGAL_ENTITY));
        $this->assertEquals(false, RFC::isValid($legalEntityRFC, RFC::TYPE_NATURAL_PERSON));
    }

    public function testRfcWithoutHomoclaveValidation(): void
    {
        $cases = [
            // input => expected output
            // valid strings
            'GUHR890715' => true,

            // invalid strings
            'invalid_rfc'           => false,
            ''                      => false,
            'HEGG560427MVZRRL04'    => false, // this is a valid CURP, but not a valid RFC
            'G83R890715'            => false, // inserting digits in the first part
            'GUHR890799'            => false, // invalid date digits
        ];

        foreach ($cases as $input => $expected) {
            $this->assertEquals($expected, RFC::isValidWithoutHomoclave($input));
        }


        // Check that filters work OK
        $naturalPersonRFC = 'GUHR890715';

        $this->assertEquals(true, RFC::isValidWithoutHomoclave($naturalPersonRFC));
        $this->assertEquals(true, RFC::isValidWithoutHomoclave($naturalPersonRFC, RFC::TYPE_NATURAL_PERSON));
        $this->assertEquals(false, RFC::isValidWithoutHomoclave($naturalPersonRFC, RFC::TYPE_LEGAL_ENTITY));


        $legalEntityRFC = 'GUH890715';

        $this->assertEquals(true, RFC::isValidWithoutHomoclave($legalEntityRFC));
        $this->assertEquals(true, RFC::isValidWithoutHomoclave($legalEntityRFC, RFC::TYPE_LEGAL_ENTITY));
        $this->assertEquals(false, RFC::isValidWithoutHomoclave($legalEntityRFC, RFC::TYPE_NATURAL_PERSON));
    }
}