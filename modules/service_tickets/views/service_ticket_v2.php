   <div class="ticket-page-wrap">
       <div class="nav-wrap">
           <nav>
               <ul class="flx-row jcc">
                   <button class="ticket-btn flx-row btn-addr" onclick="openAddrModal()">
                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                           <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.83 14.254c.298-.323.447-.484.605-.578a1.24 1.24 0 0 1 1.241-.02c.161.09.315.247.622.561s.46.47.548.635c.212.397.205.878-.018 1.268c-.092.162-.25.314-.566.619L17.5 20.362c-.599.577-.898.865-1.273 1.012c-.374.146-.786.135-1.609.113l-.112-.002c-.25-.007-.376-.01-.449-.093c-.072-.083-.062-.21-.043-.465l.011-.14c.056-.718.084-1.077.224-1.4s.383-.585.867-1.11zM22 10.5v-.783c0-1.94 0-2.909-.586-3.512c-.586-.602-1.528-.602-3.414-.602h-2.079c-.917 0-.925-.002-1.75-.415L10.84 3.521c-1.391-.696-2.087-1.044-2.828-1.02S6.6 2.918 5.253 3.704l-1.227.716c-.989.577-1.483.866-1.754 1.346C2 6.246 2 6.83 2 7.999v8.217c0 1.535 0 2.303.342 2.73c.228.285.547.476.9.54c.53.095 1.18-.284 2.478-1.042c.882-.515 1.73-1.05 2.785-.905c.884.122 1.705.68 2.495 1.075M8 2.5v15m7-12v8" color="currentColor" />
                       </svg>
                       <span class="hide-label">Address</span>
                   </button>
                   <button class="ticket-btn flx-row btn-acc" onclick="openAccModal()">
                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                           <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M22 14v-4c0-3.771 0-5.657-1.172-6.828S17.771 2 14 2h-2C8.229 2 6.343 2 5.172 3.172S4 6.229 4 10v4c0 3.771 0 5.657 1.172 6.828S8.229 22 12 22h2c3.771 0 5.657 0 6.828-1.172S22 17.771 22 14M5 6H2m3 6H2m3 6H2M17.5 7h-4m2 4h-2M9 22V2" color="currentColor" />
                       </svg>
                       <span class="hide-label">Account</span>
                   </button>
                   <button class="ticket-btn flx-row btn-parts" onclick="openPartsModal()">
                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                           <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.198 3H3.802c-.75 0-1.126 0-1.386.177a1 1 0 0 0-.31.34c-.153.272-.116.64-.041 1.378c.125 1.231.187 1.847.513 2.287c.163.219.369.403.606.541C3.66 8 4.286 8 5.54 8h12.922c1.253 0 1.879 0 2.355-.277c.237-.138.443-.322.606-.541c.326-.44.388-1.056.513-2.287c.075-.737.112-1.106-.04-1.379a1 1 0 0 0-.311-.339C21.324 3 20.948 3 20.198 3M3 8v5.04c0 3.753 0 5.629 1.172 6.794S7.229 21 11 21h2c3.771 0 5.657 0 6.828-1.166S21 16.793 21 13.041V8m-11 3h4" color="currentColor" />
                       </svg>
                       <span class="hide-label">parts</span>
                   </button>
                   <button class="ticket-btn flx-row btn-summary" onclick="openSummaryModal()">
                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                           <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                               <path d="M21.917 10.5q.027.234.043.47c.053.83.053 1.69 0 2.52c-.274 4.243-3.606 7.623-7.79 7.9a33 33 0 0 1-4.34 0a4.9 4.9 0 0 1-1.486-.339c-.512-.21-.768-.316-.899-.3c-.13.016-.319.155-.696.434c-.666.49-1.505.844-2.75.813c-.629-.015-.943-.023-1.084-.263s.034-.572.385-1.237c.487-.922.795-1.978.328-2.823c-.805-1.208-1.488-2.639-1.588-4.184a20 20 0 0 1 0-2.52c.274-4.243 3.606-7.622 7.79-7.9a33 33 0 0 1 3.67-.037M8.5 15h7m-7-5H11" />
                               <path d="m20.868 2.44l.693.692a1.5 1.5 0 0 1 0 2.121l-3.628 3.696a2 2 0 0 1-1.047.551l-2.248.489a.5.5 0 0 1-.595-.594l.479-2.235a2 2 0 0 1 .551-1.047l3.674-3.674a1.5 1.5 0 0 1 2.121 0" />
                           </g>
                       </svg>
                       <span class="hide-label">summary</span>
                   </button>
                   <button class="ticket-btn flx-row btn-time" onclick="openTimeModal()">
                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                           <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                               <circle cx="12" cy="12" r="10" />
                               <path d="M12 8v4l2 2" />
                           </g>
                       </svg>
                       <span class="hide-label">Times</span>
                   </button>
                   <button class="ticket-btn flx-row btn-sign" onclick="openSignatureModal()">
                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                           <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M22 12.634c-4 3.512-4.572-2.013-6.65-1.617c-2.35.447-3.85 5.428-2.35 5.428s-.5-5.945-2.5-3.89s-2.64 4.74-4.265 2.748C-1.5 5.813 5-1.15 8.163 3.457C10.165 6.373 6.5 16.977 2 22m7-1h10" color="currentColor" />
                       </svg>
                       <span class="hide-label">Sign</span>
                   </button>
                   <button class="ticket-btn flx-row" onclick="sendTicket()">
                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                           <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                               <path d="M22 12.5c0-.491-.005-1.483-.016-1.976c-.065-3.065-.098-4.598-1.229-5.733c-1.131-1.136-2.705-1.175-5.854-1.254a115 115 0 0 0-5.802 0c-3.149.079-4.723.118-5.854 1.254c-1.131 1.135-1.164 2.668-1.23 5.733a69 69 0 0 0 0 2.952c.066 3.065.099 4.598 1.23 5.733c1.131 1.136 2.705 1.175 5.854 1.254q1.204.03 2.401.036" />
                               <path d="m7 8.5l2.942 1.74c1.715 1.014 2.4 1.014 4.116 0L17 8.5m5 9h-8m8 0c0-.7-1.994-2.008-2.5-2.5m2.5 2.5c0 .7-1.994 2.009-2.5 2.5" />
                           </g>
                       </svg>
                       <span class="hide-label">Send</span>
                   </button>

                   <a class="ticket-btn flx-row back-btn" href="jobs/day_view">
                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                           <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.808 9.441L6.774 7.47C8.19 6.048 8.744 5.284 9.51 5.554c.957.337.642 2.463.642 3.18c1.486 0 3.032-.131 4.497.144C19.487 9.787 21 13.715 21 18c-1.37-.97-2.737-2.003-4.382-2.452c-2.054-.562-4.348-.294-6.465-.294c0 .718.314 2.844-.642 3.181c-.868.306-1.321-.494-2.737-1.915l-1.966-1.972C3.603 13.338 3 12.733 3 11.995c0-.74.603-1.344 1.808-2.554" color="currentColor" />
                       </svg>
                       <span class="hide-label">Back</span>
                   </a>

                   <button class="ticket-btn flx-row" onclick="openResetModal()"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                           <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m4.475 6.1l.84 12.077c.094 1.16.967 3.377 3.204 3.625s6.731.193 7.55.193c.82 0 2.944-.581 2.944-2.99c0-2.43-2.03-3.063-3.305-3.041h-3.653m0 0a.8.8 0 0 1 .273-.581l2.159-1.89m-2.432 2.47a.8.8 0 0 0 .275.623l2.157 1.875M19.47 5.824l-.468 7.655M3 5.496h18m-4.945 0l-.682-1.407c-.454-.934-.68-1.401-1.071-1.693a2 2 0 0 0-.275-.172C13.594 2 13.074 2 12.034 2c-1.065 0-1.598 0-2.039.234q-.146.078-.278.179c-.396.303-.617.787-1.059 1.756l-.605 1.327" color="currentColor" />
                       </svg>
                       <span class="hide-label">Clear</span>
                   </button>
               </ul>
           </nav>
       </div>
       <div class="ticket-wrapper">
           <section class="ticket">
               <div class="ticket-header">
                   <div>
                       <img src="<?= BASE_URL ?>service_tickets_module/imgs/ses-logo.png" alt="">
                   </div>
                   <div>
                       <div class="flx-col font-bold tx-center">
                           <p>37919 HEATHER PLAZA - DADE CITY, FL 33525</p>
                           <p>Phone 352-567-5996</p>
                           <p class="font-sm">LIC #EF0001945</p>
                           <div class="black-block">
                               <p>SERVICE ORDER</p>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="ticket-info">
                   <div class="ticket-container">
                       <table class="ticket-table">
                           <tbody>
                               <!-- Row 1 (Two-column) -->
                               <tr>
                                   <td class="col-60 bt3" colspan="2">
                                       <div>
                                           NAME
                                       </div>
                                       <div>
                                           <span id="job-name"></span>
                                       </div>
                                   </td>
                                   <td class="col-20 bt3 bl3">
                                       <div>
                                           PHONE
                                       </div>
                                       <div>
                                           <span id="job-phone"></span>
                                       </div>
                                   </td>
                               </tr>
                               <!-- Row 2 (Two-column) -->
                               <tr>
                                   <td class="col-60" colspan="2">
                                       <div>
                                           ADDRESS
                                       </div>
                                       <div>
                                           <span id="job-addr"></span>
                                       </div>
                                   </td>
                                   <td class="col-20 bl3">
                                       <div>
                                           APT or SUITE
                                       </div>
                                       <div>
                                           <span id="job-apt"></span>
                                       </div>
                                   </td>
                               </tr>
                               <!-- Row 3 (Three-column) -->
                               <tr>
                                   <td class="col-60">
                                       <div>
                                           CITY
                                       </div>
                                       <div>
                                           <span id="job-city"></span>
                                       </div>
                                   </td>
                                   <td class="col-20 bl3">
                                       <div>
                                           STATE / ZIP
                                       </div>
                                       <div>
                                           <span id="job-state"></span>
                                           <span id="job-zip"></span>
                                       </div>
                                   </td>
                                   <td class="col-20 bl3">
                                       <div>
                                           COUNTY
                                       </div>
                                       <div>
                                           <span id="job-county"></span>
                                       </div>
                                   </td>
                               </tr>

                               <!-- Row 5 (Two-column) -->
                               <tr>
                                   <td class="col-60">
                                       <div>
                                           MAKE / MODEL
                                       </div>
                                       <div>
                                           <span id="job-make"></span>
                                       </div>
                                   </td>
                                   <td class="col-20 bl3" colspan="2">
                                       <div>
                                           PROPOSAL #
                                       </div>
                                       <div>
                                           <span id="job-proposal"></span>
                                       </div>
                                   </td>
                               </tr>
                               <!-- Row 6 (Two-column) -->
                               <tr>
                                   <td class="col-60">
                                       <div>
                                           ACCOUNT #
                                       </div>
                                       <div>
                                           <span id="job-account"></span>
                                       </div>
                                   </td>
                                   <td class="col-20 bl3" colspan="2">
                                       <div>
                                           PURCHASE ORDER #
                                       </div>
                                       <div>
                                           <span id="job-purchase"></span>
                                       </div>
                                   </td>
                               </tr>
                               <!-- Full Row (Spanning all columns) -->
                               <tr>
                                   <td class="col-full bt3" colspan="3">
                                       <div>
                                           SERVICE REQUEST
                                       </div>
                                       <div>
                                           <span id="job-srq"></span>
                                       </div>
                                   </td>
                               </tr>
                           </tbody>
                       </table>
                       <section>
                           <div class="parts-container">
                               <table class="parts-table">
                                   <thead>
                                       <tr>
                                           <th class="col-10">QTY</th>
                                           <th class="col-30 bl3">PART NO.</th>
                                           <th class="col-60 bl3">DESCRIPTION</th>
                                       </tr>
                                   </thead>
                                   <tbody id="parts-list">
                                       <tr>
                                           <td class="col-10"></td>
                                           <td class="col-30 bl3"></td>
                                           <td class="col-60 bl3"></td>
                                       </tr>
                                       <tr>
                                           <td class="col-10"></td>
                                           <td class="col-30 bl3" </td>
                                           <td class="col-60 bl3"></td>
                                       </tr>
                                       <tr>
                                           <td class="col-10"></td>
                                           <td class="col-30 bl3"></td>
                                           <td class="col-60 bl3"></td>
                                       </tr>
                                       <tr>
                                           <td class="col-10"></td>
                                           <td class="col-30 bl3"></td>
                                           <td class="col-60 bl3"></td>
                                       </tr>
                                       <tr>
                                           <td class="col-10"></td>
                                           <td class="col-30 bl3"></td>
                                           <td class="col-60 bl3"></td>
                                       </tr>
                                       <!-- Add more rows as needed -->
                                   </tbody>
                               </table>
                           </div>
                       </section>
                       <section>
                           <div class="ticket-summary-container">
                               <div class="serv-summary-title">
                                   SERVICE SUMMARY
                               </div>
                               <div class="ticket-summary" id="job-summary"></div>
                           </div>
                       </section>
                       <section>
                           <table class="time-table">
                               <tr>
                                   <td class="col-75">

                                   </td>
                                   <td class="col-25">
                                       <div class="flx-row justify-sb">
                                           <div>
                                               <p>TRAVEL</p>
                                               <p>TIME</p>
                                           </div>
                                           <div>
                                               <span class="time-box-values" id="time-tt"></span>Hrs
                                           </div>
                                       </div>
                                   </td>
                               </tr>
                               <tr>
                                   <td class="col-75">

                                   </td>
                                   <td class="col-25">
                                       <div class="flx-row justify-sb">
                                           <div>
                                               <p>EMERGENCY</p>
                                               <p>TIME</p>
                                           </div>
                                           <div>
                                               <span class="time-box-values" id="time-et"></span>Hrs
                                           </div>
                                       </div>
                                   </td>
                               </tr>
                               <tr>
                                   <td class="col-75">

                                   </td>
                                   <td class="col-25">
                                       <div class="flx-row justify-sb">
                                           <div>
                                               <p>OVER</p>
                                               <p>TIME</p>
                                           </div>
                                           <div>
                                               <span class="time-box-values" id="time-ot"></span>Hrs
                                           </div>
                                       </div>
                                   </td>
                               </tr>
                               <tr>
                                   <td class="col-75">
                                       <div class="flx-row justify-sb">
                                           <div class="flx-row justify-sb">
                                               <div>
                                                   <p>TIME</p>
                                                   <p>ARRIVED</p>
                                               </div>
                                               <div class="time-value">
                                                   <span id="time-ta"></span>
                                               </div>
                                           </div>
                                           <div class="flx-row justify-sb">
                                               <div>
                                                   <p>TIME</p>
                                                   <p>COMPLETED</p>
                                               </div>
                                               <div class="time-value">
                                                   <span id="time-tc"></span>
                                               </div>
                                           </div>
                                           <div class="flx-row justify-sb">
                                               <div>
                                                   <p>DATE</p>
                                                   <p>COMPLETED</p>
                                               </div>
                                               <div class="time-value">
                                                   <span id="time-dc"></span>
                                               </div>
                                           </div>
                                       </div>
                                   </td>
                                   <td class="col-25">
                                       <div class="flx-row justify-sb">
                                           <div>
                                               <p>SERVICE </p>
                                               <p>LABOR</p>
                                           </div>
                                           <div>
                                               <span class="time-box-values" id="time-sl"></span>
                                           </div>
                                       </div>
                                   </td>
                               </tr>
                           </table>
                       </section>
                   </div>
               </div>
               <div class="ticket-signatures">
                   <div class="disclaimer">
                       <p>
                           I hereby accept the above performed service and charges, as being
                           satisfactory.
                       </p>
                       <p>
                           and acknowledge that the equipment has been left in good condition.
                       </p>
                   </div>
                   <div class="signatures flx-row justify-sb">
                       <div class="signature-col ">
                           <p><?= $tech_name ?></p>
                           <img src="<?= $tech_sign ?>" alt="">
                           <div>
                               Technician
                           </div>
                       </div>
                       <div class="signature-col">
                           <p id="cust-print-name"></p>
                           <span id="cust-signature"><img src="https://placehold.co/200x50" alt=""></span>
                           <div>
                               Customer's Signature
                           </div>
                       </div>
                   </div>


               </div>
               <div class="ticket-footer">
                   <h4><i>THANK YOU</i></h4>
               </div>
           </section>
       </div>


       <!-- modals for service ticket-->
       <div class="st-modal" id="addrModal">
           <div class="st-modal-content">
               <div class="st-modal-header">
                   <h3>Address Info</h3>
                   <div onclick="closeModal('addrModal')">
                       <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                           <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m15.75 15l-6-6m0 6l6-6m7 3c0-5.523-4.477-10-10-10s-10 4.477-10 10s4.477 10 10 10s10-4.477 10-10" color="currentColor" />
                       </svg>
                   </div>
               </div>
               <div class="st-modal-body">
                   <form id="addr-form">
                       <div class="input-field">
                           <label for="name">Name</label>
                           <input type="text" id="name" name="name" required />
                       </div>

                       <div class="input-field">
                           <label for="phone">Phone</label>
                           <input type="text" id="phone" name="phone" />
                       </div>

                       <div class="input-field">
                           <label for="address">Address</label>
                           <input type="text" id="address" name="address" required />
                       </div>

                       <div class="input-field">
                           <label for="apt">Apt/Suite</label>
                           <input type="text" id="apt" name="apt" />
                       </div>

                       <div class="input-field">
                           <label for="city">City</label>
                           <input type="text" id="city" name="city" required />
                       </div>

                       <div class="input-field">
                           <label for="state">State</label>
                           <input type="text" id="state" name="state" required />
                       </div>

                       <div class="input-field">
                           <label for="zip">Zip Code</label>
                           <input type="text" id="zip" name="zip" />
                       </div>

                       <div class="input-field">
                           <label for="county">County</label>
                           <input type="text" id="county" name="county" />
                       </div>


                       <div class="st-modal-footer">
                           <button type="submit" class="st-modal-btn">Submit</button>
                       </div>
                   </form>
               </div>
           </div>
       </div>

       <div class="st-modal" id="accModal">
           <div class="st-modal-content">
               <div class="st-modal-header">
                   <h3>Account Info</h3>
                   <div onclick="closeModal('accModal')">
                       <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                           <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m15.75 15l-6-6m0 6l6-6m7 3c0-5.523-4.477-10-10-10s-10 4.477-10 10s4.477 10 10 10s10-4.477 10-10" color="currentColor" />
                       </svg>
                   </div>
               </div>
               <div class="st-modal-body">
                   <form id="acc-form">
                       <div class="input-field">
                           <label for="make">Make/Modal</label>
                           <input type="text" id="make" name="make">
                       </div>
                       <div class="input-field">
                           <label for="account">Account #</label>
                           <input type="text" id="account" name="account">
                       </div>
                       <div class="input-field">
                           <label for="proposal">Proposal #</label>
                           <input type="text" id="proposal" name="proposal">
                       </div>
                       <div class="input-field">
                           <label for="purchase">Purchase Order #</label>
                           <input type="text" id="purchase" name="purchase">
                       </div>
                       <div class="input-field">
                           <label for="srq">Service Request</label>
                           <textarea id="srq" name="srq" style="width: 300px; height: 150px;" maxlength="98"
                               placeholder="Enter your text (max 98 characters)"></textarea>
                       </div>
                       <div class="st-modal-footer">
                           <button type="submit" class="btn st-modal-btn">Submit</button>
                       </div>
                   </form>
               </div>
           </div>
       </div>

       <div class="st-modal" id="partsModal">
           <div class="st-modal-content">
               <div class="st-modal-header">
                   <h3>Add parts used</h3>
                   <div onclick="closeModal('partsModal')">
                       <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                           <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m15.75 15l-6-6m0 6l6-6m7 3c0-5.523-4.477-10-10-10s-10 4.477-10 10s4.477 10 10 10s10-4.477 10-10" color="currentColor" />
                       </svg>
                   </div>
               </div>
               <div class="st-modal-body">
                   <form id="parts-form">
                       <div class="input-field">
                           <label for="qty">Qty</label>
                           <input type="text" id="qty" name="qty">
                       </div>
                       <div class="input-field">
                           <label for="part-num">Part Number</label>
                           <input type="text" id="part-num" name="part-num">
                       </div>
                       <div class="input-field">
                           <label for="desc">Description #</label>
                           <input type="text" id="desc" name="desc">
                       </div>
                       <div class="st-modal-footer">
                           <button type="submit" class="btn st-modal-btn">Add Part</button>
                       </div>
                   </form>
                   <div id="parts-added">

                   </div>
               </div>
           </div>
       </div>

       <div class="st-modal" id="sSumModal">
           <div class="st-modal-content">
               <div class="st-modal-header">
                   <h3>Complete Service Summary</h3>
                   <div onclick="closeModal('sSumModal')">
                       <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                           <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m15.75 15l-6-6m0 6l6-6m7 3c0-5.523-4.477-10-10-10s-10 4.477-10 10s4.477 10 10 10s10-4.477 10-10" color="currentColor" />
                       </svg>
                   </div>
               </div>
               <div class="st-modal-body">
                   <form id="sSum-form">

                       <div class="input-field">
                           <label for="summary">Service Summary</label>
                           <textarea id="summary" name="summary" style="width: 300px; height: 150px;"
                               maxlength="500"></textarea>
                       </div>
                       <div class="st-modal-footer">
                           <button type="submit" class="btn st-modal-btn">Submit</button>
                       </div>
                   </form>
               </div>
           </div>
       </div>


       <div class="st-modal" id="timeModal">
           <div class="st-modal-content">
               <div class="st-modal-header">
                   <h3>Add Times</h3>
                   <div onclick="closeModal('timeModal')">
                       <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                           <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m15.75 15l-6-6m0 6l6-6m7 3c0-5.523-4.477-10-10-10s-10 4.477-10 10s4.477 10 10 10s10-4.477 10-10" color="currentColor" />
                       </svg>
                   </div>
               </div>
               <div class="st-modal-body">
                   <form id="time-form">
                       <div class="input-field">
                           <label for="modal-ta">Time Arrived</label>
                           <input type="time" id="modal-ta" name="modal-ta" />
                       </div>
                       <div class="input-field">
                           <label for="modal-tc">Time Completed</label>
                           <input type="time" id="modal-tc" name="modal-tc" />
                       </div>
                       <div class="input-field">
                           <label for="modal-dc">Date Completed</label>
                           <input type="date" id="modal-dc" name="modal-dc" />
                       </div>
                       <div class="input-field">
                           <label for="modal-tt">Travel Time</label>
                           <input type="text" id="modal-tt" name="modal-tt" />
                       </div>
                       <div class="input-field">
                           <label for="modal-ec">Emergency Time</label>
                           <input type="text" id="modal-et" name="modal-ec" />
                       </div>
                       <div class="input-field">
                           <label for="modal-ot">Over Time</label>
                           <input type="text" id="modal-ot" name="modal-ot" />
                       </div>
                       <div class="st-modal-footer">
                           <button type="submit" class="btn st-modal-btn">Submit</button>
                       </div>
                   </form>
               </div>
           </div>
       </div>

       <div class="st-modal" id="signModal">
           <div class="st-modal-content">
               <div class="st-modal-header flx-row justify-sb">
                   <h3>Customer Signature</h3>
                   <div onclick="closeModal('signModal')">
                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                           <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m15.75 15l-6-6m0 6l6-6m7 3c0-5.523-4.477-10-10-10s-10 4.477-10 10s4.477 10 10 10s10-4.477 10-10" color="currentColor" />
                       </svg>
                   </div>
               </div>
               <div class="st-modal-body">
                   <p class="flex pb8 pt8">Please sign and Print below</p>
                   <form id="signature" action="#" method="post" class="signature-pad-form">
                       <canvas height="100" width="300" class="signature-pad" id="sign-img"></canvas>

                       <div class="input-field">
                           <label for="printed-name">Printed Name</label>
                           <input type="text" id="printed-name" name="printed-name" require>
                       </div>
                       <div class="st-modal-footer">
                           <button type="submit" class="btn st-modal-btn">Submit</button>
                           <p>
                               <a href="#" class="clear-button">Clear </a>
                           </p>
                       </div>
                   </form>
               </div>
           </div>
       </div>

       <div class="st-modal" id="clearModal">
           <div class="st-modal-content">
               <div class="st-modal-header">
                   <h3>Reset the Ticket</h3>
               </div>
               <div class="st-modal-body">
                   <p>Are you sure you want to reset the ticket?</p>
                   <div class="st-modal-footer">
                       <button type="button" onclick="clearTicket()">Clear Ticket</button>
                       <button type="button" onclick="closeModal('clearModal')">Cancel</button>
                   </div>

               </div>
           </div>
       </div>
   </div>

   <style>
       /* Link to the service_tickets/assets/css/custom.css */
       @import url('service_tickets_module/css/css_v2.css');
   </style>
   <script>
       let jobCode = '<?= $job_code ?>';
       let baseUrl = '<?= BASE_URL ?>';
   </script>
   <!-- Link to the assets/js/custom.js -->
   <script src="service_tickets_module/js/save_ticket.js"></script>
   <script src="service_tickets_module/js/custom.js"></script>
   <script src="service_tickets_module/js/signature_v2.js"></script>