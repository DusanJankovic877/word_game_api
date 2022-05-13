<?php
namespace Tests\AppBundle\Entity;

use App\Entity\Word;
use PHPUnit\Framework\TestCase;

class WordTest extends TestCase
{
    
    public $string = 'rotor';
    
    public function testNumOfUniqueLetters(){
        $word = new Word();
        $this->assertFinite($word->numOfUniqueLetters('word'));
    }
        public function testIsPalindrome(){

        $word = new Word();
        $this->assertTrue($word->isPalindrome($this->string));
    }
    public function testIsAlmostPalindrome(){
        
        $word = new Word();
        //checking if not palindrome
        $isPalindrome = $this->assertFalse($word->isPalindrome($this->string));
        //if it is not palindrome check for  is almost palindrome
        if(!$isPalindrome)$this->assertTrue($word->isAlmostPalindrome($this->string));

  

    }
}