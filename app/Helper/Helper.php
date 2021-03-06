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
    static function dataResponse($data, $total, Array $filters)
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
            "segments.delete",
            "segments.show",
            "questions.index",
            "questions.store",
            "questions.update",
            "questions.delete",
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
                '??land, ??les' => 'AX',
                'Albanie' => 'AL',
                'Alg??rie' => 'DZ',
                'Allemagne' => 'DE',
                'Andorre' => 'AD',
                'Angola' => 'AO',
                'Anguilla' => 'AI',
                'Antarctique' => 'AQ',
                'Antigua-Et-Barbuda' => 'AG',
                'Arabie Saoudite' => 'SA',
                'Argentine' => 'AR',
                'Arm??nie' => 'AM',
                'Aruba' => 'AW',
                'Australie' => 'AU',
                'Autriche' => 'AT',
                'Azerba??djan' => 'AZ',
                'Bahamas' => 'BS',
                'Bahre??n' => 'BH',
                'Bangladesh' => 'BD',
                'Barbade' => 'BB',
                'B??larus' => 'BY',
                'Belgique' => 'BE',
                'Belize' => 'BZ',
                'B??nin' => 'BJ',
                'Bermudes' => 'BM',
                'Bhoutan' => 'BT',
                'Bolivie, L\'??tat Plurinational De' => 'BO',
                'Bonaire, Saint-Eustache Et Saba' => 'BQ',
                'Bosnie-Herz??govine' => 'BA',
                'Botswana' => 'BW',
                'Bouvet, ??le' => 'BV',
                'Br??sil' => 'BR',
                'Brunei Darussalam' => 'BN',
                'Bulgarie' => 'BG',
                'Burkina Faso' => 'BF',
                'Burundi' => 'BI',
                'Ca??mans, ??les' => 'KY',
                'Cambodge' => 'KH',
                'Cameroun' => 'CM',
                'Canada' => 'CA',
                'Cap-Vert' => 'CV',
                'Centrafricaine, R??publique' => 'CF',
                'Chili' => 'CL',
                'Chine' => 'CN',
                'Christmas, ??le' => 'CX',
                'Chypre' => 'CY',
                'Cocos (Keeling), ??les' => 'CC',
                'Colombie' => 'CO',
                'Comores' => 'KM',
                'Congo' => 'CG',
                'Congo, La R??publique D??mocratique Du' => 'CD',
                'Cook, ??les' => 'CK',
                'Cor??e, R??publique De' => 'KR',
                'Cor??e, R??publique Populaire D??mocratique De' => 'KP',
                'Costa Rica' => 'CR',
                'C??te D\'ivoire' => 'CI',
                'Croatie' => 'HR',
                'Cuba' => 'CU',
                'Cura??ao' => 'CW',
                'Danemark' => 'DK',
                'Djibouti' => 'DJ',
                'Dominicaine, R??publique' => 'DO',
                'Dominique' => 'DM',
                '??gypte' => 'EG',
                'El Salvador' => 'SV',
                '??mirats Arabes Unis' => 'AE',
                '??quateur' => 'EC',
                '??rythr??e' => 'ER',
                'Espagne' => 'ES',
                'Estonie' => 'EE',
                '??tats-Unis' => 'US',
                '??thiopie' => 'ET',
                'Falkland, ??les (Malvinas)' => 'FK',
                'F??ro??, ??les' => 'FO',
                'Fidji' => 'FJ',
                'Finlande' => 'FI',
                'France' => 'FR',
                'Gabon' => 'GA',
                'Gambie' => 'GM',
                'G??orgie' => 'GE',
                'G??orgie Du Sud-Et-Les ??les Sandwich Du Sud' => 'GS',
                'Ghana' => 'GH',
                'Gibraltar' => 'GI',
                'Gr??ce' => 'GR',
                'Grenade' => 'GD',
                'Groenland' => 'GL',
                'Guadeloupe' => 'GP',
                'Guam' => 'GU',
                'Guatemala' => 'GT',
                'Guernesey' => 'GG',
                'Guin??e' => 'GN',
                'Guin??e-Bissau' => 'GW',
                'Guin??e ??quatoriale' => 'GQ',
                'Guyana' => 'GY',
                'Guyane Fran??aise' => 'GF',
                'Ha??ti' => 'HT',
                'Heard-Et-??les Macdonald, ??le' => 'HM',
                'Honduras' => 'HN',
                'Hong Kong' => 'HK',
                'Hongrie' => 'HU',
                '??le De Man' => 'IM',
                '??les Mineures ??loign??es Des ??tats-Unis' => 'UM',
                '??les Vierges Britanniques' => 'VG',
                '??les Vierges Des ??tats-Unis' => 'VI',
                'Inde' => 'IN',
                'Indon??sie' => 'ID',
                'Iran, R??publique Islamique D\'' => 'IR',
                'Iraq' => 'IQ',
                'Irlande' => 'IE',
                'Islande' => 'IS',
                'Isra??l' => 'IL',
                'Italie' => 'IT',
                'Jama??que' => 'JM',
                'Japon' => 'JP',
                'Jersey' => 'JE',
                'Jordanie' => 'JO',
                'Kazakhstan' => 'KZ',
                'Kenya' => 'KE',
                'Kirghizistan' => 'KG',
                'Kiribati' => 'KI',
                'Kowe??t' => 'KW',
                'Lao, R??publique D??mocratique Populaire' => 'LA',
                'Lesotho' => 'LS',
                'Lettonie' => 'LV',
                'Liban' => 'LB',
                'Lib??ria' => 'LR',
                'Libye' => 'LY',
                'Liechtenstein' => 'LI',
                'Lituanie' => 'LT',
                'Luxembourg' => 'LU',
                'Macao' => 'MO',
                'Mac??doine, L\'ex-R??publique Yougoslave De' => 'MK',
                'Madagascar' => 'MG',
                'Malaisie' => 'MY',
                'Malawi' => 'MW',
                'Maldives' => 'MV',
                'Mali' => 'ML',
                'Malte' => 'MT',
                'Mariannes Du Nord, ??les' => 'MP',
                'Maroc' => 'MA',
                'Marshall, ??les' => 'MH',
                'Martinique' => 'MQ',
                'Maurice' => 'MU',
                'Mauritanie' => 'MR',
                'Mayotte' => 'YT',
                'Mexique' => 'MX',
                'Micron??sie, ??tats F??d??r??s De' => 'FM',
                'Moldova, R??publique De' => 'MD',
                'Monaco' => 'MC',
                'Mongolie' => 'MN',
                'Mont??n??gro' => 'ME',
                'Montserrat' => 'MS',
                'Mozambique' => 'MZ',
                'Myanmar' => 'MM',
                'Namibie' => 'NA',
                'Nauru' => 'NR',
                'N??pal' => 'NP',
                'Nicaragua' => 'NI',
                'Niger' => 'NE',
                'Nig??ria' => 'NG',
                'Niu??' => 'NU',
                'Norfolk, ??le' => 'NF',
                'Norv??ge' => 'NO',
                'Nouvelle-Cal??donie' => 'NC',
                'Nouvelle-Z??lande' => 'NZ',
                'Oc??an Indien, Territoire Britannique De L\'' => 'IO',
                'Oman' => 'OM',
                'Ouganda' => 'UG',
                'Ouzb??kistan' => 'UZ',
                'Pakistan' => 'PK',
                'Palaos' => 'PW',
                'Palestinien Occup??, Territoire' => 'PS',
                'Panama' => 'PA',
                'Papouasie-Nouvelle-Guin??e' => 'PG',
                'Paraguay' => 'PY',
                'Pays-Bas' => 'NL',
                'P??rou' => 'PE',
                'Philippines' => 'PH',
                'Pitcairn' => 'PN',
                'Pologne' => 'PL',
                'Polyn??sie Fran??aise' => 'PF',
                'Porto Rico' => 'PR',
                'Portugal' => 'PT',
                'Qatar' => 'QA',
                'R??union' => 'RE',
                'Roumanie' => 'RO',
                'Royaume-Uni' => 'GB',
                'Russie, F??d??ration De' => 'RU',
                'Rwanda' => 'RW',
                'Sahara Occidental' => 'EH',
                'Saint-Barth??lemy' => 'BL',
                'Sainte-H??l??ne, Ascension Et Tristan Da Cunha' => 'SH',
                'Sainte-Lucie' => 'LC',
                'Saint-Kitts-Et-Nevis' => 'KN',
                'Saint-Marin' => 'SM',
                'Saint-Martin(Partie Fran??aise)' => 'MF',
                'Saint-Martin (Partie N??erlandaise)' => 'SX',
                'Saint-Pierre-Et-Miquelon' => 'PM',
                'Saint-Si??ge (??tat De La Cit?? Du Vatican)' => 'VA',
                'Saint-Vincent-Et-Les Grenadines' => 'VC',
                'Salomon, ??les' => 'SB',
                'Samoa' => 'WS',
                'Samoa Am??ricaines' => 'AS',
                'Sao Tom??-Et-Principe' => 'ST',
                'S??n??gal' => 'SN',
                'Serbie' => 'RS',
                'Seychelles' => 'SC',
                'Sierra Leone' => 'SL',
                'Singapour' => 'SG',
                'Slovaquie' => 'SK',
                'Slov??nie' => 'SI',
                'Somalie' => 'SO',
                'Soudan' => 'SD',
                'Soudan Du Sud' => 'SS',
                'Sri Lanka' => 'LK',
                'Su??de' => 'SE',
                'Suisse' => 'CH',
                'Suriname' => 'SR',
                'Svalbard Et ??le Jan Mayen' => 'SJ',
                'Swaziland' => 'SZ',
                'Syrienne, R??publique Arabe' => 'SY',
                'Tadjikistan' => 'TJ',
                'Ta??wan, Province De Chine' => 'TW',
                'Tanzanie, R??publique-Unie De' => 'TZ',
                'Tchad' => 'TD',
                'Tch??que, R??publique' => 'CZ',
                'Terres Australes Fran??aises' => 'TF',
                'Tha??lande' => 'TH',
                'Timor-Leste' => 'TL',
                'Togo' => 'TG',
                'Tokelau' => 'TK',
                'Tonga' => 'TO',
                'Trinit??-Et-Tobago' => 'TT',
                'Tunisie' => 'TN',
                'Turkm??nistan' => 'TM',
                'Turks-Et-Ca??cos, ??les' => 'TC',
                'Turquie' => 'TR',
                'Tuvalu' => 'TV',
                'Ukraine' => 'UA',
                'Uruguay' => 'UY',
                'Vanuatu' => 'VU',
                'Venezuela R??publique Bolivarienne Du' => 'VE',
                'Viet Nam' => 'VN',
                'Wallis Et Futuna' => 'WF',
                'Y??men' => 'YE',
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
