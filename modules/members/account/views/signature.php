<section class="main-sec">
    <div class="container cont-sm">
        <div class="container-header pb8 flex align-center justify-between">
            <div>
                <h2>Add Your Siganture</h2>
                <p>This will appear on the service ticket automagically.</p>

            </div>
        </div>
        <div class="modal-body">
            <form id="signature" action="#" method="post" class="signature-pad-form">
                <canvas height="100" width="300" class="signature-pad"></canvas>
              
                <div class="flex align-center justify-between mt16">
                    <button type="submit" class="button btn-primary-45">Submit</button>
                    <a href="#" class="clear-button button btn-secondary">Clear Pad</a>
                </div>
            </form>
        </div>
    </div>
</section>
<style>
    body{
        overflow: auto;
        touch-action: none;
    }
    .signature-pad {
        border: 2px solid black;
        border-radius: 5px;
    }
</style>
<!-- Link to the assets/js/custom.js -->
<script src="<?= BASE_URL ?>members-account_module/js/signature.js"></script>

