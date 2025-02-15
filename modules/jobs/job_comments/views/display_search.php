<?php
if (count($rows) <= 0) {
    echo '<div class="flex align-center justify-center  pt16">No Comments 
        &nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
                    <g fill="none" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="white">
                        <path d="M9.5 21.685A10 10 0 0 0 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2S2 6.477 2 12q0 .507.05 1" />
                        <path d="m5.021 14l-2.16 2.083a2.835 2.835 0 0 0 .02 4.088c1.18 1.118 3.08 1.099 4.24-.02a2.82 2.82 0 0 0 0-4.088zm2.988-5.558H8m8 0h-.009M15 16a4.98 4.98 0 0 0-3-1c-.91 0-1.765.244-2.5.67" />
                    </g>
                </svg>
            </div>';
} else {
    foreach ($rows as $item) { ?>
        <div class="bg-secondary m8-block p8 round-sm">
            <div>
                <div>
                    <p class="text-secondary"><i>Last Update: <?= out($item->comment_date) ?></i></p>
                    <h2 class="text-primary"><?= html_entity_decode(out($item->job_name), ENT_QUOTES, 'UTF-8') ?></h2>
                </div>
            </div>

            <div class="pt8">
                <div>
                    <h3><?= html_entity_decode(out($item->summary), ENT_QUOTES, 'UTF-8') ?></h3>
                </div>

                <div class="p8 mt8 mb8 bg-ternary round-sm">                   
                    <div>
                        <p><?= nl2br(html_entity_decode(out($item->comment), ENT_QUOTES, 'UTF-8')) ?>
                    </div>
                </div>
                <?php if ($item->member_id == $member_id) { ?>
                    <div class=" flex align-center justify-end pt8">
                        <div>
                            <div>
                                <a href="jobs-job_comments/index/<?= out($item->job_code) ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32px" height="32px" viewBox="0 0 24 24">
                                        <g fill="none" stroke="#cdb851" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="#cdb851">
                                            <path d="M21.917 10.5q.027.234.043.47c.053.83.053 1.69 0 2.52c-.274 4.243-3.606 7.623-7.79 7.9a33 33 0 0 1-4.34 0a4.9 4.9 0 0 1-1.486-.339c-.512-.21-.768-.316-.899-.3c-.13.016-.319.155-.696.434c-.666.49-1.505.844-2.75.813c-.629-.015-.943-.023-1.084-.263s.034-.572.385-1.237c.487-.922.795-1.978.328-2.823c-.805-1.208-1.488-2.639-1.588-4.184a20 20 0 0 1 0-2.52c.274-4.243 3.606-7.622 7.79-7.9a33 33 0 0 1 3.67-.037M8.5 15h7m-7-5H11" />
                                            <path d="m20.868 2.44l.693.692a1.5 1.5 0 0 1 0 2.121l-3.628 3.696a2 2 0 0 1-1.047.551l-2.248.489a.5.5 0 0 1-.595-.594l.479-2.235a2 2 0 0 1 .551-1.047l3.674-3.674a1.5 1.5 0 0 1 2.121 0" />
                                        </g>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
<?php
    }
}

?>