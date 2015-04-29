var Dictionary = Dictionary || {};

Dictionary.initPilesForms = function() {

    var history = JSON.parse(localStorage.getItem('history'));

    $.ajax({
        method: "POST",
        url: "api/v1/history/translation",
        data: {
            'history': JSON.parse(localStorage.getItem('history'))
        },
        headers: {
            "Accept":"application/json"
        },
        success: function (data) {
            console.log(data);
            var responseHTML = '<div class="panel-heading">' +
                    '<h4>HISTORY</h4>' +
                    '</div>' +
                    '<div class="panel-body">';

            for(var word in data) {
                var historyItem = '<div class="word_history_white panel-column">' +
                                    '<div class="col-md-8 col-xs-12">' +
                                        '<div><a class="history_key" href="#'+ data[word]['word'] + '">' + data[word]['word'] +'</a></div>';

                var wordTranslation = data[word].translations;
                for(var j in wordTranslation) {
                    historyItem +='<div class="wordByType">' +
                                    '<span class="wordType">'+ j +': </span>' + wordTranslation[j].join() + '</div>';
                }
                historyItem +='</div></div>';
                responseHTML += historyItem;
            }

            responseHTML ='<div class="panel panel-info">' + responseHTML + '</div>';

            $('#history').html(responseHTML);
        },
        error: function (err) {
        }
    });

    $('#translation_form').submit(function( event ) {
        event.preventDefault();

        var word = $('#word').val(),
            historyArr;

        location.hash = word;
        if(localStorage.getItem('history')) {
            historyArr = JSON.parse(localStorage.getItem('history'));
            for(var i in historyArr) {
                if(word == historyArr[i]) {
                    historyArr.splice(i, 1);
                }
            }
        } else {
            historyArr = [];
        }
        historyArr.unshift(word);

        localStorage.setItem('history', JSON.stringify(historyArr));
        $.ajax({
            method: "GET",
            url: "api/v1/translation/"+word,
            headers: {
                "Accept":"application/json"
            },
            success: function (data) {
                console.log(data.translation);

                var response = '<div><h2>'+data.word +'</h2></div>' +
                    '<div class="table-responsive">' +
                                    '<table class="table">' +
                                        '<tbody>';
                for (var i in data.translation) {
                    response += '<tr><td colspan="3"><b><span>' + i + '</span></b></td></tr>';
                    var trans = data.translation[i];
                    for(var j in trans) {
                        response += '<tr>' +
                                        '<td>&nbsp;</td>' +
                                        '<td><span>' + trans[j]['translation']+ '</span></td>';
                        var synonyms = trans[j]['synonyms'];
                        var synonymsHtml = '';
                        for(var k in synonyms) {
                            synonymsHtml += '<span class="synonym">' +
                                                '<a href="home#'+ synonyms[k] + '">' + synonyms[k]+ '</a>' +
                                            '</span>';
                        }
                        response += '<td>' + synonymsHtml + '</td></tr>';
                    }
                }
                $('#response').html(response);
            },
            error: function (err) {
            }
        });

    });

    $('a.pile').click(function(ev) {
        ev.preventDefault();
        var element = $(this),
            parent = element.parent();

        $.ajax({
            type: "GET",
            url: element.attr('href'),
            success: function(data)
            {
                if(data.success) {
                    parent.find('a.pile').each(function () {
                        $(this).removeClass('disabled');
                    });
                    element.addClass('disabled');
                }
            }
        });
    });

    $('a.history_delete_item').click(function(ev) {
        ev.preventDefault();

        var element = $(this),
            historyId = element.attr('data-id'),
            hisotyItemEl;

        $.ajax({
            type: "DELETE",
            url: element.attr('href'),
            success: function(data)
            {
                if (data.success) {
                    hisotyItemEl = $('#history_item_' + historyId);
                    hisotyItemEl.hide('slow', function(){ hisotyItemEl.remove(); });
                }
            }
        });
    });

    $('a.pile_delete_item').click(function(ev) {
        ev.preventDefault();

        var element = $(this),
            pileId = element.attr('data-id'),
            pileEl;

        $.ajax({
            type: "DELETE",
            url: element.attr('href'),
            success: function(data)
            {
                if (data.success) {
                    pileEl = $('#pile_item_' + pileId);
                    pileEl.hide('slow', function(){ pileEl.remove(); });
                }
            }
        });
    });
};
