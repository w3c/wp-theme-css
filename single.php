<?php
/**
 * The Template for displaying all single posts.
 *
 * This template is for the CSS WG blog.
 *
 * To do: escape text where needed (with esc_html()?)
 *
 * Author: Bert Bos <bert@w3.org>
 * Created: 15 September 2011
 *
 * Copyright © 2011 World Wide Web Consortium
 * See http://www.w3.org/Consortium/Legal/2002/copyright-software-20021231
 *
 */


// Allowed tags in a comment
$allowedtags = array('a' => array(
				  'href' => array(),
				  'title' => array()),
		     'abbr' => array(
				     'title' => array()),
		     'acronym' => array(
					'title' => array()),
		     'b' => array(),
		     'blockquote' => array(
					   'cite' => array()),
		     'cite' => array(),
		     'code' => array(),
		     'del' => array(
				    'datetime' => array()),
		     'em' => array(),
		     'i' => array(),
		     'q' => array(
				  'cite' => array()),
		     'strike' => array(),
		     'strong' => array(),
		     );

if (have_posts()) while (have_posts()) : the_post();

include 'starthtml.inc';

echo "<title>", esc_html(get_bloginfo('name')), " &ndash; ";
echo esc_html(get_the_title()), "</title>\n\n";

include 'head.inc';

if (($h = get_previous_post())) {
  echo "<link rel=\"prev\" title=\"", esc_attr(get_the_title($h->ID)), "\"\n";
  echo " href=\"", esc_attr(get_permalink($h->ID)), "\" />\n";
}
if (($h = get_next_post())) {
  echo "<link rel=\"next\" title=\"", esc_attr(get_the_title($h->ID)), "\"\n";
  echo " href=\"", esc_attr(get_permalink($h->ID)), "\" />\n";
}
echo "<link rel=\"pingback\"";
echo " href=\"", esc_attr(get_bloginfo('pingback_url')), "\" />\n\n";

echo "<style type=\"text/css\">\n";
echo " div.metadata {font-size: smaller; margin-bottom: 0.6em}\n";
echo " #commentform ul {list-style: none; padding-left: 1em}\n";
echo " #commentform span {font-weight: bold}\n";
echo " label {display: block; margin-left: -1em}\n";
echo " input, textarea {max-width: 100%}\n";
echo " #commentform > ul {columns: 10em}\n";
echo "</style>\n";
echo "</head>\n\n";

echo "<body>\n";

// Once 'text-overflow: ellipsis' is in CSS, that will be the better solutuion
$t = get_the_title();
if (mb_strlen($t, 'UTF-8') <= 43) {
  echo "<h1><em>", esc_html(get_bloginfo('name')), "</em>\n";
  echo esc_html($t), "</h1>\n\n";
} else {
  echo "<h1 title=\"", esc_html($t), "\"\n";
  echo "><em>";
  echo esc_html(get_bloginfo('name')), "</em>\n";
  echo esc_html(mb_substr($t, 0, 42, 'UTF-8')), "…</h1>\n\n";
}

include 'intro.inc';

echo "<div class=\"section long\">\n";
echo "<h2>", esc_html(get_the_title()), "</h2>\n\n";

echo "<div class=\"metadata\">\n";
echo "<p>By ";

$author_url = get_the_author_meta('user_url');

if ($author_url) {
  echo "<a href=\"", esc_attr($author_url), "\">";
  echo "<em class=\"author\">", esc_html(get_the_author()), "</em></a>";
} else {
  echo "<em class=\"author\">", esc_html(get_the_author()), "</em>";
}
echo " <span class=\"updated\">", esc_html(get_the_date()), "</span>\n";
echo "(<a href=\"", esc_attr(get_permalink()), "\">Permalink</a>)<br />\n";
echo "<span class=\"categories\">Categories:\n";
echo "<strong>";

foreach ((get_the_category()) as $category) {
  echo "<a title=\"Browse category\"\n";
  echo "href=\"", esc_attr(get_category_link($category->cat_ID)), "\">";
  echo esc_html($category->cat_name), "</a> ";
}

echo "</strong></span></p>\n";
echo "</div>\n\n";

the_content();

echo "<p class=\"more\">\n";

if (($h = get_previous_post())) {
  echo "<a\n";
  echo "title=\"", esc_attr(get_the_title($h->ID)), "\"\n";
  echo "href=\"", esc_attr(get_permalink($h->ID)), "\"\n";
  echo ">« Previous article</a>\n";
}
if (($h = get_next_post())) {
  echo "<a\n";
  echo "title=\"", esc_attr(get_the_title($h->ID)), "\"\n";
  echo "href=\"", esc_attr(get_permalink($h->ID)), "\"\n";
  echo ">Next article »</a>\n";
}

echo "</p>\n";
echo "</div>\n\n";

$order = strtoupper(get_option('comment_order'));
$comments = get_comments(array('order' => $order,
			       'post_id' => get_the_ID()));

if ($comments) {

  // Get max # of comments per page, as set in admin interface
  if (get_option('page_comments'))
    $per_page = get_query_var('comments_per_page');
  else
    $per_page = 0;

  // Set which page we need to display
  if (get_query_var('cpage'))
    $page = intval(get_query_var('cpage'));
  elseif (get_option('default_comments_page') == 'newest')
    $page = get_comment_pages_count($comments, $per_page, false);
  else
    $page = 1;
  if ($page == 0 && $per_page != 0) $page = 1;

  // Only moderated comments?
  $only_moderated = get_option('comment_moderation');

  // Loop over the comments
  $list_started = false;
  $n = 0;
  foreach ($comments as $comment) {
    if (! $only_moderated || $comment->comment_approved == 1) {
      if (! $per_page || (int)($n / $per_page) + 1 == $page) {
	if (! $list_started) {
	  echo "<div class=\"section long\" id=\"comments\">\n";
	  echo "<h2>Comments</h2>\n\n";
	  echo "<ul>\n";
	  $list_started = true;
	}
 	echo "<li ";
	if ($comment->comment_type)
	  echo "class=\"", esc_attr($comment->comment_type), "\" ";
	echo "id=\"comment-", esc_attr($comment->comment_ID), "\">\n";
	if ($comment->comment_author_url) {
	  echo "<a rel=\"nofollow\" href=\"";
	  echo esc_attr($comment->comment_author_url), "\">";
	}
	echo "<span class=\"author\">", esc_html($comment->comment_author);
	echo "</span>";
	if ($comment->comment_author_url) echo "</a>";
	echo "\n";
	echo "<span class=\"date\">", esc_html($comment->comment_date_gmt);
	echo "</span>\n";
	echo wp_rel_nofollow(wp_kses(force_balance_tags($comment->comment_content),
				     $allowedtags));
	echo "\n";
	echo "</li>\n";
      }
      $n++;
    }
  }
  if ($list_started) echo "</ul>\n";

  // Print links to previous/next pages with comments, if any
  if ($per_page && ($page > 1 || (int)($n / $per_page) + 1 != $page)) {

    if (! $list_started) {
      // There were no comments to print so far, so section was not started yet
      echo "<div class=\"section long\" id=\"comments\">\n";
      echo "<h2>Comments</h2>\n\n";
      $list_started = true;
    }

    if (strcmp($order, 'ASC') == 0) {
      $prevtext = '« Older comments';
      $nexttext = 'Newer comments »';
    } else {
      $prevtext = '« Newer comments';
      $nexttext = 'Older comments »';
    }

    echo "\n<p class=\"more\">\n";
    if ($page > 1) {
      echo "<a href=\"", esc_attr(get_permalink($h->ID)), "comment-page-";
      echo $page - 1, "/#comments\">", $prevtext, "</a>\n";
    }
    if ((int)($n / $per_page) + 1 != $page) {
      echo "<a href=\"", esc_attr(get_permalink($h->ID)), "comment-page-";
      echo $page + 1, "/#comments\">", $nexttext, "</a>\n";
    }
    echo "</p>\n";
  }

  if ($list_started) {
    echo "</div>\n\n";
  }
}


// if (have_comments()) {
// 
//   echo "<!--\n";
//   echo "<div class=\"section\" id=\"comments\">\n";
//   echo "<h2>Comments</h2>\n\n";
// 
//   echo "<ul>\n";
// 
//   //while (have_comments()) {
//   //the_comment();		// Defines global $comment
// 
//   //echo "<li>Comment by ";
//   //comment_author();
//   //echo ": ";
//   //comment_text();
//   //echo "</li>\n";
//   //}
// 
// 
//   echo "</ul>\n";
// 
//   if (get_comment_pages_count() > 1 && get_option('page_comments')) {
//     echo "\n<p class=\"more\">";
//     previous_comments_link("\n« Older comments");
//     echo " ";
//     next_comments_link("\nNewer comments »");
//     echo "</p>\n";
//   }
// 
//   echo "</div>\n\n";
//   echo "-->\n\n";
// }


if (comments_open()) {
  echo "<div class=\"section\" id=\"commentform\">\n";
  echo "<h2>Comment form</h2>\n\n";

  echo "<p>You can use this form to send a comment to the author.\n";
  echo "A selection of the comments may be published on this page.\n";
  echo "Comments may be shortened.\n";
  echo "<em>If you don't want your comment to be published,\n";
  echo "please, say so in your message, or\n";
  echo "send it by e-mail instead.</em></p>\n\n";

  echo "<p>Your e-mail address will not be published.\n";
  echo "Required fields are marked <span>*</span></p>\n\n";

  echo "<form action=\"", esc_attr(home_url()), "/wp-comments-post.php\"\n";
  echo "method=\"post\">\n";
  echo "<ul>\n";
  echo "<li><label for=\"author\">Name</label>\n";
  echo "<input id=\"author\" name=\"author\" size=\"30\" />";
  echo "<span>*</span></li>\n\n";

  echo "<li><label for=\"email\">E-mail</label>\n";
  echo "<input id=\"email\" name=\"email\" size=\"30\" />";
  echo "<span>*</span></li>\n\n";

  echo "<li><label for=\"url\">Web site</label>\n";
  echo "<input id=\"url\" name=\"url\" size=\"30\" /></li>\n\n";

  echo "<li><label for=\"comment\">Comment</label>\n";
  echo "<textarea id=\"comment\" name=\"comment\" cols=\"45\" rows=\"8\">";
  echo "</textarea></li>\n\n";

  echo "<li><input type=\"submit\" value=\"Submit\" />\n";
  echo "<input type=\"hidden\" name=\"comment_post_ID\" value=\"";
  echo esc_attr(get_the_ID()), "\" />\n";
  echo "<input type=\"hidden\" name=\"comment_parent\" value=\"0\" />\n";

  wp_nonce_field(-1, 'akismet_comment_nonce', true, true);

  echo "</li>\n";
  echo "</ul>\n";
  echo "</form>\n\n";

  echo "<p>You may use these <abbr title=\"HyperText Markup\n";
  echo "Language\">HTML</abbr> tags and attributes:</p>\n\n";

  echo "<ul>\n";
  echo "<li>&lt;a href=&quot;&quot; title=&quot;&quot;&gt;</li>\n";
  echo "<li>&lt;abbr title=&quot;&quot;&gt;</li>\n";
  echo "<li>&lt;acronym title=&quot;&quot;&gt;</li>\n";
  echo "<li>&lt;b&gt;</li>\n";
  //echo "<li>&lt;blockquote cite=&quot;&quot;&gt;</li>\n";
  echo "<li>&lt;cite&gt;</li>\n";
  echo "<li>&lt;code&gt;</li>\n";
  echo "<li>&lt;del datetime=&quot;&quot;&gt;</li>\n";
  echo "<li>&lt;em&gt;</li>\n";
  echo "<li>&lt;i&gt;</li>\n";
  echo "<li>&lt;q cite=&quot;&quot;&gt;</li>\n";
  echo "<li>&lt;strike&gt;</li>\n";
  echo "<li>&lt;strong&gt;</li>\n";
  echo "</ul>\n\n";

  echo "</div>\n\n";
}

include 'banner.en.inc';

echo "<div class=\"section\" id=\"endmatter\">\n";
include 'address.en.inc';
echo "<p>Last updated ", esc_html($post->post_date), "</p>\n";
echo "</div>\n";
echo "</body>\n";
echo "</html>\n";

endwhile;
