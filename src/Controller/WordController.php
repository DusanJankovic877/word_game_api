<?php

namespace App\Controller;
use App\Entity\Word;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class WordController extends AbstractController{

    public $total_score = 0;
    public $unique_letters_score = 0;
    public $palindrome_score = 0;
    public $almost_palindrome_score = 0;
    public $palindrome_points = 3;
    public $almost_palindrome_points = 2;
    
    /**
     * @Route("api/index")
     * @Method({"GET"})
     */
    public function index(Request $request): JsonResponse{

        // get word
        $parameter = json_decode($request->getContent(), true);
        // word to lower case
        $word_to_lower_case = strtolower($parameter["word"]);
        $word = new Word();
        $almost_palindrome = null;
        
        $response_code = $word->checkIfWordIsInEnglish($word_to_lower_case);
        if ($response_code == 200 ) {

            // Add unique letters number(points) to score
            $this->unique_letters_score = $word->numOfUniqueLetters($word_to_lower_case);
            $this->total_score = $this->unique_letters_score;

            // Check if word is palidrome
            $palindrome= $word->isPalindrome($word_to_lower_case);
            // Check if word is almost palidrome
            !$palindrome ? $almost_palindrome = $word->isAlmostPalindrome($word_to_lower_case) : $almost_palindrome;
            
            if($palindrome){

                // Add palindrome points to score
                $this->palindrome_score = $this->palindrome_points;
                $this->total_score = $this->total_score + $this->palindrome_score;

            }elseif(!$palindrome && $almost_palindrome){

                // Add almost palindrome points to score
                $this->almost_palindrome_score = $this->almost_palindrome_points;
                $this->total_score = $this->total_score + $this->almost_palindrome_score;

            }
            return  $this->json(
                [ 
                    "word that you entered" => $parameter["word"],
                    "unique_letters_score" => $this->unique_letters_score, 
                    "palindrome score" => $this->palindrome_score, 
                    "almost palindrome score" => $this->almost_palindrome_score,
                    "total score" => $this->total_score
                ]
            );
            } else {
                return $this->json(["message" => "We are sorry, we couldn't find definitions for the word you were looking for."]);
            }
    }
}