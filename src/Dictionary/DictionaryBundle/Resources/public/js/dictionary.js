var Dictionary = Dictionary || {};

Dictionary.initPilesForms = function() {

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
