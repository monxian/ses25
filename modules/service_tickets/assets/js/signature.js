const canvas = document.querySelector("canvas");
const form = document.querySelector(".signature-pad-form");
const cust_div = document.querySelector(".cust-signature");
const cust_name = document.querySelector(".cust-name-printed");
const clearButton = document.querySelector(".clear-button");
const ctx = canvas.getContext("2d");    
let writingMode = false;

form.addEventListener("submit", (e) => {
  e.preventDefault();

  cust_div.style.display="flex";
  cust_name.style.display="flex";
  cust_div.innerHTML = "";

  const imageURL = canvas.toDataURL();
  const image = document.createElement('img');
  image.src = imageURL;
  image.height = canvas.height;
  image.width = canvas.width;
  image.style.display = "block"; 
  cust_div.appendChild(image); 

  const imageBase64 = canvas.toDataURL("image/png");
  // Retrieve the existing `multiSectionForm` data from localStorage
  const formData = JSON.parse(localStorage.getItem("multiSectionForm")) || {};
  // Add the image to the `multiSectionForm`
  formData["image"] = imageBase64;
  // Save the updated formData back to localStorage
  localStorage.setItem("multiSectionForm", JSON.stringify(formData));


  //saveToDatabase(imageBase64);

  clearPad();
  document.body.classList.remove("body-no-scroll");
  closeModal("signModal");

  
});

const clearPad = () => {
  ctx.clearRect(0, 0, canvas.width, canvas.height);  
};

clearButton.addEventListener("click", (e) => {
  e.preventDefault();
  clearPad();
});

const getTargetPosition = (e) => {
  positionX = e.clientX - e.target.getBoundingClientRect().x;
  positionY = e.clientY - e.target.getBoundingClientRect().y;

  return [positionX, positionY];
};

const handlePointerMove = (e) => {
  if (!writingMode) return;
  const [positionX, positionY] = getTargetPosition(e);
  ctx.lineTo(positionX, positionY);
  ctx.stroke();
};

const handlePointerUp = () => {
  writingMode = false;
};

const handlePointerDown = (e) => {
  console.log("pointer down");
  writingMode = true;
  ctx.beginPath();
  const [positionX, positionY] = getTargetPosition(e);
  ctx.moveTo(positionX, positionY);
};

ctx.lineWidth = 3;
ctx.lineJoin = ctx.lineCap = "round";

canvas.addEventListener("pointerdown", handlePointerDown, { passive: true });
canvas.addEventListener("pointerup", handlePointerUp, { passive: true });
canvas.addEventListener("pointermove", handlePointerMove, { passive: true });

//Open modals
function openSignModal() {
  const modal = document.getElementById("signModal");
  modal.style.display = "block";
  document.body.classList.add("body-no-scroll");
}

function closeModal(closeModal){
     const modal = document.getElementById(closeModal);   
     modal.style.display = "none";
     document.body.classList.remove("body-no-scroll");
}


function saveToDatabase(imageData){
    fetch("service_tickets/save_signature", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ image: imageData }),
    })
      .then((response) => response.json())
      .then((data) => {
        console.log("Image saved:", data);
      })
      .catch((error) => {
        console.error("Error saving image:", error);
      });

}

function saveImageToLocalStorage() {
  // Get the canvas element
  const canvas = document.querySelector(".signature-pad");

  // Convert the canvas content to a Base64 string
  const imageBase64 = canvas.toDataURL("image/png");

  // Retrieve the existing `multiSectionForm` data from localStorage
  const formData = JSON.parse(localStorage.getItem("multiSectionForm")) || {};

  // Add the image to the `multiSectionForm`
  formData["image"] = imageBase64;

  // Save the updated formData back to localStorage
  localStorage.setItem("multiSectionForm", JSON.stringify(formData));

  console.log("Image saved to multiSectionForm!");
}

