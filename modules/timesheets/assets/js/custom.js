function convertTimeTo12HourFormat(time) {
    // Parse the input time into hours and minutes
    var parts = time.split(":");
    var hours = parseInt(parts[0]);
    var minutes = parseInt(parts[1]);

    // Determine the period (AM or PM)
    var period = hours >= 12 ? "pm" : "am";

    // Convert hours to 12-hour format
    hours = hours % 12 || 12;

    // Add leading zeros to minutes if necessary
    minutes = minutes < 10 ? "0" + minutes : minutes;

    // Return the converted time
    return hours + ":" + minutes + " " + period;
}

// Function to convert all times on the page
function convertAllTimesTo12HourFormat() {
    var timeElements = document.querySelectorAll(".time-conv");

    // Loop through each time element and convert the time
    for (var i = 0; i < timeElements.length; i++) {
        var timeElement = timeElements[i];
        var time = timeElement.textContent;

        // Convert the time and update the content of the element
        timeElement.textContent = convertTimeTo12HourFormat(time);
    }
}

// Call the function to convert all times when the page finishes loading
window.addEventListener("load", convertAllTimesTo12HourFormat);