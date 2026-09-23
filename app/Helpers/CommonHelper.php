<?php

if (! function_exists('getServiceLabels')) {
    function getServiceLabels(): array
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
}

if (! function_exists('getServiceLabel')) {
    function getServiceLabel(?string $serviceKey, ?string $lang = 'en'): string
    {
        if (empty($serviceKey)) {
            return '';
        }

        $labels = getServiceLabels();
        $lang   = $lang ?: 'en';

        return $labels[$serviceKey][$lang] ?? $labels[$serviceKey]['en'] ?? $serviceKey;
    }
}

if(!function_exists("getServiceList")) {
    function getServiceList() :array {
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
}


if (! function_exists('getServiceStatus')) {
    function getServiceStatus(): array
    {
        return [
            '0' => ['en' => 'Accepted', 'hi' => 'स्वीकार'],
            '1' => ['en' => 'New',      'hi' => 'नया'],
            '2' => ['en' => 'Waiting',  'hi' => 'इंतज़ार'],
            '3' => ['en' => 'Rejected', 'hi' => 'अस्वीकार'],
        ];
    }
}

if (! function_exists('getServiceStatusLabel')) {
    function getServiceStatusLabel($status, $lang = 'en'): string
    {
        $status = (string) $status;
        $labels = getServiceStatus();

        if (! isset($labels[$status])) {
            return $status;
        }

        return $labels[$status][$lang] ?? $labels[$status]['en'] ?? $status;
    }
}

if (! function_exists('getYeildingAnimal')) {
    function getYeildingAnimal($value = null)
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
}