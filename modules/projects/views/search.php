<section class="main-sec">
    <div class="container cont-sm">
        <div class="container-header pb8 flex align-center justify-between">
            <div>
                <h2><?= $heading ?></h2>
                <p class="small-text text-secondary">You can search by partial words too.</p>
            </div>
        </div>
        <form id="myForm" mx-post="projects/search_mx/<?= $mx_path ?>" mx-target="#result" class="mb-16">
            <div class="input-container">
                <input type="text" name="query" id="query" placeholder="enter name">
                <button type="submit">Search</button>
            </div>
        </form>
        <div id="result"></div>
    </div>

    </div>
</section>
<style>
    .input-container {
        position: relative;
    }

    .input-container input[type="text"] {
        width: 100%;
        padding-right: 50px;
        box-sizing: border-box;
        height: 46px;
    }

    .input-container button {
        position: absolute;
        right: 2px;
        top: 2px;
        bottom: 0;
        border: none;
        background: var(--color-primary-45);
        color: white;
        padding: 0 10px;
        cursor: pointer;
        border-radius: 0 .5em .5em 0;
        height: 42px;
        /* Match input border radius */
    }

    .input-container button:hover {
        background: var(--color-primary-35);
    }
</style>