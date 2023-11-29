<?php
/**
 * The template for displaying Search Results pages.
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

// Set the number of posts per page to 50.
// To do: make configurable?
//
query_posts($query_string . '&posts_per_page=50');

$query= get_search_query();

include 'starthtml.inc';

echo "<title>", get_bloginfo('name'), " &ndash; ";
echo "Search: ", $query, "</title>\n\n";

include 'head.inc';

echo "<style type=\"text/css\" title=\"Main\">\n";
echo " #archives ul {columns: 10em}\n";
echo " #archives {color: #333; background: #C1D2E7; border-radius: .5em;\n";
echo "  overflow: auto}\n";
echo " #archives > *:first-child {margin-top: 0}\n";
echo "</style>\n\n";
echo "</head>\n\n";

echo "<body>\n";
echo "<h1><em>", get_bloginfo('name'), "</em> Search results</h1>\n\n";

include 'intro.inc';

echo "<div class=\"section\">\n";
echo "<h2>Search results</h2>\n\n";

if (! have_posts()) {

  echo "<p>No articles contain the keyword";
  if (strpbrk($query, ' ,;')) echo "s";
  echo " “", $query, "”.</p>\n";

} else { 

  echo "<p>The following articles contain the keyword";
  if (strpbrk($query, ' ,;')) echo "s";
  echo " “", $query, "”:</p>\n";

  echo "<ul class=\"dated\">\n";
  while (have_posts()) {
    the_post();
    echo "<li><span class=\"updated\">", get_the_date('Y-m-d'), "</span>\n";
    echo "<a href=\"", get_permalink(), "\">\n";
    echo get_the_title(), "</a></li>\n\n";
  }
  echo "</ul>\n";

  $prev = get_previous_posts_link("\n« Newer articles");
  $next = get_next_posts_link("\nOlder articles »");
  if ($prev || $next) {
    echo "<p class=\"more\">";
    if ($prev) echo $prev, " ";
    if ($next) echo $next;
    echo "</p>\n";
  }
}
echo "</div>\n\n";

echo "<div class=\"section\" id=\"archives\">\n";
echo "<h2>Archives</h2>\n\n";

echo "<p class=\"feed\"><a\n";
echo "href=\"", get_bloginfo('atom_url'), "\"><img\n";
echo "alt=\"(Also available as Atom news feed.)\"\n";
echo "src=\"/Style/CSS/w3c-2010/feed\" title=\"News feed\"></a></p>\n\n";

echo "<form action=\"", home_url('/'), "\">\n\n";

echo "<p><label for=\"s\">Search for:</label>\n";
echo "<input value=\"", $query, "\" name=\"s\" id=\"s\" />\n";
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
