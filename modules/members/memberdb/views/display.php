<section class="main-sec">
    <div class="container max-1034">
        <div class="container-header pb8 flex align-center justify-between ">
            <div class="pb8">
                <h2>Members</h2>
                <p class="small-text text-secondary"><?= $msg ?></p>
            </div>
            <div> <?= flashdata() ?></div>
            <div class="pl16 flex align-center">
                <a href="members-memberdb/add" class="text-primary flex align-center button btn-primary-45">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v8m4-4H8m14 0c0-5.523-4.477-10-10-10S2 6.477 2 12s4.477 10 10 10s10-4.477 10-10" color="currentColor" />
                    </svg>&nbsp;
                    Add
                </a>
                <a href="<?= $link ?>" class="text-primary flex align-center button btn-primary-45 m16-inline">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.578 15.482c-1.415.842-5.125 2.562-2.865 4.715C4.816 21.248 6.045 22 7.59 22h8.818c1.546 0 2.775-.752 3.878-1.803c2.26-2.153-1.45-3.873-2.865-4.715a10.66 10.66 0 0 0-10.844 0M16.5 6.5a4.5 4.5 0 1 1-9 0a4.5 4.5 0 0 1 9 0" color="currentColor" />
                    </svg>&nbsp;
                    <?= $show ?>
                </a>
            </div>
        </div>
        <div class="flex gap-1 flex-wrap">
            <?php
            foreach ($member_rows as $row) { ?>
                <div class="round-sm border p8 w-320 align-self-start bg-ternary flex flex-col justify-between minh-320">
                    <div>
                        <div class="flex align-center justify-between">
                            <div>
                                <h3><?= ucfirst($row->first_name) ?> <?= ucfirst($row->last_name) ?></h3>
                            </div>
                            <div class="small-text text-secondary flex align-center">
                                Active: &nbsp;
                                <?php
                                if ($row->confirmed == true) {
                                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24">
                                            <g fill="none" stroke="#37c34e" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="#37c34e">
                                                <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12s4.477 10 10 10s10-4.477 10-10" />
                                                <path d="M8 12.75s1.6.912 2.4 2.25c0 0 2.4-5.25 5.6-7" />
                                            </g>
                                        </svg>';
                                } else {
                                    echo '<svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24">
                                            <path fill="none" stroke="#ed8d8d" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m15.75 15l-6-6m0 6l6-6m7 3c0-5.523-4.477-10-10-10s-10 4.477-10 10s4.477 10 10 10s10-4.477 10-10" color="#ed8d8d" />
                                      </svg>';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="mt-16">
                            <div class="m16-block">
                                <div class="flex align-center justify-between  m8-inline">
                                    <p class="small-text text-secondary">Username: </p>
                                    <p><?= $row->username ?></p>
                                </div>
                                <div class="flex align-center justify-between  m8-inline">
                                    <p class="small-text text-secondary">Email: </p>
                                    <p><?= $row->email_address ?></p>
                                </div>
                                <div class="flex align-center justify-between  m8-inline">
                                    <p class="small-text text-secondary">Date Added: </p>                                 
                                    <p><?= date('M d, Y', $row->date_joined) ?></p>
                                </div>
                                <div class="flex align-center justify-between  m8-inline">
                                    <p class="small-text text-secondary">User Level: </p>
                                    <p><?= ucfirst($row->level_title) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php if ($row->is_tech) { ?>
                        <div class="bg-secondary secondary-hover p8 pointer tech-hours round-sm max-content">
                            <div class="flex align-center"><i class="mr8">Year to date hours</i>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.5 12c0-4.478 0-6.718 1.391-8.109S7.521 2.5 12 2.5c4.478 0 6.718 0 8.109 1.391S21.5 7.521 21.5 12c0 4.478 0 6.718-1.391 8.109S16.479 21.5 12 21.5c-4.478 0-6.718 0-8.109-1.391S2.5 16.479 2.5 12M11 7h6M7 7h1m-1 5h1m-1 5h1m3-5h6m-6 5h6" color="currentColor" />
                                </svg>
                            </div>
                            <div class="hide">
                                <div class="m8">
                                    <p class="small-text text-secondary">Regular Hours(approx. includes lunch)</p>
                                    <p><?= $row->reg ?></p>
                                </div>
                                <div class="m8">
                                    <p class="small-text text-secondary">Vacation Hours</p>
                                    <p><?= $row->vaca ?></p>
                                </div>
                                <div class="m8">
                                    <p class="small-text text-secondary">Holiday Hours</p>
                                    <p><?= $row->holiday ?></p>
                                </div>
                            </div>

                        </div>
                    <?php } ?>

                    <div>
                        <p class="mt16">Update Details</p>
                        <div class=" flex align-center justify-between">
                            <div class="m8-inline">
                                <a href="members-memberdb/update/<?= $row->id ?>" class="button btn-primary-45 flex align-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24">
                                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                            <path d="M10.29 21.961h-.9c-3.248 0-4.873 0-5.882-1.025S2.5 18.261 2.5 14.961v-5c0-3.3 0-4.95 1.01-5.974C4.517 2.96 6.142 2.96 9.39 2.96h2.953c3.249 0 5.147.056 6.156 1.08c1.01 1.026 1 2.62 1 5.92v1.187M15.945 2v2m-5-2v2m-5-2v2M7 15h4m-4-5h8" />
                                            <path d="M20.76 14.879c-.906-1.015-1.449-.954-2.052-.773c-.423.06-1.871 1.75-2.475 2.29c-.991.978-1.987 1.986-2.052 2.118c-.188.305-.362.845-.447 1.449c-.157.906-.383 1.925-.097 2.013s1.087-.08 1.992-.213c.604-.11 1.026-.23 1.328-.411c.423-.254 1.207-1.147 2.56-2.476c.847-.893 1.665-1.51 1.907-2.113c.241-.906-.12-1.39-.664-1.885" opacity="0.93" />
                                        </g>
                                    </svg> &nbsp;</a>
                            </div>
                            <div class="m8">
                                <a href="members-memberdb/update_password/<?= $row->id ?>" class="button btn-primary-45 flex align-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24">
                                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                            <path d="M18.5 11.5c-.275-1.025-1.525-2.504-3.425-2.4c0 0-1.932-.104-3.884-.104c-1.953 0-2.94.029-4.466.104c-1.025 0-2.65.575-3.275 2.325c-.576 1.75-.55 5.374-.2 7.225c.075.95.598 2.3 2.15 3c.75.45 5.45.3 6.1.35M6.516 8.196c-.05-2.375-.15-4.25 2.604-5.801c.926-.375 2.303-.7 4.005.1c1.777 1.075 1.998 2.213 2.153 2.5c.425 1.126.2 2.726.25 3.376" />
                                            <path d="M15.67 18.444c.3.144.672.516.852.816c.06.42.36-1.2 1.824-2.16M21 18a4 4 0 1 1-8 0a4 4 0 0 1 8 0" />
                                        </g>
                                    </svg> &nbsp;</a>
                            </div>
                            <?php
                            if ($row->deletable) { ?>
                                <div class="">
                                    <a href="members-memberdb/delete/<?= $row->id ?>" class="button btn-danger flex align-center m8">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m19.5 5.5l-.62 10.025c-.158 2.561-.237 3.842-.88 4.763a4 4 0 0 1-1.2 1.128c-.957.584-2.24.584-4.806.584c-2.57 0-3.855 0-4.814-.585a4 4 0 0 1-1.2-1.13c-.642-.922-.72-2.205-.874-4.77L4.5 5.5M3 5.5h18m-4.944 0l-.683-1.408c-.453-.936-.68-1.403-1.071-1.695a2 2 0 0 0-.275-.172C13.594 2 13.074 2 12.035 2c-1.066 0-1.599 0-2.04.234a2 2 0 0 0-.278.18c-.395.303-.616.788-1.058 1.757L8.053 5.5" color="currentColor" />
                                        </svg></a>
                                </div>
                            <?php

                            }
                            ?>
                        </div>
                    </div>


                </div>
            <?php
            }
            ?>

        </div>
    </div>
</section>
<style>
    /* Link to the memberdb/assets/css/custom.css */
    @import url('members-memberdb_module/css/custom.css');

    .max-1034 {
        max-width: 1034px;
    }
</style>

<!-- Link to the assets/js/custom.js -->
<script src="members-memberdb_module/js/custom.js"></script>