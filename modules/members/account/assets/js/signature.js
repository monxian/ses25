const canvas = document.querySelector("canvas");
const form = document.querySelector(".signature-pad-form");
const clearButton = document.querySelector(".clear-button");
const ctx = canvas.getContext("2d");
let writingMode = false;

form.addEventListener("submit", (e) => {
  e.preventDefault();

  const imageBase64 = canvas.toDataURL("image/png");
  saveToDatabase(imageBase64);

  clearPad();  
  
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

ctx.lineWidth = 2;
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

function closeModal(closeModal) {
  const modal = document.getElementById(closeModal);
  modal.style.display = "none";
  document.body.classList.remove("body-no-scroll");
}

function saveToDatabase(imageData) {
  fetch("members-account/save_signature", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ image: imageData }),
  })
    .then((response) => response.text())
    .then((result) => {
       console.log("Server Response:", result);
       window.location.href = "members-account/your_account";

    })
    .catch((error) => {
       console.error("Error:", error);
    });
}
