# Angle Mexico RFC
PHP utility to handle Mexico SAT's (Tax Authority) RFC (Tax ID)

## RFC
What is RFC? 
_Registro Federal de Contribuyentes_ for the Mexican Tax Authority: SAT _Servicio de Administración Tributaria_ and SHCP _Secretaría de Hacienda y Crédito Público_.

## How to Use
#### Calculate a Person's RFC from their Name and Date of Birth data

This calculates the _Homoclave_ , which is a __ 

However, *do note* this is only a baseline ___ and SAT can always change this __ code 

specially the last 3 digits called _homoclave_.

The whole purpose of this is to prevent __

If two individuals were to have the exact same name born on the same date __ then they would be homonyms __ sharing the same base __ 

SAT would then change the _homoclave_ for one or both of them.

More testing and validation is still required, RFCs have a lot of exceptions and edge cases that must be considered.

```php
$dob = \DateTime::createFromFormat('Y-m-d', '1989-07-15');
$rfc = RFC::createForNaturalPerson('Jose Ramiro', 'Gutierrez', 'Hernández', $dob);

echo $rfc->getRfc(); // GUHR890715
echo $rfc->getRfcComplete(); // GUHR890715G54
```


#### Validate existing RFC strings
The utility can also be used to validate an existing RFC string and infer some metadata from it.

```php
echo (RFC::isValid('INVALID_12313') ? 'Yes' : 'No'); // No
echo (RFC::isValid('GUHR890715G54') ? 'Yes' : 'No'); // Yes

echo (RFC::isValidWithoutHomoclave('GUHR890715') ? 'Yes' : 'No'); // Yes
```

#### Extract metadata from valid RFC strings
Validate and infer some metadata from the RFC string, such as type of legal entity.

TODO: infer date of birth.

```php
$rfc = RFC::createFromRfcString('GUHR890715G54');

if ($rfc === null) {
    die('Invalid RFC string');
}

echo ($rfc->isGeneric() ? 'Yes' : 'No'); // No
echo ($rfc->isNaturalPerson() ? 'Yes' : 'No'); // Yes
```

## Tests

```bash
php vendor/bin/phpunit tests/BuildTest.php
php vendor/bin/phpunit tests/ValidationTest.php
```

## TO-DO
- Finish writing up this README
- Cleanup the RFC class, it's very messy right now. Also clean up the Tests for RFC verifications. Implement some way of testing private / protected methods ?
- Find a big list of Person Names, Date of Births and RFCs to test against.

## References
https://cec.cele.unam.mx/include/howToRFC.php
https://solucionfactible.com/sfic/capitulos/timbrado/rfc-clave-direfenciadora-homonimia.jsp
https://solucionfactible.com/sfic/capitulos/timbrado/rfc-digito-verificador.jsp
https://solucionfactible.com/sfic/capitulos/timbrado/rfc-anexos.jsp
https://solucionfactible.com/sfic/resources/files/palabrasInconvenientes-rfc.pdf
