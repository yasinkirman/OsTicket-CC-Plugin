<?php
require_once INCLUDE_DIR . 'class.plugin.php';

class OsticketContactPluginConfig extends PluginConfig {

    function translate() {

        return Plugin::translate('contact');
    }

    function getOptions() {
        list($__, $_N) = self::translate();        
        return array(
            'customcodeHeading' => new SectionBreakField(array(
                'label' => $__('Enter your custom code below')
            )),
            'custom-code-css' => new TextareaField(array(
                'label' => $__('Custom CSS'),
                'configuration' => array('rows'=>10, 'cols'=>80, 'html'=>false),                
            )),
            'custom-code-script' => new TextareaField(array(
                'label' => $__('Custom Script'),
                'configuration' => array('rows'=>10, 'cols'=>80, 'html'=>false),
            ))
        );
    }

    function pre_save(&$config, &$errors) {
         try {

            $filepath = INCLUDE_DIR . "client/open.inc.php";

            $find = "<?php } ?>";
            $tag_start = "<!-- start custom code -->";
            $tag_end = "<!-- end custom code-->";

            $contents = file_get_contents($filepath);            
            $contents = preg_replace("#" . $tag_start ."(.*?)" . $tag_end . "#s", "", $contents);
            $contents = str_replace($tag_start, "", $contents);
            $contents = str_replace($tag_end, "", $contents);

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
            error_log($e->getMessage());
        }
        return true;
     }
}