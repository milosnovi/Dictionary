Dictionary.factory('HistoryService', function() {
    var historyList = [];

    return {
        addHistoryItem: addHistoryItem,
        getHistory: getHistory,
        setData: setData,
        getData: getData,
        getFirstItem: getFirstItem
    };

    function getFirstItem() {
        return historyList[0];
    }

    function setData(data) {
        historyList =  data;
    }

    function getData() {
        return  historyList;
    }

    function addHistoryItem(item) {
        historyList.unshift(item);
    }

    function getHistory() {
        return historyList;
    }
});