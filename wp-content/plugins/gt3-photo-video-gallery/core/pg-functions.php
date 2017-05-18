<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly



function be_attachment_field_credit( $form_fields, $post ) {

    $form_fields['gt3-video-url'] = array(

        'label' => 'Video Url',

        'input' => 'text',

        'value' => get_post_meta( $post->ID, 'gt3_video_url', true ),

    );

     return $form_fields;

}
add_filter( 'attachment_fields_to_edit', 'be_attachment_field_credit', 10, 2 );

function be_attachment_field_credit_save( $post, $attachment ) {

    if( isset( $attachment['gt3-video-url'] ) )

        update_post_meta( $post['ID'], 'gt3_video_url', $attachment['gt3-video-url'] );

    return $post;
}
add_filter( 'attachment_fields_to_save', 'be_attachment_field_credit_save', 10, 2 );

function theme_slug_filter_the_content( $content ) { 

  if ( is_single() && 'attachment' == get_post_type() ) {

      $src = get_post_meta(get_the_ID(), 'gt3_video_url', true);
      $iframe = wp_oembed_get($src);
      $custom_content = $iframe;
      $custom_content .= $content;

      return $custom_content;
    } else {
        return $content;
    }
}
add_filter( 'the_content', 'theme_slug_filter_the_content' );

remove_shortcode('gallery');

function gt3pg_get_video_from_description($post_description) {
  $arr=array();
  
  if (preg_match('/\[video=(.+)\]/isU', $post_description, $arr)) return $arr[1]; else return false;
}

function gt3pg_get_video_type_from_description($video_url) {
  if (strpos($video_url, 'youtube') !== false) return 'youtube';
  if (strpos($video_url, 'vimeo') !== false) return 'vimeo';
  return false;
}

function gt3pg_gallery_shortcode( $attr ) {

  $gt3_photo_gallery = gt3pg_get_option("photo_gallery");

  $post = get_post();
  static $instance = 0;
  $instance++;

  if ( ! empty( $attr['ids'] ) ) {
    // 'ids' is explicitly ordered, unless you specify otherwise.
    if ( empty( $attr['orderby'] ) ) {
      $attr['orderby'] = 'post__in';
    }
    $attr['include'] = $attr['ids'];
  }

  /**
   * Filter the default gallery shortcode output.
   *
   * If the filtered output isn't empty, it will be used instead of generating
   * the default gallery template.
   *
   * @since 2.5.0
   * @since 4.2.0 The `$instance` parameter was added.
   *
   * @see gallery_shortcode()
   *
   * @param string $output   The gallery output. Default empty.
   * @param array  $attr     Attributes of the gallery shortcode.
   * @param int    $instance Unique numeric ID of this gallery shortcode instance.
   */
  $output = apply_filters( 'post_gallery', '', $attr, $instance );
  if ( $output != '' ) {
    return $output;
  }

  $html5 = current_theme_supports( 'html5', 'gallery' );

  if (isset($gt3_photo_gallery['gt3pg_margin'])) $atts_margin = $gt3_photo_gallery['gt3pg_margin']; else $atts_margin = 30;
  if (isset($gt3_photo_gallery['gt3pg_thumbnail_type'])) $atts_thumbnail_type = $gt3_photo_gallery['gt3pg_thumbnail_type']; else $atts_thumbnail_type = 'rectangle';
  if (isset($gt3_photo_gallery['gt3pg_corner_type'])) $atts_corner_type = $gt3_photo_gallery['gt3pg_corner_type']; else $atts_corner_type = 'standard';
  if (isset($gt3_photo_gallery['gt3pg_border'])) $atts_border = $gt3_photo_gallery['gt3pg_border']; else $atts_border = 'off';
  if (isset($gt3_photo_gallery['gt3pg_columns'])) $atts_columns = $gt3_photo_gallery['gt3pg_columns']; else $atts_columns = 3;
  if (isset($gt3_photo_gallery['gt3pg_border_size'])) $border_size = $gt3_photo_gallery['gt3pg_border_size']; else $border_size = 1;
  if (isset($gt3_photo_gallery['gt3pg_border_padding'])) $border_padding = $gt3_photo_gallery['gt3pg_border_padding']; else $border_padding = 0;
  if (isset($gt3_photo_gallery['gt3pg_border_col'])) $border_col = $gt3_photo_gallery['gt3pg_border_col']; else $border_col = "#dddddd";
  if (isset($gt3_photo_gallery['gt3pg_size'])) $gt3pg_size = $gt3_photo_gallery['gt3pg_size']; else $gt3pg_size = "thumbnail";
  if (isset($gt3_photo_gallery['gt3pg_link_to'])) $gt3pg_link = $gt3_photo_gallery['gt3pg_link_to']; else $gt3pg_link = "post";
  if (isset($gt3_photo_gallery['gt3pg_rand_order'])) 
    if ($gt3_photo_gallery['gt3pg_rand_order'] == 'checked' || $gt3_photo_gallery['gt3pg_rand_order'] == 'on') $gt3pg_rand = 'rand'; else $gt3pg_rand = "menu_order ID";
  $atts = shortcode_atts( array(
    'order'      => 'ASC',
    'orderby'    => $gt3pg_rand,
    'id'         => $post ? $post->ID : 0,
    'itemtag'    => $html5 ? 'figure'     : 'dl',
    'icontag'    => $html5 ? 'div'        : 'dt',
    'captiontag' => $html5 ? 'figcaption' : 'dd',
    'columns'    => $atts_columns,
    'size'       => $gt3pg_size,
    'include'    => '',
    'exclude'    => '',
    'rand_order' => '',
    'link'       => $gt3pg_link,
    'margin'     => $atts_margin,
    'thumb_type' => $atts_thumbnail_type,
    'corners_type' => $atts_corner_type,
    'border_type' => $atts_border,
    'border_size' => $border_size,
    'border_padding' => $border_padding,
    'border_col' => $border_col,
    'gt3_gallery'  => ''
  ), $attr, 'gallery' );

  // new version
  if ($atts['rand_order'] == '' && $atts['gt3_gallery'] == 'yes') {
    if ($gt3pg_rand == 'rand') $atts['orderby'] = 'rand'; else $atts['orderby'] = 'post__in';
  };

  $id = intval( $atts['id'] );

  if ( ! empty( $atts['include'] ) ) {
    $_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

    $attachments = array();
    foreach ( $_attachments as $key => $val ) {
      $attachments[$val->ID] = $_attachments[$key];
    }
  } elseif ( ! empty( $atts['exclude'] ) ) {
    $attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
  } else {
    $attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
  }

  if ( empty( $attachments ) ) {
    return '';
  }

  if ( is_feed() ) {
    $output = "\n";
    foreach ( $attachments as $att_id => $attachment ) {
      $output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
    }
    return $output;
  }

  $itemtag = tag_escape( $atts['itemtag'] );
  $captiontag = tag_escape( $atts['captiontag'] );
  $icontag = tag_escape( $atts['icontag'] );
  $valid_tags = wp_kses_allowed_html( 'post' );
  if ( ! isset( $valid_tags[ $itemtag ] ) ) {
    $itemtag = 'dl';
  }
  if ( ! isset( $valid_tags[ $captiontag ] ) ) {
    $captiontag = 'dd';
  }
  if ( ! isset( $valid_tags[ $icontag ] ) ) {
    $icontag = 'dt';
  }

  $columns = intval( $atts['columns'] );
  $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
  $float = is_rtl() ? 'right' : 'left';

  $selector = "gallery-{$instance}";

  $gallery_style = '';

  /**
   * Filter whether to print default gallery styles.
   *
   * @since 3.1.0
   *
   * @param bool $print Whether to print default gallery styles.
   *                    Defaults to false if the theme supports HTML5 galleries.
   *                    Otherwise, defaults to true.
   */
  if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
    $gallery_style = "
    <style type='text/css'>
      #{$selector} {
        margin: auto;
      }
      #{$selector} .gallery-item {
        float: {$float};
        margin-top: 10px;
        text-align: center;
        width: {$itemwidth}%;
      }
      #{$selector} .gt3pg_gallery-caption {
        margin-left: 0;
      }
      #{$selector} .gt3pg_gallery-item {
        float: {$float};
        margin-top: 10px;
        text-align: center;
        width: {$itemwidth}%;
      }
      #{$selector} .gt3pg_gallery-caption {
        margin-left: 0;
      }
      /* see gallery_shortcode() in wp-includes/media.php */
    </style>
";
  }

  // ------------ style ----------
  // new version
  if ($atts['gt3_gallery'] !='') {
    $gallery_style.= " <style type='text/css'>";
    $gallery_style.= "
      @media only screen and (max-width: 1279px) and (min-width: 769px) {
        .gallery-columns-6 .gt3pg_gallery-item,
        .gallery-columns-9 .gt3pg_gallery-item {
          width: 33%!important;
          max-width: 33%!important;
        }
        .gallery-columns-7 .gt3pg_gallery-item,
        .gallery-columns-8 .gt3pg_gallery-item {
          width: 24.9%!important;
          max-width: 24.9%!important;
        }
      }
      @media only screen and (max-width: 768px) and (min-width: 668px) {
        .gt3pg_gallery-item,
        .gallery-columns-2 .gt3pg_gallery-item,
        .gallery-columns-4 .gt3pg_gallery-item,
        .gallery-columns-5 .gt3pg_gallery-item,
        .gallery-columns-6 .gt3pg_gallery-item,
        .gallery-columns-7 .gt3pg_gallery-item,
        .gallery-columns-8 .gt3pg_gallery-item,
        .gallery-columns-9 .gt3pg_gallery-item {
          width: 50%!important;
          max-width: 50%!important;
        }
        .gallery-columns-3 .gt3pg_gallery-item {
          width: 100%!important;
          max-width: 100%!important;
        }
      }
      @media only screen and (max-width: 667px) {
        .gallery-item,
        .gallery-columns-2 .gt3pg_gallery-item,
        .gallery-columns-3 .gt3pg_gallery-item,
        .gallery-columns-4 .gt3pg_gallery-item,
        .gallery-columns-5 .gt3pg_gallery-item,
        .gallery-columns-6 .gt3pg_gallery-item,
        .gallery-columns-7 .gt3pg_gallery-item,
        .gallery-columns-8 .gt3pg_gallery-item,
        .gallery-columns-9 .gt3pg_gallery-item {
          width: 100%!important;
          max-width: 100%!important;
        }
      }
    ";
    if (isset($atts['margin']))
      $gallery_style.= "
        #{$selector} .gt3pg_gallery_wrapper {
          margin-left: -" . $atts['margin']/2 . "px;
          margin-right: -" . $atts['margin']/2 . "px;
        }

        #{$selector} {$itemtag}.gt3pg_gallery-item {
          padding-left: " . $atts['margin']/2 . "px;
          padding-right: " . $atts['margin']/2 . "px;
          margin-bottom: " . $atts['margin'] . "px;
          margin-left: 0;
          margin-right: 0;
          padding-bottom: 0px;
        }
      ";

    if ($atts['thumb_type'] == 'square' || $atts['thumb_type'] == 'circle') 
      $gallery_style.= "
        #{$selector} {$icontag}.gt3pg_gallery-icon {
          overflow: hidden;
          position: relative;
          width: 100%;
          padding-bottom: 100%;
          z-index: 2;
        }

        #{$selector} {$icontag}.gt3pg_gallery-icon .gt3pg_cover {
          position: absolute;
          width: 100%;
          height: 100%;
          z-index: 0;
        }

        #{$selector} {$icontag}.gt3pg_gallery-icon img {
          position: absolute;
          top: 50%;
          left: 50%;
          min-height: 100.01%;
          min-width: 100.01%;
          max-width: inherit;
          height: auto;
          width: auto;
          transform: translate(-50%, -50%);
          -webkit-transform: translate(-50%, -50%);
          z-index: -1;
        }
        #{$selector} {$icontag}.gt3pg_gallery-icon img.safari {
          width: 100%;
          height: 100%;
        }
    ";

    if ($atts['thumb_type'] == 'circle' || $atts['thumb_type'] == 'square') {
       $gallery_style.= "
        #{$selector} {$icontag}.gt3pg_gallery-icon img {
          width: 100%;
          height: 100%;
        }

        #{$selector} {$icontag}.gt3pg_gallery-icon a {
          display: block;
          height: 100%;
        }
       ";
    }

    if ($atts['thumb_type'] == 'circle')
      $gallery_style.= "
        #{$selector} {$icontag}.gt3pg_gallery-icon,
        #{$selector} a.gt3pg_view-link {
          border-radius: 50%;
          -webkit-border-radius: 50%;
        }
        #{$selector} {$icontag}.gt3pg_gallery-icon img.safari,
        #{$selector} {$icontag}.gt3pg_gallery-icon .gt3pg_cover {
          border-radius: 50%;
          -webkit-border-radius: 50%;
        }
    ";

    if ($atts['corners_type'] == 'rounded' && $atts['thumb_type'] != 'circle')
      $gallery_style.= "
      #{$selector} {$icontag}.gt3pg_gallery-icon,
      #{$selector} {$icontag}.gt3pg_gallery-icon .gt3pg_img_wrap {
        border-radius: 3px;
        -webkit-border-radius: 3px;
      }
      #{$selector} {$icontag}.gt3pg_gallery-icon img,
      #{$selector} {$icontag}.gt3pg_gallery-icon .gt3pg_img_wrap a {
        border-radius: 3px;
        -webkit-border-radius: 3px;
        color: transparent;
      }
    ";

    if ($atts['border_type'] == 'on') {
      if (isset($atts['border_size']) && $atts['border_size']) 
        $gallery_style.= "
          #{$selector} {$icontag}.gt3pg_gallery-icon {
            border-width: {$atts['border_size']}px;
            border-style: solid;
          }
        ";
      if (isset($atts['border_size']) && $atts['border_size'] && ($atts['thumb_type'] == 'circle' || $atts['thumb_type'] == 'square') ) 
        $gallery_style.= "
          #{$selector} {$icontag}.gt3pg_gallery-icon {
            padding-bottom: 95%;
            padding-bottom: -webkit-calc(100% - " . ($atts['border_size']*2 + (isset($atts['border_padding']) ? $atts['border_padding']*2 : "0")) . "px);
            padding-bottom: calc(100% - " . ($atts['border_size']*2 + (isset($atts['border_padding']) ? $atts['border_padding']*2 : "0")) . "px);
          }

        ";
      if (isset($atts['border_padding']) && $atts['border_padding'])
        $gallery_style.= "
          #{$selector} {$icontag}.gt3pg_gallery-icon .gt3pg_img_wrap {
            display: inline-block;
            border: {$atts['border_padding']}px solid transparent;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            overflow: hidden;
            width: 100%;
            box-sizing: border-box;
          }
      "; 
      if ($atts['corners_type'] == 'rounded' && $atts['thumb_type'] != 'circle' )
        $gallery_style.= "
      #{$selector} {$icontag}.gt3pg_gallery-icon .gt3pg_img_wrap {
        border-radius: " . (3 - (isset($atts['border_padding']) ? $atts['border_padding'] : "0" )) . "px;
        -webkit-border-radius: " . (3 - (isset($atts['border_padding']) ? $atts['border_padding'] : "0" )) . "px;
      }
      #{$selector} {$icontag}.gt3pg_gallery-icon img,
      #{$selector} {$icontag}.gt3pg_gallery-icon .gt3pg_img_wrap a {
        border-radius: " . (3 - (isset($atts['border_padding']) ? $atts['border_padding'] : "0" ) - (isset($atts['border_size']) ? $atts['border_size'] : "0" )) . "px;
        -webkit-border-radius: " . (3 - (isset($atts['border_padding']) ? $atts['border_padding'] : "0" ) - (isset($atts['border_size']) ? $atts['border_size'] : "0" )) . "px;
        color: transparent;
      }
      ";
      if (isset($atts['border_padding']) && $atts['border_padding']  && $atts['thumb_type'] == 'circle')
        $gallery_style.= "
          #{$selector} {$icontag}.gt3pg_gallery-icon .gt3pg_img_wrap {
            border-radius: 50%;
            -webkit-border-radius: 50%;
          }
          #{$selector} {$icontag}.gt3pg_gallery-icon img {
            border-radius: 50%;
            -webkit-border-radius: 50%;
          }
      ";
      if (isset($atts['border_padding']) && $atts['border_padding'] && ($atts['thumb_type'] == 'rectangle' || $atts['thumb_type'] == 'masonry') )
        $gallery_style.= "
          #{$selector} {$icontag}.gt3pg_gallery-icon .gt3pg_img_wrap {
            position: relative;
            display: block;
          }
      ";
      if (isset($atts['border_col']))
        $gallery_style.= "
          #{$selector} {$icontag}.gt3pg_gallery-icon {
            border-color: {$atts['border_col']};
          }
        ";
    }
    $gallery_style.= "</style>\n\t\t";
  }

  $size_class = sanitize_html_class( $atts['size'] );

  // new version
  if ($atts['gt3_gallery'] !='') {
    $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class} gt3pg_photo_gallery gt3pg_page-gallery-container'> <div class='gt3pg_gallery_wrapper {$atts['thumb_type']}";
    if ($atts['thumb_type'] == 'masonry') {
      $gallery_div .= " gt3pg_sorting_block";
      wp_enqueue_script('gt3pg_isotope_js', GT3PG_JSURL . 'jquery.isotope.min.js', array(), false, true);
      wp_enqueue_script('gt3pg_sorting_js', GT3PG_JSURL . 'sorting.js', array(), false, true);
    }
    $gallery_div .= "'>";

  } else {
    $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
  }
  

  /**
   * Filter the default gallery shortcode CSS styles.
   *
   * @since 2.5.0
   *
   * @param string $gallery_style Default CSS styles and opening HTML div container
   *                              for the gallery shortcode output.
   */
  $output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

  $i = 0;
  foreach ( $attachments as $id => $attachment ) {

    $attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
    $img_src = wp_get_attachment_image_src($id, 'full');
    $img_alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
    $media_url = $img_src[0];
    $media_class = '';

    //new version
    if ($atts['gt3_gallery'] !='') {

      // video types
      $post_description = (trim($attachment->post_content) );
      // $tmp_url = get_video_from_description($post_description);      
      $tmp_url = get_post_meta($attachment->ID, 'gt3_video_url', true);
      if ($tmp_url != '') {
        
        $video_type = gt3pg_get_video_type_from_description($tmp_url);
        if ($video_type !== false) $media_url = $tmp_url;
        if ($video_type == 'youtube') $media_class = 'mfp-iframe popup-youtube'; else
          if ($video_type == 'vimeo') $media_class = 'mfp-iframe popup-vimeo';
      }
      // end video types

      $tmp_sizes = wp_get_attachment_metadata( $id );

      $w = $tmp_sizes['width'];
      $h = $tmp_sizes['height'];
      if ($atts['size'] == 'large') {
        if (isset($tmp_sizes['sizes']['large']['width'])) {
          $w = $tmp_sizes['sizes']['large']['width'];
          $h = $tmp_sizes['sizes']['large']['height'];
        } else if (isset($tmp_sizes['sizes']['medium_large']['width'])) {
          $w = $tmp_sizes['sizes']['medium_large']['width'];
          $h = $tmp_sizes['sizes']['medium_large']['height'];
        }
      }

      if ($atts['size'] == 'medium') {
        if (isset($tmp_sizes['sizes']['medium']['width'])) {
          $w = $tmp_sizes['sizes']['medium']['width'];
          $h = $tmp_sizes['sizes']['medium']['height'];
        } 
      }

      if ($atts['size'] != 'thumbnail') {        
        if ($atts['thumb_type'] == 'circle' || $atts['thumb_type'] == 'square') {
            $w = min($w, $h); 
            $h = $w;
          } 
      } else {    
        if ($atts['thumb_type'] == 'circle' || $atts['thumb_type'] == 'square') $h = "700"; else if ($atts['thumb_type'] != 'masonry') $h = "525"; else $h = ($h / ($w / 700) );
        $w = "700";
      }

      if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {      
        $image_output = '<img src="' . gt3pg_aq_resize(wp_get_attachment_url( $id, 'full' ), $w, $h, true, true, true). '" alt="' . ((isset($img_alt)) ? $img_alt : '') . '" title="' . $attachment->post_title . '" /><a class="gt3pg_view-link gt3pg_swipebox ' . $media_class . '" href="' . $media_url . '" title="' . $attachment->post_title . '" data-description="'.$attachment->post_content.'"></a>';
      } elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
        $image_output = '<img src="' . gt3pg_aq_resize(wp_get_attachment_url( $id, 'full' ), $w, $h, true, true, true). '"  alt="' . ((isset($img_alt)) ? $img_alt : '') . '" title="' . $attachment->post_title . '" />';
      } else {
        $image_output = wp_get_attachment_link( $id, "", true, false, '<img src="' . gt3pg_aq_resize(wp_get_attachment_url( $id, 'full' ), $w, $h, true, true, true). '"  alt="' . ((isset($img_alt)) ? $img_alt : '') . '"  title="' . $attachment->post_title . '" />' );
      }

      $image_meta  = wp_get_attachment_metadata( $id );

      $orientation = '';
      if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
        $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
      }
      $output .= "<{$itemtag} class='gt3pg_gallery-item gt3pg_element'><div class='gt3pg_item-wrapper'>";
      $output .= "
        <{$icontag} class='gt3pg_gallery-icon {$orientation}'><div class='gt3pg_cover'><div class='gt3pg_img_wrap'>
          $image_output
        </div></div></{$icontag}>";
      if ( $captiontag && trim($attachment->post_excerpt) ) {
        $output .= "
          <{$captiontag} class='wp-caption-text gt3pg_gallery-caption' id='$selector-$id'>
          " . wptexturize($attachment->post_excerpt) . "
          </{$captiontag}></div>";
      }
      $output .= "</{$itemtag}>";

    } else {
      if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
        $image_output = wp_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
      } elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
        $image_output = wp_get_attachment_image( $id, $atts['size'], false, $attr );
      } else {
        $image_output = wp_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
      }
      $image_meta  = wp_get_attachment_metadata( $id );

      $orientation = '';
      if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
        $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
      }
      $output .= "<{$itemtag} class='gallery-item'>";
      $output .= "
        <{$icontag} class='gallery-icon {$orientation}'>
          $image_output
        </{$icontag}>";
      if ( $captiontag && trim($attachment->post_excerpt) ) {
        $output .= "
          <{$captiontag} class='wp-caption-text gallery-caption' id='$selector-$id'>
          " . wptexturize($attachment->post_excerpt) . "
          </{$captiontag}>";
      }
      $output .= "</{$itemtag}>";
    }
    if ( $columns > 0 && ++$i % $columns == 0 ) {
      $output .= '<br style="clear: both" />';
    }
  }

  if ( ! $html5 && $columns > 0 && $i % $columns !== 0 ) {
    $output .= "
      <br style='clear: both' />";
  }

  // new version
  if ($atts['gt3_gallery'] !='') $output .= "</div>\n</div>\n<div class='clear'></div>"; 
    else $output .= "</div>\n";

  return $output;
}

add_shortcode('gallery', 'gt3pg_gallery_shortcode');

function gt3pg_add_gallery_template() {
	// change native template
  global $gt3_photo_gallery, $gt3_photo_gallery_defaults;

	?>
	<script>
		jQuery(function() {
      wp.media._galleryDefaults = {
        itemtag: 'dl',
        icontag: 'dt',
        captiontag: 'dd',
        columns: '<?php echo ((isset($gt3_photo_gallery['gt3pg_columns'])) ? $gt3_photo_gallery['gt3pg_columns'] : ''); ?>',
        real_columns: 'default',
        link: 'default',
        size: 'default',
        order: 'ASC',
        id: wp.media.view.settings.post && wp.media.view.settings.post.id,
        orderby : 'menu_order ID',
        rand_order: 'default',
        margin : '<?php echo ((isset($gt3_photo_gallery['gt3pg_margin'])) ? $gt3_photo_gallery['gt3pg_margin'] : ''); ?>',
        thumb_type: 'default',
        corners_type: 'default',
        border_type: 'default',
        border_size: '<?php echo ((isset($gt3_photo_gallery['gt3pg_border_size'])) ? $gt3_photo_gallery['gt3pg_border_size'] : ''); ?>',
        border_padding: '<?php echo ((isset($gt3_photo_gallery['gt3pg_border_padding'])) ? $gt3_photo_gallery['gt3pg_border_padding'] : ''); ?>',
        border_col: '<?php echo ((isset($gt3_photo_gallery['gt3pg_border_col'])) ? $gt3_photo_gallery['gt3pg_border_col'] : ''); ?>',
        is_margin: 'default'
      };

      if ( wp.media.view.settings.galleryDefaults ) {
        wp.media.galleryDefaults = _.extend( {}, wp.media._galleryDefaults, wp.media.view.settings.galleryDefaults );
      } else {
        wp.media.galleryDefaults = wp.media._galleryDefaults;
      }

      wp.media.gallery = new wp.media.collection({
        tag: 'gallery',
        type : 'image',
        editTitle : wp.media.view.l10n.editGalleryTitle,
        defaults : wp.media.galleryDefaults,

        setDefaults: function( attrs ) {
          var self = this, changed = ! _.isEqual( wp.media.galleryDefaults, wp.media._galleryDefaults );
          _.each( this.defaults, function( value, key ) {
            attrs[ key ] = self.coerce( attrs, key );
            if ( value === attrs[ key ] && ( ! changed || value === wp.media._galleryDefaults[ key ] ) ) {
              delete attrs[ key ];
            }
          } );
          return attrs;
        }
      });

			var script_text = '<div class="gt3pg_settings"><h2><?php _e( 'GT3 Photo & Video Gallery Settings' );?></h2>'+
      '<label class="gt3pg_setting">'+
        '<input class="hidden" type="hidden" name="gt3_gallery" data-setting="gt3_gallery" value="yes"/>'+
      '</label>'+

			'<label class="gt3pg_setting">'+
				'<span><?php _e("Link Image To", "gt3pg"); ?></span>'+
				'<select class="link" name="link"'+
					'data-setting="link"'+
					'<# if ( data.userSettings ) { #>'+
						'data-user-setting="urlbutton"'+
					'<# } #>>'+
          '<option value="default" <# if ( ! wp.media.galleryDefaults.link || "default" == wp.media.galleryDefaults.link ) {'+
            '#>selected="selected"<# } #>>'+
            '<?php esc_attr_e("Default", "gt3pg"); ?>'+
          '</option>'+
					'<option value="post" <# if ( "post" == wp.media.galleryDefaults.link ) {'+
						'#>selected="selected"<# } #>>'+
						'<?php esc_attr_e("Attachment Page", "gt3pg"); ?>'+
					'</option>'+
					'<option value="file" <# if ( "file" == wp.media.galleryDefaults.link ) { #>selected="selected"<# } #>>'+
						'<?php esc_attr_e("Lightbox", "gt3pg"); ?>'+
					'</option>'+
					'<option value="none" <# if ( "none" == wp.media.galleryDefaults.link ) { #>selected="selected"<# } #>>'+
						'<?php esc_attr_e("None", "gt3pg"); ?>'+
					'</option>'+
				'</select>'+
			'</label>'+

      '<label class="gt3pg_setting size">'+
        '<span><?php _e( "Image Size", "gt3pg" ); ?></span>'+
        '<select class="size" name="size"'+
          'data-setting="size"'+
          '<# if ( data.userSettings ) { #>'+
            'data-user-setting="imgsize"'+
          '<# } #>'+
          '>'+
          '<option value="default" <# if ( ! wp.media.galleryDefaults.size || "default" == wp.media.galleryDefaults.size ) {'+
            '#>selected="selected"<# } #>>'+
            '<?php esc_attr_e("Default", "gt3pg"); ?>'+
          '</option>'+
          '<?php $size_names = apply_filters( "image_size_names_choose", array("thumbnail" => __( "Thumbnail", "gt3pg" ), "medium" => __( "Medium", "gt3pg" ), "large" => __( "Large", "gt3pg" ), "full" => __( "Full Size", "gt3pg" ),) );

          foreach ( $size_names as $size => $label ) : ?>'+
            '<option value="<?php echo $size; ?>" <# if ( "<?php echo $size?>" == wp.media.galleryDefaults.size ) { #>selected="selected"<# } #> >'+
              '<?php echo esc_html( $label, "gt3pg" ); ?>'+
            '</option>'+
          '<?php endforeach; ?>'+
        '</select>'+
      '</label>'+

			'<label class="gt3pg_setting hidden">'+
				'<span><?php _e("Columns", "gt3pg"); ?></span>'+
				'<select class="columns" name="columns"'+
					'data-setting="columns">'+
					'<?php for ( $i = 1; $i <= 9; $i++ ) : ?>'+
						'<option value="<?php echo $i; ?>" <#'+
							'if ( <?php echo $i ?> == wp.media.galleryDefaults.columns ) { #>selected="selected"<# }'+
						'#>>'+
							'<?php echo esc_html( $i, "gt3pg" ); ?>'+
						'</option>'+
					'<?php endfor; ?>'+
				'</select>'+
			'</label>'+

      '<label class="gt3pg_setting">'+
        '<span><?php _e("Columns", "gt3pg"); ?></span>'+
        '<select class="columns" name="real_columns"'+
          'data-setting="real_columns">'+
          '<option value="default" <# if ( ! wp.media.galleryDefaults.real_columns || "default" == wp.media.galleryDefaults.real_columns ) {'+
            '#>selected="selected"<# } #>>'+
            '<?php esc_attr_e("Default", "gt3pg"); ?>'+
          '</option>'+
          '<?php for ( $i = 1; $i <= 9; $i++ ) : ?>'+
            '<option value="<?php echo $i; ?>" <#'+
              'if ( <?php echo $i ?> == wp.media.galleryDefaults.real_columns ) { #>selected="selected"<# }'+
            '#>>'+
              '<?php echo esc_html( $i, "gt3pg" ); ?>'+
            '</option>'+
          '<?php endfor; ?>'+
        '</select>'+
      '</label>'+

			'<label class="gt3pg_setting random">'+
				'<span><?php _e( "Random Order", "gt3pg" ); ?></span>'+
				'<input type="checkbox" name="orderby" data-setting="_orderbyRandom" />'+
			'</label>'+

      '<label class="gt3pg_setting">'+
        '<span><?php _e("Random Order", "gt3pg"); ?></span>'+
        '<select class="rand_order" data-setting="rand_order" name="rand_order"'+
          '<# if ( data.userSettings ) { #>'+
            'data-user-setting="rand_order"'+
          '<# } #>>'+

          '<option value="default" <# if ( ! wp.media.galleryDefaults.rand_order || "default" == wp.media.galleryDefaults.rand_order ) { #>selected="selected"<# } #>>'+
            '<?php esc_attr_e("Default", "gt3pg"); ?>'+
          '</option>'+
          '<option value="rand" <# if ( "rand" == wp.media.galleryDefaults.rand_order ) { #>selected="selected"<# } #>>'+
            '<?php esc_attr_e("Random", "gt3pg"); ?>'+
          '</option>'+
          '<option value="menu_order ID" <# if ( "menu_order ID" == wp.media.galleryDefaults.rand_order ) { #>selected="selected"<# } #>>'+
            '<?php esc_attr_e("Ordered", "gt3pg"); ?>'+
          '</option>'+

        '</select>'+
      '</label>'+ 

      '<label class="gt3pg_setting">'+
        '<span><?php _e("Margin", "gt3pg"); ?></span>'+
        '<select class="is_margin"'+
          'data-setting="is_margin" name="is_margin">'+

          '<option value="default" <# if ( ! wp.media.galleryDefaults.is_margin || "default" == wp.media.galleryDefaults.is_margin ) { #>selected="selected"<# } #>>'+
            '<?php esc_attr_e("Default", "gt3pg"); ?>'+
          '</option>'+
          '<option value="custom" <# if ( "custom" == wp.media.galleryDefaults.is_margin ) { #>selected="selected"<# } #>>'+
            '<?php esc_attr_e("Custom", "gt3pg"); ?>'+
          '</option>'+

        '</select>'+
      '</label>'+

			'<label class="gt3pg_setting margin">'+
				'<span><?php _e( "Margin, px", "gt3pg" ); ?></span>'+
				'<input class="short-input" type="text" name="margin" data-setting="margin" value="<?php echo ((isset($gt3_photo_gallery['gt3pg_margin'])) ? $gt3_photo_gallery['gt3pg_margin'] : ''); ?>" />'+
			'</label>'+

			'<label class="gt3pg_setting">'+
				'<span><?php _e("Thumbnail Type", "gt3pg"); ?></span>'+
				'<select class="thumbnail-type"'+
					'data-setting="thumb_type"'+
					'<# if ( data.userSettings ) { #>'+
						'data-user-setting="thumb-type"'+
					'<# } #>>'+
          '<option value="default" <# if ( ! wp.media.galleryDefaults.thumb_type || "default" == wp.media.galleryDefaults.thumb_type ) { #>selected="selected"<# } #>>'+
            '<?php esc_attr_e("Default", "gt3pg"); ?>'+
          '</option>'+
					'<option value="square" <# if ( "square" == wp.media.galleryDefaults.thumb_type ) { #>selected="selected"<# } #>>'+
            '<?php esc_attr_e("Square", "gt3pg"); ?>'+
					'</option>'+
          '<option value="rectangle" <# if ( "rectangle" == wp.media.galleryDefaults.thumb_type ) { #>selected="selected"<# } #>>'+
            '<?php esc_attr_e("Rectangle", "gt3pg"); ?>'+
          '</option>'+
          '<option value="circle" <# if ( "circle" == wp.media.galleryDefaults.thumb_type ) { #>selected="selected"<# } #>>'+
            '<?php esc_attr_e("Circle", "gt3pg"); ?>'+
          '</option>'+
          '<option value="masonry" <# if ( "masonry" == wp.media.galleryDefaults.thumb_type ) { #>selected="selected"<# } #>>'+
            '<?php esc_attr_e("Masonry", "gt3pg"); ?>'+
          '</option>'+

				'</select>'+
			'</label>'+

      '<label class="gt3pg_setting">'+
        '<span><?php _e("Corners Type", "gt3pg"); ?></span>'+
        '<select class="corners-type"'+
          'data-setting="corners_type"'+
          '<# if ( data.userSettings ) { #>'+
            'data-user-setting="corners-type"'+
          '<# } #>>'+

          '<option value="default" <# if ( ! wp.media.galleryDefaults.corners_type || "default" == wp.media.galleryDefaults.corners_type ) { #>selected="selected"<# } #>>'+
            '<?php esc_attr_e("Default", "gt3pg"); ?>'+
          '</option>'+
          '<option value="standard" <# if ( "standard" == wp.media.galleryDefaults.corners_type ) { #>selected="selected"<# } #>>'+
            '<?php esc_attr_e("Standard", "gt3pg"); ?>'+
          '</option>'+
          '<option value="rounded" <# if ( "rounded" == wp.media.galleryDefaults.corners_type ) { #>selected="selected"<# } #>>'+
            '<?php esc_attr_e("Rounded", "gt3pg"); ?>'+
          '</option>'+

        '</select>'+
      '</label>'+   

      '<label class="gt3pg_setting">'+
        '<span><?php _e("Image Border", "gt3pg"); ?></span>'+
        '<select class="border-type" data-setting="border_type" name="border_type"'+
          '<# if ( data.userSettings ) { #>'+
            'data-user-setting="border-type"'+
          '<# } #>>'+

          '<option value="default" <# if ( ! wp.media.galleryDefaults.border_type || "default" == wp.media.galleryDefaults.border_type ) { #>selected="selected"<# } #>>'+
            '<?php esc_attr_e("Default", "gt3pg"); ?>'+
          '</option>'+
          '<option value="on" <# if ( "on" == wp.media.galleryDefaults.border_type ) { #>selected="selected"<# } #>>'+
            '<?php esc_attr_e("On", "gt3pg"); ?>'+
          '</option>'+
          '<option value="off" <# if ( "off" == wp.media.galleryDefaults.border_type ) { #>selected="selected"<# } #>>'+
            '<?php esc_attr_e("Off", "gt3pg"); ?>'+
          '</option>'+

        '</select>'+
      '</label>'+  

      '<script>'+
        'jQuery(\'input[name="color_picker"]\').val(jQuery(\'input[name="border_col"]\').val());'+
        'jQuery(\'.gt3pg_settings\').attr("data-post-id", jQuery("#post_ID").val());'+
        'jQuery(\'.media-button-insert\').on("mousedown", function(e){ e.preventDefault();'+
        'if (jQuery("select[name=\'border_type\']").val() == "default") { jQuery(\'input[name="border_size"]\').val(<?php echo $gt3_photo_gallery["gt3pg_border_size"] ?>).trigger("change").trigger("input").trigger("focus").trigger("blur"); jQuery(\'input[name="border_padding"]\').val(<?php echo $gt3_photo_gallery["gt3pg_border_padding"] ?>).trigger("change").trigger("input").trigger("focus").trigger("blur"); jQuery(\'input[name="border_col"]\').val("#<?php echo substr($gt3_photo_gallery["gt3pg_border_col"], 1); ?>").trigger("change").trigger("input").trigger("focus").trigger("blur"); }'+

          'if(jQuery(".rand_order").val() == "rand") jQuery(\'input[name="orderby"]\').prop("checked", "checked").trigger("change").trigger("input").trigger("focus").trigger("blur"); else if(jQuery(".rand_order").val() == "menu_order ID") jQuery(\'input[name="orderby"]\').prop("checked", false).trigger("change").trigger("input").trigger("focus").trigger("blur"); else if (<?php echo (($gt3_photo_gallery["gt3pg_rand_order"] == "checked" || $gt3_photo_gallery["gt3pg_rand_order"] == "on") ? "true" : "false")?>) jQuery(\'input[name="orderby"]\').prop("checked", "checked").trigger("change").trigger("input").trigger("focus").trigger("blur"); else jQuery(\'input[name="orderby"]\').prop("checked", false).trigger("change").trigger("input").trigger("focus").trigger("blur");'+

        'if (jQuery("select[name=\'is_margin\']").val() == "default") { jQuery(\'input[name="margin"]\').val(<?php echo $gt3_photo_gallery["gt3pg_margin"] ?>).trigger("change").trigger("input").trigger("focus").trigger("blur"); }});'+
        'jQuery(\'input[name="gt3_gallery"]\').trigger("change").trigger("input").trigger("focus").trigger("blur");'+
        'jQuery(".gt3pg_setting.random").hide();'+

        'if(jQuery(".border-type").val() == "on") jQuery(".border-setting").show(); else jQuery(".border-setting").hide();'+
        'jQuery(".border-type").on("change", function(){'+
          'if(jQuery(".border-type").val() == "on") jQuery(".gt3pg_setting.border-setting").show(); else jQuery(".gt3pg_setting.border-setting").hide(); });'+
        'if(jQuery(".is_margin").val() == "custom") jQuery(".gt3pg_setting.margin").show(); else jQuery(".gt3pg_setting.margin").hide(); '+
        'jQuery(".is_margin").on("change", function(){'+
          'if(jQuery(".is_margin").val() == "custom") jQuery(".gt3pg_setting.margin").show(); else jQuery(".gt3pg_setting.margin").hide(); });'+
        'jQuery(\'input[name="color_picker"]\').wpColorPicker();'+
        'jQuery(\'.media-button-insert\').on("mouseover", function() {'+
          'if (jQuery(\'input[name="color_picker"]\').val() != "undefined") jQuery(\'input[name="border_col"]\').val(jQuery(\'input[name="color_picker"]\').val()).trigger("change").trigger("input").trigger("focus").trigger("blur");'+

        'if (jQuery(\'select[name="real_columns"]\').val() != "Default" && jQuery(\'select[name="real_columns"]\').val() != jQuery(\'select[name="columns"]\').val()) jQuery(\'select[name="columns"]\').val(jQuery(\'select[name="real_columns"]\').val()).trigger("change").trigger("input").trigger("focus").trigger("blur"); else if (jQuery(\'select[name="real_columns"]\').val() == "Default") jQuery(\'select[name="columns"]\').val("<?php echo ((isset($gt3_photo_gallery['gt3pg_columns'])) ? $gt3_photo_gallery['gt3pg_columns'] : '') ?>").trigger("change").trigger("input").trigger("focus").trigger("blur");'+

        '});'+
      '<\/script>'+

      '<label class="gt3pg_setting border-setting">'+
        '<span><?php _e( "Border Size, px", "gt3pg" ); ?></span>'+
        '<input class="short-input" type="text" name="border_size" data-setting="border_size" value="<?php echo ((isset($gt3_photo_gallery['gt3pg_border_size'])) ? $gt3_photo_gallery['gt3pg_border_size'] : ''); ?>" />'+
      '</label>'+   

      '<label class="gt3pg_setting border-setting">'+
        '<span><?php _e( "Border Padding, px", "gt3pg" ); ?></span>'+
        '<input class="short-input" type="text" name="border_padding" data-setting="border_padding" value="<?php echo ((isset($gt3_photo_gallery['gt3pg_border_padding'])) ? $gt3_photo_gallery['gt3pg_border_padding'] : ''); ?>" />'+
      '</label><div class="clear clearfix"></div>'+

      '<label class="gt3pg_setting border-setting">'+
        '<span><?php _e( "Border Color", "gt3pg" ); ?></span>'+
        '<input type="text" name="color_picker"/>'+
        '<input type="text" class="hidden" name="border_col" data-setting="border_col" value="<?php echo ((isset($gt3_photo_gallery['gt3pg_border_col'])) ? $gt3_photo_gallery['gt3pg_border_col'] : ''); ?>" />'+
      '</label></div>'; 
			
			jQuery('script#tmpl-gallery-settings').text(script_text);
		});
	</script><?php

}

add_action( 'admin_footer', 'gt3pg_add_gallery_template' );

add_action('wp_head','gt3pg_wp_head');
function gt3pg_wp_head() {
  $gt3_photo_gallery = gt3pg_get_option("photo_gallery");

  if (isset($gt3_photo_gallery['gt3pg_text_before_head']))
    echo ((strlen($gt3_photo_gallery['gt3pg_text_before_head'])) ? "<style>" . $gt3_photo_gallery['gt3pg_text_before_head'] . "</style>\n": '');
}