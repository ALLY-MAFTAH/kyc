(function ($) {
    "use strict";
    var substringMatcher = function (strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;

            // an array that will be populated with substring matches
            matches = [];

            // regex used to determine if a string contains the substring `q`
            var substrRegex = new RegExp(q, "i");

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
        "All",
        "BUNJU",
        "GOBA",
        "WAZI",
        "MABWEPANDE",
        "MAKONGO",
        "MBEZI",
        "JUU",
        "NDUGUMBI",
        "MZIMUNI",
        "MWANANYAMALA",
        "MAKUMBUSHO",
        "MSASANI",
        "MIKOCHENI",
        "MBWENI",
        "MBEZI",
        "MAGOMENI",
        "KUNDUCHI",
        "KINONDONI",
        "KIJITONYAMA",
        "KIGOGO",
        "KAWE",
        "HANANASIF",
    ];
    var list_of_streets = [
        "MAKUMBUSHO",
        "KAWE",
        "KIGOGO",
        "MANZESE",
        "MIKOCHENI",
        "SINZA",
        "TEGETA A",
        "TEGETA B",
        "MAGOMENI",
        "OSTERBAY",
    ];

    $("#wards .typeahead").typeahead(
        {
            hint: true,
            highlight: true,
            minLength: 1,
        },
        {
            name: "list_of_wards",
            source: substringMatcher(list_of_wards),
        }
    );
    $("#streets .typeahead").typeahead(
        {
            hint: true,
            highlight: true,
            minLength: 1,
        },
        {
            name: "list_of_streets",
            source: substringMatcher(list_of_streets),
        }
    );
    // constructs the suggestion engine
    var list_of_wards = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.whitespace,
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        // `list_of_wards` is an array of state names defined in "The Basics"
        local: list_of_wards,
    });

    $("#bloodhound .typeahead").typeahead(
        {
            hint: true,
            highlight: true,
            minLength: 1,
        },
        {
            name: "list_of_wards",
            source: list_of_wards,
        }
    );
})(jQuery);
