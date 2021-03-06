<?php
/**
 * Template Name: Activity form
 */

get_header();

?>

<div class="row">
  <main id="content">
	<div class="row">
      <?php the_content(); ?>

	  <div class="col-xs-12">
        <?php if(current_user_can('publish_posts', the_post())) : ?>
          <?php
          if(isset($_GET['post_id'])) {
            $post_id = $_GET['post_id'];
            if(get_post_status($post_id) == 'draft') {
              $submit_button =  'Publish activity';
              $draft_button = 'Save as draft and preview';
            } else {
              $submit_button = 'Update activity';
              $draft_button = 'Unpublish, save as draft, and preview';
            }
          } else {
            $post_id = 'new_post';
            $submit_button = 'Publish activity';
            $draft_button = 'Save as draft and preview';
          }
          ?>
          <?php acf_form(array(
              'post_id' => $post_id,
              'new_post' => array(
                  'post_type'	=> 'activity',
                  'post_status' => 'publish',
              ),
              'html_after_fields' => '<div class="acf-field"><input type="hidden" name="post_type"><button type="submit" name="draft">' . $draft_button . '</button><span class="acf-spinner"></span></div>',
              'uploader' => 'basic',
              'return' => '%post_url%',
              'submit_value' => $submit_button,
          )); ?>
        <?php endif ; ?>
    </div>
  </main>
</div>

<script type="text/javascript">
  function toTitleCase(str) {
    return str.replace(/\w\S*/g, function(txt) {
      return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
  }
  (function($) {
    <?php /* Create headings in "How"-textarea when choosing methods */ ?>
    $('input[name^="acf[field_570d4d3b389ea]"]').change(function() {
      if($(this).is(':checked')) {
        tinymce.get($('textarea[name="acf[field_5702d2889ac48]"]').attr('id'))
               .execCommand('mceInsertContent', false, "<p><b>" + toTitleCase($(this).val()) + "</b></p><p></p>");
      }
    });

    <?php /* Save draft handler */ ?>
    $('button[name="draft"]').click(function(e) {
      var button = $(this);
      button.prev('input[name="post_type"]').val('draft');
      button.next().addClass('is-active');
      <?php /* Hide publish button container */ ?>
      button.parents('form').find('.acf-form-submit').hide();
    });

    <?php /* Reset display after form submit */ ?>
    $('form').ajaxComplete(function(e) {
      $('.acf-spinner').removeClass('is-active');
      $(this).find('.acf-form-submit').show();
    });
  })(jQuery);
</script>

<?php get_footer(); ?>
