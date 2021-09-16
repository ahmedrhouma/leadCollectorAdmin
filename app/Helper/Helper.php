<?php


namespace App\Helper;


use App\Models\Logs;
use DateTimeImmutable;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;

class Helper
{
    /**
     * @param $action
     * @param $element
     * @param $element_id
     */
    static function addLog($action, $element, $element_id)
    {
        Logs::create(["action" => $action, "element" => $element, "access_id" => \Session::get('accessKey_id'), "element_id" => $element_id]);
    }

    /**
     * @param array $data
     * @param Int $total
     * @param array $filters
     * @return \Illuminate\Http\Response
     */
    static function dataResponse(Array $data, $total, Array $filters)
    {
        return response()->json([
            'code' => 'success',
            'data' => $data,
            "meta" => [
                "total" => $total,
                "links" => "",
                "filters" => $filters
            ]
        ], 200);
    }

    /**
     * @param $name
     * @param $element
     * @return \Illuminate\Http\Response
     */
    static function createdResponse($name, $element)
    {
        return response()->json([
            'code' => "Success",
            'message' => "$name created successfully",
            'data' => $element
        ], 201);
    }

    /**
     * @param array $details
     * @return \Illuminate\Http\Response
     */
    static function errorResponse(Array $details)
    {
        return response()->json([
            'code' => "Error",
            'message' => "Required fields not filled or formats not recognized !",
            'details' => $details
        ], 400);
    }

    /**
     * @param String $name
     * @return \Illuminate\Http\Response
     */
    static function createErrorResponse($name)
    {
        return response()->json([
            'code' => "Error",
            'message' => "Unexpected error, the $name has not been created."
        ], 500);
    }

    /**
     * @param String $name
     * @return \Illuminate\Http\Response
     */
    static function updatedResponse($name, $element)
    {
        return response()->json([
            'code' => "Success",
            'message' => "$name updated successfully.",
            'data' => $element
        ], 200);
    }

    /**
     * @param String $name
     * @return \Illuminate\Http\Response
     */
    static function updatedErrorResponse($name)
    {
        return response()->json([
            'code' => "Error",
            'message' => "Failed to update $name : Nothing to update."
        ], 400);
    }

    /**
     * @param String $name
     * @return \Illuminate\Http\Response
     */
    static function deleteResponse($name)
    {
        return response()->json([
            'code' => "Success",
            'message' => "$name deleted successfully"
        ], 200);
    }

    /**
     * Create token of account
     * @param $account
     * @return string
     * @throws \Exception
     */
    static function generateToken($account)
    {
        $configuration = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::base64Encoded('mBC5v1sOKVvbdEitdSBenu59nfNfhwkedkJVNabosTw=')
        );
        $now = new DateTimeImmutable();
        $token = $configuration->builder()
            ->issuedAt($now)
            ->withClaim('uid', $account->id)
            ->getToken($configuration->signer(), $configuration->signingKey());
        return $token->toString();
    }

    /**
     * @param String $gender
     * @return int
     */
    static function getGender($gender)
    {
        switch ($gender) {
            case "male":
                return 1;
                break;
            case "female":
                return 2;
                break;
            default:
                return 0;
                break;
        }
    }

    /**
     * Default scopes for users
     * @return string
     */
    static function getAccountScopes()
    {
        return json_encode([
            "contacts.addToSegment",
            "contacts.deleteFromSegment",
            "contacts.index",
            "contacts.store",
            "contacts.update",
            "contacts.show",
            "accessKeys.store",
            "accessKeys.show",
            "accounts.show",
            "accounts.update",
            "authorizations.index",
            "fields.index",
            "fields.store",
            "fields.destroy",
            "fields.update",
            "forms.index",
            "forms.store",
            "forms.destroy",
            "forms.update",
            "forms.show",
            "logs.index",
            "medias.index",
            "messages.index",
            "profiles.index",
            "profiles.store",
            "profiles.destroy",
            "profiles.update",
            "requests.index",
            "responders.index",
            "responders.store",
            "responders.update",
            "responders.show",
            "segments.index",
            "segments.store",
            "segments.update",
            "segments.show",
        ]);
    }

    /**
     * Default scopes for users
     * @return array
     */
    static function getViewScopes()
    {
        return [
            "contacts" => [
                "Add to segment" =>"contacts.addToSegment",
                "Delete from segment" =>"contacts.deleteFromSegment",
                "List" =>"contacts.index",
                "Add" =>"contacts.store",
                "Update" =>"contacts.update",
                "Show" =>"contacts.show"
            ],
            "accessKeys" => [
                "Add" =>"accessKeys.store",
                "Show" =>"accessKeys.show"
            ],
            "accounts" => [
                "Show" =>"accounts.show",
                "Update" =>"accounts.update",
            ],
            "authorizations" => [
                "List" => "authorizations.index",
            ],
            "fields" => [
                "List" =>"fields.index",
                "Add" =>"fields.store",
                "Delete" =>"fields.destroy",
                "Update" =>"fields.update",
            ],
            "forms" => [
                "List" =>"forms.index",
                "Add" =>"forms.store",
                "Destroy" =>"forms.destroy",
                "Update" =>"forms.update",
                "Show" =>"forms.show",
            ],
            "logs" => [
                "List" =>"logs.index",
            ],
            "medias" => [
                "List" =>"medias.index",
            ],
            "messages" => [
                "List" =>"messages.index",
            ],
            "profiles" => [
                "List" =>"profiles.index",
                "Add" =>"profiles.store",
                "Delete" =>"profiles.destroy",
                "Update" =>"profiles.update",
            ],
            "requests" => [
                "List" => "requests.index",
            ],
            "responders" => [
                "List" =>"responders.index",
                "Add" =>"responders.store",
                "Update" =>"responders.update",
                "Show" =>"responders.show",
            ],
            "segments" => [
                "List" =>"segments.index",
                "Add" =>"segments.store",
                "Update" =>"segments.update",
                "Show" =>"segments.show",
            ]
        ];
    }

    static function getCountries($filter = null)
    {
        $countries = array(
            "EN" => [
                'Afghanistan' => 'AF',
                'Aland Islands' => 'AX',
                'Albania' => 'AL',
                'Algeria' => 'DZ',
                'American Samoa' => 'AS',
                'Andorra' => 'AD',
                'Angola' => 'AO',
                'Anguilla' => 'AI',
                'Antarctica' => 'AQ',
                'Antigua And Barbuda' => 'AG',
                'Argentina' => 'AR',
                'Armenia' => 'AM',
                'Aruba' => 'AW',
                'Australia' => 'AU',
                'Austria' => 'AT',
                'Azerbaijan' => 'AZ',
                'Bahamas' => 'BS',
                'Bahrain' => 'BH',
                'Bangladesh' => 'BD',
                'Barbados' => 'BB',
                'Belarus' => 'BY',
                'Belgium' => 'BE',
                'Belize' => 'BZ',
                'Benin' => 'BJ',
                'Bermuda' => 'BM',
                'Bhutan' => 'BT',
                'Bolivia' => 'BO',
                'Bosnia And Herzegovina' => 'BA',
                'Botswana' => 'BW',
                'Bouvet Island' => 'BV',
                'Brazil' => 'BR',
                'British Indian Ocean Territory' => 'IO',
                'Brunei Darussalam' => 'BN',
                'Bulgaria' => 'BG',
                'Burkina Faso' => 'BF',
                'Burundi' => 'BI',
                'Cambodia' => 'KH',
                'Cameroon' => 'CM',
                'Canada' => 'CA',
                'Cape Verde' => 'CV',
                'Cayman Islands' => 'KY',
                'Central African Republic' => 'CF',
                'Chad' => 'TD',
                'Chile' => 'CL',
                'China' => 'CN',
                'Christmas Island' => 'CX',
                'Cocos (Keeling) Islands' => 'CC',
                'Colombia' => 'CO',
                'Comoros' => 'KM',
                'Congo' => 'CG',
                'Congo, Democratic Republic' => 'CD',
                'Cook Islands' => 'CK',
                'Costa Rica' => 'CR',
                'Cote D\'Ivoire' => 'CI',
                'Croatia' => 'HR',
                'Cuba' => 'CU',
                'Cyprus' => 'CY',
                'Czech Republic' => 'CZ',
                'Denmark' => 'DK',
                'Djibouti' => 'DJ',
                'Dominica' => 'DM',
                'Dominican Republic' => 'DO',
                'Ecuador' => 'EC',
                'Egypt' => 'EG',
                'El Salvador' => 'SV',
                'Equatorial Guinea' => 'GQ',
                'Eritrea' => 'ER',
                'Estonia' => 'EE',
                'Ethiopia' => 'ET',
                'Falkland Islands (Malvinas)' => 'FK',
                'Faroe Islands' => 'FO',
                'Fiji' => 'FJ',
                'Finland' => 'FI',
                'France' => 'FR',
                'French Guiana' => 'GF',
                'French Polynesia' => 'PF',
                'French Southern Territories' => 'TF',
                'Gabon' => 'GA',
                'Gambia' => 'GM',
                'Georgia' => 'GE',
                'Germany' => 'DE',
                'Ghana' => 'GH',
                'Gibraltar' => 'GI',
                'Greece' => 'GR',
                'Greenland' => 'GL',
                'Grenada' => 'GD',
                'Guadeloupe' => 'GP',
                'Guam' => 'GU',
                'Guatemala' => 'GT',
                'Guernsey' => 'GG',
                'Guinea' => 'GN',
                'Guinea-Bissau' => 'GW',
                'Guyana' => 'GY',
                'Haiti' => 'HT',
                'Heard Island & Mcdonald Islands' => 'HM',
                'Holy See (Vatican City State)' => 'VA',
                'Honduras' => 'HN',
                'Hong Kong' => 'HK',
                'Hungary' => 'HU',
                'Iceland' => 'IS',
                'India' => 'IN',
                'Indonesia' => 'ID',
                'Iran, Islamic Republic Of' => 'IR',
                'Iraq' => 'IQ',
                'Ireland' => 'IE',
                'Isle Of Man' => 'IM',
                'Israel' => 'IL',
                'Italy' => 'IT',
                'Jamaica' => 'JM',
                'Japan' => 'JP',
                'Jersey' => 'JE',
                'Jordan' => 'JO',
                'Kazakhstan' => 'KZ',
                'Kenya' => 'KE',
                'Kiribati' => 'KI',
                'Korea' => 'KR',
                'Kuwait' => 'KW',
                'Kyrgyzstan' => 'KG',
                'Lao People\'s Democratic Republic' => 'LA',
                'Latvia' => 'LV',
                'Lebanon' => 'LB',
                'Lesotho' => 'LS',
                'Liberia' => 'LR',
                'Libyan Arab Jamahiriya' => 'LY',
                'Liechtenstein' => 'LI',
                'Lithuania' => 'LT',
                'Luxembourg' => 'LU',
                'Macao' => 'MO',
                'Macedonia' => 'MK',
                'Madagascar' => 'MG',
                'Malawi' => 'MW',
                'Malaysia' => 'MY',
                'Maldives' => 'MV',
                'Mali' => 'ML',
                'Malta' => 'MT',
                'Marshall Islands' => 'MH',
                'Martinique' => 'MQ',
                'Mauritania' => 'MR',
                'Mauritius' => 'MU',
                'Mayotte' => 'YT',
                'Mexico' => 'MX',
                'Micronesia, Federated States Of' => 'FM',
                'Moldova' => 'MD',
                'Monaco' => 'MC',
                'Mongolia' => 'MN',
                'Montenegro' => 'ME',
                'Montserrat' => 'MS',
                'Morocco' => 'MA',
                'Mozambique' => 'MZ',
                'Myanmar' => 'MM',
                'Namibia' => 'NA',
                'Nauru' => 'NR',
                'Nepal' => 'NP',
                'Netherlands' => 'NL',
                'Netherlands Antilles' => 'AN',
                'New Caledonia' => 'NC',
                'New Zealand' => 'NZ',
                'Nicaragua' => 'NI',
                'Niger' => 'NE',
                'Nigeria' => 'NG',
                'Niue' => 'NU',
                'Norfolk Island' => 'NF',
                'Northern Mariana Islands' => 'MP',
                'Norway' => 'NO',
                'Oman' => 'OM',
                'Pakistan' => 'PK',
                'Palau' => 'PW',
                'Palestinian Territory, Occupied' => 'PS',
                'Panama' => 'PA',
                'Papua New Guinea' => 'PG',
                'Paraguay' => 'PY',
                'Peru' => 'PE',
                'Philippines' => 'PH',
                'Pitcairn' => 'PN',
                'Poland' => 'PL',
                'Portugal' => 'PT',
                'Puerto Rico' => 'PR',
                'Qatar' => 'QA',
                'Reunion' => 'RE',
                'Romania' => 'RO',
                'Russian Federation' => 'RU',
                'Rwanda' => 'RW',
                'Saint Barthelemy' => 'BL',
                'Saint Helena' => 'SH',
                'Saint Kitts And Nevis' => 'KN',
                'Saint Lucia' => 'LC',
                'Saint Martin' => 'MF',
                'Saint Pierre And Miquelon' => 'PM',
                'Saint Vincent And Grenadines' => 'VC',
                'Samoa' => 'WS',
                'San Marino' => 'SM',
                'Sao Tome And Principe' => 'ST',
                'Saudi Arabia' => 'SA',
                'Senegal' => 'SN',
                'Serbia' => 'RS',
                'Seychelles' => 'SC',
                'Sierra Leone' => 'SL',
                'Singapore' => 'SG',
                'Slovakia' => 'SK',
                'Slovenia' => 'SI',
                'Solomon Islands' => 'SB',
                'Somalia' => 'SO',
                'South Africa' => 'ZA',
                'South Georgia And Sandwich Isl.' => 'GS',
                'Spain' => 'ES',
                'Sri Lanka' => 'LK',
                'Sudan' => 'SD',
                'Suriname' => 'SR',
                'Svalbard And Jan Mayen' => 'SJ',
                'Swaziland' => 'SZ',
                'Sweden' => 'SE',
                'Switzerland' => 'CH',
                'Syrian Arab Republic' => 'SY',
                'Taiwan' => 'TW',
                'Tajikistan' => 'TJ',
                'Tanzania' => 'TZ',
                'Thailand' => 'TH',
                'Timor-Leste' => 'TL',
                'Togo' => 'TG',
                'Tokelau' => 'TK',
                'Tonga' => 'TO',
                'Trinidad And Tobago' => 'TT',
                'Tunisia' => 'TN',
                'Turkey' => 'TR',
                'Turkmenistan' => 'TM',
                'Turks And Caicos Islands' => 'TC',
                'Tuvalu' => 'TV',
                'Uganda' => 'UG',
                'Ukraine' => 'UA',
                'United Arab Emirates' => 'AE',
                'United Kingdom' => 'GB',
                'United States' => 'US',
                'United States Outlying Islands' => 'UM',
                'Uruguay' => 'UY',
                'Uzbekistan' => 'UZ',
                'Vanuatu' => 'VU',
                'Venezuela' => 'VE',
                'Viet Nam' => 'VN',
                'Virgin Islands, British' => 'VG',
                'Virgin Islands, U.S.' => 'VI',
                'Wallis And Futuna' => 'WF',
                'Western Sahara' => 'EH',
                'Yemen' => 'YE',
                'Zambia' => 'ZM',
                'Zimbabwe' => 'ZW',
            ],
            "FR" => [
                'Afghanistan' => 'AF',
                'Afrique Du Sud' => 'ZA',
                'Åland, Îles' => 'AX',
                'Albanie' => 'AL',
                'Algérie' => 'DZ',
                'Allemagne' => 'DE',
                'Andorre' => 'AD',
                'Angola' => 'AO',
                'Anguilla' => 'AI',
                'Antarctique' => 'AQ',
                'Antigua-Et-Barbuda' => 'AG',
                'Arabie Saoudite' => 'SA',
                'Argentine' => 'AR',
                'Arménie' => 'AM',
                'Aruba' => 'AW',
                'Australie' => 'AU',
                'Autriche' => 'AT',
                'Azerbaïdjan' => 'AZ',
                'Bahamas' => 'BS',
                'Bahreïn' => 'BH',
                'Bangladesh' => 'BD',
                'Barbade' => 'BB',
                'Bélarus' => 'BY',
                'Belgique' => 'BE',
                'Belize' => 'BZ',
                'Bénin' => 'BJ',
                'Bermudes' => 'BM',
                'Bhoutan' => 'BT',
                'Bolivie, L\'état Plurinational De' => 'BO',
                'Bonaire, Saint-Eustache Et Saba' => 'BQ',
                'Bosnie-Herzégovine' => 'BA',
                'Botswana' => 'BW',
                'Bouvet, Île' => 'BV',
                'Brésil' => 'BR',
                'Brunei Darussalam' => 'BN',
                'Bulgarie' => 'BG',
                'Burkina Faso' => 'BF',
                'Burundi' => 'BI',
                'Caïmans, Îles' => 'KY',
                'Cambodge' => 'KH',
                'Cameroun' => 'CM',
                'Canada' => 'CA',
                'Cap-Vert' => 'CV',
                'Centrafricaine, République' => 'CF',
                'Chili' => 'CL',
                'Chine' => 'CN',
                'Christmas, Île' => 'CX',
                'Chypre' => 'CY',
                'Cocos (Keeling), Îles' => 'CC',
                'Colombie' => 'CO',
                'Comores' => 'KM',
                'Congo' => 'CG',
                'Congo, La République Démocratique Du' => 'CD',
                'Cook, Îles' => 'CK',
                'Corée, République De' => 'KR',
                'Corée, République Populaire Démocratique De' => 'KP',
                'Costa Rica' => 'CR',
                'Côte D\'ivoire' => 'CI',
                'Croatie' => 'HR',
                'Cuba' => 'CU',
                'Curaçao' => 'CW',
                'Danemark' => 'DK',
                'Djibouti' => 'DJ',
                'Dominicaine, République' => 'DO',
                'Dominique' => 'DM',
                'Égypte' => 'EG',
                'El Salvador' => 'SV',
                'Émirats Arabes Unis' => 'AE',
                'Équateur' => 'EC',
                'Érythrée' => 'ER',
                'Espagne' => 'ES',
                'Estonie' => 'EE',
                'États-Unis' => 'US',
                'Éthiopie' => 'ET',
                'Falkland, Îles (Malvinas)' => 'FK',
                'Féroé, Îles' => 'FO',
                'Fidji' => 'FJ',
                'Finlande' => 'FI',
                'France' => 'FR',
                'Gabon' => 'GA',
                'Gambie' => 'GM',
                'Géorgie' => 'GE',
                'Géorgie Du Sud-Et-Les Îles Sandwich Du Sud' => 'GS',
                'Ghana' => 'GH',
                'Gibraltar' => 'GI',
                'Grèce' => 'GR',
                'Grenade' => 'GD',
                'Groenland' => 'GL',
                'Guadeloupe' => 'GP',
                'Guam' => 'GU',
                'Guatemala' => 'GT',
                'Guernesey' => 'GG',
                'Guinée' => 'GN',
                'Guinée-Bissau' => 'GW',
                'Guinée Équatoriale' => 'GQ',
                'Guyana' => 'GY',
                'Guyane Française' => 'GF',
                'Haïti' => 'HT',
                'Heard-Et-Îles Macdonald, Île' => 'HM',
                'Honduras' => 'HN',
                'Hong Kong' => 'HK',
                'Hongrie' => 'HU',
                'Île De Man' => 'IM',
                'Îles Mineures Éloignées Des États-Unis' => 'UM',
                'Îles Vierges Britanniques' => 'VG',
                'Îles Vierges Des États-Unis' => 'VI',
                'Inde' => 'IN',
                'Indonésie' => 'ID',
                'Iran, République Islamique D\'' => 'IR',
                'Iraq' => 'IQ',
                'Irlande' => 'IE',
                'Islande' => 'IS',
                'Israël' => 'IL',
                'Italie' => 'IT',
                'Jamaïque' => 'JM',
                'Japon' => 'JP',
                'Jersey' => 'JE',
                'Jordanie' => 'JO',
                'Kazakhstan' => 'KZ',
                'Kenya' => 'KE',
                'Kirghizistan' => 'KG',
                'Kiribati' => 'KI',
                'Koweït' => 'KW',
                'Lao, République Démocratique Populaire' => 'LA',
                'Lesotho' => 'LS',
                'Lettonie' => 'LV',
                'Liban' => 'LB',
                'Libéria' => 'LR',
                'Libye' => 'LY',
                'Liechtenstein' => 'LI',
                'Lituanie' => 'LT',
                'Luxembourg' => 'LU',
                'Macao' => 'MO',
                'Macédoine, L\'ex-République Yougoslave De' => 'MK',
                'Madagascar' => 'MG',
                'Malaisie' => 'MY',
                'Malawi' => 'MW',
                'Maldives' => 'MV',
                'Mali' => 'ML',
                'Malte' => 'MT',
                'Mariannes Du Nord, Îles' => 'MP',
                'Maroc' => 'MA',
                'Marshall, Îles' => 'MH',
                'Martinique' => 'MQ',
                'Maurice' => 'MU',
                'Mauritanie' => 'MR',
                'Mayotte' => 'YT',
                'Mexique' => 'MX',
                'Micronésie, États Fédérés De' => 'FM',
                'Moldova, République De' => 'MD',
                'Monaco' => 'MC',
                'Mongolie' => 'MN',
                'Monténégro' => 'ME',
                'Montserrat' => 'MS',
                'Mozambique' => 'MZ',
                'Myanmar' => 'MM',
                'Namibie' => 'NA',
                'Nauru' => 'NR',
                'Népal' => 'NP',
                'Nicaragua' => 'NI',
                'Niger' => 'NE',
                'Nigéria' => 'NG',
                'Niué' => 'NU',
                'Norfolk, Île' => 'NF',
                'Norvège' => 'NO',
                'Nouvelle-Calédonie' => 'NC',
                'Nouvelle-Zélande' => 'NZ',
                'Océan Indien, Territoire Britannique De L\'' => 'IO',
                'Oman' => 'OM',
                'Ouganda' => 'UG',
                'Ouzbékistan' => 'UZ',
                'Pakistan' => 'PK',
                'Palaos' => 'PW',
                'Palestinien Occupé, Territoire' => 'PS',
                'Panama' => 'PA',
                'Papouasie-Nouvelle-Guinée' => 'PG',
                'Paraguay' => 'PY',
                'Pays-Bas' => 'NL',
                'Pérou' => 'PE',
                'Philippines' => 'PH',
                'Pitcairn' => 'PN',
                'Pologne' => 'PL',
                'Polynésie Française' => 'PF',
                'Porto Rico' => 'PR',
                'Portugal' => 'PT',
                'Qatar' => 'QA',
                'Réunion' => 'RE',
                'Roumanie' => 'RO',
                'Royaume-Uni' => 'GB',
                'Russie, Fédération De' => 'RU',
                'Rwanda' => 'RW',
                'Sahara Occidental' => 'EH',
                'Saint-Barthélemy' => 'BL',
                'Sainte-Hélène, Ascension Et Tristan Da Cunha' => 'SH',
                'Sainte-Lucie' => 'LC',
                'Saint-Kitts-Et-Nevis' => 'KN',
                'Saint-Marin' => 'SM',
                'Saint-Martin(Partie Française)' => 'MF',
                'Saint-Martin (Partie Néerlandaise)' => 'SX',
                'Saint-Pierre-Et-Miquelon' => 'PM',
                'Saint-Siège (État De La Cité Du Vatican)' => 'VA',
                'Saint-Vincent-Et-Les Grenadines' => 'VC',
                'Salomon, Îles' => 'SB',
                'Samoa' => 'WS',
                'Samoa Américaines' => 'AS',
                'Sao Tomé-Et-Principe' => 'ST',
                'Sénégal' => 'SN',
                'Serbie' => 'RS',
                'Seychelles' => 'SC',
                'Sierra Leone' => 'SL',
                'Singapour' => 'SG',
                'Slovaquie' => 'SK',
                'Slovénie' => 'SI',
                'Somalie' => 'SO',
                'Soudan' => 'SD',
                'Soudan Du Sud' => 'SS',
                'Sri Lanka' => 'LK',
                'Suède' => 'SE',
                'Suisse' => 'CH',
                'Suriname' => 'SR',
                'Svalbard Et Île Jan Mayen' => 'SJ',
                'Swaziland' => 'SZ',
                'Syrienne, République Arabe' => 'SY',
                'Tadjikistan' => 'TJ',
                'Taïwan, Province De Chine' => 'TW',
                'Tanzanie, République-Unie De' => 'TZ',
                'Tchad' => 'TD',
                'Tchèque, République' => 'CZ',
                'Terres Australes Françaises' => 'TF',
                'Thaïlande' => 'TH',
                'Timor-Leste' => 'TL',
                'Togo' => 'TG',
                'Tokelau' => 'TK',
                'Tonga' => 'TO',
                'Trinité-Et-Tobago' => 'TT',
                'Tunisie' => 'TN',
                'Turkménistan' => 'TM',
                'Turks-Et-Caïcos, Îles' => 'TC',
                'Turquie' => 'TR',
                'Tuvalu' => 'TV',
                'Ukraine' => 'UA',
                'Uruguay' => 'UY',
                'Vanuatu' => 'VU',
                'Venezuela République Bolivarienne Du' => 'VE',
                'Viet Nam' => 'VN',
                'Wallis Et Futuna' => 'WF',
                'Yémen' => 'YE',
                'Zambie' => 'ZM',
                'Zimbabwe' => 'ZW',
            ],
        );
        if ($filter != null) {
            return isset($countries[$filter]) ? $countries[$filter] : [];
        }
        return $countries;
    }
}
