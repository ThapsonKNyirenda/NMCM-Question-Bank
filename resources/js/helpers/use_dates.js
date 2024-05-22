import dayjs from "dayjs";
var customParseFormat = require('dayjs/plugin/customParseFormat');
dayjs.extend(customParseFormat);

const getMonth = function (monthNumber) {
    let month = [];
    month[0] = "January";
    month[1] = "February";
    month[2] = "March";
    month[3] = "April";
    month[4] = "May";
    month[5] = "June";
    month[6] = "July";
    month[7] = "August";
    month[8] = "September";
    month[9] = "October";
    month[10] = "November";
    month[11] = "December";

    return month[monthNumber];
};

const getDateMonth = function (fullDate) {
    let sDate = new Date(fullDate);
    return getMonth(sDate.getMonth());
};

const getFormattedDate = function (rawDate, format = "MMMM DD, YYYY") {
    return dayjs(rawDate).format( format );
};

function addMonths(date, amount) {
    return dayjs(date).add(amount, 'month');
}

function addDays(date, days){
    return dayjs(date).add(days,'day');
}

function dateDiff(firstDate, lastDate){
    let diff;

    const fDate = new Date(firstDate);
    const lDate = new Date(lastDate);

    if(lDate.getTime() > fDate.getTime()){
        diff = lDate.getTime() - fDate.getTime();
    }else{
        diff = fDate.getTime() - lDate.getTime();
    }
    return Math.ceil(diff / (1000 * 3600 * 24));
}

export {
    addMonths,
    addDays,
    dateDiff,
    getFormattedDate,
    getDateMonth,
    getMonth
}