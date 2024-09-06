<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Stichoza\GoogleTranslate\Exceptions\LargeTextException;
use Stichoza\GoogleTranslate\Exceptions\RateLimitException;
use Stichoza\GoogleTranslate\Exceptions\TranslationRequestException;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslateTextHelper
{
    /**
     * @var string Default source language.
     */
    private static string $source = 'en';

    /**
     * @var string Default target language.
     */
    private static string $target = 'hi';

    /**
     * Set the source language.
     *
     * @param  string  $source The source language code.
     * @return self This instance of the class.
     */
    public static function setSource(string $source): self
    {
        self::$source = $source;

        return new self();
    }

    /**
     * Set the target language.
     *
     * @param  string  $target The target language code.
     * @return self This instance of the class.
     */
    public static function setTarget(string $target): self
    {
        self::$target = $target;

        return new self();
    }

    /**
     * Translate the given text from the source language to the target language.
     *
     * @param  string  $text The text to be translated.
     * @return string The translated text.
     */
    // public static function translate(string $text): string
    // {
    //     $translatedText = '';

    //     try {
    //         if(isset($text)){
    //             $translator = new GoogleTranslate();
    //             $translator->setSource(self::$source);
    //             $translator->setTarget(self::$target);
    
    //             $translatedText = $translator->translate($text);
    //         }else{
    //             $translatedText = '';
    //         }
           
    //     } catch (LargeTextException|RateLimitException|TranslationRequestException $ex) {
    //         Log::error('TranslateTextHelperException', [
    //             'message' => $ex->getMessage(),
    //         ]);
    //     }

    //     return $translatedText;
    // }


    public static function translate(string $text): string
    {
        $translatedText = '';

        try {
            if (isset($text) && $text !== '') {
                $translator = new GoogleTranslate();
                $translator->setSource(self::$source);
                $translator->setTarget(self::$target);

                $result = $translator->translate($text);
                
                // Ensure $result is not null before assigning it to $translatedText
                $translatedText = $result !== null ? $result : '';
            }
        } catch (LargeTextException|RateLimitException|TranslationRequestException $ex) {
            Log::error('TranslateTextHelperException', [
                'message' => $ex->getMessage(),
            ]);
            // In case of an exception, ensure $translatedText is a string
            $translatedText = '';
        }

        return $translatedText;
    }

}