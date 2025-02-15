// Add your JavaScript here
function modalClose(id){    
    const partQty = document.getElementById('part-qty');
    const showQty = document.getElementById("show-truck-qty-"+id);
    const lowLevel = document.getElementById("low-level-" + id);

    const ll = lowLevel.dataset.ll;  
    let numOne = +partQty.innerText;
    let numTwo = +ll;
   
    if(numOne <= numTwo){
        if (lowLevel.classList.contains("hide")) {
          lowLevel.classList.remove("hide");
        }
      
    } else {
         lowLevel.classList.add("hide");
    }

    showQty.innerText = "Truck Qty: " + partQty.innerText;
    closeModal();
}

