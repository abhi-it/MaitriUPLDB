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

    public static function getAboutUsContent($value = null)
    {
        $data = [
            'en' => 'U.P. Government established Uttar Pradesh Livestock Development Board via G.O. no. 3991/12 Pa-2-98-1(20)/98, Dt. 31st October, 1998 and was registered under the Societies Registration Act 1860, Rule 21 of 1860 with the registration no. 2342/1998-99, Dt. 07.01.1999, which has now been renewed up to 07th January, 2029. Govt. of India had issued terms & conditions governing sanction No. 3-15/97-AHT, Dt. 03rd March, 1998 for implementation of Centrally Sponsored Scheme of Extension of Frozen Semen Technology (EFST) and National Bull Production Programme (NBPP) for Cattle and Buffalo Breeding during 1997-98. In this sanction there was a provision for creation of a State Level Autonomous Body, which was to be the incharge of Semen and liquid nitrogen production/procurement and sale to all agencies incharge of artificial insemination. This Body was to be formed under Societies\' Registration Act or Company registered under Companies Act. The Board is an autonomous body, being governed by the Board of Directors with Additional Chief Secretary / Principal Secretary, Animal Husbandry as the Chairman. It is headed by the Chief Executive Officer, and has a core group of professionals and limited supporting staff deployed from Animal Husbandry Department for State Implementing Agency (SIA). The basic aim of the Board is to restructure and reorient the cattle and buffalo breeding operations in the State.

    The UPLDB is working in collaboration with State Animal Husbandry Department and also in co-ordination with other agencies performing cattle and buffalo breeding activities in the State, like: Pradeshik Cooperative Dairy Federation (PCDF), Bhartiya Agro Industrial Foundation Limited (BAIF), State Agricultural Universities (SAU\'s), State Veterinary University, Indian Veterinary Research Institute (IVRI), and ICAR institutes, etc. along with other related State departments, like Department of Rural Development. This agency (SIA) is a viable entity, generating funds for meeting its establishment and other costs to keep it operational. It was the mandate of the Govt. of India that Transfer of Assets available in the form of Sperm Stations, Training Centers, State Livestock Farms, etc. from A. H. department and like-wise agencies shall be transferred completely to the Board/SIA. The SIA Head Quarters is managed by a core group of professionals and limited supporting staff to maintain the establishment cost of SIA to the barest minimum. A similar approach has been adopted by the SIA while engaging personnel in the field units. Initially the personnel are drawn from the State Department of Animal Husbandry. If suitable man power is not available, recruitment from extra departmental sources has been considered to keep the SIA functioning.

    This has ensured that there is proportionate reduction of manpower in the department while engaging of adequate qualified personnel in the SIA. The basic aim of the Board is to restructure and reorient the cattle and buffalo breeding operations in the State.',

            'hi' => 'उत्तर प्रदेश सरकार ने शासनादेश संख्या 3991/12 पा-2-98-1(20)/98, दिनांक 31 अक्टूबर, 1998 के माध्यम से उत्तर प्रदेश पशुधन विकास परिषद की स्थापना की और इसे सोसाइटी पंजीकरण अधिनियम 1860, नियम 21 के तहत पंजीकरण संख्या 2342/1998-99, दिनांक 07.01.1999 के साथ पंजीकृत किया गया था, जिसे अब 07 जनवरी, 2029 तक नवीनीकृत किया गया है। भारत सरकार ने 1997-98 के दौरान गाय और भैंस प्रजनन के लिए फ्रोजन सीमेन टेक्नोलॉजी (EFST) और नेशनल बुल प्रोडक्शन प्रोग्राम (NBPP) के कार्यान्वयन के लिए नियम और शर्तें जारी की थीं। इस मंजूरी में एक राज्य स्तरीय स्वायत्त निकाय के निर्माण का प्रावधान था, जो कृत्रिम गर्भाधान की सभी एजेंसियों को वीर्य और तरल नाइट्रोजन उत्पादन/खरीद और बिक्री का प्रभारी होगा।

    यू.पी.एल.डी.बी. राज्य पशुपालन विभाग के सहयोग से और राज्य में गाय और भैंस प्रजनन गतिविधियों को करने वाली अन्य एजेंसियों जैसे: प्रादेशिक को-ऑपरेटिव डेयरी फेडरेशन (PCDF), भारतीय एग्रो इंडस्ट्रियल फाउंडेशन लिमिटेड (BAIF), राज्य कृषि विश्वविद्यालयों (SAU\'s), राज्य पशु चिकित्सा विश्वविद्यालय, भारतीय पशु चिकित्सा अनुसंधान संस्थान (IVRI), और ICAR संस्थानों आदि के साथ-साथ ग्रामीण विकास विभाग जैसे अन्य संबंधित राज्य विभागों के समन्वय में काम कर रहा है।

    इसने विभाग में जनशक्ति की आनुपातिक कमी सुनिश्चित की है जबकि SIA में पर्याप्त योग्य कर्मियों को शामिल किया गया है। बोर्ड का मूल उद्देश्य राज्य में गाय और भैंस प्रजनन कार्यों का पुनर्गठन और पुनर्विन्यास करना है।',
        ];

        if ($value === null) {
            return $data;
        }

        return $data[$value] ?? null;
    }

    public static function getTermsAndConditions($value = null)
    {
        $hindiContent = <<<'HTML'
            राष्ट्रीय गोकुल मिशन अन्तगर्त कृत्रिम गर्भाधान आच्छादन बढाने हेतु मैत्री की स्थापना

            नियम-शर्ते निम्न प्रकार है-

            1. योग्यताः

            (क) शैक्षिक योग्यता: अनिवार्य न्यूनतम अर्हता हाईस्कूल (जीव विज्ञान) उत्तीर्ण हो। इण्टर (जीव विज्ञान) वरीयता दी जायेगी।

            (ख) आवेदक चयनित क्षेत्र की ग्राम पंचायत का निवासी हो।

            (ग) पूर्णतः स्वस्थ एवं कार्य करने के योग्य हो। पशुपालक के द्वार पर पहुॅच कर सेवा कर सके। राजकीय चिकित्साधिकारी द्वारा प्रदत्त स्वस्थ्य प्रमाण पत्र संलग्न करना अनिवार्य है।

            (घ) वोटर आई.डी. कार्ड/आधार कार्ड/पैन कार्ड की स्वप्रमाणित छाया प्रति संलग्न करना अनिवार्य है।

            (ड) Migrant Workers(प्रवासी श्रमिकों)/पशु सखि/प्रशिक्षित पैरावेट को वरीयता दी जायेगी।

            2. आवेदक की आयु दिनांक 01.12.2020 को 18 वर्ष से 40 वर्ष के मध्य हो।

            3. आवेदक पत्र जमा करने की अन्तिम तिथि:- 31.12.2020

            4. यह योजना पूर्णतः स्वरोजगार सृजन की अवधारणा पर आधारित है। आवेदक को किसी भी स्थिति में शासकीय सेवा में संविलयन का कोई अधिकार नही होगा। चयनित अभ्यर्थी को 35 दिनों का सैद्धान्तिक प्रशिक्षण एवं 55 दिनों का व्यावहारिक प्रशिक्षण कराया जायेगा। चयनित अभ्यर्थी को सफलतापूर्णक प्रशिक्षण पूर्ण करने के उपरान्त मैत्री (मल्टी परपज ए0आई0 टेक्निशियन इन रुरल इण्डिया) के रुप में कार्य करने हेतु प्रमाण-पत्र, बायोलॉजिकल कण्टेनर्स तथा ए0आई0किट आदि उपलब्ध कराये जायेगें।

            5. निर्धारित प्रारुप पर आवेदन-पत्र एवं उसके साथ शैक्षिक एवं निर्धारित अर्हताओं से सम्बन्धित प्रमाण-पत्र की स्वप्रमाणित छाया प्रतियाँ, आवेदन पत्र के साथ अपना पता लिखा एक लिफाफा (रु0 27 का डाक टिकट सहित), अनुसूचित जाति/ अनुसूचित जाति श्रेणी हेतु सक्षम स्तर द्वारा जारी जाति प्रमाण-पत्र की स्वप्रमाणित छाया प्रति संलग्न कर सम्बन्धित पशुचिकित्साधिकारी/उप मुख्य पशुचिकित्साधिकारी के कार्यालय में दिनांक 31.12.2020 सांय 5.00 बजे तक व्यक्तिगत रुप से जमा कर सकते है। संबधित पशुचिकित्साधिकारी/ उप मुख्य पशुचिकित्साधिकारी द्वारा आवेदन-पत्रों को भरने में सहायता की जायेगी।

            6. चयनित अभ्यर्थियों को चयनोपरान्त इस आशय का शपथ-पत्र देना होगा कि वे एक स्वरोजगारी के रुप में कार्य करेगें। सरकारी सेवा में किसी भी स्थिति में सविलियन का कोई अधिकार नही होगा तथा इसके लिए कभी दावा नही करेगें।

            नोट:- उ0प्र0 पशुधन विकास परिषद द्वारा जनपदवार चयन किये जाने स्वरोजगारी मैत्री (मल्टी परपज ए0आई0 टेक्निशियन इन रुरल इण्डिया) की संख्या संलग्न है।
        HTML;

        $hindiContent = str_replace("\r", "", $hindiContent);
        $hindiContent = trim($hindiContent);

        $data = [
            'en' => null,
            'hi' => $hindiContent,
        ];

        if ($value === null) {
            return $data;
        }

        return $data[$value] ?? null;
    }

}