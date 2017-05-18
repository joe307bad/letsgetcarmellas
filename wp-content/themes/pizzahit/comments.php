<?php
if (post_password_required()) {
  ?>
  <p class="nocomments"><?php esc_html_e('This post is password protected. Enter the password to view comments.', 'pizzahit'); ?></p>
  <?php return;
}
?>

<div id="comments">
  <?php

  #Required for nested reply function that moves reply inline with JS
  if (is_singular()) wp_enqueue_script('comment-reply');

  if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die ('Please do not load this page directly. Thanks!');

  if (have_comments()) : ?>
    <h5 class="heading"><?php echo esc_html__('Comments on This Post', 'pizzahit'); ?></h5><span class="comments_number"><?php echo esc_html(comments_number('0', '1', '%') . ''); ?> </span>
    <ol class="commentlist">
      <?php 
        if ( gt3_get_theme_option("post_pingbacks") == "enabled" ) {
          wp_list_comments('type=all&callback=gt3_theme_comment');
        } else {
          wp_list_comments('type=comment&callback=gt3_theme_comment');
        }     
      ?>
    </ol>

    <div class="dn"><?php paginate_comments_links(); ?></div>

    <?php if ('open' == $post->comment_status) : ?>

    <?php else : // comments are closed ?>

    <?php endif; ?>
  <?php endif; ?>



  <?php if ('open' == $post->comment_status) :

    $comment_form = array(
      'fields' => apply_filters('comment_form_default_fields', array(
        'author' => '<label class="label-name"></label><div class="name_cont"><input type="text" placeholder="' . esc_html__('Your Name', 'pizzahit') . '" title="' . esc_html__('Your Name', 'pizzahit') . '" id="author" name="author" class="form_field"></div>',
        'email' => '<label class="label-email"></label><div class="email_cont"><input type="text" placeholder="' . esc_html__('Your Email', 'pizzahit') . '" title="' . esc_html__('Your Email', 'pizzahit') . '" id="email" name="email" class="form_field"></div>'
      )),
      'comment_field' => '<label class="label-message"></label><textarea name="comment" cols="45" rows="5" placeholder="' . esc_html__('Your Comment', 'pizzahit') . '" id="comment-message" class="form_field"></textarea>',

      'comment_form_before' => '',
      'comment_form_after' => '',
      'must_log_in' => esc_html__('You must be logged in to post a comment.', 'pizzahit'),
      'title_reply' => esc_html__('Leave a Reply', 'pizzahit'),
      'label_submit' => esc_html__('Send Comment', 'pizzahit'),
      'logged_in_as' => '<p class="logged-in-as">' . esc_html__('Logged in as', 'pizzahit') . ' <a href="' . admin_url('profile.php') . '">' . $user_identity . '</a>. <a href="' . wp_logout_url(apply_filters('the_permalink', get_permalink())) . '">' . esc_html__('Log out?', 'pizzahit') . '</a></p>',
    );
    comment_form($comment_form, $post->ID);

  else : // Comments are closed
    ?>
    <p class="hidden"><?php esc_html_e('Sorry, the comment form is closed at this time.', 'pizzahit') ?></p>
  <?php endif; ?>
</div>