<?php

namespace App\Tests\Service;

use App\Service\PasswordGenerator;
use PHPUnit\Framework\TestCase;

class PasswordGeneratorTest extends TestCase
{
    /** @test */
    public function generate_should_respect_password_constraint(): void
    {
        $passwordGenerator = new PasswordGenerator();

        $password= $passwordGenerator->generate(length: 10);

        $this->assertSame(10, mb_strlen($password));
        $this->assertMatchesRegularExpression('/^[a-z]{10}$/', $password);
        $this->assertDoesNotMatchRegularExpression('/[A-Z]/', $password);
        $this->assertDoesNotMatchRegularExpression('/[0-9]/', $password);
        $this->assertDoesNotMatchRegularExpression('/[\W_]/', $password);


        $password= $passwordGenerator->generate(length: 15,uppercaseLatters: true);

        $this->assertSame(15, mb_strlen($password));
        $this->assertMatchesRegularExpression('/[a-z]/', $password);
        $this->assertMatchesRegularExpression('/[A-Z]/', $password);
        $this->assertDoesNotMatchRegularExpression('/[0-9]/', $password);
        $this->assertDoesNotMatchRegularExpression('/[\W_]/', $password);



        $password= $passwordGenerator->generate(length: 22,uppercaseLatters: true,digits: true);

        $this->assertSame(22, mb_strlen($password));
        $this->assertMatchesRegularExpression('/[a-z]/', $password);
        $this->assertMatchesRegularExpression('/[A-Z]/', $password);
        $this->assertMatchesRegularExpression('/[0-9]/', $password);
        $this->assertDoesNotMatchRegularExpression('/[\W_]/', $password);

        $password= $passwordGenerator->generate(length: 14,uppercaseLatters: true,digits: true,specialCharacters: true);

        $this->assertSame(14, mb_strlen($password));
        $this->assertMatchesRegularExpression('/[a-z]/', $password);
        $this->assertMatchesRegularExpression('/[A-Z]/', $password);
        $this->assertMatchesRegularExpression('/[0-9]/', $password);
        $this->assertMatchesRegularExpression('/[\W_]/', $password);
    }
}
