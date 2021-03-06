<?php
namespace App\Entity;

class Word
{
    public function checkIfWordIsInEnglish ($word_to_lower_case){

        // url for checking if word is in english
        $url = "https://api.dictionaryapi.dev/api/v2/entries/en/".$word_to_lower_case;
        function getHttpResponseCode($url) {
            $headers = get_headers($url);
            return substr($headers[0], 9, 3);
        }

        // response code of reuqest
        $get_http_response_code = getHttpResponseCode($url);
        return $get_http_response_code;

    }
    // numOfUniqueLetters returns numer of unique letters
    public static function numOfUniqueLetters($word){
        
        // Split word to array by letters
        $letters_array = str_split($word);
        // Check how many unique letters there is
        $result = array_unique($letters_array);
        // Count unique letters and numer is used as points for score and return it
        return count($result);

    }
    public static function isPalindrome($word){
        // Reverse a word, compare it with original and return true of false
        return $word === strrev($word) ? true : false;

    }
    // isAlmostPalindrome returns true or false from checkForAlmostPalindrome
    public function isAlmostPalindrome($word_to_lower_case){

        // create array from string
        $letters_array = str_split($word_to_lower_case);
        $this->checkForAlmostPalindrome($letters_array);

    }
    // checkForAlmostPalindrome returns true or false
    public function checkForAlmostPalindrome($letters_array){
        // clone $letters_array
        $letters_array_without_removed_element = $letters_array;
        $almost_palindrome_results = [];
        $words = [];
        for ($i=0; $i < count($letters_array); $i++) { 

            // delete letter according to loop count
            unset($letters_array[$i]);
            // change $letters_array to string
            $word = implode($letters_array);
            $words[] = $word;
            // check if it is palindrome
            $almost_palindrome_results = Word::isPalindrome($word);

            // check if $almost_palindrome_results is false
            if(!$almost_palindrome_results)$letters_array = $letters_array_without_removed_element;// reset $letters array
            // check if $almost_palindrome_results is true
            if ($almost_palindrome_results)return true;
            
        }
    }


}