
    <div class="searched-names">
        <div class="fix-names-sec">
            <div id="close-info" onclick="closeBtn()">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m15.75 15l-6-6m0 6l6-6m7 3c0-5.523-4.477-10-10-10s-10 4.477-10 10s4.477 10 10 10s10-4.477 10-10" color="currentColor" />
                </svg>
            </div>
            <div>
                <p>Inconsistent or misspelled job names can corrupt
                    the analysis. Click on the tools icon to update
                    a job name for consistency.
                </p>

            </div>
        </div>
        <div class="flex align-center justify-between">
            <div>
                <h4>Job names found in search:</h4>
                <div class="small-text mb8">(Use this to refine your search or fix names)</div>
            </div>
            <div class="open-info" onclick="openBtn()">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                        <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12s4.477 10 10 10s10-4.477 10-10" />
                        <path d="M12.242 17v-5c0-.471 0-.707-.146-.854c-.147-.146-.382-.146-.854-.146m.75-3h.009" />
                    </g>
                </svg>
            </div>
        </div>
        <?php
        foreach ($job_names as $jname => $occurrence) { ?>
            <div class="names-list">
                <a href="#"
                    mx-post="projects/job_analysis/<?= urlencode($jname) ?>/<?= $link_start_date ?>/<?= $link_end_date ?>" 
                    mx-target = "#job-analysis"
                    class="search-btn flex m8-block">
                    <?= $jname ?> (<?= $occurrence ?>)
                </a>
                <a href="projects/fix_name/<?= urlencode($jname) ?>" class="text-primary flex m8-block fix-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                            <path d="m13 11l5-5m1 1l-2-2l2.5-1.5l1 1zM4.025 8.975a3.5 3.5 0 0 1-.79-3.74l1.422 1.422h2v-2L5.235 3.235a3.5 3.5 0 0 1 4.529 4.53l6.47 6.471a3.5 3.5 0 0 1 4.53 4.529l-1.421-1.422h-2v2l1.422 1.422a3.5 3.5 0 0 1-4.53-4.528L7.763 9.765a3.5 3.5 0 0 1-3.738-.79" />
                            <path d="m12.203 14.5l-5.604 5.604a1.35 1.35 0 0 1-1.911 0l-.792-.792a1.35 1.35 0 0 1 0-1.911L9.5 11.797" />
                        </g>
                    </svg>
                </a>

            </div>
        <?php
        }
        ?>
    </div>
    </div>

<style>
    .searched-names {
        margin: 1em 0;
        background-color: var(--color-surface-30);
        border-radius: 5px;
        padding: .5em 1em;
        position: relative;
    }

    .fix-names-sec {
        display: none;
        position: absolute;
        background-color: var(--color-surface-20);
        border: 1px solid var(--color-surface-60);
        padding: 1em;
        border-radius: 5px;
        width: 95%;
        margin: 0 auto;
    }

    .names-list {
        padding: 0.2em .5em;
        margin: .5em 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-radius: 5px;
        border: 1px solid var(--border);
        background-color: var(--color-surface-20);
    }

    .hours-meter {
        width: 100%;
        height: 25px;
        background: rgb(245, 203, 56);
        background: linear-gradient(90deg, rgba(245, 203, 56, 1) 0%, rgba(244, 170, 54, 1) 25%, rgba(255, 61, 0, 1) 100%);
        margin-bottom: 1em;
        border-radius: 5px;
        display: flex;
        align-items: center;
       
    }

    .percent-cover {
        background: transparent;
        height: 25px;
        display: flex;
        align-items: end;
        border-radius: 5px;
        display: flex;
        justify-content: center;
       
    }

    .dark-cover {       
        height: 23px;
        background-color: var(--color-surface-20);
        border-radius: 0 5px 5px 0;
        margin-right: 1px;

    }

    .orange-text {
        color: rgb(245, 203, 56);

    }

    #close-info {
        display: flex;
        justify-content: end;
        padding: 0 0 8px 0;
        cursor: pointer;
    }

    .search-btn {
        color: var(--color-primary-45);
    }

    .search-btn:hover {
        color: var(--color-primary-85);
    }

    a.fix-btn {
        border-radius: 5px;
        border: 1px solid var(--color-primary-45);
        color: var(--color-primary-45);
        padding: 0.2em;
    }

    a.fix-btn:hover {
        color: var(--color-primary-85);
        border-color: var(--color-primary-85);
    }
</style>
