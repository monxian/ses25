// 1. Retrieve data from localStorage
const accData = JSON.parse(localStorage.getItem('accData'));
const jobData = JSON.parse(localStorage.getItem('jobData'));
const partsData = JSON.parse(localStorage.getItem('partsData'));
const signature = JSON.parse(localStorage.getItem('signature'));
const summaryData = JSON.parse(localStorage.getItem('summaryData'));
const timeData = JSON.parse(localStorage.getItem('timeData'));

// 2. Combine the data into a single object
const combinedData = {
jobData: jobData,
partsData: partsData,
signature: signature,
summaryData: summaryData,
timeData: timeData
};

// 3. Convert the combined object to a JSON string
const jsonData = JSON.stringify(combinedData);

// 4. Send the JSON data to your PHP script using fetch (POST method is recommended for larger data)
fetch(baseUrl+'service_tickets/save_ticket_btns/'+jobCode, { // Replace with your PHP script URL
method: 'POST',
headers: {
'Content-Type': 'application/json' // Important: Set Content-Type to JSON
},
body: jsonData // Send the JSON string in the request body
})
.then(response => {
if (!response.ok) {
return response.text().then(err => {throw new Error(err)});
}
return response.json(); // If the PHP script returns JSON
})
.then(data => {
// Handle the response from the PHP script
console.log('Success:', data);
})
.catch((error) => {
console.error('Error:', error);
});