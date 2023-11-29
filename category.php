<?php
/**
 * The template for displaying Category Archive pages.
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

// Set the number of posts per page to 50.
// To do: make configurable?
//
query_posts($query_string . '&posts_per_page=50');

$cat = get_category(get_query_var('cat'));

include 'starthtml.inc';

echo "<title>", get_bloginfo('name'), " &ndash; ";
echo "Category: ", $cat->name, "</title>\n\n";

include 'head.inc';

echo "<link rel=\"alternate\" type=\"application/atom+xml\"\n";
echo " title=\"CSS Working Group news (category: ", $cat->name, ")\"\n";
echo " href=\"", get_category_feed_link($cat->cat_ID, 'atom'), "\" />\n";
echo "</head>\n\n";

echo "<body>\n";
echo "<h1><em>",  get_bloginfo('name'), "</em>\n";
echo "Category: ", $cat->name, "</h1>\n\n";

include 'intro.inc';

echo "<div class=\"section\">\n";
echo "<h2>Category: ", $cat->name, "</h2>\n\n";

echo "<p class=\"feed\"><a\n";
echo "href=\"", get_category_feed_link($cat->cat_ID, 'atom'), "\"><img\n";
echo "alt=\"(Also available as Atom news feed.)\"";
echo " src=\"/Style/CSS/w3c-2010/feed\" title=\"News feed\" /></a></p>\n\n";

if ($cat->category_description)
  echo "<p>", $cat->category_description, "</p>\n\n";

if (! have_posts()) {

  echo "<p>No posts with this category.</p>\n";

} else {

  echo "<ul class=\"dated\">\n";
  while (have_posts()) {
    the_post();
    echo "<li><span class=\"updated\">", get_the_date('Y-m-d'), "</span>\n";
    echo "<a href=\"", get_permalink(), "\">\n";
    echo get_the_title(), "</a></li>\n\n";
  }
  echo "</ul>\n";
}

$prev = get_previous_posts_link("\n« Newer articles");
$next = get_next_posts_link("\nOlder articles »");
if ($prev || $next) {
 echo "<p class=\"more\">";
 if ($prev) echo $prev, " ";
 if ($next) echo $next;
 echo "</p>\n";
}

echo "</div>\n\n";

include 'banner.en.inc';

echo "<div class=\"section\" id=\"endmatter\">\n";
include 'address.en.inc';
echo "</div>\n";
echo "</body>\n";
echo "</html>\n";
