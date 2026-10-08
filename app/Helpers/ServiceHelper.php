<?php

namespace App\Helpers;

class ServiceHelper
{
    /**
     * Get all service labels.
     */
    public static function getServiceLabels(): array
    {
        return [
            'frozen_semen_ai' => [
                'en' => 'Frozen Semen AI',
                'hi' => 'फ्रोज़न सीमेन कृत्रिम गर्भाधान',
            ],
            'sex_semen_ai' => [
                'en' => 'Sex Sorted Semen AI',
                'hi' => 'सेक्स सॉर्टेड सीमेन कृत्रिम गर्भाधान',
            ],
            'ivf_embryo' => [
                'en' => 'IVF Embryo',
                'hi' => 'आई.वी.एफ. भ्रूण',
            ],
            'health_medical_checkip' => [
                'en' => 'Health/Medical Checkup',
                'hi' => 'स्वास्थ्य/चिकित्सा जांच',
            ],
            'animal_insurance' => [
                'en' => 'Animal Insurance',
                'hi' => 'पशु बीमा',
            ],
            'livestock_insurance' => [
                'en' => 'Livestock Insurance',
                'hi' => 'पशुधन बीमा',
            ],
            'vaccination' => [
                'en' => 'Vaccination',
                'hi' => 'टीकाकरण',
            ],
            'pregnancy_diagnosis' => [
                'en' => 'Pregnancy Diagnosis',
                'hi' => 'गर्भावस्था निदान',
            ],
            'artificial_insemination' => [
                'en' => 'Artificial Insemination',
                'hi' => 'कृत्रिम गर्भाधान',
            ],
            'calving' => [
                'en' => 'Calving',
                'hi' => 'बछड़ा जनन',
            ],
        ];
    }

    /**
     * Get a single service label by key and language.
     */
    public static function getServiceLabel(?string $serviceKey, ?string $lang = 'en'): string
    {
        if (empty($serviceKey)) {
            return '';
        }

        $labels = self::getServiceLabels();
        $lang   = $lang ?: 'en';

        return $labels[$serviceKey][$lang] ?? $labels[$serviceKey]['en'] ?? $serviceKey;
    }

    /**
     * Get the service list.
     */
    public static function getServiceList(): array
    {
        return [
            ['value' => 'health_medical_checkip', 'label' => 'स्वास्थ्य/चिकित्सा जांच'],
            ['value' => 'animal_insurance', 'label' => 'पशु बीमा'],
            ['value' => 'vaccination', 'label' => 'टीकाकरण'],
            ['value' => 'pregnancy_diagnosis', 'label' => 'गर्भावस्था निदान'],
            ['value' => 'artificial_insemination', 'label' => 'कृत्रिम गर्भाधान'],
            ['value' => 'livestock_insurance', 'label' => 'पशुधन बीमा'],
            ['value' => 'calving', 'label' => 'बछड़ा जनन'],
        ];
    }

    /**
     * Get all service statuses.
     */
    public static function getServiceStatus(): array
    {
        return [
            '0' => ['en' => 'Accepted', 'hi' => 'स्वीकार'],
            '1' => ['en' => 'New',      'hi' => 'नया'],
            '2' => ['en' => 'Waiting',  'hi' => 'इंतज़ार'],
            '3' => ['en' => 'Rejected', 'hi' => 'अस्वीकार'],
        ];
    }

    /**
     * Get a single service status label.
     */
    public static function getServiceStatusLabel($status, $lang = 'en'): string
    {
        $status = (string) $status;
        $labels = self::getServiceStatus();

        if (! isset($labels[$status])) {
            return $status;
        }

        return $labels[$status][$lang] ?? $labels[$status]['en'] ?? $status;
    }

    /**
     * Get yielding animal(s).
     */
    public static function getYeildingAnimal($value = null)
    {
        $data = [
            'buffalo' => 'भैंस',
            'cow'     => 'गाय',
            'goat'    => 'बकरी',
            'horse'   => 'घोड़ा',
        ];

        if ($value === null) {
            return $data;
        }

        return $data[$value] ?? null;
    }

    /**
     * Get species semen data.
     */
    public static function getSpeciesSemen($value = null)
    {
        $data = [
            'cow'     => 'गाय',
            'buffalo' => 'भैंस',
            'goat'    => 'बकरी',
        ];

        if ($value === null) {
            return $data;
        }

        return $data[$value] ?? null;
    }

    /**
     * Get semen type data.
     */
    public static function getSemenType($value = null)
    {
        $data = [
            'conventional' => 'सामान्य',
            'sexed'        => 'वर्गीकृत',
        ];

        if ($value === null) {
            return $data;
        }

        return $data[$value] ?? null;
    }

    /**
     * Get semen source data.
     */
    public static function getSemenSource($value = null)
    {
        $data = [
            'UPLDB'          => 'यूपीएलडीबी',
            'BAIF'           => 'बीएआईएफ़',
            'ABC Salon'      => 'एबीसी सैलून',
            'Amul'           => 'अमूल',
            'Haryana'        => 'हरियाणा',
            'Hissar Bovine'  => 'हिसार गोजातीय',
            'Morna Breeding' => 'मोरना प्रजनन',
            'others'         => 'अन्य',
        ];

        if ($value === null) {
            return $data;
        }

        return $data[$value] ?? null;
    }

    /**
     * Get complaint data.
     */
    public static function getAnyComplaint($value = null)
    {
        $data = [
            'स्ट्रॉ से संबंधित'           => 'Related to Straws',
            'तरल नाइट्रोजन से संबंधित'   => 'Related to Liquid Nitrogen',
            'कंटेनर से संबंधित'          => 'Related to Container',
            'भारत पशुधन आईडी से संबंधित' => 'Related to Bharat Pashudhan ID',
            'प्रोत्साहन राशि से संबंधित' => 'Related to Incentive amount',
            'बीमा से संबंधित'            => 'Related to Insurance',
        ];

        if ($value === null) {
            return $data;
        }

        return $data[$value] ?? null;
    }
}