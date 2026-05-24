import moment from 'moment';

//convert words first letter to upper case
Vue.filter('upperCase', function(value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
});

//global for date human readable
Vue.filter('dateTime', function(created) {
    return moment(created).format('MMM ddd Do, YYYY, hh:mm:ss a');
});

Vue.filter('dateOnly', function(created) {
    return moment(created).format('MMM ddd Do, YYYY');
});

Vue.filter('rawDate', function(created) {
    return moment(created).format('l, hh:mm:ss a');
});

Vue.filter('lastTime', function(created) {
    // var mydate = "2017-08-30T00:00:00";
    // console.log(moment(mydate).format('dddd')); // Wednesday
    // console.log(moment(mydate).format('ddd'));  // Wed
    // console.log('Day in number[0,1,2,3,4,5,6]: '+moment(mydate).format('d')); // Day in number[0,1,2,3,4,5,6]: 3
    // console.log(moment(mydate).format('MMM'));  // Aug
    // console.log(moment(mydate).format('MMMM'));  // August

    // moment().format();                                // "2014-09-08T08:02:17-05:00" (ISO 8601, no fractional seconds)
    // moment().format("dddd, MMMM Do YYYY, h:mm:ss a"); // "Sunday, February 14th 2010, 3:25:50 pm"
    // moment().format("ddd, hA");                       // "Sun, 3PM"
    // moment().format("[Today is] dddd");               // "Today is Sunday"
    // moment('gibberish').format('YYYY MM DD');         // "Invalid date"

    // moment(dateToCheck).isSame(new Date(), 'week'); //true if dates are in the same week
    // moment(dateToCheck).isSame(new Date(), 'month'); //true if dates are in the same month
    // moment(dateToCheck).isSame(new Date(), 'year'); //true if dates are in the same year

    // var sampleDaysAgo = moment().subtract(28, 'days'); //28 just for test
    // var today = moment();

    // console.log(today.diff(sampleDaysAgo, 'days')); // 28 

    if (moment(created).format('DD/MM/YYYY') == moment(new Date()).format('DD/MM/YYYY'))
        return moment(created).format('hh:mm:ss a');
    else
        return moment(created).fromNow();
    // return moment(created).format('l');
    // return moment(created).format('dddd');
    // return moment(created).format('MMM ddd Do, YYYY');
});

Vue.filter('raw', function(created) {
    return moment(created).format('l');
});

Vue.filter('localFormat', function(created) {
    return moment(created).format('YYYY-dd-Do, hh:mm:ss a');
});

//substring in vue
Vue.filter('reduceText', function(text, length, suffix) {
    if (text.length > length) {
        return text.substring(0, length) + suffix;
    } else {
        return text;
    }
});

Vue.filter('toFixed', function(price, limit) {
    return price.toFixed(limit);
});