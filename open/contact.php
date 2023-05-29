<?php
require_once(INCLUDE_DIR . 'class.plugin.php');		
require_once(INCLUDE_DIR . 'class.osticket.php');
require_once('config.php');

class OsticketContactPlugin extends Plugin {
    var $config_class = "OsticketContactPluginConfig";

    function bootstrap() {

        $filepath = INCLUDE_DIR . "client/open.inc.php";
        $contents = file_get_contents($filepath);
        $tag_start = "<!-- start custom code -->";

        if (!str_contains($contents, $tag_start)){
            
            $this->InsertCustomCode();
        }
        
    }

    function InsertCustomCode() {      
        try {
            $config = $this->getConfig();

            $filepath = INCLUDE_DIR . "client/open.inc.php";

            $find = "<?php } ?>";
            $tag_start = "<!-- start custom code -->";
            $tag_end = "<!-- end custom code -->";

            $contents = file_get_contents($filepath);

            $replace = $tag_start . "<?php } ?>" . "</tbody>
<tbody>
<tr><td colspan=\"2\"><hr />
          <tr id=\"ccRow\">
            <td width=\"160\"><?php echo __('Cc'); ?>:</td>
            <td>
              <span>
                <select class=\"collabSelections\" name=\"ccs[]\" id=\"cc_users_open\" multiple=\"multiple\"
                ref=\"tags\" data-placeholder=\"<?php echo __('Select Contacts'); ?>\">
              </select>
            </span>
            <br/><span class=\"error\"><?php echo \$errors['ccs']; ?></span>
          </td>
        </tr>

";
            $contents = str_replace($find, $replace, $contents);
            file_put_contents($filepath, $contents);

            $filepath2 = INCLUDE_DIR . "client/open.inc.php";
            $find2 = "</form>";
            $tag_start2 = "</form>
<script type=\"text/javascript\">
$(function() {
    $('.collabSelections').select2({
      width: '350px',
      minimumInputLength: 3,
      ajax: {
        url: \"ajax.php/users/local\",
        dataType: 'json',
        data: function (params) {
          return {
            q: params.term,
          };
        },
        processResults: function (data) {
          return {
            results: $.map(data, function (item) {
              return {
                text: item.name,
                slug: item.slug,
                id: item.id
              }
            })
          };
        }
      }
    });
  });
</script>";
            $contents2 = file_get_contents($filepath2);
            $contents2 = str_replace("</form>", "</form>
<script type=\"text/javascript\">
$(function() {
    $('.collabSelections').select2({
      width: '350px',
      minimumInputLength: 3,
      ajax: {
        url: \"ajax.php/users/local\",
        dataType: 'json',
        data: function (params) {
          return {
            q: params.term,
          };
        },
        processResults: function (data) {
          return {
            results: $.map(data, function (item) {
              return {
                text: item.name,
                slug: item.slug,
                id: item.id
              }
            })
          };
        }
      }
    });
  });
</script>", $contents2);
            file_put_contents($filepath2, $contents2);

       } catch(Exception $e) {

            error_log($e->getMessage(), 0); 
       }
    }
}