<?php


namespace App\Classes;


use App\Models\Contacts;
use App\Models\MatchingConfig;
use App\Models\Profiles;
use Illuminate\Database\Eloquent\Collection;

class Matcher
{
    private $matchedContacts;

    public function matchData()
    {

    }

    /**
     * Match new contact with older contacts
     * @param Contacts $contactToMatch
     * @param array $contacts
     * @param collection $parameters
     * @return array
     */
    public function matchContact(Contacts $contactToMatch, $contacts, $parameters)
    {
        foreach ($contacts as $contact) {
            /** Initialise number of matched parameters between new contact and BDD contact*/
            $matchedParams = 0;
            foreach ($parameters as $param) {
                /** Calculate distance using levenshtein */
                $lev = levenshtein($contactToMatch[$param->fields['tag']], $contact[$param->fields['tag']]);

                /** Convert distance to percentage */
                $per = (1 - ($lev / max(strlen($contactToMatch[$param->fields['tag']]), $contact[$param->fields['tag']]))) * 100;

                /** Check if parameter percentage condition is true */
                if ($param['percentage'] < $per) {
                    /** If true increase matched parameters */
                    if ($param['obligation'] == 1) {
                        $this->matchedContacts[] = $contact;
                        break;
                    }
                    $matchedParams++;
                } elseif ($param['obligation'] == 1) {
                    break;
                }
            }
            /** If all parameters Matched */
            if ($parameters->count() == $matchedParams) {
                $this->matchedContacts[] = $contact;
                /** If parameters are partially Matched */
            } elseif ($matchedParams != 0 && $parameters->count() > $matchedParams) {
                // Ki yabda moch l kol ymatchiw ech bech ta3mel a 7sin
            }
        }
        /** If single match */
        if (count($this->matchedContacts) <= 1) {
            return $this->matchedContacts;

            /** If multiple match */
        } else {
            $currentParamsIds = $parameters->pluck('id');
            $additionalParam = MatchingConfig::whereNotIn('id', $currentParamsIds)->first();
            /** If More parameters for matching exist */
            if ($additionalParam) {
                $contacts = $this->matchedContacts;
                $parameters = $additionalParam;
                $this->matchedContacts = [];
                $this->matchContact($contactToMatch, $contacts, $parameters);
            /** If NO More parameters for matching */
            } else {
                /** When no more params and have multiple matchs => duplicated contacts => remove duplication */
            }
        }
        return $this->matchedContacts;
    }
}
