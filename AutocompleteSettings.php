<?php

class AutocompleteSettings {

    protected $option_name = 'Autocomplete-Settings';
    protected $data = array(
        'words' => 'wordpress'
    );

    public function __construct() {

        add_action('init', array($this, 'init'));



        add_action('admin_init', array($this, 'admin_init'));
        add_action('admin_menu', array($this, 'add_page'));

        register_activation_hook(AUTOCOMPLETEPLUGIN_FILE, array($this, 'activate'));

        register_deactivation_hook(AUTOCOMPLETEPLUGIN_FILE, array($this, 'deactivate'));
    }

    public function activate() {
        update_option($this->option_name, $this->data);
    }

    public function deactivate() {
        delete_option($this->option_name);
    }

    public function init() {

        $result = get_option('Autocomplete-Settings');
    }

    public function admin_init() {
        register_setting('Autocomplete_options', $this->option_name, array($this, 'validate'));
    }

    public function add_page() {
        add_options_page('Autocomplete  Options', 'Autocomplete Options', 'manage_options', 'Autocomplete_options', array($this, 'options_autocomplete_page'));
    }

    public function options_autocomplete_page() {
        $options = get_option($this->option_name);
        ?>
        <script>
            function updrng()
            {
                document.getElementById("brdrtxt").value = document.getElementById("bsize").value + "px";
            }

            function updborder()
            {
                document.getElementById('brdr').value += ',';
                document.getElementById('brdr').value += document.getElementById('txt').value;
                this.value = '';
            }
            function resetx()
            {
                document.getElementById('brdr').value = 'wordpress';

            }
        </script>
        <div class="wrap">
            <h2>Autocomplete Options</h2>
            <form method="post" action="options.php">
        <?php settings_fields('Autocomplete_options'); ?>
                <table border="1" width="75%" class="form-table">
                    <TR>

                        <td width=25%><b>Word to Add</b><input type="text" id="txt"   onkeyup="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '')"  /></td>
                        <td width=25%><button type="button" onclick="updborder();">Add Word</button></td>

                    </tr>
                    <tr>
                        <td>Words:<input type="text" id="brdr" onkeydown="return false;" name="<?php echo $this->option_name ?>[words]" value="<?php echo $options['words']; ?>" /></td>
                        <td width=25%><button type="button" onclick="resetx();">Reset</button></td>
                    </tr>
                </table>
                <p class="submit">
                    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
                </p>
            </form>
        </div>
        <?php
    }

    public function validate($input) {
        var_dump($input);
        $valid = array();
        $valid['words'] = $input['words'];





        return $valid;
    }

}
