const canvas = document.querySelector("canvas");
const form = document.querySelector(".signature-pad-form");
const clearButton = document.querySelector(".clear-button");
const ctx = canvas.getContext("2d");
let writingMode = false;

form.addEventListener("submit", (e) => {
  e.preventDefault();
  let cust_div = document.getElementById("cust-signature");
  let printedName = document.getElementById("printed-name").value;
  document.getElementById("cust-print-name").innerText = printedName;
  cust_div.innerHTML = "";

  const imageURL = canvas.toDataURL();
  const image = document.createElement("img");
  image.src = imageURL;
  image.height = canvas.height;
  image.width = canvas.width;
  image.style.display = "block";
  cust_div.appendChild(image);

  const imageBase64 = canvas.toDataURL("image/png");

  const imageData = {
    imageBase64,
    printedName
  };
  localStorage.setItem("signature", JSON.stringify(imageData));

  clearPad();

  const modal = document.getElementById("signModal");
  modal.style.display = "none";
  modal.classList.remove("body-no-scroll");
  document.querySelector(".btn-sign").classList.add("visited");
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
