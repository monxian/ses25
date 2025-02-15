//get the modal forms
const addrForm = document.getElementById("addr-form");
const accountForm = document.getElementById("acc-form");
const partsForm = document.getElementById("parts-form");
const summaryForm = document.getElementById("sSum-form");
const timeForm = document.getElementById("time-form");

addrForm.addEventListener("submit", addrFormSubmit);
accountForm.addEventListener("submit", accountFormSubmit);
partsForm.addEventListener("submit", partsFormSubmit);
summaryForm.addEventListener("submit", summaryFormSubmit);
timeForm.addEventListener("submit", timeFormSubmit);



function openAddrModal() {
  const modal = document.getElementById("addrModal");
  modal.style.display = "block";
}
function openAccModal() {
  const modal = document.getElementById("accModal");
  modal.style.display = "block";
}
function openPartsModal() {
  const modal = document.getElementById("partsModal");
  modal.style.display = "block";
}

function openSummaryModal() {
  const modal = document.getElementById("sSumModal");
  modal.style.display = "block";
}

function openTimeModal() {
  const modal = document.getElementById("timeModal");
  modal.style.display = "block";
}

function openSignatureModal(){
    const modal = document.getElementById("signModal");
    modal.style.display = "block";
    modal.classList.add("body-no-scroll");
}

function openResetModal(){
    const modal = document.getElementById("clearModal");
    modal.style.display = "block";
}

function closeModal(clickedModal){   
  const modal = document.getElementById(clickedModal); 
  modal.style.display = "none";
}

function clearTicket(){
    localStorage.clear();
    const modal = document.getElementById('clearModal');
    modal.style.display = "none";

      populateFormData();
      populateAccountData();
      populatePartstData();
      populateSummaryData();
      populateTimeData();
}


function saveData(){
  
}



// Function to handle form submission
function addrFormSubmit(event) {     
  event.preventDefault(); // Prevent the default form submission 

  // Get the form values
  const name = document.getElementById("name").value;
  const phone = document.getElementById("phone").value;
  const address = document.getElementById("address").value;
  const apt = document.getElementById("apt").value;
  const county = document.getElementById("county").value;
  const city = document.getElementById("city").value;
  const state = document.getElementById("state").value;
  const zip = document.getElementById("zip").value;

  // Store form values in local storage
  const jobData = {
    name,
    phone,
    address,
    apt,
    city,
    county,
    state,
    zip,
  };

  localStorage.setItem("jobData", JSON.stringify(jobData));

  // Populate the HTML with stored data
  populateFormData();
  console.log("poplate form");
  document.getElementById("addrModal").style.display = "none";

  document.querySelector('.btn-addr').classList.add('visited');
}

// Function to populate form data from local storage
function populateFormData() {
  const storedData = JSON.parse(localStorage.getItem("jobData"));

  if (storedData) {
    // Populate the fields with the stored data
    document.getElementById("name").value = storedData.name || "";
    document.getElementById("phone").value = storedData.phone || "";
    document.getElementById("address").value = storedData.address || "";
    document.getElementById("apt").value = storedData.apt || "";
    document.getElementById("city").value = storedData.city || "";
    document.getElementById("county").value = storedData.county || "";
    document.getElementById("state").value = storedData.state || "";
    document.getElementById("zip").value = storedData.zip || "";

    document.getElementById("job-name").innerText = storedData.name || "";
    document.getElementById("job-phone").innerText = storedData.phone || "";
    document.getElementById("job-addr").innerText = storedData.address || "";
    document.getElementById("job-apt").innerText = storedData.apt || "";
    document.getElementById("job-city").innerText = storedData.city || "";
    document.getElementById("job-county").innerText = storedData.county || "";
    document.getElementById("job-state").innerText = storedData.state || "";
    document.getElementById("job-zip").innerText = storedData.zip || "";
  }
}

// Function to handle form submission
function accountFormSubmit(event) {
  event.preventDefault(); // Prevent the default form submission

  // Get the form values
  const make = document.getElementById("make").value;
  const account = document.getElementById("account").value;
  const proposal = document.getElementById("proposal").value;
  const purchase = document.getElementById("purchase").value;
  const srq = document.getElementById("srq").value;

  // Store form values in local storage
  const accData = {
    make,
    account,
    proposal,
    purchase,
    srq,
  };
  localStorage.setItem("accData", JSON.stringify(accData));

  // Populate the HTML with stored data
  populateAccountData();
  document.getElementById("accModal").style.display = "none";
  document.querySelector(".btn-acc").classList.add("visited");
}

function populateAccountData() {
  const storedData = JSON.parse(localStorage.getItem("accData"));

  if (storedData) {
    // Populate the fields with the stored data
    document.getElementById("make").value = storedData.make || "";
    document.getElementById("account").value = storedData.account || "";
    document.getElementById("proposal").value = storedData.proposal || "";
    document.getElementById("purchase").value = storedData.purchase || "";
    document.getElementById("srq").value = storedData.srq || "";

    document.getElementById("job-make").innerText = storedData.make || "";
    document.getElementById("job-account").innerText = storedData.account || "";
    document.getElementById("job-proposal").innerText = storedData.proposal || "";
    document.getElementById("job-purchase").innerText = storedData.purchase || "";
    document.getElementById("job-srq").innerText = storedData.srq || "";
  }
}

// Function to handle form submission
function partsFormSubmit(event) {
  event.preventDefault(); // Prevent the default form submission

  // Get the form values
  const qty = document.getElementById("qty").value;
  const partNum = document.getElementById("part-num").value;
  const desc = document.getElementById("desc").value;

  const savedData = JSON.parse(localStorage.getItem("partsData")) || {};
  savedData.parts = savedData.parts || [];
  savedData.parts.push({
    desc: desc,
    qty: qty,
    partNo: partNum,
  });
  localStorage.setItem("partsData", JSON.stringify(savedData));

  // Populate the HTML with stored data
  populatePartstData();
  document.getElementById("partsModal").style.display = "none";
  document.querySelector(".btn-parts").classList.add("visited");
}

function populatePartstData() {
  const storedData = JSON.parse(localStorage.getItem("partsData"));
  let storedLength = 0;
  if (storedData && storedData["parts"] != null) {
    storedLength = storedData["parts"].length;
  } 
  

  if (storedData) {  
    
    const partsTbody = document.getElementById("parts-list");
    partsTbody.innerHTML = "";

    storedData["parts"].forEach((part, index) => {
      const row = createTableRow(part.qty, part.desc, part.partNo, index);
      partsTbody.appendChild(row);

      document.querySelectorAll(".pid-btn").forEach((deleteBtn) => {
        deleteBtn.addEventListener("click", (e) => {
          const index = e.target.getAttribute("data-index");
          console.log(`Deleting part with index: ${index}`);

          const savedData = JSON.parse(localStorage.getItem("partsData")) || {};
          console.log(savedData);

          // Remove part from localStorage
          if (savedData.parts) {
            savedData.parts.splice(index, 1); // Remove part at this index
            localStorage.setItem("partsData", JSON.stringify(savedData)); // Save updated data
            populatePartstData(); // Re-render the list
          }
        });
      });
    });

    if(storedLength < 5){        
        let loops = 5 - storedLength;
        for(let i = 0; i < loops; i++ ){       
          let emptyRow = createTableRow();
          partsTbody.appendChild(emptyRow);
        }
    }
  }
  // clear form
   document.getElementById("qty").value = "";
   document.getElementById("part-num").value ="";
   document.getElementById("desc").value = "";
}


function createTableRow(qty='', desc='', partNo='', index='') {
  const row = document.createElement("tr");
  const td1 = document.createElement("td");
  td1.className = "col-10";
  td1.innerText = qty;

  const td2 = document.createElement("td");
  td2.className = "col-30 bl3";
  td2.innerText = partNo;

  const td3 = document.createElement("td");
  td3.className = "col-60 bl3 part-desc";
  td3.innerText = desc;


  const deleteBtn = document.createElement("span");
  
  if ((qty < 1)) {
     deleteBtn.innerHTML = "";
    } else{
     deleteBtn.innerHTML = `<span class="pid-btn" data-index="${index}">X</span>`;
    }
  td3.appendChild(deleteBtn);

  row.appendChild(td1);
  row.appendChild(td2);
  row.appendChild(td3);

  return row;
}


function summaryFormSubmit(event) {
  event.preventDefault(); // Prevent the default form submission

  // Get the form values
  const summary = document.getElementById("summary").value;

  // Store form values in local storage
  const summaryData = {
    summary,
  };

  localStorage.setItem("summaryData", JSON.stringify(summaryData));

  // Populate the HTML with stored data
  populateSummaryData();
  document.getElementById("sSumModal").style.display = "none";
   document.querySelector(".btn-summary").classList.add("visited");
}


function populateSummaryData() {
  const storedData = JSON.parse(localStorage.getItem("summaryData"));

  if (storedData) {
    // Populate the fields with the stored data
    document.getElementById("summary").value = storedData.summary || "";

    document.getElementById("job-summary").innerText = storedData.summary || "";
  }
}


function timeFormSubmit(event) {
  event.preventDefault(); // Prevent the default form submission

  // Get the form values
    const timeTa = document.getElementById("modal-ta").value;
    const timeTc = document.getElementById("modal-tc").value;
    const timeDc = document.getElementById("modal-dc").value;
    const timeTt = document.getElementById("modal-tt").value;
    const timeEt = document.getElementById("modal-et").value;
    const timeOt = document.getElementById("modal-ot").value;

   

  // Store form values in local storage
  const timeData = {
    timeTa,
    timeTc,
    timeDc,
    timeTt,
    timeEt,
    timeOt
   
  };

  localStorage.setItem("timeData", JSON.stringify(timeData));

  // Populate the HTML with stored data
  populateTimeData();
  document.getElementById("timeModal").style.display = "none";
  document.querySelector(".btn-time").classList.add("visited");
}

function populateTimeData() {
  const storedData = JSON.parse(localStorage.getItem("timeData"));

  if (storedData) {
    // Populate the fields with the stored data  
    document.getElementById("modal-ta").value = storedData.timeTa || "";
    document.getElementById("modal-tc").value = storedData.timeTc || "";
    document.getElementById("modal-dc").value = storedData.timeDc || "";
    document.getElementById("modal-tt").value = storedData.timeTt || "";
    document.getElementById("modal-et").value = storedData.timeEt || "";
    document.getElementById("modal-ot").value = storedData.timeOt || "";
   
    let serviceTime = calculateTimeDifference(
      storedData.timeTa,
      storedData.timeTc
    );
    let timeIn = convertTo12HourFormat(storedData.timeTa);
    let timeOut = convertTo12HourFormat(storedData.timeTc);
    document.getElementById("time-ta").innerText = timeIn || "";
    document.getElementById("time-tc").innerText = timeOut || "";
    document.getElementById("time-dc").innerText = storedData.timeDc || "";
    document.getElementById("time-tt").innerText = storedData.timeTt || "";
    document.getElementById("time-et").innerText = storedData.timeEt || "";
    document.getElementById("time-ot").innerText = storedData.timeOt || "";
    document.getElementById("time-sl").innerText = serviceTime || "";
  
  
  }
}

function populateSignData() {
  const storedData = JSON.parse(localStorage.getItem("signature"));

  if (storedData) {
  
    document.getElementById("printed-name").value = storedData.printedName || "";
    
    document.getElementById("cust-signature").innerHTML = `<img src="${storedData.imageBase64}">`;
    document.getElementById("cust-print-name").innerText = storedData.printedName;
   
  
  }
}





function convertTo12HourFormat(time24) {
  const [hours, minutes] = time24.split(":").map(Number);
  const period = hours >= 12 ? "PM" : "AM";
  const hours12 = hours % 12 || 12; // Convert 0 to 12 for midnight
  return `${hours12}:${minutes.toString().padStart(2, "0")} ${period}`;
}

function calculateTimeDifference(startTime24, endTime24) {
  const [startHours, startMinutes] = startTime24.split(":").map(Number);
  const [endHours, endMinutes] = endTime24.split(":").map(Number);

  const startTotalMinutes = startHours * 60 + startMinutes;
  const endTotalMinutes = endHours * 60 + endMinutes;

  // Handle cases where the end time is on the next day
  const diffMinutes =
    endTotalMinutes >= startTotalMinutes
      ? endTotalMinutes - startTotalMinutes
      : 1440 - (startTotalMinutes - endTotalMinutes); // 1440 minutes = 24 hours

  // Round to the nearest quarter hour (15 minutes)
  const roundedMinutes = Math.round(diffMinutes / 15) * 15;

  const hoursDiff = Math.floor(roundedMinutes / 60);
  const minutesDiff = roundedMinutes % 60;

  return `${hoursDiff} hrs  ${minutesDiff} mins`;
}











window.addEventListener("load", () => {
  populateFormData();
  populateAccountData();
  populatePartstData();
  populateSummaryData();
  populateTimeData();
  populateSignData();

  //change the button color if populated
  addVisitClass();
});

function addVisitClass(){
    if (localStorage.getItem("accData")) {
      document.querySelector(".btn-addr").classList.add("visited");      
    }
    if (localStorage.getItem("jobData")) {
      document.querySelector(".btn-acc").classList.add("visited");
    }
    if (localStorage.getItem("partsData")) {
      document.querySelector(".btn-parts").classList.add("visited");
    }
    if (localStorage.getItem("summaryData")) {
      document.querySelector(".btn-summary").classList.add("visited");
    }
    if (localStorage.getItem("timeData")) {
      document.querySelector(".btn-time").classList.add("visited");
    }
    if (localStorage.getItem("signature")) {
      document.querySelector(".btn-sign").classList.add("visited");
    }
}
