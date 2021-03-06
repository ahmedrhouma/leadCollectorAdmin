<?php


namespace App\Helper;


class  Countries
{
    protected Static $countries = [
        "united kingdom"                               => "gb",
        "afghanistan"                                  => "af",
        "albania"                                      => "al",
        "algeria"                                      => "dz",
        "american samoa"                               => "as",
        "andorra"                                      => "ad",
        "angola"                                       => "ad",
        "anguilla"                                     => "ai",
        "antarctica"                                   => "aq",
        "antigua and barbuda"                          => "ag",
        "argentina"                                    => "ar",
        "armenia"                                      => "am",
        "aruba"                                        => "aw",
        "australia"                                    => "au",
        "austria"                                      => "at",
        "azerbaijan"                                   => "az",
        "bahamas"                                      => "bs",
        "bahrain"                                      => "bh",
        "bangladesh"                                   => "bd",
        "barbados"                                     => "bb",
        "belarus"                                      => "by",
        "belgium"                                      => "be",
        "belize"                                       => "bz",
        "benin"                                        => "bj",
        "bermuda"                                      => "bm",
        "bhutan"                                       => "bt",
        "bolivia"                                      => "bo",
        "bosnia and herzegowina"                       => "ba",
        "botswana"                                     => "bw",
        "bouvet island"                                => "bv",
        "brazil"                                       => "br",
        "british indian ocean territory"               => "io",
        "brunei darussalam"                            => "bn",
        "bulgaria"                                     => "bg",
        "burkina faso"                                 => "bf",
        "burundi"                                      => "bi",
        "cambodia"                                     => "kh",
        "cameroon"                                     => "cm",
        "canada"                                       => "ca",
        "cabo verde"                                   => "cv",
        "cayman islands"                               => "ky",
        "central african republic"                     => "cf",
        "chad"                                         => "td",
        "chile"                                        => "cl",
        "china"                                        => "cn",
        "christmas island"                             => "cx",
        "cocos (keeling) islands"                      => "cc",
        "colombia"                                     => "co",
        "comoros"                                      => "km",
        "congo"                                        => "cg",
        "congo, the democratic republic of the"        => "cd",
        "cook islands"                                 => "ck",
        "costa rica"                                   => "cr",
        "cote d'ivoire"                                => "ci",
        "croatia (hrvatska)"                           => "hr",
        "cuba"                                         => "cu",
        "cyprus"                                       => "cy",
        "czech republic"                               => "cz",
        "denmark"                                      => "dk",
        "djibouti"                                     => "dj",
        "dominica"                                     => "dm",
        "dominican republic"                           => "do",
        "east timor"                                   => "tl",
        "ecuador"                                      => "ec",
        "egypt"                                        => "eg",
        "el salvador"                                  => "sv",
        "equatorial guinea"                            => "gq",
        "eritrea"                                      => "er",
        "estonia"                                      => "ee",
        "ethiopia"                                     => "et",
        "falkland islands (malvinas)"                  => "fk",
        "faroe islands"                                => "fo",
        "fiji"                                         => "fj",
        "finland"                                      => "fi",
        "france"                                       => "fr",
        "french guiana"                                => "gf",
        "french polynesia"                             => "pf",
        "french southern territories"                  => "tf",
        "gabon"                                        => "ga",
        "gambia"                                       => "gm",
        "georgia"                                      => "ge",
        "germany"                                      => "de",
        "ghana"                                        => "gh",
        "gibraltar"                                    => "gi",
        "greece"                                       => "gr",
        "greenland"                                    => "gl",
        "grenada"                                      => "gd",
        "guadeloupe"                                   => "gp",
        "guam"                                         => "gu",
        "guatemala"                                    => "gt",
        "guinea"                                       => "gn",
        "guinea-bissau"                                => "gw",
        "guyana"                                       => "gy",
        "haiti"                                        => "ht",
        "heard and mc donald islands"                  => "hm",
        "holy see (vatican city state)"                => "va",
        "honduras"                                     => "hn",
        "hong kong"                                    => "hk",
        "hungary"                                      => "hu",
        "iceland"                                      => "is",
        "india"                                        => "in",
        "indonesia"                                    => "id",
        "iran (islamic republic of)"                   => "ir",
        "iraq"                                         => "iq",
        "ireland"                                      => "ie",
        "israel"                                       => "il",
        "italy"                                        => "it",
        "jamaica"                                      => "jm",
        "japan"                                        => "jp",
        "jordan"                                       => "jo",
        "kazakhstan"                                   => "kz",
        "kenya"                                        => "ke",
        "kiribati"                                     => "ki",
        "korea, democratic people's republic of"       => "kp",
        "korea, republic of"                           => "kr",
        "kuwait"                                       => "kw",
        "kyrgyzstan"                                   => "kg",
        "lao, people's democratic republic"            => "la",
        "latvia"                                       => "lv",
        "lebanon"                                      => "lb",
        "lesotho"                                      => "ls",
        "liberia"                                      => "lr",
        "libyan arab jamahiriya"                       => "ly",
        "liechtenstein"                                => "li",
        "lithuania"                                    => "lt",
        "luxembourg"                                   => "lu",
        "macao"                                        => "mo",
        "macedonia, the former yugoslav republic of"   => "mk",
        "madagascar"                                   => "mg",
        "malawi"                                       => "mw",
        "malaysia"                                     => "my",
        "maldives"                                     => "mv",
        "mali"                                         => "ml",
        "malta"                                        => "mt",
        "marshall islands"                             => "mh",
        "martinique"                                   => "mq",
        "mauritania"                                   => "mr",
        "mauritius"                                    => "mu",
        "mayotte"                                      => "yt",
        "mexico"                                       => "mx",
        "micronesia, federated states of"              => "fm",
        "moldova, republic of"                         => "md",
        "monaco"                                       => "mc",
        "mongolia"                                     => "mn",
        "montserrat"                                   => "ms",
        "morocco"                                      => "ma",
        "mozambique"                                   => "mz",
        "myanmar"                                      => "mm",
        "namibia"                                      => "na",
        "nauru"                                        => "nr",
        "nepal"                                        => "np",
        "netherlands"                                  => "nl",
        "netherlands antilles"                         => "an",
        "new caledonia"                                => "nc",
        "new zealand"                                  => "nz",
        "nicaragua"                                    => "ni",
        "niger"                                        => "ne",
        "nigeria"                                      => "ng",
        "niue"                                         => "nu",
        "norfolk island"                               => "nf",
        "northern mariana islands"                     => "mp",
        "norway"                                       => "no",
        "oman"                                         => "om",
        "pakistan"                                     => "pk",
        "palau"                                        => "pw",
        "panama"                                       => "pa",
        "papua new guinea"                             => "pg",
        "paraguay"                                     => "py",
        "peru"                                         => "pe",
        "philippines"                                  => "ph",
        "pitcairn"                                     => "pn",
        "poland"                                       => "pl",
        "portugal"                                     => "pt",
        "puerto rico"                                  => "pr",
        "qatar"                                        => "qa",
        "reunion"                                      => "re",
        "romania"                                      => "ro",
        "russian federation"                           => "ru",
        "rwanda"                                       => "rw",
        "saint kitts and nevis"                        => "kn",
        "saint lucia"                                  => "lc",
        "saint vincent and the grenadines"             => "vc",
        "samoa"                                        => "ws",
        "san marino"                                   => "sm",
        "sao tome and principe"                        => "st",
        "saudi arabia"                                 => "sa",
        "senegal"                                      => "sn",
        "seychelles"                                   => "sc",
        "sierra leone"                                 => "sl",
        "singapore"                                    => "sg",
        "slovakia (slovak republic)"                   => "sk",
        "slovenia"                                     => "si",
        "solomon islands"                              => "sb",
        "somalia"                                      => "so",
        "south africa"                                 => "za",
        "south georgia and the south sandwich islands" => "gs",
        "spain"                                        => "es",
        "sri lanka"                                    => "lk",
        "st. helena"                                   => "sh",
        "st. pierre and miquelon"                      => "pm",
        "sudan"                                        => "sd",
        "suriname"                                     => "sr",
        "svalbard and jan mayen islands"               => "sj",
        "swaziland"                                    => "sz",
        "sweden"                                       => "se",
        "switzerland"                                  => "ch",
        "syrian arab republic"                         => "sy",
        "taiwan, province of china"                    => "tw",
        "tajikistan"                                   => "tj",
        "tanzania, united republic of"                 => "tz",
        "thailand"                                     => "th",
        "togo"                                         => "tg",
        "tokelau"                                      => "tk",
        "tonga"                                        => "to",
        "trinidad and tobago"                          => "tt",
        "tunisia"                                      => "tn",
        "turkey"                                       => "tr",
        "turkmenistan"                                 => "tm",
        "turks and caicos islands"                     => "tc",
        "tuvalu"                                       => "tv",
        "uganda"                                       => "ug",
        "ukraine"                                      => "ua",
        "united arab emirates"                         => "ae",
        "united kingdom"                               => "gb",
        "united states"                                => "us",
        "united states minor outlying islands"         => "um",
        "uruguay"                                      => "uy",
        "uzbekistan"                                   => "uz",
        "vanuatu"                                      => "vu",
        "venezuela"                                    => "ve",
        "vietnam"                                      => "vn",
        "virgin islands (british)"                     => "vg",
        "virgin islands (u.s.)"                        => "vi",
        "wallis and futuna islands"                    => "wf",
        "western sahara"                               => "eh",
        "yemen"                                        => "ye",
        "serbia"                                       => "yu",
        "zambia"                                       => "zm",
        "zimbabwe"                                     => "zw",
        'afghanistan' => 'af' ,
        'afrique du sud' => 'za' ,
        '??land, ??les' => 'ax' ,
        'albanie' => 'al' ,
        'alg??rie' => 'dz' ,
        'allemagne' => 'de' ,
        'andorre' => 'ad' ,
        'angola' => 'ao' ,
        'anguilla' => 'ai' ,
        'antarctique' => 'aq' ,
        'antigua-et-barbuda' => 'ag' ,
        'arabie saoudite' => 'sa' ,
        'argentine' => 'ar' ,
        'arm??nie' => 'am' ,
        'aruba' => 'aw' ,
        'australie' => 'au' ,
        'autriche' => 'at' ,
        'azerba??djan' => 'az' ,
        'bahamas' => 'bs' ,
        'bahre??n' => 'bh' ,
        'bangladesh' => 'bd' ,
        'barbade' => 'bb' ,
        'b??larus' => 'by' ,
        'belgique' => 'be' ,
        'belize' => 'bz' ,
        'b??nin' => 'bj' ,
        'bermudes' => 'bm' ,
        'bhoutan' => 'bt' ,
        'bolivie, l\'??tat plurinational de' => 'bo' ,
        'bonaire, saint-eustache et saba' => 'bq' ,
        'bosnie-herz??govine' => 'ba' ,
        'botswana' => 'bw' ,
        'bouvet, ??le' => 'bv' ,
        'br??sil' => 'br' ,
        'brunei darussalam' => 'bn' ,
        'bulgarie' => 'bg' ,
        'burkina faso' => 'bf' ,
        'burundi' => 'bi' ,
        'ca??mans, ??les' => 'ky' ,
        'cambodge' => 'kh' ,
        'cameroun' => 'cm' ,
        'canada' => 'ca' ,
        'cap-vert' => 'cv' ,
        'centrafricaine, r??publique' => 'cf' ,
        'chili' => 'cl' ,
        'chine' => 'cn' ,
        'christmas, ??le' => 'cx' ,
        'chypre' => 'cy' ,
        'cocos (keeling), ??les' => 'cc' ,
        'colombie' => 'co' ,
        'comores' => 'km' ,
        'congo' => 'cg' ,
        'congo, la r??publique d??mocratique du' => 'cd' ,
        'cook, ??les' => 'ck' ,
        'cor??e, r??publique de' => 'kr' ,
        'cor??e, r??publique populaire d??mocratique de' => 'kp' ,
        'costa rica' => 'cr' ,
        'c??te d\'ivoire' => 'ci' ,
        'croatie' => 'hr' ,
        'cuba' => 'cu' ,
        'cura??ao' => 'cw' ,
        'danemark' => 'dk' ,
        'djibouti' => 'dj' ,
        'dominicaine, r??publique' => 'do' ,
        'dominique' => 'dm' ,
        '??gypte' => 'eg' ,
        'el salvador' => 'sv' ,
        '??mirats arabes unis' => 'ae' ,
        '??quateur' => 'ec' ,
        '??rythr??e' => 'er' ,
        'espagne' => 'es' ,
        'estonie' => 'ee' ,
        '??tats-unis' => 'us' ,
        '??thiopie' => 'et' ,
        'falkland, ??les (malvinas)' => 'fk' ,
        'f??ro??, ??les' => 'fo' ,
        'fidji' => 'fj' ,
        'finlande' => 'fi' ,
        'france' => 'fr' ,
        'gabon' => 'ga' ,
        'gambie' => 'gm' ,
        'g??orgie' => 'ge' ,
        'g??orgie du sud-et-les ??les sandwich du sud' => 'gs' ,
        'ghana' => 'gh' ,
        'gibraltar' => 'gi' ,
        'gr??ce' => 'gr' ,
        'grenade' => 'gd' ,
        'groenland' => 'gl' ,
        'guadeloupe' => 'gp' ,
        'guam' => 'gu' ,
        'guatemala' => 'gt' ,
        'guernesey' => 'gg' ,
        'guin??e' => 'gn' ,
        'guin??e-bissau' => 'gw' ,
        'guin??e ??quatoriale' => 'gq' ,
        'guyana' => 'gy' ,
        'guyane fran??aise' => 'gf' ,
        'ha??ti' => 'ht' ,
        'heard-et-??les macdonald, ??le' => 'hm' ,
        'honduras' => 'hn' ,
        'hong kong' => 'hk' ,
        'hongrie' => 'hu' ,
        '??le de man' => 'im' ,
        '??les mineures ??loign??es des ??tats-unis' => 'um' ,
        '??les vierges britanniques' => 'vg' ,
        '??les vierges des ??tats-unis' => 'vi' ,
        'inde' => 'in' ,
        'indon??sie' => 'id' ,
        'iran, r??publique islamique d\'' => 'ir' ,
        'iraq' => 'iq' ,
        'irlande' => 'ie' ,
        'islande' => 'is' ,
        'isra??l' => 'il' ,
        'italie' => 'it' ,
        'jama??que' => 'jm' ,
        'japon' => 'jp' ,
        'jersey' => 'je' ,
        'jordanie' => 'jo' ,
        'kazakhstan' => 'kz' ,
        'kenya' => 'ke' ,
        'kirghizistan' => 'kg' ,
        'kiribati' => 'ki' ,
        'kowe??t' => 'kw' ,
        'lao, r??publique d??mocratique populaire' => 'la' ,
        'lesotho' => 'ls' ,
        'lettonie' => 'lv' ,
        'liban' => 'lb' ,
        'lib??ria' => 'lr' ,
        'libye' => 'ly' ,
        'liechtenstein' => 'li' ,
        'lituanie' => 'lt' ,
        'luxembourg' => 'lu' ,
        'macao' => 'mo' ,
        'mac??doine, l\'ex-r??publique yougoslave de' => 'mk' ,
        'madagascar' => 'mg' ,
        'malaisie' => 'my' ,
        'malawi' => 'mw' ,
        'maldives' => 'mv' ,
        'mali' => 'ml' ,
        'malte' => 'mt' ,
        'mariannes du nord, ??les' => 'mp' ,
        'maroc' => 'ma' ,
        'marshall, ??les' => 'mh' ,
        'martinique' => 'mq' ,
        'maurice' => 'mu' ,
        'mauritanie' => 'mr' ,
        'mayotte' => 'yt' ,
        'mexique' => 'mx' ,
        'micron??sie, ??tats f??d??r??s de' => 'fm' ,
        'moldova, r??publique de' => 'md' ,
        'monaco' => 'mc' ,
        'mongolie' => 'mn' ,
        'mont??n??gro' => 'me' ,
        'montserrat' => 'ms' ,
        'mozambique' => 'mz' ,
        'myanmar' => 'mm' ,
        'namibie' => 'na' ,
        'nauru' => 'nr' ,
        'n??pal' => 'np' ,
        'nicaragua' => 'ni' ,
        'niger' => 'ne' ,
        'nig??ria' => 'ng' ,
        'niu??' => 'nu' ,
        'norfolk, ??le' => 'nf' ,
        'norv??ge' => 'no' ,
        'nouvelle-cal??donie' => 'nc' ,
        'nouvelle-z??lande' => 'nz' ,
        'oc??an indien, territoire britannique de l\'' => 'io' ,
        'oman' => 'om' ,
        'ouganda' => 'ug' ,
        'ouzb??kistan' => 'uz' ,
        'pakistan' => 'pk' ,
        'palaos' => 'pw' ,
        'palestinien occup??, territoire' => 'ps' ,
        'panama' => 'pa' ,
        'papouasie-nouvelle-guin??e' => 'pg' ,
        'paraguay' => 'py' ,
        'pays-bas' => 'nl' ,
        'p??rou' => 'pe' ,
        'philippines' => 'ph' ,
        'pitcairn' => 'pn' ,
        'pologne' => 'pl' ,
        'polyn??sie fran??aise' => 'pf' ,
        'porto rico' => 'pr' ,
        'portugal' => 'pt' ,
        'qatar' => 'qa' ,
        'r??union' => 're' ,
        'roumanie' => 'ro' ,
        'royaume-uni' => 'gb' ,
        'russie, f??d??ration de' => 'ru' ,
        'rwanda' => 'rw' ,
        'sahara occidental' => 'eh' ,
        'saint-barth??lemy' => 'bl' ,
        'sainte-h??l??ne, ascension et tristan da cunha' => 'sh' ,
        'sainte-lucie' => 'lc' ,
        'saint-kitts-et-nevis' => 'kn' ,
        'saint-marin' => 'sm' ,
        'saint-martin(partie fran??aise)' => 'mf' ,
        'saint-martin (partie n??erlandaise)' => 'sx' ,
        'saint-pierre-et-miquelon' => 'pm' ,
        'saint-si??ge (??tat de la cit?? du vatican)' => 'va' ,
        'saint-vincent-et-les grenadines' => 'vc' ,
        'salomon, ??les' => 'sb' ,
        'samoa' => 'ws' ,
        'samoa am??ricaines' => 'as' ,
        'sao tom??-et-principe' => 'st' ,
        's??n??gal' => 'sn' ,
        'serbie' => 'rs' ,
        'seychelles' => 'sc' ,
        'sierra leone' => 'sl' ,
        'singapour' => 'sg' ,
        'slovaquie' => 'sk' ,
        'slov??nie' => 'si' ,
        'somalie' => 'so' ,
        'soudan' => 'sd' ,
        'soudan du sud' => 'ss' ,
        'sri lanka' => 'lk' ,
        'su??de' => 'se' ,
        'suisse' => 'ch' ,
        'suriname' => 'sr' ,
        'svalbard et ??le jan mayen' => 'sj' ,
        'swaziland' => 'sz' ,
        'syrienne, r??publique arabe' => 'sy' ,
        'tadjikistan' => 'tj' ,
        'ta??wan, province de chine' => 'tw' ,
        'tanzanie, r??publique-unie de' => 'tz' ,
        'tchad' => 'td' ,
        'tch??que, r??publique' => 'cz' ,
        'terres australes fran??aises' => 'tf' ,
        'tha??lande' => 'th' ,
        'timor-leste' => 'tl' ,
        'togo' => 'tg' ,
        'tokelau' => 'tk' ,
        'tonga' => 'to' ,
        'trinit??-et-tobago' => 'tt' ,
        'tunisie' => 'tn' ,
        'turkm??nistan' => 'tm' ,
        'turks-et-ca??cos, ??les' => 'tc' ,
        'turquie' => 'tr' ,
        'tuvalu' => 'tv' ,
        'ukraine' => 'ua' ,
        'uruguay' => 'uy' ,
        'vanuatu' => 'vu' ,
        'venezuela, r??publique bolivarienne du' => 've' ,
        'viet nam' => 'vn' ,
        'wallis et futuna' => 'wf' ,
        'y??men' => 'ye' ,
        'zambie' => 'zm' ,
        'zimbabwe' => 'zw' ,
    ];
    protected Static $isoCountries = [
        "gb" =>"united kingdom"                               ,
        "af" =>"afghanistan"                                  ,
        "al" =>"albania"                                      ,
        "dz" =>"algeria"                                      ,
        "as" =>"american samoa"                               ,
        "ad" =>"andorra"                                      ,
        "ad" =>"angola"                                       ,
        "ai" =>"anguilla"                                     ,
        "aq" =>"antarctica"                                   ,
        "ag" =>"antigua and barbuda"                          ,
        "ar" =>"argentina"                                    ,
        "am" =>"armenia"                                      ,
        "aw" =>"aruba"                                        ,
        "au" =>"australia"                                    ,
        "at" =>"austria"                                      ,
        "az" =>"azerbaijan"                                   ,
        "bs" =>"bahamas"                                      ,
        "bh" =>"bahrain"                                      ,
        "bd" =>"bangladesh"                                   ,
        "bb" =>"barbados"                                     ,
        "by" =>"belarus"                                      ,
        "be" =>"belgium"                                      ,
        "bz" =>"belize"                                       ,
        "bj" =>"benin"                                        ,
        "bm" =>"bermuda"                                      ,
        "bt" =>"bhutan"                                       ,
        "bo" =>"bolivia"                                      ,
        "ba" =>"bosnia and herzegowina"                       ,
        "bw" =>"botswana"                                     ,
        "bv" =>"bouvet island"                                ,
        "br" =>"brazil"                                       ,
        "io" =>"british indian ocean territory"               ,
        "bn" =>"brunei darussalam"                            ,
        "bg" =>"bulgaria"                                     ,
        "bf" =>"burkina faso"                                 ,
        "bi" =>"burundi"                                      ,
        "kh" =>"cambodia"                                     ,
        "cm" =>"cameroon"                                     ,
        "ca" =>"canada"                                       ,
        "cv" =>"cabo verde"                                   ,
        "ky" =>"cayman islands"                               ,
        "cf" =>"central african republic"                     ,
        "td" =>"chad"                                         ,
        "cl" =>"chile"                                        ,
        "cn" =>"china"                                        ,
        "cx" =>"christmas island"                             ,
        "cc" =>"cocos (keeling) islands"                      ,
        "co" =>"colombia"                                     ,
        "km" =>"comoros"                                      ,
        "cg" =>"congo"                                        ,
        "cd" =>"congo, the democratic republic of the"        ,
        "ck" =>"cook islands"                                 ,
        "cr" =>"costa rica"                                   ,
        "ci" =>"cote d'ivoire"                                ,
        "hr" =>"croatia (hrvatska)"                           ,
        "cu" =>"cuba"                                         ,
        "cy" =>"cyprus"                                       ,
        "cz" =>"czech republic"                               ,
        "dk" =>"denmark"                                      ,
        "dj" =>"djibouti"                                     ,
        "dm" =>"dominica"                                     ,
        "do" =>"dominican republic"                           ,
        "tl" =>"east timor"                                   ,
        "ec" =>"ecuador"                                      ,
        "eg" =>"egypt"                                        ,
        "sv" =>"el salvador"                                  ,
        "gq" =>"equatorial guinea"                            ,
        "er" =>"eritrea"                                      ,
        "ee" =>"estonia"                                      ,
        "et" =>"ethiopia"                                     ,
        "fk" =>"falkland islands (malvinas)"                  ,
        "fo" =>"faroe islands"                                ,
        "fj" =>"fiji"                                         ,
        "fi" =>"finland"                                      ,
        "fr" =>"france"                                       ,
        "gf" =>"french guiana"                                ,
        "pf" =>"french polynesia"                             ,
        "tf" =>"french southern territories"                  ,
        "ga" =>"gabon"                                        ,
        "gm" =>"gambia"                                       ,
        "ge" =>"georgia"                                      ,
        "de" =>"germany"                                      ,
        "gh" =>"ghana"                                        ,
        "gi" =>"gibraltar"                                    ,
        "gr" =>"greece"                                       ,
        "gl" =>"greenland"                                    ,
        "gd" =>"grenada"                                      ,
        "gp" =>"guadeloupe"                                   ,
        "gu" =>"guam"                                         ,
        "gt" =>"guatemala"                                    ,
        "gn" =>"guinea"                                       ,
        "gw" =>"guinea-bissau"                                ,
        "gy" =>"guyana"                                       ,
        "ht" =>"haiti"                                        ,
        "hm" =>"heard and mc donald islands"                  ,
        "va" =>"holy see (vatican city state)"                ,
        "hn" =>"honduras"                                     ,
        "hk" =>"hong kong"                                    ,
        "hu" =>"hungary"                                      ,
        "is" =>"iceland"                                      ,
        "in" =>"india"                                        ,
        "id" =>"indonesia"                                    ,
        "ir" =>"iran (islamic republic of)"                   ,
        "iq" =>"iraq"                                         ,
        "ie" =>"ireland"                                      ,
        "il" =>"israel"                                       ,
        "it" =>"italy"                                        ,
        "jm" =>"jamaica"                                      ,
        "jp" =>"japan"                                        ,
        "jo" =>"jordan"                                       ,
        "kz" =>"kazakhstan"                                   ,
        "ke" =>"kenya"                                        ,
        "ki" =>"kiribati"                                     ,
        "kp" =>"korea, democratic people's republic of"       ,
        "kr" =>"korea, republic of"                           ,
        "kw" =>"kuwait"                                       ,
        "kg" =>"kyrgyzstan"                                   ,
        "la" =>"lao, people's democratic republic"            ,
        "lv" =>"latvia"                                       ,
        "lb" =>"lebanon"                                      ,
        "ls" =>"lesotho"                                      ,
        "lr" =>"liberia"                                      ,
        "ly" =>"libyan arab jamahiriya"                       ,
        "li" =>"liechtenstein"                                ,
        "lt" =>"lithuania"                                    ,
        "lu" =>"luxembourg"                                   ,
        "mo" =>"macao"                                        ,
        "mk" =>"macedonia, the former yugoslav republic of"   ,
        "mg" =>"madagascar"                                   ,
        "mw" =>"malawi"                                       ,
        "my" =>"malaysia"                                     ,
        "mv" =>"maldives"                                     ,
        "ml" =>"mali"                                         ,
        "mt" =>"malta"                                        ,
        "mh" =>"marshall islands"                             ,
        "mq" =>"martinique"                                   ,
        "mr" =>"mauritania"                                   ,
        "mu" =>"mauritius"                                    ,
        "yt" =>"mayotte"                                      ,
        "mx" =>"mexico"                                       ,
        "fm" =>"micronesia, federated states of"              ,
        "md" =>"moldova, republic of"                         ,
        "mc" =>"monaco"                                       ,
        "mn" =>"mongolia"                                     ,
        "ms" =>"montserrat"                                   ,
        "ma" =>"morocco"                                      ,
        "mz" =>"mozambique"                                   ,
        "mm" =>"myanmar"                                      ,
        "na" =>"namibia"                                      ,
        "nr" =>"nauru"                                        ,
        "np" =>"nepal"                                        ,
        "nl" =>"netherlands"                                  ,
        "an" =>"netherlands antilles"                         ,
        "nc" =>"new caledonia"                                ,
        "nz" =>"new zealand"                                  ,
        "ni" =>"nicaragua"                                    ,
        "ne" =>"niger"                                        ,
        "ng" =>"nigeria"                                      ,
        "nu" =>"niue"                                         ,
        "nf" =>"norfolk island"                               ,
        "mp" =>"northern mariana islands"                     ,
        "no" =>"norway"                                       ,
        "om" =>"oman"                                         ,
        "pk" =>"pakistan"                                     ,
        "pw" =>"palau"                                        ,
        "pa" =>"panama"                                       ,
        "pg" =>"papua new guinea"                             ,
        "py" =>"paraguay"                                     ,
        "pe" =>"peru"                                         ,
        "ph" =>"philippines"                                  ,
        "pn" =>"pitcairn"                                     ,
        "pl" =>"poland"                                       ,
        "pt" =>"portugal"                                     ,
        "pr" =>"puerto rico"                                  ,
        "qa" =>"qatar"                                        ,
        "re" =>"reunion"                                      ,
        "ro" =>"romania"                                      ,
        "ru" =>"russian federation"                           ,
        "rw" =>"rwanda"                                       ,
        "kn" =>"saint kitts and nevis"                        ,
        "lc" =>"saint lucia"                                  ,
        "vc" =>"saint vincent and the grenadines"             ,
        "ws" =>"samoa"                                        ,
        "sm" =>"san marino"                                   ,
        "st" =>"sao tome and principe"                        ,
        "sa" =>"saudi arabia"                                 ,
        "sn" =>"senegal"                                      ,
        "sc" =>"seychelles"                                   ,
        "sl" =>"sierra leone"                                 ,
        "sg" =>"singapore"                                    ,
        "sk" =>"slovakia (slovak republic)"                   ,
        "si" =>"slovenia"                                     ,
        "sb" =>"solomon islands"                              ,
        "so" =>"somalia"                                      ,
        "za" =>"south africa"                                 ,
        "gs" =>"south georgia and the south sandwich islands" ,
        "es" =>"spain"                                        ,
        "lk" =>"sri lanka"                                    ,
        "sh" =>"st. helena"                                   ,
        "pm" =>"st. pierre and miquelon"                      ,
        "sd" =>"sudan"                                        ,
        "sr" =>"suriname"                                     ,
        "sj" =>"svalbard and jan mayen islands"               ,
        "sz" =>"swaziland"                                    ,
        "se" =>"sweden"                                       ,
        "ch" =>"switzerland"                                  ,
        "sy" =>"syrian arab republic"                         ,
        "tw" =>"taiwan, province of china"                    ,
        "tj" =>"tajikistan"                                   ,
        "tz" =>"tanzania, united republic of"                 ,
        "th" =>"thailand"                                     ,
        "tg" =>"togo"                                         ,
        "tk" =>"tokelau"                                      ,
        "to" =>"tonga"                                        ,
        "tt" =>"trinidad and tobago"                          ,
        "tn" =>"tunisia"                                      ,
        "tr" =>"turkey"                                       ,
        "tm" =>"turkmenistan"                                 ,
        "tc" =>"turks and caicos islands"                     ,
        "tv" =>"tuvalu"                                       ,
        "ug" =>"uganda"                                       ,
        "ua" =>"ukraine"                                      ,
        "ae" =>"united arab emirates"                         ,
        "gb" =>"united kingdom"                               ,
        "us" =>"united states"                                ,
        "um" =>"united states minor outlying islands"         ,
        "uy" =>"uruguay"                                      ,
        "uz" =>"uzbekistan"                                   ,
        "vu" =>"vanuatu"                                      ,
        "ve" =>"venezuela"                                    ,
        "vn" =>"vietnam"                                      ,
        "vg" =>"virgin islands (british)"                     ,
        "vi" =>"virgin islands (u.s.)"                        ,
        "wf" =>"wallis and futuna islands"                    ,
        "eh" =>"western sahara"                               ,
        "ye" =>"yemen"                                        ,
        "yu" =>"serbia"                                       ,
        "zm" =>"zambia"                                       ,
        "zw" =>"zimbabwe"
    ];
    /**
     * Get full array of countries and codes
     *
     * @return array
     */
    public static function getCountries($country)
    {
        return static::$countries[$country];
    }

    /**
     * Check if country exist
     * @param $country
     * @return bool
     */
    public static function  exist($country){
        return isset(static::$countries[$country]);
    }
    /**
     * Check if country exist
     * @param $country
     * @return bool
     */
    public static function  getByIso($country){
        return static::$isoCountries[$country];
    }
}
