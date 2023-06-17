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
        "TANDALE",
        "HANANASIF",
        "MWANANYAMALA",
        "MAKUMBUSHO",
        "KIJITONYAMA",
        "KINONDONI",
        "MAGOMENI",
        "MZIMUNI",
        "KIGOGO",
        "NDUGUMBI",
        "KAWE",
        "MAKONGO",
        "MBEZI JUU",
        "KUNDUCHI",
        "WAZO",
        "BUNJU",
        "MABWEPANDE",
        "MBWENI",
        "MIKOCHENI",
        "MSASANI",
    ];
    var list_of_streets = [
        "MTOGOLE",
        "MUHALITANI",
        "SOKONI",
        "PAKACHA",
        "KWA TUMBO",
        "MKUNDUGE",
        "HANANASIF",
        "MKUNGUNI  B",
        "KAWAWA",
        "MKUNGUNI A",
        "KISUTU",
        "BWAWANI",
        "MSISIRI  B",
        "KAMBANGWA",
        "MSOLOMI",
        "MWINYIJUMA",
        "MSISIRI  A",
        "KWA KOPA",
        "MAKUMBUSHO",
        "MCHANGANI",
        "MBUYUNI",
        "MINAZINI",
        "KISIWANI",
        "SINGANO",
        "MPAKANI A",
        "MWENGE",
        "NZASA",
        "KIJITONYAMA",
        "MPAKANI  B",
        "BWAWANI",
        "ALIMAUA   A",
        "ALIMAUA  B",
        "KUMBUKUMBU",
        "SHAMBA",
        "ADA ESTATE",
        "KINONDONI MJINI",
        "MAKUTI  A",
        "MAKUTI  B",
        "SUNA",
        "DOSSI",
        "IDRISA",
        "MWINYI MKUU",
        "IDRISA",
        "MAKUMBUSHO",
        "MTAMBANI",
        "MKWAJUNI",
        "KIGOGO KATI",
        "MTAA WA MBUYUNI",
        "MPAKANI",
        "KAGERA MIKOROSHINI",
        "MAKANYA",
        "VIGAENI",
        "UKWAMANI",
        "MBEZI BEACH  A",
        "MZIMUNI",
        "MBEZI BEACH  B",
        "MAKONGO JUU",
        "CHANGANYIKENI",
        "MLALAKUWA",
        "MBUYUNI",
        "MBEZI JUU",
        "MBEZI MTONI",
        "MBEZI JOGOO",
        "MBEZI KATI",
        "MBEZI NDUMBWI",
        "TEGETA",
        "MTONGANI",
        "KONDO",
        "UNUNIO",
        "KILONGAWIMA",
        "PWANI",
        "WAZO",
        "MADALE",
        "SALASALA",
        "MIVUMONI",
        "KILIMAHEWA",
        "KILIMAHEWA JUU",
        "NYAKASANGWE",
        "KISANGA",
        "DOVYO",
        "BASIHAYA",
        "MKOANI",
        "KILUNGULE",
        "BOKO",
        "BUNJU  A",
        "KIHONZILE",
        "BUNJU  B",
        "MABWEPANDE",
        "MJI MPYA",
        "MBOPO",
        "TETA",
        "MAPUTO",
        "MPIJIMBWENI",
        "MALINDI ESTATE",
        "MBWENI",
        "MIKOCHENI  A",
        "MIKOCHENI  B",
        "T.P.D.C",
        "DARAJANI",
        "REGENT ESTATE",
        "ALLY HASSAN MWINYI",
        "OYSTERBAY",
        "MASAKI",
        "MIKOROSHINI",
        "BONDE LA MPUNGA",
        "MAKANGIRA",
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
