<?php $this->load->view('template/header.php'); ?>
    <main>
        <h1>HTML STRUCTURE ANALYZER</h1>
        <section>
            <p>URL to fetch</p>
            <form action="" method="get">
                <input type="hidden" name="<?=$csrf['name']?>" value="<?=$csrf['hash']?>">
                <input type="text" name="url" placeholder="enter a url">
                <label>
                    <input type="checkbox" name="verification" value="ssl_off">
                     Disable SSL verification
                </label>
                <input type="submit" value="Fetch">
            </form>
        </section>
        <section id="tags">
<?php $this->load->view('partials/tag.php'); ?>
        </section>
        <section id="response">
            <h2>Snippet</h2>
            <section>
                <button>Copy</button>
                <pre></pre>
            </section>
        </section>
    </main>
<?php $this->load->view('partials/modal.php'); ?>
<?php $this->load->view('template/footer.php'); ?>