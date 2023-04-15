<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'A(z) :attribute el kell fogadni.',
    'accepted_if' => 'A(z) :attribute el kell fogadni, ha :other értéke :value.',
    'active_url' => 'A(z) :attribute nem valódi URL.',
    'after' => 'A(z) :attribute dátumnak későbbinek kell lennie, mint :date.',
    'after_or_equal' => 'A(z) :attribute dátumnak későbbinek vagy azonosnak kell lennie, mint :date.',
    'alpha' => 'A(z) :attribute csak betűket tartalmazhat.',
    'alpha_dash' => 'A(z) :attribute csak betűket, számokat, kötőjelet és aláhúzást tartalmazhat.',
    'alpha_num' => 'A(z) :attribute csak betűket és számokat tartalmazhat.',
    'array' => 'A(z) :attribute értéknek tömbnek kell lennie.',
    'before' => 'A(z) :attribute dátumnak előbbinek kell lennie, mint :date.',
    'before_or_equal' => 'A(z) :attribute dátumnak előbbinek vagy azonosnak kell lennie, mint :date.',
    'between' => [
        'array' => 'A(z) :attribute tömb elemszámának :min és :max között kell lennie.',
        'file' => 'A(z) :attribute fájl méretének :min és :max kilobyte között kell lennie.',
        'numeric' => 'A(z) :attribute szám :min és :max között kell legyen.',
        'string' => 'A(z) :attribute szöveg hossza :min és :max között kell elgyen.',
    ],
    'boolean' => 'A(z) :attribute mező értéke csak igaz vagy hamis lehet.',
    'confirmed' => 'A(z) :attribute megerősítőérték nem egyezik.',
    'current_password' => 'Helytelen jelszó.',
    'date' => 'A(z) :attribute dátum nem megfelelő formátumú.',
    'date_equals' => 'A(z) :attribute dátumnak egyenlőnek kell lennie ezzel: :date.',
    'date_format' => 'A(z) :attribute dátum nem ebben a formátumban van: :format.',
    'declined' => 'A(z) :attribute értéket vissza kell utasítani.',
    'declined_if' => 'A(z) :attribute értéket vissza kell utasítani, ha :other érték ezzel egyenlő: :value.',
    'different' => 'A(z) :attribute és :other különbözőnek kell lennie.',
    'digits' => 'A(z) :attribute értéknek :digits számoknak kell lennie.',
    'digits_between' => 'A(z) :attribute értéknek :min és :max közötti számoknak kell lennie.',
    'dimensions' => 'A(z) :attribute nem megfelelő képdimenziókat tartalmaz.',
    'distinct' => 'A(z) :attribute mező értéke megegyezik egy másik mezőével.',
    'doesnt_end_with' => 'A(z) :attribute nem végződhet a következők egyikével: :values.',
    'doesnt_start_with' => 'A(z) :attribute nem kezdődhet a következők egyikével: :values.',
    'email' => 'A(z) :attribute igazi e-mail címnek kell lennie.',
    'ends_with' => 'A(z) :attribute értéknek a következők egyikével kell végződnie: :values.',
    'enum' => 'A kiválasztott :attribute érték nem megfelelő.',
    'exists' => 'A kiválaszottt :attribute érték nem megfelelő.',
    'file' => 'A(z) :attribute fájl kell, hogy legyen.',
    'filled' => 'A(z) :attribute mező nem lehet üres.',
    'gt' => [
        'array' => 'A(z) :attribute több elemének kell lennie, mint :value.',
        'file' => 'A(z) :attribute fájlnak nagyobbnak kell lennie, mint :value kilobyte.',
        'numeric' => 'A(z) :attribute számnak nagyobbnak kell lennie, mint :value.',
        'string' => 'A(z) :attribute szövegnek hosszabbnak kell lennie, mint :value karakter.',
    ],
    'gte' => [
        'array' => 'A(z) :attribute tömbnek legalább :value elemmel kell rendelkeznie.',
        'file' => 'A(z) :attribute fájlnak legalább :value kilobyte méretűnek kell lennie.',
        'numeric' => 'A(z) :attribute számnak legalább ekkorának kell lennie: :value.',
        'string' => 'A(z) :attribute szöveg hosszának legalább :value karakternek kell lennie.',
    ],
    'image' => 'A(z) :attribute fájlnak képnek kell lennie.',
    'in' => 'A kiválasztott :attribute nem megfelelő.',
    'in_array' => 'A(z) :attribute mező nem létezik ebben: :other.',
    'integer' => 'A(z) :attribute értéknek számnak kell lennie.',
    'ip' => 'A(z) :attribute értéknek IP-címnek kell lennie.',
    'ipv4' => 'A(z) :attribute értéknek IPv4-címnek kell lennie.',
    'ipv6' => 'A(z) :attribute értéknek IPv6-címnek kell lennie.',
    'json' => 'A(z) :attribute értéknek megfelelő JSON sztringnek kell lennie.',
    'lt' => [
        'array' => 'A(z) :attribute kevesebb értékkel kell rendelkeznie, mint: :value.',
        'file' => 'A(z) :attribute fájlnak kisebbnek kell lennie, mint :value kilobyte.',
        'numeric' => 'A(z) :attribute kisebbnek kell lennie, mint :value.',
        'string' => 'A(z) :attribute rövidebbnek kell lennie, mint :value.',
    ],
    'lte' => [
        'array' => 'A(z) :attribute több értékkel kell rendelkeznie, mint: :value.',
        'file' => 'A(z) :attribute fájl legfeljebb ekkora lehet :value kilobyte.',
        'numeric' => 'A(z) :attribute legfeljebb ekkora lehet: :value.',
        'string' => 'A(z) :attribute legfeljebb ilyen hosszú lehet: :value.',
    ],
    'mac_address' => 'A(z) :attribute igazi MAC címnek kell lennie.',
    'max' => [
        'array' => 'A(z) :attribute tömbnek legfeljebb :max eleme lehet.',
        'file' => 'A(z) :attribute nem lehet nagyobb, mint :max kilobyte.',
        'numeric' => 'A(z) :attribute nem lehet nagyobb, mint :max.',
        'string' => 'A(z) :attribute nem lehet hosszabb, mint :max karakter.',
    ],
    'max_digits' => 'A(z) :attribute tömbben legfeljebb :max számjegy lehet',
    'mimes' => 'A(z) :attribute ilyen fájl vagy típus kell legyen: :values.',
    'mimetypes' => 'A(z) :attribute ilyen fájl vagy típus kell legyen: :values.',
    'min' => [
        'array' => 'A(z) :attribute tömbnek legalább :min eleme kell legyen.',
        'file' => 'A(z) :attribute fájlnak legalább ekkorának kell lennie: :min kilobyte.',
        'numeric' => 'A(z) :attribute számnak legalább ekkorának kell lennie: :min.',
        'string' => 'A(z) :attribute legalább ilyen hosszúnak kell lennie: :min karakter.',
    ],
    'min_digits' => 'A(z) :attribute értéknek legalább :min számjegyet kell tartalmaznia.',
    'multiple_of' => 'A(z) :attribute érték :value értéknek a többszöröse kell legyen.',
    'not_in' => 'A kiválasztott :attribute érték nem megfelelő.',
    'not_regex' => 'A(z) :attribute formátum nem megfelelő.',
    'numeric' => 'A(z) :attribute értéknek számnak kell lennie.',
    'password' => [
        'letters' => 'A(z) :attribute tartalmaznia kell legalább egy betűt.',
        'mixed' => 'A(z) :attribute tartalmaznia kell legalább egy kis- és nagybetűt.',
        'numbers' => 'A(z) :attribute tartalmaznia kell számot.',
        'symbols' => 'A(z) :attribute tartalmaznia kell különleges karaktert.',
        'uncompromised' => 'A(z) megadott :attribute megjelent egy adatszivárgásban. Kérem válasszon egy másik :attribute értéket.',
    ],
    'present' => 'A(z) :attribute mezőnek léteznie kell.',
    'prohibited' => 'A(z) :attribute mező tiltott.',
    'prohibited_if' => 'A(z) :attribute tiltott, ha :other mezőnek :value az értéke.',
    'prohibited_unless' => 'A(z) :attribute tiltott, ha :other :values között van.',
    'prohibits' => 'A(z) :attribute tiltja :other megjelenését.',
    'regex' => 'A(z) :attribute formátum nem megfelelő.',
    'required' => 'A(z) :attribute szükséges.',
    'required_array_keys' => 'A(z) :attribute mezőnek bejegyzéseket kell tartalmaznia ezekre: :values.',
    'required_if' => 'A(z) :attribute szükséges, ha :other értéke :value.',
    'required_unless' => 'A(z) :attribute szükséges, hacsak :other érték nincs :values között.',
    'required_with' => 'A(z) :attribute mező kötelező, ha :values létezik.',
    'required_with_all' => 'A(z) :attribute mező kötelező, ha :values létezik.',
    'required_without' => 'A(z) :attribute mező kötelező, ha :values nem létezik.',
    'required_without_all' => 'A(z) :attribute mező kötelező, ha :values egyike létezik.',
    'same' => 'A(z) :attribute és :other mezőknek egyezniük kell.',
    'size' => [
        'array' => 'A(z) :attribute tömbnek :size elemet kell tartalmaznia.',
        'file' => 'A(z) :attribute :size kilobyte-nak kell lennie.',
        'numeric' => 'A(z) :attribute számnak ekkorának kell lennie: :size.',
        'string' => 'A(z) :attribute szövegnek :size hosszúnak kell lennie.',
    ],
    'starts_with' => 'A(z) :attribute a következő értékek egyikével kell kezdődnie: :values.',
    'string' => 'A(z) :attribute szövegnek kell lennie.',
    'timezone' => 'A(z) :attribute helyes időzónának kell lennie.',
    'unique' => 'A(z) :attribute már foglalt.',
    'uploaded' => 'A(z) :attribute feltöltése sikertelen.',
    'url' => 'A(z) :attribute valódi URL-nek kell lennie.',
    'uuid' => 'A(z) :attribute valódi UUID-nek kell lennie.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
