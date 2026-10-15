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
            'buffalo' => ['en' => 'buffalo', 'hi' => 'भैंस'],
            'cow'     => ['en' => 'cow',     'hi' => 'गाय'],
            'goat'    => ['en' => 'goat',    'hi' => 'बकरी'],
            'horse'   => ['en' => 'horse',   'hi' => 'घोड़ा'],
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
            'cow'     => ['en' => 'cow',     'hi' => 'गाय'],
            'buffalo' => ['en' => 'buffalo', 'hi' => 'भैंस'],
            'goat'    => ['en' => 'goat',    'hi' => 'बकरी'],
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
            'conventional' => ['en' => 'conventional', 'hi' => 'सामान्य'],
            'sexed'        => ['en' => 'sexed',        'hi' => 'वर्गीकृत'],
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
            'UPLDB'          => ['en' => 'UPLDB',          'hi' => 'यूपीएलडीबी'],
            'BAIF'           => ['en' => 'BAIF',           'hi' => 'बीएआईएफ़'],
            'ABC Salon'      => ['en' => 'ABC Salon',      'hi' => 'एबीसी सैलून'],
            'Amul'           => ['en' => 'Amul',           'hi' => 'अमूल'],
            'Haryana'        => ['en' => 'Haryana',        'hi' => 'हरियाणा'],
            'Hissar Bovine'  => ['en' => 'Hissar Bovine',  'hi' => 'हिसार गोजातीय'],
            'Morna Breeding' => ['en' => 'Morna Breeding', 'hi' => 'मोरना प्रजनन'],
            'others'         => ['en' => 'others',         'hi' => 'अन्य'],
        ];

        if ($value === null) {
            return $data;
        }

        return $data[$value] ?? null;
    }

    public static function getAnyComplaint($value = null)
    {
        $data = [
            'straws'    => ['en' => 'Related to Straws',             'hi' => 'स्ट्रॉ से संबंधित'],
            'nitrogen'  => ['en' => 'Related to Liquid Nitrogen',    'hi' => 'तरल नाइट्रोजन से संबंधित'],
            'container' => ['en' => 'Related to Container',          'hi' => 'कंटेनर से संबंधित'],
            'bharat_id' => ['en' => 'Related to Bharat Pashudhan ID','hi' => 'भारत पशुधन आईडी से संबंधित'],
            'incentive' => ['en' => 'Related to Incentive amount',   'hi' => 'प्रोत्साहन राशि से संबंधित'],
            'insurance' => ['en' => 'Related to Insurance',          'hi' => 'बीमा से संबंधित'],
        ];

        if ($value === null) {
            return $data;
        }

        return $data[$value] ?? null;
    }

    private static function toOptions(array $data): array
    {
        $options = [];
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $options[] = [
                    'eng' => $value['en'] ?? (string) $key,
                    'hi'  => $value['hi'] ?? '',
                ];
            } else {
                $options[] = [
                    'eng' => (string) $key,
                    'hi'  => (string) $value,
                ];
            }
        }
        return $options;
    }

    public static function getYeildingAnimalOptions(): array
    {
        return self::toOptions(self::getYeildingAnimal());
    }

    public static function getSpeciesSemenOptions(): array
    {
        return self::toOptions(self::getSpeciesSemen());
    }

    public static function getSemenTypeOptions(): array
    {
        return self::toOptions(self::getSemenType());
    }

    public static function getSemenSourceOptions(): array
    {
        return self::toOptions(self::getSemenSource());
    }

    public static function getAnyComplaintOptions(): array
    {
        return self::toOptions(self::getAnyComplaint());
    }

    public static function getStatusOptions(): array
    {
        $options = [];
        foreach (self::getServiceStatus() as $id => $labels) {
            $options[] = [
                'id'  => (string) $id,
                'eng' => $labels['en'] ?? '',
                'hi'  => $labels['hi'] ?? '',
            ];
        }
        return $options;
    }
}