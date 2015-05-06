var Dictionary = Dictionary || {};

var DictionaryLocalStorage = DictionaryLocalStorage || {};


Dictionary.initDict = function(isLoggedIn) {
    var _this = this;
    this.initHasManager(function(word) {
        if(isLoggedIn) {
            _this.updateHistory(word);
        }
    });
    this.initTranslationForm(function(word) {
        if(isLoggedIn) {
            _this.updateHistory(word);
        }
    });
    this.initHistory(isLoggedIn);
};

Dictionary.getTranslation = function(word) {
    var _this = this;
    if(!word) {
        return;
    }
    $.ajax({
        method: "GET",
        url: Routing.generate('translationapi_translation_get', { word: word }),
        headers: {
            "Accept":"application/json"
        },
        success: function (data) {
            DictionaryLocalStorage.addItem(word);

            ga('send', 'pageview', '/' + word);

            var response = '<div><h2>'+data.word +'</h2></div>' +
                '<div class="table-responsive">' +
                '<table class="table">' +
                '<tbody>';
            var historyItem = '<div class="word_history_white panel-column" data-value="' + data.word + '">' +
                '<div class="col-md-8 col-xs-12">' +
                '<div><a class="history_key" href="#'+ data.word + '">' + data.word +'</a></div>';

            for (var i in data.translation) {
                response += '<tr><td colspan="3"><b><span>' + i + '</span></b></td></tr>';
                var trans = data.translation[i];

                historyItem +='<div class="wordByType"><span class="wordType">'+ i +': </span>';
                var englishTrans = [];
                for(var j in trans) {
                    englishTrans.push(trans[j]['translation']);
                    response += '<tr>' +
                    '<td>&nbsp;</td>' +
                    '<td><span>' + trans[j]['translation']+ '</span></td>';
                    var synonyms = trans[j]['synonyms'];
                    var synonymsHtml = '';
                    for(var k in synonyms) {
                        synonymsHtml += '<span class="synonym">' +
                        '<a href="#'+ synonyms[k] + '">' + synonyms[k]+ '</a>' +
                        '</span>';
                    }
                    response += '<td>' + synonymsHtml + '</td></tr>';
                }
                historyItem += englishTrans.join() + '</div>';
            }
            historyItem +='</div>';
            historyItem += '<div class="col-md-6 col-xs-12">'+
                '<a class="history_delete_item panel-item-links" data-id="955" href="/history/955"><span class="glyphicon glyphicon-remove"></span></a>' +
                '<a href="word/' +word+ '/pile/4" class="pile btn btn-sm btn-danger  panel-item-links " style="line-height: 1;">DONT KNOW</a>' +
                '<a href="word/' +word+ '/pile/2" class="pile btn btn-sm btn-warning panel-item-links " style="line-height: 1;">ALMOST</a>' +
                '<a href="word/' +word+ '/pile/1" class="pile btn btn-sm btn-success panel-item-links " style="line-height: 1;">KNOW</a>' +
            '</div></div>';

            if($('#history').find('.history-item-no-records')) {
                $('#history').find('.history-item-no-records').remove();
            }

            $('#response').html(response);
            $("#history").find("[data-value='" + data.word + "']").remove();
            $('#history .panel-body').prepend(historyItem);
            _this.initPilesForms("[data-value='" + data.word + "']");

        },
        error: function (err) {
            var response = '<div id="latestResult">There is no result!</div>';
            $('#response').html(response);
        }
    });
};

DictionaryLocalStorage.addItem = function(word) {
    var historyArr;
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
    historyArr = historyArr.splice(0, 25);

    localStorage.setItem('history', JSON.stringify(historyArr));
};

Dictionary.initHasManager = function(callback) {
    var _this = this;
    if(!localStorage.getItem('history')) {
        DictionaryLocalStorage.addItem('welcome');
    }
    $(function(){
        $(window).hashchange(function(){
            var hash = location.hash,
                word  = hash.replace( /^#/, '' );

            $('#word').val(word);
            _this.getTranslation(word);
            callback(word);
        });

        $(window).hashchange();
    });
};

Dictionary.updateHistory = function(word) {
    $.ajax({
        method: "GET",
        url: Routing.generate('update_historyapi_update_history', {'word': word}),
        headers: {
            "Accept":"application/json"
        },
        success: function (data) {
            console.log(data);
        },
        error: function (err) {
        }
    });
};

Dictionary.initTranslationForm = function(callback) {
    var _this = this;
    $('#translation_form').submit(function( event ) {
        event.preventDefault();
        var word = $('#word').val();

        location.hash = word;
        _this.getTranslation(word);
        callback(word);
    });
};


Dictionary.initHistory = function(isLoggedIn) {
    console.log(isLoggedIn);
    var _this = this,
        history = JSON.parse(localStorage.getItem('history')),
        data = isLoggedIn ? {} : {'history': JSON.parse(localStorage.getItem('history'))},
        url = isLoggedIn ? Routing.generate('user_historyapi_history') : Routing.generate('anonymous_historyapi_translations_post');

    $.ajax({
        method: "POST",
        url: url,
        data: data,
        headers: {
            "Accept":"application/json"
        },
        success: function (data) {
            console.log(data);
            var responseHTML = '<div class="panel-heading">' +
                '<h4>HISTORY</h4>' +
                '</div>' +
                '<div class="panel-body">';

            if(0 >= data.length) {
                responseHTML ='<div class="panel panel-info">' +
                        '<div class="panel-heading">' +
                            '<h4>HISTORY</h4>' +
                        '</div>' +
                        '<div class="panel-body">' +
                            '<div class="history-item-no-records">' +
                                'There is no history item yet!' +
                            '</div>' +
                        '</div>';

                $('#history').html(responseHTML);
                return;
            }

            for(var word in data) {
                var historyItem = '<div class="word_history_white panel-column" data-value="' + data[word]['word'] + '">' +
                    '<div class="col-md-8 col-xs-12">' +
                    '<div><a class="history_key" href="#'+ data[word]['word'] + '">' + data[word]['word'] +'</a></div>';

                var wordTranslation = data[word].translations;
                for(var j in wordTranslation) {
                    historyItem +='<div class="wordByType">' +
                    '<span class="wordType">'+ j +': </span>' + wordTranslation[j].join() + '</div>';
                }
                historyItem +='</div>';
                historyItem += '<div class="col-md-6 col-xs-12">'+
                '<a class="history_delete_item panel-item-links" data-id="955" href="/history/955"><span class="glyphicon glyphicon-remove"></span></a>' +
                '<a href="word/' +data[word]['word']+ '/pile/4" class="pile btn btn-sm btn-danger  panel-item-links " style="line-height: 1;">DONT KNOW</a>' +
                '<a href="word/' +data[word]['word']+ '/pile/2" class="pile btn btn-sm btn-warning panel-item-links " style="line-height: 1;">ALMOST</a>' +
                '<a href="word/' +data[word]['word']+ '/pile/1" class="pile btn btn-sm btn-success panel-item-links " style="line-height: 1;">KNOW</a>' +
                '</div></div>'
                responseHTML += historyItem;
            }

            responseHTML ='<div class="panel panel-info">' + responseHTML + '</div>';

            $('#history').html(responseHTML);
            _this.initPilesForms();
        },
        error: function (err) {
        }
    });
};

Dictionary.initPilesForms = function(selector) {
    var selector = undefined === selector ? '#history' : '#history ' + selector;
    $(selector + ' a.pile').on('click', function (ev) {
        ev.preventDefault();
        var element = $(this),
            parent = element.parent();

        $.ajax({
            type: "GET",
            url: element.attr('href'),
            success: function (data) {
                if (data.success) {
                    parent.find('a.pile').each(function () {
                        $(this).removeClass('disabled');
                    });
                    element.addClass('disabled');
                }
            }
        });
    });

    $(selector + ' a.history_delete_item').on('click', function (ev) {
        ev.preventDefault();

        var element = $(this),
            historyId = element.attr('data-id'),
            hisotyItemEl;

        $.ajax({
            type: "DELETE",
            url: element.attr('href'),
            success: function (data) {
                if (data.success) {
                    hisotyItemEl = $('#history_item_' + historyId);
                    hisotyItemEl.hide('slow', function () {
                        hisotyItemEl.remove();
                    });
                }
            }
        });
    });

    $(selector + ' a.pile_delete_item').on('click', function (ev) {
        ev.preventDefault();

        var element = $(this),
            pileId = element.attr('data-id'),
            pileEl;

        $.ajax({
            type: "DELETE",
            url: element.attr('href'),
            success: function (data) {
                if (data.success) {
                    pileEl = $('#pile_item_' + pileId);
                    pileEl.hide('slow', function () {
                        pileEl.remove();
                    });
                }
            }
        });
    });
}
