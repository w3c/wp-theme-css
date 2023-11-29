<?php
/**
 * The template for displaying the blog's start page.
 *
 * This template is for the CSS WG blog.
 *
 * To do: escape text where needed (with esc_html()?)
 *
 * Author: Bert Bos <bert@w3.org>
 * Created: 16 September 2011
 *
 * Copyright © 2011 World Wide Web Consortium
 * See http://www.w3.org/Consortium/Legal/2002/copyright-software-20021231
 *
 */

include 'starthtml.inc';

echo "<title>", get_bloginfo('name'), "</title>\n\n";

include 'head.inc';

echo "<link rel=\"pingback\"";
echo " href=\"", get_bloginfo('pingback_url'), "\" />\n";
echo "<link rel=\"alternate\" type=\"application/atom+xml\" title=\"Atom\"\n";
echo " href=\"", get_bloginfo('atom_url'), "\" />\n\n";

echo "<style type=\"text/css\" title=\"Main\">\n";
echo " div.metadata {font-size: smaller; margin-bottom: 0.6em}\n";
echo " #archives ul {columns: 10em}\n";
echo " #archives {color: #333; background: #C1D2E7; border-radius: .5em;\n";
echo "  overflow: auto}\n";
echo " #archives > *:first-child {margin-top: 0}\n";
echo "</style>\n";
echo "</head>\n\n";

echo "<body>\n";
echo "<h1><em>", get_bloginfo('name'), "</em> front page</h1>\n\n";

include 'intro.inc';

if (! have_posts()) {

  echo "<div class=\"section\">\n";
  echo "<h2>No posts</h2>\n\n";
  echo "<p>This blog currently has no articles.</p>\n";
  echo "</div>\n\n";

} else {

  while (have_posts()) {
    the_post();

    echo "<div class=\"section\" id=\"post-", get_the_ID(), "\">\n";
    echo "<h2>", get_the_title(), "</h2>\n\n";

    echo "<div class=\"metadata\">\n";
    echo "<p>By <em class=\"author\">", get_the_author(), "</em>";
    echo " <span class=\"updated\">", get_the_date(), "</span>\n";
    echo "(<a href=\"", get_permalink(), "\">Permalink</a>)<br />\n";
    echo "<span class=\"categories\">Categories:\n";
    echo "<strong>";

    foreach ((get_the_category()) as $category) {
      echo "<a title=\"Browse category\"\n";
      echo "href=\"", get_category_link($category->cat_ID), "\">";
      echo $category->cat_name, "</a> ";
    }
    echo "</strong></span></p>\n";
    echo "</div>\n\n";

    the_content();

    echo "</div>\n\n";
  }
}

echo "<div class=\"section\">\n";
echo "<p class=\"more\">";
if (($h = get_previous_posts_link("\n« Newer articles"))) echo $h, " ";
if (($h = get_next_posts_link("\nOlder articles »"))) echo $h;
echo "</p>\n";
echo "</div>\n\n";

echo "<div class=\"section\" id=\"archives\">\n";
echo "<h2>Archives</h2>\n\n";

echo "<p class=\"feed\"><a\n";
echo "href=\"", get_bloginfo('atom_url'), "\"><img\n";
echo "alt=\"(Also available as Atom news feed.)\"\n";
echo "src=\"/Style/CSS/w3c-2010/feed\" title=\"News feed\" /></a></p>\n\n";

echo "<form action=\"", home_url('/'), "\">\n\n";

echo "<p><label for=\"s\">Search for:</label>\n";
echo "<input value=\"", get_search_query(), "\" name=\"s\" id=\"s\" />\n";
echo "<input type=\"submit\" value=\"Submit\" /></p>\n\n";

echo "</form>\n\n";

echo "<p>Browse by date:</p>\n";
echo "<ul>\n";
wp_get_archives(array('show_post_count' => true));
echo "</ul>\n\n";

echo "<p>Browse by category:</p>\n";
echo "<ul>\n";
foreach ((get_categories()) as $category) {
  echo "<li><a href=\"", get_category_link($category->term_id), "\">\n";
  echo " ", $category->name, "</a> (", $category->count, ")</li>\n";
}
echo "</ul>\n";
echo "</div>\n\n";

include 'banner.en.inc';

echo "<div class=\"section\" id=\"endmatter\">\n";
include 'address.en.inc';
echo "<p>Last updated ", get_lastpostmodified(), "</p>\n";
echo "</div>\n";
echo "</body>\n";
echo "</html>\n";
