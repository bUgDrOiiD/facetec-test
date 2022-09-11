<?php

// ...
use App\Validator\FacetecString;
use App\Validator\FacetecStringValidator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class FacetecStringValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator()
    {
        return new FacetecStringValidator();
    }

    public function testNullIsValid()
    {
        $this->validator->validate(null, new FacetecString());

        $this->assertNoViolation();
    }

    /**
    * @dataProvider provideValidConstraints
    */
    public function testValidString($value)
    {
        $this->validator->validate($value, new FacetecString());

        $this->assertNoViolation();
    }

    public function provideValidConstraints()
    {
        # Could probably use some logic to generate all possible scenarios for bigger strings
        return [
            ['fAceTec'],
            ['faCeTec'],
            ['FacETec'],
            ['FaceTec'],
            ['FAceTec'],
            ['FACeTec'],
            ['FACETec'], 
            ['faCETec'],
            ['fACETec']
        ];
    }

    /**
     * @dataProvider provideInvalidConstraints
     */
    public function testInvalidString($value)
    {
        $constraint = new FacetecString([
            'message' => 'myMessage',
        ]);

        $this->validator->validate($value, $constraint);

        $this->buildViolation('myMessage')  
            ->setParameter('{{ value }}', $value)
            ->assertRaised();
    }

    public function provideInvalidConstraints()
    {
        # Could probably use some logic to generate all possible scenarios for bigger strings
        return [
            ['FAce'],
            ['FACe'],
            ['FACE'],
            ['FAcE'],
            ['FaCe'],
            ['face'],
            ['faCe'],
            ['facE'],
            ['fAcE'],
            ['fACE'],
            ['faCE']
        ];
    }
}