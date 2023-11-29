<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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

if (have_posts()) the_post();	// Needed to get the date from

if (is_day()) $date = get_the_date();
elseif (is_month()) $date = get_the_date('F Y');
elseif (is_year()) $date = get_the_date('Y');
else $date = '-';

include 'starthtml.inc';

echo "<title>", get_bloginfo('name'), " &ndash; ", $date, "</title>\n\n";

include 'head.inc';

echo "</head>\n\n";

echo "<body>\n";
echo "<h1><em>", get_bloginfo('name'). "</em>\n";
echo $date, "</h1>\n\n";

include 'intro.inc';

echo "<div class=\"section\">\n";
echo "<h2>Archive: ", $date, "</h2>\n\n";

rewind_posts();			// Since we called the_post() above...

if (! have_posts()) {

  echo "<p>No posts in this period.</p>\n";

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
