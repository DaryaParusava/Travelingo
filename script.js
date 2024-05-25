document.addEventListener("DOMContentLoaded", function() {
    updateTimeSinceApril6();
    setInterval(updateTimeSinceApril6, 1000);
});

document.addEventListener("DOMContentLoaded", function() {
    setInterval(displayTime, 1000);
});

document.addEventListener("DOMContentLoaded", function() {
    var countDownDate = new Date("May 8, 2024 00:00:00").getTime();

    var x = setInterval(function() {
        var now = new Date().getTime();
        var distance = countDownDate - now;
        var seconds = Math.floor(distance / 1000);
        var countdownElement = document.getElementById("countdown");
        if (countdownElement) {
            countdownElement.innerHTML = "Do końca rekrutacji zostało: " + seconds + " sekund";
        }
        if (distance <= 0) {
            clearInterval(x);
            countdownElement.innerHTML = "Отсчет завершен";
        }
    }, 1000);
});

function updateTimeSinceApril6() {
    var april6 = new Date(2024, 3, 6);
    var now = new Date();
    var difference = now - april6;
    var days = Math.floor(difference / (1000 * 60 * 60 * 24));
    var hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((difference % (1000 * 60)) / 1000);

    var timeSinceApril6Element = document.getElementById("timeSinceApril6");
    if (timeSinceApril6Element) {
        timeSinceApril6Element.innerHTML = "<h5>NASZA FIRMA ISTNIEJE JUŻ: " + days + " dni " + hours + " godzin, " + minutes + " minut, " + seconds + " sekund</h5>";
    }
}

function displayTime() {
    var today = new Date();
    var dayOfWeek = ["niedziela", "poniedziałek", "wtorek", "środa", "czwartek", "piątek", "sobota"];
    var day = today.getDate();
    var month = today.getMonth() + 1;
    var year = today.getFullYear();
    var hours = today.getHours();
    var minutes = today.getMinutes();
    var seconds = today.getSeconds();
    hours = checkTime(hours);
    minutes = checkTime(minutes);
    seconds = checkTime(seconds);
    day = checkTime(day);
    month = checkTime(month);

    var timeString = hours + ":" + minutes + ":" + seconds;
    var dateString = year + "-" + month + "-" + day;
    var dayOfWeekString = dayOfWeek[today.getDay()];

    var timeDisplayElement = document.getElementById("timeDisplay");
    if (timeDisplayElement) {
        timeDisplayElement.innerHTML = "<h1 id='h1'>dzisiaj jest " + dayOfWeekString + " | " + dateString + " | " + timeString + "</h1>";
    }
}

function checkTime(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}
