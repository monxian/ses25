<div id="formCarousel" class="carousel">
    <!-- Section 1 -->
    <section class="carousel-item active">
        <section class="main-sec">
            <div class="container cont-sm">
                <div class="container-header pb8 flex align-center justify-between">
                    <div>
                        <h2>Service Ticket</h2>
                        <div>for <span class="large-text"><b><?= $job_info->job_name ?></b></span></div>
                    </div>
                    <div>
                        step 1 of 8
                    </div>
                </div>
                <?php

                $form_id['id'] = 'addr-form';
                echo form_open('#', $form_id);

                echo form_label('Name', array('class' => 'accent'));
                echo '<input type="text" name="job_name" value="' . $job_name . '" required>';

                echo form_label('Phone', array('class' => 'accent'));
                echo form_input('job_phone', $job_phone);

                echo form_label('Address', array('class' => 'accent'));
                $attributes['required'] = 'required';
                echo form_input('job_addr', $job_addr, $attributes);

                echo form_label('Apt or Suite', array('class' => 'accent'));
                echo form_input('job_apt', $job_apt);

                echo form_label('City', array('class' => 'accent'));
                echo form_input('job_city', $job_city, $attributes);

                echo form_label('State', array('class' => 'accent'));
                echo form_input('job_state', $job_state, $attributes);

                echo form_label('County', array('class' => 'accent'));
                echo form_input('job_county', $job_county, $attributes);

                echo form_label('Zip', array('class' => 'accent'));
                echo form_input('job_zip', $job_zip, $attributes);

                echo '<div class="form-btns">';
                echo  '<a href="jobs/day_view" class="button btn-secondary">Cancel</a>';

                echo '<button type="button" class="next">Next</button>';
                echo form_close();
                ?>
            </div>
        </section>
    </section>


    <!-- Section 2 -->
    <section class="carousel-item">
        <section class="main-sec">
            <div class="container cont-sm">
                <div class="container-header pb8 flex align-center justify-between">
                    <div>
                        <h2>Service Ticket</h2>
                            <div>for <span class="large-text"><b><?= $job_info->job_name ?></b></span></div>
                    </div>
                    <div>
                        step 2 of 8
                    </div>
                </div>
                <?php

                $form_id['id'] = 'account-form';
                echo form_open('#', $form_id);

                echo form_label('Service Request', array('class' => 'accent'));
                echo '<input list="options" name="job_srq" required  class="datalist-input"/>
                        <datalist id="options">
                            <option value="Annual Fire Alarm Test and Inspection">
                            <option value="Trouble condidtion on panel">
                            <option value="Zone in faulted">
                        </datalist>';

                //$attributes['required'] = 'required';
                // echo form_input('job_srq', $job_srq, $attributes);

                echo form_label('Make/Model', array('class' => 'accent'));
                echo form_input('job_make', $job_make);

                echo form_label('Account', array('class' => 'accent'));
                echo form_input('job_acc', $job_acc);

                echo form_label('Proposal #', array('class' => 'accent'));
                echo form_input('job_proposal', $job_proposal);

                echo form_label('Purchase Order #', array('class' => 'accent'));
                echo form_input('job_purchase', $job_purchase);

                echo '<div class="form-btns">';
                echo  ' <button type="button" class="prev">Back</button>';

                echo '<button type="button" class="next">Next</button>';
                echo form_close();
                ?>
            </div>
        </section>
    </section>

    <!-- Section 3 -->
    <section class="carousel-item">
        <section class="main-sec">
            <div class="container cont-sm">
                <div class="container-header pb8 flex align-center justify-between">
                    <div>
                        <h2>Service Ticket</h2>
                            <div>for <span class="large-text"><b><?= $job_info->job_name ?></b></span></div>
                    </div>
                    <div>
                        step 3 of 8
                    </div>
                </div>
                <div>
                    <p>Add any parts here or next to proceed</p>
                    <?php
                    $form_id['id'] = 'partsDetails';
                    echo form_open('#', $form_id);

                    echo '<div class="form-wrap">';
                    echo form_label('Qty', array('class' => 'accent'));
                    $attributes['id'] = 'part_qty';
                    $attributes['min'] = '1';
                    echo form_number('part_qty', $part_qty, $attributes);

                    echo form_label('Part Number', array('class' => 'accent'));
                    $attributes['id'] = 'part_num';
                    echo form_input('part_num', $part_num, $attributes);

                    echo form_label('Description', array('class' => 'accent'));
                    $attributes['id'] = 'part_desc';
                    echo form_input('part_desc', $part_desc, $attributes);
                    echo '<br>';
                    echo  '<button type="button" id="addPart" class="add-part">Add</button>';
                    echo '</div>';
                    ?>
                    <div class="pt16">
                        <h3>Added Parts</h3>
                        <ul id="partsList">
                            <?= $parts_list ?>
                        </ul>
                    </div>

                    <?php
                    echo '<div class="form-btns">';
                    echo  '<button type="button" class="prev">Back</button>';
                    echo '<button type="button" class="next">Next</button>';
                    echo form_close();
                    ?>
                </div>
            </div>
        </section>
    </section>

    <!-- Section 4 -->
    <section class="carousel-item">
        <section class="main-sec">
            <div class="container cont-sm">
                <div class="container-header pb8 flex align-center justify-between">
                    <div>
                        <h2>Service Ticket</h2>
                            <div>for <span class="large-text"><b><?= $job_info->job_name ?></b></span></div>
                    </div>
                    <div>
                        step 4 of 8
                    </div>
                </div>
                <div>
                    <p>What did you do at the job? </p>
                    <?php
                    $form_id['id'] = 'summary';
                    echo form_open('#', $form_id);

                    echo form_label('Service Summary', array('class' => 'accent'));
                    echo form_textarea('service_summary', $service_summary, array('id' => 'textSumInput', 'rows' => '15', 'cols' => '30'));
                  
                    echo '<div class="form-btns">';
                    echo '<button type="button" class="prev">Back</button>';
                    echo '<button type="button" class="next">Next</button>';
                    echo form_close();
                    ?>


                </div>
            </div>
        </section>
    </section>


    <!-- Section 5 -->
    <section class="carousel-item">
        <section class="main-sec">
            <div class="container cont-sm">
                <div class="container-header pb8 flex align-center justify-between">
                    <div>
                        <h2>Service Ticket</h2>
                            <div>for <span class="large-text"><b><?= $job_info->job_name ?></b></span></div>
                    </div>
                    <div>
                        step 5 of 8
                    </div>
                </div>
                <?php

                $form_id['id'] = 'time-form';
                echo form_open('#', $form_id);

                echo form_label('Time Arrived', array('class' => 'accent'));
                echo '<input type="time" name="time_ta" value="' . $time_ta . '" required>';

                echo form_label('Time Completed', array('class' => 'accent'));
                echo '<input type="time" name="time_tc" value="' . $time_tc . '" required>';

                
                if($time_dc == ""){                   
                    $time_dc = date('Y-m-d');
                }           
                echo form_label('Date Completed', array('class' => 'accent'));
                echo '<input type="date" name="time_dc" value="' . $time_dc . '" required>';


                echo '<div class="form-btns">';
                echo  ' <button type="button" class="prev">Back</button>';

                echo '<button type="button" class="next">Next</button>';
                echo form_close();
                ?>
            </div>
        </section>
    </section>

    <!-- Section 6 -->
    <section class="carousel-item">
        <section class="main-sec">
            <div class="container cont-sm">
                <div class="container-header pb8 flex align-center justify-between">
                    <div>
                        <h2>Service Ticket</h2>
                            <div>for <span class="large-text"><b><?= $job_info->job_name ?></b></span></div>
                    </div>
                    <div>
                        step 6 of 8
                    </div>
                </div>
                <?php

                $form_id['id'] = 'time-ex-form';
                echo form_open('#', $form_id);

                echo form_label('Travel Time', array('class' => 'accent'));
                echo '<input type="number" name="time_tt" step="0.1" min="0.1" value="' . $time_tt . '" >';

                echo form_label('Emergency Time', array('class' => 'accent'));
                echo '<input type="number" name="time_et" step="0.1" min="0.1" value="' . $time_et . '" >';

                echo form_label('Over Time', array('class' => 'accent'));
                echo '<input type="number" name="time_ot" step="0.1" min="0.1" value="' . $time_ot . '" >';
        

                echo '<div class="form-btns">';
                echo  ' <button type="button" class="prev">Back</button>';

                echo '<button type="button" class="next">Next</button>';
                echo form_close();
                ?>
            </div>
        </section>
    </section>


    <!-- Section 7 -->
    <section class="carousel-item">
        <section class="main-sec">
            <div class="container cont-sm">
                <div class="container-header pb8 flex align-center justify-between">
                    <div>
                        <h2>Service Ticket</h2>
                            <div>for <span class="large-text"><b><?= $job_info->job_name ?></b></span></div>
                    </div>
                    <div>
                        step 7 of 8
                    </div>
                </div>
                <?php

                $form_id['id'] = 'email-form';
                echo form_open('#', $form_id);

                echo form_label('Email', array('class' => 'accent'));
                echo '<input type="email" name="send_to_email" value="' . $send_to_email . '" placeholder="Email for ticket to be send to" required>';


                echo '<div class="form-btns">';
                echo  ' <button type="button" class="prev">Back</button>';

                echo '<button type="button" class="next">Next</button>';
                echo form_close();
                ?>
            </div>
        </section>
    </section>

    <!-- Section 7 -->
    <section class="carousel-item" id="service-summary-final-section">
        <section class="main-sec">
            <div class="container cont-sm">
                <div class="container-header pb8 flex align-center justify-between">
                    <div>
                        <h2>Service Ticket</h2>
                    </div>
                    <div>
                        step 8 of 8
                    </div>
                </div>

                <div class="p8 mb-32 round-sm bg-secondary dark-box-shadow" id="service-summary-final"></div>
                <div class="m8">
                    <button onclick="openSignModal()" class="flex align-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                <path d="m16.214 4.982l1.402-1.401a1.982 1.982 0 0 1 2.803 2.803l-1.401 1.402m-2.804-2.804l-5.234 5.234c-1.045 1.046-1.568 1.568-1.924 2.205S8.342 14.561 8 16c1.438-.342 2.942-.7 3.579-1.056s1.16-.879 2.205-1.924l5.234-5.234m-2.804-2.804l2.804 2.804" />
                                <path d="M21 12c0 4.243 0 6.364-1.318 7.682S16.242 21 12 21s-6.364 0-7.682-1.318S3 16.242 3 12s0-6.364 1.318-7.682S7.758 3 12 3" />
                            </g>
                        </svg>Signature Required</button>
                    <div class="cust-signature">
                        <img src="<?= $image_data ?>" alt="">
                    </div>
                    <div class="cust-name-printed">
                        <?php
                        echo form_label('Print Name', array('class' => 'accent'));
                        echo '<input type="text" name="printed-name" value="' . $printed_name . '" required>';
                        ?>
                    </div>
                </div>


                <div class="form-btns">
                    <button type="button" class="prev">Back</button>
                    <button type="button" class="create-ticket">Submit</button>
                </div>
        </section>
    </section>
</div>

<div class=" st-modal" id="signModal">
    <div class="st-modal-content">
        <div class="st-modal-header flex-row justify-between">
            <h3>Customer Signature</h3>
            <div onclick="closeModal('signModal')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <rect width="24" height="24" fill="none" />
                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                        <path d="M15.5 8.5L12 12m0 0l-3.5 3.5M12 12l3.5 3.5M12 12L8.5 8.5" />
                        <circle cx="12" cy="12" r="10" />
                    </g>
                </svg></div>
        </div>
        <div class="st-modal-body">
            <p>Please sign and Print below</p>
            <form id="signature" action="#" method="post" class="signature-pad-form">
                <canvas height="100" width="300" class="signature-pad"></canvas>
                <div class="st-modal-footer">
                    <button type="submit" class="button btn-primary-45">Submit</button>
                    <a href="#" class="clear-button button btn-secondary">Clear Pad</a>
                </div>
            </form>
        </div>
    </div>
</div>



<style>
    /* Link to the service_tickets/assets/css/custom.css */
    @import url('<?= BASE_URL ?>service_tickets_module/css/ticket-flow.css');
</style>

<!-- Link to the assets/js/custom.js -->
<script src="<?= BASE_URL ?>service_tickets_module/js/signature.js"></script>
<script>
    const carouselItems = document.querySelectorAll(".carousel-item");
    let currentIndex = 0;

    // Show the current section with animation
    const updateCarousel = (direction) => {
        carouselItems.forEach((item, index) => {
            item.classList.remove("active", "prev", "next");

            if (index === currentIndex) {
                item.classList.add("active");
            } else if (direction === "next" && index === currentIndex - 1) {
                item.classList.add("prev");
            } else if (direction === "prev" && index === currentIndex + 1) {
                item.classList.add("next");
            }
        });
    };

    // Next button functionality
    document.querySelectorAll(".next").forEach((btn) =>
        btn.addEventListener("click", () => {
            if (currentIndex < carouselItems.length - 1) {
                currentIndex++;
                updateCarousel("next");
            }
        })
    );

    // Previous button functionality
    document.querySelectorAll(".prev").forEach((btn) =>
        btn.addEventListener("click", () => {
            if (currentIndex > 0) {
                currentIndex--;
                updateCarousel("prev");
            }
        })
    );

    // Initialize the first section
    updateCarousel();



    const saveSectionToLocalStorage = (formId) => {
        if (formId === "partsDetails") {
            console.log("Skipping save for partsDetails; parts are already saved dynamically.");
            return;
        }
        const form = document.getElementById(formId);
        const formData = new FormData(form);
        const savedData = JSON.parse(localStorage.getItem("multiSectionForm")) || {};
        if (!savedData[formId]) {
            savedData[formId] = {}; // Initialize if it doesn't exist
        }


        // Save the current section data
        savedData[formId] = {};
        formData.forEach((value, key) => {
            if (key !== "csrf_token") {
                savedData[formId][key] = value;
            }

        });

        localStorage.setItem("multiSectionForm", JSON.stringify(savedData));
        console.log(`Saved data for ${formId}:`, savedData[formId]);
    };

    // Add event listener for Next buttons
    document.querySelectorAll(".next").forEach((btn) => {
        btn.addEventListener("click", (e) => {
            const formId = e.target.closest("form").id; // Get the current form ID
            saveSectionToLocalStorage(formId);



            // Optionally, move to the next section (if using a carousel or other navigation)
            // For example: updateCarousel("next");
        });
    });

    // Restore saved data on page load
    document.addEventListener("DOMContentLoaded", () => {
        const savedData = JSON.parse(localStorage.getItem("multiSectionForm"));
        if (savedData) {
            Object.keys(savedData).forEach((formId) => {
                const form = document.getElementById(formId);
                if (form) {
                    Object.keys(savedData[formId]).forEach((key) => {
                        const field = form.elements[key];
                        if (field) field.value = savedData[formId][key];
                    });
                }
            });
            console.log("Restored form data from localStorage.");
        }
    });

    document.getElementById("addPart").addEventListener("click", () => {
        const partName = document.getElementById("part_desc").value;
        const partQuantity = document.getElementById("part_qty").value;
        const partNum = document.getElementById("part_num").value;

        //add to localstorage from form and from php previously stored
        partsLocalstorage(partName, partQuantity, partNum);

    });

    function partsLocalstorage(partName, partQuantity, partNum) {
        if (partName && partQuantity && partNum) {
            const savedData = JSON.parse(localStorage.getItem("multiSectionForm")) || {};
            savedData.parts = savedData.parts || [];
            savedData.parts.push({
                name: partName,
                quantity: partQuantity,
                number: partNum
            });
            localStorage.setItem("multiSectionForm", JSON.stringify(savedData));
            console.log("Part added:", {
                name: partName,
                quantity: partQuantity,
                number: partNum
            });

            // Clear inputs for the next part
            document.getElementById("part_qty").value = "";
            document.getElementById("part_desc").value = "";
            document.getElementById("part_num").value = "";
            renderParts();
        } else {
            alert("Please fill in both part name and quantity.");
        }
    }


    const renderParts = () => {
        const partsList = document.getElementById("partsList");
        const savedData = JSON.parse(localStorage.getItem("multiSectionForm")) || {};
        const parts = savedData.parts || [];

        // Clear the current list
        partsList.innerHTML = "";

        // Render each part
        parts.forEach((part, index) => {
            const listItem = document.createElement("li");
            listItem.classList.add('part-item');
            listItem.innerHTML = ` ${part.name} (Quantity: ${part.quantity})
                                    <div type="button" class="deletePart" data-index="${index}">
                                      X
                                    </div>
                                `;
            partsList.appendChild(listItem);
        });
    };

    document.getElementById("partsList").addEventListener("click", (e) => {
        if (e.target.classList.contains("deletePart")) {
            const index = e.target.getAttribute("data-index");
            const savedData = JSON.parse(localStorage.getItem("multiSectionForm")) || {};
            savedData.parts = savedData.parts || [];
            savedData.parts.splice(index, 1); // Remove the part at the given index
            localStorage.setItem("multiSectionForm", JSON.stringify(savedData));
            console.log(`Part at index ${index} deleted.`);

            // Re-render the parts list
            renderParts();
        }
    });

    // Render parts on page load from the php storage 
    // also for signed image base64
    document.addEventListener("DOMContentLoaded", () => {
        const signImage = <?= json_encode($image_data) ?>;
        let partsArray = <?= json_encode($parts); ?>;

        //Load the localstorage or load from the database
        const formData = JSON.parse(localStorage.getItem("multiSectionForm")) || {};
        const localStorageParts = formData["parts"] || []; // Retrieve the parts array
        if (Array.isArray(localStorageParts) && localStorageParts.length > 0) {
            renderParts();
        } else if (partsArray) {
            partsArray.forEach(part => {
                partsLocalstorage(part.name, part.quantity, part.number);
            })
        }

        if (signImage) {
            addSignatureFromDB();
        }
    });

    //onload add image from php storage
    function addSignatureFromDB() {
        const formData = JSON.parse(localStorage.getItem("multiSectionForm")) || {};
        // Add the image to the `multiSectionForm`
        formData["image"] = `<?= $image_data ?>`;
        // Save the updated formData back to localStorage
        localStorage.setItem("multiSectionForm", JSON.stringify(formData));
    }



    document.addEventListener("DOMContentLoaded", () => {
        // Delegate the event listener to a stable parent container
        document.body.addEventListener("click", (event) => {
            if (event.target.classList.contains("next")) {
                const currentSection = document.querySelector(".carousel-item.active");

                // Check if the current section is the service summary section
                if (currentSection && currentSection.id === "service-summary-final-section") {
                    loadServiceSummary(); // Load service summary data
                }
            }
        });

        // Function to load the service summary
        function loadServiceSummary() {
            const serviceSummaryContainer = document.getElementById("service-summary-final");

            // Retrieve the summary object from localStorage
            const formData = JSON.parse(localStorage.getItem("multiSectionForm")) || {};
            const serviceSummary = formData["summary"] ? formData["summary"]["service_summary"] : null; // Access nested service_summary
            const parts = formData["parts"] || []; // Retrieve the parts array

            let partsListHTML = "";

            if (parts.length > 0) {
                partsListHTML = `
                    <h4>Parts Used:</h4>
                    <ul>
                        ${parts.map(part => `<li>${part.name} (${part.quantity})</li>`).join("")}
                    </ul>
                `;
            } else {
                partsListHTML = `<p>No parts used.</p>`;
            }
            if (serviceSummary) {
                serviceSummaryContainer.innerHTML = `
                <div class="service-summary">
                    <h3>Summary of Work Done</h3>
                    <p>${serviceSummary}</p>
                    <div class="pt8">  ${partsListHTML} </div>
                </div>
            `;
            } else {
                serviceSummaryContainer.innerHTML = `<p>No service summary available.</p>`;
            }
        }
    });


    const textInput = document.getElementById("textSumInput");
    const wordCountDisplay = document.getElementById("wordCount");
    let timeout;
    textInput.addEventListener("input", () => {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            const text = textSumInput.value.trim();
            const words = text === "" ? 0 : text.split(/\s+/).length;
            wordCountDisplay.textContent = words;
        }, 300); // Wait 300ms after the user stops typing
    });


    document.addEventListener("DOMContentLoaded", () => {
        const submitButton = document.querySelector(".create-ticket");

        submitButton.addEventListener("click", (e) => {
            e.preventDefault(); // Prevent default form submission

            // Retrieve all data from localStorage
            const formData = JSON.parse(localStorage.getItem("multiSectionForm")) || {};

            // Include any other final form fields if necessary
            const printedName = document.querySelector('input[name="printed-name"]').value;

            // Add printed name to form data
            formData["printed_name"] = printedName;

            // Send the data to the server via AJAX (using Fetch API)
            fetch("service_tickets/save_ticket/<?= $job_code ?>", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData), // Send all form data as JSON
                })
                .then(response => response.json()) // Assuming your server returns JSON
                .then(data => {
                    console.log('Ticket saved successfully', data);

                    // Optionally handle success (e.g., show a success message)
                    // For example, redirect the user or clear the form
                    localStorage.removeItem("multiSectionForm"); // Clear the localStorage after success

                    // Optionally redirect to another page after submission
                    window.location.href = 'service_tickets/email_ticket/<?= $job_code ?>'; // Redirect example
                })
                .catch(error => {
                    console.error('Error saving ticket:', error);
                    // Handle the error (e.g., show an error message)
                });
        });
    });
</script>