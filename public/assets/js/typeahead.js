(function ($) {
    'use strict';
    var substringMatcher = function (strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
            var substrRegex = new RegExp(q, 'i');

            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            for (var i = 0; i < strs.length; i++) {
                if (substrRegex.test(strs[i])) {
                    matches.push(strs[i]);
                }
            }

            cb(matches);
        };
    };

    var list_of_wards = [

        'Bunju',
        'Goba',
        'Wazi',
        'Mabwepande',
        'Makongo',
        'Mbezi',
        'Juu',
        'Ndugumbi',
        'Mzimuni',
        'Mwananyamala',
        'Makumbusho',
        'Makurumla',
        'Msasani',
        'Mikocheni',
        'Mbweni',
        'Mbezi',
        'Magomeni',
        'Kunduchi',
        'Kinondoni',
        'Kimara',
        'Kijitonyama',
        'Kigogo',
        'Kibamba',
        'Kawe',
        'Hananasif',];
    var list_of_streets = [

        'Tegeta A', 'Tegeta B', 'Magomeni', 'Osterbay'];

    $('#wards .typeahead').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        name: 'list_of_wards',
        source: substringMatcher(list_of_wards)
    });
    $('#streets .typeahead').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        name: 'list_of_streets',
        source: substringMatcher(list_of_streets)
    });
    // constructs the suggestion engine
    var list_of_wards = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        // `list_of_wards` is an array of state names defined in "The Basics"
        local: list_of_wards
    });

    $('#bloodhound .typeahead').typeahead({
        hint: true,
        highlight: true,
        minLength: 1
    }, {
        name: 'list_of_wards',
        source: list_of_wards
    });
})(jQuery);
