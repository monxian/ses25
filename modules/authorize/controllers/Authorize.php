<?php
class Authorize extends Trongate {

    function restricted() {
        $flash_msg = '<div class="flex align-center login-alert"><svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                                <path d="M7.333 10H6.5a.5.5 0 0 0-.5.5v.833A2.667 2.667 0 0 0 8.667 14H9.5a.5.5 0 0 0 .5-.5v-.833A2.667 2.667 0 0 0 7.333 10m9.334 0H17c.471 0 .707 0 .854.146c.146.147.146.383.146.854v.333A2.667 2.667 0 0 1 15.333 14H15c-.471 0-.707 0-.854-.146C14 13.707 14 13.47 14 13v-.333A2.667 2.667 0 0 1 16.667 10M11 18h2" />
                                <path d="M21 11c0 5.523-6 11-9 11s-9-5.477-9-11s4.03-9 9-9s9 3.477 9 9" />
                            </g>
                          </svg>&nbsp; Restricted Area</div>';
        set_flashdata($flash_msg);
        redirect('members/logout');
    }


}