<section class="main-sec">
    <div class="container cont-sm">
        <div class="container-header pb8 flex align-center justify-between">
            <div>
                <h3>On Call</h3>
            </div>
            <div>
                <p><span class="small-text text-secondary"><?= $claim_status ?></span></p>
            </div>
        </div>
        <div>
            <div id="on_call_results">
                <?= $claim_history ?>
            </div>
        </div>
    </div>
</section>
<style>
    .cur-week{
        border: 1px solid var(--color-primary-45);
    }
</style>
