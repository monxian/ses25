<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ticket PHP</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>service_tickets_module/css/st-styles.css">
</head>

<body>
    <div class="page-wrap">
        <header>
            <div>
                <img src="<?= BASE_URL ?>service_tickets_module/imgs/ses-logo.png" alt="">
            </div>
            <div>
                <div class="flex-col items-center font-bold">
                    <p>37919 HEATHER PLAZA - DADE CITY, FL 33525</p>
                    <p>Phone 352-567-5996</p>
                    <p class="font-sm">LIC #EF0001945</p>
                    <div class="black-block">
                        <p>SERVICE ORDER</p>
                    </div>
                </div>
        </header>
        <section class="account">
            <div class="account-name account-item bb1 brb">
                <div>
                    <div class="account-item-label">NAME</div>
                    <div><?= $td['addr-form']->job_name ?></div>
                </div>
            </div>
            <div class="account-phone account-item bb1">
                <div>
                    <div class="account-item-label">PHONE</div>
                    <div><?= $td['addr-form']->job_phone ?></div>
                </div>
            </div>

            <div class="account-addr account-item bb1 brb">
                <div>
                    <div class="account-item-label">ADDRESS</div>
                    <div><?= $td['addr-form']->job_addr ?></div>
                </div>
            </div>
            <div class="account-apt account-item bb1">
                <div>
                    <div class="account-item-label">APT or SUITE</div>
                    <div><?= $td['addr-form']->job_apt ?></div>
                </div>
            </div>
            <div class="account-city account-item bb1 brb">
                <div>
                    <div class="account-item-label">CITY</div>
                    <div><?= $td['addr-form']->job_city ?></div>
                </div>
            </div>
            <div class="account-state account-item bb1">
                <div>
                    <div class="account-item-label">STATE/ZIP</div>
                    <div><?= $td['addr-form']->job_state ?>&nbsp;<?= $td['addr-form']->job_zip ?> </div>
                </div>
            </div>
            <div class="account-county account-item bb1">
                <div>
                    <div class="account-item-label">COUNTY</div>
                    <div><?= $td['addr-form']->job_county ?></div>
                </div>
            </div>
            <div class="account-make account-item bb1 brb">
                <div>
                    <div class="account-item-label">MAKE/MODEL</div>
                    <div><?= $td['account-form']->job_make ?></div>
                </div>
            </div>
            <div class="account-prop account-item bb1">
                <div>
                    <div class="account-item-label font-bold">PROPOSAL #</div>
                    <div><?= $td['account-form']->job_proposal ?></div>
                </div>
            </div>
            <div class="account-acc account-item bb1 brb">
                <div>
                    <div class="account-item-label font-bold">ACCOUNT #</div>
                    <div><?= $td['account-form']->job_account ?></div>
                </div>
            </div>
            <div class="account-po account-item bb1 ">
                <div>
                    <div class="account-item-label font-bold">PURCHASE ORDER #</div>
                    <div><?= $td['account-form']->job_purchase ?></div>
                </div>
            </div>
        </section>
        <section class="account-srq">
            <div class="account-item-label font-bold">SERVICE REQUEST</div>
            <div class="pl16">
                <?= nl2br($td['account-form']->job_srq) ?>
            </div>
        </section>
        <section>

            <table>
                <thead>
                    <tr>
                        <th>Qty</th>
                        <th>PART NO</th>
                        <th>DESCRIPTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?= $parts_html ?>
                </tbody>
            </table>
        </section>

        <section class="summary">
            <div class="account-item-label font-bold">SERVICE SUMMARY</div>
            <div class="summary-text"><?= nl2br($td['summary']->service_summary) ?></div>
        </section>

        <section class="service-summary">
            <div class="summary-ex">

            </div>
            <div class="times">
                <div class="travel flex-rows">
                    <div>
                        <p>TRAVEL</p>
                        <p>TIME</p>
                    </div>
                    <div>
                        <span class="font-bold">2</span><?= $td['time-ex-form']->tt ?> &nbsp; hrs
                    </div>
                </div>
                <div class="emergency flex-rows">
                    <div>
                        <p>EMERGENCY</p>
                        <p>TIME</p>
                    </div>
                    <div>
                        <span class="font-bold"></span><?= $td['time-ex-form']->et ?> &nbsp; hrs
                    </div>
                </div>
                <div class="overtime flex-rows">
                    <div>
                        <p>OVER</p>
                        <p>TIME</p>
                    </div>
                    <div>
                        <span class="font-bold"></span><?= $td['time-ex-form']->ot ?> &nbsp; hrs
                    </div>
                </div>
                <div class="slabor flex-rows">
                    <div>
                        <p>SERVICE</p>
                        <p>LABOR</p>
                    </div>
                    <div>
                        <span class="font-bold"><?= $total_sl_hours ?></span><?= $td['time-ex-form']->sl ?> &nbsp; hrs
                    </div>
                </div>
            </div>
            <div class="complete-times">
                <div class="time-arr flex-rows">
                    <div class="flex-cols">
                        <p>TIME</p>
                        <p>ARRIVED</p>
                    </div>
                    <div class="com-times-value">
                        <?= $td['time-form']->time_ta ?>
                    </div>
                </div>
                <div class="TIME-comp flex-rows">
                    <div class="flex-cols">
                        <p>TIME</p>
                        <p>COMPLETED</p>
                    </div>
                    <div class="com-times-value">
                        <?= $td['time-form']->time_tc ?>
                    </div>
                </div>
                <div class="date-comp flex-rows">
                    <div class="flex-cols">
                        <p>DATE</p>
                        <p>COMPLETED</p>
                    </div>
                    <div class="com-times-value">
                        <?= $td['time-form']->time_dc ?>
                    </div>
                </div>
            </div>
        </section>
        <section class="signature">
            <div class="disclaimer">
                <p>
                    I hereby accept the above performed service and charges, as being
                    satisfactory.
                </p>
                <p>
                    and acknowledge that the equipment has been left in good condition.
                </p>
            </div>
            <div class="sign-imgs">
                <div>
                    <div>
                        <img src="signature.png" alt="">
                    </div>
                    <div>
                        <hr>
                        <p>Technician</p>
                    </div>
                </div>
                <div>
                    <div style=" padding:.5em ; display:flex; align-items:center">
                        <img src="<?= $td['image'] ?>" alt="">
                        <div class="printed-name"><?= $td['printed_name'] ?></div>
                    </div>
                    <div>
                        <hr>
                        <p>Customer Signature</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="footer">
            <div>
                &nbsp;
            </div>
            <div>
                <h4><i>THANK YOU</i></h4>
            </div>
        </section>
    </div>
</body>

</html>

