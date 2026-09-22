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