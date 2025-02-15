<div class=" text-color-30">
    <div class="flex align-center justify-between p8 text-white ">
        <?php if (!$jobs) { ?>
            <div>
                <h3>No Jobs Yet</h3>
            </div>
            <div class="flex align-center justify-between p8">
                <a href="<?= $back ?>" class="button btn-modal-secondary ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.808 9.441L6.774 7.47C8.19 6.048 8.744 5.284 9.51 5.554c.957.337.642 2.463.642 3.18c1.486 0 3.032-.131 4.497.144C19.487 9.787 21 13.715 21 18c-1.37-.97-2.737-2.003-4.382-2.452c-2.054-.562-4.348-.294-6.465-.294c0 .718.314 2.844-.642 3.181c-.868.306-1.321-.494-2.737-1.915l-1.966-1.972C3.603 13.338 3 12.733 3 11.995c0-.74.603-1.344 1.808-2.554" color="currentColor" />
                    </svg>
                </a>
            </div>
        <?php } else { ?>
            <div>
                <h3> <?= ucfirst($jobs[0]->name); ?></h3>
                <p>Week of <?= date("M d, Y", strtotime($jobs[0]->job_date)); ?></p>
            </div>

            <div class="flex align-center justify-between p8">
                <a href="<?= $back ?>" class="back-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28px" height="28px" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.808 9.441L6.774 7.47C8.19 6.048 8.744 5.284 9.51 5.554c.957.337.642 2.463.642 3.18c1.486 0 3.032-.131 4.497.144C19.487 9.787 21 13.715 21 18c-1.37-.97-2.737-2.003-4.382-2.452c-2.054-.562-4.348-.294-6.465-.294c0 .718.314 2.844-.642 3.181c-.868.306-1.321-.494-2.737-1.915l-1.966-1.972C3.603 13.338 3 12.733 3 11.995c0-.74.603-1.344 1.808-2.554" color="currentColor" />
                    </svg>
                </a>
            </div>
        <?php } ?>
    </div>
    <div class="p8">
        <?php
        $last_date = 'first';
        $hours_sum = 0;
        foreach ($jobs as $item) {
            $same_day = $item->job_date == $last_date;
            $format_date = date("M d, Y", strtotime($item->job_date));
            if (!$same_day && $last_date != 'first') {
                echo '</div>';
            }
            if (!$same_day) {
                echo '<div class="bg-ternary round-sm p8 m16-block text-white"><h3>' . out($format_date) . '</h3> ';
            }
        ?>
            <div class="round-sm m8 p8 bg-secondary border text-color-40 flex justify-between">
                <div>
                    <div><b><?= html_entity_decode(out($item->job_name), ENT_QUOTES, 'UTF-8') ?></b></div>
                    <div class="flex pt4 sm-flex-col">
                        <div class="small-text pr16">Time In: <span class="text-primary"><?= out($item->time_in) ?></span></div>
                        <div class="small-text">Time Out: <span class="text-primary"><?= out($item->time_out) ?></span></div>
                    </div>
                    <div class="pt8">
                        <p><span class="small-text">Job Hours: </span><?= out($item->job_hours) ?> </p>
                    </div>
                </div>
                <div>
                    <a href="jobs/edit/<?= $item->job_code ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
                            <path fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.513 16h4m-4-5h8m-4.5 11h1M7.51 22c-1.15-.025-1.924 0-2.923-.225c-1.05-.275-1.7-.925-1.924-2.225c-.225-.85-.153-4.626-.15-8.225c.002-2.793.02-5.326.25-5.85c.325-1.125 1.074-1.925 3.398-1.95m9.868 0c.8.075 2.89 0 3.298 2.3c.222 1.25.175 3.025.175 5.15M8.184 5.5c1.05.025 4.422 0 5.572 0c1.149 0 1.756-.946 1.749-1.825c-.008-.896-.8-1.595-1.575-1.675H8.16c-.925.05-1.55.8-1.65 1.55c-.1 1.025.65 1.9 1.674 1.95m10.094 8.875c-1.375 1.4-4.023 3.9-4.023 4.075c-.213.297-.4.9-.525 1.75c-.156.788-.344 1.475-.124 1.675s1.047.032 1.923-.15c.7-.075 1.35-.325 1.674-.575c.475-.42 3.698-3.675 4.073-4.1c.274-.375.3-1.075.06-1.5c-.135-.3-.985-1.1-1.26-1.325a1.52 1.52 0 0 0-1.799.15" color="currentColor" />
                        </svg>
                    </a>
                </div>
            </div>


        <?php
            $hours_sum = $hours_sum + $item->job_hours;
            $last_date = $item->job_date;
        }
        ?>

    </div>
    <div class=" p8 lg-text text-white">
        <h3>Total Hours: <?= $hours_sum ?> hrs</h3>
    </div>
</div>
<style>
    .back-btn{
        border-radius: .5em;
        background-color: var(--color-surface-55);
        padding: 0 1em;
        color: white;
    }
 
</style>