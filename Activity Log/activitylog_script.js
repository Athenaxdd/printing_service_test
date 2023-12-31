function _(id) {
    return document.getElementById(id)
}

function OpenPopup(id) {
    _(id).classList.add("open-popup");
}
function ClosePopup(id) {
    _(id).classList.add("close-popup");
}
function getHref() { // Set href to tag a and delete selected option 
    var a = _('confirm_delete_multi');
    a.href = 'delete_activitylog.php?confirm_delete_range=true&' + _('delete_range_select').value;
}

/* Design Calendar */
const daysTag = document.querySelector(".days"),
    currentDate = document.querySelector(".current-date"),
    prevNextIcon = document.querySelectorAll(".icons i");

// getting new date, current year and month
let date = new Date(),
    currYear = date.getFullYear(),
    currMonth = date.getMonth();

// storing full name of all months in array
const months = ["January", "February", "March", "April", "May", "June", "July",
    "August", "September", "October", "November", "December"];

const renderCalendar = () => {
    let firstDayofcurMonth = new Date(currYear, currMonth, 1).getDay(), // getting first day of current month
        lastDateofcurMonth = new Date(currYear, currMonth + 1, 0).getDate(), // getting last date of current month
        lastDayofcurMonth = new Date(currYear, currMonth, lastDateofcurMonth).getDay(), // getting last day of currentmonth
        lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate(); // getting last date of previous month
    /*getDay(): get weekday from 0-6; getDate(): get day from 1-31 */
    let liTag = "";
    /*Firstly, push last days of previous month */
    for (let i = firstDayofcurMonth; i > 0; i--) { // creating li of previous month last days
        liTag += `<li onclick="delParticularDay(this)" class="inactive">${lastDateofLastMonth - i + 1}<span> ${currMonth + 1}</span><span> ${currYear}</span></li>`;
    }
    /*Secondly, push days of current month */
    for (let i = 1; i <= lastDateofcurMonth; i++) { // creating li of all days of current month
        // adding active class to li if the current day, month, and year matched
        let isToday = i === date.getDate() && currMonth === new Date().getMonth()
            && currYear === new Date().getFullYear() ? "today" : "";
        liTag += `<li onclick=" delParticularDay(this)" class="${isToday}">${i}<span> ${currMonth + 1}</span><span> ${currYear}</span></li>`;
    }
    /*Lastly, push days of next month */
    for (let i = lastDayofcurMonth; i < 6; i++) { // creating li of next month first days
        liTag += `<li onclick=" delParticularDay(this)" class="inactive">${i - lastDayofcurMonth + 1}<span> ${currMonth + 1}</span><span> ${currYear}</span></li>`
    }
    currentDate.innerText = `${months[currMonth]} ${currYear}`; // passing current mon and yr as currentDate text
    daysTag.innerHTML = liTag;
}
renderCalendar(); //display current month

prevNextIcon.forEach(icon => { // getting prev and next icons
    icon.addEventListener("click", () => { // adding click event on both icons
        // if clicked icon is previous icon then decrement current month by 1 else increment it by 1
        currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

        if (currMonth < 0 || currMonth > 11) { // if current month is less than 0 or greater than 11
            // creating a new date of current year & month and pass it as date value
            date = new Date(currYear, currMonth, new Date().getDate());
            currYear = date.getFullYear();// updating current year with new date year
            currMonth = date.getMonth(); // updating current month with new date month
        } else {
            date = new Date(); // pass the current date as date value
        }
        renderCalendar(); // calling renderCalendar function to display selected month
    });
});
function delParticularDay(obj) {
    obj.classList.toggle('active');
}