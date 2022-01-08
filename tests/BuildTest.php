<?php

namespace Angle\Mexico\RFC\Tests;

use Angle\Mexico\RFC\RFC;
use PHPUnit\Framework\TestCase;

final class BuildTest extends TestCase
{
    public function testCleanString(): void
    {
        $cases = [
            // input => expected output
            'maría'                         => 'MARIA',
            'maría josé'                    => 'MARIA JOSE',
            '  _& maria .. ,.;  josé __ '   => 'MARIA JOSE',
            'perez-lopez'                   => 'PEREZ-LOPEZ',
            'nuñez'                         => 'NUÑEZ',
            'núñez'                         => 'NUÑEZ',
            '    '                          => '',
            ' a     b   '                   => 'A B',
            ' a     _ ; _ .&%  b   '                   => 'A B',
        ];

        foreach ($cases as $input => $expected) {
            $this->assertEquals($expected, RFC::cleanNameString($input));
        }
    }

    public function testRfcBuild(): void
    {
        $cases = [
            // input => expected output
            'LUIS|ROMERO|PLAZUELOS'         => 'ROPL',

            // special cases:
            'ALBERTO|ÑANDO|RODRIGUEZ'           => 'XARA',
            'MARIA LUISA|PEREZ|HERNANDEZ'       => 'PEHL',
            //'JUAN JOSE|D/AMICO|ALVAREZ'         => 'DXAJ', ??
            'CARMEN|DE LEON|RAMIREZ'            => 'LERC',
            'JESUS|DE LA GARZA|PEREZ'           => 'GAPJ',
            'JESUS|DE|PEREZ'                    => 'DEPJ',
            'ROCIO|RIVA PALACIO|CRUZ'           => 'RICR',
            'CARLOS|MC GREGOR|LOPEZ'            => 'GELC',
            'OFELIA|PEDRERO|DOMINGUEZ'          => 'PEDX',
            'ANDRES|ICH|RODRIGUEZ'              => 'IXRA',
            'LUIS|PEREZ|'                       => 'PEXL',
            'Fernanda|Escamilla|Arroyo'         => 'EAAF',
            'María Fernanda|Escamilla|Arroyo'   => 'EAAF',
        ];

        $dob = \DateTime::createFromFormat('Y-m-d', '1980-01-01');

        foreach ($cases as $input => $expected) {
            $parts = explode('|', $input);

            if (count($parts) !== 3) {
                throw new \RuntimeException('Invalid input string: ' . $input);
            }

            $rfc = RFC::createForNaturalPerson($parts[0], $parts[1], $parts[2], $dob);
            $this->assertEquals($expected, substr($rfc->getRfc(), 0, 4));
        }
    }

    /* DEPRECATED: This test was used during development, and the methods it tested are now private inside the RFC class
    public function testRfcHomonimiaCalculation(): void
    {
        $cases = [
            // input => expected output
            'Emma|Gómez|Díaz'                   => 'GR',
            'Jose Ramiro|Gutierrez|Hernandez'   => 'G5',
        ];

        $dob = \DateTime::createFromFormat('Y-m-d', '1980-01-01'); // don't care, not used here..

        foreach ($cases as $input => $expected) {
            $parts = explode('|', $input);

            if (count($parts) !== 3) {
                throw new \RuntimeException('Invalid input string: ' . $input);
            }

            $rfc = RFC::createForNaturalPerson($parts[0], $parts[1], $parts[2], $dob);
            $this->assertEquals($expected, $rfc->calculateHomonimia());
        }
    }
    */

    /* DEPRECATED: This test was used during development, and the methods it tested are now private inside the RFC class
    public function testRfcCheckDigitCalculationFromFile(): void
    {
        // Sample RFC list file: 1 RFC (13 chars) per line

        $filename = dirname(__FILE__) . '/../test-data/sample-rfc-list.txt';

        $file = fopen($filename, "r");

        if (!$file) {
            die('ERROR - Cannot open INPUT file at ' . $filename);
        }

        $n = 0;
        while (($line = fgets($file)) !== false) {
            $n++;

            $line = trim($line);

            if (mb_substr($line, 0, 1) == '#') {
                // skip lines that begin with a hash (comments)
                continue;
            }

            // Extract the CheckDigit from a valid RFC
            $rfc = mb_substr($line, 0, 12);
            $check = mb_substr($line, 12, 1);

            $this->assertEquals($rfc . $check, $rfc . RFC::calculateCheckDigitFromString($rfc));
        }
    }
    */

    /* DEPRECATED: This test was used during development, and the methods it tested are now private inside the RFC class
    public function testRfcCheckDigitCalculation(): void
    {
        $cases = [
            // input => expected output
            'Jose Ramiro|Gutierrez|Hernandez|1989|07|15'   => '4',
        ];

        foreach ($cases as $input => $expected) {
            $parts = explode('|', $input);

            if (count($parts) !== 6) {
                throw new \RuntimeException('Invalid input string: ' . $input);
            }

            $dob = \DateTime::createFromFormat('Ymd', $parts[3] . $parts[4] . $parts[5]);

            $rfc = RFC::createForNaturalPerson($parts[0], $parts[1], $parts[2], $dob);
            $this->assertEquals($rfc->getRfc() . $rfc->calculateHomonimia() . $expected, $rfc->getRfc() . $rfc->calculateHomonimia() . $rfc->calculateCheckDigit());
        }
    }
    */

    public function testRfcFullBuild(): void
    {
        $cases = [
            // input => expected output
            'Jose Ramiro|Gutierrez|Hernandez|1989|07|15'   => 'GUHR890715G54',
        ];

        foreach ($cases as $input => $expected) {
            $parts = explode('|', $input);

            if (count($parts) !== 6) {
                throw new \RuntimeException('Invalid input string: ' . $input);
            }

            $dob = \DateTime::createFromFormat('Ymd', $parts[3] . $parts[4] . $parts[5]);

            $rfc = RFC::createForNaturalPerson($parts[0], $parts[1], $parts[2], $dob);
            $this->assertEquals($expected, $rfc->getRfcComplete());
        }
    }
}