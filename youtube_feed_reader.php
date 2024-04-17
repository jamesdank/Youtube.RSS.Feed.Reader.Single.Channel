<?php
// ID of channel
$id="";

// YouTube RSS feed URL
$rss_url = 'https://www.youtube.com/feeds/videos.xml?channel_id='.$id;

// Function to fetch and parse the RSS feed
function fetchYouTubeRSS($url) {
    // Fetch the RSS feed
    $rss = simplexml_load_file($url);

    // Check if RSS was fetched successfully
    if ($rss) {
        $videos = [];
        // Loop through each item in the feed
        foreach ($rss->entry as $entry) {
            $video['title'] = (string) $entry->title;
            $video['link'] = (string) $entry->link['href'];
            $video['published'] = (string) $entry->published;
            $video['thumbnail'] = (string) $entry->children('media', true)->group->thumbnail[0]->attributes()->url;
            // Add video data to the array
            $videos[] = $video;
        }
        return $videos;
    } else {
        return false;
    }
}

// Fetch YouTube RSS feed
$videos = fetchYouTubeRSS($rss_url);

// Display videos
if ($videos) {
    foreach ($videos as $video) {
        echo '<div>';
        echo '<h2>' . $video['title'] . '</h2>';
        echo '<p>Publish Date: ' . $video['published'] . '</p>';
        echo '<a href="' . $video['link'] . '"><img src="' . $video['thumbnail'] . '" alt="' . $video['title'] . '"></a>';
        echo '</div>';
    }
} else {
    echo 'Error fetching YouTube RSS feed.';
}
?>
