<?php

namespace Angle\Mexico\RFC;

use DateTime;

class RFC
{
    const RFC_GENERIC_NATIONAL = 'XAXX010101000';
    const RFC_GENERIC_FOREIGN  = 'XEXX010101000';

    const LEGAL_ENTITY_PATTERN      = "/^[A-Z&Ñ]{3}[0-9]{2}(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])[A-Z0-9]{2}[0-9A]$/";
    const NATURAL_PERSON_PATTERN    = "/^[A-Z&Ñ]{4}[0-9]{2}(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])[A-Z0-9]{2}[0-9A]$/";

    const LEGAL_ENTITY_PATTERN_WITHOUT_HOMOCLAVE    = "/^[A-Z&Ñ]{3}[0-9]{2}(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])$/";
    const NATURAL_PERSON_PATTERN_WITHOUT_HOMOCLAVE  = "/^[A-Z&Ñ]{4}[0-9]{2}(0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])$/";

    const INCONVENIENT_WORDS = [
        'BUEI',
        'BUEY',
        'CACA',
        'CACO',
        'CAGA',
        'CAGO',
        'CAKA',
        'CAKO',
        'COGE',
        'COJA',

        'COJE',
        'COJI',
        'COJO',
        'CULO',
        'FETO',
        'GUEY',
        'JOTO',
        'KACA',
        'KACO',
        'KAGA',

        'KAGO',
        'KOGE',
        'KOJO',
        'KAKA',
        'KULO',
        'MAME',
        'MAMO',
        'MEAR',
        'MEAS',
        'MEON',

        'MION',
        'MOCO',
        'MULA',
        'PEDA',
        'PEDO',
        'PENE',
        'PUTA',
        'PUTO',
        'QULO',
        'RATA',

        'RUIN',
    ];

    const COMMON_FIRST_NAMES = [
        'MARIA', 'MA', 'JOSE', 'J',
    ];

    const COMPOUND_SURNAMES = [
        'DA', 'DAS', 'DE', 'DEL', 'DER', 'DI', 'DIE', 'DD', 'EL', 'LA', 'LOS', 'LAS', 'LE', 'LES', 'MAC', 'MC', 'VAN', 'VON', 'Y',
    ];

    const HOMONIMIA_MAP = [
        ' ' => 0,
        '0' => 0,
        '1' => 1,
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
        '7' => 7,
        '8' => 8,
        '9' => 9,

        '&' => 10,
        'A' => 11,
        'B' => 12,
        'C' => 13,
        'D' => 14,
        'E' => 15,
        'F' => 16,
        'G' => 17,
        'H' => 18,
        'I' => 19,

        //'' => 20,
        'J' => 21,
        'K' => 22,
        'L' => 23,
        'M' => 24,
        'N' => 25,
        'O' => 26,
        'P' => 27,
        'Q' => 28,
        'R' => 29,

        //'' => 30,
        //'' => 31,
        'S' => 32,
        'T' => 33,
        'U' => 34,
        'V' => 35,
        'W' => 36,
        'X' => 37,
        'Y' => 38,
        'Z' => 39,

        'Ñ' => 40,
    ];

    const HOMONIMIA_RESULT_MAP = [
        0 => '1',
        1 => '2',
        2 => '3',
        3 => '4',
        4 => '5',
        5 => '6',
        6 => '7',
        7 => '8',
        8 => '9',
        9 => 'A',

        10 => 'B',
        11 => 'C',
        12 => 'D',
        13 => 'E',
        14 => 'F',
        15 => 'G',
        16 => 'H',
        17 => 'I',
        18 => 'J',
        19 => 'K',

        20 => 'L',
        21 => 'M',
        22 => 'N',
        23 => 'P',
        24 => 'Q',
        25 => 'R',
        26 => 'S',
        27 => 'T',
        28 => 'U',
        29 => 'V',

        30 => 'W',
        31 => 'X',
        32 => 'Y',
        33 => 'Z',
    ];

    const CHECK_DIGIT_MAP = [
        '0' => 0,
        '1' => 1,
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
        '7' => 7,
        '8' => 8,
        '9' => 9,

        'A' => 10,
        'B' => 11,
        'C' => 12,
        'D' => 13,
        'E' => 14,
        'F' => 15,
        'G' => 16,
        'H' => 17,
        'I' => 18,
        'J' => 19,

        'K' => 20,
        'L' => 21,
        'M' => 22,
        'N' => 23,
        '&' => 24,
        'O' => 25,
        'P' => 26,
        'Q' => 27,
        'R' => 28,
        'S' => 29,

        'T' => 30,
        'U' => 31,
        'V' => 32,
        'W' => 33,
        'X' => 34,
        'Y' => 35,
        'Z' => 36,
        ' ' => 37,
        'Ñ' => 38,
    ];


    /**
     * @var string $rfc
     */
    protected $rfc;

    /**
     * Disambiguation code
     * @var string $homoclave
     */
    private $homoclave;

    /**
     * @var string $names
     */
    protected $names;

    /**
     * @var string $paternalSurname
     */
    protected $paternalSurname;

    /**
     * @var string|null $maternalSurname
     */
    protected $maternalSurname;

    /**
     * @var DateTime $birthDate
     */
    protected $birthDate;


    // FLAGS

    /**
     * @var bool $naturalPerson
     */
    protected $naturalPerson = false;

    /**
     * @var bool $legalEntity
     */
    protected $legalEntity = false;

    /**
     * @var bool $genericNational
     */
    protected $genericNational = false;

    /**
     * @var bool $genericForeign
     */
    protected $genericForeign = false;


    public static function isValid(string $rfc): bool
    {
        $r = preg_match(self::LEGAL_ENTITY_PATTERN, $rfc, $matches);

        if ($r === 1) {
            return true;
        }

        $r = preg_match(self::NATURAL_PERSON_PATTERN, $rfc, $matches);

        if ($r === 1) {
            return true;
        }

        return false;
    }

    public static function isValidWithoutHomoclave(string $rfc): bool
    {
        $r = preg_match(self::LEGAL_ENTITY_PATTERN_WITHOUT_HOMOCLAVE, $rfc, $matches);

        if ($r === 1) {
            return true;
        }

        $r = preg_match(self::NATURAL_PERSON_PATTERN_WITHOUT_HOMOCLAVE, $rfc, $matches);

        if ($r === 1) {
            return true;
        }

        return false;
    }

    // TODO: isCheckDigitValid(string $rfc): bool

    public static function createForNaturalPerson(string $names, string $paternalSurname, ?string $maternalSurname, DateTime $birthDate): ?self
    {
        $rfc = new self();
        $rfc->names             = self::cleanNameString($names); // NOTE: "Ñ" is a valid character!!
        $rfc->paternalSurname   = self::cleanNameString($paternalSurname);
        $rfc->maternalSurname   = self::cleanNameString($maternalSurname);
        $rfc->birthDate         = $birthDate;

        $rfc->naturalPerson     = true;

        $rfc->rfc = $rfc->buildRfc();
        $rfc->homoclave = $rfc->buildHomoclave();

        return $rfc;
    }

    public static function createFromRfcString(string $rfc): ?self
    {
        $rfc = preg_replace('/\s/', '', $rfc);
        $rfc = str_replace('-', '', $rfc);
        $rfc = mb_strtoupper($rfc);

        $entity = new self();

        if ($rfc == self::RFC_GENERIC_NATIONAL) {
            $entity->rfc = mb_substr($rfc, 0, 10);
            $entity->homoclave = '000';
            $entity->genericNational = true;
            return $entity;
        }

        if ($rfc == self::RFC_GENERIC_FOREIGN) {
            $entity->rfc = mb_substr($rfc, 0, 10);
            $entity->homoclave = '000';
            $entity->genericForeign = true;
            return $entity;
        }

        // Check for Natual Person
        if (preg_match(self::NATURAL_PERSON_PATTERN, $rfc)) {
            $entity->rfc = mb_substr($rfc, 0, 10);
            $entity->homoclave = mb_substr($rfc, 10, 3);
            $entity->naturalPerson = true;
            return $entity;
        }

        // Check for Legal Entity
        if (preg_match(self::LEGAL_ENTITY_PATTERN, $rfc)) {
            $entity->rfc = mb_substr($rfc, 0, 9);
            $entity->homoclave = mb_substr($rfc, 9, 3);
            $entity->legalEntity = true;
            return $entity;
        }

        return null;
    }

    public static function cleanNameString(string $string): string
    {
        $string = mb_strtoupper(CharacterRules::transform($string)); // NOTE: "Ñ" is a valid character!!

        // now remove any other punctuation characters in the string
        $string = preg_replace('/[^A-ZÑ \/-]/', '', $string);

        // replace multiple spaces (or tabs, line ends, etc.) with a single space
        $string = preg_replace('/\\s+/', ' ', $string);

        $string = trim($string);

        return $string;
    }

    /**
     * Filter out (remove) any components of the surname that are deemed "Compound"
     * @param string $surname
     * @return string
     */
    public static function filterSurname(string $surname): string
    {
        $parts = explode(' ', $surname);

        if (count($parts) == 1) {
            // there is only one last name, nothing to filter out
            return $surname;
        }

        foreach ($parts as $k => $s) {
            if (in_array($s, self::COMPOUND_SURNAMES, true)) {
                unset($parts[$k]);
            }
        }

        if (count($parts) == 0) {
            // woops, we deleted all surnames, this cannot be good. return the input instead.
            return $surname;
        }

        return implode(' ', $parts);
    }

    private function buildRfc(): string
    {
        // Paternal Surname
        // Filter the paternal surname
        $paternal = self::filterSurname($this->paternalSurname);

        $first = mb_substr($paternal, 0, 1);

        if ($first == 'Ñ') {
            $first = 'X';
        }

        // Pull all the vowels in the name, starting from the second position
        $vowels = preg_replace('/[^AEIOU]/', '', mb_substr($paternal, 1));

        if (strlen($vowels) > 0) {
            $second = mb_substr($vowels, 0, 1);
        } else {
            $second = 'X'; // the last name does not have vowels
        }

        // Maternal Surname
        $maternal = self::filterSurname($this->maternalSurname);

        if (!$maternal) {
            $third = 'X'; // if the person does not have a Maternal Surname (second last name), use an X on that position
        } else {
            $third = mb_substr($maternal, 0, 1);

            if ($third == 'Ñ') {
                $third = 'X';
            }
        }

        // Names
        $nameParts = explode(' ', $this->names);

        if (strlen($this->names) == 0) {
            $fourth = 'X';

        } elseif (count($nameParts) == 1) {
            // this person only has one name
            $name = $nameParts[0];

            $fourth = mb_substr($name,  0, 1);
        } else {
            // this person has multiple names, we must check if the first name is not a "common" name
            if (in_array($nameParts[0], self::COMMON_FIRST_NAMES, true)) {
                // this is a common first name, use the second name instead
                $name = $nameParts[1];
            } else {
                $name = $nameParts[0];
            }

            $fourth = mb_substr($name,  0, 1);
        }


        // Finally, verify if the first four letters do not spell an "inconvenient word"
        $initial = $first . $second . $third . $fourth;

        if (in_array($initial, self::INCONVENIENT_WORDS, true)) {
            $fourth = 'X';
        }

        $dob = $this->birthDate->format('ymd');

        return $first . $second . $third . $fourth . $dob;
    }

    private function buildHomoclave(): string
    {
        if (!$this->rfc) {
            throw new \RuntimeException('Cannot calculate the CheckDigit if the base RFC has not been calculated');
        }

        $homonimia = self::calculateHomonimiaFromFullName($this->getFullName());

        $check = self::calculateCheckDigitFromRfcAndHomonimia($this->rfc, $homonimia);

        return $homonimia . $check;
    }

    private static function calculateHomonimiaFromFullName(string $fullName): ?string
    {
        $chain = '0'; // the chain always starts with a zero

        $chars = preg_split('//u', $fullName, -1, PREG_SPLIT_NO_EMPTY);

        foreach ($chars as $char) {
            if (!array_key_exists($char, self::HOMONIMIA_MAP)) {
                $chain .= '00'; // if the char is not found, default to 00
            } else {
                $chain .= sprintf('%02d', self::HOMONIMIA_MAP[$char]);
            }
        }

        // Start calculating by transversing the chain in pairs
        $r = 0;

        $digits = preg_split('//u', $chain, -1, PREG_SPLIT_NO_EMPTY);

        for($i = 1; $i < count($digits); $i++) {
            $a = intval($digits[$i - 1] . $digits[$i]);
            $b = intval($digits[$i]);

            $r += ($a * $b);
        }

        // from the result, we must only take the last 3 digits
        $result = $r % 1000;
        $quotient = intdiv($result, 34); // 34 is always the factor
        $remainder = $result % 34; // 34 is always the factor too..


        // Finally, map the results of the arithmetic division to the hash characters
        $first  = self::HOMONIMIA_RESULT_MAP[$quotient];
        $second = self::HOMONIMIA_RESULT_MAP[$remainder];

        return $first . $second;
    }

    private static function calculateCheckDigitFromRfcAndHomonimia(string $rfc, string $hominimia): string
    {
        if (mb_strlen($rfc) != 10 || mb_strlen($hominimia) != 2) {
            throw new \RuntimeException('Invalid RFC string length for CheckDigit calculation, only NaturalPerson (12 chars, RFC+Homonimia) supported');
        }

        // The calculation for LegalEntities (Persona Moral) is the same, only the length changes (12 for NaturalPerson, 11 for LegalEntity)

        $chars = preg_split('//u', $rfc . $hominimia, -1, PREG_SPLIT_NO_EMPTY);

        $r = 0;

        for ($i = 0; $i < count($chars); $i++) {
            // first, get the current char and map it
            $char = $chars[$i];

            if (!array_key_exists($char, self::CHECK_DIGIT_MAP)) {
                $key = 0;
            } else {
                $key = self::CHECK_DIGIT_MAP[$char];
            }

            #printf('Char: %s, Key: %d, Pos: %d' . PHP_EOL, $char, $key, (13-$i));

            $r += ($key * (13 - $i)); // the first position is always 13, and it counts downwards
        }

        $remainder = $r % 11; // 11 is always the modulo factor

        #printf('Result: %d, Remainder: %d' . PHP_EOL, $r, $remainder);

        if ($remainder == 0) {
            $check = '0';
        } elseif ($remainder == 1) {
            $check = 'A';
        } else {
            $check = strval(11 - $remainder);
        }

        return $check;
    }


    #########################
    ## GETTERS AND SETTERS ##
    #########################

    /**
     * @return string
     */
    public function getRfc(): ?string
    {
        return $this->rfc;
    }

    /**
     * @return string
     */
    public function getRfcComplete(): ?string
    {
        return $this->rfc . $this->homoclave;
    }

    /**
     * @param string $rfc
     * @return self
     */
    public function setRfc(string $rfc): self
    {
        $this->rfc = $rfc;
        return $this;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        $fullName = $this->names . ' ' . $this->paternalSurname . ' ' . $this->maternalSurname;
        $fullName = trim($fullName);

        return $fullName;
    }

    /**
     * @return string|null
     */
    public function getNames(): ?string
    {
        return $this->names;
    }

    /**
     * @param string $names
     * @return self
     */
    public function setNames(string $names): self
    {
        $this->names = $names;
        return $this;
    }

    /**
     * @return string
     */
    public function getPaternalSurname(): string
    {
        return $this->paternalSurname;
    }

    /**
     * @param string $paternalSurname
     * @return self
     */
    public function setPaternalSurname(string $paternalSurname): self
    {
        $this->paternalSurname = $paternalSurname;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMaternalSurname(): ?string
    {
        return $this->maternalSurname;
    }

    /**
     * @param string|null $maternalSurname
     * @return self
     */
    public function setMaternalSurname(?string $maternalSurname): self
    {
        $this->maternalSurname = $maternalSurname;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getBirthDate(): ?DateTime
    {
        return $this->birthDate;
    }

    /**
     * @param DateTime $birthDate
     * @return self
     */
    public function setBirthDate(DateTime $birthDate): self
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getHomoclave(): ?string
    {
        return $this->homoclave;
    }

    /**
     * @return string
     */
    public function getHomonimia(): ?string
    {
        if (!$this->homoclave || mb_strlen($this->homoclave) !== 3) {
            return null;
        }

        return mb_substr($this->homoclave, 0, 2);
    }

    /**
     * @return string
     */
    public function getCheckDigit(): ?string
    {
        if (!$this->homoclave || mb_strlen($this->homoclave) !== 3) {
            return null;
        }

        return mb_substr($this->homoclave, 2, 1);
    }

    /**
     * @return bool
     */
    public function isNaturalPerson(): bool
    {
        return $this->naturalPerson;
    }

    /**
     * @return bool
     */
    public function isLegalEntity(): bool
    {
        return $this->legalEntity;
    }

    /**
     * @return bool
     */
    public function isGeneric(): bool
    {
        return ($this->genericNational || $this->isGenericForeign());
    }

    /**
     * @return bool
     */
    public function isGenericNational(): bool
    {
        return $this->genericNational;
    }

    /**
     * @return bool
     */
    public function isGenericForeign(): bool
    {
        return $this->genericForeign;
    }
}